<?php

use Medoo\Medoo;

class core {

  protected $db;

  public $ip;

  protected $pwtype;

  public function setup() {
    global $pwtype;
    $this->db_connect();
    $this->ip = $this->self_ip();
    $this->pwtype = $pwtype;
  }

  private function db_connect() {
    global $dbhost, $dbname, $dbpass, $dbport, $dbuser; #
    $this->db = new Medoo([
      'database_type' => 'pgsql',
      'database_name' => $dbname,
      'server' => $dbhost,
      'port' => $dbport,
      'username' => $dbuser,
      'password' => $dbpass
    ]);
  }

  public function check_username_len($data) {
    $len = strlen($data);
    return ($len < 26 and $len > 5 ? true : false);
  }

  public function check_password_len($data) {
    $len = strlen($data);
    return ($len > 5 ? true : false);
  }

  public function anwser($msg, $classes = null) {
    return (strlen($classes) > 1 ? json_encode(["message" => $msg, "classes" => $classes]) : json_encode(["message" => $msg]));
  }

  public function check_password_similarity($pw, $pwc) {
    $pw = hash("sha1", $pw);
    $pwc = hash("sha1", $pwc);
    return ($pw == $pwc ? true : false);
  }

  private function password_sha512($password) {
    return hash("SHA512", $password);
  }

  private function passowrd_pbkdf2($password) {
    $salt = bin2hex(openssl_random_pseudo_bytes(24));
    return (object)[ "hash"=>hash_pbkdf2("SHA512", $password, $salt, 15000, 0), "salt"=>$salt];
  }

  public function sign_gen() {
    global $signature_secret;
    return hash_hmac("sha3-512", hash("SHA256", ip2long($this->self_ip())), $signature_secret);
  }

  public function sign_check($sign) {
    $verifity = $this->sign_gen();
    return ($verifity === $sign ? true : false);
  }

  public function check_username_exist($username) {
    return (!$this->db->has("Account", ["Name" => $username]) ? true : false);
  }

  public function check_mail_exist($mail) {
    return (!$this->db->has("Account", ["Email" => $mail]) ? true : false);
  }

  public function self_ip() {
    //CF IPRanger, we need REAL IP not fake one.
    $cloudflareIPRanges = array(
      '2400:cb00::/32',
      '2606:4700::/32',
      '2803:f800::/32',
      '2405:b500::/32',
      '2405:8100::/32',
      '2a06:98c0::/29',
      '2c0f:f248::/32',
      '204.93.240.0/24',
      '204.93.177.0/24',
      '199.27.128.0/21',
      '173.245.48.0/20',
      '103.21.244.0/22',
      '103.22.200.0/22',
      '103.31.4.0/22',
      '141.101.64.0/18',
      '108.162.192.0/18',
      '190.93.240.0/20',
      '188.114.96.0/20',
      '197.234.240.0/22',
      '198.41.128.0/17',
      '162.158.0.0/15'
    );
    //Ensure we have a IP not an malicious content
    if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]) && filter_var($_SERVER["HTTP_CF_CONNECTING_IP"], FILTER_VALIDATE_IP)) {
      $validCFRequest = false;
      foreach($cloudflareIPRanges as $range){
        if($this->ip_in_range($_SERVER['REMOTE_ADDR'], $range)) {
          $validCFRequest = true;
          break;
        }
      }
      if($validCFRequest)
        return $_SERVER["HTTP_CF_CONNECTING_IP"];
      else
        return $_SERVER['REMOTE_ADDR'];
    }
    else
      return $_SERVER['REMOTE_ADDR'];
  }

  /**
   * @param $ip
   * @param $range
   * @return bool
   */
  private function ip_in_range($ip, $range) {
    if ( strpos( $range, '/' ) == false ) {
      $range .= '/32';
    }
    list( $range, $netmask ) = explode( '/', $range, 2 );
    $range_decimal = ip2long( $range );
    $ip_decimal = ip2long( $ip );
    $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
    $netmask_decimal = ~ $wildcard_decimal;
    return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
  }

  public function makeaccount($user_name, $user_password, $user_email) {
    switch ($this->pwtype) {
      case "SHA512":
        $prepare = [
          "Authority" => 0,
          "Language" => 0,
          "Name" => $user_name,
          "Password" => $this->password_sha512($user_password),
          "Email" => $user_email,
          "RegistrationIp" => $this->ip
        ];
        break;
      case "PBKDF2":
        $password = $this->passowrd_pbkdf2($user_password);
        $prepare = [
          "Authority" => 0,
          "Language" => 0,
          "Name" => $user_name,
          "NewAuthPassword" => $password->hash,
          "NewAuthSalt" => $password->salt,
          "Email" => $user_email,
          "RegistrationIp" => $this->ip
        ];
        break;
      case "Both":
        $password = $this->passowrd_pbkdf2($user_password);
        $prepare = [
          "Authority" => 0,
          "Language" => 0,
          "Name" => $user_name,
          "NewAuthPassword" => $password->hash,
          "Password" => $this->password_sha512($user_password),
          "NewAuthSalt" => $password->salt,
          "Email" => $user_email,
          "RegistrationIp" => $this->ip
        ];
        break;
      default:
        return false;
        break;
    }
    return ($this->db->insert("Account", $prepare)? true : false);
  }
}
