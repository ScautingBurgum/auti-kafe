<?php
$conn = mysqli_connect("localhost","root","","kafelogin");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  //require_once 'markdown/src/bootstrap.php';
  //use \MarkdownExtended\MarkdownExtended;  
  session_start();

?>
 <head>
<link rel="stylesheet" type="text/css" href="style.css">
</head> 