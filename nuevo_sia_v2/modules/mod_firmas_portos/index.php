<?php
session_start();
$usuario_log =  $_SESSION["usuARio"]    ;
?>
<html>
<head>
<style>
    #ls_usuario{
        background-color:smokewhite;
        width:50%;
        border-radius: 20px;
        -webkit-box-shadow: 10px 10px 46px 7px rgba(0,0,0,0.19);
        -moz-box-shadow: 10px 10px 46px 7px rgba(0,0,0,0.19);
        box-shadow: 10px 10px 46px 7px rgba(0,0,0,0.19);
        margin-button:10px;
    }
    #opt_usuario,  #opt_impresora, #opt_server{
        width:50%;
        font-size: 1.5vw;
        margin-button:5px;
        border-radius: 20px;
    }
    #enviar_user {
        color: smokewhite;
        margin-top:10px;
        background-color: #408080;
        width:50%;
        border-radius: 20px;
        font-size:2vw;
        margin-botton:5px;
    }
    form label{
        font-size: 1.5vw;
    }
    
 

    
</style>

</head>
<body></body>
<footer></footer>
</html>



<center>

    <form id="ls_usuario" name="ls_usuario" action="#" method="POST">
        <label>Empresa:</label><br>
        <select name="opt_server" id="opt_server" >
            <?php
    if($usuario_log=='CIFUENTESE' || $usuario_log=='SOLERA' || $usuario_log=='GOMEZD' || $usuario_log=='DIAZD' || $usuario_log=='TORRESC' ){
        echo '
        <option value=""></option>
        <option value="IBM-AGROCAMPO-P">Agrocampo</option>
        <option value="IBM-PESTAR-P">Pestar</option>
        <option value="IBM-COMERVET-P">Comervet</option>
        ';
    }else if($usuario_log=='NARVAEZY' ||$usuario_log=='ALVAREZR' ){
        echo '
        <option value=""></option>
        <option value="IBM-AGROCAMPO-P">Agrocampo</option>
        <option value="IBM-PESTAR-P">Pestar</option>
        <option value="IBM-COMERVET-P">Comervet</option>
        ';
        
    }else if($usuario_log=='FERIAS' || $usuario_log=='RODRIGUEZM' || $usuario_log=='SANGUINOK'){
        echo '
        <option value=""></option>
        <option value="IBM-AGROCAMPO-P">Agrocampo</option>
        ';

    }else {
        echo "<option></option>";
    }

?>




        </select>
        <br>
        <label>Usuario:</label><br>
        <select name="opt_usuario" id="opt_usuario" >
        <option value=""></option>

<?php
    if($usuario_log=='CIFUENTESE' || $usuario_log=='SOLERA' || $usuario_log=='GOMEZD' || $usuario_log=='DIAZD' || $usuario_log=='TORRESC' ){
        echo "<option value='NARVAEZY'>NARVAEZY</option>";
        echo "<option value='ALVAREZR'>ALVAREZR</option>";
        echo "<option value='FERIAS'>FERIAS</option>";
        echo "<option value='RODRIGUEZM'>RODRIGUEZM</option>";
        echo "<option value='SANGUINOK'>SANGUINOK</option>";
    }else if($usuario_log=='NARVAEZY'){
        echo "<option value='$usuario_log'>$usuario_log</option>";
    }else if($usuario_log=='ALVAREZR'){
        echo "<option value='$usuario_log'>$usuario_log</option>";
    }else if($usuario_log=='FERIAS'){
        echo "<option value='$usuario_log'>$usuario_log</option>";
    }else if($usuario_log=='RODRIGUEZM'){
        echo "<option value='$usuario_log'>$usuario_log</option>";
    }else if($usuario_log=='SANGUINOK'){
        echo "<option value='$usuario_log'>$usuario_log</option>";
    }

?>
        </select>
        <br>
        <label>Impresora:</label><br>
        <select name="opt_impresora" id="opt_impresora" >
            <option value=""></option>
<?php
    if($usuario_log=='CIFUENTESE' || $usuario_log=='SOLERA' || $usuario_log=='GOMEZD' || $usuario_log=='DIAZD' || $usuario_log=='TORRESC' ){
        echo "
        <option value='CAJA80'   >CAJA80    FACTURA TIRILLA</option>
        <option value='ADBKYOP'  >ADBKYOP   FACTURAS GRANDES</option>
        <option value='CAJA6'    >CAJA6     FACTURA TIRILLA</option>
        <option value='ADOBEDEVO'>ADOBEDEVO FACTURAS GRANDES</option>
        ";
    }
    else if ($usuario_log=='NARVAEZY' || $usuario_log=='ALVAREZR' ){
        echo "
        <option value='CAJA80'>FACTURA TIRILLA</option>
        <option value='ADBKYOP'>FACTURAS GRANDES</option>
        ";
    }else if($usuario_log=='FERIAS' || $usuario_log=='RODRIGUEZM' || $usuario_log=='SANGUINOK'){
        echo "
        <option value='CAJA6'>FACTURA TIRILLA</option>
        <option value='ADOBEDEVO'>FACTURAS GRANDES</option>
        ";
    }else {
        echo "<option></option>";
    }
?>
        </select>
        <br>
        <input id="enviar_user" name="enviar_user" type="submit" value="Cambiar">
    </form>
</center>

<?php
 
 
if(isset($_POST['opt_usuario']) && isset($_POST['opt_impresora'])  && isset($_POST['opt_server'])){
    if($_POST['opt_usuario']=='' && $_POST['opt_impresora']=='' && isset($_POST['opt_server'])){
        echo "<center> no puede tener valores vacios </center>";
        return;
    }
    

    include('../../conection/conexion_ibs.php');
    
    $usuario    = $_POST['opt_usuario'];
    $impresora  = $_POST['opt_impresora'];
    $empresa    = $_POST['opt_server'];


    $conibs = new con_ibs($empresa,'','');

    $update_firma =  "UPDATE SROCTLSD SET CTDEVD = '$impresora' where CTSIGN = '$usuario'";
    unset ($_POST['opt_usuario']);
    unset ($_POST['opt_impresora']);
    $conibs->conectar("$update_firma");
    echo "<center> ✔ Actualizado </center>";
}else{
    echo "<center> No existe </center>";
}
?>