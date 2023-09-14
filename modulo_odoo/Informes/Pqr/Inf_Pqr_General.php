<?php
include('../conectarbase.php');
include_once '../usercon_odoo.php';
Conexion::abrirConexion();
$Conn = Conexion::obtenerConexion();
setlocale(LC_TIME, 'es_ES');



$anio_d = trim($_GET['a']);
$mes_d  = trim($_GET['m']);
$dia_d  = trim($_GET['d']);
$anio_h = trim($_GET['ah']);
$mes_h  = trim($_GET['mh']);
$dia_h  = trim($_GET['dh']);
$tc     = trim($_GET['tc']);
$pqr    = trim($_GET['p']);
$sede   = trim($_GET['sede']);
$bodega = 0;
/* 
echo 
''.$anio_d.
'<br>'.$mes_d.
'<br>'.$dia_d.
'<br>'.$anio_.
'<br>'.$mes_h.
'<br>'.$dia_h.
'<br>'.$tc   .
'<br>'.$pqr;
 */
/* 
$ini=trim($_GET['i']);
$fin=trim($_GET['f']);
 */



//$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31 30 
// $feini = $ini;  //$anio."-".$mes."-01";
// $fefin = $fin;  //$anio."-".$mes."-".$dia;


$diaA = date('d');
$mesA = date('m');
//$mesA=$mesA-1;

$fecha = DateTime::createFromFormat('!m', $mesA);
$mesN  = strftime("%B", $fecha->getTimestamp());
$anioA = date('Y');
$consu = 0;
$fd = 3;
$url_avancys_1 = 'http://192.168.6.13:8003/web?debug=#id=';
$url_avancys_2 = 'http://agrocampo.avancyserp.com/web?debug=#id=';
$where_and = '';
$where = '';



$arrayAveriaTransp = new ArrayIterator();
$arrayCodigoVendedor = new ArrayIterator();
$arrayDestinoReposicion = new ArrayIterator();
$arrayFechaCierra = new ArrayIterator();
$arrayFuncionarioSancion = new ArrayIterator();
$arrayGuiaTransp  = new ArrayIterator();
$arrayLote = new ArrayIterator();
$arrayNumeroNotaCredito = new ArrayIterator();
$arrayNumeroOrdenSalida = new ArrayIterator();
$arrayPqr = new ArrayIterator();
$arrayProducto = new ArrayIterator();
$arrayResponsable = new ArrayIterator();
$arrayTipoNotaCredito = new ArrayIterator();
$arrayTipoSolucion = new ArrayIterator();
$arrayTotalSancion = new ArrayIterator();
$arrayTransp = new ArrayIterator();
$arrayValorFlete = new ArrayIterator();
$arrayValorNotaCredito = new ArrayIterator();
$arrayValorSancion = new ArrayIterator();
$codPerfilpreg = new ArrayIterator();
$Buscon = new ArrayIterator();


$pqra = trim($pqr);
$fechaActual = $diaA . " - " . $mesN . " - " . $anioA;


// CONSULTA POR CC A LA BASE 

$queryCC = "
select 
distinct
    rp.id,
    rp.name
from 
    crm_claim cc 
    inner join res_partner rp on rp.id = cc.partner_id  

order by 
    rp.name
    ";

$resultadoCC = $Conn->prepare($queryCC);
$resultadoCC->execute();
$datosCC = $resultadoCC->fetchAll();
$tamanio = count($datosCC);

if ($tamanio === 0) {
    echo 'No hay resultado para esta consulta';
    return;
}

foreach ($datosCC as $datoCC) {
    $parid = $datoCC['id'];
    if ($parid != "") {
        //PQR DE LA CONSULTA POR CC
        $pqrid = $datoCC['name'];
        $Buscon[$consu] = $pqrid;
    } else {
        $pqrid = "";
    }
    $consu++;
};




/* RANGO DE NOMBRES PARA EJECUTAR CONSULTA QUERY  ejemplo: in('us1','us2','us3','us4'...) */
$consult = " in (";
$co = 0;
for ($acon = 0; $acon < $consu; $acon++) {
    $consult = $consult . "'" . $Buscon[$co] . "'";
    if ($acon < $consu - 1) {
        $consult = $consult . ",";
    }
    $co++;
}
$consult = $consult . ") ";



if ($tc === 'normal') {
    $feini = $anio_d . '-' . $mes_d;
    $where_and = "and substring(cast(cc.date as varchar(10)),0,10)   like '" . $feini . "%'  and  rp.name $consult";
} else if ($tc === 'rangos') {

    $feini = $anio_d . "-" . $mes_d . "-" . $dia_d;
    $fefin = $anio_h . "-" . $mes_h . "-" . $dia_h;

    $where_and = "and substring(cast(cc.date as varchar(10)),0,11)  between '" . $feini . "' and '" . $fefin . "' and  rp.name $consult ";
} else if ($tc === 'pqr') {
                             /* ###    //buscar por PQR y por CC ###*/
    if (substr($pqr, 0, 3) != "PQR") {
        $where_and = "and rp.ref = '$pqr'";
    } else {
        $where_and = "and cc.name like '%$pqr'";
    }
} else {
    $where_and = "";
}

if ( $sede ==='port' ) {
    $where ="
    where
	left(f.type, 3)= 'out'
	and (case
    when left(f.number, 4)= 'FEPO' then '008'
    when left(f.number, 4)= 'FEAL' then '005'
    when left(f.number, 2) in ('FD', '01') then '008'
    else '005'
	end) = '008'
    ";
    $bodega = 'P';
}elseif ($sede === 'alm' ) {
    
    $where ="
    where left(f.type,3)='out'
    and (case when left(f.number,4)='FEPO' THEN '005' 
    ELSE (case when left(f.number,4)='FEAL' THEN '005' 
    ELSE (case when left(f.number,2) IN ('FD','01') THEN '008' 
    ELSE '005' end) end) end)='005'
    
    ";
    $bodega = 'A';
}

/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */
/* ########################################################################################################################################################################################################  */





$miruta = '../Informexls/';
$nombre_fichero = 'Inf_Pqr_'.$bodega ;

$r = $r . "<p style=\"text-align: center;\" class=\"z-depth-1\">Pqr Generado a Corte: " . $fechaActual . "</p>"; 

$r = $r . "<table style=\"border: 1px solid #000; width:100%; \" class=\"#439049 green darken-1\">";
$r = $r . "<tr style=\"border-bottom: 1pt solid black; font-size: 0.6em;\">";
$r = $r . "<td style=\"font-weight: bold;text-align: left; padding: 5px;\" class=\"z-depth-1 white-text text-darken-2\">No.</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero de Factura</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Cliente que Realiza el Reclamo</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">No. de Pqr</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Url</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado Pqr</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Estado Actual</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Responsable Asignado</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Inicio</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Fin</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Descripci&oacute;n de la Pqr</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Causa del Reclamo</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Costo Flete de Repocici&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">C&oacute;digo Vendedor</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Destino Reposici&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Fecha Cerrado</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Funcionario sancionado</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Gu&iacute;a</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Pago Transportador</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Laboratorio</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Numero Nota</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Orden de Salida</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Responsable</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Sanci&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo de Soluci&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Tipo de Nota Credito</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Total Sanci&oacute;n</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Transportadora</td>
            <td style=\"font-weight: bold;text-align: left;\" class=\"z-depth-1 white-text text-darken-2\">Valor Nota Cr&eacute;dito</td>
            <td><a href='Informexls/$nombre_fichero.xlsx' class=\"z-depth-1 white-text text-darken-2\">Descargar</a><Strong></td>";
$r = $r . "</tr>";


$query1a = "

select
	cc.id,
	cc.name,
	f.type,
	f.number as numero_factura,
	rp.ref,
	cc.name as numpqr,
	concat(concat(rp.ref,' '), concat(concat(concat(rp.primer_nombre, ' '), concat(rp.primer_apellido, ' ')), concat(rp.segundo_apellido, ' '))) as emp_cliente_reclamo,
	concat(concat(rp.name,' '), cc.name) as pqr,
	concat(concat('$url_avancys_1', cc.id), '&view_type=form&model=crm.claim') as url2,
	concat(concat('$url_avancys_2', cc.id), '&view_type=form&model=crm.claim') as url,
	case
		when cc.active = true then 'Active'
		else 'No Activa'
	end as status,
	case
		when cs.name = 'Fase 1' then 'PQR RECIBIDA'
		else cs.name
	end as estado_actual,
	concat(concat(concat(rp.ref, ' '), concat(concat(concat(rp.primer_nombre, ' '), concat(rp.primer_apellido, ' ')), concat(rp.segundo_apellido, ' '))), rp.email) as asignadoa_responsable,
	cc.date fecha_inicio,
	cc.date_deadline as fecha_limite,
	concat(concat(rp.ref, ' '), concat(concat(concat(rp.primer_nombre, ' '), concat(rp.primer_apellido, ' ')), concat(rp.segundo_apellido, ' '))) as next_respnsable_problema,
	concat(concat(rp.ref, ' '), rp.email) as mail_asignado_to,
	concat(concat(rp.ref, ' '), concat(concat(concat(rp.primer_nombre, ' '), concat(rp.primer_apellido, ' ')), concat(rp.segundo_apellido, ' '))) as responsable1,
	concat(concat(rp.ref, ' '), concat(concat(concat(rp.primer_nombre, ' '), concat(rp.primer_apellido, ' ')), concat(rp.segundo_apellido, ' '))) as responsable_problema2,
	cc.description as descripcion_pqr,
	ct.name as causa_reclamo,
	'' as costo_flete_reposicion,
	ru.login as cod_vendedor,
	rp.name as nom_vendedor,
	cty.name as destino_reposicion,
	cc.write_date as fecha_cerrado,
	'' as funcionario_sancionado,
	'' as guia,
	'' as pago_transportador,
	trim(split_part(qws.name, '-', 1)) as codpregunta,
	qws.name as pregunta,
	aws.name as respuesta,
	'' as laboratorio,
	f.number as numero_nota,
	f.origin as numero_orden_salida,
	'' as responsable,
	'' as sancion,
	ty.type_action as tipo_solucion,
	'' as tipo_nota_credito,
	'' as total_sancion,
	'' as transportadora,
	'' as valor_nota_credito,
	cc.action_next as proxima_accion
from 
	crm_claim cc
left join res_users ru on
	cc.partner_id = ru.partner_id
left join res_company rc on
	cc.company_id = rc.id
left join res_partner rp on
	rp.id = cc.partner_id
left join crm_claim_profiling_rel rcl on
	rcl.claim = cc.id
left join crm_profiling_answer aws on
	rcl.answers = aws.id
left join crm_profiling_question qws on
	qws.id = aws.question_id
left join crm_claim_stage cs on
	cs.id = cc.stage_id
left join type_action_crm ty on
	ty.id = cc.type_action_id
left join crm_claim_type ct on
	ct.id = cc.type_id
left join crm_case_section sv on
	cc.section_id = sv.id
left join res_city cty on
	rp.city_id = cty.id
left join account_invoice f on
	cc.factura_id = f.id
    $where
    $where_and
	
    order by
	cc.name asc
    
    ";
	// and $buscafecha 
/*#######################################################################################################################################################################################################*/
/*#######################################################################################################################################################################################################*/
/*#######################################################################################################################################################################################################*/
/*#######################################################################################################################################################################################################*/
/*#######################################################################################################################################################################################################*/



$query1 = $query1a;
$resultado1a = $Conn->prepare($query1a);
$resultado1a->execute();
$datos1a = $resultado1a->fetchAll();


//carga datos de perfiles***
$f = 0;
$contar = count($arrayPqr);
while ($f < $contar) {
    $codPerfilpreg[$f] = "";
    $arrayPqr[$f] = "";
    $arrayTransp[$f] = "";
    $arrayValorSancion[$f] = "";
    $arrayFuncionarioSancion[$f] = "";
    $arrayTipoNotaCredito[$f] = "";
    $arrayValorNotaCredito[$f] = "";
    $arrayResponsable[$f] = "";
    $arrayNumeroNotaCredito[$f] = "";
    $arrayTipoSolucion[$f] = "";
    $arrayGuiaTransp[$f] = "";
    $arrayCodigoVendedor[$f] = "";
    $arrayFechaCierra[$f] = "";
    $arrayTotalSancion[$f] = "";
    $arrayNumeroOrdenSalida[$f] = "";
    $arrayDestinoReposicion[$f] = "";
    $arrayProducto[$f] = "";
    $arrayLote[$f] = "";
    $arrayValorFlete[$f] = "";
    $arrayAveriaTransp[$f] = "";
    $f++;
}
$f = 0;
foreach ($datos1a as $dato1a) {
    $codpreguntap = $dato1a['codpregunta'];
    $codPerfilpreg[$f] = $codpreguntap;
    $arrayPqr[$f] = $dato1a['numpqr'];
    //transportadora
    if ($codpreguntap == 'R1') {
        $arrayTransp[$f] = $dato1a['respuesta'];
    }
    //guia
    if ($codpreguntap == 'R2') {
        $arrayGuiaTransp[$f] = $dato1a['respuesta'];
    }
    //valor averia transportadora
    if ($codpreguntap == 'R3') {
        $arrayAveriaTransp[$f] = $dato1a['respuesta'];
    }
    //tipo nota credito
    if ($codpreguntap == 'R5') {
        $arrayTipoNotaCredito[$f] = $dato1a['respuesta'];
    }
    //numero nota credito
    if ($codpreguntap == 'R6') {
        $arrayNumeroNotaCredito[$f] = $dato1a['respuesta'];
    }
    //valor nota credito
    if ($codpreguntap == 'R7') {
        $arrayValorNotaCredito[$f] = $dato1a['respuesta'];
    }
    //responsable
    if ($codpreguntap == 'R8') {
        $arrayResponsable[$f] = $dato1a['respuesta'];
    }
    //numero orden salida
    if ($codpreguntap == 'R9') {
        $arrayNumeroOrdenSalida[$f] = $dato1a['respuesta'];
    }
    //codigo vendedor
    if ($codpreguntap == 'R10') {
        $arrayCodigoVendedor[$f] = $dato1a['respuesta'];
    }
    //tipo solucion
    if ($codpreguntap == 'R11') {
        $arrayTipoSolucion[$f] = $dato1a['respuesta'];
    }
    //fecha cierre
    if ($codpreguntap == 'R12') {
        $arrayFechaCierra[$f] = $dato1a['respuesta'];
    }
    //funcionario sancionado
    if ($codpreguntap == 'R13') {
        $arrayFuncionarioSancion[$f] = $dato1a['respuesta'];
    }
    //valor sancion
    if ($codpreguntap == 'R14') {
        $arrayValorSancion[$f] = $dato1a['respuesta'];
    }
    //Valor flete
    if ($codpreguntap == 'R15') {
        $arrayValorFlete[$f] = $dato1a['respuesta'];
    }
    //total sancion
    if ($codpreguntap == 'R16') {
        $arrayTotalSancion[$f] = $dato1a['respuesta'];
    }
    //destino reposicion
    if ($codpreguntap == 'R17') {
        $arrayDestinoReposicion[$f] = $dato1a['respuesta'];
    }
    //producto
    if ($codpreguntap == 'R18') {
        $arrayProducto[$f] = $dato1a['respuesta'];
    }
    //lote
    if ($codpreguntap == 'R19') {
        $arrayLote[$f] = $dato1a['respuesta'];
    }
    $f++;
}


// $r="Informexls/Informe_Inventario008.xlsx"
$mipath = $miruta . $nombre_fichero . '.xlsx';
if (file_exists($miruta)) {
    include('../Classes/PHPExcel.php');
    include('../Classes/PHPExcel/Reader/Excel2007.php');
    //Crear el objeto Excel: 
    $objPHPExcel = new PHPExcel();
    $mipath2 = $miruta . $nombre_fichero . '.xlsx';
    if (file_exists($mipath2)) {
        $archivo = $mipath2;
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
    } else {
        $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
        $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
        $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
        $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
        $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPExcel->getProperties()->setCategory("Resultado de Informe");
        // Add new sheet
        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objWorkSheet->setCellValue('A2', 'No.')
            ->setCellValue('B2', 'Numero de Factura')
            ->setCellValue('C2', 'Cliente que Realiza el Reclamo')
            ->setCellValue('D2', 'No. de Pqr')
            ->setCellValue('E2', 'Url')
            ->setCellValue('F2', 'Estado Pqr')
            ->setCellValue('G2', 'Estado Actual')
            ->setCellValue('H2', 'Responsable Asignado')
            ->setCellValue('I2', 'Fecha Inicio')
            ->setCellValue('J2', 'Fecha Fin')
            ->setCellValue('K2', 'Descripcion de la Pqr')
            ->setCellValue('L2', 'Causa del Reclamo')
            ->setCellValue('M2', 'Costo Flete de Repocicion')
            ->setCellValue('N2', 'Codigo Vendedor')
            ->setCellValue('O2', 'Destino Reposicion')
            ->setCellValue('P2', 'Fecha Cerrado')
            ->setCellValue('Q2', 'Funcionario sancionado')
            ->setCellValue('R2', 'Guia')
            ->setCellValue('S2', 'Pago Transportador')
            ->setCellValue('T2', 'Laboratorio')
            ->setCellValue('U2', 'Numero Nota')
            ->setCellValue('V2', 'Orden de Salida')
            ->setCellValue('W2', 'Responsable')
            ->setCellValue('X2', 'Sancion')
            ->setCellValue('Y2', 'Tipo de Solucion')
            ->setCellValue('Z2', 'Tipo de Nota Credito')
            ->setCellValue('AA2', 'Total Sancion')
            ->setCellValue('AB2', 'Transportadora')
            ->setCellValue('AC2', 'Valor Nota Credito');
        //colocar titulos a las hojas de excel
        //$objWorkSheet->setTitle("$i");
        $objWorkSheet->setTitle('PQR_'.$bodega );
    }
    $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo");
    $objPHPExcel->getProperties()->setLastModifiedBy("Agrocampo");
    $objPHPExcel->getProperties()->setTitle("Informe Agrocampo");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Informe Empresarial");
    $objPHPExcel->getProperties()->setDescription("Informe en Office 2007 XLSX");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Resultado de Informe");

    ///////// revisar 
    //BORRAR DTOS
    $fil = 3;
    $objPHPExcel->setActiveSheetIndex(0);
    $totalreg = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $totalreg = $totalreg + 1;
    while ($fil <= $totalreg) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('W' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('X' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $fil, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $fil, '');
        $fil++;
    }
    //ANCHOS
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(5);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C1', "Pqr Generado a Corte Corte: " . $fechaActual);
    $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

    $resultado1 = $Conn->prepare($query1);
    $resultado1->execute();
    $datos1 = $resultado1->fetchAll();
    $contaPerfiles = count($arrayPqr);
    $i = 1;
    foreach ($datos1 as $dato1) {
        if (($i % 2) == 0) {
            $color = "#AED6F1";
        } else {
            $color = "#E8F6F3";
        }
        $d1 = $dato1['numero_factura'];
        $d2 = $dato1['emp_cliente_reclamo'];
        $codpqr = $dato1['numpqr'];
        $d3 = $dato1['pqr'];
        $d4 = $dato1['url'];
        $d5 = $dato1['status'];
        $d6 = $dato1['estado_actual'];
        $d7 = $dato1['asignadoa_responsable'];
        $d8 = $dato1['fecha_inicio'];
        $d9 = $dato1['fecha_limite'];
        $d10 = $dato1['descripcion_pqr'];
        $d11 = $dato1['causa_reclamo'];
        //$d12=$dato1['costo_flete_reposicion'];
        //$d13=$dato1['cod_vendedor'];
        //$d14=$dato1['destino_reposicion'];
        //$d15=$dato1['fecha_cerrado'];
        //$d16=$dato1['funcionario_sancionado'];
        //$d17=$dato1['guia'];
        //$d18=$dato1['pago_transportador'];
        $d19 = $dato1['laboratorio'];
        //$d20=$dato1['numero_nota'];
        //$d21=$dato1['numero_orden_salida'];
        //$d22=$dato1['responsable'];
        //$d23=$dato1['sancion'];
        //$d24=$dato1['tipo_solucion'];
        //$d25=$dato1['tipo_nota_credito'];
        //$d26=$dato1['total_sancion'];
        $x = 0;
        while ($x < $contaPerfiles) {
            if ($codpqr == $arrayPqr[$x]) {
                if ($codPerfilpreg[$x] == 'R1') {
                    $d27 = $arrayTransp[$x];
                }
                //costo flete reposicion
                if ($codPerfilpreg[$x] == 'R15') {
                    $d12 = $arrayValorFlete[$x];
                }
                //funcionario sancionado 
                if ($codPerfilpreg[$x] == 'R13') {
                    $d16 = $arrayFuncionarioSancion[$x];
                }
                //guia
                if ($codPerfilpreg[$x] == 'R2') {
                    $d17 = $arrayGuiaTransp[$x];
                }
                //codigo vendedor
                if ($codPerfilpreg[$x] == 'R10') {
                    $d13 = $arrayCodigoVendedor[$x];
                }
                //detino reposicion
                if ($codPerfilpreg[$x] == 'R17') {
                    $d14 = $arrayDestinoReposicion[$x];
                }
                //fecha cierre
                if ($codPerfilpreg[$x] == 'R12') {
                    $d15 = $arrayFechaCierra[$x];
                }
                //valor transportador
                if ($codPerfilpreg[$x] == 'R3') {
                    $d18 = $arrayAveriaTransp[$x];
                }
                //tipo nota credito
                if ($codPerfilpreg[$x] == 'R6') {
                    $d20 = $arrayNumeroNotaCredito[$x];
                }
                //numero orden salida
                if ($codPerfilpreg[$x] == 'R9') {
                    $d21 = $arrayNumeroOrdenSalida[$x];
                }
                //responsable
                if ($codPerfilpreg[$x] == 'R8') {
                    $d22 = $arrayResponsable[$x];
                }
                //sancion
                if ($codPerfilpreg[$x] == 'R14') {
                    $d23 = $arrayValorSancion[$x];
                }
                //tipo solucion
                if ($codPerfilpreg[$x] == 'R11') {
                    $d24 = $arrayTipoSolucion[$x];
                }
                //tipo nota credito
                if ($codPerfilpreg[$x] == 'R5') {
                    $d25 = $arrayTipoNotaCredito[$x];
                }
                //total sancion
                if ($codPerfilpreg[$x] == 'R16') {
                    $d26 = $arrayTotalSancion[$x];
                }
                if ($codPerfilpreg[$x] == 'R7') {
                    $d28 = $arrayValorNotaCredito[$x];
                }
            }
            $x++;
        }
        //$d27=$dato1['transportadora'];

        //$d28=$dato1['valor_nota_credito'];

        $r = $r . "<tr style='background-color: $color;  border: 1px solid rgb(120,120,120); font-size: 1.2em;'>";
        $r = $r . "<td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $i . "</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d1 . "</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d2 . "</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d3 . "</td>
                                <td style='width: 19%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'><a href=".$d4." target="."_blank"." > " . $d4 . "</a></td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d5 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d6 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d7 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d8 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d9 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d10 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d11 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d12 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d13 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d14 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d15 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d16 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d17 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d18 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d19 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d20 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d21 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d22 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d23 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d24 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d25 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d26 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d27 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'>" . $d28 . "</td>
                                <td style='width: 10%; font-size: 0.5em; border: 1px solid rgb(120,120,120);height: 10px;padding: 5px;'></td>";
        $r = $r . "</tr>";

        //EXCEL
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $fd, $i)
            ->setCellValue('B' . $fd, $d1)
            ->setCellValueExplicitByColumnAndRow(2, $fd, $d2, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicitByColumnAndRow(3, $fd, $d3, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('E' . $fd, $d4)
            ->setCellValue('F' . $fd, $d5)
            ->setCellValue('G' . $fd, $d6)
            ->setCellValueExplicitByColumnAndRow(7, $fd, $d7, PHPExcel_Cell_DataType::TYPE_STRING)
            //->setCellValue('H'.$fd, $d7)
            ->setCellValueExplicitByColumnAndRow(8, $fd, $d8, PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValue('J' . $fd, $d9)
            ->setCellValueExplicitByColumnAndRow(10, $fd, $d10, PHPExcel_Cell_DataType::TYPE_STRING)
            //->setCellValue('K'.$fd, $d10)
            ->setCellValue('L' . $fd, $d11)
            ->setCellValue('M' . $fd, $d12)
            ->setCellValue('N' . $fd, $d13)
            ->setCellValue('O' . $fd, $d14)
            ->setCellValue('P' . $fd, $d15)
            ->setCellValue('Q' . $fd, $d16)
            ->setCellValue('R' . $fd, $d17)
            ->setCellValue('S' . $fd, $d18)
            ->setCellValue('T' . $fd, $d19)
            ->setCellValue('U' . $fd, $d20)
            ->setCellValue('V' . $fd, $d21)
            ->setCellValue('W' . $fd, $d22)
            ->setCellValue('X' . $fd, $d23)
            ->setCellValue('Y' . $fd, $d24)
            ->setCellValue('Z' . $fd, $d25)
            ->setCellValue('AA' . $fd, $d26)
            ->setCellValue('AB' . $fd, $d27)
            ->setCellValue('AC' . $fd, $d28);
        $i++;
        $fd++;
    }
}


$r = $r . "</table>";
Conexion::cerrarConexion();
//CREA ARCHIVO************************************************************
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el achivo: 
$objWriter->save($mipath2);
echo $r;
//echo $fecha;
