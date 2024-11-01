<?php  
  session_start();
  include '../backend/connection.php';
  include './functions/dbFunction.php';
  include './functions/fetchFromApi.php';

  // FETCHING NOTIFICATION RECORDS
  $notifications = getDataNotif($conn);
  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/notification.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60;URL=notification.php">
  </head>
  <body>
    <header>
      <div class="ham-menu" onclick="hamMenuActive()">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="icon-name head-container">
        <img src="../pictures/cewmo logo.png" alt="CEWMO Logo">
        <h1 class="header-title">CEWMO E-COLLECT</h1>
      </div>
      <div class="login-logout head-container">
        <div class="head-container">
          <img src="../pictures/login icon.png" alt="Login Icon">
          <h4><?= $_SESSION['usern']; ?></h4>
        </div>
        <div class="logout-hover head-container" onclick="logout()">
          <img src="../pictures/logout icon.png" alt="Logout Icon">
          <h4>Logout</h4>
        </div>
      </div>
    </header>
    <div class="nav-main-container">
      <nav class="navigation-list">
        <ul class="nav-list">
          <a class="nav-link" href="dashboard.php">
            <li class="nav-item">
              Dashboard
            </li>
          </a>
          <a class="nav-link" href="transactions.php">
            <li class="nav-item">
              Transaction Records
            </li>
          </a>
          <a class="nav-link" href="coin.php">
            <li class="nav-item">
              Coin Records
            </li>
          </a>
          <a class="nav-link" href="notification.php">
            <li class="nav-item active">
              Notifications
            </li>
          </a>
          <a class="nav-link" href="users.php">
            <li class="nav-item">
              Users
            </li>
          </a>
          <a class="nav-link" href="logs.php">
            <li class="nav-item">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <main>
        <table>
          <caption>Notifications</caption>
          <tr>
            <th>
              Date and Time
            </th>
            <th>
              Notification Message
            </th>
            <th>
              Status
            </th>
          </tr>
          <?php
            if($notifications != NULL){
              foreach($notifications as $data){
                echo "<tr>";
                  echo "<td>". $data['DATE_TIME'] ."</td>";
                  echo "<td>". $data['NOTIF_MESSAGE'] ."</td>";
                  echo "<td>". $data['STATUS'] ."</td>";
                echo "</tr>";
              }
            }else{
              echo "<tr>";
                echo "<td colspan='3' style='text-align: center;'> No Notification </td>";
              echo "</tr>";
            }
          ?>
        </table>
      </main>
    </div>
    <script type="text/javascript" src="./javascript/frontendFunc.js"></script>
  </body>
</html>

<!--
[] - PUT ICON BESIDE THE NAVIGATION TXT
[√] - LINK ALL NAVIGATION TABS
[√] - FETCH DATA FROM DB AND DISPLAY IT
-->