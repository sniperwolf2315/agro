<?php 
$filename = "audit_".date("Y-m-d_Hi");
header("Content-Type: application/force-download");
header("Content-disposition: csv" .$filename. ".csv");
header( "Content-disposition: filename=".$filename.".csv");
// print $csv_output;
// @ #!°>>
?> 