<?php
$usuario=$_SESSION[usuARio];
$emp=$_GET['emp'];
$are=trim($_GET['are']);
$doc=trim($_GET['doc']);
$nom=trim($_GET['nom']);
$ape=trim($_GET['ape']);
//exit();
$msg="Error";
$n="";
    require_once("user_con.php");
    $sqlaux="SELECT * FROM rh_personal WHERE CODIGO='$doc'";
    $result = mysqli_query($mysqli, $sqlaux);
    $row = mysqli_fetch_array($result);
         $n=$row["NOMBRES"];
         if($n == ""){
              $sql = "INSERT INTO rh_personal (NOMBRES,APELLIDOS,TIPO_DE_ID,CODIGO,AREA,EMPRESA,USUARIO) 
              VALUES('$nom','$ape','','$doc','$are','$emp','$usuario')";
    
            if($result2=mysqli_query($mysqli,$sql )){
                $msg="Datos del Usuario guardados con exito.";  
            }else{
                $msg="Datos no se guardaron, por favor revise!";
            }  
        }else{
            $msg="Usuario ya existe con el mismo documento!";
        }       
       
    echo $msg;
?>