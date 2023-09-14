<?php
include("user_con.php");
$sql="SELECT 
CONCEPTO 
  FROM rh_vale_vales WHERE CODIGO is null AND EMPRESA is null ORDER BY CONCEPTO ASC";
$result = mysqli_query($mysqli, $sql); //echo $sql;
while($row = mysqli_fetch_array($result)){
  $Aux.=$row["CONCEPTO"]."^";
  }
  echo $Aux;
?>