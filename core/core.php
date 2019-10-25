<?php

class core {

  public function __construct() {

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
    return hash_pbkdf2("SHA512", $password, openssl_random_pseudo_bytes(24), 15000, 0);
  }

  private function password_both($password) {
    return ["SHA512" => $this->password_sha512($password), "PBKDF2" => $this->passowrd_pbkdf2($password)];
  }

  private function password_crypt($password) {
    global $pwtype;
    try {
      switch ($pwtype) {
        case "SHA512":
          return $this->password_sha512($password);
          break;
        case "PBKDF2":
          return $this->passowrd_pbkdf2($password);
          break;
        case "Both":
          return $this->password_both($password);
          break;
        default:
        break;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function sign_gen() {
    global $signature_secret;
    return hash_hmac("sha3-512", hash("SHA256", ip2long($this->self_ip())), $signature_secret);
  }

  public function sign_check($sign) {
    $verifity = $this->sign_gen();
    return (strcmp($sign, $verifity) ? true : false);
  }

  private function check_username_exist($username) {
    global $dbhost, $dbname, $dbpass, $dbport, $dbuser; #
    $db = new Medoo\Medoo([
    'database_type' => 'pgsql',
    'database_name' => $dbname,
    'server' => $dbhost,
    'port' => $dbport,
    'username' => $dbuser,
    'password' => $dbpass
    ]);
    return ($db->has("Accounts", ["name" => $username]) ? true : false);
  }
  public function self_ip() {
    $cloudflareIPRanges = array(
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
    if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
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
}
