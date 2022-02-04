<?php
if(session_start()===FALSE){
        session_start();
    }

//MSSQL
    //6.68=190.131.242.143
    //6.15=190.131.242.140
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); 
    //$cLink = mssql_connect('192.168.0.206', 'sa', 'administrador') or die(mssql_get_last_message());
    //$cLink = mssql_connect('192.168.0.206', 'sa', 'administrador') or die(mssql_get_last_message());
    mssql_select_db('InformesCompVentas',$cLink);
    
?>