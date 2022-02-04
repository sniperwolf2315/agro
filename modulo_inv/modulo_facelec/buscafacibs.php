<?php
$factura=trim($_GET['f']);
$emp=trim($_GET['emp']);
$factura=trim($factura);
require_once('user_con.php');

            $sql="SELECT IETTXT AS CUFE, IEINVN AS FACTURA, IEORNO AS ORDEN, IEIDAT AS FECHA_EMISION_IBS, IEDUED AS FECHA_VENCE_FAC, IECUNO AS IDCLIENTE, IEFTXT AS NOVEDAD, IELTXT AS FECHA_VALIDACION_OK, IEPREF AS FACTURA_DIAN, IECMPD AS ESTADO FROM AGR620CF".$emp.".Z3BISHE WHERE IEINVN='$factura'";
            
	        $result = odbc_exec($db2con, $sql);
            $row = odbc_fetch_array($result);
            
            $estado = $row['ESTADO'];
            $orden = $row['ORDEN'];
            $fechaemi = $row['FECHA_EMISION_IBS'];
            $idcliente = $row['IDCLIENTE'];
            $novedad = utf8_encode($row['NOVEDAD']);
            $facdian = $row['FACTURA_DIAN'];
            
            $datosfac=$factura."^".$orden."^".$fechaemi."^".$idcliente."^".$novedad."^".$facdian."^".$estado;
            odbc_close($result);
            
            echo $datosfac;
?>