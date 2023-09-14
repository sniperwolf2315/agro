
<?php
// echo "si se invocaron estas funciones";
function format_fecha_hora($fecha_hora){
    $hora_novedad = date("Y/m/d h:i:s", strtotime($fecha_hora));
    $date = new DateTime($hora_novedad);
    $hora_novedad_fn = $date->format('Y-m-d h:i:s');

    return $hora_novedad_fn;
}



function dom_firma(){
        echo '
        <form id="formCanvas" name="formCanvas" method="POST" ENCTYPE="multipart/form-data" action="">
        <div class="centrador">
                    <canvas id="canvas"></canvas><br />
                            <button type=\'button\' onclick=\'LimpiarTrazado()\'>Borrar</button>
                            <!-- <button type=\'button\' onclick=\'GuardarTrazado()\'>Guardar</button>-->
                            <button type="button" style="visibility: hidden;" onclick="guardarDatos();">Guardar</button>
                            <input type="hidden" name="imagen" id="imagen" />
                            <input type="hidden" name="imagenom" id="imagenom" />
        </div>

        ';    

        // comprovamos si se envió la imagen
        if (isset($_POST['imagen'])) { 
                    function uploadImgBase64 ($base64, $name){
                    // decodificamos el base64
                    $datosBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                    // definimos la ruta donde se guardara en el server
                    // $path= $_SERVER['DOCUMENT_ROOT'].'/modulo_plan/FIRMAVENDEDOR/'.$name;
                    $path= './firmas'.$name;
                    // guardamos la imagen en el server
                    if(!file_put_contents($path, $datosBase64)){
                        // retorno si falla
                        return false;
                    }
                    else{
                        // retorno si todo fue bien
                        return true;
                        }
                    }
                    $nombre=$_POST["imagenom"];
                    $imag=$_POST["imagen"];
                    uploadImgBase64($imag, $nombre.".png" );
                    //tamaño imagen
                    $tamano = '0';//filesize("FIRMAVENDEDOR/".$nombre.".png"); 
                    //echo 'tamano:'.$tamano;
                    echo "<input type=\"text\" name=\"firm\" id=\"firm\" value=\"$tamano\" style=\"visibility: hidden;\">";
        }else{
                    if(empty($tamano)){
                        $tamano=0;
                    }
                    //echo "<input type='text' name='firm' id='firm' value='$tamano' style='visibility: visible;'>";
                    echo "<input type=\"text\" name=\"firm\" id=\"firm\" value=\"$tamano\" style=\"visibility: hidden;\">";
        }
            echo "</form>";
}


?>