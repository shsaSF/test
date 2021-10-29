<?php

$csv_l = (new SplFileObject($argv[1]))->setFlags(SplFileObject::READ_CSV);
$csv_s = (new SplFileObject($argv[2]))->setFlags(SplFileObject::READ_CSV);

$ip_l = array();
$ip_s = array();

$ip_l = function($csv){
   foreach ($csv as  $line) {
     $ip_l[] = $line[5];
   } 
   return $ip_l;
};


$ip_s = function(){
   foreach ($csv_s as  $line) {
     $ip_s[] = $line[0];
   } 
   return $ip_s;
};


var_dump($ip_l());

//foreach( array_diff($ip_s, $ip_l) as $ip ) {
//    echo $ip . "\n";
//}
