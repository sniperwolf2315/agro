<?php

function url_pedido_s($factura_despacho,$fecha_ped){
        $fechaActual = substr(str_replace("-","-",$fecha_ped),0,11);
        $ini_corte   = date( 'Y/m/d', strtotime( $fechaActual.'- 1 day' ) );
        $fin_corte   = date( 'Y/m/d', strtotime( $fechaActual.'+ 1 day' ) );

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuiaImagen?NumeroGuia='.$factura_despacho.'&BuscarImagen=true',
        // CURLOPT_URL => 'http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuiaImagen?NumeroGuia='.$factura_despacho.'&BuscarImagen=false',
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_ENCODING        => '',
        CURLOPT_MAXREDIRS       => 10,
        CURLOPT_TIMEOUT         => 0,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST   => 'GET',
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

        /* CONVERTIR EL XML EN CABECERAS SENCILLAS Y DE AHI SE TRANFORMA EN JSON PARA CONVERTIRLO EN UN ARRAY DE OBJETOS */
        $xml    = simplexml_load_string($response);
        $json   = json_encode($xml);
        $array  = json_decode($json,TRUE);
        return $array;
        }
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
}

?>