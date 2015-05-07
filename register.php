 <?php
session_start(); // Starting Session stolen from http://www.formget.com/login-form-in-php/
include 'password.php';
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {

    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    // Establishing Connection with Server by passing server_name, user_id and password as a parameter
    $link = new mysqli(getHost(),getUsername(),getPassword(),"tanks"); /*for local testing only*/
    if ($link->connect_errno) {
      printf("Connect failed: %s\n", $link->connect_error);
      exit();
    }
    // To protect MySQL injection for Security purpose
    $name = mysqli_real_escape_string($link,stripslashes($name));
    $email = mysqli_real_escape_string($link,stripslashes($email));
    $username = mysqli_real_escape_string($link,stripslashes($username));
    $password = mysqli_real_escape_string($link,stripslashes($password));
    $password = md5($password);
    // SQL query to fetch information of registerd users and finds user match.
    $query = "INSERT INTO `login`(`name`, `username`, `email`, `password`) VALUES ('".$name."','".$username."','".$email."','".$password."');
              ";
    
    $result = $link->query($query);
    if(!$result) {
      $error = $link->error;
      die();
    } else {
      $_SESSION['name'] = $name;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['signedIn'] = true;
      mysqli_close($link);
      // echo "It worked!";
      header('Location: index.php');
    }
}

/*INSERT INTO 'achievements' ('user', 'objective', 'done') VALUES 
                ('".$username."', 'Playing Your First Game!', 'false'),
                ('".$username."', 'Played 100 games!', 'false'),
                ('".$username."', 'Shot 500 times!', 'false'),
                ('".$username."', 'Played 200 games!', 'false'),
                ('".$username."', 'Destroyed 100 enemy tanks!', 'false'),
                ('".$username."', 'Shot 1000 times!', 'false'),
                ('".$username."', 'Destroyed 500 enemey tanks!', 'false'),
                ('".$username."', 'Shot once!', 'false'),
                ('".$username."', 'Drive 100 miles!', 'false'),
                ('".$username."', 'Drive 500 miles!', 'false'),
              ;
*/
?>


<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         
        <meta charset="utf-8">
        <title>TanksTanksTanks Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->



        <!-- CSS code from Bootply.com editor -->
        
        <style type="text/css">
            .modal-footer {   border-top: 0px; }
        </style>
    <style type="text/css"></style></head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body>
        
        <!--login modal-->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">Register</h1>
          <h3 class="text-center"><a href="login.php">Already have an account?</a></h3>
      </div>
      <div class="modal-body">
          <form class="form col-md-12 center-block" action="register.php" method="POST">
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Full Name" name="name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Email" name="email">
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Username" name="username">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" placeholder="Password" name="password">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" placeholder="Repeat Password" name="password2">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block" name="submit" value="submit">Sign In</button>
              <span class="pull-right"><a href="register.php">Register</a></span><span><a href="#">Need help?</a></span>
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <a href="index.php" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</a>
      </div>  
      </div>
  </div>
  </div>
</div>

        <script type="text/javascript" src="css/bootstrap.min.js"></script>






        
        <!-- JavaScript jQuery code from Bootply.com editor  -->
        
        <script type="text/javascript">
        $(document).ready(function() {
        });
        </script>
        
       
    
</body></html>