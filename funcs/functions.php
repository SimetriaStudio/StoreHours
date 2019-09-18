<?php

   function buildDate($obj){
      return $obj->m . ' ' . $obj->d . ' ' . $obj->y;
   }

   function buildHours($obj){
      return $obj->hr . ':' . $obj->min . $obj->amPm;
   }

   function toUnixTime($m, $d, $y, $hr, $min){
      $date = $m . ' ' . $d . ' ' . $y . ' ' . $hr . ':' . $min;
      return strtotime("$date");
   }

   function toMilitaryTime($hr, $amPm){
      if($amPm === 'pm' && $hr < 12){
         return $hr + 12;
      } else {
         return $hr;
      }
   }
