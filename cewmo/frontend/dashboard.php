<?php  
  session_start(); 

  include '../backend/connection.php';
  include './functions/fetchFromApi.php';
  include './functions/dbFunction.php';
  include './functions/dateFunction.php';

  // FETCHING TRANSACTION RECORDS
  $transactions = fetchDataTransac($conn);
  // GETTING ONLY THE YEAR OF THE TRANSACTIONS
  $transacFormattedDateYear = [];
  foreach($transactions as $ctr){
    $transacFormattedDateYear[] = getYear(new \Datetime($ctr['DATE']));
  }
  // GETING ONLY THE MONTH AND YEAR OF THE TRANSACTIONS
  $transacFormattedDateMonth = [];
  foreach($transactions as $ctr){
    $transacFormattedDateMonth[] = getMonthYear(new \Datetime($ctr['DATE']));
  }
  // GETTING ONLY THE DAY OF THE TRANSACTON
  $transacFormattedDateDaily = [];
  foreach($transactions as $ctr){
    $transacFormattedDateDaily[] = getDay(new \Datetime($ctr['DATE']));
  }

  // CHECKING IF THE COINS IS IN CRITICAL LEVEL
  $totalCoin = getTotalCoin($conn);
  if($totalCoin['TOTAL_COINS'] > 100 && $totalCoin['TOTAL_COINS'] <= 500){
    $flagCoin = "IMMEDIATE";
    $insertNotif = "INSERT INTO notifications VALUE('', now(), 'Coin balance: &#8369;500.', 'MILD');";
    $conn->query($insertNotif);
  }
  if($totalCoin['TOTAL_COINS'] <= 100){
    $flagCoin = "GOOD";
    $insertNotif = "INSERT INTO notifications VALUE('', now(), 'Coin balance: &#8369;100. Please Refill.', 'IMMEDIATE');";
    $conn->query($insertNotif);
  }

  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60;URL=dashboard.php">
  </head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      /* YEARLY TRANSACTION CHART */
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(yearDrawChart);

      function yearDrawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Number of Transaction'],
          <?php
            // GETTING THE CURRENT YEAR
            $yearlyData = [[2024, 0]];
            $yearDate = new Datetime();
            $currentYear = getYear($yearDate);

            // SAVING THE DATA FECTHED TO THE ARRAY
            $arraySize = sizeof($yearlyData);
            if($currentYear > $yearlyData[$arraySize-1][0]){
              // SAVING YEAR IN THE ARRAY
              $yearlyData[$arraySize][0] = $currentYear;
            }
            // UPDATING ARRAY SIZE
            $arraySize = sizeof($yearlyData);
            if($currentYear == $yearlyData[$arraySize-1][0]){
              // SAVING NUMBER OF TRANSACTION
              if($transacFormattedDateYear != NULL){
                $yearlyData[$arraySize-1][1] = getTransacYear($transacFormattedDateYear, $currentYear);
              }else{
                $yearlyData[$arraySize-1][1] = 0;
              }
            }
            // PRITING DATA FOR THE GRAPH
            for($row=0;$row<sizeof($yearlyData);$row++){
          ?>
          ['<?= $yearlyData[$row][0] ?>', <?= $yearlyData[$row][1]?>],
          <?php
            }
          ?>
        ]);

        var options = {
          title: 'Yearly Bottle & Tin can Transaction',
          colors: ['green'],
          legend: { position: 'bottom'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('yearly-chart'));

        chart.draw(data, options);
      }
      /* MONTHLY TRANSACTION CHART */
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(monthlyDrawChart);

      function monthlyDrawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php
            // GETTING THE CURRENT MONTH
            $months = [1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec'];
            $monthlyData = [];
            $monthDate = new Datetime();
            $currentMonth = getMonthYear($monthDate);
            // INITIALIZING ARRAY FOR MONTH AND MONTLY DATA
            for($ctr=0;$ctr<($monthDate->format("n"));$ctr++){
              $monthlyData[$ctr] = 0;
            }
            // PRINTING DATA TO GRAPH
            for($month=1;$month<=($monthDate->format("n"));$month++){
              $fetchedData = getTransacMonth($transacFormattedDateMonth,$month, $currentYear);
              $monthlyData[$month-1] = $fetchedData;
            }
          ?>
          ['Month', 'Number of Transaction'],
          <?php
            for($ctr=0;$ctr<sizeof($monthlyData);$ctr++){
          ?>
          ['<?= $months[$ctr+1] ?>', <?= $monthlyData[$ctr] ?>],
          <?php
            }
          ?>
        ]);

        var options = {
          title: 'Monthly Bottle & Tin can Transaction (<?= $currentYear; ?>)',
          colors: ['green'],
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('monthly-chart'));

        chart.draw(data, options);
      }
      /* DAILY TRANSACTION CHART */
      /* 
      USEFUL LINKS FOR DAILY
      https://www.w3schools.com/php/func_date_date_format.asp
      https://stackoverflow.com/questions/32615861/get-week-number-in-month-from-date-in-php
      */
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(dailyDrawChart);

      function dailyDrawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php
            $dailyData = [];
            $dailyDate = new Datetime();
            $currentDate = getDay($dailyDate);
            if($transacFormattedDateDaily != NULL){
              $fetchData = getTransacDaily($transacFormattedDateDaily, $currentDate);
              $dailyData[0][0] = $dailyDate->format("l");
              $dailyData[0][1] = $fetchData;
            }
          ?>
          ['Now', 'Number of Transaction'],
          <?php
            echo "['".$dailyData[0][0]."', ". $dailyData[0][1] ."]";
          ?>
        ]);

        var options = {
          title: 'Daily Bottle & Tin can Transaction',
          colors: ['green'],
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('daily-chart'));

        chart.draw(data, options);
      }
    </script>
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
            <li class="nav-item active">
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
            <li class="nav-item">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <?php
        /* CODE FOR NOTIFICATION N NEW TRANSACTION */
        $notifDatas = getDataNotifLimit($conn);
        $transacDatas = fetchDataTransacSortedLimit($conn);
      ?>
      <main>
        <div class="graph-content-container">
         <h1>Transaction</h1>
         <div class="graph-items">
          <a href="#"><div id="yearly-chart"></div></a>
          <a href="#"><div id="monthly-chart"></div></a>
          <a href="#"><div id="daily-chart"></div></a>
         </div>
        </div>
        <div class="notif-transac-container">
          <div class="notif-items">
            <h1>Notification</h1>
            <div class="incoming-notif">
              <?php 
                if($notifDatas != NULL){
                  for($row=0;$row<sizeof($notifDatas);$row++){
                    switch ($notifDatas[$row]['STATUS']) {
                      case "GOOD":
                        echo "<a href='notification.php'>". $notifDatas[$row]['DATE_TIME']." - ". $notifDatas[$row]['NOTIF_MESSAGE'] ."</a>";
                        break;
                      case "MILD":
                        echo "<a href='notification.php' class='mild'>". $notifDatas[$row]['DATE_TIME']." - ". $notifDatas[$row]['NOTIF_MESSAGE'] ."</a>";
                        break;
                      case "IMMEDIATE":
                        echo "<a href='notification.php' class='immediate'>". $notifDatas[$row]['DATE_TIME']." - ". $notifDatas[$row]['NOTIF_MESSAGE'] ."</a>";
                        break;
                    }
                  }
                }else{
                  echo "<a href='dashboard.php'>No new notification</a>";
                }
              ?>
            </div>
          </div>
          <div class="transac-items">
            <h1>New Transaction</h1>
            <div class="incoming-transac">
              <table>
                <tr>
                  <th>DATE</th>
                  <th>PLASTIC 2L</th>
                  <th>PLASTIC 250mL</th>
                  <th>TIN CANS 2L</th>
                  <th>TIN CANS 250mL</th>
                  <th>TOTAL</th>
                </tr>
                <?php
                  for($row=0;$row<sizeof($transacDatas);$row++){
                    echo "<tr class='table-items' onclick='goToTransactions(". $transacDatas[$row]['ID'] .")'>";
                      echo "<td>". $transacDatas[$row]['DATE'] ."</td>";
                      echo "<td>". $transacDatas[$row]['PLASTIC2L'] ."</td>";
                      echo "<td>". $transacDatas[$row]['PLASTIC250ML'] ."</td>";
                      echo "<td>". $transacDatas[$row]['TIN_CANS2L'] ."</td>";
                      echo "<td>". $transacDatas[$row]['TIN_CANS250ML'] ."</td>";
                      echo "<td>". $transacDatas[$row]['TOTAL'] ."</td>";
                    echo "</tr>";
                  } 
                ?>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script type="text/javascript" src="./javascript/frontendFunc.js"></script>
  </body>
</html>

<!-- 
(easy)
[] - PUT ICON BESIDE THE NAVIGATION TXT
[√] - LINK ALL NAVIGATION TABS
(medium)
[√] - LINE GRAPH FOR THE RECORDS (yr,mth,day) YR - √, MTH - √, DAY - √
[√] - NOTIFICATION SHOULD HAVE A STATUS immediate - √, mild - √, good - √
[√] - NEW TRANSACTION WILL BE DISPLAYED
[√] - FETCHING OF DATA FROM THINGSPEAK
[] - NOTIFICATION ABOUT FULL STORAGE (FIX SA ARDUINO)
[] - NOTIFICIATION IF COIN HOPPER IS HALF EMPTY AND EMPTY (FIX SA ARDUINO)
-->