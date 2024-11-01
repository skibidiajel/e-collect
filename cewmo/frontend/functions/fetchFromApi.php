<?php
  function fetchDataFrmApi($conn){
    $ch = curl_init();
    $url = "https://api.thingspeak.com/channels/2501832/feeds.json?api_key=WO9ZNZZHDYW08SBF&timezone=Asia/Singapore";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if($error = curl_error($ch)){
      echo $error;
    }else{
      $decoded = json_decode($response);
      //print_r($decoded);
      //echo "<br><br>";
      for($ctr=0; $ctr < sizeof($decoded->feeds); $ctr++){
        // for plastic and tin cans
        $field1ToString = $decoded->feeds[$ctr]->field1;
        $field2ToString = $decoded->feeds[$ctr]->field2;
        $field3ToString = $decoded->feeds[$ctr]->field3;
        $field4ToString = $decoded->feeds[$ctr]->field4;
        $field5ToString = $decoded->feeds[$ctr]->field5;
        $field1ToString = (int)$field1ToString;
        $field2ToString = (int)$field2ToString;
        $field3ToString = (int)$field3ToString;
        $field4ToString = (int)$field4ToString;
        $field5ToString = (int)$field5ToString;
        // for date
        $dateToString = $decoded->feeds[$ctr]->created_at;
        $dateToString = str_replace("Z","",$dateToString);
        $dateToString = str_replace("T","",$dateToString);
        $dateToString = strtotime($dateToString);
        $dateToString = date('Y/m/d H:i:s', $dateToString);
        //echo "No ".(string)$ctr+1 . " = field1=" . $field1ToString . " field2= " . $field2ToString . " Date= ". $dateToString ."<br>";

        // SENDING TO DB
        date_default_timezone_set("Asia/Singapore");
        $startTime = date("Y/m/d H:i:s");
        //$currentDate = date("Y/m/d", strtotime("+1 minute", strtotime($startTime)));
        $currentDate = date("Y/m/d H:i:s", strtotime("-1 minute", strtotime($startTime)));
        //echo "Current date = ".$currentDate. " date inserted = ". $dateToString. "<br>";
        if($currentDate <= $dateToString){
          // INSERTING THE LASTEST TRANSACTION IN DB
          $insert = "INSERT INTO plastic_tin_cans VALUES('', '$dateToString', $field1ToString, $field3ToString, $field2ToString, $field4ToString, $field5ToString)";
          $conn->query($insert);
          // SETTING THE COIN BALANCE AND SUBTRACTING IT
          $coinBalance = getCoin($conn);
          $differenceCB = $coinBalance - $field5ToString;
          // FUNCTION TO ADD THE LASTEST COIN BALANCE
          updateCoin($conn, $differenceCB);
          // INSERTING THE COIN DEDUCTED AND ITS DATE
          coinDeduction($conn, $dateToString, $field5ToString);
        }
      }
    }
    curl_close($ch);


  }
// [] - MAKE A QUERY FOR coin_status TABLE (SELECT) TO MAKE A COMPUTATION FOR DEDUCTION THEN STORE TO coin_deduction.
// [] - UPDATE coin_status TABLE TO THE TOTAL DEDUCTION.
?>
