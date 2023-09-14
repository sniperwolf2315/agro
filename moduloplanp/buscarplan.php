<?php
            //CONECCION DB2
            include("../user_con.php");
            $d1=$_GET['d1'];
            if(empty($d1)){
                echo("Digite Cedula o Nit!");
                exit();
            }
            $anioact=date("Y");
            $datos='';
            // && fecha_creacion LIKE '%$anioact'
            $resultado = $mysqli->query("SELECT * FROM planpremios WHERE cod_cliente='$d1'");   
            $numero = $resultado->num_rows;
            if($resultado && $numero > 0){
                 $row = $resultado->fetch_array(MYSQLI_NUM);
                 //array de datos tabla
                 $datos=$row[0].'^'.$row[1].'^'.$row[2].'^'.$row[3].'^'.$row[4].'^'.$row[5].'^'.$row[6].'^'.$row[7].'^'.$row[8].'^'.$row[9].'^'.$row[10].'^'.$row[11].'^'.$row[12].'^'.$row[13].'^'.$row[14].'^'.$row[15].'^'.$row[16].'^'.$row[17].'^'.$row[18]; 
                echo $datos;
                $mysqli->close();  
            }else{
                echo $datos;
                $mysqli->close();  
            }
?>

