<?php 
session_start();
$us=$_GET['user'];
$lo=$_GET['log'];

if($lo==1){
	
	$loginBO = htmlspecialchars(trim(strtoupper($us)));
	$passBO = trim(mb_strtoupper($us));

}else{
	$lOGin= sha1(date("Y-m-d:H"));  
	$loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
	
	$pASs=  sha1(date("H:Y-m-d"));
	$passBO = trim(mb_strtoupper($_POST["$pASs"]));
	
}
/* 160820225 ESTA LINEA SOLO HACE LA CONVERSION A AMAYUSCULAS PARA EL LOGUEO */
$loginBO = strtoupper($loginBO);
$passBO  = strtoupper($passBO);
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
    $_SESSION['clAVe']   = $passBO;





    $_SESSION['emp'] = $_SESSION['empresA'][0];
    if(  $_SESSION["usuARio"] == 'BARONF'
  		OR $_SESSION["usuARio"] == 'SILVAJ'
  		OR $_SESSION["usuARio"] == 'TORRESC'
  		OR $_SESSION["usuARio"] == 'SILVAJ'
  		OR $_SESSION["usuARio"] == 'MORANTESM'
  		OR $_SESSION["usuARio"] == 'SIERRAJ'
  		OR $_SESSION["usuARio"] == 'HOYOSF'
  		OR $_SESSION["usuARio"] == 'SUAREZM'
  		OR $_SESSION["usuARio"] == 'RODRIGUEZA'
  		OR $_SESSION["usuARio"] == 'IBANEZV'
  		OR $_SESSION["usuARio"] == 'GOMEZD'
  		OR $_SESSION["usuARio"] == 'RODRIGUEZC'
		OR $_SESSION["usuARio"] == 'PEREZD'
		OR $_SESSION["usuARio"] == 'SIERRAJ'
		OR $_SESSION["usuARio"] == 'GERENCIA'
		OR $_SESSION["usuARio"] == 'ESTADISTIC'
        OR $_SESSION["usuARio"] == 'PAEZD'
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
    // echo odbc_errormsg().'<br>';
    echo "
	<center>
	<BR>
	<BR>
	<BR>
	<BR>
	<BR>
	<div class="."container-xl "."position-absolute top-50 start-100 translate-middle". "link-secondary".">
	<h2>
	<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=user_conect.php\">
	<BR><BR> Error en ingreso, intentelo de nuevo.
	</a>
	</h2>
	</div>
	</center>
			";	
     die;
    }

?>
