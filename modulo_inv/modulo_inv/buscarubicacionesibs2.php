<?php
$tipobuscar=trim($_GET['b']);
$codigo=trim($_GET['c']);
$codigo=strtoupper($codigo);
$codigotemp=$codigo;
//$tipop=substr($tipobuscar,1,10);
//para la ubicacion
$codigo=substr($codigo,2);
if ($tipobuscar=="XProducto"){
    $codigo2=substr($codigotemp,0,12);
    $codigo2=strtoupper($codigo2);
}
if ($tipobuscar=="XProducto"){
    $codigo3=substr($codigotemp,0,11);
    $codigo3=strtoupper($codigo3);
}
$conta=1;
$color1="#BBE0F";
$color2="#E1D8F";
$concolor=1;
require_once('user_con.php');
if (!isset($_SESSION)) { session_start(); }
                $datos="<table border=1px cellpadding=2 cellspacing=0; style=\"font-size: 1.0em;\">";
                $concolor=1;
                $datos=$datos."<tr>";
                $datos=$datos."<td>#</td>";
                $datos=$datos."<td class=\"celdat\"><b>ITEM</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>DESCRIPCION</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>BODE</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>ZONA</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>UBICACION</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>CANT_UBICA</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>RESERVADO</b></td>";
                $datos=$datos."<td class=\"celdat\"><b>EXISTENCIA</b></td>";
                $datos=$datos."</tr>";

            if ($tipobuscar=="XUbicacion"){
                $sql="SELECT * FROM AGR620CFZZ.VISBODUBICA WHERE ID_UBICACION='$codigo' OR ID_UBICACION='$codigotemp' ORDER BY ID_UBICACION ASC";
                $result = odbc_exec($db2con, $sql);
                $verifica=0;
                while($row2 = odbc_fetch_array($result)){
                        //$concolor=$conta % 1;
                        if($conta%2==0){
                            $clase="celdaa";
                        }else{
                            $clase="celdab";
                        } 
                        $verifica++;                      
                        $item = $row2['ITEM'];
                        $item=trim($item);
                        
                        $descrip = utf8_encode($row2['DESCRIPCION']);
                        $descrip=trim($descrip);
                       
                        $bode = $row2['BODEGA'];
                        $bode=trim($bode);
                        
                        $zona = $row2['ZONA_UBICACION'];
                        $zona=trim($zona);
                      
                        $ubica = $row2['ID_UBICACION'];
                        $ubica=trim($ubica);
                        
                        $cantubica = $row2['CANT_UBICACION'];
                        $cantubica=round($cantubica,0);
                        
                        $cantreser = $row2['CANT_RESERVADA'];
                        $cantreser=round($cantreser,0);
                        
                        $cantexist = $row2['CANT_EXISTENCIA'];
                        $cantexist=round($cantexist,0);
                        
                        $datos=$datos."<tr>";
                        $datos=$datos."<td class=\"$clase\">".$conta."</td>";
                        $datos=$datos."<td class=\"$clase\">".$item."</td>";
                        $datos=$datos."<td class=\"$clase\">".$descrip."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$bode."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$zona."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$ubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantreser."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantexist."</td>";
                        $datos=$datos."</tr>";
                        $conta++;
                }
                odbc_close($result);
                $tipobuscar='XUbicacion';
            }
            //OR PCXPRC LIKE '%$codigotemp' OR LEFT(PCXPRC,11)='$codigo3'
            if ($tipobuscar=="XProducto"){
                
                $tam=strlen($codigotemp);
                echo $tam."--".$codigotemp;
                //PCXPRC='$codigotemp' OR
                //OR LEFT(PCXPRC,12)='$codigo2'
                if($tam==13){
                    $sql="SELECT DISTINCT PGPRDC AS ITEM FROM AGR620CFZZ.VISINVWHM WHERE PGPRDC='$codigotemp' OR LEFT(PGPRDC,12)='$codigotemp'";
                    echo "aqui";
                }
                if($tam==12 || $tam==11){
                    echo "aqui2";
                    //OR LEFT(PCXPRC,11)='$codigo3' 
                    $sql="SELECT DISTINCT PGPRDC AS ITEM FROM AGR620CFZZ.VISINVWHM WHERE PGPRDC='$codigotemp' OR LEFT(PGPRDC,12)='$codigotemp' OR LEFT(PGPRDC,11)='$codigotemp'";
                }
                
    	        $result = odbc_exec($db2con, $sql);
                
                if($row = odbc_fetch_array($result)){
                    $reg1 = $row['PGPRDC'];
                    $Itemdbar = $row['ITEM'];
                    $Itemdbar=trim($Itemdbar);
                    echo "--item---".$Itemdbar;  
                    exit();                  
                    //condulta datos de inventario DE BODEGA
                    $sql2="SELECT * FROM AGR620CFZZ.VISBODUBICA WHERE ITEM='$Itemdbar' ORDER BY ID_UBICACION ASC";
                    
                    $result2 = odbc_exec($db2con, $sql2);
                    $verifica=0;
                    while($row2 = odbc_fetch_array($result2)){
                    
                        if($conta%2==0){
                            $clase="celdaa";
                        }else{
                            $clase="celdab";
                        }   
                        $verifica++;
                        $item = $row2['ITEM'];
                        $item=trim($item);
                        
                        $descrip = utf8_encode($row2['DESCRIPCION']);
                        $descrip=trim($descrip);
                       
                        $bode = $row2['BODEGA'];
                        $bode=trim($bode);
                       
                        $zona = $row2['ZONA_UBICACION'];
                        $zona=trim($zona);
                      
                        $ubica = $row2['ID_UBICACION'];
                        $ubica=trim($ubica);
                        
                        $cantubica = $row2['CANT_UBICACION'];
                        $cantubica=round($cantubica,0);
                        
                        $cantreser = $row2['CANT_RESERVADA'];
                        $cantreser=round($cantreser,0);
                        
                        $cantexist = $row2['CANT_EXISTENCIA'];
                        $cantexist=round($cantexist,0);
                        
                        $datos=$datos."<tr>";
                        $datos=$datos."<td class=\"$clase\">".$conta."</td>";
                        $datos=$datos."<td class=\"$clase\">".$item."</td>";
                        $datos=$datos."<td class=\"$clase\">".$descrip."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$bode."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$zona."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$ubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantreser."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantexist."</td>";
                        $datos=$datos."</tr>";
                        $conta++;
                    }
                }
                odbc_close($result);
                odbc_close($result2);
                $tipobuscar=="XProducto";
            }
            
            if ($tipobuscar=="XNombre"){
                $sql3="SELECT * FROM AGR620CFZZ.VISBODUBICA WHERE DESCRIPCION LIKE '%$codigotemp%' ORDER BY ID_UBICACION ASC";
                $result3 = odbc_exec($db2con, $sql3);
                $verifica=0;
                while($row3 = odbc_fetch_array($result3)){
                        $verifica++;
                        //$concolor=$conta % 1;
                        if($conta%2==0){
                            $clase="celdaa";
                        }else{
                            $clase="celdab";
                        }                       
                        $item = $row3['ITEM'];
                        $item=trim($item);
                        
                        $descrip = utf8_encode($row3['DESCRIPCION']);
                        $descrip=trim($descrip);
                       
                        $bode = $row2['BODEGA'];
                        $bode=trim($bode);
                       
                        $zona = $row3['ZONA_UBICACION'];
                        $zona=trim($zona);
                      
                        $ubica = $row3['ID_UBICACION'];
                        $ubica=trim($ubica);
                        
                        $cantubica = $row3['CANT_UBICACION'];
                        $cantubica=round($cantubica,0);
                        
                        $cantreser = $row3['CANT_RESERVADA'];
                        $cantreser=round($cantreser,0);
                        
                        $cantexist = $row3['CANT_EXISTENCIA'];
                        $cantexist=round($cantexist,0);
                        
                        $datos=$datos."<tr>";
                        $datos=$datos."<td class=\"$clase\">".$conta."</td>";
                        $datos=$datos."<td class=\"$clase\">".$item."</td>";
                        $datos=$datos."<td class=\"$clase\">".$descrip."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$bode."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$zona."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: center;\">".$ubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantubica."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantreser."</td>";
                        $datos=$datos."<td class=\"$clase\" style=\"text-align: right;\">".$cantexist."</td>";
                        $datos=$datos."</tr>";
                        $conta++;
                }
                odbc_close($result3);
                $tipobuscar=="XNombre";
            }
            
            $datos=$datos."</table>";
            
            if($verifica==0){
                echo "Producto no fue encontrado ".$tipobuscar." en el inventario de Bodega.";
            }else{
                echo $datos;
            }
            
            

?>