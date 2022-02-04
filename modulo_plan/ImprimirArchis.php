<?php

$handle = printer_open("\\192.168.6.14KyoceraP1");

printer_start_doc($handle, "PET PASS");

printer_start_page($handle);

$filename = "test.txt";

$fhandle=fopen($filename, "r");
$contents = fread($fhandle, filesize($filename));
fclose($fhandle);

printer_set_option($handle, PRINTER_MODE, "RAW");
printer_write($handle,$contents);

printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);

?>