<?php
    if(session_start()===FALSE){
        session_start();
    }
    
?>
<!DOCTYPE html>
<html>
 
<head>


    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Librerias JQuery -->
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script src="js/viewer.js"></script>
<body>


<iframe id='frame' src='pdf/Pruebadeimpresion.pdf' style="height: 300px; width: 600px;"></iframe>

<button id="btnImprimir" type="button">Imprimir</button>



<?php
/*
if(isset($_POST['EnviarPdf'])){
    echo "entrado";
    error_reporting(1);
    include('PHPPrinter/printer.class.php');
    if($handle=printer_open('KyoceraP1')){
        printer_set_option($handle, PRINTER_MODE, 'RAM');
        printer_start_doc($handle);
        printer_start_page($handle);
        
        $linea1="PRUEBA DE IMPRESION PHP";
        $font=printer_create_font('Arial',150,80,700,false,false,false,0);
        printer_select_font($handle,$font);
        
        printer_draw_text($handle,$linea1,150,250);
        printer_delete_font($font);
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);
        echo "impreso";
    }else{
        echo "Falla de impresion";
    }
}*/
?>

<script>


   
   $(document).ready(function(){
        //detectamos el click en el boton de imprimir
        $('#btnImprimir').click(function(){
          //Hacemos foco en el iframe
          $('#frame').get(0).contentWindow.focus(); 
          //Ejecutamos la impresion sobre ese control
          $("#frame").get(0).contentWindow.print(true); 
          return;
        });
      });
    


/*
PARA CHROME:

1) Abre el navegador e imprime una página de prueba para configurar los parámetros de la impresora

2) cerrar todo el chrome

2) Crea un nuevo acceso directo del google Chrome

3) Hacer click con el botón derecho del mouse para ver el menú contextual del acceso directo creado para “google Chrome” y seleccionar propiedades.

4) en el campo de la ruta target: colocar el final el parámetro: --kiosk-printing

5) aplicar cambios y OK

6) Ejecutar el nuevo acceso directo de Chrome

7) Probar el codigo de impresión nuevamente.
*/

</script>


</body>
</html>