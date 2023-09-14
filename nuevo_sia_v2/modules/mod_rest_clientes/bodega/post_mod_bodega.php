<?php
return;

// echo ( $array )?'✔ <br>'=>'❌ <br>';
$DATA_PICAP = array(
    'booking'=>array(
        'address'=> 'Cra. 61 #23z-42',
        'secondary_address'=> 'Diagonal a la panadería',
        'lat'=> 4.653652,
        'lon'=> -74.108101,
        'requested_service_type_id'=> '5c71b03a58b9ba10fa6393cf',
        'return_to_origin'=> false,
        'requires_a_driver_with_base_money'=> false,
        'scheduled_at'=> null,
        'stops'=>[
            array(
                'address'=> 'Titan',
                'secondary_address'=> 'Diagonal al centro comercial',
                'lat'=> 4.695382,
                'lon'=> -74.085727,
                'customer'=> array(
                    'name'=> 'Cliente',
                    'country_code'=> '57',
                    'phone'=> '30112345678',
                    'email'=> 'docs@picap.co'
                ),
                'packages'=>[
                    array(
                        'indications'=> 'Indicaciones',
                        'declared_value'=> array(
                            'sub_units'=> 210000,
                            'currency'=> 'COP'
                        ),
                        'reference'=> 'Pedido 1',
                        'counter_delivery'=> false,
                        'size_cd'=> 1
                    )
                ]
            )
        ]
    )
);

echo '<br> /POST <br>';

$end_point = 'bookings/eta?t=';
//TODO=> ESTAMOS VALIDANDO MEDIANTE EL POST
$rs_ps    = API_REST::POST( $PROD_URL_PIBOX.$end_point, $PROD_TOKEN_PIBOX, $DATA_PICAP );
$array_ps = API_REST::JSON_TO_ARRAY( $rs_ps );
var_export( $array_ps );

echo '<br> /DELETE <br>';

$end_point = 'hooks?t=';
$DATA_PICAP = array(
    '_id'=>'5d7f23ec56c97100147bfba2',
    'url'=>'https://www.api.test/hook/bookings',
    'event_cd'=> 0,
    'headers'=> []
);
// //TODO=> ESTAMOS VALIDANDO MEDIANTE EL POST
$rs_ps    = API_REST::DELETE( $PROD_URL_PIBOX.$end_point, $PROD_TOKEN_PIBOX, $DATA_PICAP );
$array_ps = API_REST::JSON_TO_ARRAY( $rs_ps );

/*
echo "
<script>
API_REST_GET();
API_REST_POST2('$PROD_URL_PIBOX_POST.$PROD_TOKEN_PIBOX, $DATA_PICAP ');

</script>";
*/

?>