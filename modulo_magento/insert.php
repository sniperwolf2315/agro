<? 
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

$hoy = date("Y-m-d");

/*
$msqlINSERT[] = "INSERT INTO CreacionEncabezadoVentatmp 
                  (IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha,FechaIngreso,FechaFacturacion) 
                  VALUES 
                  ('1','82390515','prueba','0','CRA 40 #28 A 56 SUR LA GUACA','3012303930','3871833','011001000','eligonvilla@hotmail.com','','','','','259686.0000','4500','','100030463','2020-04-02 00:03:28.0000000','0000-00-00 00:00:00.0000000','0000-00-00 00:00:00.0000000')";
 $campos =''; $valores='';

*/
$sql = "SELECT 
           IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,
           IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha 
        FROM magento_orden ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $msqlINSERT["$idPP"] = "INSERT INTO CreacionEncabezadoVentatmp ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

$sql = "SELECT * FROM magento_orden_item";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
 $msqlINSERTitem["$idPP"][] = "INSERT INTO CreacionItemsVentatmp ($campos) VALUES ('$valores'); ";
 $campos =''; $valores='';
}

//inserta encabezados
mssql_query("DELETE FROM CreacionEncabezadoVentatmp ");
mssql_query("DELETE FROM CreacionItemsVentatmp "); 
foreach($msqlINSERT AS $idP => $ins){
  
  if(mssql_query($ins)){
    foreach($msqlINSERTitem["$idP"] AS $insItem){
      if(mssql_query($insItem)){
      //echo "Grabo $insItem <br>";
      }else{
      echo "Error $insItem <br>".mssql_get_last_message()."<br>";
      }
    }
  }else{
  //echo "error $ins<br>".mssql_get_last_message()."<br>";
  }
}

?>
  
