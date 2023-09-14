<?php
$item=trim($_GET['itm']);
$codigotemp=$item;
$item=substr($item,1,12);
$compania=$_SESSION['Compan'];
require_once('user_con.php');
if($compania=='Agrocampo'){
    require_once('conexioninventario80.php');
}
if($compania=='Comervet'){
    require_once('conexionInvComervet80.php');
}
if (!isset($_SESSION)) { session_start(); }
//$_SESSION['Grupo']=trim($d1);
//$_SESSION['fVenc']=$fv;
//$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');
//$reg1="";
$reg2="";
$reg3="";
$datob="";
//$sql = "select * from AGR620CFAG.VISINV006 WHERE PGPRDC='$item'";SRBPRG.PGPRDC, SRBEAN.PJEANP, SRBPRG.PGDESC
//$sql="SELECT * FROM AGR620CFAG.SROPRG SRBPRG LEFT JOIN AGR620CFAG.SROEAN SRBEAN ON SRBPRG.PGPRDC = SRBEAN.PJPRDC WHERE SRBEAN.PJEANP LIKE '%4540104902016%'";
                $tam=strlen($codigotemp);
                //echo $tam."--".$codigotemp."--".$codigo3."--";
                //if($tam==13){
                    //$sql="SELECT DISTINCT PGPRDC AS ITEM FROM AGR620CFAG.VISINVWHM WHERE PCXPRC='$codigotemp' OR LEFT(PCXPRC,12)='$codigo2' OR LEFT(PCXPRC,12)='$codigotemp'";
                    //OR LEFT(PGPRDC,12)='$codigotemp'
                    if($compania=='Agrocampo'){
                        $sql="SELECT * FROM AGR620CFAG.VISINVWHM WHERE PGPRDC='$codigotemp'";
                    }
                    if($compania=='Comervet'){
                        $sql="SELECT * FROM AGR620CFZZ.VISINVWHM WHERE PGPRDC='$codigotemp'";
                    }
                //}
                /*if($tam==12 || $tam==11){
                    //$sql="SELECT DISTINCT PGPRDC AS ITEM FROM AGR620CFAG.VISINVWHM WHERE PCXPRC='$codigotemp' OR LEFT(PCXPRC,11)='$codigo3' OR LEFT(PCXPRC,12)='$codigotemp'";
                    //OR LEFT(PGPRDC,12)='$codigotemp' OR LEFT(PGPRDC,11)='$codigotemp'
                    $sql="SELECT * FROM AGR620CFAG.VISINVWHM WHERE PGPRDC='$codigotemp'";
                }
                */
            //$sql="SELECT * FROM AGR620CFAG.VISINVWHM WHERE PCXPRC='$item' OR PCXPRC LIKE '%$item%'";
	        $result = odbc_exec($db2con, $sql);
            $row = odbc_fetch_array($result);
            //$reg1 = $row['PGPRDC'];
            if($result){
                $reg2 = utf8_encode($row['PGDESC']);
                //$reg2 = utf8_encode($row['SRBEAN.PJEANP']);
                $itemb = utf8_encode($row['PGPRDC']);
                //GRUPO
                $grupo = utf8_encode($row['PGPGRP']);
                $grupo=trim($grupo);
                $reg3 = "008";
            }
            odbc_close($result);
            $_SESSION['Bodsede']=trim($reg3);
            $_SESSION['Item']=trim($itemb);
            //item descripcion bodega
            $datob=$reg2.'^'.$reg3;
            //adiciona el grupo si no esta en la base 
            //include('conexioninventario.php');
            
            //$cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); 
            //mssql_select_db('sqlInventario008',$cLink);
            
            if($compania=='Agrocampo'){
                require_once('conexioninventario80.php');
                $result = mssql_query("SELECT Ejecutar FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE PGPGRP='$grupo'", $cLink);
            }
            if($compania=='Comervet'){
                require_once('conexionInvComervet80.php');
                $result = mssql_query("SELECT Ejecutar FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE PGPGRP='$grupo'", $cLink);
            }
            $fila = mssql_fetch_array($result);
            //$numero = mssql_num_rows($result);
            $Estado=$fila['Ejecutar'];
            if ($Estado==0 || $Estado=='0'){
                $datob="N";
            }
            mssql_close($result);
                        
            //$d1=$fila[0];
            /*while($row = odbc_fetch_array($result)){ 
               $regs = $row['PGDESC'];
               
            }*/
            //echo $datob.'^'.'---'.$numero.'---'.$_SERVER['PATH_INFO'];
            echo $datob;
?>