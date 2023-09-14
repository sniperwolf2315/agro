<?php
            //CONECCION DB2
            //include("../user_con.php");
            //include("conexion.php");
            include('conexionodbc.php');
            $d1=$_GET['d1'];
            if(empty($d1)){
                echo("No hay categorias registradas!");
                exit();
            }
            $datos='';
            //$resultado = $mysqli->query("SELECT * FROM catpremios WHERE categ='$d1'");   
            //$numero = $resultado->num_rows;
            $consulta2 = "select * from zAgroCatPremios WHERE Categoria='$d1'";
            $resultado2 = odbc_exec($connection,$consulta2);
            if($resultado2){
                 while (odbc_fetch_row($resultado2))
                     {
                     $result = odbc_result($resultado2,"Premio");
                     $datos=$datos.utf8_decode($result).'^';
                     }
                 //$d0 = odbc_result($resultado,"Nombre");
                 /*while($row = $resultado->fetch_array(MYSQLI_NUM)){
                     $datos=$datos.utf8_decode($row[2]).'^';
                 }
                 echo $datos;
                 $mysqli->close();  */
                 odbc_close($connection);
            }else{
                echo $datos;
                odbc_close($connection);
                //$mysqli->close();  
            }
?>