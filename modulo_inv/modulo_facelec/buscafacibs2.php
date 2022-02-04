<?php
$fecha=trim($_GET['fe']);
$emp=trim($_GET['emp']);
$fecha=trim($fecha);
$facturai=trim($_GET['fi']);
$facturai=trim($facturai);
$facturaf=trim($_GET['ff']);
$facturaf=trim($facturaf);
$color1="#BBE0F";
$color2="#E1D8F";
$concolor=1;
$conta=1;
require_once('user_con.php');
            $c=1;
            $concolor=1;
            //$sql="SELECT IETTXT AS CUFE, IEINVN AS FACTURA, IEORNO AS ORDEN, IEIDAT AS FECHA_EMISION_IBS, IEDUED AS FECHA_VENCE_FAC, IECUNO AS IDCLIENTE, IEFTXT AS NOVEDAD, IELTXT AS FECHA_VALIDACION_OK, IEPREF AS FACTURA_DIAN, IECMPD AS ESTADO FROM AGR620CFAG.Z3BISHE WHERE IEIDAT='$fecha' AND IEINVN>='$facturai' AND IEINVN<='$facturaf' AND IETYPP='1' AND IECMPD='Y' AND IEPREF NOT LIKE '%FE%' AND IEFTXT LIKE '%mensaje%'";
            $sql="SELECT IETTXT AS CUFE, IEINVN AS FACTURA, IEORNO AS ORDEN, IEIDAT AS FECHA_EMISION_IBS, IEDUED AS FECHA_VENCE_FAC, IECUNO AS IDCLIENTE, U.NAPOCD AS CIUDAD, IEFTXT AS NOVEDAD, IELTXT AS FECHA_VALIDACION_OK, IEPREF AS FACTURA_DIAN, IECMPD AS ESTADO FROM AGR620CF".$emp.".Z3BISHE LEFT JOIN AGR620CFAG.SRONAM U ON U.NANUM=IECUNO WHERE IEIDAT='$fecha' AND LEFT(IEIDAT,4)>=2021 AND IEINVN>='$facturai' AND IEINVN<='$facturaf' AND IETYPP='1' AND IEPREF ='' AND (IEFTXT LIKE '%mensaje%' OR IEFTXT LIKE '%SIN RESPUESTA DESDE DIAN%' OR IEFTXT LIKE '%Ha ocurrido un error%' OR IEFTXT='El cliente no tiene folios disponibles' OR IEFTXT LIKE '%Error en Consumo de Firma%' OR IEFTXT LIKE '%ConsecutivoDocumento%' OR IEFTXT LIKE '%obteniendo el siguiente%')";
            $tabla='<table border=1>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td>No.</td><td class="celdac">Factura</td><td class="celdac">Orden</td><td class="celdac">Fecha</td><td class="celdac">IDcliente</td><td class="celdac">Ciudad Destino</td><td class="celdac">Novedad</td><td class="celdac">FacturaDian</td><td class="celdac">Estado</td></tr>';       
	        $result = odbc_exec($db2con, $sql);
            $listFac="";
            while($row = odbc_fetch_array($result)){
                /*if($conta%2==0){
                    $clase="celdaa";
                }else{
                    $clase="celdab";
                } */
                $estado = $row['ESTADO'];
                /*if($estado=='Y'){
                     $clase="celdaa";
                }else{
                     $clase="celdab";
                }*/
                $facturab=$row['FACTURA'];
                //$listFac=$listFac."'".trim($facturab)."',";
                
                $orden = $row['ORDEN'];
                $fechaemi = $row['FECHA_EMISION_IBS'];
                $idcliente = $row['IDCLIENTE'];
                $ciudadest = utf8_encode($row['CIUDAD']);
                $novedad = utf8_encode($row['NOVEDAD']);
                $facdian = $row['FACTURA_DIAN'];
                if($estado=='Y'){
                    $tabla=$tabla.'<tr><td class="celdaa">'.$c.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$facturab.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$orden.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$fechaemi.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$idcliente.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$ciudadest.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$novedad.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$facdian.'</td>';
                    $tabla=$tabla.'<td class="celdaa">'.$estado.'</td></tr>';
                    if(strlen(trim($facturab))>=6){
                        $listFac=$listFac.trim($facturab).",";
                    }
                }else{
                    $tabla=$tabla.'<tr><td class="celdab">'.$c.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$facturab.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$orden.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$fechaemi.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$idcliente.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$ciudadest.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$novedad.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$facdian.'</td>';
                    $tabla=$tabla.'<td class="celdab">'.$estado.'</td></tr>';
                    if(strlen(trim($facturab))>=6){
                        $listFac=$listFac.trim($facturab).",";
                    }
                }
                $c++;
            }
            $tabla=$tabla.'</table><br />';
            $tabla=$tabla.'<input type="button" class="boton5" id="Habilitarfac2" value="HABILITA TODAS" onclick="habilitafacturaibs2();" /></br>';
            $listFac=substr($listFac,0,strlen($listFac)-1);
            $listFac="'".$listFac."'";
            $msgtxt=str_replace(",","','",$listFac);
            unlink('facturas.txt');
            $archivo="facturas.txt";
            $myfile = file_put_contents($archivo, $msgtxt.PHP_EOL , FILE_APPEND);
            //$tabla=$tabla.'</br>Lista Facturas: <label id="facd">'.$listFac.'</label></br>';
            $tabla=$tabla.'<a href="facturas.txt" target="_blank">Descargar</a>';
            odbc_close($result);
            
            echo $tabla;
            
?>