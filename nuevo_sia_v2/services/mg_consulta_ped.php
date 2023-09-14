<?php 
// var_export($_REQUEST);
header_remove("Cache-Control"); 
header_remove("X-Powered-By"); 
header_remove("Server"); 


if($_GET['T']=='' || TRIM($_GET['T'])!='50HLTvC4SsD4Z7gWhGqz5Hp2k' ){
    http_response_code(400);
    echo "No tiene permiso , favor validar los parametros";
    return; 
    exit;
}

/*
http://192.168.6.55/nuevo_sia_v2/services/mg_consulta_ped.php?T=aeGQ9VtiAFj7cqphJPDceWufhzPUIUzo&ped=448692
http://192.168.1.115/nuevo_sia_v2/services/mg_consulta_ped.php?T=50HLTvC4SsD4Z7gWhGqz5Hp2k&ped=448692
*/
/*███████████████████████████████████████████████ IMPORTACIONES███████████████████████████████████████████████████████████████████████████████████████████ */
include_once('../conection/conexion_sql.php');
include_once('../conection/conexion_ibs.php');
include_once('../functions/general_functions.php');
include_once('servientrega_consulta_pedido.php');


/*███████████████████████████████████████████████ CONECCIONES █████████████████████████████████████████████████████████████████████████████████████████████ */
$con    = new con_sql();
$con_ibs = new con_ibs('','CONSULTA','CONSULTA');


/*███████████████████████████████████████████████ VARIABLES █████████████████████████████████████████████████████████████████████████████████████████████ */

$JSON_RESPONSE = "";
$pedido = $_GET['ped'];

 $datos_consulta = [];
 $ls_estados = [
    "10"=>"Cotizacion",
    "20"=>"Orden confirmada",
    "30"=>"Alistamiento",
    "45"=>"Empaque",
    "60"=>"Facturado",
    "60-1"=>"En ruta",
];
$ip_consulta = getRealIP();
$existe = "IBS";



/*███████████████████████████████████████████████ CONSULTAS  █████████████████████████████████████████████████████████████████████████████████████████████*/

/* VALIDAMOS PRIMERO LA  INFORMACIÓN TIENE POR LO MENOS 1 RESULTADO , CASO CONTRARIO NO CONTINUA */
$existe_mgt = mssql_fetch_array($con->consultar("SELECT count(*)from CreacionEncabezadoVenta CEV where CEV.Sequence=$pedido or CEV.IDFacturaAgro='$pedido' or CEV.IDordenAgro='$pedido' "));
$existe_sia = mssql_fetch_array($con->consultar("SELECT count(*)from facRegistroEtiqueta WHERE orden = '$pedido' or factura ='$pedido'"));
$existe_servientrega = mssql_fetch_array($con->consultar("SELECT count(*)from facRegistroEtiqueta WHERE guia='$pedido'"));
// $existe_servientrega = consulta_pedido_servientrega($pedido);





if($existe_mgt[0]==1){
    // echo "existe en pagina \n<br>";
    $existe="PAGINA";
    $consulta_pedido = $con->consultar("SELECT CEV.Sequence PEDIDO,CEV.IDordenAgro ORDENAGRO,CEV.NombreCliente NOM_CLIENTE,CEV.IDCliente DOC_CLIENTE,CEV.Pago ESTADO_PAGO,CEV.IDFacturaAgro as FACTURAGRO ,'' as Guia from CreacionEncabezadoVenta CEV where CEV.Sequence=$pedido or CEV.IDFacturaAgro='$pedido' or CEV.IDordenAgro='$pedido' order by Fecha");
}else if($existe_sia[0]>=1){
    $existe="IBS";
    // echo "existe en IBS-SIA  \n <br>";
    // echo "SELECT top 1 ConsecutivoCarga as PEDIDO,Orden as ORDENAGRO,Nombres NOM_CLIENTE ,Cedula DOC_CLIENTE, '60' ESTADO_PAGO ,Factura as FACTURAGRO,'' as Guia,(select placa from facVehiculo where IdVehiculo = frf.IdVehiculo) as VEHICULO   from facRegistroFactura frf where Orden='$pedido' or Factura='$pedido' order by fecha desc <br>";
    $consulta_pedido = $con->consultar("SELECT top 1 ConsecutivoCarga as PEDIDO,Orden as ORDENAGRO,Nombres NOM_CLIENTE ,Cedula DOC_CLIENTE, '60' ESTADO_PAGO ,Factura as FACTURAGRO,'' as Guia,(select placa from facVehiculo where IdVehiculo = frf.IdVehiculo) as VEHICULO   from facRegistroFactura frf where Orden='$pedido' or Factura='$pedido' order by fecha desc");
    
}else if ($existe_servientrega[0]>=1){
    // echo "existe en SERVIENTREGA  \n <br>";    
    $existe="SERVIENTREGA";
    $empresa_lleva ='SERVIENTREGA';
    $consulta_pedido = $con->consultar("SELECT top 1 max(frf.ConsecutivoCarga )as PEDIDO,fre.Orden as ODENAGRO,frf.Nombres as NOM_CLIENTE,frf.Cedula DOC_CLIENTE, frf.Tipo ESTADO_PAGO ,fre.Factura as FACTURAGRO, fre.Guia GUIA,(select placa from facVehiculo where IdVehiculo = frf.IdVehiculo) as VEHICULO from facRegistroEtiqueta fre inner join facRegistroFactura frf on frf.orden = fre.orden where fre.Guia ='$pedido' group by fre.Orden,frf.Nombres,frf.Cedula,frf.Tipo,fre.Factura,frf.Fecha ,fre.Guia,frf.IdVehiculo  order by frf.fecha desc");
}
else{
    $existe="NO EXISTE";
    echo "<br>Este número de pedido no coincide con nuestra base de datos y la de los proveedores, por tal motivo no tenemos información <br>";
    http_response_code(204);
    return; 
    exit;
}
//  echo gettype($consulta_pedido);



/*███████████████████████████████████████████████  █████████████████████████████████████████████████████████████████████████████████████████████*/
/* SI TIENE RESULTADO BUSCAMOS LA ORDEN EN IBS Y VALIDACMOS SU ESTADO */
while($datos_pedido = mssql_fetch_array($consulta_pedido )){
    /*1. validar 1  */
    // echo $datos_pedido[0].' '.$datos_pedido[1].'<br>';

    $orden_pag_buscar = trim($datos_pedido[0]);
    $orden_ibs_buscar = trim($datos_pedido[1]);
    $nombre           = remove_characters(trim($datos_pedido[2]));
    // $nombre           = (trim($datos_pedido[2]));
    $documento        = trim($datos_pedido[3]);

    $consulta_estado_orden= ("SELECT * from AGR620CFAG.SRBSOH where OHORNO =$orden_ibs_buscar limit 1");

    $num_guia  = $datos_pedido['GUIA'];
    
    // echo "$consulta_estado_orden";
    $datos_orden = $con_ibs->conectar($consulta_estado_orden);
    
    while( $row = odbc_fetch_array( $datos_orden ) ) {
        /* 2. validar  2 */
        $estado_orden =  $row[ 'OHORDS' ];
        $defincion_estado = $ls_estados[$estado_orden];

        /* 
        VALIDAMOS SI SU ESTADO ES 60 O FACTURADO, SI ES ASI LO BUSCAMOS EN LA TABLA DE QUEMADO DE FACTURAS PARA VER SI CONTINUA O SALIO DE AGROCAMPO 
        NUMERO DE ESTADO EJEMPLO NUMERO10-20-30....  
        echo "$estado_orden $defincion_estado";
        */
        if($estado_orden=="60" || $defincion_estado =="Facturado"){
            // echo "aun sigue en agrocampo <br>";
            // echo "SELECT count(*) from facRegistroFactura where Orden='$orden_ibs_buscar'";

            $pedido_despachado_conta = mssql_fetch_array($con->consultar("SELECT count(*) from facRegistroFactura where Orden='$orden_ibs_buscar'"));    

                /* INFORMA SI YA SALIO DE AGRO = ESTA LA FACTURA QUEMADA */
                if(strval($pedido_despachado_conta[0]!="0")){
                    // echo "Salio";
                    $defincion_estado = $ls_estados["60-1"];
                    $estado_orden = "60-1";
                    /* CON ESTA CONSULTA BUSCAMOS SI ESTA EN LA TABLA DE QUEMADO  */
                    // $lleva_domicilio = $con->consultar("SELECT Direccion,Factura as FACTURA, idruta as ruta, CONVERT(varchar,Fecha,121) from facRegistroFactura where Orden='$orden_ibs_buscar'  or factura='$orden_ibs_buscar'");
                    
                    $lleva_domicilio_qry = "
                    SELECT 
                    top 1 
                    frf.Direccion,fre.Factura as FACTURA, 
                    (case when frf.idruta ='' then fre.Guia else frf.idruta end ) as ruta, 
                    CONVERT(varchar,frf.Fecha,121) Fecha,
                    (select placa from facVehiculo where IdVehiculo = frf.IdVehiculo) Vehiculo,
                    (select Nombres from facConductor where IdConductor = frf.IdConductor) Conductor
                    from facRegistroEtiqueta fre 
                    inner join facRegistroFactura frf on frf.orden = fre.orden 
                    where 
                    fre.Orden='$orden_ibs_buscar' 
                    or fre.factura='$orden_ibs_buscar'
                    or fre.Guia ='$num_guia' 
                    group by frf.Direccion,fre.Factura,frf.IdRuta,frf.Factura,frf.fecha,fre.guia,frf.IdVehiculo,frf.IdConductor
                    order by frf.fecha desc
                    ";

                    // echo "<br><br>$lleva_domicilio_qry <br><br>";
                    
                    $lleva_domicilio = $con->consultar($lleva_domicilio_qry );

                    while($datos_transportador = mssql_fetch_array($lleva_domicilio )){
                        $direccion = trim($datos_transportador[0]);
                        $factura   = trim($datos_transportador[1]);
                        $ruta      = trim($datos_transportador[2]);
                        $fecha_despacho = (trim($datos_transportador[3]));
                        
                        /*BUSCAMOS SI ALGUN PIBOX-QUICK-RAPPIBOY O PROPIO SE LLEVO EL DOMICILIO */
                        $lleva_domicilio_veh = $con->consultar("SELECT EMPRESA,PLACA,NOMBRE_1, APELLIDO_1 ,HORA_SALIDA from API_REPARTIDORES where PEDIDO like '%$factura%'");
                        if(mssql_num_rows($lleva_domicilio_veh)>0){

                            while($datos_domi = mssql_fetch_array($lleva_domicilio_veh )){
                                $empresa_lleva   =  $datos_domi[0];
                                $placa_lleva     =  $datos_domi[1];
                                $nombre_completo =  $datos_domi[2].' '.$datos_domi[3];
                                $fecha_despacho  =  ($datos_domi[4]);
                            }
                        }else{
                            $placa_lleva     =  (trim($datos_transportador[4]));
                            $empresa_lleva   =  (trim($datos_transportador[5]));
                        }
                    }
                }

            }else{
                
                $defincion_estado = $ls_estados[$estado_orden];
                $estado_orden =  $row[ 'OHORDS' ];
            }
        
        /* RESPUESTA PARA SERVICIO FORMATO JSON */
$JSON_RESPONSE =  '
    {
    "agr-response":{
        "Ip_consulta":"'.$ip_consulta.'",
        "Pedido_pagina":"'.$orden_pag_buscar.'",
        "Orden_ibs":"'.$orden_ibs_buscar.'",
        "Nombre":"'.$nombre.'",
        "Documento":"'.$documento.'",
        "Estado":"'.$estado_orden.' '.$defincion_estado.'",
        "existe":"'.$existe.'",
        "Transporte":{
            "Fecha":"'.$fecha_despacho.'",
            "Factura":"'.$factura.'",
            "Direccion":"'.$direccion.'",
            "Ruta":"'.$ruta.'",
            "Responsable_entrega":"'.$empresa_lleva.' '. $placa_lleva.' '.$nombre_completo.'",
            "Guia":"'.$num_guia.'"
            }
        }
    }';
    }
}

/* GUARDAMOS UN LOG EN SQL SERVER */
$insert_json = "'$JSON_RESPONSE'";
$con->insertar("insert into API_LOGS (DESC_LOG,VALOR_LOG,HORA_REGISTRO,SERVICIO_ORIGEN,IP_ORIGEN)VALUES('API_CONSULTA_ESTADO',$insert_json,getdate(),'SRV_MG_ORDENES','$ip_consulta')");

$con_ibs->cerrar();
$con->cerrar($con);
echo  $JSON_RESPONSE;
?>