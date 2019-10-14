<?php

class installer {
  public function handle($data) {
    $config = '
    <?php
    $title = "'.htmlentities($data->sn, ENT_QUOTES).'";
    $dbhost = "'.$data->db_host.'";
    $dbuser = "'.$data->db_user.'";
    $dbpass = "'.$data->db_pass.'";
    $dbname = "'.$data->db_name.'";
    $dbport = '.$data->db_port.';
    $discord = "'.$data->discord.'";
    $web = "'.$data->web.'";
    $fb = "'.$data->fb.'";
    $ddl = "'.base64_encode(htmlentities($data->ddl, ENT_QUOTES)).'";
    ';
    if(file_exists("config.php") == false) {
      fwrite(fopen("config.php", "x+"), $config);
      return true;
    }
    else {
      return false;
    }
  }
}
