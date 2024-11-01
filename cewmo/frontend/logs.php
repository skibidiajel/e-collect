<?php  
  session_start();
  include '../backend/connection.php';
  include './functions/dbFunction.php';
  include './functions/fetchFromApi.php';

  // FETCHING LOGS RECORDS
  $logs = getDataLogs($conn);
  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/logs.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60;URL=logs.php">
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
            <li class="nav-item">
              Notifications
            </li>
          </a>
          <a class="nav-link" href="users.php">
            <li class="nav-item">
              Users
            </li>
          </a>
          <a class="nav-link" href="logs.php">
            <li class="nav-item active">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <main>
        <table class="users-data">
          <caption>Logs</caption>
          <tr>
            <th>
              Date 
            </th>
            <th>
              Username
            </th>
            <th>
              Type
            </th>
          </tr>
          <?php
            if($logs != NULL){
              foreach($logs as $data){
                echo "<tr>";
                  echo "<td>". $data['DATE_TIME'] ."</td>";
                  echo "<td>". $data['USERNAME'] ."</td>";
                  echo "<td>". $data['TYPE'] ."</td>";
                echo "</tr>";
              }
            }
          ?>
        </table>
      </main>
    </div>
    <script type="text/javascript" src="./javascript/frontendFunc.js"></script>
  </body>
</html>