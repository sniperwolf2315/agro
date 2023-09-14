<?php
$item=trim($_GET['itm']);
require_once('user_con.php');
//if (!isset($_SESSION)) { session_start(); }
//$_SESSION['Grupo']=trim($d1);
//$_SESSION['fVenc']=$fv;
//$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');
//$reg1="";
$reg2="";
$reg3="";
$datob="";
$sql = "select * from AGR620CFAG.VISINV006 WHERE PGPRDC='$item'";
	        $result = odbc_exec($db2con, $sql);
            $row = odbc_fetch_array($result);
            //$reg1 = $row['PGPRDC'];
            $reg2 = utf8_encode($row['PGDESC']);
            $reg3 = $row['SRSROM'];
            odbc_close($result);
            //$_SESSION['Bodsede']=trim($reg3);
            //item descripcion bodega
            $datob=$reg2.'^'.$reg3;
            //adiciona el grupo si no esta en la base 
            //include('conexioninventario.php');
            
            /*
            $result = mssql_query("SELECT DISTINCT(pgpgrp) from invGrupo WHERE pgpgrp='$d1'", $cLink008);
            $fila = mssql_fetch_array($result);
            $numero = mssql_num_rows($result);
            mssql_close($result);
            */
            
            //$d1=$fila[0];
            /*while($row = odbc_fetch_array($result)){ 
               $regs = $row['PGDESC'];
               
            }*/
            //echo $datob.'^'.'---'.$numero.'---'.$_SERVER['PATH_INFO'];
            echo $datob;
?>