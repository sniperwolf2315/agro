<?php
$cola=$_GET['cola'];
$emp=$_GET['emp'];
$per=$_GET['per'];
$periodo=explode("-",$per);
$Pery=explode(" ",$periodo[1]);
$sesionadmin = TRUE;

if ( $sesionadmin === true){
  $_SESSION[usuARio]='VILLALOBOS';
}else {
  $_SESSION[usuARio]='LOPEZJ';
}



$autorizados = array('OYUELAL','PEREZD','NINOM','LOPEZJ','CARDOZOJ' ,'VILLALOBOS');

$autorizado='no';
if( in_array( $_SESSION[usuARio], $autorizados) ){
  $autorizado = 'si';
  }
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	}

if(empty($tipo)){
    $tipo_area="MOLECULA";
    $_POST['molonom']=$tipo;
}else{
    $tipo_area=$tipo;
    $_POST['molonom']=$tipo;
}

if($cola != ''){
      $filtrosVA .= " AND COLABORADOR = '$cola' ";
}

//$fempresa = " AND EMPRESA = '".substr($emp,4)."' ";
//$fempresaTipo = " EMPRESA = '".substr($emp,4)."' AND TIPO = '$tipo_area' ";

//$fempresaTipo=substr($emp,4);
 
//$colabora=explode($cola,"-");
//echo $colabora[0];
//exit();
include("user_con.php");

if($cola !=''){  //ok
  if($autorizado !='si'){   //ok
    $fuser = " AND USUARIO = '$_SESSION[usuARio]'  "; 
  }
  //WHERE EMPRESA='$emp' AND TIPO = '$tipo_area'
  $sql="SELECT 
  ID, 
  CONCEPTO, 
  VALOR,
  IFNULL((SELECT SUM(valor) FROM rh_vale_vales_aplicados WHERE idvales = rh_vale_vales.ID AND corteap = ''), 'NA' ) AS APLICADO,
  IF(VALE IS NULL,concat('PF',PREFIRMADO), VALE) AS VALE,
  OBS,
  (SELECT GROUP_CONCAT( DISTINCT CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id
              ) AS PAGOS
  FROM rh_vale_vales WHERE EMPRESA='$emp' AND CODIGO='$cola' AND CORTE='$Pery[0]' AND ANO='$Pery[1]'  ORDER BY COLABORADOR";
  /*$sql = "SELECT 
            ID, CONCEPTO, VALOR 
            ,IFNULL((SELECT SUM(valor) FROM rh_vale_vales_aplicados WHERE idvales = rh_vale_vales.ID AND corteap = ''), 'NA' ) AS APLICADO
            ,IF(VALE IS NULL,concat('PF',PREFIRMADO), VALE) AS VALE
            ,OBS
            ,(SELECT GROUP_CONCAT( DISTINCT CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id
              ) AS PAGOS 
          FROM rh_vale_vales WHERE $fempresaTipo $filtrosVA $fuser ORDER BY CONCEPTO";*/
  }else{
    $sql="SELECT 
    ID, 
    CONCEPTO, 
    VALOR,
    IFNULL((SELECT SUM(valor) FROM rh_vale_vales_aplicados WHERE idvales = rh_vale_vales.ID AND corteap = ''), 'NA' ) AS APLICADO,
    IF(VALE IS NULL,concat('PF',PREFIRMADO), VALE) AS VALE,
    OBS,
    (SELECT GROUP_CONCAT( DISTINCT CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id
              ) AS PAGOS
    
     FROM rh_vale_vales EMPRESA='$emp' AND CODIGO='$cola' AND CORTE='$Pery[0]' AND ANO='$Pery[1]' ORDER BY COLABORADOR";
    /*
    $sql = "SELECT rh_vale_vales.ID, COLABORADOR as CONCEPTO, IFNULL(sum(rh_vale_vales.VALOR),'0') as VALOR, SUM(rh_vale_vales_aplicados.valor) AS APLICADO  
          FROM rh_vale_vales LEFT JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID WHERE $fempresaTipo $filtrosVA $fuser GROUP BY COLABORADOR ORDER BY COLABORADOR";*/
  }
$result = mysqli_query($mysqli, $sql); //echo $sql;
while($row = mysqli_fetch_array($result)){
  /*$concID = $row["ID"];
  $dtos["$concID"] = $row["VALOR"];
  $conceptos["$concID"] = $row["CONCEPTO"];
  $aplicados["$concID"] = $row["APLICADO"];
  $vale["$concID"] = $row["VALE"];
  $obs["$concID"] = $row["OBS"]."
  Pagos: ".$row[PAGOS];
  */
  $Aux.=$row["ID"]."^".$row["VALOR"]."^".$row["CONCEPTO"]."^".$row["APLICADO"]."^".$row["VALE"]."^".$row["OBS"]."^".$row["PAGOS"].";";
  /*
  $_POST["conc$concID"] = $row["ID"] ;
  
  if($_POST["dtos$concID"] == '' AND $row["APLICADO"] == 'NA' ){ 
    $_POST["dtos$concID"] = $row["VALOR"] * -1 ; 
    }
  
  if($row["APLICADO"] != 'NA'){
    $dtosT += $row["APLICADO"];
    }else{
    $pendDTO ='SI';
    }  
  if($periodoVEN == 'si'){
    $dtosT += $_POST["dtos$concID"];
    }
    */
  }
  echo $Aux;
?>