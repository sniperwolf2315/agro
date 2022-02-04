<?php
include("user_con.php");
$emp=trim($_GET['e']);
            $opt="";   
            $query="SELECT codigo, colaborador FROM rh_vale_vales WHERE EMPRESA='".$emp."' GROUP BY codigo, colaborador"; 
                    $result = mysqli_query($mysqli,$query);
                    while($row = mysqli_fetch_array($result)){
                        //$idr=$row['id']; //id registro
                        $id=$row['codigo']; //cedula
                        $nom=$row['colaborador'];   //nombre
                        $opt=$opt.$id."-".$nom.";";
                        }
            echo $opt;
?>