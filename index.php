<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - Log in</title>
    <link rel="icon" type="image/x-icon" href="./pictures/cewmo logo.png">
    <link rel="stylesheet" href="./frontend/CSS/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <form class="container" action="index.php" method="POST">
      <h1>CEWMO LOGIN</h1>
      <input type="text" class="username" name="username" autocomplete="on" placeholder="Username" autofocus>
      <input type="password" name="password" autocomplete="off" placeholder="Password">
      <span class="invalid-creds-prompt show-error">The username or password you have entered is incorrect</span>
      <button name="login">Login</button>
    </form>
    <script type="text/javascript" src="./frontend/javascript/frontendFunc.js"></script>
  </body>
</html>

<?php
  include './backend/connection.php';
  include './frontend/functions/dbFunction.php';
  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username != NULL || $password != NULL){
      $flag = loginCreds($conn, $username, $password);
    }else{
      //die();
      $flag = false;
    }
    
    if($flag){
      session_start();
      $_SESSION['usern'] = $username;
      http_response_code(301);
      header('Location: ./frontend/dashboard.php');
    }else{
      echo "<script type='text/javascript'>unmatchedCreds();</script>";
    }
  }
?>

<!--
[√] - INPUT BOX FOR USERNAME N PASSWORD
[√] - SHOULD GO TO DASHBOARD WHEN THE LOGIN CREDENTIALS ARE CORRECT
[√] - PROMPT IF THE CREDENTIALS ARE WRONG (UI)
[] - SHOULD HAVE A PROMPT IF THERE IS NO INPUTTED CREDS
-->