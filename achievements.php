<?php
session_start();
include 'password.php';
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

    <!-- this makes the glyphs work -->
    <!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
    

    
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
                <li><a href="index.php">Lobby <span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="achievements.php">Achievements</a></li>
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

      <h1>Here are your achievements <?php echo "".$_SESSION['username']."" ?></h1> <br>


      <!-- <span class="label label-default" style="font-size: 40px;">Default</span> <br>
      <span class="label label-primary">Primary</span> <br>
      <span class="label label-success">Success</span> <br>
      <span class="label label-info">Info</span> <br>
      <span class="label label-warning">Warning</span> <br>
      <span class="label label-danger">Danger</span> <br> -->

      
      <?php 

      $link = new mysqli(getHost(),getUsername(),getPassword(),"tanks"); /*for local testing only*/
      if ($link->connect_errno) {
        printf("Connect failed: %s\n", $link->connect_error);
        exit();
      }

      $result = $link->query("SELECT a.* FROM achievements a INNER JOIN login l ON l.username = a.user WHERE a.user = '".$$_SESSION['username']."'");

      $something = FALSE;

      for ($row = mysqli_fetch_array($result)) {
        
        if ($row['bool'])
        {
          // echo '<span class="label label-success" style="font-size: 25px;">Default</span> <br> <br>';

          echo '<div class="alert alert-danger" role="alert">';
          echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
          echo $row['objective'];
          echo '</div>';
        }

        else
        {
          // echo '<span class="label label-danger" style="font-size: 25px;">Default</span> <br> <br>'; 

          echo '<div class="alert alert-danger" role="alert">';
          echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
          echo $row['objective'];
          echo '</div>';
        }
      } 
      ?>


      <?php } ?> <!-- END ELSE STATEMENT  -->


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
          window.location.replace("http://104.130.213.145/wd2-project3/redirect.php");
        }
      });

  </script>
</html>
