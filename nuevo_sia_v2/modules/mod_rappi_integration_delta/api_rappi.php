<?php

function post_rappi( $jason_data ) {
    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL             => "https://services.grability.rappi.com/api/cpgs-integration/datasets",
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_ENCODING        => "",
        CURLOPT_MAXREDIRS       => 10,
        CURLOPT_TIMEOUT         => 30,
        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST   => "POST",
        CURLOPT_POSTFIELDS      => "$jason_data",
        CURLOPT_HTTPHEADER      => [
            "Accept: */*",
            "Content-Type: application/json",
            "api_key: 21919845-0ede-4dfd-9c76-dfbf26718916"
        ],
    ] );

    $response = curl_exec( $curl );
    $err = curl_error( $curl );
    curl_close( $curl );
    if ( $err ) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}


/*
API_KEY_TEST => https://www.postman.com/collections/0779e534d934e8e51f4c
*/
?>
