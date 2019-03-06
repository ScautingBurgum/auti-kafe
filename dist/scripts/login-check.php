<?php
  require_once('dbcon.php');
?>

<html>
<title>Login</title>
<body>
<?php
if(isset($_POST['submit'])) {
  if(isset($_POST['email']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string ($conn,$_POST['email']); 
    $password = mysqli_real_escape_string ($conn,$_POST['password']);
    $query = mysqli_query($conn, "SELECT * FROM kafelogin");
    $result = mysqli_fetch_array($query);
    if($result['email'] == $username && $result['password'] == $password) {
      echo "Success";
      $_SESSION['username'] = $username;
      header("refresh:3;../admin/");
      die();
    } else {
      echo "Verkeerde username / password";
    }
  }else{
    echo "No username or password set!";
  }
} else {
  header('index.php');
}
?>
</body>
</html>