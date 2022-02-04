<?php
$fecha=trim($_GET['fe']);
$emp=trim($_GET['emp']);
$fecha=trim($fecha);
$facturai=trim($_GET['fi']);
$facturai=trim($facturai);
$facturaf=trim($_GET['ff']);
$facturaf=trim($facturaf);
require_once('user_con.php');
            $c=0;
            $tmp='nada';
            //2020-12-11 14:40:13-
            //Z3BISHE.IEFTXT ='Ha ocurrido un error en la ejecución del servicio, por favor intente m'
            $fvalidacion=date("Y-m-d H:i:s-");
            //obteniendo el siguiente
            $sql1="SELECT IEINVN AS FACTURA, IEPREF AS FACTURA_DIAN, IECMPD AS ESTADO, IEFTXT AS NOVEDAD FROM AGR620CF".$emp.".Z3BISHE WHERE IEIDAT='$fecha' AND IEINVN>='$facturai' AND IEINVN<='$facturaf' AND IETYPP='1' AND IECMPD='Y' AND IEPREF='' AND (IEFTXT LIKE '%mensaje%' OR IEFTXT LIKE '%SIN RESPUESTA DESDE DIAN%' OR IEFTXT LIKE '%Ha ocurrido un error%' OR IEFTXT='El cliente no tiene folios disponibles' OR IEFTXT LIKE '%Error en Consumo de Firma%' OR IEFTXT LIKE '%ConsecutivoDocumento%' OR IEFTXT LIKE '%obteniendo el siguiente%')";   
	        $result1 = odbc_exec($db2con, $sql1);
            while($row1 = odbc_fetch_array($result1)){
            
                $estado = $row1['ESTADO'];
                
                $facdian = trim($row1['FACTURA_DIAN']);
                
                $novedad = trim($row1['NOVEDAD']);
                
                $factura = trim($row1['FACTURA']);
                
                $ff=substr($facdian,0,2);
                
                //correctamente
                if(($ff=='') && $estado == 'Y' && ($novedad != 'Documento emitido previamente' && $novedad != 'Documento se envio correctamente' && $novedad != 'Procesado Correctamente.') && $factura != ''){
                    $sql="UPDATE AGR620CF".$emp.".Z3BISHE SET IECMPD='N', IELTXT='".$fvalidacion."' WHERE IEINVN=".$factura." AND IETYPP='1'";
                    if($resulte = odbc_exec($db2con, $sql)){
     	                  $c++;             
                    }
                }
            }
            if($c > 0){
                echo "Se cambio el estado de  ".$c." Facturas de la empresa ".$emp." desde la ".$facturai." a la ".$facturaf.". Ejecutelas en Integrator.";
            }else{
                echo "No se procesaron facturas.";
            }
           
            odbc_close($resulte);
            odbc_close($result1);

?>