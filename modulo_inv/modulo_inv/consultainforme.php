<?php
$compan=trim($_GET['c']);
$grupoc=trim($_GET['g']);
$conteo=trim($_GET['n']);
$descri=trim($_GET['d']);
$op1=trim($_GET['op1']);    //total bodega
$op2=trim($_GET['op2']);    //fecha vencimiento
$bu=trim($_GET['bu']);      //buscar ubicaciones
$dc=trim($_GET['dc']);      //diferencias en cero
$grupoconteo=trim($_GET['gc']); //buscar por G. de Conteo
require_once('user_con.php');
$conta=1;
$color1="#BBE0F";
$color2="#E1D8F";
                $datos="<table border=1px cellpadding=2 cellspacing=0; style=\"font-size: 1.0em;\">";
                $concolor=1;
                $datos=$datos."<tr>";
                $datos=$datos."<td>#</td>";
                $datos=$datos."<td class=\"celdat\"><b>ITEM</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>DESCRIPCION</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>TOTAL</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>C0</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>C1</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>C2</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>EXISTENCIA</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>COSTO</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>BARRAS</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>DIFERENCIA</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>VALOR</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>UBICACION</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>PASILLO</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>ALTURA</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>GRUPO</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>HISTORIA</b></td>";
                $datos=$datos."</tr>";
                //ORDER BY ID_UBICACION ASC
                
                $verifica=0;
                $suma=0;
                
                $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message());
                
                /*if($compan=='Agrocampo'){
                    mssql_select_db('sqlInventario008',$cLink);
                    $result1 = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION NOT like '%COMERVET%'", $cLink);
                }else if($compan=='Comervet'){
                    mssql_select_db('sqlInventarioComervet008',$cLink);
                    //AND DESCRIPCION like '%COMERVET%'
                    $result1 = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1'", $cLink);
                }*/
                if($compan=='Agrocampo'){
                            //busca todos
                            mssql_select_db('sqlInventario008',$cLink);
                            if($grupoc=='' && $descri=='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION NOT like '%COMERVET%'", $cLink);
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO NOT IN('ANC','BIM','BRA','CMV','CRV','EWA','FOX','INV','MIP','MTS','MYL','NIN','QUI','REA','URC','VCT','TEC','LHI','ZAP','MER','AGR')";
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$grupoSQL'";
                            }
                            //busca por grupo trae desc de server
                            if($grupoc!='' && $descri=='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$grupoc%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                            if($grupoc!='' && $descri!='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$grupoc%' OR DESCRIPCION LIKE '%$descri%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                    //IBS
                                    //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                                
                            }
                            if($grupoc=='' && $descri!='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$descri%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                            if($grupoconteo!=''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION NOT like '%COMERVET%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                        }else if($compan=='Comervet'){
                            mssql_select_db('sqlInventarioComervet008',$cLink);
                            if($grupoc=='' && $descri=='' && $grupoconteo==''){
                                
                                //AND DESCRIPCION like '%COMERVET%'
                                $resultg = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1'", $cLink);
                                //$sql="SELECT DISTINCT * FROM AGR620CFZZ.VISBODUBICA WHERE GRUPO IN('AGR','ANC','BRA','EWA','FOX','INV','MER','MIP','MTS','MYL','NIN','PPO','QUI','REA','TEC','URC','VCT','ZAP')";
                            }
                            if($grupoc!='' && $descri=='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$grupoc%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFZZ.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                            if($grupoc!='' && $descri!='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$grupoc%' OR DESCRIPCION LIKE '%$descri%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                    //IBS
                                    //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                                
                            }
                            if($grupoc=='' && $descri!='' && $grupoconteo==''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION LIKE '%$descri%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                            if($grupoconteo!=''){
                                $resultg = mssql_query("SELECT PGPGRP FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE Ejecutar='1' AND DESCRIPCION NOT like '%COMERVET%'", $cLink);
                                //$filag = mssql_fetch_array($resultg);
                                //$Gruposql=$filag['PGPGRP']; 
                                //IBS
                                //$sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$Gruposql'";
                            }
                        }
                while($fila = mssql_fetch_array($resultg)){
                        $grupoSQL=$fila['PGPGRP'];
                        $grupoSQL=trim($grupoSQL);                
                        //ITEM='04045045600002'  OJO PONER WHILE INTERNOS
                        
                        //total bodega con ubicaciones
                        if($op1==1 && $grupoconteo==''){
                            $sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$grupoSQL'";
                        }
                        if($grupoconteo!='' && $op1==1){
                            $sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$grupoSQL' AND ID_UBICACION='$grupoconteo'";
                        }
                        
                        if($op2==1){
                            if($compan=='Agrocampo'){
                                $result3a = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invRegistro] WHERE FechaVencimiento!=''", $cLink);
                            }else if($compan=='Comervet'){
                                $result3a = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invRegistro] WHERE FechaVencimiento!=''", $cLink);
                            }
                            $fila3a = mssql_fetch_array($result3a);
                            $item1=$fila3a['pgprcd'];
                            $item1=trim($item1);
                            $ubika=$fila3a['pgpgrp'];
                            $desk=$fila3a['Descripcion'];
                            
                            //echo $item1."--".$desk;
                            //mssql_close($resultg);
                            //exit();
                            
                            mssql_close($result3a);
                            //ibs  AND DESCRIPCION='$desk'
                            $sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE DESCRIPCION LIKE '%$desk%'";
                        }
                        //if($op2==1){
                          //  $sql="SELECT * FROM AGR620CFAG.VISBODUBICA WHERE GRUPO='$grupoSQL'";
                        //}
                        
                        
                        
                        $result = odbc_exec($db2con, $sql);
                        while($row2 = odbc_fetch_array($result)){
                                
                                /*echo $item1."-*-".$desk;
                                mssql_close($resultg);
                                odbc_close($result);
                                exit();*/
                                                               
                                if($conta%2==0){
                                    $clase="celdaa";
                                }else{
                                    $clase="celdab";
                                }
                                                                        
                                $item = $row2['ITEM'];
                                $item=trim($item);
                                
                                $descrip = utf8_encode($row2['DESCRIPCION']);
                                $descrip=trim($descrip);
                               
                                $total='0';
                                
                                $con1=0;
                                
                                $con2=0;
                                
                                $con3=0;
                                
                                $cantexist = $row2['CANT_EXISTENCIA'];
                                $cantexist=round($cantexist,0);
                                
                                $costo = $row2['COSTO_PROMEDIO'];
                                $costo=round($costo,0);
                                
                                $barras= $item;
                                
                                $diferencia=$total-$cantexist;
                                
                                $valor = $row2['COSTO_TOTAL'];
                                $valor=round($valor,0);
                                $suma=$suma+$valor;
                                
                                if($op1==1 && $bu==1){
                                    $ubica = $row2['ID_UBICACION'];
                                    $ubica=trim($ubica);
                                }else{
                                    $ubica='999';
                                }
                                
                                if($op1==1 && $bu==1){
                                    $pasillo=substr($ubica,1,4);
                                }else{
                                    $pasillo='999';
                                }
                                
                                if($op1==1 && $bu==1){
                                    $altura=substr($ubica,-2,2);
                                    if($altura=='P1' || $altura=='P2'){
                                        $altura='ALTURA';
                                    }else{
                                        $altura='PISO';
                                    }
                                }else{
                                    $altura='';
                                }
                                
                                if($op1==1 && $bu==1){
                                    $zona = $row2['ZONA_UBICACION'];
                                    $zona=trim($zona);
                                }else{
                                    $zona='';
                                }
                                
                                $bode = $row2['BODEGA'];
                                $bode=trim($bode);
                                
                                $grupo = $row2['GRUPO'];
                                $grupo=trim($grupo);
                                              
                                /*if($compan=='Agrocampo'){
                                    $resultg2 = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invGrupoItem] WHERE PGPGRP='$grupo'", $cLink);
                                }else if($compan=='Comervet'){
                                    $resultg2 = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invGrupoItem] WHERE PGPGRP='$grupo'", $cLink);
                                }*/
                                //$filag = mssql_fetch_array($resultg2);
                                //$Estado=0;
                                //if($filag = mssql_fetch_array($resultg2)){
                                    //$Estado=$filag['Ejecutar']; 
                                    //if ($Estado=='1'){
                                        if($compan=='Agrocampo'){
                                            $result3 = mssql_query("SELECT * FROM [sqlInventario008].[dbo].[invRegistro] WHERE pgprcd='$item' AND pgpgrp='$ubica'", $cLink);
                                        }else if($compan=='Comervet'){
                                            $result3 = mssql_query("SELECT * FROM [sqlInventarioComervet008].[dbo].[invRegistro] WHERE pgprcd='$item' AND pgpgrp='$ubica'", $cLink);
                                        }
                                        //$result3 = mssql_query("SELECT * FROM invRegistro WHERE pgprcd='$item'", $cLink);
                                        //$fila3 = mssql_fetch_array($result3);
                                        if($fila3 = mssql_fetch_array($result3)){
                                            $con1=$fila3['srsthq']; 
                                            $con2=$fila3['cantidad1']; 
                                            $con3=$fila3['cantidad2']; 
                                            $historia=$fila3['Historia'];
                                        }
                                        mssql_close($result3);
                                    //}
                                //}
                                mssql_close($resultg2);
                                $datos=$datos."<tr>";
                                $datos=$datos."<td class=\"$clase\">".$conta."</td>";
                                $datos=$datos."<td class=\"$clase\">".$item."</td>";
                                $datos=$datos."<td class=\"$clase\">".$descrip."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$total."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$con1."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$con2."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$con3."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$cantexist."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$costo."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$barras."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$diferencia."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$valor."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$ubica."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$pasillo."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$altura."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$grupo."</td>";
                                $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$historia."</td>";
                                $datos=$datos."</tr>";
                                $conta++;
                        }
                        odbc_close($result);
                    }
                    mssql_close($resultg);
                //mssql_close($result1);
                $datos=$datos."<tr>";
                $datos=$datos."<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
                $datos=$datos."<td></td><td></td><td></td><td>".$suma."</td><td></td><td></td><td></td><td></td>";
                $datos=$datos."</tr>";
                $datos=$datos."</table>";
                //odbc_close($result);
                echo $datos;
?>