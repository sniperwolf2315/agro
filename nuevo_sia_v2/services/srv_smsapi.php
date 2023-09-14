<?php

/*http://192.168.1.115/nuevo_sia_v2/services/srv_smsapi.php */


function sms_send($params, $backup = false)
{
    $token ="anOZ2j9VHtE9rdxFSIj2l35jy39gqI5w1vTOHMcu";

    static $content;

    if ($backup == true) {
        $url = 'https://api2.smsapi.com/sms.do';
    } else {
        $url = 'https://api.smsapi.com/sms.do';
    }

    $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $params);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token"));

    $content = curl_exec($c);
    $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);

        if ($http_status != 200 && $backup == false) {
            $backup = true;
            sms_send($params, $token, $backup);
        }
    curl_close($c);
    return $content;
}



?>

<?php
/*
// $token = "token_api_oauth"; //https://ssl.smsapi.com/react/oauth/manage

$factura="101010";
// $msq_body="Se ha presentado novedad con la factura $factura, por favor  verificar en  www.sia.agrocampo.vip , recuerde que dispone de 24 horas máximo para sus observaciones.";
$msq_body="Se ha presentado novedad con la factura $factura, por favor verificarel www.sia.agrocampo.vip antes de 24 para sus observaciones.";
$params = array(
    'to'            => '573134812230',         //destination number  
    'from'          => 'Agrocampo',                  //sendername made in https://ssl.smsapi.com/sms_settings/sendernames
    'message'       => "$msq_body",    //message content
    'format'        => 'json',           
);
sms_send($params);
*/

// Envío masivo de SMS personalizados mediante parámetros
// $params = array(
//     'to'       => '48600111222,48500111222',    //destination numbers
//     'from'     => 'Test',                       //sendername made in https://ssl.smsapi.com/sms_settings/sendernames 
//     'message'  => 'Message content,parameter1:[%1%]parameter2:[%2%]',   //message content
//     'param1'   => 'John|Ann',
//     'param2'   => '30|40',
//     'format'   => 'json'
// );
?>