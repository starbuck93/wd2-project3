<?php
session_start();

$signedIn = false;
if(isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true)
  $signedIn = true;

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Room</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
    <link rel="stylesheet" href="css/chatstyle.css">
  </head>

  <body>

    <div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3>Chat Room</h3>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">TANKS</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Lobby <span class="sr-only">(current)</span></a></li>
                <li><a href="achievements.php">Achievements</a></li>
                <?php if($signedIn) { ?> <li class="active"><a href="#">Chat</a></li> <?php } ?>
                <?php if(!$signedIn) { ?> <li><a href="login.php">Login</a></li> <?php } ?>
                <?php if(!$signedIn) { ?> <li><a href="register.php">Register</a></li> <?php } ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <?php if($signedIn) print("<li><a href=\"logout.php\">Hello, ".$_SESSION['username']." . <span class=\"text-danger\">Click to Logout</span></a></li>"); ?>
              </ul>
            </div>
          </div>
        </nav>
      </div>
      <?php if(!$signedIn) { ?>
      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Tanks</h1>
        <p class="lead">A Multiplayer Tank Battle Game. Invite Your Friends And Play Now!</p>
        <p>
        <p><a class="btn btn-lg btn-success" href="login.php" role="button">Sign In or Register Now!</a></p>
      </div>
      <?php } else { ?>

      <iframe src="http://wd2.starbuckstech.com:3000/" width="100%" height="480" scrolling="no" class="iframe-class" frameborder="0">Whoops, Adam needs to start the chat server and/or figure out how to make it work</iframe>


      <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="/socket.io/socket.io.js"></script>
      <script src="js/main.js"></script>


      <?php }?>
      <!-- Site footer -->
      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
