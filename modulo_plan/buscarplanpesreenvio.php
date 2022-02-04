<?php
            //CONECCION DB2
            //include("../user_con.php");
            //include("conexion.php");
            //include('conexionodbc.php');
            include('conectarbase.php');
            $emp=$_GET['emp'];
            $d1=$_GET['d1'];
            $d1=trim($d1);
            if(empty($d1)){
                echo("Digite Cedula o Nit!");
                exit();
            }
            $anioact=date("Y");
            $datos='Datos no encontrados.';
            // && fecha_creacion LIKE '%$anioact'
            //$resultado = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1'");   
            //$consulta = "SELECT * from zAgroPremios2019 WHERE Cedula='$d1' and Empresa='$emp'";
            //$resultado = odbc_exec($connection,$consulta);
            if($emp=='AG'){
                $result = mssql_query("SELECT * from zAgroPremios2019 WHERE Cedula='$d1' and Empresa='$emp' and Estado='1'");
            }else if($emp=='X1'){
                $result = mssql_query("SELECT * from zAgroPremiosPestar2021 WHERE Cedula='$d1' and Empresa='$emp' and Estado='1'");
            }
            $resultado = mssql_fetch_array($result);
            
            //$numero = $resultado->num_rows;
            if($resultado){
                 //$row = $resultado->fetch_array(MYSQLI_NUM);
                 
                 //$d0 = odbc_result($resultado,"Nombre");
                 $d0=$resultado["Nombre"];
                 //$d0 = utf8_encode($d0);
                 //$d0 = utf8_decode($d0);
                 //$d1 = odbc_result($resultado,"NombreEstablecimiento");
                 $d1=$resultado["NombreEstablecimiento"];
                 if($d1==""){
                    $d1="-";
                 }
                 //$d1 = utf8_encode($d1);
                 //$d2 = odbc_result($resultado,"Direccion");
                 $d2=$resultado["Direccion"];
                 $d2 = utf8_encode($d2);
                 //$d3 = odbc_result($resultado,"Barrio");
                 $d3=$resultado["Barrio"];
                 $d3 = utf8_encode($d3);
                 //$d4 = odbc_result($resultado,"Telefono");
                 $d4=$resultado["Telefono"];
                 $d4 = utf8_encode($d4);
                 //$d5 = odbc_result($resultado,"Celular");
                 $d5=$resultado["Celular"];
                 //$d6 = odbc_result($resultado,"Email");
                 $d6=$resultado["Email"];
                 //$d7 = odbc_result($resultado,"Departamento");
                 $d7=$resultado["Departamento"];
                 //$d8 = odbc_result($resultado,"Ciudad");
                 $d8=$resultado["Ciudad"];
                 //$d9 = odbc_result($resultado,"MontoCompras");
                 $d9=$resultado["MontoCompras"];
                 $d9=number_format($d9, 0, '.', ',');
                 //$d10 = odbc_result($resultado,"Id");
                 $d10=$resultado["Id"];
                 //$d11 = odbc_result($resultado,"CategoriaPremio");
                 $d11=$resultado["CategoriaPremio"];
                 //$d12 = odbc_result($resultado,"PremioCompras");
                 $d12=$resultado["PremioCompras"];
                 $d7=strtoupper($d7);
                 $d7=trim($d7);
                 if(substr($d7, 0,4)=='NARI'){
                        $d7=utf8_encode('NARIÑO');
                    }else{
                        $d7=utf8_decode($d7);
                    }
                 if($emp=='X1'){
                    $P1=$resultado["Porc1"];
                    $P2=$resultado["Porc2"];
                    $P3=$resultado["Porc3"];
                    $P4=$resultado["Porc4"];
                    $P5=$resultado["Porc5"];
                    $m2=$resultado["Monto2"];
                    $m2=number_format($m2, 0, '.', ',');   
                 } else if($emp=='AG'){
                    $P1='0';
                    $P2='0';
                    $P3='0';
                 }
                 //array de datos tabla
                 $datos=utf8_encode($d0).'^'.utf8_encode($d1).'^'.utf8_decode($d2).'^'.utf8_decode($d3).'^'.utf8_decode($d4).'^'.$d5.'^'.$d6.'^'.$d7.'^'.utf8_encode($d8).'^'.$d9.'^'.$d10.'^'.$d11.'^'.$d12.'^'.$P1.'^'.$P2.'^'.$P3.'^'.$P4.'^'.$P5.'^'.$m2; 
                 echo $datos;
                 //$mysqli->close(); 
                 //$mssql->close();
                 //odbc_close($connection); 
                 mssql_close();
            }else{
                echo $datos;
                //$mysqli->close();  
                //odbc_close($connection);
            }
?>