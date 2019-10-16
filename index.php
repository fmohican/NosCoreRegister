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
    <main>
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h1 class="center"><?php echo $title;?></h1>
          </div>
          <div class="col s12">
            <form class="col s12">
              <input type="hidden" name="action" value="user_new"/>
              <div class="row">
                <div class="input-field col s12">
                  <input id="sn" type="text" class="validate white-text" name="user_name" required>
                  <label for="sn">Server Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_email" type="email" class="validate white-text" name="user_email" required>
                  <label for="user_email"></label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password" type="password" class="validate white-text" name="user_password" required>
                  <label for="user_password">Password</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="user_password_confirm" type="password" class="validate white-text" name="user_password_confirm" required>
                  <label for="user_password_confirm">Confirm Password</label>
                </div>
              </div>
            </div>
          </div>
        </div>
    </main>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="static/materialize.min.js"></script>
    <script type="text/javascript" src="static/jquery.min.js"></script>
    <script type="text/javascript" src="static/underscore.min.js"></script>
    <script type="text/javascript" src="static/core.js"></script>
  </body>
</html>
