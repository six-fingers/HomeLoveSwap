<?php

date_default_timezone_set('Europe/London');
setlocale(LC_ALL, 'en_US');

$fileName = $argv[2] ? $argv[2] : 'file.csv';
$year = $argv[1] ? $argv[1] : date('Y');

echo fileGenerator($fileName, $year);

function fileGenerator($fileName, $year) {
  $fileContent = arrayGenerator($year);
  if( file_put_contents($fileName, $fileContent) ) {
    return "A File Named $fileName Has Been Generated For The Year $year \n";
  } else {
    return "Unknown Error \n";
  }
}


function arrayGenerator($year) {
  $array = array("\"Month Name\", \"1st expenses day\", \"2nd expenses day\", \"Salary day\"\n");

  for ($month=1; $month <= 12; $month++) {

    $day = 1;
    while (isWeekendDay("$year-$month-$day")) {
      $day++;
    }
    $firstExpensesDay = strftime("%G-%m-%d", strtotime("$year-$month-$day"));

    $day = 15;
    while (isWeekendDay("$year-$month-$day")) {
      $day++;
    }
    $secondExpensesDay = strftime("%G-%m-%d", strtotime("$year-$month-$day"));

    $day = date("t", strtotime("$year-$month-$day"));
    while (isWeekendDay("$year-$month-$day")) {
      $day--;
    }
    $salaryDay = strftime("%G-%m-%d", strtotime("$year-$month-$day"));

    $monthName = date("F", strtotime("$year-$month-01"));

    $string .= "\"$monthName\", \"$firstExpensesDay\", \"$secondExpensesDay\", \"$salaryDay\"\n";
    array_push($array, "\"$monthName\", \"$firstExpensesDay\", \"$secondExpensesDay\", \"$salaryDay\"\n");
  }
  return $array;
}


function isWeekendDay($date) {
  $dayName = date('D', strtotime($date));
  return $dayName === 'Sat' || $dayName === 'Sun' ? true : false;
}


?>
