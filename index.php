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
    <script type="text/javascript" src="chat.js"></script> <!-- for chat javascript file -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <style>
      div.chat_box {
        background: #ccc none repeat scroll 0 0;
        border: 3px solid #666;
        margin-bottom: 5px;
        /*padding: 5px;*/
        position: relative;
        width: 200px;
        height: 100px;
        overflow: auto;
      }
      /*p {
        margin: 10px;
        padding: 5px;
        border: 2px solid #666;
        width: 1000px;
        height: 1000px;
      }*/
  </style>
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
                <?php if($signedIn) { ?> <li><a href="chat.php">Chat</a></li> <?php } ?>
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
        <p><a class="btn btn-lg btn-success" href="login.php" role="button">Sign In or Register Now to Play!</a></p>
      </div>
      <?php } else {

      echo "<div id='game'></div>";
      
       }?>

      <!-- Site footer -->
      <!-- Scroll bar present and enabled -->      

      <h3>Chat</h3>  
      <div class="chat_box" id="chat_box" style="width: 640px; height: 175px; overflow-y: scroll; border: 2px solid black">
          <!-- test<br />
          test<br />
          test<br />
          test<br />
          test<br />
          test<br />
          test<br />
          test<br />
          test<br />
          test<br /> -->
          <label id="status-label" style="color: black">Status</label>
      </div>
      

      <article>        
        <input type="text" id="text-view" placeholder="Type your message" style="width: 580px"/>
        <input type="button" id="send-button" value="Send!" style="width: 57px" />
        <br />
        
      
        <input type="button" id="stop-button" value="Stop" />
      </article>

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
