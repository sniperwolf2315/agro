<?php
    include('../../conection/conexion_sql.php');
    include('../../../general_funciones.php');
    include('../../services/srv_smsapi.php');


    $conn= new con_sql();


    $data_conse     = $_POST['data_conse'];
    $fecha_regis    = $_POST['date_act'];
    $orden          = $_POST['num_ord_ibs'];
    $factura        = $_POST['num_fac'];
    $vendedor       = $_POST['dat_vende'];
    $auxiliar       = $_POST['dat_aux'];
    $per_seguridad  = $_POST['per_seg'];
    $novedad        = $_POST['dat_novedad'];
    $comen_seg      = $_POST['cometario'];
    $cod_vendedor   = trim(substr($vendedor,0,7));


    // $query_cell         = "SELECT NUM_CEL_SUSUARIO from API_COLABORADORES_AGRO where COD_VENDEDOR = '$cod_vendedor' AND ACTIVO=1 ";
    // $query_cell_arr     = $conn->consultar( $query_cell );
    // $query_cell_arr_rta = mssql_fetch_array($query_cell_arr);
    // $numero_contacto = mssql_fetch_array();
    // $numero_contacto = mssql_fetch_array($conn->consultar("select NUM_CEL_SUSUARIO from API_COLABORADORES_AGRO where ACTIVO=1 "));
    // echo "select NUM_CEL_SUSUARIO from API_COLABORADORES_AGRO where COD_VENDEDOR = '$cod_vendedor' AND ACTIVO=1 ";

    $numero_contacto = mssql_fetch_array($conn->consultar("select NUM_CEL_SUSUARIO from API_COLABORADORES_AGRO where COD_VENDEDOR = '$cod_vendedor' and ACTIVO=1 "));
    $numero_contacto    =$numero_contacto[0];

    

    $auxiliar = ($auxiliar=="")?$vendedor:$auxiliar;
    $comen_seg  =($comen_seg=="")?'PERSONAL DE SEGURIDAD NO DIO UNA DESCRIPCION':strtoupper($comen_seg);

    $consulta_insert = ("
    INSERT INTO  SQLFACTURAS.DBO.API_SANCIONES_AGRO(
        FECHA_REG
        ,NUMERO_ORDE_IBS
        ,NUMERO_FACT_SIA
        ,DATOS_VENDE
        ,DATOS_AUXI
        ,DATOS_SEGURIDAD
        ,NOVEDAD_DESCRIPCION
        ,NUM_CONSECUTIVO
        ,COMENTARIO_SEGURIDAD
        ,NUMERO_NOTIFICACION
        )VALUES(
        getdate(),
        '$orden',
        '$factura',    
        '$vendedor',
        '$auxiliar',
        '$per_seguridad',
        '$novedad',
        $data_conse,
        '$comen_seg',
        '57$numero_contacto'
        ) 
    ");
    $conn->insertar($consulta_insert );
    // echo $consulta_insert;


    // $msq_body="Se ha presentado novedad con la factura $factura, por favor  verificar en  www.sia.agrocampo.vip  , recuerde que dispone de 24 horas máximo para sus observaciones.";
    $msq_body="Se ha presentado novedad con la factura $factura, por favor  verificar el  www.sia.agrocampo.vip antes de 24H.";


    $envio_msj = array(
        'to'            => '57'.$numero_contacto,         //destination number  
        'from'          => 'Agrocampo',                  //sendername made in https://ssl.smsapi.com/sms_settings/sendernames
        'message'       => "$msq_body",    //message content
        'format'        => 'json',           
    );
    
    sms_send($envio_msj);

    /* ACTUALZIAR EL CONSECUTIVO DE SANCION */
    $sql_upt_consecutivo = ("UPDATE API_CONFIGURACION set VALOR= $data_conse where id = 18 and CAMPO='CONSEC_SANCION' ");
    $conn->insertar($sql_upt_consecutivo );

    echo "Registro Exitoso";
    echo '<META HTTP-EQUIV="refresh" CONTENT="1; URL=index.php?usr_seg='.$per_seguridad.'">';
?>