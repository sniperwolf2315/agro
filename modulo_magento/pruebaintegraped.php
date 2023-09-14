<? 
//$prueba ='TMP';

if($prueba =='TMP'){echo "<font size='20' color='red'>PRUEBAS HABILITADO</font><br>br>"; }
// MySQL local
$localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
$claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
$mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }


$sql2 = "SELECT 
           ciudad, Departamento 
        FROM magento_orden WHERE IDPedidoPagina='88237'";
        $result2 = $result2 = mysqli_query($mysqliL, $sql2);
        if($row2 = mysqli_fetch_assoc($result2)){
          $ciudadP = $row2[ciudad];
          $dptoP = $row2[Departamento];
          $Dpto=$ciudadP."-".$dptoP."-";
          }
echo $ciudadP."---".$dptoP;
exit();


//MySQL Magento

/* 
//magento 1
$localhostL 	= 	'67.225.141.1'	; 	$userA 		= 	'agrocom'	;
$claveO		=	'temporal2020lino*'; 	$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
if (mysqli_connect_errno())
  { echo "Failed to connect to MySQL MAgento: " . mysqli_connect_error(); }

//magento 2 1ra ver
$localhostL 	= 	'67.225.141.97'	; 	
$userA 		= 	'agrocom'	;//agroeva
$claveO		=	'M4scot4$-F1nalSv2018=!'; 	
$base_datosL	=	'agrocom_evacom'	;
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);
*/

//magento 2 2da ver
$localhostL 	= 	'3.233.60.4'; 	
$userA 		= 	'nzwcsjbshb';   //agroeva
$claveO		=	'k4SCnVuThJ'; 	
$base_datosL	=	'nzwcsjbshb';
$mysqliM = new mysqli($localhostL,$userA,$claveO,$base_datosL);

//mmsql AgroC
    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlFacturas',$cLink);

//db2 IBS
$db2conp = odbc_connect('IBM-AGROCAMPO-P','ODBC','ODBC');
$db2con = odbc_connect('IBM-AGROCAMPO-P','odbc','odbc');


$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));


require('../_lupap.php');
    $ciudad = '';
    $_POST[barrio] ='';
    $_POST[localidad] ='';
    $_POST[dir_norm] ='';
    $_POST[post_code] ='';
 //agregado
 $idPedidoP = new ArrayIterator();
 $codLupapP = new ArrayIterator();
$ff=0;  
//require_once('user_con_magen.php');
//Vbarrio ='' AND CodigoMunicipalidad = '11001000'
$sql = "SELECT IDPedidoPagina, Direccion, IDCliente, ciudad, Sequence FROM magento_orden WHERE Pago != 'contra' ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_row($result)){
      $idPed = trim($row[0]);   //agregado
      $direccion = $row[1];
      $direCliente=utf8_decode($direccion); //agregado
      $direClientesql=substr($direCliente,0,20); //agregado
      $idclienteord = trim($row[2]);    //agregado
      //$ciudad ='bogota';
      $ciudadaBuscar = trim($row[3]);
      //sequence
      $sequenceMgSql = trim($row[4]);     
      //Reemplazamos tildes la A y a
		$ciudadaBuscar = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$ciudadaBuscar);
 
		//Reemplazamos la E y e
		$ciudadaBuscar = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$ciudadaBuscar);
 
		//Reemplazamos la I y i
		$ciudadaBuscar = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$ciudadaBuscar);
 
		//Reemplazamos la O y o
		$ciudadaBuscar = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$ciudadaBuscar);
 
		//Reemplazamos la U y u
		$ciudadaBuscar = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$ciudadaBuscar);
        
        //Reemplazamos la N, n, C y c
		$ciudadaBuscar = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$ciudadaBuscar);
      
      $ciudad=$ciudadaBuscar;
      
      //***AQUI CONSULTA TABLA agrCodigoPostal EN sqlSever para traer codigos postales o insertarlos***
      $copPostLupap="";
      $direClientesql=utf8_decode(substr($direccion,0,20)); //agregado
      $direClientesqlb=substr($direccion,0,20); //agregado
      $direClientesqlN= strtoupper(substr($direccion,0,20));
      //AND left(Direccion,20)='$direClientesql'
      // IdUsuario='$idclienteord'
      $SqlLupa=mssql_query("SELECT IdUsuario as IdUsu, Direccion as DirCliente, CodPostal as codPst  FROM [sqlFacturas].[dbo].[agrCodigoPostal] WHERE (left(Direccion,20)='$direClientesql' OR left(Direccion,20)='$direClientesqlb' OR left(Dirnormalizada,20)='$direClientesqlN')");
      //$resultord = mssql_query($SqlLupa,$cLink);
      if (!mssql_num_rows($SqlLupa)) {
            //CODIGO POSTAL LUPAP
            $resultLU = geocode($ciudad, $direccion);
            $latitudLupa=$_POST[latitud];
            $longitudLupa=$_POST[longitud];
            $LocalidadLupa=utf8_decode($_POST[localidad]);
            $dirNormalizadaLupa=$_POST[dir_norm];
            $codPostaLup = $_POST[post_code];
            $barioLup = utf8_decode($_POST[barrio]);
            $cod_city = $_POST[city_code];
            if($codPostaLup != ""){
                $copPostLupap=$codPostaLup;
                /*$sqlord = "INSERT INTO [sqlFacturas].[dbo].[agrCodigoPostal](IdUsuario,Direccion,Dirnormalizada,Localidad,CodPostal,Barrio,Latitud,Longitud,Ciudad) 
                VALUES('$idclienteord','$direCliente','$dirNormalizadaLupa','$LocalidadLupa','$codPostaLup','$barioLup','$latitudLupa','$longitudLupa','$ciudad')"; 
                mssql_query($sqlord,$cLink);*/
            }else{
                //$codPostaLup = '11001000';
                $codPostaLup = '';
                //$copPostLupap = '11001000';
                $copPostLupap = '';
                //$barioLup="Bogota D. C.";
                $barioLup = "";
            }
      }else{
           if($rowPed = mssql_fetch_array($SqlLupa)){
                //dir base
                $dirBuscarBd = $rowPed[DirCliente];
                $dirBuscarBd=trim($dirBuscarBd);
                //dir magento
                $direClienteMg=utf8_decode($direccion); //agregado
                $direClienteMg=trim($direClienteMg);
                
                $direClienteBad=substr($dirBuscarBd,0,10); //agregado
                $direClienteMag=substr($direClienteMg,0,10); //agregado
                if($direClienteBad == $direClienteMag){
                    //lee de base local codigoslupap
                    $copPostLupap = $rowPed[codPst];
                }else{
                    //consulta en lupap y actualiza codigo postal del cliente en base codigospostales por cambio de direccion
                    $resultLU = geocode($ciudad, $direccion);
                    $latitudLupa=$_POST[latitud];
                    $longitudLupa=$_POST[longitud];
                    $LocalidadLupa=$_POST[localidad];
                    $dirNormalizadaLupa=$_POST[dir_norm];
                    $codPostaLup = $_POST[post_code];
                    $barioLup = $_POST[barrio];
                    $cod_city = $_POST[city_code];
                    $copPostLupap=$codPostaLup;
                    if($codPostaLup != ""){
                        /*$sqlord = "UPDATE [sqlFacturas].[dbo].[agrCodigoPostal] SET Direccion='$direccion', Dirnormalizada='$dirNormalizadaLupa', Localidad='$LocalidadLupa', CodPostal='$codPostaLup', Barrio='$barioLup', Latitud='$latitudLupa', Longitud='$longitudLupa', Ciudad='$ciudad' WHERE IdUsuario='$idclienteord'"; 
                        mssql_query($sqlord,$cLink);*/
                    }
                }
           } 
      }
      //fin AQUI*****
       if($copPostLupap != ""){
          $idPedidoP[$ff]=$idPed;
          $codLupapP[$ff]=trim($copPostLupap);
          $ff++;
      }else{
          $idPedidoP[$ff]=$idPed;
          if($ciudad == 'Bogota' || $ciudad == 'Bogotá' || $ciudad == 'bogota'){
            $codLupapP[$ff]='11001000'; 
          }else{
            $codLupapP[$ff]='';
          }
          $ff++;     
      }
}
 require_once('user_con_magen.php');
$direabuscar="";  //nuevo
$codPostLupap=""; //nuevo
$sql = "SELECT 
           IDPedidoPagina,IDCliente,NombreCliente,Estado,Direccion,Telefono,Celular,CodigoMunicipalidad,Email,
           IDordenAgro,IDestadoAgro,IDDescEstado,IDFacturaAgro,ValorOrden,ValorFlete,vBarrio,Sequence,Fecha,Pago,Notas 
        FROM magento_orden ";
$result = $result = mysqli_query($mysqliL, $sql);
while($row = mysqli_fetch_assoc($result)){
  $idPP = $row[IDPedidoPagina];
  $comaID =',';
  $comaC = '';
  $comaV = '';
  //agregados
  $contarLupas = count($idPedidoP);
  $idPedP=trim($idPP);
  //fin agregados
  foreach($row AS $titulo => $valor){
        $campos .= "$comaC$titulo";
        //nuevos
        /*if($titulo=='Direccion'){
           $direabuscar=$valor;
        }*/
        $codigoDestinoL="";
        if($titulo=='CodigoMunicipalidad'){
            $codCity=trim($valor);
               //nuevo ciclo
                $ff=0;
                while($ff < $contarLupas){
                    if($idPedP == $idPedidoP[$ff]){
                        $valor=trim($codLupapP[$ff]);
                        $codigoDestinoL=$valor;
                        echo "||";
                        $ff=$contarLupas+1;
                    }
                    $ff++;
                }
        }
        //echo $codigoDestinoL."*";
        if($titulo == 'vBarrio'){
           if((substr($valor,0,1) == 'G') || (substr($valor,0,1) == 'D')){
                $valor='11001000';
           }
        }
        if($titulo=='Sequence'){
            $codigoSequence=$valor;
            //echo $codigoSequence;
        }
        $valores .= "$comaV$valor";
        $comaC = ',';
        $comaV = "','";
  }
  echo $valores."<br><br>";
  //echo $codigoDestinoL."||||||";
  $cdPostalis=explode("','",$valores); 
  $campos =''; $valores='';   
      //fin AQUI*****
      //$resultLU = geocode($ciudad, $direccion);  //codigo old lino 
      //agregados new
      $CodPostalNew=$cdPostalis[7];
      $SequenceNew=$cdPostalis[16];
      echo "aqui2[".$CodPostalNew."]<br><br>";
      echo "aqui3[".$SequenceNew."]<br><br>";
      //if($_POST[post_code] != ""){
       if($CodPostalNew != '' && $SequenceNew != ''){
        
          //$idPedidoP[$ff]=$idPed;
          //$codLupapP[$ff]=trim($copPostLupap);
          //$ff++;
          //actualica destinos en ibs******************************************************************
          //echo "<br>----Codigolupa=".$codigoDestinoL;  
            //$vBarrioDest=trim($copPostLupap);
          //$SequenceMg="0000".$SequenceNew;
          //echo "-----sequence=".$SequenceMg;
            /*
            $sqlP="SELECT
            B.region as Departamento
            ,B.city as Ciudad
            ,B.postcode as Codpostalmg
            FROM agro_sales_order A 
            inner join agro_sales_order_address B on A.shipping_address_id = B.entity_id
            WHERE increment_id='$SequenceMg'";
            $resultP = mysqli_query($mysqliM, $sqlP);
            if($rowP = mysqli_fetch_assoc($resultP)){
                $dptoMg=$rowP[Departamento];
                $ciudadMg=$rowP[Ciudad];
            }
             */
             echo "todavia no Inserta dato: $dptoMg-$ciudadMg---";
                //CONSULTA DESTINO EN IBS ***
                //$hayDestIbs=1;
                //if($vBarrioDest != ""){
                $ibsDestino = "SELECT *FROM AGR620CFAG.SRODST WHERE DTDEST='$CodPostalNew'";
                $resultDestino = odbc_exec($db2con, $ibsDestino);
                $rcD=odbc_num_rows($resultDestino);
                if($rcD <= 0){
                    echo "casi Inserta dato----";
                    //actualiza nuevo codigo lupap como destino en ibs
                    //$hayDestIbs=0;
                    if($CodPostalNew != "" && $ciudadMg != ""){
                        $Dpto=$ciudadMg."-".$dptoMg;
                        //$sql2A = "INSERT INTO AGR620CFAG.SRODST (DTDEST,DTDESC) VALUES('$CodPostalNew','$Dpto')";
                        //$result2A = odbc_exec($db2con, $sql2A);
                        echo "Inserta dato----";
                    }
                }
             /*
                //TABLA DOS DESTINOS CLIENTES NUEVOS
                //$hayDestIbs2=1;
                $ibsDestino2 = "SELECT * FROM AGR620CFAG.COBCTLDN WHERE DNMCOD='$vBarrioDest'";
                $resultDestino2 = odbc_exec($db2con, $ibsDestino2);
                $rcD2=odbc_num_rows($resultDestino2);
                if($rcD2 <= 0){
                    //actualiza nuevo codigo lupap como destino en ibs cliente nuevos
                    //$hayDestIbs2=0;
                    if($vBarrioDest != "" && $ciudadMg != ""){
                        $Dpto=$ciudadMg."-".$dptoMg;
                        $CodCity=substr($vBarrioDest,0,2);
                        $sql2B = "INSERT INTO AGR620CFAG.COBCTLDN (DNDCOD, DNDNAM, DNMCOD, DNMNAM) VALUES ('$CodCity','$dptoMg','$vBarrioDest','$ciudadMg')";
                        $result2B = odbc_exec($db2con, $sql2B);
                    }
                }
                */
               // }
                //*****************************************************************************************
      }else{
          $idPedidoP[$ff]=$idPed;
          if($ciudad == 'Bogota' || $ciudad == 'Bogotá' || $ciudad == 'bogota'){
            $codLupapP[$ff]='11001000'; 
          }else{
            $codLupapP[$ff]='';
          }
          $ff++;     
      }
  }
      //fin agregados new
  
mssql_close();
mysqli_close();
odbc_close();

?>
  
