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

}
