<?php
require_once('conectarbase.php');
                $resultPlan = mssql_query("SELECT * FROM zAgroCategorias where IdC='13'");
                $c=0;
                //while($resultado = mssql_fetch_array($resultPlan)){
                    $datosPremios1=$resultado["Descripcion1"];
                    $datosPremios2=$resultado["Descripcion2"];
                    $id=$resultado["IdC"]; 
                    $d1=str_replace('"',"&#34;",$datosPremios1);
                    $consulta3= "UPDATE zAgroCategorias SET Descripcion1='$d1' where IdC='13'";
                    $resultado2=mssql_query($consulta3);
                    /*
                    $d1=str_replace("á","&aacute;",$datosPremios1);
                    $d2=str_replace("é","&eacute;",$d1);
                    $d3=str_replace("í","&iacute;",$d2);
                    $d4=str_replace("ó","&oacute;",$d3);
                    $d5=str_replace("ú","&uacute;",$d4);
                    $d6=str_replace("ñ","&ntilde;",$d5);
                    $consulta3= "UPDATE zAgroCategorias SET Descripcion1='$d1' where IdC='$id'";
                    $resultado2=mssql_query($consulta3);
                    //****
                    $d1=str_replace("á","&aacute;",$datosPremios2);
                    $d2=str_replace("é","&eacute;",$d1);
                    $d3=str_replace("í","&iacute;",$d2);
                    $d4=str_replace("ó","&oacute;",$d3);
                    $d5=str_replace("ú","&uacute;",$d4);
                    $d6=str_replace("ñ","&ntilde;",$d5);
                    $consulta3b= "UPDATE zAgroCategorias SET Descripcion2='$d6' WHERE IdC='$id'";
                    $resultado2b=mssql_query($consulta3b);
                    //****
                    $d1=str_replace("Á","&Aacute;",$datosPremios1);
                    $d2=str_replace("É","&Eacute;",$d1);
                    $d3=str_replace("Í","&Iacute;",$d2);
                    $d4=str_replace("Ó","&Oacute;",$d3);
                    $d5=str_replace("Ó","&Uacute;",$d4);
                    $d6=str_replace("Ñ","&Ntilde;",$d5);
                    $consulta3= "UPDATE zAgroCategorias SET Descripcion1='$d1' where IdC='$id'";
                    $resultado2=mssql_query($consulta3);
                    //****
                    $d1=str_replace("Á","&Aacute;",$datosPremios2);
                    $d2=str_replace("É","&Eacute;",$d1);
                    $d3=str_replace("Í","&Iacute;",$d2);
                    $d4=str_replace("Ó","&Oacute;",$d3);
                    $d5=str_replace("Ó","&Uacute;",$d4);
                    $d6=str_replace("Ñ","&Ntilde;",$d5);
                    $consulta3b= "UPDATE zAgroCategorias SET Descripcion2='$d6' WHERE IdC='$id'";
                    $resultado2b=mssql_query($consulta3b);
                    */
                    $c++;
                //}
                echo "terminado".$c;
                mssql_close(); 
?>
