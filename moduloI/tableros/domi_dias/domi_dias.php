<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PEDIDOS PENDIENTES</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<!-- <meta http-equiv="refresh" content="60"> -->

<link rel="stylesheet" type="text/css" href="../../../antenna.css" id="css" media="all">
<link rel="stylesheet" href="../../../aajquery.css" >
<link rel="stylesheet" type="text/css" href="../../../_tableFilter/filtergrid.css" media="screen" />
<link rel="stylesheet" type="text/css" href="./css/domi_dias.css">

<script type="text/javascript" src="../../../antenna/auto.js"></script>
<script src="../../../aajquery.js"></script>
<script type="text/javascript" src="../../../_tableFilter/tablefilter_all.js"></script>
<script src="./js/domi_dias.js"></script>

<style type="text/css" media="print">
@page{
   size: letter portrait;	
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>

</head>


<!-- ███████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ -->
<?php 
include ('../../../nuevo_sia_v2/conection/conexion_sql.php');
include('consultas.php');
include('configuracion.php');


session_start();
$anio = date('Y');
$mes = date('m');
$dia = date('d');
$hoy_10 = date( 'Y-m-d', strtotime( "$hoy - 10 day" ) );

$con_sql = new con_sql('sqlFacturas');


if($_POST['empresa'] == ''){
  $_POST['empresa'] = $_SESSION['emp'];
}

if($_SESSION['emp'] != $_POST['empresa']){
  $_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
}

/*
token 1 = 9c2050e88ccdea5226af2e1a6c8054a7 general 
token 2 = 6aaacef41ca892843921b67f3d810c2e area 
token 3 = 2360fe6a1195d0ea3210559eacf19560 individual
*/


/* EJECUTA EL SP DE MANERA INDIVIDUAL */
if((empty($_GET['to']) && empty($_GET['ar'])) && (($_GET['to']=='' && $_GET['ar']=='') )){
include_once('../../../nuevo_sia_v2/conection/conexion_sql.php');

$es_ind = 1;
$usuario = strtoupper($_SESSION['usuARioS']);
$conn = new con_sql();
$consul="select AREA,CODIGO from VIS_CODIGOS_AREA where Codigo='$usuario' order by AREA,Codigo";
$rta_consul = $conn->consultar($consul);

  while($area_consulta = mssql_fetch_array($rta_consul)){
      
    $area_pertenece =   $area_consulta[0];
    $cod_pertenece =   $area_consulta[1];

      if($area_pertenece==='ALMACEN'){
        $token="6aaacef41ca892843921b67f3d810c2e";
        $area=1004;
        $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_pertenece','$cod_pertenece'");
        $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_pertenece' and VENDEDOR='$cod_pertenece' "));
        echo "<center><h1> $area_pertenece </h1></center>";

      }else if($area_pertenece==='CALLCENTER'){
        $token="45323aae323bcd418a48000fa0f3fa77";
        $area=1007;
        $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_pertenece','$cod_pertenece'");
        $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_pertenece' and VENDEDOR='$cod_pertenece'"));
        echo "<center><h1> $area_pertenece </h1></center>";
        
      }else if($area_pertenece==='VENTA EXTERNA'){
        $token="2456da3802bb9cca78ed50285dc48282";
        $area=1009;
        $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_pertenece','$cod_pertenece'");
        $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_pertenece' and VENDEDOR='$cod_pertenece' "));
        echo "<center><h1> $area_pertenece </h1></center>";
      }else{
        echo "Su codigo no tiene ningun permiso";
        return;
      }
  }

  $area_nom = mssql_fetch_array($con_sql->consultar("select CAMPO from API_CONFIGURACION where DESCRIPCION like'CODIGO%' and VALOR='$area_pertenece'"));
  $area_nom = $area_nom[0];
  
}else{
  $es_ind = 0;

  $token    = $_GET['to'];
  $area     = $_GET['ar'];
  $area_nom = mssql_fetch_array($con_sql->consultar("select CAMPO from API_CONFIGURACION where DESCRIPCION like'CODIGO%' and VALOR='$area'"));
  $area_nom = $area_nom[0];

/* validamos area y token para general  */
if($token==='9c2050e88ccdea5226af2e1a6c8054a7'){
 
  $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS");
  $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO"));

}
else if ($token==='6aaacef41ca892843921b67f3d810c2e' && $area==1004){// ALMACEN
  $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_nom'");
  $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_nom' "));
  echo "<center><h1> $area_nom </h1></center>";
  
}else if($token==='45323aae323bcd418a48000fa0f3fa77' && $area==1007){// CALL CENTER 2456da3802bb9cca78ed50285dc48282
  $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_nom'");
  $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_nom' "));
  echo "<center><h1> $area_nom </h1></center>";
  
}else if ($token==='d925b5029c401ac9efacf2beae480ef9' && $area==1008){// WEB 45323aae323bcd418a48000fa0f3fa77
  $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_nom'");
  $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_nom' "));
  echo "<center><h1> $area_nom </h1></center>";

}else if($token==='2456da3802bb9cca78ed50285dc48282' && $area==1009){// VENTA EXTERNA d925b5029c401ac9efacf2beae480ef9
  $sql=("EXEC SP_VIS_TABLEROS_DOMICILIOS '$area_nom'");
  $total_ordenes = mssql_fetch_array($con_sql->consultar("select count(*) from TBL_VIS_TABLERO where sector='$area_nom' "));
  echo "<center><h1> $area_nom </h1></center>";
  
}else{
  echo "<center>No tiene permiso para consultar</center>";
  return; 
}


}




/*██████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/*██████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/*██████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */
/*██████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */


$result = $con_sql->consultar($sql) ; 

while($row = mssql_fetch_assoc($result)){
    
		$dia          = $row["DIA"];
		$orden        = $row["ORDEN"];
		$estado       = $row["ESTADO"];
		$actualizado  = $row["ACTUALIZADO"];
		$row["DEST"]  = SUBSTR($row["DESTINO"],0,3);

		
    $comaC = '';
        $comaV = '';
		foreach($row as $campo => $valor){
		  //datos tablero
		  $ti["$dia"]["$orden"]["$campo"]= utf8_encode(strtoupper($valor));
		} 
    }


if($_GET['mail'] =='SI'){  exit; }
if(count($ti) == 0){ $ti[" ----- SIN PEDIDOS PENDIENTES ----- "] = ''; $tiHORA[] = '';} 


?> 

<body class="global" onLoad="setInterval('fsubmit()',900000);">
<form id="form1" name="form1" action="domi_dias.php" method="post" name="submit button1">
  <div align="center" class="frr" id="msj_head" name="msj_head">
    <font size="+2" color="crimsom">¡Estamos trabajando para mejorar!</font> 
    <font size="+2" color="navy"><br> <b>PEDIDOS WEB PENDIENTES DE TRAMITE </b></font>
    
    
    <font size="+1" color="navy"><br> <b> TOTAL DE ORDENES DESDE <?=$hoy_10?> SON <?=$total_ordenes[0]?> </b></font>
  </div>
  
  <!-- ██████████████████████████████████████ VALIDACION DE LAS ORDENES REVIVIDAS ████████████████████████████████████████ -->

<section style="width    : 4.5% !important;" class="frr" id="revividas" name="revividas">
  <table style="background-color:transparent; height   : 100% !important; text-align: center;">
    <th>
      <span style="font-size:10px; ">
        ORDENES REVIVIDAS EN EL MES
      </span>
    </th>
    <tr>
      <td style="width: 20px !important; font-size: 11px; border; 1px solid black;">
                <?php

                // ES ESTA SECCION SE REVISAN CUALES SON LAS ORDENES QUE ESTAN REVIVIDAS
                $ordenes_revividas = $con_sql->consultar($consulta_revividas);
                  while($revividas = mssql_fetch_array($ordenes_revividas)){
                      echo "$revividas[0] <br>";
                  }
              ?>
      </td>
    </tr>
  </table>
</section>
<!-- ██████████████████████████████████████ VALIDACION DE LAS ORDENES REVIVIDAS ████████████████████████████████████████ -->



<?
foreach($ti AS $di =>$i2){
    if($di== '1' || $di== '2'){
        $color = "green";
        $bgcolor = "#f4f9f7";
    }else if($di == 3){
        $color = "DarkOrange";
        $bgcolor = "#f8efd3";
    }else if($di >= 4){
        $color = "Red";
        $bgcolor = "pink";
    }

?>


<section style="background-color:<?= $bgcolor?>">
  <?php //organiza valores del array origen
      $ordenes ='';
        foreach($ti["$di"] AS $ord => $vals){
        $ordenes[] = "$ord";
        
          foreach($ti["$di"]["$ord"] AS $campo => $vals2){
            if($campo =='ESTADO'){ 
              $estado = $vals2;
            }
            if($campo =='DEST'){ 
              $dest = $vals2;
            }
          }
          $total["$di"]["$dest"]["$estado"][] = $ord;
        }

        /*
        1 = consulta individual
        0 = consulta general y grupos se valida por codigo y token
        */
      if($es_ind==1){
        $consul_add = "and VENDEDOR = '$cod_pertenece' ";
      }else{
        $consul_add ="";
      }


     /* columna de totales  PRIMERA TALBA AREA*/
    $totalALM    = mssql_fetch_array($con_sql->consultar("select count(orden) TOTAL from TBL_VIS_TABLERO WHERE  dia='$di' and SECTOR='ALMACEN' $consul_add "));
    $totalCAL    = mssql_fetch_array($con_sql->consultar("select count(orden) TOTAL from TBL_VIS_TABLERO WHERE  dia='$di' and SECTOR='CALLCENTER'$consul_add  "));
    $totalVTAEXT = mssql_fetch_array($con_sql->consultar("select count(orden) TOTAL from TBL_VIS_TABLERO WHERE  dia='$di' and SECTOR='VENTA EXTERNA' $consul_add "));
    $totalWEB    = mssql_fetch_array($con_sql->consultar("select count(orden) TOTAL from TBL_VIS_TABLERO WHERE  dia='$di' and SECTOR='WEB' $consul_add "));
  ?>
  <font color="<?= $color?>" size="+2" ></font>
 
  
  <table align="center" class="frr" width="100%">
  
    <tr>
      <th colspan="4" style="height: 49px">
        <font color="<?= $color?>" size="+2" ><b>DIA <?= $di?></b></font>
        <br/>
        <font size="+2" ><b><u id="total_x_dia" name="total_x_dia" ><?= count($ti["$di"])?></u></b></font> 
        
      </th>
    </tr>
    <!-- CABECERA TOTALES POR GRUPO DOMI -REME-CALC x entrega -->
    
    <tr align="center">
      <td><font color="<?= $color?>" size="+1"><u> ALMACÉN    </u></font></td>
      <td><font color="<?= $color?>" size="+1"><u> CALLCENTER </u></font></td>
      <td><font color="<?= $color?>" size="+1"><u> VTA EXTERNA</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u> WEB        </u></font></td>
      <td><font color="<?= $color?>" size="+1"><u> PTO. WEB   </u></font></td>
    </tr>
    <tr align="center">
      <!--  Valores de cantidades por sector -->
      <td><font color="<?= $color?>" size="+1"><?= $totalALM[0]?>    </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalCAL[0]?>    </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalVTAEXT[0]?> </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalWEB[0]?>    </font></td>
    </tr>              
  </table>
              
    <?php
    //DEFINION DE LA TABLA LA PRELACION ES EL CAMPO DESTINO DE LA VISTA
    $titulos = array('EXP' => 'EXP','REM' => 'REM','WEB'=>'WEB','AGR' => 'AGR','DOM'=>'DOM','SIN'=>'SIN','PTO. WEB'=>'PTO. WEB');   
    
    // LA PRELACION ES EL CAMPO ESTADO DE KA VISTA
    $estados = array('Estado 10' => '10','Estado 20' => '20','Estado 30' => '30','Estado 40' => '40','Estado 45' => '45','Estado 60' => '60','TOTAL' => 'TOTAL');
    // $estados = array('Estado 10' => '10','Estado 20-45' => '20-45','Estado 60' => '60','TOTAL' => 'TOTAL');

    ?>  
    <table align="center" class="frr" style=" width:200%; border-width:thin;border-style:groove;border-color:<?= $color?>;" >    
      <tr>
        <th>Estados</th>
        <?
          foreach($titulos AS $titulo => $valorDES){
            echo "<th class='frr'>$titulo</th>";
          }
        ?>
      </tr>
      <?
      /* Columna 1 estados */
      foreach($estados AS $estado => $valorEST){
        /* FILAS DE GRIPOS 10- 20/45 -60 */
      echo "<tr><td class='frr' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>
              <b>$estado </b>
              </td>";
                foreach($titulos AS $titulo => $valorDES){

                  /**COLUMNAS IZQUIERDA A DERECHA PARA ESTADOS 10 -20/45-60 */
                  /* valores recuadro de cantidades 
                  Estados	      DOMI	REM	WEB-ALM	EXPR	SIN-D	TOTAL
                  Estado 10	    11	  27	0	      4	    121	  163
                  Estado 20-45	25	  1	  0	      1	    4	    31
                  Estado 60	    1	    3	  0	      28	  11	  43
                  TOTAL	        37	  31	0	      33	  136	  237
                  */

                  $valExD = count($total["$di"]["$valorDES"]["$valorEST"]);

                  $valT["$di"]["$valorDES"] += $valExD; 
                  $valT["$di"]["$valorEST"] += $valExD;
                  $valTT["$di"] += $valExD;


                  if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"];}
                  if($valorDES =="TOTAL"){ $valExD = $valT["$di"]["$valorEST"];}
                  if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"];}
                  if($valorDES =="TOTAL" AND $valorEST =="TOTAL"){ $valExD = $valTT["$di"];}
                echo "<td class='frr' align='center' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>$valExD</td>";
        }        
      }
      ?>

    </table>
    <br>
    <div align="center" class="frr aut" style="height:50%; width:100%;">
      <table id="<?= $di?>" align="center" width="100%" class="frr">
      <tr>
        <th>Sector</th>
        <th>Orden</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Dest</th>
      </tr>
      <?
      foreach($ordenes AS $ord){
      echo "<tr>
             <td>".$ti[$di][$ord][SECTOR]."</td>
             <td>".$ti[$di][$ord][TIPO]."-$ord</td>
             <td>".$ti[$di][$ord][FECHA]."</td>
             <td>".$ti[$di][$ord][ESTADO]."</td>
             <td>".$ti[$di][$ord][DESTINO]."</td>
            </tr>";
      }
      ?>
    </table>
    <?
    echo "";
    ?>
     <script language='javascript' type='text/javascript'>
     //<![CDATA[ 
     var tableclientes_Props =  {
                col_0: "select",
                col_2: "select",
                col_3: "select",
                display_all_text: " Todo ",
                sort_select: true,
                rows_counter: true,			 //mostrar cantidad de filas
                rows_counter_text: "✔ Pedidos en la lista:", 
                btn_reset: true, 
                //paging: true,					    //paginar
                //paging_length: 10,			    //3 filas por pagina
                //loader: true, 
                //loader_text: "Filrando datos..."
				};  
     var tabl = "<?= $di?>";
     var tf1 = setFilterGrid(tabl,tableclientes_Props);
      
     //]]> 
     </script>
</div>
</section>
<?php
} //fin foreach?>
</form>

</body>
<footer>
  <div>
    <a href="domi_dias_csv.php">
      <button value="Descargar Excel"> Descargar Excel</button>
    </a>
  </div>
</footer>
</html>

<script>
//submit
function fsubmit(){
		var idform = 'form1';
        document.forms[idform].submit();
}
onLoad="setInterval('fsubmit()',10000);" 
</script>
<?
odbc_close();
mssql_close();
?>
