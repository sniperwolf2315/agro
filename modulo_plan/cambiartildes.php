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
                    $d1=str_replace("�","&aacute;",$datosPremios1);
                    $d2=str_replace("�","&eacute;",$d1);
                    $d3=str_replace("�","&iacute;",$d2);
                    $d4=str_replace("�","&oacute;",$d3);
                    $d5=str_replace("�","&uacute;",$d4);
                    $d6=str_replace("�","&ntilde;",$d5);
                    $consulta3= "UPDATE zAgroCategorias SET Descripcion1='$d1' where IdC='$id'";
                    $resultado2=mssql_query($consulta3);
                    //****
                    $d1=str_replace("�","&aacute;",$datosPremios2);
                    $d2=str_replace("�","&eacute;",$d1);
                    $d3=str_replace("�","&iacute;",$d2);
                    $d4=str_replace("�","&oacute;",$d3);
                    $d5=str_replace("�","&uacute;",$d4);
                    $d6=str_replace("�","&ntilde;",$d5);
                    $consulta3b= "UPDATE zAgroCategorias SET Descripcion2='$d6' WHERE IdC='$id'";
                    $resultado2b=mssql_query($consulta3b);
                    //****
                    $d1=str_replace("�","&Aacute;",$datosPremios1);
                    $d2=str_replace("�","&Eacute;",$d1);
                    $d3=str_replace("�","&Iacute;",$d2);
                    $d4=str_replace("�","&Oacute;",$d3);
                    $d5=str_replace("�","&Uacute;",$d4);
                    $d6=str_replace("�","&Ntilde;",$d5);
                    $consulta3= "UPDATE zAgroCategorias SET Descripcion1='$d1' where IdC='$id'";
                    $resultado2=mssql_query($consulta3);
                    //****
                    $d1=str_replace("�","&Aacute;",$datosPremios2);
                    $d2=str_replace("�","&Eacute;",$d1);
                    $d3=str_replace("�","&Iacute;",$d2);
                    $d4=str_replace("�","&Oacute;",$d3);
                    $d5=str_replace("�","&Uacute;",$d4);
                    $d6=str_replace("�","&Ntilde;",$d5);
                    $consulta3b= "UPDATE zAgroCategorias SET Descripcion2='$d6' WHERE IdC='$id'";
                    $resultado2b=mssql_query($consulta3b);
                    */
                    $c++;
                //}
                echo "terminado".$c;
                mssql_close(); 
?>
