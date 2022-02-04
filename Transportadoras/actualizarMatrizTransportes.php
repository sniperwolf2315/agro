<label>ACTUALIZAR DESTINOS,RUTAS Y TARIFAS</label><br /><hr />
<div style="width: 98%; background-color: #024C68;"><br />  
<form name="act" method="POST" action="">                                    
<center><select id="company" name="company" class="browser-default light-blue-text" style="width: 250px;">
<option value="Seleccione" disabled selected >Seleccione Compa&ntilde;ia</option>
<option value="AG">AGROCAMPO</option>
<option value="X1">PESTAR</option>
<option value="ZZ">COMERVET</option>
</select></center>
<br /><br />
                                    
<input type="submit" class="waves-efect waves-light btn" name="Enviar" value="Actualizar Rutas" /><br /><br />                        
</form>                                
</div><br />

<?php

if(isset($_POST['Enviar'])){
    $emp=$_POST['company'];
    if($emp != 'AG' && $emp != 'X1' && $emp != 'ZZ'){
        exit();
    }
    include('conectarbaseprod.php');
    //agrocampo
    if($emp == 'AG'){
        $empresa='';
        mssql_select_db('sqlFacturas',$cLink);
    }else if($emp == 'ZZ'){
        $empresa='Comervet';
        mssql_select_db('sqlFacturasComervet',$cLink);
    }else if($emp == 'X1'){
        $empresa='Pestar';
        mssql_select_db('sqlFacturasPestar',$cLink);
    }
        $fd=2;      
        $miruta='Rutas/';
        $nombre_fichero = 'Matriz2021';
        $mipath=$miruta.$nombre_fichero.'.xlsx';
        
       if(file_exists($miruta)) {
            include('Classes/PHPExcel.php');
            include('Classes/PHPExcel/Reader/Excel2007.php');
            //Crear el objeto Excel: 
            $objPHPExcel = new PHPExcel();
            //RUTA
            $mipath2=$miruta.$nombre_fichero.'.xlsx';
            if(file_exists($mipath2)) {
                $archivo = $mipath2;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);
                
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                //$highestRow
                for ($row = 2; $row <= 1093; $row++){
                    //coge toda la fila excel
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);    
                    //echo $rowData."<BR>";
                    foreach($rowData as $dato){
                        //ajusta el codigo postal
                        if(strlen($dato[2]) == 7){
                            $codDest=$dato[2].'0';
                        }else if(strlen($dato[2]) == 6){
                            $codDest=$dato[2].'00';
                        }else if(strlen($dato[2]) == 5){
                            $codDest=$dato[2].'000';
                        }else{
                            $codDest=$dato[2];
                        }
                        
                        $codDest=trim($codDest);
                        $resultSQLP = mssql_query("SELECT IdDestino FROM [sqlFacturas$empresa].[dbo].[agrDestino] WHERE Codigo='$codDest'",$cLink);
                        
                        if(trim($dato[1]) != ''){                       
                            $Destin=trim($dato[0])."-".trim($dato[1]);
                        }else{
                            $Destin=trim($dato[0]);
                        }
                            //actualiza el destino
                        if (mssql_num_rows($resultSQLP)) {
                            echo $codDest."a <br>";
                            $row2 = mssql_fetch_array($resultSQLP);
                            $idDestino = $row2['IdDestino'];
                            //transportadora
                            $nomT=trim($dato[6]); 
                            if($nomT=='ENERGY'){
                                $nomT='ENERGY LOGISTICA';
                            }
                            
                            //obtener id transportadora
                            $resultSQLT = mssql_query("SELECT IdTransportador FROM [sqlFacturas].[dbo].[agrTransportador] WHERE Nombre='$nomT'",$cLink);
                            //$resultSQLT = mssql_query("SELECT IdTransportador FROM [sqlFacturasComervet].[dbo].[agrTransportador] WHERE Nombre='$nomT'",$cLink);
                            $rowT = mssql_fetch_array($resultSQLT);
                            $idTransp = $rowT['IdTransportador'];
                            
                            $Porcen='0.0000';
                            
                            $Valor=trim($dato[7]);
                            
                            //2018-03-14 16:19:00.000
                            $FechaMod=date("Y-m-d H:i:s");
                            
                            //actualiza destino
                            $Destinox=utf8_decode($Destin);
                            $sqlv= "UPDATE [sqlFacturas$empresa].[dbo].[agrDestino] SET Nombre='$Destinox', Descripcion='$Destinox' WHERE IdDestino='$idDestino'";
                            mssql_query($sqlv,$cLink);
                            
                            //actualiza tarifas
                            //echo "---inserta0:".$idDestino."---".$idTransp."----".$nomT;
                                                                                   
                            $resultSQLT = mssql_query("SELECT IdTransportador FROM [sqlFacturas$empresa].[dbo].[agrTarifa] WHERE IdDestino='$idDestino' AND (UsuarioModificacion='FACTURAS' OR UsuarioModificacion='0')",$cLink);
                            if (mssql_num_rows($resultSQLT)) {
                                $sqlv2= "UPDATE [sqlFacturas$empresa].[dbo].[agrTarifa] SET IdTransportador='$idTransp', Unidad='$Valor', FechaModificacion='$FechaMod' WHERE IdDestino='$idDestino' AND (UsuarioModificacion='FACTURAS' OR UsuarioModificacion='0')";
                                mssql_query($sqlv2,$cLink);
                            }else{
                                //inserta tarifa
                                $sqlv3 = "INSERT INTO [sqlFacturas$empresa].[dbo].[agrTarifa](IdDestino,IdTransportador,Porcentaje,Unidad,FechaModificacion,UsuarioModificacion,Principal) 
                                VALUES('$idDestino','$idTransp','$Porcen','$Valor','$FechaMod','FACTURAS','1')"; 
                                mssql_query($sqlv3,$cLink);
                            }
                            
                        }else{
                            echo $codDest." i<br>";
                            //inserta destino
                            $Destinox=utf8_decode($Destin);
                            $sqlv = "INSERT INTO [sqlFacturas$empresa].[dbo].[agrDestino](Codigo,Nombre,Descripcion,Activo) 
                            VALUES('$codDest','$Destinox','$Destinox','1')"; 
                            mssql_query($sqlv,$cLink);
                            
                            sleep(1);
                            
                            $idDestino="-";
                            $resultSQLD = mssql_query("SELECT IdDestino FROM [sqlFacturas$empresa].[dbo].[agrDestino] WHERE Codigo='$codDest'",$cLink);
                            if (mssql_num_rows($resultSQLD)) {
                                $rowD = mssql_fetch_array($resultSQLD);
                                $idDestino = $rowD['IdDestino'];
                 
                            }
                            
                            $nomT=trim($dato[6]); 
                            if($nomT=='ENERGY'){
                                $nomT='ENERGY LOGISTICA';
                            }
                           
                            //obtener id transportadora
                            $idTransp="-";
                            $resultSQLT = mssql_query("SELECT IdTransportador FROM [sqlFacturas].[dbo].[agrTransportador] WHERE Nombre='$nomT'",$cLink);
                            if (mssql_num_rows($resultSQLT)) {
                                $rowT = mssql_fetch_array($resultSQLT);
                                $idTransp = $rowT['IdTransportador'];
                 
                            }
                            
                            $Porcen='0.0000';
                            
                            $Valor=trim($dato[7]);
                            
                            //2018-03-14 16:19:00.000
                            $FechaMod=date("Y-m-d H:i:s");
                            //echo "---inserta1:".$idDestino."---".$idTransp."----".$nomT;
                            
                            $resultSQLT2 = mssql_query("SELECT IdTransportador FROM [sqlFacturas$empresa].[dbo].[agrTarifa] WHERE IdDestino='$idDestino' AND (UsuarioModificacion='FACTURAS' OR UsuarioModificacion='0')",$cLink);
                            if (mssql_num_rows($resultSQLT2)) {
                                $sqlv2= "UPDATE [sqlFacturas$empresa].[dbo].[agrTarifa] SET IdTransportador='$idTransp', Unidad='$Valor', FechaModificacion='$FechaMod' WHERE IdDestino='$idDestino' AND (UsuarioModificacion='FACTURAS' OR UsuarioModificacion='0')";
                                mssql_query($sqlv2,$cLink);
                            }else{
                                //inserta tarifa
                                $sqlv3 = "INSERT INTO [sqlFacturas$empresa].[dbo].[agrTarifa](IdDestino,IdTransportador,Porcentaje,Unidad,FechaModificacion,UsuarioModificacion,Principal) 
                                VALUES('$idDestino','$idTransp','$Porcen','$Valor','$FechaMod','FACTURAS','1')"; 
                                mssql_query($sqlv3,$cLink);
                            }
                            
                        }
                        
                        //echo $dato[0]." ---- ".$dato[1]." ---- ".$dato[2]." ---- ".$dato[3]." ---- ".$dato[4]." ---- ".$dato[5]." ---- ".$dato[6]." ---- ".$dato[7]." ---- ".$dato[8];
                            
                    } //fin foreach
                    //echo "<br>";
                }
            }
            
        }
        

echo "<br>TERMINADO";
mssql_close();
}
?>