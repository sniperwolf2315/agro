<?php
            //CONECCION DB2
            //include("../user_con.php");
            //include("conexion.php");
            //include('conexionodbc.php');
            exit();
            include('conectarbase.php');
            $d1=$_GET['d1'];    //ced
            $d1=trim($d1);
            $d2=$_GET['d2'];    //NOMBRE
            $d3=$_GET['d3'];    //ESTABLEcim
            $dd=$_GET['d4'];   //DIR
            $d4=str_replace("#"," ",$dd);
            $dd=utf8_encode($d4);   //DIR
            $bar=$_GET['d5'];
            $bar2=str_replace("#"," ",$bar);
            /*if($_GET['d5'] && !empty($_GET['d5'])){
                $d5=utf8_encode($_GET['d5']);   //BARRIO
            }else{
                $d5='';
            }*/
            //auditoria remota******************************************
                //función que escribe la IP del cliente en un archivo de texto    
                function write_visita ($idc){
                    //Indicar ruta de archivo válida
                    $archivo="visitas2.txt";
                    $new_ip=get_client_ip();
                    $now = new DateTime();
                    $txt =  str_pad($new_ip,25). " ".
                        str_pad($now->format('Y-m-d H:i:s'),25)."     Id:".$idc;
                    $myfile = file_put_contents($archivo, $txt.PHP_EOL , FILE_APPEND);
                }
            
            
                //Obtiene la IP del cliente
                function get_client_ip() {
                    $ipaddress = '';
                    if (getenv('HTTP_CLIENT_IP'))
                        $ipaddress = getenv('HTTP_CLIENT_IP');
                    else if(getenv('HTTP_X_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                    else if(getenv('HTTP_X_FORWARDED'))
                        $ipaddress = getenv('HTTP_X_FORWARDED');
                    else if(getenv('HTTP_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    else if(getenv('HTTP_FORWARDED'))
                       $ipaddress = getenv('HTTP_FORWARDED');
                    else if(getenv('REMOTE_ADDR'))
                        $ipaddress = getenv('REMOTE_ADDR');
                    else
                        $ipaddress = 'UNKNOWN';
                    return $ipaddress;
                }
            //************************************************************
            
            if(!empty($bar2)){
                $d5=utf8_encode($bar2);   //BARRIO
            }else{
                $d5='';
            }
            if($_GET['d6'] && !empty($_GET['d6'])){
                $d6=utf8_encode($_GET['d6']);   //tele
            }else{
                $d6='';
            }
            //$d6=$_GET['d6'];    //TELE
            //$d6b=$_GET['d6b'];  //REPITE TEL
            if($_GET['d6b'] && !empty($_GET['d6b'])){
                $d6b=utf8_encode($_GET['d6b']);   //verifica tel
            }else{
                $d6b='';
            }
            if($_GET['d7'] && !empty($_GET['d7'])){
                $d7=utf8_encode($_GET['d7']);   //celu
            }else{
                $d7='';
            }
            //$d7=$_GET['d7'];    //CELU
            $emp=$_GET['emp'];    //empresa
            if (empty($emp)){
                $emp='AG';
            }
            $d8=$_GET['d8'];    //eMAIL
            $d9=$_GET['d9'];    //DPTO
            $d10=$_GET['d10'];  //CIUDAD
            $d11=$_GET['d11'];  //OBJ COMPRAS
            $d12=$_GET['d12'];  //categoria
            $df=$_GET['df'];    //F
            //dp=premio
            $md=$_GET['md'];    //manejo datos
            $tipo=$_GET['tp'];  //tipo V o P
            if(empty($_GET['pe2'])){
                $pe2='';
            }else{
                //premio
                $pe2=$_GET['pe2'];
            }
            $pelegido=$_GET['pe'].";".$pe2;  //premio elegido
            $pelegido=utf8_encode($pelegido);
            if($emp=='AG'){
                $url='http://sia.pestar.com.co/modulo_plan/FOTOSPLAN/'.$d12.'/'.$pelegido.'.png';
            }else if($emp=='X1'){
                $url='';//'http://190.131.242.142:55/modulo_plan/FOTOSPLANPESTAR/'.$d12.'/'.$pelegido.'.png';
            }
            //$urlcliente='http://sia.agrocampo.vip/modulo_plan/FIRMAVENDEDOR/'.$d1.'.png';
            $urlcliente='http://sia.pestar.com.co/modulo_plan/FIRMAVENDEDOR/'.$d1.'.png';
            $firma=$d1.'.png';
            //premios
            if(empty($_GET['dp'])){
                $dp='Ninguno';
            }else{
                //premio
                $dp=$_GET['dp'];
            }
            if(empty($_GET['dp2'])){
                $dp2='';
            }else{
                //premio
                $dp2=$_GET['dp2'];
            }
            $Premio1="";
            $Premio2="";
            $Premio3="";
            if($emp=='X1'){
                $Premios=explode(";",$dp);
                $tam=count($Premios);
                if($tam==3){
                    $Premio1=$Premios[0];
                    $Premio2=$Premios[1];
                    $Premio3=$Premios[2];
                }
                if($tam==2){
                    $Premio1=$Premios[0];
                    $Premio2=$Premios[1];
                }
                if($tam==1){
                    $Premio1=$Premios[0];
                }
                if($tam==0){
                    $Premio1=$dp;
                }
                $Premio1=utf8_decode($Premio1);
                $Premio2=utf8_decode($Premio2);
                $Premio3=utf8_decode($Premio3);
                //opciones adicionales
                $Premios=explode(";",$dp2);
                $tam=count($Premios);
                if($tam==2){
                    $Premio4=$Premios[0];
                    $Premio5=$Premios[1];
                }
                $Premio4=utf8_decode($Premio4);
                $Premio5=utf8_decode($Premio5);
            }
            //$dp=utf8_decode($dp);
            //$dp=utf8_encode($dp);
            //$dp=str_replace("ñ","Ã±",$dp);
            $fecha=date("Ymd");
            $anioant=date("Y")-1;
            $anioact=date("Y");
            $dia=date("d");
            $mes=date("m");
            //$resultado = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1'");   
            //$consulta = $mysqli->query("SELECT * FROM zAgroPremios2019 WHERE Cedula='$d1'");
            //////////$consulta = "SELECT * FROM zAgroPremios2019 WHERE Cedula='$d1' and Estado='0'";
            if($emp=='AG'){
                $result = mssql_query("SELECT * FROM zAgroPremios2019 WHERE Cedula='$d1' and Estado='0'");
            }else if($emp=='X1'){
                $result = mssql_query("SELECT * FROM zAgroPremiosPestar2020 WHERE Cedula='$d1' and Estado='0'");
            }
            $resultado = mssql_fetch_array($result);
            //$resultado = odbc_exec($connection,$consulta);
            //$numero = $resultado->num_rows;
            //$resultado = odbc_exec($connection,$consulta); ñ Ã±
            if($resultado){
                //$nom = odbc_result($resultado,"Nombre");
                $nom=$resultado["Nombre"];
                
                //$firma=$resultado["Firma"];
                //$nom=str_replace("Ñ","Ã‘",$nom);
                //$nom = utf8_encode($nom);
                //$yaregistropremio = odbc_result($resultado,"PremioCompras");
                $yaregistropremio=$resultado["PremioCompras"];
                //$m2018 = odbc_result($resultado,"Monto2018");
                $m2018=$resultado["Monto2018"];
                //$c2018 = odbc_result($resultado,"Compras2018");
                $c2018=$resultado["Compras2018"];
                //$avance = odbc_result($resultado,"Avance");
                $avance=$resultado["Avance"];
                //$montoc = odbc_result($resultado,"MontoCompras");
                $montoc=$resultado["MontoCompras"];
                //$fecha = odbc_result($resultado,"Fecha");
                $fecha=$resultado["Fecha"];
                //$dpto = odbc_result($resultado,"Departamento");
                $dpto=$resultado["Departamento"];
                //$esta = odbc_result($resultado,"Estado");
                $esta=$resultado["Estado"];
                //$cate = odbc_result($resultado,"CategoriaPremio");
                $cate=$resultado["CategoriaPremio"];
                //$codv = odbc_result($resultado,"CodigoVendedor");
                $codv=$resultado["CodigoVendedor"];
                //segundo monto
                $montodos=$resultado["Monto2"];
                
                $fechareg=$dia.'/'.$mes.'/'.substr($fecha,6,strlen($fecha));
                if($d9!=$dpto){
                    $dpto=$d9;
                }
                //si no tiene premios registrados los registra
                $resultado=false;
                $largo=strlen($yaregistropremio);
                if($emp=='X1'){
                    $cate="0";
                }
                if($largo<5){
                    if($dp!='Ninguno'){
                        if($emp=='AG'){
                            $consulta2="INSERT INTO zAgroPremios2019(Nombre,Monto2018,Compras2018,Avance,MontoCompras,Firma,Fecha,NombreEstablecimiento,Cedula,Email,Departamento,Ciudad,Direccion,Barrio,Telefono,Celular,Estado,CategoriaPremio,PremioCompras,FirmaVendedor,CodigoVendedor,Tipop,Autmanejodatos,Empresa,fotopremio,Url,AreaVentas)";
                            $consulta2=$consulta2." VALUES('$nom','$m2018','$c2018','$avance','$montoc','$firma','$fechareg','$d3','$d1','$d8','$dpto','$d10','$d4','$d5','$d6b','$d7','1','$cate','$dp','$urlcliente','$codv','$tipo','$md','$emp','$pelegido','$url','-')";
                            $resultado1=mssql_query($consulta2);
                            //actualiza
                            $consulta3= "UPDATE zAgroPremios2019 SET PremioCompras='$pelegido' WHERE Cedula='$d1' and Estado='0'";
                            $resultado2=mssql_query($consulta3);
                        }else if($emp=='X1'){
                            $consulta3= "UPDATE zAgroPremiosPestar2020 SET Firma='$firma', PremioCompras='$pelegido', FirmaVendedor='$urlcliente', Premio1='$Premio1', Premio2='$Premio2', Premio3='$Premio3', Premio4='$Premio4', Premio5='$Premio5' WHERE Cedula='$d1' and Estado='0'";
                            $resultado2=mssql_query($consulta3);
                            $pelegido=utf8_encode($pelegido);
                            $consulta2="INSERT INTO zAgroPremiosPestar2020(Nombre,Monto2018,Compras2018,Avance,MontoCompras,Firma,Fecha,NombreEstablecimiento,Cedula,Email,Departamento,Ciudad,Direccion,Barrio,Telefono,Celular,Estado,CategoriaPremio,PremioCompras,FirmaVendedor,CodigoVendedor,Tipop,Autmanejodatos,Empresa,fotopremio,Url,AreaVentas,Porc1,Porc2,Porc3,Premio1,Premio2,Premio3,Porc4,Porc5,Monto2,Premio4,Premio5)";
                            $consulta2=$consulta2." VALUES('$nom','$m2018','$c2018','$avance','$montoc','$firma','$fechareg','$d3','$d1','$d8','$dpto','$d10','$d4','$d5','$d6b','$d7','1','$cate','$dp','$urlcliente','$codv','$tipo','$md','$emp','$pelegido','$url','-','','','','$Premio1','$Premio2','$Premio3','','','$montodos','$Premio4','$Premio5')";
                            $resultado1=mssql_query($consulta2); 
                        }
                         
                    }//else{
                       // $consulta2= "UPDATE zAgroPremios2019 SET Email='$d8', Firma='$firma', Direccion='$d4', Barrio='$d5', Telefono='$d6b', Celular='$d7', PremioCompras='', Autmanejodatos='$md', Tipop='$tipo', fotopremio='Sin Premio', Url='$url', FirmaVendedor='$urlcliente' WHERE Cedula='$d1'";
                    //}
                    //$resultado = sqlsrv_query($connection,$consulta2);
                    //$resultado = odbc_exec($connection,$consulta2);
                    //sqlsrv_query
                    
                    //$resultado=$mysqli->query($consulta);
                        if($resultado1){
                            echo("Datos fueron procesados.");
                        }else{
                            echo("Los datos No se pudieron procesar. Intentalo nuevamamente.");
                        }  
                    //$mysqli->close();  
                    //odbc_close($connection);
                    mssql_close(); 
                    write_visita ($d1);
                }/*else{
                    /*if($dp!='Sin Premio'){
                        $consulta2= "UPDATE zAgroPremios2019 SET Email='$d8', Direccion='$d4', Barrio='$d5', Telefono='$d6b', Celular='$d7', Autmanejodatos='$md', Tipop='$tipo' WHERE Cedula='$d1'";
                    }else{
                        $consulta2= "UPDATE zAgroPremios2019 SET Email='$d8', Direccion='$d4', Barrio='$d5', Telefono='$d6b', Celular='$d7', Autmanejodatos='$md', Tipop='$tipo' WHERE Cedula='$d1'";
                    }
                    $resultado = odbc_exec($connection,$consulta2);
                    //$resultado=$mysqli->query($consulta);
                        if($resultado){
                            echo("Datos procesados.");
                        }  
                    //$mysqli->close();  
                    odbc_close($connection); */
                }
            /*}else{
                //consulta el monto anterior año
                /*$resultado2 = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1' && anio_actual='$anioant'");   
                $numero2 = $resultado2->num_rows;
                if($resultado2 && $numero2 > 0){
                    $row2 = $resultado2->fetch_array(MYSQLI_NUM);
                    $montoant=$row2[6];
                    $montocompant=$row2[7];
                }else{
                    $montoant=0;
                }
                //consulta el monto sugerido actual año
                $resultado2 = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1' && anio_actual='$anioact'");   
                $numero2 = $resultado2->num_rows;
                if($resultado2 && $numero2 > 0){
                    $row2 = $resultado2->fetch_array(MYSQLI_NUM);
                    $montoact=$row2[9];
                }else{
                    $montoact=0;
                }
                /*$consulta= "INSERT INTO planpremios (cod_cliente,nom_cliente,nom_int_cliente,fecha_creacion,anio_anterior,monto_anterior,monto_compras,anio_actual,sugerido_actual,percent_avance,vend,nom_estab,dir_cliente,barrio,telefono,movil,email,dpto,munic,categ,premio) 
                                               VALUES ('$d1','$d2','','$fecha','$anioant','$montoant','$montocompant','$anioact','$montoact','','','$d3','$d4','$d5','$d6','$d7','$d8','$d9','$d10','$d12','')";  
                if($mysqli->query($consulta)===TRUE){
                    echo("Datos fueron registrados.");
                }else{
                    echo("Datos no fueron enviados, revise nuevamente.");
                }*/
                 //odbc_close($connection);
                // mssql_close();
            //}
          

?>
