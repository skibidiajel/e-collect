<?php
  include '../backend/connection.php';

  if($_REQUEST['getData']){
    $filterData = $_REQUEST['getData'];

    if($filterData == 'year'){
      $date = new Datetime();
      $year = $date->format('Y');
      // FETCHING TRANSACTION DATA FROM DB
      $transacSelect = "SELECT * FROM plastic_tin_cans WHERE EXTRACT(YEAR FROM DATE) = '$year' ORDER BY DATE DESC";
      $transacResult = $conn->query($transacSelect);
      // CHECKING IF THERE IS A FETCHED DATA
      if($transacResult->num_rows > 0){
        // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
        $transactions = [];
        while($row = $transacResult->fetch_assoc()){
          $transactions[] = $row;
        }
        echo json_encode($transactions);
      }
    }else if($filterData == 'month'){
      $date = new Datetime();
      $month = $date->format('n');
      // FETCHING TRANSACTION DATA FROM DB
      $transacSelect = "SELECT * FROM plastic_tin_cans WHERE EXTRACT(MONTH FROM DATE) = '$month' ORDER BY DATE DESC";
      $transacResult = $conn->query($transacSelect);
      // CHECKING IF THERE IS A FETCHED DATA
      if($transacResult->num_rows > 0){
        // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
        $transactions = [];
        while($row = $transacResult->fetch_assoc()){
          $transactions[] = $row;
        }
        echo json_encode($transactions);
      }
    }else if($filterData == 'day'){
      $date = new Datetime();
      $day = $date->format('d');
      // FETCHING TRANSACTION DATA FROM DB
      $transacSelect = "SELECT * FROM plastic_tin_cans WHERE EXTRACT(DAY FROM DATE) = '$day' ORDER BY DATE DESC";
      $transacResult = $conn->query($transacSelect);
      // CHECKING IF THERE IS A FETCHED DATA
      if($transacResult->num_rows > 0){
        // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
        $transactions = [];
        while($row = $transacResult->fetch_assoc()){
          $transactions[] = $row;
        }
        echo json_encode($transactions);
      }else{
        // CREATING ARRAY VARIABLE FOR THE FETCHED DATA
        $transactions = [];
        while($row = $transacResult->fetch_assoc()){
          $transactions[] = $row;
        }
        echo json_encode($transactions);
      }
    }else if($filterData == 'none'){
      $date = new Datetime();
      $day = $date->format('d');
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
        echo json_encode($transactions);
      }
    }
  }
?>