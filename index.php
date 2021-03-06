<?php
include("function.php");
if(!file_exists("config.php"))
  header("Location: install.php");

?>
<!DOCTYPE HTML/>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="static/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="static/core.css"/>
  </head>
  <body class="grey darken-4 white-text">
    <header>
      <div class="loadingtop" id="loading">
        <div class="progress">
          <div class="indeterminate"></div>
        </div>
      </div>
      <div class="container row">
        <div class="col s12">
          <h1 class="center"><?php echo $title;?></h1>
        </div>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="row darkbg">
          <div class="col s12">
            <form class="col s12" id="register">
              <input type="hidden" name="action" value="user_new"/>
              <input type="hidden" name="user_sign" value="<?php echo $core->sign_gen();?>"/>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_name" type="text" class="validate white-text" name="user_name" required>
                  <label for="user_name">Username</label>
                  <span class="helper-text white-text text-darken-1">Username should be between 5 and 25 alphanumeric characters (latin only)</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_email" type="email" class="validate white-text" name="user_email" required>
                  <label for="user_email">Email</label>
                  <span class="helper-text white-text text-darken-1">Please enter you'r real and functional email address, it will helps when password or username are forgotten</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password" type="password" class="validate white-text" name="user_password" required>
                  <label for="user_password">Password</label>
                  <span class="helper-text white-text text-darken-1">Password should be longer then 6 characters and complex. Don't be kid! Do <b>not</b> use simple password.</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password_confirm" type="password" class="validate white-text" name="user_password_confirm" required>
                  <label for="user_password_confirm">Confirm Password</label>
                  <span class="helper-text white-text text-darken-1"></span>
                </div>
              </div>
              <div class="row">
                <div class="g-recaptcha center"></div>
              </div>
              <div class="row">
                <div class="col s6 center-align">
                  <a class="btn waves-effect waves-light btn-large red darken-4 modal-trigger" href="#download"><i class="material-icons left">cloud_download</i> Donwload Client</a>
                </div>
                <div class="col s6 center-align">
                  <button id="send" type="submit" class="btn waves-effect waves-light btn-large green darken-4"><i class="material-icons left">account_box</i> Register me</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col s12">
            <p class="tooltipped center" data-position="top" data-tooltip="This page it's a fork of <a class='teal-text text-lighting-2' href='https://github.com/fmohican/noscoreregister'>github.com/Fmohican/NosCoreRegister</a>, licensed under WTFPL.">&copy; <?php echo $title;?> All Right Reserved.</p>
          </div>
        </div>
      </div>
      <div id="download" class="modal bottom-sheet">
        <div class="modal-content grey darken-4">
          <h2 class="center"><?php echo $title;?> Client Download</h2>
          <p>A bunch of text</p>
        </div>
      </div>
    </footer>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="static/materialize.min.js"></script>
    <script type="text/javascript" src="static/jquery.min.js"></script>
    <script type="text/javascript" src="static/underscore.min.js"></script>
    <script type="text/javascript" src="static/password.score.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en&onload=onloadCallback&render=explicit"></script>
    <script type="text/javascript" src="static/core.js"></script>
    <script type="text/javascript" defer>
      var onloadCallback = function() {
          var captchaContainer = document.querySelector('.g-recaptcha');
          grecaptcha.render(captchaContainer, {
              'sitekey' : '<?php echo $gpublic; ?>'
          });
          $("#send").prop("disabled", false);
      };
</script>
  </body>
</html>
