<br>
<br>
<?php
require( '../../../conection/conexion_sql.php' );
session_start();

$sql_con=new con_sql('sqlfacturas');
$perfil = $_GET['perf'];
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];


$consulta=("select * from API_CONFIGURACION where CAMPO in ('CANT BAHIA','CUPOS BAHIA')");
$rta_data = $sql_con->consultar($consulta);

while($a = mssql_fetch_array($rta_data)){
    if($a[1]=='CANT BAHIA'){
        $bahias_hab = $a[2];
    }else if($a[1]=='CUPOS BAHIA'){
        $cupos_hab  = $a[2];
    }

 }
 echo "Configuración de parametros: <br>";
echo '
<form action="#" method="POST" autocomplete="off">
<table>
<tr>
    <td>
        <label for="#num_ventanilla">  # Bahias de cargue   </label>
    </td>
    <td>
        <input type="number" min=1 id="num_ventanilla" name="num_ventanilla" class="num_ventanilla" placeholder="'.$bahias_hab.'">
    </td>
</tr>
<tr>
 <td>
    <label for="#cup_ventanilla">  # Cupos por bahia   </label>
 </td>
    <td>
        <input type="number" min=5 id="cup_ventanilla" name="cup_ventanilla" class="cup_ventanilla" placeholder="'.$cupos_hab.'">
    </td>
</tr>
<tr>
    <td colspan="3">
        <input type="submit" name="btn_ced_domi" id="btn_ced_domi" class="btn_ced_domi" value="Guardar" >
        <input type="reset" value="Limpiar" class="btn_ced_domi" name="btn_ced_domi" id="btn_ced_domi" >
    </td>
</tr>
</form>
</table>
';

if(isset($_POST['num_ventanilla'])){
    echo "<br>la cantidad de ventanillas habilitadas son ".$_POST['num_ventanilla'];
    $_SESSION['num_ventanilla']=$_POST['num_ventanilla'] ;
    mssql_query("update  API_CONFIGURACION set valor=".$_POST['num_ventanilla']." where id=1 and campo='CANT BAHIA' ");
}
if(isset($_POST['cup_ventanilla'])){
    echo "<br>El cupo por ventanillas habilitadas son ".$_POST['cup_ventanilla'];
    $_SESSION['cup_ventanilla']=$_POST['cup_ventanilla'] ;
    mssql_query("update  API_CONFIGURACION set valor=".$_POST['cup_ventanilla']." where id=2 and campo='CUPOS BAHIA' ");
}

mssql_close();

?>