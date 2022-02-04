<?php
            //CONECCION DB2
            include("../user_con.php");
            $d1=$_GET['d1'];
            $d2=$_GET['d2'];
            $d3=$_GET['d3'];
            $d4=utf8_encode($_GET['d4']);
            $d5=utf8_encode($_GET['d5']);
            $d6=$_GET['d6'];
            $d6b=$_GET['d6b'];
            $d7=$_GET['d7'];
            $d8=$_GET['d8'];
            $d9=$_GET['d9'];
            $d10=$_GET['d10'];
            $d11=$_GET['d11'];
            $d12=$_GET['d12'];
            $df=$_GET['df'];
            if(empty($_GET['dp'])){
                $dp='Ninguno';
            }else{
                $dp=utf8_encode($_GET['dp']);
            }
            /*if(empty($d1)){
                echo("Digite Cedula o Nit!");
                exit();
            }
            if(empty($d2)){
                echo("Digite número de Identificacion y haga clic en Validar!");
                exit();
            }*/
            /*if(empty($d6b)){
                echo("Digite un numero de teléfono actualizado!");
                exit();
            }*/
            $fecha=date("Ymd");
            $anioant=date("Y")-1;
            $anioact=date("Y");
            $resultado = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1'");   
            $numero = $resultado->num_rows;
            if($resultado && $numero > 0){
                if($dp!='Sin Premio'){
                    $consulta= "UPDATE planpremios SET fecha_creacion='$df', email='$d8', dir_cliente='$d4', barrio='$d5', telefono='$d6b', movil='$d7', categ='$d12', premio='$dp', registropremio='1' WHERE cod_cliente='$d1'";
                }else{
                    $consulta= "UPDATE planpremios SET fecha_creacion='$df', email='$d8', dir_cliente='$d4', barrio='$d5', telefono='$d6b', movil='$d7', categ='$d12', premio='$dp', registropremio='0' WHERE cod_cliente='$d1'";
                }
                $resultado=$mysqli->query($consulta);
                    if($resultado){
                        echo("Datos procesados.");
                    }  
                $mysqli->close();  
            }else{
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
                 $mysqli->close();  
            }
          

?>
