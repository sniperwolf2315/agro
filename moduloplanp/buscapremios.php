<?php
            //CONECCION DB2
            include("../user_con.php");
            $d1=$_GET['d1'];
            if(empty($d1)){
                echo("No hay categorias!");
                exit();
            }
            $datos='';
            $resultado = $mysqli->query("SELECT * FROM catpremios WHERE categ='$d1'");   
            $numero = $resultado->num_rows;
            if($resultado && $numero > 0){
                 while($row = $resultado->fetch_array(MYSQLI_NUM)){
                     $datos=$datos.utf8_decode($row[2]).'^';
                 }
                 echo $datos;
                 $mysqli->close();  
            }else{
                echo $datos;
                $mysqli->close();  
            }
?>