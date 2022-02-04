<?php
if(session_start()===FALSE){
        session_start();
    }
$lOGin= sha1(date("Y-m-d:H"));  
$loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));

$pASs=  sha1(date("H:Y-m-d"));
$passBO = trim(mb_strtoupper($_POST["$pASs"]));
 
//CONECCION DB2

//echo "odbc_connect('IBM-AGROCAMPO',$loginBO,$passBO)";
$emP = "";
$handle = odbc_connect('IBM-AGROCAMPO-P',$loginBO,$passBO);
$result = odbc_exec($handle, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='AG- AGROCAMPO'; $emP = "DeNtR";
		}
		
$handleP = odbc_connect('IBM-PESTAR-P',$loginBO,$passBO);
$result = odbc_exec($handleP, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='X1- PESTAR'; $emP = "DeNtR"; 
		}

$handleC = odbc_connect('IBM-COMERVET-P',$loginBO,$passBO);
$result = odbc_exec($handleC, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='ZZ- COMERVET'; $emP = "DeNtR"; 
		}

if($emP == "DeNtR" ){
    $_SESSION['usuARio'] = $loginBO;
    $_SESSION['clAVe'] = $passBO;
    $_SESSION['emp'] = $_SESSION['empresA'][0];
    if(  $_SESSION["usuARio"] == 'CARDOZOJ'
  		OR $_SESSION["usuARio"] == 'TORRESC'
		){ 
		  $_SESSION["dIr"] ='SI';
		}

    
    if($_POST['claves'] < 750){
    	$_SESSION['ancho'] = 'cel' ;
   	 	}else{
    	$_SESSION['ancho'] = 'pc' ;
    	}	
    header("location:index.php");
    }
    else{
    header("location:user_conect.php");
    $_SESSION['acc']='1';
    $_SESSION['usuARio']="";
    /*if(session_start()===TRUE){
        session_destroy();
    }*/
    }


?>