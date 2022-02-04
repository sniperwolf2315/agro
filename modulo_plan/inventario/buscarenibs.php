<?php
$d1=$_GET['grp'];
$fv=$_GET['fv'];
//session_start();
$_SESSION['Grupo']=$d1;
$_SESSION['fVenc']=$fv;
$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');
$reg1="";
$reg2="";
$reg3="";
$datob="";
$sql = "select * from VISINV006 WHERE PGPRDC='0000000030001'";
	        $result = odbc_exec($db2con, $sql);
            $row = odbc_fetch_array($result);
            $reg1 = $row['PGPRDC'];
            $reg2 = $row['PGDESC'];
            $reg3 = $row['SRSROM'];
            //item descripcion bodega
            $datob=$reg1.'^'.$reg2.'^'.$reg3;
            //adiciona el grupo si no esta en la base 
            include('conexioninventario.php');
            $result = mssql_query("SELECT DISTINCT(pgpgrp) from invRegistro WHERE pgpgrp='$d1'");
            $fila = mssql_fetch_array($result);
            $numero = mssql_num_rows($result);
            //$d1=$fila[0];
            /*while($row = odbc_fetch_array($result)){ 
               $regs = $row['PGDESC'];
               
            }*/
            echo $datob.'^'.'---'.$numero;
?>