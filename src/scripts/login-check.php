<?php
  require_once('dbcon.php');
?>

<html>
<title>Login</title>
<body>
<?php
if(isset($_POST['submit'])) {
  if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string ($conn,$_POST['email']); 
    $password = mysqli_real_escape_string ($conn,$_POST['password']);
    $query = "SELECT email, username, password FROM kafelogin WHERE email = '$email'";
    if($query = mysqli_query($conn, $query)) {
      $result = mysqli_fetch_array($query);
      if($result['email'] == $email && password_verify($password,$result['password'])) {
        $_SESSION['username'] = $result['username'];
        header("Location: /admin/");
        die();
      } else {
        echo "Verkeerde username / password";
      }
    }
  } else{
    echo "No username or password set!";
  }
} else if (isset($_POST['register'])) {
  header("Location: /admin/?action=register");
} else {
  header('index.php');
}
?>
</body>
</html>