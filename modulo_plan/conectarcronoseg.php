<?php
session_start();

//MSSQL

    $cLink2 = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message());
    mssql_select_db('sqlCronoseg',$cLink2);
?>