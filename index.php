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
    <title>TanksTanksTanks</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
    <script type="text/javascript" src="js/phaser.js"></script>
    <script type="text/javascript" src="js/game.js"></script>
   
  </head>

  <body>

    <div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3>wd2-project3</h3>
        <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TANKSSSS</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Lobby <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Rankings</a></li>
        <?php if($signedIn) { ?> <li><a href="#">Chat</a></li> <?php } ?>
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
        <h1>TanksTanksTanks</h1>
        <p class="lead">Tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks tanks</p>
        <p>
        <p><a class="btn btn-lg btn-success" href="login.php" role="button">Sign In or Register Now!</a></p>
      </div>
      <?php } else {

      echo "<div id='game'></div>";

       }?>
      <!-- Site footer -->
      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->

  </body>
  <script>
    var exists = document.getElementById('game');
    if(exists != null){
      var game = new Phaser.Game(640,480, Phaser.CANVAS, 'game');
      game.state.add("Game", PhaserGame, true);
      game.state.start("Game");
    }

  </script>
</html>
