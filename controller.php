<?php
use ReCaptcha\ReCaptcha;
use Waavi\Sanitizer\Sanitizer;
include("function.php");
$action = htmlentities(strip_tags($_REQUEST["action"]), ENT_QUOTES);
switch($action) {
  case "API":
    $type = htmlentities(strip_tags($_REQUEST["type"]), ENT_QUOTES);
    if($API == true) {
      switch ($type) {
        case "register":
          //todo
          break;
        case "login":
          //todo
          break;
        case "check_username":
          //todo
          break;
        case "check_email":
          break;
        default:
          echo json_encode("No types found. :(");
          break;
      }
    } else
      echo json_encode("API are disabled for this server. If you are system operator please enablie it in config");
    break;
  case "user_check":
    $filter = [
      "user_name" => "trim|escape|strip_tags",
      "user_sign" => "escape|strip_tags",
    ];
    $sani = new Sanitizer($_POST, $filter);
    $sani = (object) $sani->sanitize();
    if(@$core->sign_check($sani->user_sign)){
      if($core->check_username_exist($sani->user_name))
        echo $core->anwser("Username (<strong>{$sani->user_name}</strong>) is available!", "green darken-4 white-text rounded center");
      else
        echo $core->anwser("Username already exist in our system.<br/> Please try again!", "red darken-4 rounded center white-text");
    }
    else
      echo $core->anwser("We can't verify integrity of request.", "red darken-4 rounded center white-text");
    break;
  case "user_checkm":
    $filter = [
      "user_email" => "trim|escape|lowercase",
      "user_sign" => "escape|strip_tags",
    ];
    $sani = new Sanitizer($_POST, $filter);
    $sani = (object) $sani->sanitize();
    if(@$core->sign_check($sani->user_sign)){
      if(filter_var($sani->user_email, FILTER_VALIDATE_EMAIL)) {
        if ($core->check_mail_exist($sani->user_email))
          echo $core->anwser("Email is available", "green darken-4 white-text rounded center");
        else
          echo $core->anwser("Email already exist in our system.<br/> Did you forgot password/username?", "red darken-4 rounded center white-text");
      }
      else
        echo $core->anwser("Your email its invalid.");
    }
    else
      echo $core->anwser("We can't verify integrity of request.", "red darken-4 rounded center white-text");
    break;
  case "user_new":
    $recaptcha = new ReCaptcha($gprivate);
    $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($_POST['g-recaptcha-response'], $core->ip);
    if ($resp->isSuccess()) {
      $filter = [
        "user_name" => "trim|escape|strip_tags",
        "user_password" => "trim|escape|strip_tags",
        "user_password_confirm" => "trim|escape|strip_tags",
        "user_sign" => "escape|strip_tags",
        "user_email" => "trim|escape|lowercase"
      ];
      $sani = new Sanitizer($_POST, $filter);
      $sani = $sani->sanitize();
      $sani = (object)$sani;
      if ($core->sign_check($sani->user_sign)) {
        if ($core->check_username_len($sani->user_name)) {
          if (ctype_alnum($sani->user_name)) {
            if ($core->check_password_len($sani->user_password)) {
              if ($core->check_password_similarity($sani->user_password, $sani->user_password_confirm)) {
                if (filter_var($sani->user_email, FILTER_VALIDATE_EMAIL)) {
                  if ($core->check_username_exist($sani->user_name)) {
                    if ($core->check_mail_exist($sani->user_email)) {
                      if ($core->makeaccount($sani->user_name, $sani->user_password, $sani->user_email))
                        echo $core->anwser("You'r account {$sani->user_name} was created! <br/> You can login now!", "green darken-4 white-text rounded");
                      else
                        echo $core->anwser("Something wen't wrong, you'r account hasn't be created.<br>Please contact system operator.", "red darken-4 white-text center rounded");
                    } else
                      echo $core->anwser("Email already exist in our database,<br/> do you forgot password?", "red darken-4 white-text center rounded");
                  } else
                    echo $core->anwser("Username already exist in our database!<br/>Please try again with differit username", "red darken-4 white-text center rounded");
                } else
                  echo $core->anwser("You'r email looks ugly!<br>Please use valid email", "red darken-4 white-text center rounded");
              } else
                echo $core->anwser("Passwords do not match", "red darken-4 white-text center rounded");
            } else
              echo $core->anwser("You'r password its too weak!</br> Password should be atleast 6 character longer", "red darken-4 white-text center rounded");
          } else
            echo $core->anwser("Only alphanumeric characters (english) are allowed.<br/>Please try again.", "red darken-4 white-text center rounded");
        } else
          echo $core->anwser("Username isn't valid, should be between 6 and 25, only alphanumeric (english).<br/>Please try again.", "red darken-4 white-text center rounded");
      } else
        echo $core->anwser("Security pass failed :( did you try to hack us?", "red darken-4 white-text center rounded");
    } else
      echo $core->anwser("You must pass google captcha.<br/> Please try again!", "red darken-4 white-text center rounded");
    break;
  case "install":
    $install = new installer();
    if(!file_exists("config.php"))
      die(($install->handle((object)$_POST) ? "Insall success fully!" : "Look like you already have config.php"));
    else
      die("Look like you already have config.php");
  break;
  default:
    die("unknown error occoruct");
  break;
}
