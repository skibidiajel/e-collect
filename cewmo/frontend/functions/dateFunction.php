<?php
  // GETTING THE CURRENT YEAR
  function getYear($date){
    $currentYear = $date->format("Y");
    return $currentYear;
  }

  function getMonthYear($date){
    $currentMonth = $date->format("Y-n");
    return $currentMonth;
  }

  function getDay($date){
    $currentDate = $date->format("z");
    return $currentDate;
  }
?>