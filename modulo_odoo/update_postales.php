<? 
//$prueba ='TMP';

if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//MySQL Magento
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

$hini = date("Y-m-d H:i:s");
//buscar ordenes local
$sql = "SELECT 
        codigo_departamento AS cod_dto
        , nombre_departamento AS departamento
        , codigo_municipio AS cod_mun
        , nombre_municipio AS municipio 
        , codigo_postal 
        , barrios_contenidos_en_el_codigo_postal AS barrio
        , veredas_contenidas_en_el_codigo_postal AS vereda
        , tipo
       FROM av_cod_postal
       ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  
  $barrioOk =''; $veredaOk ='';
  
  $barrios = explode("-",$row[barrio]);
  foreach($barrios AS $valor){
    if($valor !=''){
      $barrioOk ='SI';
      $msqlINSERT[] = "INSERT INTO av_cod_postal_veredas (cod_dto, departamento, cod_mun, municipio, codigo_postal, tipo, barrio_vereda ) 
                   VALUES 
                   ( '$row[cod_dto]', '".utf8_encode($row[departamento])."', '$row[cod_mun]', '".utf8_encode($row[municipio])."', '$row[codigo_postal]'
                   , 'Barrio'
                   , '".trim(utf8_encode($valor))."' 
                   )";
    }               
  }
  $veredas = explode("-",$row[vereda]);
  foreach($veredas AS $valor){
    if($valor !=''){
      $veredaOk ='SI';
      $msqlINSERT[] = "INSERT INTO av_cod_postal_veredas (cod_dto, departamento, cod_mun, municipio, codigo_postal, tipo, barrio_vereda ) 
                   VALUES 
                   ( '$row[cod_dto]', '".utf8_encode($row[departamento])."', '$row[cod_mun]', '".utf8_encode($row[municipio])."', '$row[codigo_postal]'
                   , 'Vereda'
                   , '".trim(utf8_encode($valor))."' 
                   )";
    }                  
  }
  if($barrioOk =='' AND $veredaOk ==''){
    $msqlINSERT[] = "INSERT INTO av_cod_postal_veredas (cod_dto, departamento, cod_mun, municipio, codigo_postal, tipo, barrio_vereda ) 
                   VALUES 
                   ( '$row[cod_dto]', '".utf8_encode($row[departamento])."', '$row[cod_mun]', '".utf8_encode($row[municipio])."', '$row[codigo_postal]'
                   , '$row[tipo]'
                   , '".utf8_encode($row[municipio])."' 
                   )";

  }
 }
foreach($msqlINSERT AS $sql){
mysqli_query($mysqliL, $sql) or die(mysqli_error($mysqliL));
} echo "tolis";
//print_r($msqlINSERT); 
?>
  
