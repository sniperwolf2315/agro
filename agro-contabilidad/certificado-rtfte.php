<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<?php
setlocale(LC_ALL, 'es_ES');

?>

</head>
<body>

<?php

/* IMPORTACION DE ARCHIVOS */
include('../nuevo_sia_v2/conection/conexion_ibs.php');
include('../nuevo_sia_v2/conection/conexion_sql.php');

/* DEFINICION DE GLOBALES */
setlocale(LC_MONETARY, 'es_CO');

/* DeFINICION DE VAIRALES */

if(!isset($_GET['tipo_cert']) && !isset($_GET['fecha_desde']) && !isset($_GET['fecha_hasta'])){
    return;
}

$nit          = str_replace('.','',$_GET['nit']);
$certifica    = $_GET['tipo_cert'];
$fec_desde    = $_GET['fecha_desde'];
$fec_hasta    = $_GET['fecha_hasta'];
$fecha_actual = date('Y-m-d H:i:s');
$dia_act      = date("d", strtotime($fecha_actual));
$mes_act      = date("m", strtotime($fecha_actual));
$anio_act     = date("Y", strtotime($fecha_actual));
$monthNum     = $mes_act;
$dateObj      = DateTime::createFromFormat('!m', $monthNum);
$monthName    = strftime('%B', $dateObj->getTimestamp());


$con_ibs = new con_ibs('','','');
$con_sql = new con_sql('');

$mov_cota =[];
$find_count_puc     = [];
$sum_monto          = 0;
$sum_monto_gravable = 0;


if($certifica == 'rfte'){
    $ciudad = 'Bta';
    $puc_cta_origen = "2365";
    $cta_ica = '2365';
}else if ($certifica == 'ica_cota'){
    $ciudad = 'Cta';
    $puc_cta_origen = "2365";
    $cta_ica = '2365';
    
}else{
    return;
}


$query_certificado = ("
SELECT 
TBLMOV1.PSUNM1 as NITEMP, 
TBLDATATER.NANAM1 as EMPRESA, 
TBLMOV1.PSDIM1 CONCEPTO, 
substring(TBLMOV1.PSDODT,0,7 ) as FECHA, 
sum(TBLMOV1.PSAMTR ) as VLRBALANCE 
from AGR620CFAG.SROPST TBLMOV1 join AGR620CFAG.COBNAM TBLDATATER on TBLMOV1.PSUNM1 = TBLDATATER.NATREG 
where TBLMOV1.PSPERI >= ".str_replace('-','',substr($fec_desde,0,7))." 
and TBLMOV1.PSPERI <= ".str_replace('-','',substr($fec_hasta,0,7))." 
and TBLMOV1.PSDIM1 Like '$cta_ica%'
and TBLMOV1.PSUNM1='$nit'
group by 
TBLMOV1.PSUNM1, 
TBLDATATER.NANAM1, 
TBLMOV1.PSDIM1,
substring(TBLMOV1.PSDODT,0,7 ) 
order by substring(TBLMOV1.PSDODT,0,7 )
");

$datos_cert_ibs     = $con_ibs->conectar($query_certificado);

/* SI LA CONSULTA NO RETORNA INFORMACIÓN NO DEBE CONTINUAR*/
if(odbc_num_rows( $datos_cert_ibs )==0){
    echo "
    <div class='container text-center text-secondary'>
        <h6>No cuenta con información</h6>
    </div> 
    ";

}


while( $row = odbc_fetch_array( $datos_cert_ibs ) ) {
    $nit_ibs        = trim($row['NITEMP']);
    $concepto       = trim($row['CONCEPTO']);
    $mes_cert       = substr($row['FECHA'],4,2);
    $valor_balace   =   ($row['VLRBALANCE']*-1);
    $nombre_empresa = $row['EMPRESA'];
    array_push($find_count_puc,array($concepto,$mes_cert,$puc_cta_origen,$valor_balace));
}
?>


<div id="div_certificados" name="div_certificados" class="div_certificados table-responsive text-left">
        <table class="table table-light">
            <tr>
                <div class="parent">
                    <div class="div-logo"> 
                        <img src="/nuevo_sia_v2/assets/images/logo_agro.png" alt="Logo agrocampo" id="logo_agro_cert_ica" name="logo_agro_cert_ica" class="logo_agro_cert_ica">
                    </div>
                    <div class="div-leyenda-1"><strong>AGROCAMPO S.A.S. </strong></div>
                    <br>
                    <div class="div-leyenda-2"><strong> CERTIFICADO DE RETENCION EN LA FUENTE</strong> </div>
                </div>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">AÑO GRAVABLE </td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="1" id="leyenda_3" name="leyenda_3" class="text-left">2023</td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">CIUDAD DONDE SE PRACTICO</td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left">BOGOTÁ</td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">RETENCIÓN PRACTICADA POR</td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left">AGROCAMPO S.A.S</td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">NIT O C.C.</td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left">860.069.284-2</td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">DIRECCIÓN</td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left">CALLE 73 No. 20 - 62</td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">PRACTICADO A </td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left"><?=$nombre_empresa?></td>
            </tr>
            <tr>
                <td colspan="1" id="leyenda_1" name="leyenda_1" class="text-left">NIT O CC </td>
                <td colspan="2" id="leyenda_2" name="leyenda_2" class="text-center">............................................</td>
                <td colspan="7" id="leyenda_3" name="leyenda_3" class="text-left"><?php echo  number_format($nit_ibs,0,',','.'); ?></td>
            </tr>
            
            <tr class="spacin_tr" id="spacin_tr" name="spacin_tr" >
                <td colspan="8" rowspan="1"> 
                <hr class=" class-3">
                </td>
            </tr>
            
            <div class="detalle_retencion_1" name="detalle_retencion_1" id="detalle_retencion_1">
                <tr id="detalle_retencion_2" name="detalle_retencion_2" class="detalle_retencion_2">
                    <td class="text-center"><strong>CONCEPTO DE LA RETENCIÓN</strong></td>
                    <td class="text-center"><strong>MES</strong></td>
                    <td class="text-center"><strong>BASE GRABABLE</strong></td>
                    <td class="text-center"><strong>PORCENTAJE</strong></td>
                    <td class="text-center"><strong>MONTO</strong></td>
                </tr>
            
            <?php
            
        foreach($find_count_puc as $data){
                 /* EJERICIO PARA ICA COTA */                
                if($mes <= $mes_act){
                            
                        $consulta_puc   = "SELECT DESCRIPCION,TARIFA,CUENTA FROM  sqlfacturas.dbo.pucContabilidad where cuenta like'$data[2]%' ";
                        $data_puc       = (($con_sql->consultar($consulta_puc)));
                        $contar_mes = 1;

                        while($dp = mssql_fetch_array($data_puc)){

                            $base_gravable  = ceil($data[3]*100 /  $dp['TARIFA']);
                            $mes            = $data[1] ;
                            $cta_puc        = $dp['CUENTA'] ;
                            $concepto       = $dp['DESCRIPCION'];
                            $porcentaje     = $dp['TARIFA'];
                            $monto          = $data[3];
                            $porcentaje_tar = (($dp['TARIFA']));
                            
                            if($mes == $mes  &&   $cta_puc  == $data[0]){
                                echo"
                                <tr>
                                    <td class='text-left'  >$concepto</td>
                                    <td class='text-center'>$mes</td>
                                    <td class='text-right' >".number_format($base_gravable,0,',','.')." </td>
                                    <td class='text-center'>$porcentaje_tar%</td>
                                    <td class='text-right' >".number_format($monto,0,',','.')."</td>
                                </tr>
                                ";
                                $sum_monto          += $monto;     
                                $sum_monto_gravable += $base_gravable ;
                            }
                        }
                    }
            }   
                
            ?>
            <tr>
                <td><strong> TOTAL</strong> </td>
                <td></td>
                <td class="text-right"><strong><?php echo number_format($sum_monto_gravable,0,',','.');?></strong></td>
                <td></td>
                <td class="text-right"><strong><?php echo number_format($sum_monto,0,',','.')?></strong></td>
            </tr>
        </div>
    </table>
    <br>
    <hr class="class-3">

    <div class="leyenda_certificado" id="leyenda_certificado" name="leyenda_certificado">
            <span>
                RETENCIONES CONSIGNADAS OPORTUNAMENTE EN LA ADMINISTRACION DE IMPUESTOS
                DE LA CIUDAD DE BOGOTA
                EL PRESENTE CERTIFICADO SE EXPIDE EN CUMPLIMIENTO DE LAS NORMAS VIGENTES DEL
                ESTATUTO TRIBUTARIO
            </span>
    </div>
    <div  class="leyenda_certificado_1" id="leyenda_certificado_1" name="leyenda_certificado_1">
            <table>
                <tr>
                    <td>CIUDAD Y FECHA DE EXPEDICIÓN</td>
                    <td>BOGOTÁ D.C.</td>
                    <td><?php echo "$dia_act de $monthName de $anio_act";?></td>
                </tr>
            </table>    
    </div>
    
    <div  class="leyenda_certificado_2" id="leyenda_certificado_2" name="leyenda_certificado_2">
        ESTE CERTIFICADO NO NECESITA FIRMA AUTOGRAFA DE ACUERDO A LO ESTABLECIDO
        EN EL D.R. 836/91 ART. 10
    </div>
</div>
</body>
</html>
