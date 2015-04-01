<?php
session_start(); // Starting Session stolen from http://www.formget.com/login-form-in-php/
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Username or Password is invalid";
}
else
  {
    $email=$_POST['email'];
    $password=$_POST['password'];
    // Establishing Connection with Server by passing server_name, user_id and password as a parameter
    $link = mysqli_connect("localhost", "root", "");
    // To protect MySQL injection for Security purpose
    $email = mysqli_real_escape_string($link,stripslashes($email));
    $password = mysqli_real_escape_string($link,stripslashes($password));
    $password = md5($password);
    // Selecting Database
    $db = mysqli_select_db("tanks", $link);
    // SQL query to fetch information of registerd users and finds user match.
    $query = mysqli_query($link, "SELECT * from login where password='$password' AND email='$email'");
    $rows = $query->num_rows;
    if ($rows == 1) {
      $_SESSION['name'] = $name;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['signedIn'] = true;
      header("location: profile.php"); // Redirecting To Other Page
    } else {
      $error = "Username or Password is invalid";
    }
    mysqli_close($link); // Closing Connection
  }
}


?>


<!DOCTYPE html>
<!-- saved from url=(0036)http://www.bootply.com/render/101498 -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         
        <meta charset="utf-8">
        <title>TanksTanksTanks Login</title>
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
          <h1 class="text-center">Login</h1>
          <h3 class="text-center"><a href="register.php">Need an account?</a></h3>
      </div>
      <div class="modal-body">
          <form class="form col-md-12 center-block" action="login.php" method="POST">
            <div class="form-group">
              <input type="text" class="form-control input-lg" placeholder="Email" name="email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" placeholder="Password" name="password">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block">Sign In</button>
              <span class="pull-right"><a href="register.php">Register</a></span><span><a href="#">Need help?</a></span>
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <a href="index2.php" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</a>
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