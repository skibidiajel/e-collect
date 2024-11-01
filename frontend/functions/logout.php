<?php 
  include '../../backend/connection.php';

  session_start();

  $username = $_SESSION['usern'];

  $insertLogs = "INSERT INTO logs VALUES('', now(), '$username' , 'USERS - Logged Out');";
  $conn->query($insertLogs);

  session_unset();
  session_destroy();
  header('Location: ../../index.php');
?>