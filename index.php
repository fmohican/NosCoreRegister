<?php
include("function.php");
?>
<!DOCTYPE HTML/>
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
        <div class="row">
          <div class="col s12">
            <form class="col s12">
              <input type="hidden" name="action" value="user_new"/>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_name" type="text" class="validate white-text" name="user_name" required>
                  <label for="user_name">Username</label>
                  <span class="helper-text white-text text-darken-1" data-error="wrong" data-success="right">Username should be between 5 and 25 alphanumeric characters (latin only)</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_email" type="email" class="validate white-text" name="user_email" required>
                  <label for="user_email">Email</label>
                  <span class="helper-text white-text text-darken-1" data-error="wrong" data-success="right">Please enter you'r real and functional email address, it will helps when password or username are forgotten</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password" type="password" class="validate white-text" name="user_password" required>
                  <label for="user_password">Password</label>
                  <span class="helper-text white-text text-darken-1" data-error="wrong" data-success="right">Password should be longer then 6 characters and complex. Don't be kid! Do <b>not</b> use simple password.</span>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password_confirm" type="password" class="validate white-text" name="user_password_confirm" required>
                  <label for="user_password_confirm">Confirm Password</label>
                  <span class="helper-text white-text text-darken-1" data-error="wrong" data-success="right"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </main>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col s12">
            <p>This project its a forked by <?php echo $title;?> from <a href="https://github.com/fmohican/noscoreregister">Fmohican/NosCoreRegister</a> under WTFPL</p>
          </div>
        </div>
      </div>
    </footer>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="static/materialize.min.js"></script>
    <script type="text/javascript" src="static/jquery.min.js"></script>
    <script type="text/javascript" src="static/underscore.min.js"></script>
    <script type="text/javascript" src="static/core.js"></script>
  </body>
</html>
