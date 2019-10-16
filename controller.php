<?php
include("function.php");
$action = $_REQUEST["action"];
switch($action) {
  case "user_new":
    use \Waavi\Sanitizer\Sanitizer;
    $filter = [
      "user_name" => "trim|escape|strip_tags",
      "user_password" => "trim|escape|strip_tags",
      "user_password_confirm" => "trim|escape|strip_tags",
      "user_email" => "trim|escape|lowercase"
    ];
    $sani = (object) new Sanitizer($_POST, $filter);
    if($core->check_username_len($sani->user_name)) {
      if(ctype_alnum($sani->user_name)) {
        if($core->check_password_len($sani->user_password)) {
          if($core->check_password_similarity($sani->user_password, $sani->user_password_confirm)) {
            if(filter_var($sani->user_email, FILTER_VALIDATE_EMAIL)) {
              if($core->check_username_exist($sani->user_name)) {
                if($core->makeaccount($sani->user_name, $sani->user_password, $sani->user_password))
                  echo $core->anwser("You'r account {$sani->user_name} was created! <br/> You can login now!", "green darken-4 white-text");
                else
                  echo $core->anwser("Something wen't wrong, you'r account hasen't be created.<br>Please contact system operator.", "red darken-4 white-text center");
              }
              else
                echo $core->anwser("Username already exist in our database!<br/>Please try again with differit username", "red darken-4 white-text center");
            }
            else
              echo $core->anwser("You'r email looks ugly!<br>Please use valid email", "red darken-4 white-text center");
          }
          else
            echo $core->anwser("Passwords do not match", "red darken-4 white-text center");
        }
        else
          echo $core->anwser("You'r password its too weak!</br> Password should be atleast 6 character longer", "red darken-4 white-text center");
      }
      else
        echo $core->anwser("Only alphanumeric characters (english) are allowed.<br/>Please try again.","red darken-4 white-text center");
    }
    else
      echo $core->anwser("Username isn't valid, should be between 6 and 25, only alphanumeric (english).<br/>Please try again.","red darken-4 white-text center");
  case "install":
    $install = new installer();
    $inst = $install->handle((object)$_POST);
    if($inst == true)
      die("Insall success fully!");
    else
      die("Look like you already have config.php");
  break;
  default:
    die("unknown error occoruct");
  break;
}
