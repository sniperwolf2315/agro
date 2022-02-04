<?php
$factura=trim($_GET['f']);
$emp=trim($_GET['emp']);
$factura=trim($factura);
require_once('user_con.php');

            //2020-12-11 14:40:13-
            $fvalidacion=date("Y-m-d H:i:s-");
            //$fvalidacion='2020-12-11 14:40:00-';            
            $sql1="SELECT IEPREF AS FACTURA_DIAN, IECMPD AS ESTADO, IEFTXT AS NOVEDAD FROM AGR620CF".$emp.".Z3BISHE WHERE IEINVN='$factura'";
            
                           
	        $result1 = odbc_exec($db2con, $sql1);
            $row1 = odbc_fetch_array($result1);
            
            $estado = $row1['ESTADO'];
            
            $facdian = trim($row1['FACTURA_DIAN']);
            
            $novedad = trim($row1['NOVEDAD']);
            
            $ff=substr($facdian,0,2);
            
            //$ff != 'FE' ||Procesado Correctamente.
            if(($ff=='') && $estado == 'Y' && ($novedad != 'Documento emitido previamente' && $novedad != 'Documento se envio correctamente' && $novedad != 'Procesado Correctamente.') && $factura != ''){
                $sql="UPDATE AGR620CF".$emp.".Z3BISHE SET IECMPD='N', IELTXT='".$fvalidacion."' WHERE IEINVN=".$factura." AND IETYPP='1'";
                
    	        if($resulte = odbc_exec($db2con, $sql)){
                    echo "La Factura: ".$factura." de la empresa ".$emp." fue habilitada para facturar. Ingrese a Integrator y ejecutela.";
                }else{
                    echo "Factura no se habilito.";
                }
            }else{
                echo "La factura ".$factura." de la empresa ".$emp." ya tiene numero de factura Dian o fue previamente enviada o ya fue habilitada.";
            }
            odbc_close($resulte);
            odbc_close($result1);
            
            

?>