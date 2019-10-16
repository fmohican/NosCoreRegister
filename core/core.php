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
}
