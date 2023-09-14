<?php
// echo "Si invoco la funcion";


function url_pedido_p($factura_despacho,$fecha_despacho,$fechaActualcom){
    $url_pedido =[];


    $fecha1= new DateTime($fecha_despacho);
    $fecha2= new DateTime($fechaActualcom);
    $diff = $fecha1->diff($fecha2);
    $dias_diferencia = $diff->days;
    /* SE VALIDA SI LA FECHA DE CONSULTA ES MENOR A LA ACTUAL PARA CONSULTAR LA TABLA DE HISTORICO */
    if($dias_diferencia>=2 ){
        $pedidos_pasados = mssql_fetch_array(mssql_query("SELECT BookingIndividual,EviEntrega,Estado FROM API_HISTORICO_PIBOX WHERE NumeroPedido = '$factura_despacho'"));
        if(count($pedidos_pasados)>1){
            array_push($url_pedido,
                [
                    "seguimiento"=>"https://pibox.app/tracking/".$pedidos_pasados["BookingIndividual"], 
                    "evidencia"=>$pedidos_pasados["EviEntrega"],
                    "estado"=>strval($pedidos_pasados["Estado"])
                ]
            );
        }
    }else{
    
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL             => "https://integrations.picapdb.co/api/third/bookings?t=KkYjA-Y-tkCvSy3spy6-4X9FYvZ1mEYNHdJfBxTrfdwC-Q_3_nKjvQ",
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_ENCODING        => "",
      CURLOPT_MAXREDIRS       => 10,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST   => "GET",
      CURLOPT_HTTPHEADER      => ["Accept: */*"],
    ]);
    
    
    $response_ped = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      echo "cURL Error #:" . $err;
    } 
    $estados_entrega= [
        "1"=>"Paquete recogido - en ruta",
        "2"=>"Entregado",
        "3"=>"desconocido dev",
        "4"=>"Paquete no entregado",
    ];

    $array = json_decode($response_ped,TRUE);
    foreach ($array[data] as $key => $value) {
        // echo "<br>ESTADO FINALZIADO<br>";
        $existen_pedidos ++;
        $paquetes='';
        $cedula = $value[driver][fiscal_number];
        $pedido = strval($value["_id"]);
        foreach ($value["stops"] as $stop_key => $stop_value) {
            foreach ($stop_value["packages"] as $key => $value) {
                $paquetes .=strval($value["reference"].'-') ;
                //   echo '📦'.$value["reference"].'<br>';
                $num_fac = $value["reference"];
                if ($num_fac==$factura_despacho){
                    
                // $estado_actual = $estados_entrega[$value["status_cd"]];
                $estado_actual = $estados_entrega[$value["status"]];
                    array_push($url_pedido,
                        [
                            "seguimiento"=>$value["tracking_link"], 
                            "evidencia"=>$value["delivered_photo_url"],
                            "estado"=>$estado_actual
                            ]
                    );
                }
            }
        }
    }

 }
 
 return $url_pedido; 
}


?>