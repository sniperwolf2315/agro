<?php session_start();
 
if($_POST['empresa'] == ''){
	$_POST['empresa'] = $_SESSION['emp'];
	}

if($_SESSION['emp'] != $_POST['empresa']){
	$_SESSION['emp'] = $_POST['empresa'];
	$_POST = array();
	$_POST['empresa'] = $_SESSION['emp'];
	}

//include("../../user_con.php");
//if($_SESSION["clAVe"] == ''){ECHO "<BR><BR> Registrese de nuevo<a href='../../index.php'> aqui</a>"; DIE;}

//db2
	$db2con = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);	
	$db2conp = odbc_connect('IBM-AGROCAMPO-P',odbc,odbc);
//MYSQL
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);


//MSSQL

    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);



$hoy = date("Ymd");
$hoy_1 = date("Ymd",strtotime("$hoy - 1 day"));
$hoy_2 = date("Ymd",strtotime("$hoy - 2 day"));
$hoy_3 = date("Ymd",strtotime("$hoy - 3 day"));
$hoy_4 = date("Ymd",strtotime("$hoy - 4 day"));


$hoy_10 = date("Ymd",strtotime("$hoy - 10 day"));
$n = 1;
$hoy_n = date("Ymd",strtotime("$hoy - $n day"));

$ahora = date("M-d H:i");  

$area ='Moto';
if($area == 'Portos'){}
if($area == 'Calle73'){}
if($area == 'Moto'){ $farea =" AND SROORSHE.OHDEST IN ('1','2','3') ";}
/**
  $sql ="SELECT
			SROORSHE.OHORNO AS ORDEN
			, SUBSTR(SROORSHE.OHODAT,1,4)||'-'||SUBSTR(SROORSHE.OHODAT,5,2)||'-'||SUBSTR(SROORSHE.OHODAT,7,2) AS FECHA_ORDEN
			, (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) AS ESTADO
			, ( SELECT DTDESC FROM AGR620CFAG.SRODST WHERE DTDEST = SROORSHE.OHDEST)  AS DEST
			, '' AS HORA_LIB
			, '' AS OBS
		FROM AGR620CFAG.SROORSHE SROORSHE
		WHERE
		((
		  SROORSHE.OHODAT >= '$hoy_n' 
		  AND 
		  (select max(SRBSOL.OLORDS) FROM AGR620CFAG.SROORSPL SRBSOL WHERE SROORSHE.OHORNO = SRBSOL.OLORNO AND SRBSOL.OLSTAT <> 'D' ) BETWEEN '20' AND '59' 
	 	))
	 	
	 	$farea 
		
		ORDER BY SROORSHE.OHORNO DESC
		
";
**/
$cuantoantes = $hoy_10;

$sql = "select 
         OHORNO AS ORDEN
        ,OHORDT AS TIPO
        ,OHCUNO AS CC
        ,OHORDS AS ESTADO_OV
        ,CASE WHEN
          (SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) = '10'
          THEN '10'
          	ELSE
          	  CASE WHEN
          	    (SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) = '60'
          	    THEN '60'
          	    ELSE
          	      '20-45'
          	  END
          END AS ESTADO	    
        ,(SELECT MIN(OLORDS) AS MIN_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) AS MIN_ESTADO
        ,(SELECT Max(OLORDS) AS MAX_ESTADO FROM SROORSPL SRBSOL WHERE SRBSOL.OLORNO = SROORSHE.OHORNO ) AS MAX_ESTADO
        ,SUBSTR(OHODAT,1,4)||'-'||SUBSTR(OHODAT,5,2)||'-'||SUBSTR(OHODAT,7,2) AS FECHA
        ,CASE WHEN
          OHODAT >= '$hoy_1'
          THEN '1y2'
          	ELSE
          	  CASE WHEN
          	    OHODAT = '$hoy_2'
          	    THEN '1y2'
          	    ELSE
          	      CASE WHEN
          	        OHODAT = '$hoy_3'
          	          THEN '3'
  	                  ELSE
  	                    CASE WHEN
  	                      OHODAT <= '$hoy_4'
  	                      THEN '4 o mas'
  	                    END
  	               END
  	            END
  	          END
  	      AS DIA
  	    , ifnull(( SELECT case when substr(SROORSHE.OHDEST,1,4)= '1100'
  	               then 'DOMI-AGRO'
  	               ELSE
  	                 CASE when substr(SROORSHE.OHDEST,1,4) < 10
  	                 THEN substr(TRIM(DTDESC),1,7)
  	                 ELSE
  	                 'REM-'||substr(TRIM(DTDESC),1,7)
  	                 END
  	               END  
  	        FROM AGR620CFAG.SRODST WHERE DTDEST = SROORSHE.OHDEST),'SIN DEST')  AS DESTINO
                    	    
        FROM AGR620CFAG.SROORSHE SROORSHE

        Where
        OHORDT in( '01', '03', '04', '06', 'D3','D5', 'S2', 'S3', 'S5' )
        AND OHODAT >= '$cuantoantes'
        AND OHSTAT <> 'D'
        AND OHORDS <> '0'
        ORDER BY OHODAT  
        limit 1000
		";
    /*
    21072022 por conversacion con Nancy Morantes se agregan las 01 03 04 06 D3
    OHORDT in('S1','S3')
-- OHORDT in( 'S1', 'S2', 'S3', 'S5' )
-- OHORDT in( 'S1', 'S3' )

*/
  $result = odbc_exec($db2conp, $sql) ; //echo $sql.odbc_errormsg();
  echo ($result->num_rows==0)?'No hay datos para mostrar': '';
  odbc_close();
	while($row = odbc_fetch_array($result)){
		$dia = $row["DIA"];
		$orden = $row["ORDEN"];
		$estado = $row["ESTADO"];
		$row["DEST"] = SUBSTR($row["DESTINO"],0,3);
		if($row["MAX_ESTADO"] =='60'){
		  $e60 .= ",'$row[ORDEN]'" ;
		  }
		$comaC = '';
        $comaV = '';
		foreach($row as $campo => $valor){
		  //datos tablero
		  $ti["$dia"]["$orden"]["$campo"]= utf8_encode(strtoupper($valor));
		  
		  //construye insert MySQL
		  $campos .= "$comaC$campo";
          $valores .= "$comaV$valor";
          $comaC = ',';
          $comaV = "','";
		  }
          $mysqlINSERT["$orden"] = "INSERT INTO tablero_dias ($campos) VALUES ('$valores'); ";
          $campos =''; $valores='';   
    }	
    

	$e60 = substr($e60,1);
	$sqlMS ="SELECT Orden FROM FacRegistroFactura WHERE Fecha >= '$cuantoantes' AND Orden IN($e60)";
	$resultMS = mssql_query($sqlMS); //echo $sqlMS; // or die(mssql_get_last_message());
    while($rowMS = mssql_fetch_assoc($resultMS))
	  { $orden = $rowMS["Orden"]; 
	    foreach($ti AS $day => $algo){
	    unset($ti["$day"]["$orden"]);
	    }
	    unset($mysqlINSERT["$orden"]);
	  }

      //inserta encabezados mysql local
    mysqli_query($mysqliL, "DELETE FROM tablero_dias");
    foreach($mysqlINSERT AS $ins){
    // mysqli_query($mysqliL, $ins) or die(mysqli_error($mysqliL)."<br> $ins");
    if(mysqli_query($mysqliL, $ins)){}else{echo mysqli_error($mysqliL)."<br> $ins<br>"; }
    }
  
if($_GET['mail'] =='SI'){
  exit;
  }
  
  if(count($ti) == 0){ $ti[" ----- SIN PEDIDOS PENDIENTES ----- "] = ''; $tiHORA[] = '';} 
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Web Page</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="../../../antenna.css" id="css" media="all">
<script type="text/javascript" src="../../../antenna/auto.js"></script>
<script src="../../../aajquery.js"></script>
<link rel="stylesheet" href="../../../aajquery.css" >

<style type="text/css" media="print">
.nover {display:none}
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

//submit
}
//onLoad="setInterval('fsubmit()',10000);" 
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
<body class="global" onLoad="setInterval('fsubmit()',900000);">


<form id="form1" name="form1" action="domi_dias.php" method="post" name="submit button1">
<div align="center" class="frr">
 <font size="+2" color="navy"><br> <b>PEDIDOS WEB PENDIENTES DE TRAMITE </b></font>
 <font size="+2" color="crimsom"><b><?= date("d-M H:i");?></b></font> 
</div>

<?
foreach($ti AS $di =>$i2){
    if($di== '1y2'){
    $color = "green";
    $bgcolor = "";
    }elseif($di == 3){
    $color = "DarkOrange";
    $bgcolor = "";
    }elseif($di >= 4){
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
            if($campo =='ESTADO'){ $estado = $vals2;}
            if($campo =='DEST'){ $dest = $vals2;}
          }
          $total["$di"]["$dest"]["$estado"][] = $ord;
        }
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
        <font size="+2" ><b><u><?= count($ti["$di"])?></u></b></font> 
      </th>
    </tr>
    <tr align="center">
      <td><font color="<?= $color?>" size="+1"><u>Domi</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>Reme</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>Call C</u></font></td>
      <td><font color="<?= $color?>" size="+1"><u>x Entrega</u></font></td>
    </tr>
    <tr align="center">
      <td><font color="<?= $color?>" size="+1"><?= $totalDOM ?></font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalREM ?></font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalCAL?></font></td>
      <td><font color="<?= $color?>" size="+1"><?= $totalENT?></font></td>
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
      foreach($estados AS $estado => $valorEST){
      echo "<tr><td class='frr' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>
              <b>$estado</b>
              </td>";
        foreach($titulos AS $titulo => $valorDES){
        $valExD = count($total["$di"]["$valorDES"]["$valorEST"]);
        $valT["$di"]["$valorDES"] += $valExD; 
        $valT["$di"]["$valorEST"] += $valExD;
        $valTT["$di"] += $valExD;
        if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"]; }
        if($valorDES =="TOTAL"){ $valExD = $valT["$di"]["$valorEST"]; }
        if($valorEST =="TOTAL"){ $valExD = $valT["$di"]["$valorDES"]; }
        if($valorDES =="TOTAL" AND $valorEST =="TOTAL"){ $valExD = $valTT["$di"]; }
        echo "<td class='frr' align='center' style='border-radius:0;border-top-width:thin;border-top-style:solid;border-top-color:$color'>
               $valExD
              </td>";
        
               
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
                   				     
				//paging: true,					    //paginar
				//paging_length: 3,			    //3 filas por pagina
				rows_counter: true,			 //mostrar cantidad de filas
				rows_counter_text: "Pedidos en la lista:", 
				btn_reset: true, 
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
</html>

<script>
//submit
function fsubmit(){
		var idform = 'form1';
        document.forms[idform].submit();
}
//onLoad="setInterval('fsubmit()',10000);" 
</script>
<?
odbc_close();
mssql_close();
?>
