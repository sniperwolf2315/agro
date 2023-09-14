<?php
// echo "API CONSULTA ORDENES SERVIENTREGA";

/*
http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx
Servientrega
http://192.168.6.55/nuevo_sia_v2/services/servientrega_consulta_pedido.php?NumeroPedido=2186531340
http://192.168.1.115/nuevo_sia_v2/services/servientrega_consulta_pedido.php?NumeroPedido=3001588532
*/


// $num_pedido = $_GET['NumeroPedido'];

// echo    json_encode(consulta_pedido_servientrega($num_pedido));


define('UPLOAD_DIR', './');
  $file = UPLOAD_DIR . time() . '.jpg';
  file_put_contents($file,base64_decode(trim($casa[Imagen])));

function consulta_pedido_servientrega($numero_pedido){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuiaImagen?NumeroGuia='.$numero_pedido.'&BuscarImagen=false',
        // CURLOPT_URL => 'http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuia?NumeroGuia='.$numero_pedido,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
        /* CONVERTIR EL XML EN CABECERAS SENCILLAS Y DE AHI SE TRANFORMA EN JSON PARA CONVERTIRLO EN UN ARRAY DE OBJETOS */
        $xml    = simplexml_load_string($response);
        $json   = json_encode($xml);
        $array  = json_decode($json,TRUE);
        return $array;
    }
        curl_close($curl);
}

?>
