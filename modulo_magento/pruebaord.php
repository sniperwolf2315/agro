<?php
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }
  
$sql = "SELECT 
           IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,
           IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha,Pago,Notas 
        FROM magento_orden ";
$result = $result = mysqli_query($mysqliL, $sql);

require('../_lupap.php');///nuevo

while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  $direabuscar="";  //nuevo
  $codPostLupap=""; //nuevo
  foreach($row AS $titulo => $valor){
    $campos .= "$comaC$titulo";
    //nuevos
    if($titulo=='Direccion'){
       $direabuscar=$valor;
    }
    if($titulo=='CodigoMunicipalidad'){
        $codCity=trim($valor);
        if($codCity == '11001000' || $codCity == '011001000'){
            $direccion = trim($direabuscar);
            $DirLup=substr($direccion,0,30);
            $ciudad ='bogota';
            $Pueblo='Bogotá D.C.';
            $resultLU = geocode($ciudad, $DirLup);
            $Barrio = $_POST[barrio]; 
            $codPostLupap=$_POST[post_code];
            if($codPostLupap != ''){
                $length = 8;
                //$codPostLupapnew = str_pad($codPostLupap,$length,"0", STR_PAD_LEFT);
                $codPostLupapnew = $codPostLupap;
                $valor=trim($codPostLupapnew);
                $codPostLupap="";
            }
      }
    }
    //fin nuevos
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
  }
  echo "<br><br>(".$campos.") values(".$valores.")";
  exit();
}

mysqli_close();
?>