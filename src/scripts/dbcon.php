<?php
$conn = mysqli_connect("localhost","autikafe_nl_kafelogin","E6fWq7xLqdHX","autikafe_nl_kafelogin");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  //require_once 'markdown/src/bootstrap.php';
  //use \MarkdownExtended\MarkdownExtended;
  session_start();

?>
