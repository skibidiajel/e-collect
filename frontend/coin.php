<?php  
  session_start();
  include '../backend/connection.php';
  include './functions/dbFunction.php';
  include './functions/fetchFromApi.php';

  // FETCHING COIN RECORDS AND TOTAL COINS RECORDS
  $totalCoin = getTotalCoin($conn);
  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/coin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60;URL=coin.php">
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
            <li class="nav-item active">
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
            <li class="nav-item">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <main>
      <table class="users-data">
          <caption>Coin Tracker</caption>
          <tr>
            <th>
              Date 
            </th>
            <th>
              Coin Deducted
            </th>
          </tr>
          <?php
          ?>
          <tr>
            <td colspan="2" style="text-align: right; font-weight: bolder;">TOTAL: 
              <?php 
                if($totalCoin != NULL){
                  echo $totalCoin['TOTAL_COINS'];
                }
              ?>
            </td>
          </tr>
          <tr style="background-color: var(--highlighterColor);">
            <td colspan="3" style="text-align: right;">
              <button onclick="addCoin()" class="add-coin">Add Coins</button>
              <button onclick="clearCoin()" class="add-coin">Clear Coins</button>
            </td>
          </tr>
        </table>
      </main>
    </div>
    <div class="modal" id="modal">
      <div class="modal-container">
        <div class="modal-items" id="add-coin">
          <h1>Add Coin</h1>
          <form action="coin.php" method="POST">
            <div class="input-container">
              <input type="number" name="coin" placeholder="Enter Number of Coins">
            </div>
            <div>
              <button class="confirm" name="confirm">Confirm</button>
              <button onclick='coinAddCancel()' class="cancel">Cancel</button>
            </div>
          </form>
        </div>
        <div class="modal-items" id="clear-coin">
          <h1>Clear Coin</h1>
          <form action="coin.php" method="POST">
            <div>
              <button class="confirm" name="confirm-clear">Confirm</button>
              <button onclick='coinAddCancel()' class="cancel")>Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="./javascript/frontendFunc.js"></script>
  </body>
</html>
<?php
  if(isset($_POST['confirm'])){
    $fetchDataCoin = $_POST['coin'];
    setCoinInDb($fetchDataCoin, $conn);
  }
  if(isset($_POST['confirm-clear'])){
    clearCoin($conn);
  }
?>

<!--
[√] - ADDING OF COINS WHEN THERE IS A NEW COIN PLACED
[√] - NOTIFICATION IF THERE IS ONLY HALF LEFT OF COINS
[] - SUBTRACTING WHEN THERE IS A NEW TRANSACTION (STORE IN coin_deduction table)
-->