<?php
/*if(session_start()===FALSE){
        session_start();
    }
*/
//MSSQL

    $cLink = mssql_connect('192.168.0.206', 'sa', 'administrador') or die(mssql_get_last_message()); 
    mssql_select_db('InformesCompVentas',$cLink);
    


?>