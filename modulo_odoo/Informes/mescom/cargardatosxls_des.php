<?php
require_once('user_conmes.php');
//base sqlServer produccion
require_once('conectarbaseprodmes.php');
//genera datos xls sobre formato

$periodo = $_GET['periodo']; //'202109';
$dias_dcto_periodo = $_GET['dias']; //'202109';

$fecha = date("Y-m-d h:i:s"); // fecha y hora actual
$Mes = substr($periodo, 4, 2);
$mesPro = $Mes + 1;
$Ane = substr($periodo, 0, 4);
$Mesper = array("0", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
$msg = $Mesper[substr($Mes,1,1)] . " - " . $Mesper[$mesPro]; 

$dia_ini_periodo = 16;
$dia_fin_periodo = 15;
$fecha_del = format_fecha(strtotime($Ane . '-' . $Mes . '-' . $dia_fin_periodo));
$fecha_al = format_fecha(strtotime($Ane . '-' . $mesPro . '-' . $dia_fin_periodo));

$f1 = new DateTime($fecha_del);
$f2 = new DateTime($fecha_al);
$dias_fechas = diferencia_dias($f1, $f2);
$ultimo_dia = substr(ultimo_dia($fecha_del),8,2);

$dias_del_periodo = ($ultimo_dia === 31) ? ($dias_fechas - 5) : ($dias_fechas - 4);
// echo "Este periodo va del $fecha_al al $fecha_del con un total de $dias_fechas dias menos $dias_dcto_periodo dias festivos , los dias del periodo son $dias_del_periodo  menos $dias_dcto_periodo total dias reporte " . ($dias_del_periodo - $dias_dcto_periodo) . "<br>";
$miruta = 'Informe/';
$nombref = "Mes_Comercial";
$nombre_fichero = 'Informe_' . $nombref . "_" . $periodo;
$mipath = $miruta . $nombre_fichero . '.xlsx';
$tabla = '';
unlink($mipath);

$arr_totales_ori = ['TOTAL CONTAC CENTER IND', 'TOTAL CONTAC CENTER OBJ', 'TOTAL VENDEDORES', 'TOTAL GENERAL'];
$arr_totales_rem = ['TOTAL CONTAC CENTER VENTA INDIVIDUAL', 'TOTAL CONTAC CENTER VENTA OBJETIVO', 'TOTAL VENTAS CALL A VENDEDORES (VEND114, VEND214)', 'TOTAL GENERAL (VEXT +ALM + CALL IND) - (CALL VEND114 Y VEND214)'];

if (file_exists($miruta)) {
    include('Classes/PHPExcel.php');
    include('Classes/PHPExcel/Reader/Excel2007.php');
    //Crear el objeto Excel: 
    $objPHPExcel = new PHPExcel();
    $mipath2 = $miruta . $nombre_fichero . '.xlsx';
    if (file_exists($mipath2)) {
        $archivo = $mipath2;
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo);
    }
    else { /*
  ██╗███╗░░██╗███████╗░█████╗░██████╗░███╗░░░███╗███████╗  ██████╗░███████╗
  ██║████╗░██║██╔════╝██╔══██╗██╔══██╗████╗░████║██╔════╝  ██╔══██╗██╔════╝
  ██║██╔██╗██║█████╗░░██║░░██║██████╔╝██╔████╔██║█████╗░░  ██║░░██║█████╗░░
  ██║██║╚████║██╔══╝░░██║░░██║██╔══██╗██║╚██╔╝██║██╔══╝░░  ██║░░██║██╔══╝░░
  ██║██║░╚███║██║░░░░░╚█████╔╝██║░░██║██║░╚═╝░██║███████╗  ██████╔╝███████╗
  ╚═╝╚═╝░░╚══╝╚═╝░░░░░░╚════╝░╚═╝░░╚═╝╚═╝░░░░░╚═╝╚══════╝  ╚═════╝░╚══════╝
  ██╗░░░██╗███████╗███╗░░██╗████████╗░█████╗░░██████╗
  ██║░░░██║██╔════╝████╗░██║╚══██╔══╝██╔══██╗██╔════╝
  ╚██╗░██╔╝█████╗░░██╔██╗██║░░░██║░░░███████║╚█████╗░
  ░╚████╔╝░██╔══╝░░██║╚████║░░░██║░░░██╔══██║░╚═══██╗
  ░░╚██╔╝░░███████╗██║░╚███║░░░██║░░░██║░░██║██████╔╝
  ░░░╚═╝░░░╚══════╝╚═╝░░╚══╝░░░╚═╝░░░╚═╝░░╚═╝╚═════╝░         */
        $objPHPExcel->getProperties()->setCreator("Autor: Agrocampo")
            ->setLastModifiedBy("Agrocampo")
            ->setTitle("Informe de Ordenes")
            ->setSubject("Office 2007 XLSX Informe Empresarial")
            ->setDescription("Informe en Office 2007 XLSX")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Resultado de Informe");

        $objWorkSheet = $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorkSheet->setTitle("Informe de Ventas");
        $array_grupos_cabecera = [
            "A4:C4",
            "D4:D5",
            "E4:G4",
            "H4:J4",
            "K4:M4",
            "N4:P4",
            "Q4:S4",
            "T4:V4",
            "W4:Y4",
            "Z4:AB4",
            "AC4:AE4",
            "AF4:AH4",
            "AI4:AK4",
            "AL4:AN4",
            "AO4:AQ4",
            "AR4:AT4",
            "AU4:AW4",
            "AX4:AZ4",
            "BA4:BC4",
            "BD4:BF4",
            "BG4:BI4",
            "BK4:BX4"

        ];

        foreach ($array_grupos_cabecera as $value) { //Combinar  LAS CELDAS DE LA FILA 4
            $objWorkSheet->mergeCells($value);
        }

        $fila = 4;
        $objWorkSheet
            ->setCellValueExplicitByColumnAndRow(0, 1, '')
            ->setCellValueExplicitByColumnAndRow(1, 2, '')
            ->setCellValueExplicitByColumnAndRow(2, 2, "DIAS DEL PERIODO")
            ->setCellValueExplicitByColumnAndRow(3, 2, ($dias_del_periodo - $dias_dcto_periodo))

            ;

        $array_fila_4 = [
            /*A:C  */    'Vendedor',
            /*D    */    'Cuota General',
            /*E:G  */    'Ferreteria',
            /*H:J  */    'Varios',
            /*K:M  */    'Concentrados',
            /*N:P  */    'Pets',
            /*Q:S  */    'Ganaderia',
            /*T:V  */    'Insecticidas y Otros',
            /*W:Y  */    'Invet',
            /*Z:AB */    'Icofarma',
            /*AC:AE*/    'Comervet',
            /*AI:AK*/    'Gabrica',
            /*AL:AN*/    'Biostar',
            /*AR:AT*/    'Coaspharma',
            /*AU:AW*/    'Importados',
            /*AX:AZ*/    'Intervet',
            /*BD:BF*/    'Linea Agil',
            /*BG:BI*/    'Linea Agil Importados',
            /*BJ:BL*/    'Laboratorio BAI',
            /*BM:BO*/    'Tecnocalidad',
            /*BP:BR*/    'TOTAL'
        ];

        $array_fila_5_p1 = [
            /*A5*/    'AREA'
            /*B5*/    , 'Codigo'
            /*C5*/    , 'Nombre'
        ];
        $array_fila_5_cvc = ['CUOTA', 'VENTA', 'CUMPLIMIENTO'];

        $array_fila_5_p2 = [
            /*BU5*/    'VTA.CONTADO'
            /*BV5*/    , 'VTA.CREDITO'
            /*BW5*/    , 'VTA. MIXTA'
            /*BX5*/    , 'NOTAS CR.CONTADO'
            /*BY5*/    , 'NOTAS CR.CREDITO'
            /*BZ5*/    , 'NOTAS CR. MIXTAS'
            /*CA5*/    , 'NOTA DEBITO'
            /*CB5*/    , 'NOTAS DE. COBRADA'
            /*CC5*/    , 'SUBTOTAL'
            /*CD5*/    , 'DISTRI BOLSA'
            /*CE5*/    , 'TOTAL'
            /*CF5*/    , 'LE FALTA'
            /*CG5*/    , 'DIFERENCIA ENTRE TOTAL Y   V.MIXTA(SOLO PARA EXTERNOS)'
            /*CH5*/    , '%'

        ];

        $arreglo_totales = [];
        $tabla = $tabla . '</tr></tr>';

        include('sql_consultas.php'); /* ESTE LLAMADO ES PARA VER EL INFORM Y LA TABLA QUE SE DESEA VER SI ES 1 O 2 O 1Y2 */
        include('../../../general_funciones.php'); /* EN ESTA SECCION SE USO LA FUNCION DE REMOVER CARACTERES */
        $tabla_a_consultar = 3;
        INF_MES_COMERCIAL($periodo, $tabla_a_consultar);

        $tabla_1 = mssql_query(" exec [dbo].[SP_001_INFORME_MES_COMERCIAL]  '$periodo',$tabla_a_consultar");

        $cantidad_filas = mssql_num_rows($tabla_1);
        $cantidad_columnas = mssql_num_fields($tabla_1);
        $columna_tbl_1 = 1;
        $fila_tbl_1 = 7;
        $inicio_col_data = 3;
        $contador = 1;

        if ($tabla_a_consultar === 1) {
            $cantidad_columnas = ($cantidad_columnas - 5);
        }
        else {
            $cantidad_columnas;
        }

        $array_fila_5_dim = new SplFixedArray($cantidad_columnas); /* CANTIDAD DE COLUMNAS DEL EXCEL */
        $array_totales = new SplFixedArray($cantidad_columnas); /* CANTIDAD DE COLUMNAS DEL EXCEL */
        $columna_f4 = 0;
        $fila_4 = 4;
        $tabla = "<table>
        <tr style=' border: 2px solid black;  ' >";

        foreach ($array_fila_4 as $value) { /* BARREMOS EL ARREGLO QUE CONTIENE LAS CABECERAS ejemplo vendedor, cuota gen  */
            if ($columna_f4 === 3) {
                $tabla = $tabla . "<td colspan=" . "1" . " > $value </td> ";
                $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f4, $fila_4, $value);
                $columna_f4 = $columna_f4 + 1;
            }
            else {
                $tabla = $tabla . "<td colspan=" . "3" . "> $value </td> ";
                $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f4, $fila_4, $value);
                $columna_f4 = $columna_f4 + 3;
            }
        } /*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*/

        $columna_f5 = 0;
        $fila_5 = 5;

        while ($columna_f5 <= $array_fila_5_dim->getSize()) {
            if ($columna_f5 === 0) { /* LLENA LA FILA 1 */
                $tabla = $tabla . "<tr  style=' border: 2px solid black;  '>";
                foreach ($array_fila_5_p1 as $value_p1) { /* IMPRIME  A:5 SECCION AREA CODIGO NOMBRE */
                    $tabla = $tabla . "<td colspan=" . "1" . ">$value_p1  </td>";
                    $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f5, $fila_5, $value_p1);
                    if ($columna_f5 === 3) {
                        $tabla = $tabla . "<td > $value_p1  - $columna_f5 <td>";
                        $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f5, ($fila_5 - 1), $value_p1);
                    }
                    $columna_f5++;
                }
            }
            else if ($columna_f5 >= 4 && $columna_f5 <= 60) { // IMPRIME  LAS CUOTAS VENTAS Y CUMPLIMIENTO  60 ES EL DE LAS COLUNAS DE LA TABLA UNA TERMINA EN EL GRUPO DE TOTAL 61 ES EL ESPACIO
                foreach ($array_fila_5_cvc as $value1) {
                    $tabla = $tabla . "<td >$value1 $columna_f5 </td>";
                    $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f5, $fila_5, $value1);
                    $columna_f5++;
                }
            }
            else if ($columna_f5 >= 62 && $columna_f5 <= $array_fila_5_dim->getSize()) { // IMPRIME LA CABECERA DE LA TABLA 2 APARTIR DE VENTAS DE CONTADO
                foreach ($array_fila_5_p2 as $value_p2) {
                    $objWorkSheet->setCellValueExplicitByColumnAndRow($columna_f5, $fila_5, $value_p2);
                    $columna_f5++;
                }
            }
            else {
                $tabla = $tabla . "<td colspan='1'>  $columna_f5</td>";
                $columna_f5++;
            }
        }
        $fin_columna = php_function_total_columnas(($cantidad_columnas)); /* ESTA FUNCION SE USA PARA SABER QUE COLUMNA TERMINA EN BASE A SU TABLA *//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*//*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*/
        //COMBINA AREAS Y MUSTRA DATOS DEL EXCEL
        $AREA_CANTIDAD_GRUPOS = mssql_query("
        WITH AREA_CANTIDAD AS
        (
            select 
            (case when right (area,5)='TOTAL' then replace(area,'TOTAL','') else AREA end )AREA
            ,COUNT(AREA )CANT
            from TBL_CUADRO_" . $tabla_a_consultar . " 
            where AREA not like'%TOTAL_'
            group by area
        )
        SELECT AREA,SUM(CANT) AS CANTIDAD FROM  AREA_CANTIDAD C1 GROUP BY AREA
        ORDER BY 
                        (CASE 
                            WHEN C1.AREA ='VENTA EXTERNA'		         THEN 1
                            WHEN C1.AREA ='VENTA EXTERNA TOTAL'	         THEN 2
                            WHEN C1.AREA ='CONCENTRADOS'		         THEN 3
                            WHEN C1.AREA ='CONCENTRADOS TOTAL'	         THEN 4
                            WHEN C1.AREA ='GATOS'				         THEN 5
                            WHEN C1.AREA ='GATOS TOTAL'			         THEN 6
                            WHEN C1.AREA ='MOSTRADOR'			         THEN 7
                            WHEN C1.AREA ='MOSTRADOR TOTAL'	             THEN 8
                            WHEN C1.AREA ='PEQUENOS'			         THEN 9
                            WHEN C1.AREA ='PEQUENOS TOTAL'		         THEN 10
                            WHEN C1.AREA ='IMPORTADOS'					 THEN 11
                            WHEN C1.AREA ='IMPORTADOS TOTAL'			 THEN 12
                            WHEN C1.AREA ='SEMILLAS  Y FERRETERIA'		 THEN 13
                            WHEN C1.AREA ='SEMILLAS  Y FERRETERIA TOTAL' THEN 14
                            WHEN C1.AREA ='VACUNACION'					 THEN 15
                            WHEN C1.AREA ='VACUNACION TOTAL'			 THEN 16
                            WHEN C1.AREA ='CANALES DIGITALES'		 	 THEN 17
                            WHEN C1.AREA ='CANALES DIGITALES TOTAL'		 THEN 18
                            WHEN C1.AREA ='OTROS'					     THEN 19
                            WHEN C1.AREA ='OTROS TOTAL'					 THEN 20
                            WHEN C1.AREA ='TELEOPERADOR'			     THEN 21
                            WHEN C1.AREA ='TELEOPERADOR TOTAL'			 THEN 22
                            WHEN C1.AREA ='OTROS2'						 THEN 23
                            WHEN C1.AREA ='OTROS2 TOTAL'				 THEN 24
                            WHEN C1.AREA ='TOTAL CONTAC CENTER IND '	 THEN 25
						    WHEN C1.AREA ='TOTAL CONTAC CENTER OBJ '	 THEN 26
						    WHEN C1.AREA ='TOTAL VENDEDORES '			 THEN 27
						    WHEN C1.AREA ='TOTAL GENERAL'				 THEN 28

				        ELSE 29
                        END )
            ");

        $ronda_gp = 0;
        $fila_tbl_1 = 7;
        $styleArray = array('font' => array('bold' => true, 'color' => array('rgb' => 'FF0000'), 'size' => 15, 'name' => 'Verdana'));
        $ult_col_tbl_1 = ($cantidad_columnas - 14); // 14 son la cantidad de columnas de la tabla 2 sin contar la columna AREA
        $colum_total_alm;
        while ($ac = mssql_fetch_array($AREA_CANTIDAD_GRUPOS)) { /* RETORNA LOS GRUPO  O AREAS EN BASE A LA COLUMNA AREA DE LA TABLA TBL_CUADR_O3  */
            if ($ronda_gp === 0) {
                $h = $fila_tbl_1 + $ac[1];
                $d = $fila_tbl_1;
                $objWorkSheet->setCellValueExplicitByColumnAndRow(0, $d, $ac[0]);

                while ($tbl_1 = mssql_fetch_array($tabla_1)) { /* ESTE WHILE RECORRE LA INFORMACION TBL_CUADRO_3 */
                    if ($tbl_1[0] === 'VENTA EXTERNA' || $tbl_1[0] === 'VENTA EXTERNA TOTAL') {
                        $area = str_replace('ZTOTAL', $tbl_1[0], $tbl_1[0]);
                        $CODVEND = str_replace('ZTOTAL', $tbl_1[0], $tbl_1[1]);
                        $NOMVEND = remove_characters(str_replace('ZTOTAL', '', $tbl_1[2]));
                        $tabla = $tabla . "<tr  style=' border: 2px solid black;  '><td>$tbl_1[0]  </td> <td>$CODVEND</td> <td>" . $NOMVEND . "</td>";
                        $objWorkSheet->setCellValueExplicitByColumnAndRow(1, $fila_tbl_1, $CODVEND);
                        $objWorkSheet->setCellValueExplicitByColumnAndRow(2, $fila_tbl_1, $NOMVEND);

                        for ($i = $inicio_col_data; $i <= $cantidad_columnas; $i++) { /* REOCRREMOS LA INFORMACION APARTIR DE LA COLUMNA D DEL EXEL */
                            $valor = ($tbl_1[$i]);
                            $tabla = $tabla . "<td>" . $valor . "</td>";
                            $porcen = php_function_multiplo($i, 3);
                            $valor = ($i > 3 && $i <= $ult_col_tbl_1 && $porcen == 1) ? $valor . '%' : '$ ' . number_format(intval($valor), 2, ",", ".");

                            if ($i >= $ult_col_tbl_1) { /* LA COLUMNA 61 = TOTAL (CUOTA - VENTA - CUMPLIMIENTO) */
                                $objWorkSheet->setCellValueExplicitByColumnAndRow($i + 1, $fila_tbl_1, $valor);
                            }
                            else {
                                $porcen = php_function_multiplo($i, 3);
                                $objWorkSheet->setCellValueExplicitByColumnAndRow($i, $fila_tbl_1, $valor);
                            }
                        }
                        // ### NO SE TOCA OJO 
                        $fila_tbl_1++;
                        $tabla = $tabla . "</tr>";
                        $contador++;
                    }
                }
                $objWorkSheet->mergeCells("A$d:A" . ($h - 2) . "");
                $objWorkSheet->mergeCells("A" . ($h - 1) . ":C" . ($h - 1) . "");
                $objWorkSheet->setCellValueExplicitByColumnAndRow(0, ($h - 1), $area);
                $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // COLOR #DBD8D7
                $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); // ## ASIGNAR EL BORCE DE LA A7 AL ULTIMO REGISTRO DE LA COLUMNA A
                $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // ## CENTRAR EL TEXTO VERTICALMENTE DE LA CULUMNA A
                $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getFont()->setBold(true); // ## ASIGNAR NEGRITA A TODA LA COLUMNA A

                $fila_tbl_1 = $fila_tbl_1 + $ac[1];
                $h = $h + 1;
                $d = $d + 1;
            }
            else {
                $d = $h;
                $h = $d + $ac[1];
                $fila_tbl_1 = $d;
                $objWorkSheet->setCellValueExplicitByColumnAndRow(0, $d, $ac[0]);
                $tabla_1_2 = mssql_query("select * from TBL_CUADRO_" . $tabla_a_consultar . " where area  like'$ac[0]%' order by area,codvend  "); /* TABLA PRINCIPAL */
                $pintar = ($ac[0] === 'TELEOPERADOR' || $ac[0] === 'OTROS2') ? 'si' : 'no';
                $total_grps = 0;
                $d2 = $d;
                $h2 = $h;
                $estilo_borde = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)));
                if ($pintar === 'si') {
                    $total_grps = php_function_total_grupos($d, ($h - 2), 3); // ver cantidad de grupos en un rango 
                    for ($i = 1; $i <= $total_grps; $i++) { //se hacen un total de rondas en base al resultado de la variable  $total_grps
                        $d2h = ($d2 + 2);
                        $objPHPExcel->getActiveSheet()->getStyle("B$d2:B$d2h")->applyFromArray($estilo_borde);
                        $objPHPExcel->getActiveSheet()->getStyle("C$d2:C$d2h")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                        $objPHPExcel->getActiveSheet()->getStyle("A$d2h" . ":" . $fin_columna . $d2h . "")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('E5E1E5'); // color #E5E1E5 o F3F3F3
                        $d2 = $d2h + 1;
                    }
                }
                if ($grupo_anterior === 'OTROS' && $ac[0] === 'TELEOPERADOR') { // capturar la fila en la que debe ir TOTAL ALMACEN
                    $colum_total_alm = ($fila_tbl_1 - 1);
                }
                while ($tbl_1 = mssql_fetch_array($tabla_1_2)) {
                    if ($tbl_1[0] !== ('VENTA EXTERNA') || strlen(substr($tbl_1[0], 0, 5)) === 5) {
                        $area = str_replace($arr_totales_ori, $arr_totales_rem, str_replace('ZTOTAL', $tbl_1[0], $tbl_1[0]));
                        $CODVEND = str_replace('ZTOTAL', $tbl_1[0], $tbl_1[1]);
                        $NOMVEND = remove_characters(str_replace('ZTOTAL', '', $tbl_1[2]));
                        $tabla = $tabla . "<tr  style=' border: 2px solid black;  '><td>$area</td> <td>$CODVEND</td> <td> $NOMVEND</td>";
                        $objWorkSheet->setCellValueExplicitByColumnAndRow(1, $fila_tbl_1, $CODVEND);
                        $objWorkSheet->setCellValueExplicitByColumnAndRow(2, $fila_tbl_1, $NOMVEND);

                        for ($i = $inicio_col_data; $i <= $cantidad_columnas; $i++) {
                            $valor = ($tbl_1[$i]);
                            $tabla = $tabla . "<td>" . $valor . "</td>";
                            $porcen = php_function_multiplo($i, 3);
                            $valor = ($i > 3 && $i <= 61 && $porcen == 1) ? $valor . '%' : '$ ' . number_format(intval($valor), 2, ",", ".");
                            if ($i >= 61) { // ·## 61 es la ultima COLUMNA de la tabla 1 ejemplo TOTAL => CUMPLIMIENTO
                                $objWorkSheet->setCellValueExplicitByColumnAndRow($i + 1, $fila_tbl_1, $valor);
                            }
                            else {
                                $porcen = php_function_multiplo($i, 3);
                                $objWorkSheet->setCellValueExplicitByColumnAndRow($i, $fila_tbl_1, $valor);
                            }
                        }
                    }
                    // ### NO SE TOCA OJO 
                    $fila_tbl_1++;
                    $tabla = $tabla . "</tr>";
                    $contador++;
                }

                if (substr($area, 0, 5) === 'TOTAL') {
                    $objWorkSheet->mergeCells("A$d:C" . ($h - 1) . "");
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($d) . ":$fin_columna" . ($h - 1) . "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // color #DBD8D7
                    $objWorkSheet->setCellValueExplicitByColumnAndRow(0, $d, $$area);
                    $objWorkSheet->setCellValueExplicitByColumnAndRow(0, ($h - 1), $area);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':C' . ($h - 1) . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); // ## ASIGNAR EL BORDE DE LA A7 AL ULTIMO REGISTRO DE LA COLUMNA A
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':C' . ($h - 1) . '')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // ## CENTRAR EL TEXTO VERTICALMENTE DE LA CULUMNA A
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':C' . ($h - 1) . '')->getFont()->setBold(true); // ## ASIGNAR NEGRITA A TODA LA COLUMNA A
                    $area_ant = $ac[0]; // esta variable almacena en area en cada interaccion
                }
                else {
                    $objWorkSheet->mergeCells("A$d:A" . ($h - 2) . ""); // UNIR FILAS DE TOTALES POR AREA
                    $objWorkSheet->mergeCells("A" . ($h - 1) . ":C" . ($h - 1) . ""); // UNIR COLUMNA DE TOTALES POR AREA
                    $objWorkSheet->setCellValueExplicitByColumnAndRow(0, ($h - 1), $area);
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // colro #DBD8D7
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":$fin_columna" . ($h - 1) . "")->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle("A" . ($h - 1) . ":C" . ($h - 1) . "")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); //  ### COMBINAR Y CENTRAR LA CASILLA DE LOS TOTALES
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); // ## ASIGNAR EL BORCE DE LA A7 AL ULTIMO REGISTRO DE LA COLUMNA A
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // ## CENTRAR EL TEXTO VERTICALMENTE DE LA CULUMNA A
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $d . ':A' . ($h - 1) . '')->getFont()->setBold(true); // ## ASIGNAR NEGRITA A TODA LA COLUMNA A
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $d . ':BY'. ($h - 1) . '')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE); //  FORMATO DE COLUMNAS TIPO MONEDA
                }
                $h = $h + 1;
                $d = $h + 1;
            }
            $ronda_gp++;
            $grupo_anterior = $ac[0];
        }
        if ($colum_total_alm > 0) { // ESTA ES LA LINEA DE TOTAL ALMACEN
            $TOTAL_ALMACEN = mssql_query("select * from ##tbl4");
            $cantidad_columnas = mssql_num_fields($TOTAL_ALMACEN);
            $objWorkSheet->mergeCells("A$colum_total_alm:C$colum_total_alm");
            $objWorkSheet->setCellValueExplicitByColumnAndRow(0, ($colum_total_alm - 1), 'OTROS TOTAL');
            $objWorkSheet->setCellValueExplicitByColumnAndRow(0, $colum_total_alm, 'TOTAL ALMACEN');
            while ($tot_almacen = mssql_fetch_array($TOTAL_ALMACEN)) {
                for ($i = 3; $i <= $cantidad_columnas; $i++) {
                    $valor = intval($tot_almacen[$i]);
                    $tabla = $tabla . "<td>" . $valor . "</td>";
                    if ($i >= 61) { // ·## 61 es la ultima COLUMNA de la tabla 1 ejemplo TOTAL => CUMPLIMIENTO
                        $objWorkSheet->setCellValueExplicitByColumnAndRow($i + 1, $colum_total_alm, $valor);
                    }
                    else {
                        $porcen = php_function_multiplo($i, 3);
                        $valor = ($i > 3 && $i <= 61 && $porcen == 1) ? $valor . '%' : '$ ' . number_format(intval($valor), 2, ",", ".");
                        $objWorkSheet->setCellValueExplicitByColumnAndRow($i, $colum_total_alm, $valor);
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20); //alto filas
            $objPHPExcel->getActiveSheet()->getStyle('A' . $colum_total_alm . ':' . $fin_columna . $colum_total_alm)->getFont()->setBold(true); //negrilla
            $objPHPExcel->getActiveSheet()->getStyle('A' . $colum_total_alm . ':C' . $colum_total_alm)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('A' . $colum_total_alm . ':' . $fin_columna . $colum_total_alm)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); //bordes
            $objPHPExcel->getActiveSheet()->getStyle('A' . $colum_total_alm . ':' . $fin_columna . $colum_total_alm)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // colro #DBD8D7
        }
        foreach (range('A', 'D') as $columnID) { // ANCHO DE LAS COLUMNAS 
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        ;
        // $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);//alto filas
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $fin_columna . '5')->getFont()->setBold(true); //negrilla
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $fin_columna . '5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //centrar H
        $objPHPExcel->getActiveSheet()->getStyle('A4:' . $fin_columna . '5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //centrar V
        $objPHPExcel->getActiveSheet()->getStyle('E4:' . $fin_columna . '5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM); //bordes
        $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $objPHPExcel->getActiveSheet()->getStyle('D4:D5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

        $objWorkSheet->freezePaneByColumnAndRow(3, 6); //INMOVILIZAR COLUMNAS Y FILAS

        /*
         ██╗███╗░░██╗███████╗░█████╗░██████╗░███╗░░░███╗███████╗       ██████╗░    ██╗░░██╗
         ██║████╗░██║██╔════╝██╔══██╗██╔══██╗████╗░████║██╔════╝       ██╔══██╗    ██║░░██║
         ██║██╔██╗██║█████╗░░██║░░██║██████╔╝██╔████╔██║█████╗░░       ██████╔╝====███████║
         ██║██║╚████║██╔══╝░░██║░░██║██╔══██╗██║╚██╔╝██║██╔══╝░░       ██╔══██╗====██╔══██║
         ██║██║░╚███║██║░░░░░╚█████╔╝██║░░██║██║░╚═╝░██║███████╗       ██║░░██║    ██║░░██║
         ╚═╝╚═╝░░╚══╝╚═╝░░░░░░╚════╝░╚═╝░░╚═╝╚═╝░░░░░╚═╝╚══════╝       ╚═╝░░╚═╝    ╚═╝░░╚═╝
         */


        $objWorkSheet = $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1)->setTitle("Informe RH");

        $SQL_INF_RH = mssql_query("exec [dbo].[SP_001_INFORME_MES_COMERCIAL_INF_RH] ");
        $cantidad_filas = mssql_num_rows($SQL_INF_RH);
        $cantidad_columnas = mssql_num_fields($SQL_INF_RH);

        $ini_col_inf_rh_tit = 1;
        $ini_fil_inf_rh_tit = 2;
        $ini_fil_inf_rh_grp = 4;

        //SELECCIONO LA CANTIDAD DE GRUPOS QUE EXISTAN EN LA TABLA EJEMPLO : ['AREAS',' IMPORTADOS','GRUPOIMP'];
        $grupos_inf_rh = mssql_query("select   (GRUPO )   from TBL_INF_RH 
                                      group by GRUPO 
                                      order by (
                                            case when GRUPO ='AREAS'      then 1 
                                                 when GRUPO ='IMPORTADOS' then 2 
                                                 when GRUPO ='GRUPOIMP'   then 3 
                                            else 4
                                                end
                                        )");
        // $cabeceras_grupos = ['AREA', 'Suma_de_VLR_EXC_IVA', 'Suma de VLR_INC_IVA'];
        $cabeceras_grupos = ['AREA', 'Suma de VLR_INC_IVA' , 'Suma_de_VLR_EXC_IVA'];
        $ultima_letra = php_function_total_columnas(($cantidad_columnas - 2)); // ULTIMA COLUMNA EN LETRAS EN BASE LA CANTIDAD DE COLUMNAS DE LA CONSULTA  

        $objWorkSheet->mergeCells("B2:" . $ultima_letra . "2"); //UNIR CELDAS
        $objWorkSheet->setCellValueExplicitByColumnAndRow(1, $ini_fil_inf_rh_tit, $msg); // MENSJAE DEL PERIODO  MES - MES   
        $objPHPExcel->getActiveSheet()->getStyle('B2:' . ($ultima_letra) . '2')->getFont()->setBold(true); //negrilla
        $objPHPExcel->getActiveSheet()->getStyle('B2:' . ($ultima_letra) . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //centrar H
        $objPHPExcel->getActiveSheet()->getStyle('B2:' . ($ultima_letra) . '2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //centrar V

        $contador = 0;
        $c_data = 6;
        $inicio_grupo_fila = 4;
        $col_ini_data = 1;
        $desde = 0;
        $hasta = 0;
        $cero = 0;

        // SE EL GRUPO
        while ($grupo = mssql_fetch_array($grupos_inf_rh)) {
            $ca_area = str_replace('GRUPOIMP', 'IMPORTADOS GRP', str_replace('AREAS', 'GENERAL', $grupo[0]));
            $consulta_sql_rh = mssql_query("select * from TBL_INF_RH where grupo = '$grupo[0]'  ");
            $cantidad_filas = mssql_num_rows($consulta_sql_rh);
            $desde = $inicio_grupo_fila;
            $hasta = ($desde + $cantidad_filas + 1);

            $objWorkSheet->mergeCells("B" . ($desde) . ":" . $ultima_letra . ($desde)); // COMBINAR CELDAS
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($desde) . ':' . ($ultima_letra) . ($desde))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //centrar H
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($desde) . ':' . ($ultima_letra) . ($desde))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //centrar V
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($desde) . ':' . ($ultima_letra) . ($desde))->getFont()->setBold(true); //negrilla
            $col_ini_data = 1;
            $objWorkSheet->setCellValueExplicitByColumnAndRow($col_ini_data, $inicio_grupo_fila, $ca_area); // AREA

            foreach ($cabeceras_grupos as $valor) { // # AREA	Suma_de_VLR_EXC_IVA	Suma de VLR_INC_IVA	
                $objWorkSheet->setCellValueExplicitByColumnAndRow($col_ini_data, ($c_data - 1), $valor);
                $objPHPExcel->getActiveSheet()->getStyle('B' . ($c_data - 1) . ':' . ($ultima_letra) . ($c_data - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // COLOR GRIS DE FONDO
                $objPHPExcel->getActiveSheet()->getStyle('B' . ($c_data - 1) . ':' . ($ultima_letra) . ($c_data - 1))->getFont()->setBold(true); //negrilla
                $col_ini_data++;
            }
            while ($datos_rh = mssql_fetch_array($consulta_sql_rh)) { // RECORREMOS EL ARREGLO QUE CONTENE LA CONSULTA SQL 
                $tabla = $tabla . "<tr><td> $datos_rh[0] </td><td> $datos_rh[1] </td><td> $datos_rh[2] </td><td> $datos_rh[3] </td><td> $datos_rh[4] </td></tr>";
                for ($i = 1; $i <= 4; $i++) {
                    $datos = ($datos_rh[$i + 1]);
                    $datos = ($i == 2 || $i == 3) ? '$ ' . number_format(intval($datos_rh[$i + 1]), 2, ",", ".") : strval(($datos_rh[$i + 1]));
                    $objWorkSheet->setCellValueExplicitByColumnAndRow($i, $c_data, $datos);
                }
                if (substr($datos_rh[2], 0, 5) == 'TOTAL') {
                    $objPHPExcel->getActiveSheet()->getStyle('B' . ($hasta) . ':' . ($ultima_letra) . ($hasta))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DBD8D7'); // COLOR GRIS DE FONDO
                    $objPHPExcel->getActiveSheet()->getStyle('B' . ($hasta) . ':' . ($ultima_letra) . ($hasta))->getFont()->setBold(true); //negrilla
                }
                $c_data++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('C' . $desde . ':' . $ultima_letra . $hasta . '')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $tabla = $tabla . '/<tr>';
            $contador++;
            $inicio_grupo_fila = $hasta + 2;
            $c_data = $hasta + 4;
            $objPHPExcel->getActiveSheet()->getStyle('D7:BY' . ($hasta + 10) . '')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
        }

        foreach (range('B', 'D') as $columnID) { // ANCHO DE LAS COLUMNAS 
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(25);
        }
        $objPHPExcel->setActiveSheetIndex(2)->setTitle("Agrocampo"); // TITULO DE LA ULTIMA HOJA
        /* IMPRIMIR EL CONTENITDO DEL EXCEL EN LA INTERFAZ */
        // echo $tabla . '</table><br>'; // IMPIRMIR EN HTML LO QUE SE NECESITA VER EN EL EXCEL
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($mipath2); //Guardar el achivo:
        echo $mipath2;
        return $mipath2;
        // odbc_close($result);
        mssql_close();
    }
}
else {
    echo ' No se puede procesar';
    return;
}
?>
<!-- /*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*/ -->
<!-- /*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx________________________________________xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx______________________________________________*/ -->
<?php
function php_function_total_columnas($num_columnas) /* ESTA FUNCION RETORNA UNA LETRA EN BASE A UN NUMERO */
{
    $crear_columnas = $num_columnas;
    $Contador = 0;
    $Letra = 'A';
    while ($Contador < $crear_columnas) {
        $Contador++;
        $Letra++;
    }
    return $Letra;
}

function php_function_multiplo($valor, $multimplo)
{ /* ESTA FUNCION NOS RETORNA SI UN NUMERO ESL MULTIPLO DE X  EN CUANTO A LOS 2 PARAMETROS */
    $respuesta = 0;
    if (($valor % $multimplo) == 0) {
        $respuesta = 1;
    }
    else {
        $respuesta = 0;
    }
    return $respuesta;
}
function php_function_total_grupos($d, $h, $reg_x_grp)
{ // $reg_x_grp = en el rango que se pasa desde y hasta hacer grupos de cuantos ejemplo 3
    $cons = 0;
    for ($i = $d; $i <= $h; $i++) {
        $i = $i++;
        $cons = $cons + 1;
    }
    return ($cons / $reg_x_grp);
}

function format_fecha($fecha)
{
    return Date('Y-m-d ', $fecha);
}
function diferencia_dias($d1, $d2)
{
    $difference = $d1->diff($d2);
    return $difference->format('%a');
}

function ultimo_dia($date)
{
    return date("Y-m-t", strtotime($date));
}

?>