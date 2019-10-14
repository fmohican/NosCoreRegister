<?php
include("function.php");
$action = $_REQUEST["action"];
switch($action) {
  case "install":
    $val = (object)$_POST;

  break;
  default:
    die("unknown error occoruct");
  break;
}
