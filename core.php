<?php

date_default_timezone_set('America/New_York');

require_once('./funcs/functions.php');

$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
// Date Builder
$year = date('Y');
$month = date('m');
$date = date('d');
$day = date('l');
$today = $months[$month - 1] . ' ' . $date . ' ' . $year;

// Time Builder
$hours = date('h');
$minutes = date('i');
$seconds = date('s');
$ap = date('a');
$time = $hours . ':' . $minutes . ':' . $seconds . $ap;

//
// logic to check if its a holiday
// or if its a regular day
//

// Retrieve Holidays and Decode JSON
$holidays = file_get_contents('./src/holidays.json');
$holiJSON = json_decode($holidays);

// Retrieve Regular Days and Decode JSON
$regularDays = file_get_contents('./src/regular.json');
$reguJSON = json_decode($regularDays);

$holidayObj = null;
$regObj = null;
$counter = 0;

foreach($holiJSON as $holi){
   // Adds trailing zero to single digit days
   if(strlen($holi->date->d) <= 1) {
      $holi->date->d = '0' . $holi->date->d;
   }

   if(buildDate($holi->date) === $today){
      $holidayObj = $holi;
      isStoreOpen($months[$month - 1], $date, $year, $hours, $minutes, $ap, $holidayObj->open, $holidayObj->close);
   }
}

if($holidayObj === null){
   foreach ($reguJSON as $k => $store) {
      // Checks if first store - displays first store's info
      if($counter === 0){
         foreach ($store as $key => $reg) {
            if(ucwords($key) === $day) {
               // Adds Store name to OBJ
               $reg->store = ucwords($k);
               $regObj = $reg;
            }
         }
      }
      $counter ++;
   }
   isStoreOpen($months[$month - 1], $date, $year, $hours, $minutes, $ap, $regObj->open, $regObj->close);
}

//
// Determine if store is open or closed
//
function isStoreOpen($mon, $d, $yr, $hr, $min, $ap, $openObj, $closeObj){
   $nowTime = toUnixTime($mon, $d, $yr, toMilitaryTime($hr, $ap), $min);
   $openTime = toUnixTime($months[$month - 1], $date, $year, toMilitaryTime($openObj->hr, $openObj->amPm), $openObj->min);
   $closeTime = toUnixTime($months[$month - 1], $date, $year, toMilitaryTime($closeObj->hr, $closeObj->amPm), $closeObj->min);

   // Making golbalMsg and salutation global variables
   global $globalMsg;
   global $salutation;

   // Open or close
   if( ($openTime <= $nowTime) && ($nowTime < $closeTime) ){
      $globalMsg = 'We are open';
   } else {
      $globalMsg = 'We are close';
   }

   // Type of salutation
   if( $ap === 'am' ){
      $salutation = "Good Morning";
   } elseif ( $ap === 'am' && toMilitaryTime($hr, $ap) === 12  ) {
      $salutation = "Good Afternoon";
   } elseif ( $ap === 'pm' && (toMilitaryTime($hr, $ap) >= 13 && toMilitaryTime($hr, $ap) <= 17) ) {
      $salutation = "Good Afternoon";
   } elseif ( $ap === 'pm' && toMilitaryTime($hr, $ap) >= 18 ) {
      $salutation = "Good Evening";
   }
}
