<?php
include("function.php");
$action = $_REQUEST["action"];
switch($action) {
  case "install":
    $val = (object)$_POST;
    $install = new installer();
    $inst = $install->handle($val);
    if($inst == true)
      echo "Insall success fully!";
    else
      echo "Look like you already have config.php";
  break;
  default:
    die("unknown error occoruct");
  break;
}
