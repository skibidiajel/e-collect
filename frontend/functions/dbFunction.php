<?php
  // UNCOMMENT FOR DEBUGGING
  //include '../backend/connection.php';

  // FOR LOGIN FUNCTION
  function LoginCreds($conn, $username, $password){
    // FETCHING USER DATA FROM DB
    $usersSelect = "SELECT * FROM users WHERE Username = '$username'";
    $usersResult = $conn->query($usersSelect);
    
    // CREATING CONDITION IF THERE IS A FETCHED DATA OR NO
    if($usersResult->num_rows > 0){
      while($row = $usersResult->fetch_assoc()){
        $userPass = $row['Password'];
        $returnBool = ($userPass === $password) ? true : false;
        $insertLogs = "INSERT INTO logs VALUES('',now(), '$username', 'USERS - Logged In');";
        $conn->query($insertLogs);
        return $returnBool;
      }
    }else{
      return false;
    }
  }
  // FETCHING OF TRANSACTION DATA FUNCTION
  function fetchDataTransac($conn){
    // FETCHING TRANSACTION DATA FROM DB
    $transacSelect = "SELECT * FROM plastic_tin_cans";
    $transacResult = $conn->query($transacSelect);
    // CHECKING IF THERE IS A FETCHED DATA
    if($transacResult->num_rows > 0){
      // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
      $transactions = [];
      while($row = $transacResult->fetch_assoc()){
        $transactions[] = $row;
      }
      return $transactions;
    }
  }

  function fetchDataTransacSorted($conn){
    // FETCHING TRANSACTION DATA FROM DB
    $transacSelect = "SELECT * FROM plastic_tin_cans ORDER BY DATE DESC";
    $transacResult = $conn->query($transacSelect);
    // CHECKING IF THERE IS A FETCHED DATA
    if($transacResult->num_rows > 0){
      // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
      $transactions = [];
      while($row = $transacResult->fetch_assoc()){
        $transactions[] = $row;
      }
      return $transactions;
    }
  }

  function fetchDataTransacSortedLimit($conn){
    // FETCHING TRANSACTION DATA FROM DB
    $transacSelect = "SELECT * FROM plastic_tin_cans ORDER BY DATE DESC LIMIT 10";
    $transacResult = $conn->query($transacSelect);
    // CHECKING IF THERE IS A FETCHED DATA
    if($transacResult->num_rows > 0){
      // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
      $transactions = [];
      while($row = $transacResult->fetch_assoc()){
        $transactions[] = $row;
      }
      return $transactions;
    }
  }

  // GETTING THE TOTAL NUMBER OF TRANSACTION PER YEAR
  function getTransacYear(&$arr, $currentDate){
    $ctr = 0;
    foreach($arr as $year){
      if($year == $currentDate){
        $ctr++;
      }
    }
    return $ctr;
  }
  // GETTING THE TOTAL NUMBER OF TRANSACTION PER MONTH
  function getTransacMonth(&$arr, $currentMonth, $currentYear){
    // FOR COUTING IN NUMBER OF TRANSACTIONS
    $ctr = 0;
    foreach($arr as $month){
      $date = new Datetime($month);
      $tempMonth = $date->format("n");
      // CONDITIONAL STATEMENT TO CHECK IF THE DATA HAS THE SAME MONTH AND YEAR
      if(($tempMonth == (string)$currentMonth) && ($date->format("Y")) == $currentYear){
        $ctr++;
      }
    }
    return $ctr;
  }
  // GETTING THE TOTAL NUMBER OF TRANSACTION PER DAY
  function getTransacDaily(&$arr, $currentDay){
    $ctr = 0;
    foreach($arr as $daily){
      if($daily == $currentDay){
        $ctr++;
      }
    }
    return $ctr;
  }

  /* FOR NOTIFCATION AND NEW TRANSACTION */
  function getDataNotif($conn){
    // GETTING NOTIF DATA FROM DB
    $notifSelect = "SELECT * FROM notifications ORDER BY DATE_TIME DESC";
    $notifResult = $conn->query($notifSelect);
    // CHECKING IF THERE IS A DATA IN NOTIF TABLE
    $notifications = [];
    if($notifResult->num_rows > 0){
      while($row = $notifResult->fetch_assoc()){
        $notifications[] = $row;
      }
      return $notifications;
    }
  }

  // FOR NOTIFICATION WITH LIMIT
  function getDataNotifLimit($conn){
    // GETTING NOTIF DATA FROM DB
    $notifSelect = "SELECT * FROM notifications ORDER BY DATE_TIME DESC LIMIT 10";
    $notifResult = $conn->query($notifSelect);
    // CHECKING IF THERE IS A DATA IN NOTIF TABLE
    $notifications = [];
    if($notifResult->num_rows > 0){
      while($row = $notifResult->fetch_assoc()){
        $notifications[] = $row;
      }
      return $notifications;
    }
  }

  /* FOR ADMIN ACCOUNTS */
  function getDataUsers($conn){
    // GETTING USER DATA FROM DB
    $userSelect = "SELECT * FROM users";
    $userResult = $conn->query($userSelect);
    // CHECKING IF THERE IS A DATA IN USER TABLE
    $users = [];
    if($userResult->num_rows > 0){
      while($row = $userResult->fetch_assoc()){
        $users[] = $row;
      }
      return $users; 
    }
  }

  // FETCHING LOGS DATA FROM DB
  function getDataLogs($conn){
    // GETTING LOG DATA FROM DB
    $logSelect = "SELECT * FROM logs";
    $logResult = $conn->query($logSelect);
    // CHECKING IF THERE IS A DATA IN LOG TABLE
    $logs = [];
    if($logResult->num_rows > 0){
      while($row = $logResult->fetch_assoc()){
        $logs[] = $row;
      }
      return $logs;
    }
  }

  // FETCHING TOTAL COINS FROM DB
  function getTotalCoin($conn){
    // GETTING TOTAL COIN FROM DB
    $totalCoinSelect = "SELECT * FROM coin_status";
    $totalCoinResult = $conn->query($totalCoinSelect);
    // CHECKING IF THERE IS A DATA IN TOTAL COIN TABLE
    $totalCoin;
    if($totalCoinResult->num_rows > 0){
      while($row = $totalCoinResult->fetch_assoc()){
        $totalCoin = $row;
      }
      return $totalCoin;
    }
  }

  // INSERTING NEWLY ADDED ACCOUNTS IN DB
  function setDataUsers($user, $pass, $conn, $usernameLogs){
    $users = getDataUsers($conn);
    foreach($users as $ctr){
      if($ctr['Username'] == $user){
        die("<script>alert('Same username is found. Please change it');</script>");
      }
    }
    // INSERTING TO DB
    $userInsert = "INSERT INTO users VALUES('','$user','$pass')";
    $conn->query($userInsert);
    $insertLogs = "INSERT INTO logs VALUES('', now(), '$usernameLogs', 'USERS - Added a User');";
    $conn->query($insertLogs);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=users.php\">";
  }

  // UPDATING EDITED USER INFORMATION TO DB
  function setDataUsersEdit($id, $user, $pass, $conn, $usernameLogs){
    // INSERTING TO DB
    $userUpdate = "UPDATE users SET Username = '$user', Password = '$pass' WHERE ID = $id";
    $conn->query($userUpdate);
    $insertLogs = "INSERT INTO logs VALUES('', now(), '$usernameLogs', 'USERS - Edited a User');";
    $conn->query($insertLogs);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=users.php\">";
  }
  // DELETING SELECTED USER INFORMATION IN DB
  function deleteUserData($id, $conn, $usernameLogs){
    // DELETING FROM DB
    $userDelete = "DELETE FROM users WHERE ID = $id;";
    $userAlter = "SET @num := 0;
                  UPDATE users SET ID = @num := (@num+1);
                  ALTER TABLE users AUTO_INCREMENT = 1;";
    $conn->query($userDelete);
    $insertLogs = "INSERT INTO logs VALUES('', now(), '$usernameLogs', 'USERS - Deleted a User');";
    $conn->query($insertLogs);
    $conn->multi_query($userAlter);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=users.php\">";
  }

  // SETTING INPUTTED COIN TO DB
  function setCoinInDb($fetchDataCoin, $conn){
    // CHECKING IF THERE IS A RECORD ON DB
    $totalCoinSelect = "SELECT * FROM coin_status";
    $totalCoinResult = $conn->query($totalCoinSelect);
    if($totalCoinResult->num_rows > 0){
      while($row = $totalCoinResult->fetch_assoc()){
        $addOldRecord = $row['TOTAL_COINS'];
        $newRecord = $addOldRecord + $fetchDataCoin;
      }
      $totalCoinUpdate = "UPDATE coin_status SET TOTAL_COINS = '$newRecord' WHERE ID = 1";
      $conn->query($totalCoinUpdate);
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=coin.php\">";
    }
  }

  // FUNCTION FOR CLEARING COINS
  function clearCoin($conn){
    // UPDATE CODE FOR CLEARING COIN
    $coinUpdate = "UPDATE coin_status SET TOTAL_COINS = 0 WHERE ID = 1";
    $conn->query($coinUpdate);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=coin.php\">";
  }

  // FUNCTION GETTING COIN 
  function getCoin($conn){
    // SELECTING COIN COLUMN IN DB
    $selectCoin = "SELECT TOTAL_COINS FROM coin_status";
    $resultCoin = $conn->query($selectCoin);

    return $resultCoin->fetch_assoc();
  }

  // FUNCTION FOR UPDATING THE LASTEST COIN BALANCE
  function updateCoin($conn, $newValueCB){
    // UPDATING COIN BALANCE
    $updateCoin = "UPDATE coin_status SET TOTAL_COINS = $newValueCB WHERE ID = 1";
    $conn->query($updateCoin);
  }

  function coinDeduction($conn, $date, $coinToDeduc){
    // INSERTING IT TO THE TABLE
    $insertCBDeduction = "INSERT INTO coin_deduction VALUES('$date', $coinToDeduc)";
    $conn->query($insertCBDeduction);
  }
?>