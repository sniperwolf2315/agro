<?php
if(session_start()===FALSE){
        session_start();
    }
    if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
    {
        header("location:user_conect.php"); die;
    }
    $Usw=$_SESSION['email'];
    $us=explode("@",$Usw);
    $usu=$us[0];
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="css/materialize.min.css" />
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="lolkittens" />
    
	<title>Tareas Wrike Agrocampo</title>
</head>
<script>
            function Salir(){
                    // Obtener la instancia del objeto XMLHttpRequest
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    // Preparar la funcion de respuesta
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'cerrarSesion.php' , true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                alert("Usted a salido.");
                                setTimeout("location.reload(true);", 500);
                                location.href="user_conect.php";
                            }
                        }
                    }    
            }
</script>
<body style="background-color: #303C56;">
<div class="container" style="width: 100%;">
    <div class="row" style="width: 100%;">
        <div class="col s3" id="Proyecto" style="background-color: #303C56;color: #fff; height: 50px; text-align: left; padding: 10px;"><img src="img/logoAG.png" width="40px" /></div>
        <div class="col s1" style="background-color: #303C56;"><br /></div>
        <div class="col s3" id="Tarea" style="background-color: #303C56; color: #fff; height: 50px; text-align: left; padding: 10px;"><br />Bandeja de Entrada</div>
        <div class="col s1" style="background-color: #303C56;">&nbsp;</div>
        <div class="col s4" id="Contenido" style="background-color: #303C56; color: #fff; height: 50px; text-align: right; padding: 10px;">
            <input id="buscatarea" type="text" style="background-color: gray; font-size: 1em; width: 200px; height: 20px;" />
            <label style="color: #fff;"><?php echo " ".$usu."  "; ?></label><input type="button" onclick="Salir();" value="Salir" style="background-color: red;" />
        </div>
    </div> 
    
    <div class="row" style="width: 100%;">
        
        <div style="background-color: #303C56; width: 18%; height: 40em; float: left; color: #ffffff;">1</div>
        <div style="background-color: gray; width: 1%; height: 40em; float: left;"></div>
        <div style="background-color: #ffffff; width: 35%; height: 40em;float: left; color: #000000;">2</div>
        <div style="background-color: #303C56; width: 1%; height: 40em; float: left;"></div>
        <div style="background-color: #ffffff; width: 41%; height: 40em; float: left; color: #000000;">3&nbsp;</div>
        
    </div> 
    
    
    </div> 
</div>

</body>
</html>