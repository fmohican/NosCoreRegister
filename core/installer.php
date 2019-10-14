<?php

class installer {
  private function htaccess() {
    $ht = '
      <ifModule mod_gzip.c>
      mod_gzip_on Yes
      mod_gzip_dechunk Yes
      mod_gzip_item_include file .(html?|txt|css|js|php|pl)$
      mod_gzip_item_include handler ^cgi-script$
      mod_gzip_item_include mime ^text/.*
      mod_gzip_item_include mime ^application/x-javascript.*
      mod_gzip_item_exclude mime ^image/.*
      mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
      </ifModule>

      # BEGIN Expire headers
      <ifModule mod_expires.c>
        ExpiresActive On
        ExpiresDefault "access plus 50 seconds"
        ExpiresByType image/x-icon "access plus 2592000 seconds"
        ExpiresByType image/jpeg "access plus 2592000 seconds"
        ExpiresByType image/png "access plus 2592000 seconds"
        ExpiresByType image/gif "access plus 2592000 seconds"
        ExpiresByType application/x-shockwave-flash "access plus 2592000 seconds"
        ExpiresByType text/css "access plus 604800 seconds"
        ExpiresByType text/javascript "access plus 216000 seconds"
        ExpiresByType application/javascript "access plus 216000 seconds"
        ExpiresByType application/x-javascript "access plus 216000 seconds"
        ExpiresByType text/html "access plus 600 seconds"
        ExpiresByType application/xhtml+xml "access plus 600 seconds"
      </ifModule>
      # END Expire headers

      Options All -Indexes

      <IfModule mod_rewrite.c>
      # deny access to evil robots site rippers offline browsers and other nasty scum
      RewriteEngine On
      RewriteBase /
      RewriteCond %{HTTP_USER_AGENT} ^Anarchie [OR]
      RewriteCond %{HTTP_USER_AGENT} ^ASPSeek [OR]
      RewriteCond %{HTTP_USER_AGENT} ^attach [OR]
      RewriteCond %{HTTP_USER_AGENT} ^autoemailspider [OR]
      RewriteCond %{HTTP_USER_AGENT} ^Xaldon\ WebSpider [OR]
      RewriteCond %{HTTP_USER_AGENT} ^Xenu [OR]
      RewriteCond %{HTTP_USER_AGENT} ^Zeus.*Webster [OR]
      RewriteCond %{HTTP_USER_AGENT} ^Zeus
      RewriteRule ^.* - [F,L]
      </IfModule>

      # BEGIN Cache-Control Headers
      <ifModule mod_headers.c>
        <filesMatch "\.(ico|jpe?g|png|gif|swf)$">
          Header set Cache-Control "public"
        </filesMatch>
        <filesMatch "\.(css)$">
          Header set Cache-Control "public"
        </filesMatch>
        <filesMatch "\.(js)$">
          Header set Cache-Control "private"
        </filesMatch>
        <filesMatch "\.(x?html?|php)$">
          Header set Cache-Control "private, must-revalidate"
        </filesMatch>
      </ifModule>
      # END Cache-Control Headers
      ';
      fwrite("htaccess.txt", $ht);
  }
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
      fwrite("config.php", $config);
      $this->htaccess();
      $this->nginx();
      return true;
    }
    else {
      return false;
    }
  }
}
