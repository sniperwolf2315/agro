


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PEDIDOS PENDIENTES</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="refresh" content="60">
<link rel="stylesheet" type="text/css" href="../../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../../antenna/auto.js"></script>
<script src="../../../aajquery.js"></script>
<link rel="stylesheet" href="../../../aajquery.css" >

<style type="text/css" media="print">.nover {display:none}</style>
<style type="text/css" >
.frxxs { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:7px;  direction:ltr; }
.frxs  { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:9px;  direction:ltr; }
.frs   { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:10px; direction:ltr; }
.frm   { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:11px; direction:ltr; }
.frl   { font-family:Verdana, Geneva, Bitstream Vera Sans, Tahoma, sans-serif; color:#000000; font-size:13px; direction:ltr; }
.campo { width:90%	}
.boton { width:33%	}
body{
  background-color: #fff
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
   margin: 0;
}
header, footer, nav, aside {
  display: none;
}
</style>

<link rel="stylesheet" type="text/css" href="../../../_tableFilter/filtergrid.css" media="screen" />
<script type="text/javascript" src="../../../_tableFilter/tablefilter_all.js"></script>


</head>

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
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);


if($_POST['empresa'] == ''){
  $_POST['empresa'] = $_SESSION['emp'];
}

if($_SESSION['emp'] != $_POST['empresa']){
  $_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
}

// if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}

/* esta variable enlista todas las ordenes que ya estan despachadas de todo el año*/
$ya_despachadas = $con_sql->consultar($consulta_despachadas);
$no_incluir ='';

while ($ordenes  = mssql_fetch_array($ya_despachadas ) ){
  $no_incluir .="'$ordenes[0]',";
}
$no_incluir=substr($no_incluir,0,-1);



/** SE CONSULTAN LAS ORDENES QUE YA ESTAN QUEMADAS Y DESPACHADAS PARA NO SER INCLUIDAS EN LOS TABLEROS  Y MOSTRAR SOLO LO QUE ESTA PENDIENTE */
$sql = "select * from tablero_dias where orden not in($no_incluir) and fecha>='$hoy_10' order by fecha";

$result = mysqli_query($mysqliL, $sql) ; //echo $sql.odbc_errormsg();
echo ($result->num_rows==0)?'No hay datos para mostrar': '';

	while($row = mysqli_fetch_assoc($result)){
    
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
  <div align="center" class="frr">
    <font size="+2" color="crimsom">¡Estamos trabajando para mejorar!</font> 
    <font size="+2" color="navy"><br> <b>PEDIDOS WEB PENDIENTES DE TRAMITE </b></font>
  </div>
  
  
  <!-- ██████████████████████████████████████ VALIDACION DE LAS ORDENES REVIVIDAS ████████████████████████████████████████ -->

<section style="width    : 4.5% !important;" class="class='frr'">
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
                $ordenes_repetidas = $con_sql->consultar($consulta_revividas);
                  while($revividas = mssql_fetch_array($ordenes_repetidas)){
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
     /* columna de totales */
     $totalCAL = count($total["$di"]["DOM"]["10"]) + count($total["$di"]["REM"]["10"]) + count($total["$di"]["WEB"]["10"]) + count($total["$di"]["EXP"]["10"]) + count($total["$di"]["SIN"]["10"]);
     $totalENT = count($total["$di"]["WEB"]["60"]) + count($total["$di"]["EXP"]["60"]);
     $totalREM = count($total["$di"]["REM"]["20-45"]) + count($total["$di"]["REM"]["60"]);
     $totalDOM = count($ti["$di"])- $totalREM - $totalENT - $totalCAL;
     
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
      <td><font color="<?= $color?>" size="+1"><u>Domi</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>Reme</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>Call C</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>x Entrega</u></font></td>
    </tr>
    <tr align="center">
      <td><font color="<?= $color?>" size="+1"><?= $totalDOM?> </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalREM?> </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalCAL?> </font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalENT?> </font></td>
    </tr>              
  </table>
              
     <?
    //definion de la tabla
    $titulos = array('DOMI' => 'DOM','REM' => 'REM','WEB-ALM' => 'WEB','EXPR' => 'EXP','SIN-D' => 'SIN','TOTAL' => 'TOTAL');    
    $estados = array('Estado 10' => '10','Estado 20-45' => '20-45','Estado 60' => '60','TOTAL' => 'TOTAL');
      ?>  
    <table align="center" class="frr" style=" width:200%; border-width:thin;border-style:groove;border-color:<?= $color?>;" >    
      <tr>
        <th>
          Estados
        </th>
        <?
        foreach($titulos AS $titulo => $valorDES){
        echo "<th class='frr'>
              $titulo
              </th>";
        }
        ?>
      </tr>
      <?
      /* Columna 1 estados */
      foreach($estados AS $estado => $valorEST){
        /* FILAS DE GRIPUS 10- 20/45 -60 */
      echo "<tr><td class='frr' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>
              <b>$estado </b>
              </td>";
                foreach($titulos AS $titulo => $valorDES){
                  /**COLUMNAS IZQUIERDA A DERECHA PARA ESTADOS 10 -20/45-60 */
                  $valExD = count($total["$di"]["$valorDES"]["$valorEST"]);
              
                  $valT["$di"]["$valorDES"] += $valExD; 
                  $valT["$di"]["$valorEST"] += $valExD;
                  $valTT["$di"] += $valExD;


                  if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"];}
                  if($valorDES =="TOTAL"){ $valExD = $valT["$di"]["$valorEST"];}
                  if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"];}
                  if($valorDES =="TOTAL" AND $valorEST =="TOTAL"){ $valExD = $valTT["$di"];}
                /* valores recuadro de cantidades 
                Estados	      DOMI	REM	WEB-ALM	EXPR	SIN-D	TOTAL
                Estado 10	    11	  27	0	      4	    121	  163
                Estado 20-45	25	  1	  0	      1	    4	    31
                Estado 60	    1	    3	  0	      28	  11	  43
                TOTAL	        37	  31	0	      33	  136	  237
                */
                echo "<td class='frr' align='center' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>$valExD</td>";
        }        
      }
      ?>

    </table>
    <br>
    <div align="center" class="frr aut" style="height:50%; width:100%;">
      <table id="<?= $di?>" align="center" width="100%" class="frr">
      <tr>
        <th>Orden</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Dest</th>
      </tr>
      <?
      foreach($ordenes AS $ord){
      
      echo "<tr>
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
                col_2: "select",
                col_1: "select",
                display_all_text: " Todo ",
                sort_select: true,
                rows_counter: true,			 //mostrar cantidad de filas
                rows_counter_text: "✔ Pedidos en la lista:", 
                btn_reset: true, 
                // paging: true,					    //paginar
                // paging_length: 3,			    //3 filas por pagina
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
    <a href="http://192.168.6.55/moduloI/tableros/domi_dias/domi_dias_csv.php">
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
