<?php
$conn = mysqli_connect("localhost","root","","kafelogin");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $showone = "SELECT showone FROM kafelogin";
  if($showone = mysqli_query($conn, $showone)) {
		$showone2 = mysqli_fetch_assoc($showone);
		$showone = $showone2['showone'];
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
  //require_once 'markdown/src/bootstrap.php';
  //use \MarkdownExtended\MarkdownExtended;  
  session_start();

?>
 <head>
<link rel="stylesheet" type="text/css" href="style.css">
</head> 