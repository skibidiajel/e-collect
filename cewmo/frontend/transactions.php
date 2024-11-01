<?php  
  session_start();
  include '../backend/connection.php';
  include './functions/dbFunction.php';
  include './functions/fetchFromApi.php';

  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/transactions.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
          <a class="nav-link" href="dashboard.php" onclick="changeTab()">
            <li class="nav-item">
              Dashboard
            </li>
          </a>
          <a class="nav-link" href="transactions.php" onclick="changeTab()">
            <li class="nav-item active">
              Transaction Records
            </li>
          </a>
          <a class="nav-link" href="coin.php" onclick="changeTab()">
            <li class="nav-item">
              Coin Records
            </li>
          </a>
          <a class="nav-link" href="notification.php" onclick="changeTab()">
            <li class="nav-item">
              Notifications
            </li>
          </a>
          <a class="nav-link" href="users.php" onclick="changeTab()">
            <li class="nav-item">
              Users
            </li>
          </a>
          <a class="nav-link" href="logs.php" onclick="changeTab()">
            <li class="nav-item">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <main>
        <table id="table-filter">
          <caption>Transaction Records</caption>
          <tr>
            <td colspan=6>
              <form style="text-align: left" id="transaction-record" action="transactions.php" method="POST">
                <label for="filter-date">Filter: </label>
                <select name="filterDate" id="filter-date">
                  <option value="none">None</option>
                  <option value="<?= 'year'; ?>">Year</option>
                  <option value="<?= 'month'; ?>">Month</option>
                  <option value="<?= 'day'; ?>">Day</option>
                </select>
              </form>
              <script>
                // FUNCTION FOR FILTERING DATA IN TRANSACTION TABLE
                $(document).ready(function(){
                  $('#filter-date').on('change',function(){
                    $.ajax({
                      method: 'POST',
                      dataType: "json",
                      url: 'transactionRecords.php',
                      cache: false,
                      data:{
                        getData: $(this).val(),
                      },
                      success:function(data){
                        /*console.log(data);
                        $('#new-output').text(data);*/
                        if(data){
                          $('#new-output').empty('');
                          console.log(data);
                          for (var i in data) {
                            var row = $('<tr>');
                            row.append($('<td>').html(data[i].DATE));
                            row.append($('<td>').html(data[i].PLASTIC2L));
                            row.append($('<td>').html(data[i].PLASTIC250ML));
                            row.append($('<td>').html(data[i].TIN_CANS2L));
                            row.append($('<td>').html(data[i].TIN_CANS250ML));
                            row.append($('<td>').html(data[i].TOTAL));
                            $('</tr>');
                            $('#new-output').append(row);
                          }
                        }else{
                          console.log("NOPE");
                        }
                      }
                    });
                  });  
                })

              </script>
              <?php
                // FETCHING TRANSACTION RECORDS
                $transactions = fetchDataTransacSorted($conn);
              ?>
            </td>
          </tr>
          <tr>
            <th>
              Date and Time
            </th>
            <th>
              Plastic 2L
            </th>
            <th>
              Plastic 250mL
            </th>
            <th>
              Tin can 2L
            </th>
            <th>
              Tin can 250mL
            </th>
            <th>
              Total
            </th>
          </tr>
          <tbody id=new-output>
            <?php
              if($transactions != NULL){
                foreach($transactions as $data){
                  echo "<tr id='old-output'>";
                    echo "<td>". $data['DATE'] ."</td>";
                    echo "<td>". $data['PLASTIC2L'] ."</td>";
                    echo "<td>". $data['PLASTIC250ML'] ."</td>";
                    echo "<td>". $data['TIN_CANS2L'] ."</td>";
                    echo "<td>". $data['TIN_CANS250ML'] ."</td>";
                    echo "<td>". $data['TOTAL'] ."</td>";
                  echo "</tr>";
                }
              }else{
                echo "<tr id='old-output'>";
                  echo "<td> No transactions </td>";
                echo "</tr>";
              }
            ?>
          </tbody>
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