<? 
//error_reporting(E_ALL); 
/** 
$url = "http://192.168.6.68:8080/WSFacturas/WSGuia.asmx?wsdl"; //prod
//$url = "http://192.168.0.206:32/WSFacturas/WSGuia.asmx?wsdl"; // pruebas
try {
 $client = new SoapClient($url, [ "trace" => 1 ] );
 $result = $client->GenerarGuiaOdoo( [ "IdRegistro" => '1'] );
 foreach($result AS $val1){
  foreach($val1 AS $val2){
    //[3] => \\ServidorServicio\pdfFolderServientrega\326598256.pdf
    $urlPdf = $val2[3];
    foreach($val2 AS $val3){
    //echo $val3;
    }
  }
 }

 
} catch ( SoapFault $e ) {
 echo $e->getMessage();
}

$urlPdf .= " test1.pdf test2.pdf";

echo $urlPdf;

die;
**/

//$prueba ='TMP';

if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);


//POSTGRES
$host = "192.168.6.13"; //192.169.34.251 o localhost
$port = "5432";
$data = "tecnocalidad"; //agrocampo
$user = "tecnocalidad"; //usuario de postgres sistemas
$pass = "TecnoAvancys2019!"; //password de usuario de postgres sistemasqgro

$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string); 

//-----------------------------------------------------------------------------------

$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

$hini = date("Y-m-d H:i:s");
// Odoo saca facturas de ahora

$location = "Bod42";

$sql ="select 
       ai.id as IdRegistro,
       ai.number as NumeroFactura,
       ai.journal_id as TipoFactura,
       '' as NumeroCajas,
       ter.name as Nombres,
       ter.phone as Telefono,
       ter.mobile as Celular,
       ter.street as Direccion,
       (SELECT CAST(rcs.code AS CHAR(10))||CAST(rc.code AS CHAR(10))||' '||rc.name||', '||rcs.name 
          from res_partner 
                 left join res_country_state rcs on rcs.id = state_id
          left join res_city rc on rc.id = city_id
          where res_partner.id = partner_shipping_id ) as Destino,
       (case when ail.name = 'GuiaServientrega' then ail.local_subtotal else
       0 end) as ValorGuia,
       ai.amount_untaxed as SinIva,
       ai.amount_tax as Iva,
       ai.amount_total as ConIva,
       ai.create_date as FechaCreacion
       from account_invoice ai inner join
         account_invoice_line ail on ail.invoice_id = ai.id
       left join
         res_partner ter on ter.id = ai.partner_id
       where 
         ai.type ='out_invoice'
         AND
         ai.origin LIKE '".$location."%'
         and
         ai.id in('684','676','675','674','673','668','671','670') 
    ";
$comaID ='';
$result = pg_query($pg13, $sql) or die( pg_last_error($pg13));
while($row = pg_fetch_assoc($result)){
  $idreg = $row['idregistro'];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  
  foreach($row AS $titulo => $valor){
    //$valor = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', 'ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â´', $valor))));
    IF($titulo =='fechacreacion'){ $valor= date("Y-m-d H:i:s",strtotime($valor));}
    $valor = trim(preg_replace('/\s+/', ' ', str_replace("'", 'Â´', str_replace('"', 'Â´Â´', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $sqlINSERT["$idreg"] = " INSERT INTO odoServientrega$prueba ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}
print_r($sqlINSERT); die; 

//inserta encabezados MSsql
$barra ='';
foreach($sqlINSERT AS $idP => $ins){
  
  if(mssql_query($ins)){
   $contEncabezados += 1;
   $ids .= "$barra$idP";
   $barra ='|';
   }
   else{
    //echo "error<br>"; // $ins<br>".mssql_get_last_message()."<br>";
   }
}
//$urlPdf .= "80-test1.pdf|80-test2.pdf";
$urlPdf .= "80-test2.pdf";
//$ids= "80-454|73-xxx|80-yyyy";
$ids= "80-454";
ECHO "$urlPdf $ids";
die;
//guarda log
if(strlen($encabezados) > 0 ){
 mysqli_query($mysqliL," INSERT INTO magento_orden_log$prueba (reg_guardados, hora_i, cant_reg) VALUES ('$encabezados', '$hini' , '$contEncabezados')") ;
}
?>
  
