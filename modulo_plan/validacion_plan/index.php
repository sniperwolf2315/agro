 <?php
require ("config/conexion.php");
include ("consultas/agrocampo.php");
include ("consultas/pestar.php");
?> 

<!DOCTYPE html >
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>INFORME PLAN AÑO</title>
    <link rel="stylesheet" href="nav_bar.css">

</head>
<body>
    <nav>
        <a href="#" class="nav_li">Agrocampo</a>
        <a href="#" class="nav_li">Pestar</a>
    </nav>

<div name="tbl_1" id="tbl_1">
    <form action="index.php" method="POST">
        <select name="empresa" id="empresa">
            <option value="" seleted>Seleccion</option>
            <option value="agro">Agrocampo</option>
            <option value="pest">Pestar</option>
        </select>
        <input type="submit" value="enviar">
    </form>
</div>
<br>

<div  class="tbl_tabla">
<?php
    $var = $_POST['empresa'];
    if($_POST['empresa']=='agro'){
        echo' 
        <br>AGROCAMPO<br>
        ';
        mostrar_tabla();

    }
    elseif ($_POST['empresa']=='pest') {
        echo"PESTAR<br>";
        mostrar_tablap();
    }
    else{
        echo "no ha seleccionado nada!";
    }
          
?>
</div>


</body>
</html>

<script script type="text/javascript">
    function imprimir(valor){
        console.log(valor);

    }
</script>