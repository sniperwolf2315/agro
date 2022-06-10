<? session_start();
/*mvariables de conexion*/
$sesionadmin = false;
$autorizados = array('OYUELAL','PEREZD','NINOM');

if( in_array( $_SESSION[usuARio], $autorizados) ){
  $autorizado = 'si';
  }
 
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


$TMP = "_tmp";
$tabla='rh_vale_vales';
if(empty($_POST['molonom'])){
    $tipo_area="MOLECULA";
}else{
    $tipo_area=$_POST['molonom'];
}

$fempresa=trim($_POST['empresa']);
//echo '<script>alert("****** \n'.$fempresa.'")</script>';

//echo '<script>alert("****** \n'.$x.'")</script>';
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
    
    $(".select").select2(); 
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
<?  
    $meses = array('','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
    
    $hoy = date("Y-m-d");
    $diacorte = 16;
    $mes = date("m") +0 ;
    $ano = date("Y") +0 ;
    //periodo actual
    if(date("d") >= $diacorte ){
         $mes += 1 ;
         if($mes == 13){
         $mes = 1;
         $ano +=1;
         }  
        }
      $mes_1 = $mes - 1 ;
      if( $mes_1 == 0){ $mes_1 = 12; }
      $periodoACTUAL =  $meses["$mes_1"]."-".$meses["$mes"]." ".$ano;
    
    //periodo vencido
    $mesV = $mes -1;
    $mesV_1 = $mes_1 -1;
    $anoV = $ano ;
    if( $mesV == 0){ $mesV = 12; $anoV = $ano -1; }
    if( $mesV_1 == 0){ $mesV_1 = 12; }
    $periodoVENCIDO =  $meses["$mesV_1"]."-".$meses["$mesV"]." ".$anoV; 
    
    if($_POST['molonom'] ==''){
      $_POST['molonom'] =  'MOLECULA';
      }
    //realiza la validaci� si es molecula o nomina
    function cambiar_tipo(){
        if($_POST['molonom'] =='NOMINA'){
          $lineColor = "border-color:blue;";
          $molonomINV = 'MOLECULA';
        }else{
          $molonomINV = 'NOMINA';
        }
    }
  
    if($_POST['periodo'] ==''){
      $_POST['periodo'] =  $periodoACTUAL;
      }
    
    if($_POST['periodo'] == $periodoACTUAL){
    $periodoACT = 'si' ;
    }else{
    $periodoACT = 'no' ;
    }
    
    if($_POST['periodo'] == $periodoVENCIDO){
    $periodoVEN = 'si' ;
    }else{
    $periodoVEN = 'no' ;
    }
    
    $periodoARR = explode(" ",$_POST['periodo']);
    $_POST[ano] = trim($periodoARR[1]);
    $periodoARR = explode("-",$periodoARR[0]);
    $_POST[corte] = trim($periodoARR[1]);
    
    $ancho = '780px';
    //$fempresa = AND EMPRESA = 
    //$fempresaTipo = EMPRESA =  AND TIPO  
    $fempresa = " AND EMPRESA = '".substr($_POST[empresa],4)."' ";
    $fempresaTipo = " EMPRESA = '".substr($_POST[empresa],4)."' AND TIPO = '$_POST[molonom]' ";
    
    $filtrosAP .= " AND COLABORADOR = '$_POST[colaborador]' ";
    $filtrosVA .= " AND CORTE = '$_POST[corte]' AND ANO = '$_POST[ano]' ";
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
foreach($_FILES AS $ke => $va){
  if($va[size] > 0){
  $archivo = $ke;
  //$TMP = "_tmp";
  }
}
//ingresan los datos a la tabla temporal paso 1 carga archivo (Subir archivo descuentos)  
if ( $_FILES["$archivo"]['size'] > 10  ){
  $nameA = explode('.', $_FILES["$archivo"]['name']); 
  if($_FILES["$archivo"]['size'] > 150000) { $errorA += 1; $errorAT .= ' No se permite subrir archivos mayores a 150 kb \n';}
  if(count($nameA) > 2){ $errorA += 1; $errorAT .= ' No se permite subir archivos de con mas de una extension \n'; }
  if($nameA[1] != "csv"){ $errorA += 1; $errorAT .= ' No se permiten archivos dferentes a .csv \n'; }
  if ( $errorA == 0  ){
    
     $file = $_FILES["$archivo"]; 
     $data = fopen ($file['tmp_name'], 'r');  
     $size = filesize($file['tmp_name']); 
     $content = fread($data, $size);
     $content = addslashes($content);
     fclose ($data); 

     $pycs = substr_count($content, ';');
     $cs = substr_count($content, ',');
     
     //echo "$pycs > $cs";
     if($pycs > $cs){ 
       $delim = ";";
       }else{
       $delim = ",";
       }
     $enclo ='"';  
     $nombre = "$_POST[ref].jpg"; 
     
     //seleciona tabla destino de acuerdo al archvo subido
     if($archivo =='archivoV'){ $tabla = "rh_vale_vales"; }
     if($archivo =='archivoM'){ $tabla = "rh_vale_pagos"; }
     
     /*$sql = "DELETE FROM $tabla$TMP 
             WHERE USER ='$_SESSION[usuARio]'
             ;";*/
      
     $sql = "DELETE FROM $tabla$TMP 
             WHERE USER ='$_SESSION[usuARio]';";
             
     mysqli_query($mysqli, $sql);
     $sql = "LOAD DATA LOCAL INFILE '$file[tmp_name]' 
             INTO TABLE $tabla$TMP
             FIELDS TERMINATED BY '$delim' 
             ENCLOSED BY '$enclo'
             LINES TERMINATED BY '\n'
             IGNORE 1 ROWS
             SET USER ='$_SESSION[usuARio]'
             ;";
     mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
     
     //realiza la busqueda por codigo o colaborador
     $sql= "SELECT CODIGO, COLABORADOR FROM $tabla$TMP";
     $result = mysqli_query($mysqli, $sql);
     while($row = mysqli_fetch_array($result)){
     mysqli_query($mysqli, "UPDATE $tabla$TMP SET COLABORADOR = '".utf8_encode(strtoupper($row[1]))."' WHERE CODIGO = '$row[0]'") or die(mysqli_error($mysqli));
     }
     
     $_POST['subir'] = 'cargado' ;
     $_POST['archivoX'] = $tabla ;
     }else{
      echo '<script>alert("****** \n'.$errorAT.'")</script>';
     } 
}


//sube info del archivo CSV
if($_POST['archivoX']){
  $tabla = $_POST['archivoX'];
  //$TMP = "_tmp";
  //echo '<script>alert("****** \n'.$errorAT.'")</script>';
}
//valida archivo csv en la tabla tmp y tabla real.
if($_POST['subir'] == ''){
    $sql = "DELETE FROM $tabla$TMP 
            WHERE USER ='$_SESSION[usuARio]'
             ;";
    mysqli_query($mysqli, $sql);
  }elseif($_POST['subir'] == 'subir'){
    $empresaCSV = explode('- ',$_POST['empresa']);
    //realiza la validacion entre las 2 tablas.
    mysqli_query($mysqli, "UPDATE $tabla$TMP A 
                   INNER JOIN $tabla B ON A.codigo = B.codigo 
                   SET A.COLABORADOR = B.COLABORADOR") or die(mysqli_error($mysqli));
    //campos para vales
    if($tabla =='rh_vale_vales'){
    $campos = "0 AS id, CODIGO, '$_POST[corte]', '' AS PERIODO,'$_POST[ano]', COLABORADOR, '$empresaCSV[1]', '' AREA
               , '' AS VALE,'' AS PREFIRMADO, 0 AS CUOTAS, '$_POST[dtoN]', VALOR * -1, '$hoy', USER, OBS,'$_POST[molonom]'";
    }
    //campos para pagos
    if($tabla =='rh_vale_pagos'){
    $campos = "0 AS id, CODIGO, '$_POST[corte]', '' AS PERIODO,'$_POST[ano]', COLABORADOR, '$empresaCSV[1]', AREA
               , OBS, VALOR, '$hoy', USER";
    }
    //inserta los datos a la tabla temporal.
    $sql ="";
    /*$sql = "INSERT INTO $tabla
        (SELECT
          $campos
         FROM $tabla$TMP
         WHERE USER = '$_SESSION[usuARio]'
        )
        ";*/
        
        //consultas realizadas a la base
        $tipo1=$_POST['molonom'];
        $codigo="";
        $colaborador="";
        $valor="";
        $obs="";
        $user="";
        require_once("user_con.php");
        $sqlaux="SELECT * FROM rh_vale_vales_tmp";
         //$resultado2 = mssql_fetch_array($sqlaux);
         $result = mysqli_query($mysqli, $sqlaux);
        while($row = mysqli_fetch_array($result)){
                if($result){
                $codigo = $row['CODIGO'];      
                $colaborador=$row['COLABORADOR'];//$resultado2["colaborador"];
                $valor=$row['VALOR'];//$resultado2["valor"];
                $obs=$row['OBS'];//$resultado2["obs"];
                $user=$row['USER'];//$resultado2["user"];  
                
                //INSERTA
                $sql = "INSERT INTO $tabla (codigo,corte,periodo,ano,colaborador,empresa,area,vale,prefirmado,cuotas,cuota,concepto,valor,fecha,usuario,obs,tipo) 
                VALUES('$codigo','$_POST[corte]','','$_POST[ano]','$colaborador','$empresaCSV[1]','','','','0','0','$_POST[dtoN]','15000','$hoy','$_SESSION[usuARio]','$obs','$tipo_area')";
                mysqli_query($mysqli,$sql );   
                }   
            }
            
            $sql = "DELETE FROM $tabla$TMP 
                  WHERE USER ='$_SESSION[usuARio]'
                  ;";
            mysqli_query($mysqli, $sql);
            
        //$sele='{select colaborador from $tabla$TMP}';
        //
       
        
        
        // validacion cuando (Subir archivo descuentos) no tiene tipo de descuento (Carga masiva)
       if($_POST['dtoN'] =='' AND $tabla =='rh_vale_vales' ){
         echo '<script>alert("****** \n Debe seleccionar un tipo de descuento")</script>';
         $sql = "";
         }
       // valdia si se presenta error en la carga del archivo
       if($sql != ""){  
           mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli).'no cargo csv');
         
           $sql = "DELETE FROM $tabla$TMP 
                  WHERE USER ='$_SESSION[usuARio]'
                  ;";
           mysqli_query($mysqli, $sql);
         }     
  }


//ACCIONES SOBRE VALES: borra o inviente tipo de vale
/*for($i = 1; $i <= 1; $i++){ //$_POST['contDTOS']
echo '<script>alert("******\n ")</script>';
  if($_POST["acciones$i"]){
    $acciones = explode("|", $_POST["acciones$i"]);
    
    if($acciones[1] =='Cambiar'){
    ?>
    <script> if(confirm('****** \n Confirma: <?= $acciones[1]?> a <?= $acciones[2]?> \n <?= $acciones[3]?>')){
               <?
               mysqli_query($mysqli,"UPDATE rh_vale_vales SET TIPO = '$acciones[2]' WHERE id = $acciones[0] ") 
               ?>
               }else{
               alert('No cambiaste nada');
               } 
    </script>
    <?
    
    }
  }
}
*/

//guarda vale nuevo desde la plantalla
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
    $valeOpre = "VALE";
    if($_POST[vlrdtoN] >0 ){$vlrdtoN = $_POST[vlrdtoN] * -1 ;}
    if($_POST[firmavale] =='NO' ){
      $maxnum_cuota = "'NO-FIRMA','0'";
      $maxnum2 = "NO-FIRMA";
      $cuotas = "0";
      }elseif($_POST[firmavale] =='PRE-FIRMADO'){
        $valeOpre = "PREFIRMADO";
        $maxnum = $_POST[valeNroN];
        $maxnum_cuota = " '$_POST[valeNroN]', '1' ";
        $maxnum2 = "$_POST[valeNroN]";
        $cuotas = "1";
        }else{
          $result = mysqli_query($mysqli,"SELECT MAX(cast(VALE as signed))+1 FROM rh_vale_vales");
          while($row = mysqli_fetch_array($result)){
            $maxnum = $row[0];
            }
         $maxnum_cuota = " '$maxnum', '$_POST[firmavale]' ";
         $maxnum2 = "$maxnum";
         $cuotas = "$_POST[firmavale]";
        }
    if($cuotas >= 1 AND $cuotas <= 999){
    
    $cuota = number_format(($_POST[vlrdtoN]/$cuotas)/100,0,'','')*100;
    }  

  $sql =" INSERT INTO rh_vale_vales 
               (
                CODIGO,
                CORTE,
                ANO ,
                COLABORADOR ,
                AREA ,
                EMPRESA ,
                $valeOpre ,
                CUOTAS ,
                CUOTA ,
                CONCEPTO ,
                VALOR ,
                FECHA ,
                USUARIO ,
                OBS ,
                TIPO
                )
                VALUES (
                '$codigo', '$_POST[corte]','$_POST[ano]','$_POST[colaborador]','$area','".substr($_POST[empresa],4)."'
                ,'$maxnum2','$cuotas','$cuota','$_POST[dtoN]'
                ,'$vlrdtoN', '$hoy','$_SESSION[usuARio]', '$_POST[obs]', '$_POST[molonom]'
                ) ";
    
  mysqli_query($mysqli, $sql) or die(".................. NO GUARDO, CONTACTE AL ADMINISTRADOR DEL SISTEMA"); // $sql".mysqli_error($mysqli)) ;
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
  
  if($errorCO == 0){//echo $insertCO;
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
    if($_POST["saldos$concID"] >= 0 ){
      $insertCO .= "$coma '$concID','".$_POST["saldos$concID"]."','$_SESSION[usuARio]','$hoy','$corteap'";
      $coma = '),(';
      $_POST["saldos$concID"] ='';
      }
  }
  $insertCO .= ")";
  //echo $insertCO; 
  if($errorCO == 0){
  mysqli_query($mysqli,"INSERT INTO rh_vale_vales_aplicados ( idvales, valor, usuario, fecha, corteap ) VALUES $insertCO ") or die("<br><br>$insertCO<br>no guardo");
  } 
 
 }
	
//validar si recarga 
    if($_POST['colaborador'] != $_POST['colaboradorH']){
      $colab = $_POST['colaborador'];
      $empresa = $_POST['empresa'];
      $corte = $_POST['corte'];
      $ano = $_POST['ano'];
      $periodo = $_POST['periodo'];
      $molonom = $_POST['molonom'];
      $_POST = array();
      $_POST['colaborador'] = $colab ;
      $_POST['empresa'] = $empresa;
      $_POST['corte'] = $corte;
      $_POST['ano'] = $ano;
      $_POST['vale'] = $maxnum;
      $_POST['periodo'] = $periodo;
      $_POST['molonom'] = $molonom;
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
if($_POST[vale]){
  if(substr($_POST[vale],0,2) =='PF'){
    $_POST[vale] = substr($_POST[vale],2);
    $valeOpre ='PREFIRMADO';
    $pf ="PF";
    }else{
    $valeOpre ='VALE';
    }
  }
/*require_once("user_con.php");
        $sqlaux="SELECT * FROM rh_vale_vales_tmp";
         //$resultado2 = mssql_fetch_array($sqlaux);
         $result = mysqli_query($mysqli, $sqlaux);
        while($row = mysqli_fetch_array($result)){
                if($result){
                $codigo = $row['CODIGO']; */  
  
require_once("user_con.php");
$sql = "SELECT * FROM rh_vale_vales WHERE $valeOpre = '$_POST[vale]' $fempresa ";
$result = mysqli_query($mysqli, $sql);
while($row = mysqli_fetch_array($result)){
  $vale_vale = $pf.$row["$valeOpre"];
  $vale_fecha = $row[FECHA];
  $vale_colaborador = $row[COLABORADOR];
  $vale_empresa = $row[EMPRESA];
  $vale_usuario = $row[USUARIO];
  $vale_codigo = number_format($row[CODIGO],0,',','.');
  $vale_valor = $row[VALOR] * -1 ;
  $vale_cuota = $row[CUOTA];
  }
  
//SALDOS ANTERIORES
  $sql = "SELECT rh_vale_vales.ID, CONCEPTO, SUM(rh_vale_vales_aplicados.valor) AS APLICADO
          , VALE
          , CONCAT(rh_vale_vales.CORTE,'-',rh_vale_vales.ANO) AS FECHA
          , rh_vale_vales.VALOR
          , OBS
          , (SELECT GROUP_CONCAT( CONCAT( fecha, ': $', valor )
               ORDER BY fecha ASC
               SEPARATOR ' \n ' )
               FROM rh_vale_vales_aplicados
               WHERE idvales = rh_vale_vales.id AND valor != 0
              ) AS PAGOS  
          FROM rh_vale_vales INNER JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID 
          WHERE $fempresaTipo 
          AND corteap = '$_POST[ano]-$_POST[corte]'
          
          $filtrosAP 
          GROUP BY rh_vale_vales.ID 
          
          ORDER BY CONCEPTO"; //HAVING (MAX(rh_vale_vales.VALOR) + SUM(rh_vale_vales_aplicados.valor)) != 0
  if($autorizado =='si'){
  $result = mysqli_query($mysqli, $sql); //echo $sql;
  }
  while($row = mysqli_fetch_array($result)){
    $concID = $concID += 1;
    $saldos["$concID"] = '';
    $saldoAPL["$concID"] = $row["APLICADO"];
    $saldoscon["$concID"] = $row["CONCEPTO"];
    $saldosT += $row["APLICADO"];
    //if(){}
    $saldosobs["$concID"] = "$row[FECHA] por $".$row[VALOR]."
  ".$row["OBS"]."
  Pagos:
 ".$row[PAGOS];
 
  }
  
  $sql = "SELECT rh_vale_vales.ID, CONCEPTO, MAX(rh_vale_vales.VALOR) + SUM(IFNULL(rh_vale_vales_aplicados.valor,0)) AS SALDO  
          , CONCAT(rh_vale_vales.CORTE,'-',rh_vale_vales.ANO,' por $',rh_vale_vales.VALOR) AS OBS
          , IF(corteap = '$_POST[ano]-$_POST[corte]',COUNT(corteap),0) AS ESTE_CORTE
          , GROUP_CONCAT( DISTINCT CONCAT( rh_vale_vales_aplicados.fecha, ': $', rh_vale_vales_aplicados.valor )
               ORDER BY rh_vale_vales_aplicados.fecha ASC
               SEPARATOR ' \n ' )
              AS PAGOS
          FROM rh_vale_vales LEFT JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID 
          WHERE $fempresaTipo $filtrosAP 
          AND concat(ANO,CORTE) NOT IN ('".substr($periodoACTUAL,8,4).substr($periodoACTUAL,4,3)."','".substr($periodoVENCIDO,8,4).substr($periodoVENCIDO,4,3)."')
                
          GROUP BY rh_vale_vales.ID 
          HAVING (MAX(rh_vale_vales.VALOR) + SUM(IFNULL(rh_vale_vales_aplicados.valor,0))) != 0
          ORDER BY CONCEPTO";
  if($periodoVEN =='si' AND $autorizado =='si'){
    $result = mysqli_query($mysqli, $sql); //echo $sql;
    }
while($row = mysqli_fetch_array($result)){
  $concID = $row["ID"];
  $saldos["$concID"] = $row["SALDO"];
  $saldoscon["$concID"] = $row["CONCEPTO"];
  if($row["ESTE_CORTE"]== 0 ){
     $pendSAL ='SI';
     }
  if($_POST["saldos$concID"] == '' ){ 
    if($row["ESTE_CORTE"]== 0 ){
     $_POST["saldos$concID"] = $row["SALDO"] * -1;
     $pendSAL ='SI';
     }else{
     $_POST["saldos$concID"] = 0 ;
     }
    }
  $saldosT += $_POST["saldos$concID"];
  
  $saldosobs["$concID"] = $row["OBS"]."
  Pagos:
 ".$row[PAGOS];

  }

//DESCUENTOS
if($_POST['colaborador'] !=''){
  if($autorizado !='si'){
  $fuser = " AND USUARIO = '$_SESSION[usuARio]'  "; 
  }
  $sql = "SELECT 
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
          FROM rh_vale_vales WHERE $fempresaTipo $filtrosVA $fuser ORDER BY CONCEPTO";
  }else{
  $sql = "SELECT rh_vale_vales.ID, COLABORADOR as CONCEPTO, IFNULL(sum(rh_vale_vales.VALOR),'0') as VALOR, SUM(rh_vale_vales_aplicados.valor) AS APLICADO  
          FROM rh_vale_vales LEFT JOIN rh_vale_vales_aplicados ON idvales = rh_vale_vales.ID WHERE $fempresaTipo $filtrosVA $fuser GROUP BY COLABORADOR ORDER BY COLABORADOR";
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
    }else{
    $pendDTO ='SI';
    }  
  if($periodoVEN == 'si'){
    $dtosT += $_POST["dtos$concID"];
    }
  }        

//PAGOS
if($_POST['colaborador'] !=''){
  $sql = "SELECT CONCEPTO, SUM(VALOR) AS VALOR FROM rh_vale_pagos WHERE $fempresaTipo $filtrosVA GROUP BY CONCEPTO";
  }else{
  $sql = "SELECT COLABORADOR AS CONCEPTO, SUM(VALOR) AS VALOR FROM rh_vale_pagos WHERE $fempresaTipo $filtrosVA GROUP BY COLABORADOR";
  }

if($autorizado =='si'){
  $result = mysqli_query($mysqli, $sql);
  }
while($row = mysqli_fetch_array($result)){
  $CONCEPTO = $row["CONCEPTO"];
  $pagos["$CONCEPTO"] = $row["VALOR"];
  
  $pagosT += $row["VALOR"];
  } 	

$totalT = $pagosT - $dtosT - $saldosT; 		
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
<a class="frl" style="font-weight:bolder; font-size:16px">
<br>INFORME DE DESCUENTOS <?= strtoupper($_POST['colaborador'])?>
<br>CORTE <?= $_POST['corte']?>, <?= $_POST['ano']?>
<select onchange="this.form.submit();" class="frl" id="molonom" name="molonom" style="width: inherit;border:0; border-bottom-style:groove; border-bottom-color:black;font-weight:bold;font-size:inherit">
  <option <? if($_POST['molonom']=='MOLECULA'){ echo "selected";} ?> >MOLECULA</option>
  <option <? if($_POST['molonom']=='NOMINA'){ echo "selected";} ?> >NOMINA</option>
</select> 
<?= $cuotasmsg?>
</a>
<table align="center" class="frm" border="1" cellspacing="0" style="width:90%; <?= $lineColor?>"  >
  <tr>
    <td class="frl" colspan="3" align="center">
      <font size='+1'>
      <? if(($pendSAL =='SI' OR $pendDTO == 'SI') AND $periodoVEN =='si' ){ 
        echo "<font color='DarkOrange'><b>PRE-Liquidacion </b></font>";
        }else{
        echo "<b>Liquidacion </b>";
        }
       if($totalT < 0 ){$colorTT ='RED';} 
        echo "<font color='$colorTT'><b>$".number_format($totalT,0,',','.')."</b></font>";
      ?>
      </font>
      <br/>(A abonar) - (Saldo ant) - (Dto este corte)  </td>
  </tr>
  <tr bgcolor="">
    <th style="width:33%; height: 16px;">Saldo anterior $<?= number_format($saldosT,0,',','.')?></th>
    <th style="width:34%; height: 16px;">Dto Este Corte $<?= number_format($dtosT,0,',','.')?></th>
    <th style="width:33%; height: 16px;">A Abonar $<?= number_format($pagosT,0,',','.')?></th>
  </tr>
  <tr>
    <td valign="top">
     <div class="aut" style="max-width:100%; max-height:14cm"> 
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
                  <td style='width:45%' ><a title='$saldosobs[$id]'>$saldoscon[$id]</td>
                  <td style='width:27%' align='right'>
                    ".number_format($valor,0,',','.')."</td>
                  <td style='width:28%' align='right'>  
                    "; 
              
              if($saldoAPL[$id] ==''){
              $arrSAL[] = $id;
              echo "<input class='frs campo' type='number' name='saldos$id' id='saldos$id' value='".$_POST["saldos$id"]."' style='width:100%; text-align:right; color:darkred'>
                    <input class='frs' type='hidden' name='saldoscon$id' id='saldoscon$id' value='".$saldoscon[$id]."' >";
                }else{
                  echo number_format($saldoAPL[$id],0,',','.');
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
     </div>
    </td>
    <td valign="top">
      <div class="aut" style="max-width:100%; max-height:14cm">
      <table class="frm" width="100%" cellspacing="0">
        <tr>
          <th>(<input type="radio">= vale)</th>
          <th></th>
          <th>Generado</th>
          <th>Aplicado</th>
          <?
          $periodoVEN = 'si';
          if($periodoVEN =='si'){
          echo "<th>Edit</th>";
          }
          ?>
        </tr>
        <?
        
        foreach($dtos AS $id => $valor){
           
          if($color == ''){$color ='Gainsboro';}else{$color ='';}
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
                    ".number_format($valor,0,',','.')."</td>
                  <td style='width:25%' align='right'>  
                    "; 
          
          if($aplicados[$id] =='NA' AND $periodoVEN =='si'){
              $arrCONC[] = $id;
              $contDTOS ++;
              //aqui
              echo "<input class='frs campo' type='number' name='dtos$id' id='dtos$id' value='".$_POST["dtos$id"]."' style='width:100%; text-align:right; color:darkred'>
                    <input class='frs' type='text' name='conc$id' id='conc$id' value='".$conceptos[$id]."' >
                    </td>
                    <td>
                    <select onChange='this.form.submit()' class='frxs campo' id='acciones$contDTOS' name='acciones$contDTOS'>
                      <option></option>
                      <option value='$id|Cambiar|$molonomINV|$conceptos[$id]'>$molonomINV</option>
                    </select>  
                    
                    ";
          }else{
              echo number_format($aplicados[$id],0,',','.');
          }          
                    
            echo "</td>
                </tr>";
        }
       
        ?>
      </table>
      <input type="hidden" name="contDTOS" id="contDTOS" value="<?= $contDTOS?>" />
      <br/>
      <?
        if($_POST['colaborador'] =='' OR count($arrCONC) < 1){
        //nada
        }else{      
      ?>
      Aplicar Dto : 
      <input onclick="if(confirm('******* \n Click en ACEPTAR \n Para confirmar Aplicar Dto')){this.form.submit()}else{document.getElementById('aplicar').checked = 0  } " type="checkbox" value="<?= implode('|',$arrCONC)?>" id="aplicar" name="aplicar" style="height:20px; width:20px;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   	  <input onClick="this.form.submit();" id="sdas" name="botonref1" class="verloader frm boton" value=" Calcular " type="button" >
      <br/>
        <? } // finif?>      
     </div>
    </td>
    <td valign="top">
     <div class="aut" style="max-width:100%; max-height:14cm">
      <table class="frm" width="100%">
        <?
        foreach($pagos AS $conc => $valor){
        if($color == ''){$color ='Gainsboro';}else{$color ='';}
        echo "<tr bgcolor='$color'>
                <td>$conc</td>
                <td align='right'>".number_format($valor,0,',','.')."</td>
              </tr>";
        }
        
        ?>
      </table>
     </div> 
    </td>
  <tr >
    <td style="border:0px" class="frl" align="right">
      &nbsp;</td>
    <td style="border:0px"  align="center">
        <?
        
        if($_POST['colaborador'] ==''){ $msjVALE = "Para nuevo vale debe seleccionar un colaborador"; $errorVALE += 1; }
        if($periodoACT == 'no'){ $msjVALE = "Solo se puede guardar información del periodo actual"; $errorVALE += 1; }
        
        if($errorVALE > 0){ echo "<font color='red'>$msjVALE</font>";
        }else{
        ?>
        <table class="frm" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2">
            <b>Nuevo Dto/Vale : </b>
            <br/> 
              <font color='red'><?= $msjN?></font>
              <br>
              <select class="frm select" name="dtoN" id="dtoN" style="width:100%; border-color:<?= $colorN['DN']?>" >
              <?
              if($_POST['dtoN'] == ''){
                echo "<option hidden selected>Selecciona un Tipo de Descuento</option>";
                }else{
                echo "<option>$_POST[dtoN]</option>";
                }
              foreach($conceptos AS $valor){
              if($_POST['dtoN'] != $valor){echo "<option>$valor</option>";}
              }
              ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="30%" >Valor $</td> 
            <td width="70%" >: <input class="frm" type="number" min="1" step="1" name="vlrdtoN" id="vlrdtoN" value="<?= $_POST['vlrdtoN']?>" style=" width:90%; height:28px; border-color:<?= $colorN['VDN']?>">
            </td>
          </tr>
          <tr>
            <td >Firma Vale</td>
            <td >: <select onchange="this.form.submit()" class="frm select" name="firmavale" id="firmavale" style="width:90%; border-color:red<?= $colorNe['FV']?>" >
                            <?
                            echo "<option>$_POST[firmavale]</option>";
                            if($_POST[firmavale] != 'NO'){echo "<option>NO</option>";}
                            if($_POST[firmavale] != 'PRE-FIRMADO'){echo "<option>PRE-FIRMADO</option>";}
                            echo "<optgroup label='SI,Cuotas'>";
                            for( $i =1 ; $i < 7 ; $i++){ 
                              echo "<option>$i</option>";
                              }
                            echo "<option>POR DEFINIR</option>";
                            echo "</optgroup>";
                            ?>
                            
                          </select>
            </td>
          </tr>
          <?
          if($_POST[firmavale] == 'PRE-FIRMADO'){
          ?>
          <tr>
            <td width="30%" >Vale #</td> 
            <td width="70%" >: <input class="frm" type="number" min="1" step="1" name="valeNroN" id="valeNroN" value="<?= $_POST['valeNroN']?>" style="width:90%; height:28px; border-color:<?= $colorN['VNN']?>">
            </td>
          </tr>
          <?
          }
          ?>
          <tr>
            <td colspan="2">
            Observaciones:
            <br>
            <textarea id="obs" name="obs" rows="3" style="width:100%"><?= $_POST['obs']?></textarea>
            </td>
          </tr>
          <tr>
            <td align="center" style="height: 20px" colspan="2">
              Guardar : <input onclick="this.form.submit();" type="checkbox" value="guardar" id="guardar" name="guardar" style="height:20px; width:20px;">
            </td>
          </tr>
        </table>
        <? } //finif ?>
    </td>
    <td style="border:0px" ></td>
  <? $errorCSV = 0 ;
     if($_POST['colaborador'] !=''){ $msjCSV = "Para subir archivo debe quitar el filtro de Colaborador"; $errorCSV += 1; }
     if($periodoACT == 'no'){ $msjCSV = "Solo se puede guardar información del periodo actual"; $errorCSV += 1; }
     if($msjVALE == $msjCSV){ $msjCSV = ""; }
     
     if($errorCSV > 555550){ 
       echo "<tr>
                <td></td>
                <td align='center'><font color='red'>$msjCSV</font></td>
                <td></td>
                </tr>";
        }else{
  ?>      
  <tr>  
    <td></td>
    <td>
    <? if($_POST['colaborador'] !='' OR $periodoACT == 'no'){ echo "<font color='red'>Para subir archivo de Descuentos debe quitar el filtro de Colaborador y estar en periodo actual</font>"; 
      }else{
       ?>
       Subir archivo descuentos 1 <input onchange="this.form.submit()" type="file" id="archivoV" name="archivoV" class="frm Aabs"  maxlength="15" tabindex="5" value="10">
    <? } ?>
    </td>
    <td>
    <? if($_POST['colaborador'] !='' OR $periodoVEN == 'no'){ echo "<font color='red'>Para subir Molecula debe quitar el filtro de Colaborador y estar en periodo vencido</font>"; 
      }else{
       ?>
      Subir archivo Molecula <input onchange="this.form.submit()" type="file" id="archivoM" name="archivoM" class="frm Aabs"  maxlength="15" tabindex="5" value="10"></td>
   <? } ?>
  </tr>
  <tr>
    <td colspan="3">
    <? if($_POST['subir'] !=''){ ?>
      <div class="aut" style="width:100%; height:4cm" align="center">
        <table class="frm">
        <tr>
          <th style="height: 17px">CEDULA</th>
          <th style="height: 17px">COLABORADOR</th>
          <th style="height: 17px">VALOR</th>
          <th style="height: 17px">VALIDACION DATOS</th>
        </tr>
        <?
        //, (SELECT IFNULL( min(COLABORADOR) , 'ne' ) FROM rh_vale_vales WHERE rh_vale_vales.CODIGO = $tabla$TMP.CODIGO ORDER BY id DESC LIMIT 0,1)
        $sql = "SELECT trim(CODIGO)
                     , trim(COLABORADOR)
                     , trim(sum(VALOR))
                     , CASE WHEN (SELECT IFNULL( min(COLABORADOR) , 'ne' ) FROM rh_vale_vales WHERE rh_vale_vales.CODIGO = $tabla$TMP.CODIGO ORDER BY id DESC LIMIT 0,1)!='ne' THEN 'Existe' ELSE 'No existe' END
                     FROM $tabla$TMP
                     WHERE USER ='$_SESSION[usuARio]'
                     GROUP BY TRIM(CODIGO), TRIM(COLABORADOR)
                     ORDER BY COLABORADOR"; 
        $result = mysqli_query($mysqli,$sql);
        $c=mysqli_num_rows($result);
        //echo '<script>alert("******\n'.$c.'")</script>';
        while($row = mysqli_fetch_array($result)){
             if($row[3] == 'No existe'){ 
                    $txtnombre ="<font color='green'>Se creara el colaborador</font>";
                }else{ 
                    $txtnombre ="<font color='green'>Se actualizara el colaborador</font>";
                }
                //$x=is_numeric($row[0]); //1 cuando esta bien
             if (! is_numeric($row[0])) {
                $msgx1="<font color='red'>Cedula no valida</font>";
             }
             $nom=explode(" ",$row[1]); //inicio nombre colaborador
             //echo $nom[0];
             $var2=explode(" ",$row[3]); // existe o no existe
             $f=0;
             $verfica=0;
             $L=count($nom);
             echo $L; 
             
             /*while($f<$L){
                 //$var1=$nom[$f];
                 //$aux2=$var2[$f];
                 //echo '<script>alert("******1\n '.$L.'")</script>';
                 $sql11 = "SELECT trim(COLABORADOR)
                     , (SELECT IFNULL( min(COLABORADOR) , 'ne' ) FROM rh_vale_vales_tmp WHERE rh_vale_vales_tmp.CODIGO = $tabla.CODIGO ORDER BY id DESC LIMIT 0,1)!='ne' THEN 'Existe' ELSE 'texto prueba' END
                     FROM $tabla
                     WHERE USER ='$_SESSION[usuARio]'
                     GROUP BY TRIM(CODIGO), TRIM(COLABORADOR)
                     ORDER BY COLABORADOR";
                 $resultcolabo = mysqli_query($mysqli,$sql11);
                 $c1=mysqli_num_rows($resultcolabo);  
                    
                 while($row = mysqli_fetch_array($resultcolabo)){
                    if($row[3] == 'texto prueba'){ 
                        $txtnombrecolabo ="<font color='green'>ingreso 1</font>";
                    }else{ 
                        $txtnombrecolabo ="<font color='green'>ingreso 2</font>";
                    }
                 }            
                                  
                if (strpos($row[3], $nom[$f]) !== false) {
                    $verfica++;
                }
                 $f++;
             }
             if($verfica <= 2){
                $msgx2="<font color='red'>nombres o apellidos no coinciden</font>";
             }*/
            echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$txtnombre-$row[3]-$msgx1</td></tr>";//-$msgx2-$verfica
            $msgx1="";
            $msgx2="";
            $valT += $row[2];
            $colT += 1;
            }
        /*while($row = mysqli_fetch_array($result)){
            
            
            echo "<tr>
                    <td>$row[0]</td>
                    <td>$row[1]</td>
                    <td>$row[2]
                    ";
            $txtnombre ='';
                if($row[3] == 'ne'){ 
                    $txtnombre ="<font color='green'>Nueva C.C. se creara el colaborador</font>";
                }elseif($row[3] != 'ne'){ 
                    $txtnombre ="<font color='green'>Nueva C.C. se actualizara el colaborador</font>";
                }else{
                    echo '<script>alert("******\n'.$difnom.'")</script>';
                  $nombreBD = explode(" ",$row[3]);
                  $nombreCSV = explode(" ",$row[1]);
                  $noest = array_diff($nombreBD,$nombreCSV);
                  
                  $difnom = count($nombreBD)-count($noest);
                  
                  if( $difnom <= 1 ){
                        echo '<script>alert("******\n'.$difnom.'")</script>';
                            $errorCSV += 1;
                            $txtnombre ="<font color='red'>ERROR Nombre diferente al registrado:$row[3]</font>";
                        }elseif( $difnom == 2 and count($nombreBD) != 2 ){
                            $alertCSV += 1;
                            $txtnombre ="<font color='DarkOrange'>Alerta</font> Verifique nombre, registrado:$row[3]";
                        }else{
                            $txtnombre ="ok";
                        }
                   }
                $ced = $row[0]+0 ;
                $val = $row[2]+0;  
                if(ctype_digit($ced)){}else{ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR la cedula solo puede tener numeros</font>"; }
                if(ctype_digit($val)){}else{ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR el valor debe ser positivo, sin decimales y sin puntos de miles.</font>"; }  
                if($val == 0){ $errorCSV += 1; $txtnombre = "<font color='red'>ERROR el valor no puede ser 0</font>"; }
                
                if($txtnombre != 'ok'){
                  $contEOA += 1;
                  echo "<tr>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                        <td>$row[2]</td>
                        <td>$txtnombre</td>
                        </tr>";
                  }  
               $valT += $row[2];
               $colT += 1;     
       }*/
       
       for($i = $contEOA ; $i < 20 ; $i++){
         echo "<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>";
       }
       ?>
        </table>
      </div>
      <br>
      <div class="frm" align="center">
      <?
      if($errorCSV == 0){
      
      echo "Tipo de Descuento<br><select class='frm select' name='dtoN' id='dtoN' style='width:30%; border-color:$colorN[DN]'>";
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
            <input type='Ahidden' name='archivoX' id ='archivoX' value='$_POST[archivoX]' />
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
  
  function usuarios_emp($empe){
                        
                        }
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
			<td> 
            <!--this.form.submit();-->
	    		<select onchange="this.form.submit();" id="empresa" class="frm campo select" name="empresa" tabindex="2" >
                <!--<option><?// echo $_POST['empresa']; ?></option>-->   
                <option value="">seleccione</option>                             
        		<?
        		/*foreach($_SESSION['empresA'] as $emp){
        		if($_POST['empresa'] != $emp){echo "<option>$emp</option>";}
        		}*/
                //consultas realizadas a la base 
                $query = $mysqli -> query ("SELECT DISTINCT empresa FROM rh_vale_vales WHERE 1"); //SELECT DISTINCT empresa FROM rh_vale_colaboradores WHERE 1              
                    
                while ($valores = mysqli_fetch_array($query)) {
                                        
                  echo '<option value="'.$valores[empresa].'">'.$valores[empresa].'</option>';
                }                                                
                ?> 
       </select>

			</td>
		</tr>
        <tr>
            
            <td>Empresa Seleccionada:</td> <td><?echo $_POST['empresa']; ?></td>
        </tr>
		<tr>
			<td colspan="2"> 
				<br/>
			</td>
		</tr>
		<tr>
			<td> 
				Periodo
			</td>
			<td>
				 <select id="periodo" name="periodo" class="frm campo afil select" type="text">
				   <?
				   $mesL =date("m") + 0;
				   $anoL =date("Y") + 0;
				   if(date("d") >= $diacorte ){
                     $mesL += 1 ;
                     if($mesL == 13){ 
                       $mesL = 1;
                       $anoL +=1;
                       }  
                   }

				   for( $i = 1 ; $i <= 24 ; $i++){
				     $mesL_1 = $mesL - 1 ;
				     if( $mesL_1 == 0){ $mesL_1 = 12; }
				     $periodoL = $meses["$mesL_1"]."-".$meses["$mesL"]." ".$anoL;
				     
				     if($_POST['periodo'] == $periodoL ){ $selected ="selected";}else{$selected ="";}
				     echo "<option $selected>$periodoL</option>";
				     
				     $mesL -= 1;
				     if($mesL == 0 ){$mesL = 12; $anoL -= 1;}
				     
				     if($autorizado !='si' and $i == 3){
				       break;
				       }
				   }
				   ?>
				   
				    
				  </select> 
			</td>
		</tr>

		<tr>
			<td> 
				Colaborador
			</td>
			<td><input type="text" id="colaboradorH" name="colaboradorH" value="<?= $_POST['colaborador']?>"/>
				<select onchange="this.form.submit();" id="colaborador" name="colaborador" class=" verloaderB frm campo select"  >
					<option ><?= $_POST['colaborador']?></option>
					<option value="">Quitar filtro</option>
					<?
                    
                    if(isset($_POST['empresa'])){
                        $fempresa=$_POST['empresa'];
                        //echo '<script>alert("****** \n'.$fempresa.'")</script>';
                    //visualiza la informacion de una vista en la base de datos (COLABORADOR)
                    require_once("user_con.php");
					//$sql = "SELECT DISTINCT COLABORADOR, CODIGO FROM rh_vale_colaboradores WHERE 1 order by COLABORADOR"; //$fempresa // AGROCAMPO
                    $sql = "SELECT DISTINCT COLABORADOR, CODIGO FROM rh_vale_colaboradores WHERE EMPRESA='$fempresa' order by COLABORADOR"; //$fempresa // AGROCAMPO                    
                    //SELECT COLABORADOR, CODIGO FROM rh_vale_colaboradores WHERE 1 = 1 and empresa='AGROCAMPO' order by COLABORADOR
					//$result = mysqli_query($mysqli, $sql);
					//while($row = mysqli_fetch_array($result)){
					//echo "<option value='$row[0]' >$row[0] - $row[1]</option>";
					//}
                    $result = mysqli_query($mysqli, $sql);
                    while($row = mysqli_fetch_array($result)){
                        if($result){
                                  
                            echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
                        }
                    }
                    }
					?>

					
					
			
				  </select>			
			</td>
		</tr>
		<tr>
			<td> 
				Trasferir
			</td>
            
			<td> 
            <!--this.form.submit();-->
                <?php $valida1=$_POST['tipo'];?>
	    		<select onchange="this.form.submit();" id="tipo" class="frm campo select" name="tipo" tabindex="2" >
                                
      		    <?
                
                if(isset($_POST['colaborador'])){
                    $fCOL=$_POST['colaborador'];
                    //utf8_decode($fCOL);
                    $querytipo = $mysqli -> query ("SELECT DISTINCT tipo FROM rh_vale_vales WHERE COLABORADOR='$fCOL'"); //SELECT DISTINCT empresa FROM rh_vale_colaboradores WHERE 1
                              
                        
                    /*while ($valores = mysqli_fetch_array($querytipo)) {
                                            
                      echo '<option value="'.$valores[tipo].'">'.$valores[tipo].'</option>';
                      
                      if($_POST['tipo']=='MOLECULA'){ 
                        $tipoMolecula=$_POST['tipo'];//MOLECULA
                        $valorM="";
                        
                        $sqlNom = "UPDATE `rh_vale_vales` SET `TIPO`='NOMINA' WHERE COLABORADOR='$fCOL'";
                            $result = mysqli_query($mysqli, $sqlNom);
                            while($row = mysqli_fetch_array($result)){
                            
                                echo '<script>alert("******\n Este cliente sera enviado de '.$tipoMolecula.' a NOMINA.")</script>';
                            }
                      }elseif($_POST['tipo']=='NOMINA'){
                        $tipoNomina=$_POST['tipo'];//NOMINA
                        $valorN="";
                        $sqlNom = "UPDATE `rh_vale_vales` SET `TIPO`='MOLECULA' WHERE COLABORADOR='$fCOL'";
                       
                        $result = mysqli_query($mysqli, $sqlNom);
                        while($row = mysqli_fetch_array($result)){
                            echo '<script>alert("******\n Este cliente sera enviado de '.$tipoNomina.' a MOLECULA.")</script>';
                        }
                      } 
                    }*///echo '<script>alert("******\n'.utf8_encode($fCOL).' ")</script>';
                }                                            
                ?> 
       </select>

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
				<br/>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"> 
				<input type="button" class="frm boton" value=" Imprimir " onClick="javascript:window.print()" /> 
			</td>
		</tr>
	</table>
		 
		
		
	    <br/><br/>
	    
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
