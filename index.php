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
    <script >
    var client = "<?php echo $_SESSION['username']; ?>";
    </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TanksTanksTanks</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
    <script type="text/javascript" src="js/phaser.js"></script>
    <script src="socket.io.js"></script>
    <script type="text/javascript" src="js/game.js"></script>
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
                <li><a href="achievements.php">Achievements</a></li>
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
        <br>
        <p><a class="btn btn-lg btn-success" href="login.php" role="button">Sign In or Register Now to Play!</a></p>
      </div>
      <?php } else {?>

      <div class="row">
        <div class="col-md-7">
          <div id='game'></div>  
        </div>
        <div class="col-md-5">
          <h2>How to play:</h2>
          <h4>Hit your opponent to get 10 points before they do!</h4>
          <h4>The more you play, the better you'll get and the more points you need to win!</h4>
          <h3>Controls:</h3>
          <img src="space.png" width="150px" style="margin-left:auto; margin-right:auto;">
          <img src="keys.png" width="75px" style="margin-left:auto; margin-right:auto;">
          <h4> Use the <strong>space bar</strong> to switch from moving to aiming to firing.</h4>
          <h4><strong>When moving,</strong> Use the Left and Right arrow keys to move</h4>
          <h4><strong>When aiming,</strong> And use Up and Down to move the turret and Left and Right to change power</h4>
        </div>
      </div>

      <?php } ?>


      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->

  </body>
  <script>
    var exists = document.getElementById('game');
    if(exists != null){
      var game = new Phaser.Game(640,480, Phaser.CANVAS, 'game');
      game.state.add("play", PhaserGame, true);
      game.state.add('menu', menu, true);
      game.state.add('gameOver', gameOver, true);
      game.state.start("menu");

      socket.on('connect', function(){
        socket.emit('username', {username: "<?php echo $_SESSION['username']; ?>"});      
      });
      socket.on('startGame', function(data){
        game.state.start("play");
        console.log("The game should have started");
      });
    }

      socket.on('someoneLeft', function(data){
        if (data.playerCount < 2) {
          console.log("Let's get outta here");
          // similar behavior as an HTTP redirect
          window.location.replace("http:///wd2-project3/redirect.php");
        }
      });

      socket.on('gameIsOver', function(data){
        game.state.start('gameOver');
      });

  </script>
</html>
