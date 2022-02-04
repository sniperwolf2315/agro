<? 
//error_reporting(E_ALL); 
//echo "pere deje el afan";
//exit();
//$prueba ='TMP';

//OJO QUITAR ESTE EXIT PARA PONERLO EN PRODUCCION****
echo "Ojo: deshabilite este exit para ponerlo en produccion.!!!! en el archivo /var/www/html/modulo_odoo/integra_servi/integra_servi.php <br> el crontab automatico ya esta habilitado.";
exit();


$prueba="";
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
//$data = "capacitacion_agrocampo_copia_produccion"; //agrocampo
$data = "capacitacion_agrocampo"; //agrocampo
$user = "agrocampo"; //usuario de postgres sistemas
$pass = "AgroAvancys2021!"; //password de usuario de postgres sistemasqgro

$conn_string = "host=". $host . " port=" . $port . " dbname= " . $data . " user=" . $user . " password=" . $pass;

$pg13 = pg_connect($conn_string); 

//-----------------------------------------------------------------------------------

$hoy = date("Y-m-d");
$hoy_1sem = date("Y-m-d", strtotime("$hoy - 1 week"));

$hini = date("Y-m-d H:i:s");
// Odoo saca facturas de ahora

$hini5 = date("Y-m-d H:i:s", strtotime("$hini + 5 hour"));
$hini5_5 = date("Y-m-d H:i:s", strtotime("$hini5 - 5 minute")); // hoy +5 horas(greenWish), menos 5 minutos

//echo $hini5_5;
//exit();
//create_date
$location = "008";
/*
$sql ="select 
       ai.id as IdRegistro,
       ai.number as NumeroFactura,
       ai.journal_id as TipoFactura,
       (select max(number_of_packages) from stock_picking where picking_invoice_id = ai.id) as NumeroCajas,
       ter.name as Nombres,
       ter.phone as Telefono,
       ter.mobile as Celular,
       ter.street as Direccion,
       (SELECT 
          CAST(rcs.code AS CHAR(10))
          ||CAST(rc.code AS CHAR(10))
          ||SUBSTR(coalesce(CAST(rn.code AS CHAR(10)),'0000000'),LENGTH(coalesce(CAST(rn.code AS CHAR(10)),'0000000'))-2,LENGTH(coalesce(CAST(rn.code AS CHAR(10)),'0000000')))
          ||' '||rc.name||', '||rcs.name 
          from res_partner 
                 left join res_country_state rcs on rcs.id = state_id
          left join res_city rc on rc.id = city_id
          left join res_neighborhood rn on rn.id = neighborhood_id
          where res_partner.id = partner_shipping_id ) as Destino,
       0 as ValorGuia,
       ai.amount_untaxed as SinIva,
       ai.amount_tax as Iva,
       ai.amount_total as ConIva,
       ai.create_date as FechaCreacion,
       SUBSTR(ai.origin,1,3)||'|' as Observaciones
       from account_invoice ai 
       left join
         res_partner ter on ter.id = ai.partner_id
       where
         ai.create_date >= '$hini5_5'
         AND 
         ai.type ='out_invoice'
         AND
         stock_picking_id IS NOT NULL
         AND
         (select max(carrier_tracking_ref) from stock_picking where picking_invoice_id = ai.id) IS NULL     
        AND ai.number='FEAL1000500054'
      "; //ai.origin LIKE '%".$location."%'
  */       
  /*
  EXTRACT(YEAR FROM  ai.create_date)  = '2021' AND EXTRACT(MONTH FROM  ai.create_date) = '08' AND EXTRACT(DAY FROM  ai.create_date) = '11'
         AND
  */
$sql="select
       ai.id as idregistro,
       ai.number as numerofactura,
       ai.journal_id as tipofactura,
       (select max(number_of_packages) from stock_picking where picking_invoice_id = ai.id) as numerocajas,
       ter.name as nombres,
       ter.id as idcliente,
       ter.phone as telefono,
       ter.mobile as celular,
       ter.street as direccion
       from account_invoice ai
       left join res_partner ter on ter.id = ai.partner_id
       where
          ai.type ='out_invoice'
         AND
         stock_picking_id IS NOT NULL
         AND
         (select max(carrier_tracking_ref) from stock_picking where picking_invoice_id = ai.id) IS NULL
         AND
         (select max(number_of_packages) from stock_picking where picking_invoice_id = ai.id) > 0
         AND left(ai.number,4)='FEPO'
";  

//AND ai.number='FEPO 1002001969'
//echo $sql."</br></br>";       
         
$barraID ='';
$result = pg_query($pg13, $sql) or die( pg_last_error($pg13));
while($row = pg_fetch_assoc($result)){ 
  $idreg = $row['idregistro'] + 0 ;
  $numfac = trim($row['numerofactura']);
  $tipofac = $row['tipofactura'];
  $numcajas = $row['numerocajas'];
  $idcliente = $row['idcliente'];
  $nombres = $row['nombres'];
  $telefono = $row['telefono'];
  $celular = $row['celular'];
  $direcc = trim($row['direccion']);
  
  //consulta de guia  -estaba en query anterior
  $sqlMS="SELECT
          ai.id as IdRegistro,
          CAST(rcs.code AS CHAR(10))
          ||CAST(rc.code AS CHAR(10))
          ||SUBSTR(coalesce(CAST(rn.code AS CHAR(10)),'0000000'),LENGTH(coalesce(CAST(rn.code AS CHAR(10)),'0000000'))-2,LENGTH(coalesce(CAST(rn.code AS CHAR(10)),'0000000')))
          ||' '||rc.name||', '||rcs.name as destinox,
          0 as ValorGuia,
          ai.amount_untaxed as siniva,
          ai.amount_tax as iva,
          ai.amount_total as coniva,
          ai.create_date as fechacreacion,
          SUBSTR(ai.origin,1,3)||'|' as observaciones
          from res_partner
          LEFT JOIN account_invoice ai on res_partner.id = ai.partner_shipping_id
          left join res_country_state rcs on rcs.id = state_id
          left join res_city rc on rc.id = city_id
          left join res_neighborhood rn on rn.id = neighborhood_id
          where res_partner.id = ai.partner_shipping_id
        and ai.id ='$idreg'
 ";
 //echo $sqlMS."<br>$idreg<br>";
$result = pg_query($pg13, $sqlMS) or die( pg_last_error($pg13));
if($rowD = pg_fetch_assoc($result)){ 
  $idreg = $rowD['idregistro'] + 0 ;
  //$resultMS = mssql_query($sqlMS);
  //$transp = mssql_fetch_row($resultMS);
  //$rowSQL = mssql_fetch_array($resultMS);
  //**************************************************************
  //$obs = explode("|",$row['observaciones']);   //estaba
  $obs = explode("|",$rowD['observaciones']);   //estaba
  $destino = $rowD['destinox'];   //estaba
  $siniva = $rowD['siniva'];
  $iva = $rowD['iva'];
  $coniva = $rowD['coniva'];
  $bodega = trim($obs[0]);
  $ids .= $barraID.$bodega."-".$idreg;
  $barraID ='|';
  $comaC = '';
  $comaV = '';
}
  //echo "Destino:".$destino;
  //serieMS busca transpotadora principal  estaba 
 $sqlMS = "select 
 atr.nombre as nombre, 
 ata.Unidad as valorguia,
 atr.IdTransportador as transportador
 from [sqlFacturas].[dbo].[agrTarifa] ata 
            left join [sqlFacturas].[dbo].[agrDestino] ade ON ade.IdDestino = ata.IdDestino 
            left join [sqlFacturas].[dbo].[agrTransportador] atr ON atr.IdTransportador = ata.IdTransportador
            where ade.codigo ='".substr($row[destino],0,8)."' and defecto ='1'
            ";
$destiny=substr($row[destino],0,8); 
 //52250000
 //echo "<br>".$sqlMS;
 
 $vlr_dec=200000;
 
 $resultMS = mssql_query($sqlMS);     //estaba
 //$transp = mssql_fetch_row($resultMS);    //estaba
 $transp= new ArrayIterator();
  //estaba
 if($rowC = mssql_fetch_array($resultMS)){
     $transp[0]=$rowC['nombre'];

    //fin estaba
     //$row['valorguia'] = $transp[1];
     $vlr_guia = number_format($rowC['valorguia'],0,'','');   
     $vlr_dec = number_format($coniva,0,'',''); //estaba
     
     echo "<br>Valor declarado: ".$vlr_dec;
     $idtransport = $rowC['transportador'];
     //$vlr_dec = $vlr_guia;//number_format($row['coniva'],0,'',''); //estaba
     $guia ='';
 }
 
 
 //transportador en Odoo
 $sqlOdoo="
    select distinct p.name as nomb, p.city as ciud, p.street as dire, p.city_id as idcy, t.id as idtr, t.name as ntrp, t.cost as cost  
        from res_partner p
        left join sale_order s ON s.partner_invoice_id=p.id
        left join delivery_freight_city_ids t2 ON t2.res_city_id=p.city_id
        left join delivery_freight t ON t2.delivery_freight_id=t.id and t.code_dane is not null 
        where p.id='".$idcliente."' and t.id is not null
 ";
 $resultOdd = pg_query($pg13, $sqlOdoo) or die( pg_last_error($pg13));
 if($rowO = pg_fetch_assoc($resultOdd)){ 
    $idTransp = $rowO['idtr'];
    $nomTransp = $rowO['ntrp'];
    $nomCiud = $rowO['ciud'];
  }
 
 
 //valida cajas
 if($row['numerocajas'] < 1){
    $row['numerocajas'] = 1; 
    }
 
 /*foreach($row AS $titulo => $valor){
    //IF($titulo =='fechacreacion'){ 
        $valor= date("Y-m-d H:i:s",strtotime($valor));
    //}
    //$valor = trim(preg_replace('/\s+/', ' ', str_replace("'", '-', str_replace('"', '--', $valor))));
    $campos .= "$comaC$titulo";
    $valores .= "$comaV$valor";
    $comaC = ',';
    $comaV = "','";
    $comaI = "',";
    $comaD = ",'";
  }
  */
  
  $comaC = ',';
  $comaV = "','";
  $comaI = "',";
  $comaD = ",'";
 
 $campos="IdRegistro,NumeroFactura,TipoFactura,NumeroCajas,Nombres,Telefono,Celular,Direccion,Destino,ValorGuia,SinIva,Iva,ConIva,FechaCreacion,Observaciones";
 
 if ($destiny=='' || $destiny==null){$destiny='11001000';}
 if($vlr_guia=='' || $vlr_guia==null){$vlr_guia=0;}
 if($vlr_dec=='' || $vlr_dec==null){$vlr_dec=200000;}
 
 $valores="'".$idreg.$comaV.$numfac.$comaV.$tipofac.$comaV.$numcajas.$comaV.$nombres.$comaV.$telefono.$comaV.$celular.$comaV.$direcc;
 
 $valores=$valores.$comaV.$destiny.$comaI.$vlr_guia.$comaC.$siniva.$comaC.$iva.$comaC.$coniva.$comaD.$hini.$comaV.$obs[0]."'";
 //1002001971          
 //echo "<br>Transportadora SqlServer:".$transp[0]." Registro: ".$idreg;
  
 //echo "<br>TransportadoraOdoo Cod:$idTransp:".$nomTransp."---".$idreg;
 
 if(($transp[0] =='SERVIENTREGA' || trim($nomTransp) =='SERVIENTREGA') && $idreg!=''){ 
     //$idTransp = '188' ; //id en res_partener de Servientrega
     
     //actualiza tabla de guiasServientrega en SQLServer sin repetir el registro   
     $sqlServ=mssql_query("SELECT *FROM [sqlFacturas].[dbo].[odoServientrega] WHERE IdRegistro='".$idreg."'",$cLink);
     if (!mssql_num_rows($sqlServ)) {
        $sqlv = mssql_query("INSERT INTO [sqlFacturas].[dbo].[odoServientrega$prueba] ($campos) VALUES ($valores); "); // or die(mssql_get_last_message());
        mssql_query($sqlv,$cLink);
        $campos =''; $valores=''; $transp= array();
        echo "<hr><br>Guia fue registrada en la BD con el numReg:".$idreg."<hr><br>";   
      // ENVIA ID A SERVIENTREGA
      $url = "http://192.168.1.68:8080/WSFacturas/WSGuia.asmx?wsdl"; //prod
      //$url = "http://192.168.0.206:32/WSFacturas/WSGuia.asmx?wsdl"; // pruebas
      
      try {
       $client = new SoapClient($url, [ "trace" => 1 ]); // 
       $resultWS = $client->GenerarGuiaOdoo( [ "IdRegistro" => "$idreg" ] );
       foreach($resultWS AS $val1){ //echo "<br>v1: ".$val1;
         foreach($val1 AS $val2){ //echo "<br>v2: ".$val2;
          //[3] => \\ServidorServicio\pdfFolderServientrega\326598256.pdf
          //\\192.168.1.68\TemporalFormatos\GuiasServientrega\326598256.pdf
          $ubics = explode('\\',$val2[2]);
          $guia = $val2[1];
          $urlPdf .= $barra.$bodega."-".$ubics[4];
          $barra = "|";
            foreach($val2 AS $val3){
            //echo "<br>v3: ".$val3;
            }
         }
       }
      } catch ( SoapFault $e ) {
        echo "<br>catch: ".$e->getMessage()."<br>";
      }
      
      } else {
        echo "<hr><br>Fallo: Guia ya esta registrada en la BD con el numReg:".$idreg."<hr><br>";
     }
        
      //$urlPdf .= " test1.pdf test2.pdf";

     // echo "<br>Retorna: ".$urlPdf;

      //die;

   //actualiza valeres en Odoo
  
  //echo "<br>Guia:".$guia." reg:".$idreg;
    //guide_value,declared_value,partner_carrier_id,carrier_tracking_ref
  if($guia != ''){
    $sqlUP = "UPDATE stock_picking SET 
                          guide_value ='$vlr_guia' 
                          , declared_value ='$vlr_dec' 
                          , carrier_tracking_ref ='$guia'
                          WHERE picking_invoice_id ='$idreg'
                         ";
    //echo "<br>".$sqlUP;
    //, partner_carrier_id = '$idTransp'
    pg_query($pg13, $sqlUP);// or die(pg_last_error($pg13)." <br>$sqlUP");
                 
    }

      
  } //FIN IF SERVIENTREGA



} // FIN WHILE PG

//$urlPdf .= "80-test1.pdf|80-test2.pdf";
//$ids= "80-454|73-xxx|80-yyyy";
//ECHO "$urlPdf $ids";
die;
?>
  
