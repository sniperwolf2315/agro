<?php
//require_once('../user_con.php');
$d1=$_GET['grp'];
$fv=$_GET['fv'];
$gc=$_GET['gc'];
$sd=$_GET['sd'];
if (!isset($_SESSION)) { session_start(); }
$d1=strtoupper($d1);
$d1=trim($d1);

                if($sd=='Portos'){
                    require_once('../conexioninventario80.php');    
                }else if($sd=='Calle73'){
                    require_once('../conexioninventario73.php');
                    if(strlen($d1)==1){
                    $d1='00'.$d1;
                    }
                    if(strlen($d1)==2){
                        $d1='0'.$d1;
                    } 
                }
                
                $result2 = mssql_query("SELECT * from invGrupo WHERE PGPGRP='$d1'");
               
                $numero2 = mssql_num_rows($result2);
                if($numero2 > 0 ){
                    $_SESSION['fVenc']=$fv;
                    $_SESSION['gConteo']=$gc;
                    $_SESSION['Pantalla']='2';
                    $_SESSION['Ubicag']=$d1;
                    $_SESSION['Sede']=$sd;
                }else{
                    $_SESSION['fVenc']='0';
                    $_SESSION['gConteo']='0';
                    $_SESSION['Pantalla']='1';
                    $_SESSION['Ubicag']='-';
                    $_SESSION['Sede']='';
                }
                
                mssql_close($result2);
            echo $numero2;
            //echo $d1;
?>