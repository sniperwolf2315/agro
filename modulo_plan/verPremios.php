<?php
$cate=$_GET['cate'];
require_once('conectarbase.php');
                $resultPlan = mssql_query("SELECT * FROM zAgroCategorias WHERE idCategoria='$cate'");
                $tmp='';
                while($resultado = mssql_fetch_array($resultPlan)){
                    $datosPremios1=$resultado["Descripcion1"];
                    $datosPremios2=$resultado["Descripcion2"]; 
                    $datosFoto=$resultado["foto"];
                    $tipoPremio=$resultado["Tipo"];
                    $tmp.=$datosPremios1.'^'.$datosPremios2.'^'.$datosFoto.'^'.$tipoPremio.'_';
                }
                echo $tmp;
                mssql_close(); 
?>