<?php
if (!isset($_SESSION)) { session_start(); }
$compania=$_SESSION['Compan'];
if($_SESSION['usuARioI'] ==''){
    header("location:../index.php");
}

?>
<html>
<head>
<title>Inventario</title>
<!--<link href="css/estilos.css" rel="stylesheet" type="text/css" />-->


<script language="JavaScript">
    function Inf_venT() {
        //var cedu=document.getElementById('Cedula').value;
        document.getElementById('Carguesi').value='Espere por favor....';//.style.visibility='visible';
        document.getElementById('respuesta').style.visibility='visible';
        document.getElementById('respuesta').innerHTML='';
        //var texto='';
        //document.getElementById('respuesta').innerHTML=texto;
                 
        //document.getElementById('cartera1').style.visibility='hidden';
        document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
        document.body.style.cursor = 'wait';
        if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
                       peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
        }
        // Preparar la funcion de respuesta
        peticion_http.onreadystatechange = muestraContenido;
        // Realizar peticion HTTP
        peticion_http.open('POST', 'Inf_generalJ.php', true);//?c=' + cedu, true);
        peticion_http.send(null);
        
        function muestraContenido() {
            //alert(dato1);
            if (peticion_http.readyState == 4) {
                if (peticion_http.status == 200) {
                    var dato = peticion_http.responseText;
                                //alert(dato);
                    document.body.style.cursor = 'auto';
                    document.getElementById('estado').innerHTML='';               
                    document.getElementById('respuesta').innerHTML=dato;
                }
            }
        }
    }
</script>

</head>
<body>
 
    <div class="container" style="width: 98%;">
      
        <div class="row #439049 green darken-1" style="padding: 5px;">
               <!--logo #439049 green darken-1, #1565c0 blue darken-2-->
               <div class="col">
                <img class="responsive-img center " src="img/logoAG.png" style="width: 2.5em;" />&nbsp;&nbsp;<label style="font-size: medium; color: whitesmoke; font-weight: bold;">Informes Odoo</label>
               </div>
               <!--menu blue #3980C3-->
               <div class="col right #439049 green darken-1"> 
                    <nav class="right #E67402 orange darken-1" style="height: 50px;">
                            <ul id="nav-mobile" class="right #439049 green darken-1" style="height: 0.5em;">
                                <li><a href="javascript:Inf_venT()"><b>GERENCIA</b></a>&nbsp;</li>
                                <li class="col #439049 green darken-1" style="height: 60px;">&nbsp;</li>
                                <!--<a href="javascript:Salir()">Salir</a>-->
                            </ul>
                           
                    </nav>
                    
             </div>
                  
         </div>       
         <div class="col" id="respuesta">
                
         </div>
    </div>
 
</body>
</html>
<?php


?>