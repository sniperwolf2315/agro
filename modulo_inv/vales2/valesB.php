<? session_start();
$sesionadmin = false;
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	}

include("../user_con.php");
if ( $sesionadmin === true){
  $_SESSION[usuARio]='VILLALOBOS';
}else {
  $_SESSION[usuARio]='LOPEZJ';
}

//if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo aqui<a href='../../index.php'></a>"; DIE;}

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../antenna/auto.js"></script>
<script src="../../aajquery.js"></script>
<link rel="stylesheet" href="../../aajquery.css" >

<style type="text/css" media="print">
.nover {display:none}
</style>
<style type="text/css" media="screen">
.noverp {display:none}
</style>


<style type="text/css" >
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px; direction:ltr; }
.frxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px; direction:ltr; }
.frs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }
.campo{ width:90%	}
.boton{ width:33%	}
}
.auto-style1 {
	text-align: right;
}
</style>

<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show();
    });
    
    $(".verloaderB").change(function(){
        $(".loader").show();
    });
    
    $("select").select2(); 
});

$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>

<style type="text/css" media="print">
@page{
   size: letter portrait;	
   margin: 10px;
}
header, footer, nav, aside {
  display: none;
}
</style>


</head>
<?  $meses = array('','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
    
    $hoy = date("Y-m-d");
    $diacorte = 16;
    $mes = date("m") +0 ;
    if($_POST['corte'] ==''){
      if(date("d") >= $diacorte ){
         $mes += 1 ;  
        }
      $_POST['corte'] = $meses["$mes"] ;
      }
    if($_POST[ano] == ''){ $_POST[ano] = date("Y");}
    $ancho = '780px';
    
    $fempresa = " AND EMPRESA = '".substr($_POST[empresa],4)."' ";
    $filtrosAP .= " AND COLABORADOR = '$_POST[colaborador]' ";
    $filtrosVA .= " AND CORTE = '$_POST[corte]' ";
    $filtrosPA .= " AND CORTE != '$_POST[corte]' ";
    
    if($_POST['colaborador'] != ''){
      $filtrosVA .= " AND COLABORADOR = '$_POST[colaborador]' ";
      }
    

	//registros por pag paginador
	$regsxpag = 50;
	
	if($_POST['paginador'] ==''){ $_POST['paginador'] = "1-$regsxpag"; }
	$limit = explode("-",$_POST['paginador']);
	$limit[0] = $limit[0]-1;
	$flimit = " LIMIT $limit[0],$limit[1] ";	

//print_r($arralm);
//echo $vendalm;

//subir desde archivo plano
if ( $_FILES['archivo']['size'] > 10  ){
  $nameA = explode('.', $_FILES['archivo']['name']); 
  if($_FILES['archivo']['size'] > 150000) { $errorA += 1; $errorAT .= ' No se permite subrir archivos mayores a 150 kb \n';}
  if(count($nameA) > 2){ $errorA += 1; $errorAT .= ' No se permite subir archivos de con mas de una extension \n'; }
  if($nameA[1] != "csv"){ $errorA += 1; $errorAT .= ' No se permiten archivos dferentes a .csv \n'; }

  if ( $errorA == 0  ){
     $file = $_FILES['archivo']; 
     $data = fopen ($file['tmp_name'], 'r');  
     $size = filesize($file['tmp_name']); 
     $content = fread($data, $size);
     $content = addslashes($content);
     fclose ($data); 

     $pycs = substr_count($content, ';');
     $cs = substr_count($content, ',');
     echo "ingreso 1";
     //echo "$pycs > $cs";
     if($pycs > $cs){ 
       $delim = ";";
       }else{
       $delim = ",";
       }
     $enclo ='"';  
     $nombre = "$_POST[ref].jpg"; 
     //copy($_FILES['archivo']['tmp_name'], "refimg/$nombre") or die ("no subio");
     $sql = "DELETE FROM rh_vale_vales_tmp 
             WHERE USER ='$_SESSION[usuARio]'
             ;";
     mysqli_query($mysqli, $sql);
     $sql = "LOAD DATA LOCAL INFILE '$file[tmp_name]' 
             INTO TABLE rh_vale_vales_tmp 
             FIELDS TERMINATED BY '$delim' 
             ENCLOSED BY '$enclo'
             LINES TERMINATED BY '\n'
             IGNORE 1 ROWS
             SET USER ='$_SESSION[usuARio]'
             ;";
     mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
     $_POST['subir'] = 'cargado' ;
     }else{
      echo '<script>alert("****** \n'.$errorAT.'")</script>';
     } 
}

//sube info CSV
if($_POST['subir'] == ''){
    /*$sql = "DELETE FROM rh_vale_vales_tmp 
            WHERE USER ='$_SESSION[usuARio]'
             ;";*/
    $sql = "DELETE FROM rh_vale_vales_tmp 
            WHERE USER =$_SESSION[usuARio]
             ;";
    mysqli_query($mysqli, $sql);
  }elseif($_POST['subir'] == 'subir'){
    $sql = "INSERT INTO rh_vale_vales
        (SELECT
          0 AS id
         , CODIGO
         , '$_POST[corte]'
         , '' AS PERIODO
         ,'$_POST[ano]'
         , COLABORADOR
         , (select EMPRESA FROM rh_vale_vales WHERE rh_vale_vales.CODIGO = rh_vale_vales_tmp.CODIGO ORDER bY id DESC LIMIT 0,1)
         , '' AREA
         , '' AS VALE
         , 0 AS CUOTAS
         , '$_POST[dtoN]'
         , VALOR * -1
         , '$hoy'
         , USER
         , '$_POST[obs]'
         FROM rh_vale_vales_tmp
         WHERE USER = '$_SESSION[usuARio]'
        )
        ";
   
       if($_POST['dtoN'] ==''){
         echo '<script>alert("****** \n Debe seleccionar un tipo de descuento")</script>';
         }else{
         mysqli_query($mysqli,$sql) or die('no cargo csv');
         }     
  }

//guarda vale nuevo
if($_POST['guardar'] != ''){ 
  if($_POST['dtoN'] ==''){ $errorN +=1 ; }
  if($_POST['vlrdtoN'] ==''){ $errorN +=1 ; }
  if($_POST['firmavale'] ==''){ $errorN +=1 ; }
  
  if($errorN > 0){
  $msjN = "<br>Diligencie TODOS los campos";
  }else{
  $sql = "SELECT CODIGO, AREA FROM rh_vale_vales WHERE COLABORADOR ='$_POST[colaborador]' limit 0,1 ";
  $result = mysqli_query($mysqli, $sql);
  while($row = mysqli_fetch_array($result)){
    $codigo = $row['CODIGO'];
    $area = $row['AREA'];
    }
    
    if($_POST[vlrdtoN] >0 ){$vlrdtoN = $_POST[vlrdtoN] * -1 ;}
    if($_POST[firmavale] =='NO' ){
      $maxnum_cuota = "'','0'";
      }else{
        $result = mysqli_query($mysqli,"SELECT MAX(VALE)+1 FROM rh_vale_vales");
        while($row = mysqli_fetch_array($result)){
        $maxnum = $row[0];
        }
      $maxnum_cuota = " '$maxnum', '$_POST[firmavale]' ";
      }
    
  $sql =" INSERT INTO rh_vale_vales 
               (
                CODIGO,
                CORTE,
                ANO ,
                COLABORADOR ,
                AREA ,
                EMPRESA ,
                VALE ,
                CUOTAS ,
                CONCEPTO ,
                VALOR ,
                FECHA ,
                USUARIO ,
                OBS
                )
                VALUES (
                '$codigo', '$_POST[corte]','$_POST[ano]','$_POST[colaborador]','$area','".substr($_POST[empresa],4)."'
                ,$maxnum_cuota,'$_POST[dtoN]'
                ,'$vlrdtoN', '$hoy','$_SESSION[usuARio]', '$_POST[obs]'
                ) ";
  mysqli_query($mysqli, $sql) or die(".................. NO GUARDO, CONTACTE AL ADMINISTRADOR DEL SISTEMA") ;
  echo "<script>alert('Datos almacenados con exito')</script>";
  $_POST['colaboradorH'] ='';
  
  }
}

//aplica descuentos
 if($_POST[aplicar] != ''){
  $aplicas = explode("|", $_POST[aplicar]);
  $errorCO = 0;
  $coma ='(';
  foreach($aplicas AS $concID){
    if($_POST["dtos$concID"]==''){$errorCO += 1; $color["$concID"] = 'RED'; }
    if($_POST["dtos$concID"] < 0 ){ $_POST["dtos$concID"] = $_POST["dtos$concID"] * -1; }
    //$corteap = $_POST['ano']."-".$_POST['corte'];
    $insertCO .= "$coma '$concID','".$_POST["dtos$concID"]."','$_SESSION[usuARio]','$hoy', ''";
    $coma = '),(';
  }
  $insertCO .= ")";
  
  if($errorCO == 0){echo $insertCO;
  mysqli_query($mysqli,"INSERT INTO rh_vale_vales_aplicados ( idvales, valor, usuario, fecha, corteap ) VALUES $insertCO ") or die(mysqli_error($mysqli)." no guardo ");
  } 
 
 }
//aplica saldos
 if($_POST[saldar] != ''){
  $aplicas = explode("|", $_POST[saldar]);
  $corteap = $_POST['ano']."-".$_POST['corte'];
  $errorCO = 0;
  $coma ='(';
  foreach($aplicas AS $concID){
    if($_POST["saldos$concID"]==''){$errorCO += 1; $color["$concID"] = 'RED'; }
    if($_POST["saldos$concID"] < 0 ){ $_POST["saldos$concID"] = $_POST["saldos$concID"] * -1; }
    if($_POST["saldos$concID"] > 0 ){
      $insertCO .= "$coma '$concID','".$_POST["saldos$concID"]."','$_SESSION[usuARio]','$hoy','$corteap'";
      $coma = '),(';
      }
  }
  $insertCO .= ")";
  echo $insertCO; 
  if($errorCO == 0){
  mysqli_query($mysqli,"INSERT INTO rh_vale_vales_aplicados ( idvales, valor, usuario, fecha, corteap ) VALUES $insertCO ") or die("no guardo");
  } 
 
 }
	
//validar si recarga 
    if($_POST['colaborador'] != $_POST['colaboradorH']){
      $colab = $_POST['colaborador'];
      $empresa = $_POST['empresa'];
      $corte = $_POST['corte'];
      $ano = $_POST['ano'];
      $_POST = array();
      $_POST['colaborador'] = $colab ;
      $_POST['empresa'] = $empresa;
      $_POST['corte'] = $corte;
      $_POST['ano'] = $ano;
      $_POST['vale'] = $maxnum;
      }

$dias = (strtotime("$_POST[hasta]")-strtotime("$_POST[desde]"))/86400 ;

//listas
$sql = "SELECT DISTINCT CONCEPTO FROM rh_vale_vales";
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_array($result)){
  $conceptos[] = $row[0];
  }        

// vale
//$_POST[vale] ='1';
$sql = "SELECT * FROM rh_vale_vales WHERE VALE = '$_POST[vale]' $fempresa ";
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_array($result)){
  $vale_vale = $row[VALE];
  $vale_fecha = $row[FECHA];
  $vale_colaborador = $row[COLABORADOR];
  $vale_empresa = $row[EMPRESA];
  $vale_usuario = $row[USUARIO];
  $vale_codigo = number_format($row[CODIGO],0,',','.');
  $vale_valor = $row[VALOR] * -1 ;
  $vale_cuota = $row[VALOR]/$row[CUOTAS] * -1 ;
  }
  
//SALDOS ANTERIORES
  $sql = "SELECT rh_vale_vales.ID, CONCEPTO, SUM(rh_vale_vales_aplicados.valor) AS APLICADO
          , VALE
          , rh_vale_vales.FECHA
          , rh_vale_vales.VALOR
          , OBS
          , (SELECT GROUP_CONCAT( DISTINCT CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id
              ) AS PAGOS  
          FROM rh_vale_vales INNER JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID 
          WHERE 1 = 1 
          AND corteap = '$_POST[ano]-$_POST[corte]'
          $fempresa
          $filtrosVA 
          GROUP BY rh_vale_vales.ID 
          HAVING (MAX(rh_vale_vales.VALOR) + SUM(rh_vale_vales_aplicados.valor)) != 0
          ORDER BY CONCEPTO";
  
  $result = mysqli_query($mysqli, $sql); //echo $sql;
  while($row = mysqli_fetch_array($result)){
    $concID = $concID += 1;
    $saldos["$concID"] = '';
    $saldoAPL["$concID"] = $row["APLICADO"];
    $saldoscon["$concID"] = $row["CONCEPTO"];
    $saldosT += $row["APLICADO"];
    //if(){}
    $saldosobs["$concID"] = date("M-d",strtotime("$row[FECHA]"))."$row[FECHA] por $".$row[VALOR]."
  ".$row["OBS"]."
  Pagos:
  ".$row[PAGOS];
  }
  
  $sql = "SELECT rh_vale_vales.ID, CONCEPTO, MAX(rh_vale_vales.VALOR) + SUM(rh_vale_vales_aplicados.valor) AS SALDO  
          , OBS
          , GROUP_CONCAT( DISTINCT CONCAT( rh_vale_vales_aplicados.fecha, ': $', rh_vale_vales_aplicados.valor )
               ORDER BY rh_vale_vales_aplicados.fecha ASC
               SEPARATOR ' \n ' )
              AS PAGOS
          FROM rh_vale_vales INNER JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID 
          WHERE 1 = 1 $fempresa $filtrosAP 
          GROUP BY rh_vale_vales.ID 
          HAVING (MAX(rh_vale_vales.VALOR) + SUM(rh_vale_vales_aplicados.valor)) != 0
          ORDER BY CONCEPTO";
  
  $result = mysqli_query($mysqli, $sql); //echo $sql;
while($row = mysqli_fetch_array($result)){
  $concID = $row["ID"];
  $saldos["$concID"] = $row["SALDO"];
  $saldoscon["$concID"] = $row["CONCEPTO"];
  if($_POST["saldos$concID"] == '' ){ 
    $_POST["saldos$concID"] = $row["SALDO"] * -1 ; 
    }
  $saldosT += $_POST["saldos$concID"];
  
  $saldosobs["$concID"] = $row["OBS"]."
  Pagos:
  ".$row[PAGOS];

  }
//DESCUENTOS
if($_POST['colaborador'] !=''){
  $sql = "SELECT 
            ID, CONCEPTO, VALOR 
            ,IFNULL((SELECT SUM(valor) FROM rh_vale_vales_aplicados WHERE idvales = rh_vale_vales.ID AND corteap = ''), 'NA' ) AS APLICADO
            ,VALE
            ,OBS
            ,(SELECT GROUP_CONCAT( DISTINCT CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id
              ) AS PAGOS 
          FROM rh_vale_vales WHERE 1 = 1 $fempresa $filtrosVA ORDER BY CONCEPTO";
  }else{
  $sql = "SELECT rh_vale_vales.ID, CONCEPTO, IFNULL(sum(rh_vale_vales.VALOR),'0') as VALOR, SUM(rh_vale_vales_aplicados.valor) AS APLICADO  
          FROM rh_vale_vales LEFT JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID WHERE 1 = 1 $fempresa $filtrosVA GROUP BY CONCEPTO ORDER BY CONCEPTO";
  }
$result = mysqli_query($mysqli, $sql); //echo $sql;
while($row = mysqli_fetch_array($result)){
  $concID = $row["ID"];
  $dtos["$concID"] = $row["VALOR"];
  $conceptos["$concID"] = $row["CONCEPTO"];
  $aplicados["$concID"] = $row["APLICADO"];
  $vale["$concID"] = $row["VALE"];
  $obs["$concID"] = $row["OBS"]."
  Pagos:
  ".$row[PAGOS];
  
  $_POST["conc$concID"] = $row["ID"] ;
  
  if($_POST["dtos$concID"] == '' AND $row["APLICADO"] == 'NA' ){ 
    $_POST["dtos$concID"] = $row["VALOR"] * -1 ; 
    }
  
  if($row["APLICADO"] != 'NA'){
    $dtosT += $row["APLICADO"];
    }  
  
  $dtosT += $_POST["dtos$concID"];
  
  }        

//PAGOS
$sql = "SELECT CONCEPTO, SUM(VALOR) AS VALOR FROM rh_vale_pagos WHERE 1 = 1 $fempresa $filtrosVA GROUP BY CONCEPTO";
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_array($result)){
  $CONCEPTO = $row["CONCEPTO"];
  $pagos["$CONCEPTO"] = $row["VALOR"];
  
  $pagosT += $row["VALOR"];
  } 	

$totalT = $pagosT - $dtosT - $saldoT; 		
?>
<body class="global" bgcolor="white" <?= $autoprint?> >
<form id="movse1" action="vales.php" method="post" name="submit button1" enctype="multipart/form-data">
<table class="frs" align="center" height="99%""" width="100%" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0"> 
<tr>
<td align="center" valign="top" style="width:<?= $ancho?> ; background-color:white; height: 176px; border-color:white;">

<?
if($_POST['vale'] != ''){ 
$nover  = "nover";
for($repitis = 1 ; $repitis <= 2 ; $repitis++ ){
if($repitis == 2){ $noverp ='noverp'; $dashed ="border-top:thin; border-top-style:dashed;"; } 
?>
  <table class="<?= $noverp?>" style="width:21.5cm; <?= $dashed?>">
    <tr>
      <td align="center" valign="middle" style="height:13.5cm; "> 
        <div style="width:17.5cm; height:11cm; border-style:groove; border-width:medium; margin-right: 5mm; margin-left: 5mm;">
           <br>
           <p class="frl" align="center">
           <b style="font-size:x-large" >AUTORIZACION DE DESCUENTO
           <br>
           No. <font color="red"><?= $vale_vale?></font>
           </b>
           </p>
           <p align="justify" style="font-size: medium">
           Fecha : <b><?= $vale_fecha ?></b>
           <br>
           <b><?= $vale_colaborador?></b> mayor de edad, identificado con cedula de ciudadanía No. <b><?= $vale_codigo?></b> AUTORIZO a la empresa <b><?= $vale_empresa?></b>
           a descontar de mi salario mensual la suma de <b>$<?= number_format($vale_cuota,0,',','.')?></b> hasta completar la suma total de <b>$<?= number_format($vale_valor,0,',','.')?></b> 
           <br>
           <br>
           </p>
           <p align="justify" style="font-size: small">
           Igualmente autorizo a que el saldo que en cualquier momento se encuentre en mi contra por este concepto, sea descontado de mis cesantías
           , prima de servicios, vacaciones, salarios, bonificaciones, indemnizaciones, beneficios extralegales y en general cualquier concepto
           que deba cancelarme la empresa.
           </p>
           <p align="justify" style="font-size:medium">
           <br>
           EL TRABAJADOR
           <br>
           <br>
           ____________________________
           <br>
           <?= $vale_colaborador?>
           <br>
           c.c. <?= $vale_codigo?>
           </p>
           <p align="right" style="font-size:xx-small">
           elab <?= $vale_usuario." imp ".$hoy." ".$_SESSION[usuARio] ?>
           </p> 
        </div>
      </td>
    </tr>
  </table>
<? } //finrepitis
} // finif vale ?>  
<div class="<?= $nover?> aut" style="width:100%; height:100%">

<a class="frl" style="font-weight:bolder; font-size:20px">
<br><u><? echo $_POST['vendedor']; ?></u>
</a>
<a class="frl" style="font-weight:bolder; font-size:16px">
<br>INFORME DE DESCUENTOS <?= strtoupper($_POST['colaborador'])?>
<br>CORTE <?= $_POST['corte']?>, <?= $_POST['ano']?>
<?= $cuotasmsg?>
</a>
<table align="center" class="frm" border="1" cellspacing="0" style="width:21.5cm;" >
  <tr>
    <th class="frl" colspan="3">Liquidacion (A abonar) - (Saldo ant) - (Dto este 
	corte)<br/>$ <?= number_format($totalT)?> </th>
  </tr>
  <tr bgcolor="">
    <th style="width:33%; height: 16px;">Saldo anterior $<?= number_format($saldosT)?></th>
    <th style="width:34%; height: 16px;">Dto Este Corte $<?= number_format($dtosT)?></th>
    <th style="width:33%; height: 16px;">A Abonar $<?= number_format($pagosT)?></th>
  </tr>
  <tr>
    <td valign="top">
      <table class="frm" width="100%" cellspacing="0">
        <tr>
          <th></th>
          <th>Saldo </th>
          <th>Aplicado</th>
        </tr>
        <?
        
        foreach($saldos AS $id => $valor){
           
          if($color == ''){$color ='lightgrey';}else{$color ='';}
          echo "<tr bgcolor='$color'>
                  <td style='width:45%' ><a title=' $saldosobs[$id] -'>$saldoscon[$id]</td>
                  <td style='width:27%' align='right'>
                    ".number_format($valor)."</td>
                  <td style='width:28%' align='right'>  
                    "; 
              
              if($saldoAPL[$id] ==''){
              $arrSAL[] = $id;
              echo "<input class='frs' type='number' name='saldos$id' id='saldos$id' value='".$_POST["saldos$id"]."' style='width:100%; text-align:right;'>
                    <input class='frs' type='hidden' name='saldoscon$id' id='saldoscon$id' value='".$saldoscon[$id]."' >";
                }else{
                  echo number_format($saldoAPL[$id]);
                }          
                    
            echo "</td>
                </tr>";
    
        }
       
        ?>
      </table>
      <br/>
      <?
        if($_POST['colaborador'] =='' OR count($arrSAL) < 1){
        //nada
        }else{      
      ?>
      Aplicar Saldo: 
      <input onclick="this.form.submit();" type="checkbox" value="<?= implode('|',$arrSAL)?>" id="saldar" name="saldar" style="height:20px; width:20px;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   	  <input onClick="this.form.submit();" id="sdas" name="botonref1" class="verloader frm boton" value=" Calcular " type="button" >
      <br/>
        <? } // finif?>
    </td>
    <td valign="top">
      <table class="frm" width="100%" cellspacing="0">
        <tr>
          <th>(<input type="radio">= vale)</th>
          <th></th>
          <th>Generado</th>
          <th>Aplicado</th>
        </tr>
        <?
        
        foreach($dtos AS $id => $valor){
           
          if($color == ''){$color ='lightgrey';}else{$color ='';}
          $concsha1 = sha1($conc);
          
          if($vale[$id] != ''){
            $valeR = "<input title='Nro : $vale[$id]' onclick='this.form.submit()' type='radio' id='vale' name='vale' value='$vale[$id]' >";
            }else{
            $valeR = "";
            }
          echo "<tr bgcolor='$color'>
                  <td style='width:45%' ><a title=' $obs[$id] -'>$conceptos[$id]</a></td>
                  <td style='width:5%' align='right'>$valeR
                  <td style='width:25%' align='right'>
                    ".number_format($valor)."</td>
                  <td style='width:25%' align='right'>  
                    "; 
          if($aplicados[$id] =='NA'){
              $arrCONC[] = $id;
              echo "<input class='frs' type='number' name='dtos$id' id='dtos$id' value='".$_POST["dtos$id"]."' style='width:100%; text-align:right;'>
                    <input class='frs' type='hidden' name='conc$id' id='conc$id' value='".$conceptos[$id]."' >";
          }else{
              echo number_format($aplicados[$id]);
          }          
                    
            echo "</td>
                </tr>";
        }
       
        ?>
      </table>
      <br/>
      <?
        if($_POST['colaborador'] =='' OR count($arrCONC) < 1){
        //nada
        }else{      
      ?>
      Aplicar Dto : 
      <input onclick="this.form.submit();" type="checkbox" value="<?= implode('|',$arrCONC)?>" id="aplicar" name="aplicar" style="height:20px; width:20px;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   	  <input onClick="this.form.submit();" id="sdas" name="botonref1" class="verloader frm boton" value=" Calcular " type="button" >
      <br/>
        <? } // finif?>      
    </td>
    <td valign="top">
      <table class="frm" width="100%">
        <?
        foreach($pagos AS $conc => $valor){
        if($color == ''){$color ='WhiteSmoke';}else{$color ='';}
        echo "<tr bgcolor='$color'>
                <td>$conc</td>
                <td align='right'>".number_format($valor)."</td>
              </tr>";
        }
        
        ?>
      </table>
    </td>
  <tr>
    <td class="frl" align="right">
      Nuevo Dto/Vale :  
    </td>
    <td align="center">
        <?
        if($_POST['colaborador'] ==''){ echo "<font color='darkred'>Para nuevo vale debe seleccionar un colaborador</font>";
        }else{
        ?>
        <table class="frm" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <font color='red'><?= $msjN?></font>
              <br>
              <select class="frm" name="dtoN" id="dtoN" style="width:100%; border-color:<?= $colorN['DN']?>">
              <?
              echo "<option>$_POST[dtoN]</option>";
              if($_POST['dtoN'] != ''){echo "<option>$_POST[dtoN]</option>";}
              foreach($conceptos AS $valor){
              echo "<option>$valor</option>";
              }
              ?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              Valor $<input class="frm" type="number" min="1" step="1" name="vlrdtoN" id="vlrdtoN" value="<?= $_POST['vlrdtoN']?>" style="width:30%; height:30px; border-color:<?= $colorN['VDN']?>">
              Firma Vale: <select class="frm" name="firmavale" id="firmavale" style="width:26%; border-color:red<?= $colorNe['FV']?>" >
                            <?
                            echo "<option>$_POST[firmavale]</option>";
                            if($_POST[firmavale] != 'NO'){echo "<option>NO</option>";}
                            echo "<optgroup label='Cuotas'>";
                            for( $i =1 ; $i < 36 ; $i++){ 
                              echo "<option>$i</option>";
                              }
                            echo "</optgroup>";
                            ?>
                            
                          </select>
            </td>
          </tr>
          <tr>
            <td align="center">
            Obs:<textarea id="obs" name="obs" rows="2" style="width:85%"><?= $_POST['obs']?></textarea>
            </td>
          </tr>
          <tr>
            <td align="center" style="height: 20px">
              Guardar : <input onclick="this.form.submit();" type="checkbox" value="guardar" id="guardar" name="guardar" style="height:20px; width:20px;">
            </td>
          </tr>
        </table>
        <? } //finif ?>
    </td>
    <td></td>
  <? if($_POST['colaborador'] !=''){ 
       echo "<tr>
                <td></td>
                <td align='center'><font color='darkred'>Para subir archivo debe quitar el filtro de Colaborador</font></td>
                <td></td>
                </tr>";
        }else{
  ?>      
  <tr>  
    <td></td>
    <td>Subir archivo <input onchange="this.form.submit()" type="file" id="archivo" name="archivo" class="frm Aabs"  maxlength="15" tabindex="5" value="10"></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3">
    <? if($_POST['subir'] !=''){ ?>
      <div class="aut" style="width:100%; height:8cm" align="center">
        <table class="frm">
        <tr>
          <th style="height: 17px">CEDULA</th>
          <th style="height: 17px">COLABORADOR</th>
          <th style="height: 17px">VALOR</th>
          <th style="height: 17px">VALIDACION DATOS</th>
        </tr>
        <?
        $sql = "SELECT trim(CODIGO)
                     , trim(COLABORADOR)
                     , trim(VALOR)
                     , (SELECT IFNULL( MAX( COLABORADOR ) , 'ne' ) FROM rh_vale_vales WHERE rh_vale_vales.CODIGO = rh_vale_vales_tmp.CODIGO)
                     FROM rh_vale_vales_tmp
                     WHERE USER ='$_SESSION[usuARio]'
                     ORDER BY COLABORADOR";
        $result = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_array($result)){
        echo "<tr>
                <td>$row[0]</td>
                <td>$row[1]</td>
                <td>$row[2]
                ";
        
        $txtnombre ='';
        if($row[3] == 'ne'){ 
          $txtnombre ="<font color='green'>Nueva C.C. se creara el colaborador</font>";
          }else{
          $nombreBD = explode(" ",$row[3]);
          $nombreCSV = explode(" ",$row[1]);
          $noest = array_diff($nombreBD,$nombreCSV);
          
          $difnom = count($nombreBD)-count($noest);
          
          if( $difnom <= 1 ){
            $errorCSV += 1;
            $txtnombre ="<font color='red'>ERROR Nombre diferente al registrado:$row[3]</font>";
            }elseif( $difnom == 2 and count($nombreBD) != 2 ){
            $alertCSV += 1;
            $txtnombre ="<font color='DarkOrange'>Alerta</font> Verifique nombre, registrado:$row[3]";
            }else{
            $txtnombre ="ok";
            }
          
          }
        $ced = $row[0]+0 ;$val = $row[2]+0;  
        if(ctype_digit($ced)){}else{ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR la cedula solo puede tener numeros</font>"; }
        if(ctype_digit($val)){}else{ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR el valor debe ser positivo, sin decimales y sin puntos de miles.</font>"; }  
        if($val == 0){ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR el valor no puede ser 0</font>"; }
        echo "<td>$txtnombre</td>
            </tr>";
       $valT += $row[2];
       $colT += 1;     
       }
       ?>
        </table>
      </div>
      <br>
      <div class="frm" align="center">
      <?
      if($errorCSV == 0){
      
      echo "<br><select class='frm' name='dtoN' id='dtoN' style='width:30%; border-color:$colorN[DN]'>";
              
      echo "<option>$_POST[dtoN]</option>";
      if($_POST['dtoN'] != ''){echo "<option>$_POST[dtoN]</option>";}
        foreach($conceptos AS $valor){
          echo "<option>$valor</option>";
          }
      echo "</select>";
              
      echo "<br>
            <br>
            CONFRIMAR DATOS
            <br>
            Colaboradores: <b>$colT</b> , valor total $".number_format($valT,0,',','.')."
            <font color='DarkOrange'>Alertas: $alertCSV</font>
            <br>
            Subir datos : <input onclick='this.form.submit();' type='checkbox' value='subir' id='subir' name='subir' style='height:20px; width:20px;'>
            ";
      }else{
      echo "<font color='red'>
            <br>
            OJO!!!!
            <br>
            PARA PODER GUARDAR
            <br>
            DEBE CORREGIR <u> $errorCSV </u> ERRORES
            <br> .
            </font>";
      }
      ?>
      
      
      </div>
     <? } //finif subir?> 
    </td>
  </tr>
  <?
  } //fin if archivo o vale
  ?>
</table>
</div>
</td>
<td class="nover" align="center" valign="top" width="22%" style="height: 176px">
<table class="frm"  style="width:95%" >
<tr>
	<td align="center" valign="top" style="border-style:groove;">
	<table class="frm"  style=" width:95%" >
		<tr>
			<td>
				Empresa
			</td>
			<td>: 
				
	    		<select onchange="this.form.submit();" id="empresa" class="frm campo" name="empresa" tabindex="2" >
        		<option><?= $_POST['empresa']?></option>
        		<?
        		foreach($_SESSION['empresA'] as $emp){
        		if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        		}
        ?> 
       </select>

			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td> 
				Corte
			</td>
			<td>
				: <select id="corte" name="corte" class="frm campo afil" type="text">
				   <?
				   foreach($meses AS $mes){
				   if($_POST['corte'] == $mes ){ $selected ="selected";}else{$selected ="";}
				   echo "<option $selected>$mes</option>";
				   }
				   ?>
				   
				    
				  </select> 
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td> 
				Año
			</td>
			<td>
				: <input id="ano" name="ano" class="frm campo Aabs" value="<?= $_POST['ano']?>" type="text" >
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td> 
				Colaborador
			</td>
			<td><input type="hidden" id="colaboradorH" name="colaboradorH" value="<?= $_POST['colaborador']?>">
				: <select onchange="this.form.submit();" id="colaborador" name="colaborador" class=" verloaderB frm campo"  >
					<option ><?= $_POST['colaborador']?></option>
					<option value="">Quitar filtro</option>
					<?
					$sql = "SELECT DISTINCT COLABORADOR, CODIGO FROM rh_vale_vales WHERE 1 = 1 $fempresa ";
					$result = mysqli_query($mysqli, $sql);
					while($row = mysqli_fetch_array($result)){
					echo "<option value='$row[0]' >$row[0] - $row[1]</option>";
					}
					?>

					
					
			
				  </select>			
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="height: 17px"> 
				<br>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"> 
				<input onClick="this.form.submit();" id="sdas" name="botonref1" class="verloader frm boton" value=" Ver " type="button" >
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<br>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"> 
				<input type="button" class="frm boton" value=" Imprimir " onClick="javascript:window.print()" /> 
			</td>
		</tr>
	</table>
		 
		
		
	    <br><br>
	    
	</td>
</tr>
</table>

<!--
</form>
<form id="movse2" action="0csv.php" method="post" name="submit button2">
-->
<table class="frm"  style="width:95%" >
<tr>
	<td align="center">
	<input id="cons" name="cons" type="hidden" value="<?= $sqlp?>">
	<input onclick="this.form.submit();" type="button" style="background-image:url('../../images/excel.png'); background-color:white; background-position:center; background-repeat:no-repeat; width:60px; height:60px">
	</td>
</tr>

</table>
 
</form> 
</body>
</html>
