<?php
//if(file_exists("config.php"))
//  die("<h1>Install is locked, please delete install.php for security reason. <br/> <strong>OR</strong> delete config.php for new install instance.</h1>");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="static/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="static/core.css"/>
  </head>
  <body class="grey darken-4 white-text">
    <main>
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h1 class="center">Installer</h1>
          </div>
          <div class="col s12 darkbg rounded">
            <form class="col s12" method="post" action="controller.php">
              <input type="hidden" name="action" value="install"/>
              <div class="row">
                <div class="input-field col s12">
                  <input id="sn" type="text" class="validate white-text" name="sn" required>
                  <label for="sn">Server Name</label>
                </div>
              </div>
              <div class="row">
                <h1 class="center">Database Information</h1>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="db_host" type="text" class="validate white-text" name="db_host" required>
                  <label for="db_host">DB Host</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="db_name" type="text" class="validate white-text" name="db_name" required>
                  <label for="db_name">DB Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="db_user" type="text" class="validate white-text" name="db_user" required>
                  <label for="db_user">DB User</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="db_pass" type="text" class="validate white-text" name="db_pass" required>
                  <label for="db_pass">DB Password</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input value="5432" id="db_port" type="number" class="validate white-text" name="db_port" required>
                  <label for="db_port">DB Port</label>
                </div>
              </div>
              <div class="row">
                <h1 class="center">Server Information</h1>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="domain" type="text" class="validate white-text" name="domain">
                  <label for="domain">Page Domain (eg myserver.net, without / or https/http)</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="discord" type="url" class="validate white-text" name="discord">
                  <label for="discord">Discord Link</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="web" type="url" class="validate white-text" name="web">
                  <label for="web">Offical Website</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="fb" type="url" class="validate white-text" name="fb">
                  <label for="fb">Official Facebook</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="google_public" type="text" class="materialize-textarea white-text" name="google_public">
                  <label for="google_public">Google Captcha PUBLIC key</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="google_private" type="text" class="materialize-textarea white-text" name="google_private">
                  <label for="google_private">Google Captcha !! PRIVATE !! key</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="signature_secret" type="text" class="materialize-textarea white-text" name="signature_secret" value="<?php echo bin2hex(openssl_random_pseudo_bytes(64));?>">
                  <label for="signature_secret">Signature secret key (Leave as is, or use your own.)</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="ddl" class="materialize-textarea white-text" name="ddl"></textarea>
                  <label for="ddl">Client Download Links (1 link per line)</label>
                </div>
              </div>
              <div class="row">
                <p>Password encryption method</p>
                <div class="input-field col s12">
                  <p>
                    <label>
                      <input class="with-gap" name="pwconfig" type="radio" value="PBKDF2" disabled/>
                      <span class="grey-text text-darken-1">PBKDF2 (New, most secure, not yet implemented in NosCore)</span>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input class="with-gap" name="pwconfig" type="radio" value="SHA512" checked/>
                      <span>SHA512 (Legacy, not secure)</span>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input class="with-gap" name="pwconfig" type="radio" value="Both"/>
                      <span>Both (For debug propose only)</span>
                    </label>
                  </p>
                </div>
              </div>
              <div class="row center">
                <button class="btn btn-large" type="submit">Make config file</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="static/materialize.min.js"></script>
  </body>
</html>
