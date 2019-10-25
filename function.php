<?php
include("core/installer.php");
include("core/core.php");
include("vendor/autoload.php");
if(file_exists("config.php")) {
  include_once("config.php");
  $core = new core();
  //We are going to initialise core parameters
  $core->setup();
}
