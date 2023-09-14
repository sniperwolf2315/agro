<?php
include( '../../environments/production.php' );
/**
* Clase para consumir API Rest
* Las operaciones soportadas son:
*
* 	- POST		: Agregar
* 	- GET		: Consultar
* 	- DELETE	: Eliminar
* 	- PUT		: Actualizar
* 	- PATCH		: Actualizar por parte
*
* Extras
* 	- AUTENTICACIÓN de acceso básica ( Basic Auth )
*  	- Conversor JSON
*
*/

class API_REST {

    /* RALIZAMOS PETICION CON TOKEN MEODO GET*/
    static function GET_BODY_HEADER( $URL, $TOKEN, $JSON_DATA ) {
        $curl = curl_init();
        curl_setopt_array( $curl, [
            CURLOPT_URL => "$URL",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_POSTFIELDS => "{\n  \"Documento\": $JSON_DATA\n}",
            CURLOPT_POSTFIELDS => json_encode($JSON_DATA),
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "Content-Type: application/json",
                "Token: $TOKEN"
            ],
        ] );
        $response = curl_exec( $curl );
        $err = curl_error( $curl );
        curl_close( $curl );
        if ( $err ) {
            return 'cURL Error #:' . $err;
        } else {
            return $response;
        }
    }

    /** GET CON TOKEN EN LA URL */
    
static function GET_BODY( $URL, $TOKEN, $JSON_DATA ) {
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => $URL.$TOKEN,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => json_encode($JSON_DATA),
    CURLOPT_HTTPHEADER => [
        "Accept: */*",
        "Content-Type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    return "cURL Error #:" . $err;
    } else {
    return $response;
    }
    
}





static function GET( $URL, $TOKEN ) {
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => strval($URL.$TOKEN ),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => ["Accept: */*"]]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
    return "cURL Error #:" . $err;
    } else {
    return $response;
    }
}


public function GET_PEDIDOS_PIBOX_PROD(){
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://sandboxprod.picap.co/api/third/bookings?t=KkYjA-Y-tkCvSy3spy6-4X9FYvZ1mEYNHdJfBxTrfdwC-Q_3_nKjvQ",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 35,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Accept: */*"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    return "cURL Error #:" . $err;
    }else{
    return $response;
    }
}


    /**
    * Enviar parámetros a un servidor a través del protocolo HTTP ( PUT ).
    * Se utiliza para editar un recurso en una API REST
    *
    * @param string $URL URL recurso, ejemplo: http://website.com/recurso/id
    * @param string $TOKEN token de autenticación
    * @param array $ARRAY parámetros a envíar
    * @return JSON
    */
    static function PUT( $URL, $TOKEN, $ARRAY ) {
        $datapost = '';
        foreach ( $ARRAY as $key=>$value ) {
            $datapost .= $key . ' = ' . $value . '&';
        }

        $headers 	 = array( 'Authorization: Bearer ' . $TOKEN );
        $ch 		 = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $URL );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $datapost );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 3 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $response = curl_exec( $ch );
        curl_close ( $ch );
        return json_decode( $response );
    }

    /**
    * Enviar parámetros a un servidor a través del protocolo HTTP ( PATCH ).
    * Se utiliza para editar un atributo específico ( recurso ) en una API REST
    *
    * @param string $URL URL recurso, ejemplo: http://website.com/recurso/id
    * @param string $TOKEN token de autenticación
    * @param array $ARRAY parametros parámetros a envíar
    * @return JSON
    */
    static function PATCH( $URL, $TOKEN, $ARRAY ) {
        $datapost = '';
        foreach ( $ARRAY as $key=>$value ) {
            $datapost .= $key . ' = ' . $value . '&';
        }

        $headers 	 = array( 'Authorization: Bearer ' . $TOKEN );
        $ch 		 = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $URL );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $datapost );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 3 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        $response = curl_exec( $ch );
        curl_close ( $ch );
        return json_decode( $response );
    }

    /**
    * Convertir JSON a un ARRAY
    */
    static function JSON_TO_ARRAY( $json ) {
        return json_decode( $json, true );
    }

}

/*
<!--
usuario: adriana.chacon@agrocampo.com.co
https://docs.picap.io/
Contraseña : 823aed499901

https://apidoc.smartquick.com.co/docs/enterprise_v4/webhooks/webhook
-->
*/
?>

