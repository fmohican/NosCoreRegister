<?php

class installer {
  private function self_kill() {
    rename("install.php", "install.lock");
  }

  public function handle($data) {
    $config = '<?php
$title = "'.htmlentities($data->sn, ENT_QUOTES).'";
$dbhost = "'.$data->db_host.'";
$dbuser = "'.$data->db_user.'";
$dbpass = "'.$data->db_pass.'";
$dbname = "'.$data->db_name.'";
$pwtype = "'.$data->pwconfig.'";
$dbport = '.$data->db_port.';
$gpublic = "'.$data->google_public.'";
$gprivate = "'.$data->google_private.'";
$signature_secret = "'.$data->signature_secret.'";
$discord = "'.$data->discord.'";
$web = "'.$data->web.'";
$fb = "'.$data->fb.'";
//Please use secure secret key, you will need it when make request/post to API.
//API POST/REQUEST url is : https://yourdomain.tld/controller.php?action=api&type=[types] (+ other parameters)
//By default API are disabled.
//API are used for external register, via "your own" page. The secret will act as "Private Key", we will use it to verify if request are from "trusted" source.
//DO NOT ENABLE API IF YOU ARE NOT USE IT. ITS FOR YOUR OWN SAFETY.
$API = false;
$API_secret = "";
$ddl = "'.base64_encode(htmlentities($data->ddl, ENT_QUOTES)).'";';
    if(file_exists("config.php") == false) {
      fwrite(fopen("config.php", "x+"), $config);
      $this->self_kill();
      return true;
    }
    else {
      return false;
    }
  }
}
