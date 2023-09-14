<?

if ($_SESSION["usuARio"] == 'BARONF'
or $_SESSION["usuARio"] == 'SILVAJ'
or $_SESSION["usuARio"] == 'TORRESC'
or $_SESSION["usuARio"] == 'SILVAJ'
or $_SESSION["usuARio"] == 'MORANTESM'
or $_SESSION["usuARio"] == 'DIAZD'
or $_SESSION["usuARio"] == 'CONTCMV'
or $_SESSION["usuARio"] == 'SUAREZM'
or $_SESSION["usuARio"] == 'SUAREZ'
or $_SESSION["usuARio"] == 'RODRIGUEZA'
or $_SESSION["usuARio"] == 'IBANEZV'
or $_SESSION["usuARio"] == 'DIRADMCMV'
or $_SESSION["usuARio"] == 'RODRIGUEZC'
or $_SESSION["usuARio"] == 'PEREZD'
or $_SESSION["usuARio"] == 'LOPEZS'
or $_SESSION["usuARio"] == 'LOPEZJ'
or $_SESSION["usuARio"] == 'GERENCIA'
or $_SESSION["usuARio"] == 'REPORTE'
or $_SESSION["usuARio"] == 'ESTADISTIC'
or $_SESSION["usuARio"] == 'PAEZD'
or $_SESSION["usuARio"] == 'GOMEZD'
or $_SESSION["usuARio"] == 'PARDOD'
or $_SESSION["usuARio"] == 'SANCHEZL'
or $_SESSION["usuARio"] == 'SISTEMSENA'
or $_SESSION["usuARio"] == 'PINILLOSM'
or $_SESSION["usuARio"] == 'RODRIGUEZF'
or $_SESSION["usuARio"] == 'CALDERONM'
or $_SESSION["usuARio"] == 'VILLALOBOS'
or $_SESSION["usuARio"] == 'CIFUENTESE'
or $_SESSION["usuARio"] == 'DIAZD'
or $_SESSION["usuARio"] == 'TORRESC'
or $_SESSION["usuARio"] == 'SOLERA'
or $_SESSION["usuARio"] == 'RAMIREZJ'
or $_SESSION["usuARio"] == 'MARTINEZA'
or $_SESSION["usuARio"] == 'RODRIGUEZJ'
) {
  $_SESSION["dIr"] = 'SI';
}else{
  $_SESSION["dIr"] = 'NO';
}


if ($_SESSION["dIr"] == 'SI') {
  $patrones = 'SI';
}
elseif ($_SESSION["usuARio"] == 'GRAJALESC') {
  $_POST['area'] = 'Mascotas';
  $patrones = 'SI';
}elseif ($_SESSION["usuARio"] == 'VELASQUEZL'or $_SESSION["usuARio"] == 'RAMIREZE') {
  $_POST['area'] = 'Ganaderia';
  $_SESSION['areas'] = 'Ganaderia';
  $patrones = 'SI';
}
elseif ($_SESSION["usuARio"] == 'FERROR') {
  $_POST['area'] = 'Venta Externa';
  $_SESSION['areas'] = 'Venta Externa';

}elseif ($_SESSION["usuARio"] == 'CANTORJ') {
  $_POST['area'] = 'Call';
  $_SESSION['areas'] = 'Teleoperador';
  
}elseif ($_SESSION["usuARio"] == 'CASTILLOW'or $_SESSION["usuARio"] == 'MONTENEGRO'or $_SESSION["usuARio"] == 'VILLAJ' or $_SESSION["usuARio"] == 'RODRIGUEZD') {
  $_POST['area'] = 'Almacen';
  $_SESSION['areas'] = 'Almacen';
  
}elseif ($_SESSION["usuARio"] == 'DIGITAL') {
  $_POST['area'] = 'Rappi';
  $_SESSION['areas'] = 'Almacen';
}
elseif ($_SESSION["usuARio"] == 'POLOP') {
  $_POST['area'] = 'Plagas';
  $_SESSION['areas'] = 'Almacen';
}
else {
  $sql = "select UPHAND from SROUSP WHERE UPUSER = '$_SESSION[usuARio]'";
  $result = odbc_exec($db2conp, $sql);
  while ($row = odbc_fetch_array($result)) {
    if (trim($row["UPHAND"]) == 'VANANDELL') {
      $_POST['vendedor'] = str_replace("EXT", "D", $_SESSION['usuARio']);
    }
    else {
      $_POST['vendedor'] = TRIM($row["UPHAND"]);
    }




    //PESTAR GANADERIA
    if ($_SESSION['usuARio'] == 'CRUZS') {
      $_POST['vendedor'] = 'VENPEST003';
    }
    if ($_SESSION['usuARio'] == 'TORRESY') {
      $_POST['vendedor'] = 'VENPEST004';
    }
    if ($_SESSION['usuARio'] == 'ORJUELAK') {
      $_POST['vendedor'] = 'VENPEST006';
    }
    //if($_SESSION['usuARio'] =='HERNANDEZF'){ $_POST['vendedor'] = 'VENPEST007'; }
    if ($_SESSION['usuARio'] == 'SUAREZM') {
      $_POST['vendedor'] = 'VENPEST007';
    }
    if ($_SESSION['usuARio'] == 'MARTINEZJ') {
      $_POST['vendedor'] = 'VENPEST008';
    }
    if ($_SESSION['usuARio'] == 'TORRESJ') {
      $_POST['vendedor'] = 'VENPEST009';
      // $_POST['vendedor'] = 'VENPEST003';
    }
    if ($_SESSION['usuARio'] == 'MEJIAP') {
      $_POST['vendedor'] = 'VENPEST010';
    }
    if ($_SESSION['usuARio'] == 'GOMEZS') {
      $_POST['vendedor'] = 'VENPEST011';
    }
    if ($_SESSION['usuARio'] == 'SILVAM') {
      $_POST['vendedor'] = 'VENPEST012';
    }
    if ($_SESSION['usuARio'] == 'MORAO') {
      $_POST['vendedor'] = 'VENPEST013';
    }
    if ($_SESSION['usuARio'] == 'GRISALESC') {
      $_POST['vendedor'] = 'VENPEST016';
    }
    if ($_SESSION['usuARio'] == 'VASQUEZY') {
      $_POST['vendedor'] = 'VENPEST021';
    }
    if ($_SESSION['usuARio'] == 'LOPEZJ') {
      $_POST['vendedor'] = 'LOPEZJ';
    }
    if ($_SESSION['usuARio'] == 'VILLALOBOS') {
      $_POST['vendedor'] = 'VILLALOBOS';
    }
    if ($_SESSION['usuARio'] == 'OLARTEO') {
      $_POST['vendedor'] = 'VENPEST003';
    }

    //PESTAR MASCOTAS
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENPEST014';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENPEST015';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENPEST017';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENPEST018';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENPEST019';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'LOPEZJ';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VILLALOBOS';
    }

    // COMERVET
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENDCO01';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENDCO02';
    }
    if ($_SESSION['usuARio'] == 'TRUJILLOT') {
      $_POST['vendedor'] = 'VENDCO03';
    }
    if ($_SESSION['usuARio'] == '') {
      $_POST['vendedor'] = 'VENDCO04';
    }
    if ($_SESSION['usuARio'] == 'LOPEZM') {
      $_POST['vendedor'] = 'VENDCO05';
    }
    if ($_SESSION['usuARio'] == 'OTARTEO') {
      $_POST['vendedor'] = 'VENDCO06';
    }
    if ($_SESSION['usuARio'] == 'SALAMANCAJ') {
      $_POST['vendedor'] = 'VENDCO11';
    }

    //if($_SESSION['usuARio'] =='POLOP'){ $_POST['vendedor'] = 'VENDCO16'; }

    //BODEGAS RAPPI * debe agregar tambien en grupo de vendedroes
    if ($_SESSION['usuARio'] == 'RAPPIBOSQU') {
      $_POST['vendedor'] = 'VEND528';
      $_POST['bod'] = '020';
    }
    if ($_SESSION['usuARio'] == 'ANIMALF') {
      $_POST['vendedor'] = 'VEND549';
      $_POST['bod'] = '030';
    }
    if ($_SESSION['usuARio'] == 'RAPPICHIA') {
      $_POST['vendedor'] = 'VEND560';
      $_POST['bod'] = '040';
    }
    if ($_SESSION['usuARio'] == 'RAPPITOBER') {
      $_POST['vendedor'] = 'VEND561';
      $_POST['bod'] = '050';
    }

    //USUARIO consultas sin bodega bodega
    if ($_SESSION['usuARio'] == 'CONSULTA') {
      $_POST['vendedor'] = 'CONSULTA';
      $_POST['bod'] = '000';
    }
  }
}



//GRUPOS DE VEDEDORES
// pagina web
$vendweb = "'VENDWEB'";
$arrweb = explode(",", $vendweb);
if (in_array("'" . trim($_POST['vendedor']) . "'", $arrweb)) {
  $_POST['area'] = "Pagina WEB";
  $_SESSION['areas'] = 'Almacen';
}


// bodegas rappi
$vendrappi = "'VEND417','VEND549','VEND528','VEND560','VEND561'";
$arrrappi = explode(",", $vendrappi);
if (in_array("'" . trim($_POST['vendedor']) . "'", $arrrappi)) {
  $_POST['area'] = "Rappi";
  $_SESSION['areas'] = 'Almacen';
}


//CALCENTER AGRO
$vendcall = "'VEND321','VEND389','VEND414','VEND419','VEND437','VEND439','VEND443','VEND452','VEND466','VEND468','VEND469',
			 'VEND471','VEND473','VEND475','VEND480','VEND481','VEND483','VEND500','VEND501','VEND502','VEND503','VEND510',
       'VEND515','VEND525','VEND526','VEND530','VEND531','VEND532','VEND533','VEND535','VEND539','VEND540','VEND542',
       'VEND543','VEND553','VEND565','VEND577','VEND578','VEND579','VEND580','VEND583','VEND582','VEND584','VEND585',
       'VEND588','VEND589','VEND590','VEND594','VEND603','VEND607','VEND610'";
//,'VEND524','VEND558','VEND550' son del almacen haciendo teletrabajo
$arrcall = explode(",", $vendcall);
if (in_array("'" . trim($_POST['vendedor']) . "'", $arrcall)) {
  $_POST['area'] = "Call";
}


//VENTA EXTERNA	agrocampo
$vendext = "'VEND014','VEND039','VEND040','VEND045','VEND078','VEND079','VEND081','VEND114','VEND165','VEND183','VEND214', 
	        'VEND252','VEND260','VEND310','VEND313','VEND314','VEND334','VEND338','VENDOTC'";
$arrext = explode(",", $vendext);
if (in_array("'" . trim($_POST['vendedor']) . "'", $arrext)) {
  $_POST['area'] = "Venta Externa";
}


//ALMACEN	         
$vendalm = "'VEND050','VEND164','VEND250','VEND251','VEND302','VEND304','VEND358','VEND363','VEND368','VEND369',
			'VEND380','VEND404','VEND408','VEND425','VEND492','VEND495','VEND498','VEND506','VEND507','VEND509',
			'VEND513','VEND516','VEND517','VEND518','VEND519','VEND520','VEND522','VEND523','VEND524','VEND527',
      'VEND529','VEND534','VEND537','VEND538','VEND541','VEND544','VEND545','VEND547','VEND550','VEND552',
      'VEND554','VEND555','VEND556','VEND557','VEND558','VEND559','VEND563','VEND564','VEND567','VEND568',
      'VEND569','VEND570','VEND571','VEND572','VEND573','VEND574','VEND575','VEND576','VEND888','VEND586',
      'VEND250A','VEND250B','VEND595','VEND597','VEND598' ";
$arralm = explode(",", $vendalm);

if (in_array("'" . trim($_POST['vendedor']) . "'", $arralm)) {
  $_POST['area'] = "Almacen";
}



?>
