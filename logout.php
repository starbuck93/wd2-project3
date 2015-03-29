<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: index2.php"); // Redirecting To Home Page
}
?>