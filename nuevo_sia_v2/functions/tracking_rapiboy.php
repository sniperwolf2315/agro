<?php
// echo "Si invoco la funcion";
// echo __FILE__;
// include('../services/srv_consulta_pedi_pibox_prod.php');
// echo $response_ped;

function url_pedido_r($factura_despacho,$fecha_ped){
        $fechaActual= substr(str_replace("-","-",$fecha_ped),0,11);
        $ini_corte   = date( 'Y/m/d', strtotime( $fechaActual.'- 1 day' ) );
        $fin_corte  = date( 'Y/m/d', strtotime( $fechaActual.'+ 1 day' ) );
            $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://rapiboy.com/v1/NextDayBasic/GetList",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{\n  \"FechaDesde\": \"$ini_corte\",\n  \"FechaHasta\": \"$fin_corte\"\n}",
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Content-Type: application/json",
            "Token: 64f7261e-26ec-44e7-8977-0055feaecaf7"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            include_once("../../../funciones.php");
            include_once( '../../../services/rest_pibox_service.php' );
            $array      = API_REST::JSON_TO_ARRAY( $response );


            $url_pedido =array();
            $groupkey='IdMotoboy';
            $n_array = groupArray($array,$groupkey);
            foreach ( $n_array as $arr ) {

                if($arr[IdMotoboy ] !=''){
                  $nombre = '';
                  foreach($arr[groupeddata] as $array_domi){
                                  if($array_domi[EstadoNombre]!='Entregado' || $array_domi[EstadoNombre]!='Retirado en camino a destino'){
                                      $CEDULA      = $array_domi[ DNI ]  ;
                                      $nombre      = $array_domi[ Nombre ]  ;
                                      $nombre      =(eliminar_duplicados($nombre));
                                      $telefono_rep= $array_domi[ TelefonoRepartidor];
                                      $telefono_rep= eliminar_duplicados($telefono_rep);
                                      $fecha_act   = $array_domi[ UltimaActualizacion];
                                      $fecha_act   = eliminar_duplicados($fecha_act);
                                      $Placa       = $array_domi[ Patente ];
                                      $Placa       = eliminar_duplicados($Placa);
                                      $Placa       = ($Placa=='')?'SIN PLACA':$Placa ;
                                      
                                      
                                      
                                      if($array_domi[ ReferenciaExterna ]==$factura_despacho){
                                        // $tracking_url       = $array_domi[ TrackingUrl ];
                                        array_push(
                                          $url_pedido,
                                          ["seguimiento"=> $array_domi[ TrackingUrl ], "evidencia"=>$array_domi[ FotoNoEntregado ],"estado"=>$array_domi[ EstadoNombre ]]
                                      );
                                        // $url_pedido       = $array_domi[ TrackingUrl ];
                                        // echo "<details><summary>Ver Pedido : ".$array_domi[ ReferenciaExterna ]."</summary>";
                                        // echo "📦".$array_domi[ ReferenciaExterna ]." <a href='$tracking_url' target='_blanck'>Seguimiento</a>   <br>";    
                                        // echo '</details><br>';
                                        // echo $tracking_url;

                                      }

                                      $ped .=$array_domi[ ReferenciaExterna ];
                                      $estad='NO_ENTREGADO';
                                    }else{
                                    $estad='ENTREGADO';
                                    $ped='';
                                  }
                            }
                            
                      }
                }
        }

return $url_pedido; 
}


?>