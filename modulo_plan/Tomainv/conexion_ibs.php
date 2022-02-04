<?php
if($_SESSION['usuARioF'] ==''){
header("location:index.php");
}
$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');

?>