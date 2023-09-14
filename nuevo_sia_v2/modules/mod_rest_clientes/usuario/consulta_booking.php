<?php

require_once( '../../../environments/develop.php' );
require_once( '../../../environments/production.php' );

$booking = isset( $_POST[ 'booking' ] )?$_POST[ 'booking' ]:'asd2316547sdhnvc34as6';
?>
<form method = 'POST' action = '#' id = 'form_booking' name = 'form_booking' class = 'form_booking' style='color: darkgray; '>
<label for = '#booking'>
<h3>
Ingrese el Booking:
</h3>
</label>
<br>
<input id = 'booking' name = 'booking' class = 'booking' type = 'text' placeholder = "<?=$booking?>"
style = 'border: 5px solid darkgray; width: 100%; height:20px; border-radius: 20px; padding:5% ;font-size:6vh; '><br>
<input type = 'submit' value = 'Consultar'
style = '
       margin-top:10px;
       border: 5px solid darkgray;
       width: 100%; 
       height:15%; 
       border-radius: 20px; 
       font-size:6vh; 
       cursor: pointer; 
       background-color:#49944b;
       color: white;
       text-align: center;
       justify-item: center;
       '>
</form>
<?php
echo "<h3> El Booking insertado es : $booking  </h3> <br> ";
if ( $booking ) {

    $curl = curl_init();
    curl_setopt_array( $curl, [
        CURLOPT_URL => "$PROD_URL_PIBOX_BOOKING$booking?t=$PROD_TOKEN_PIBOX",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'Accept: */*'
        ],
    ] );
    $response = curl_exec( $curl );

    if ( $response ) {
        /** SI SE CUMPLE QUE TRAE DATOSPROCEDEMOS A MOSTRAR */
        echo '<a href="https://pibox.app/bookings/'.$booking.'" target="_blank"> Validar pedido desde el proveedor </a> <br> <br>';

        $response   = json_decode( $response, true );
        $nombre     = $response [ 'driver' ][ 'name' ];
        $documento  = intval( $response [ 'driver' ][ 'fiscal_number' ] );
        $telefono   = $response [ 'driver' ][ 'phone' ];
        $placa      = $response [ 'served_vehicle' ][ 'plates' ];
        $pedidos    = '';
        $stops =  $response[ 'stops' ];
        $cont_ped  = 0;

        echo "
        Nombre : $nombre      <br>
        Documento : $documento<br>
        Telefono : $telefono  <br>
        Placa : $placa        <br>";
        echo "Pedidos encontrados para este booking diferentes a entregados:<br>";
        foreach ( $stops as $packages ) {
            foreach ( $packages[ 'packages' ] as $referencias ) {
                if ( $referencias[ 'status_cd' ] != 2 ) {
                    $pedidos .= $referencias[ 'reference' ].',';
                    echo $referencias[ 'reference' ].'<br>';
                }
            }
        }
        $pedidos = substr( $pedidos, 0, -1 );
        $cont_ped = count( explode( ',', $pedidos ) );
        confirmar_insert( $insertar_por_book, $documento, $booking, $pedidos, $nombre, $placa, $telefono, $cont_ped );

    } else {
        echo 'No hay datos para este Booking';
    }
} else {
    echo '<h1> El booking esta en blanco</h1> ';
}

function confirmar_insert( $consulta, $documento, $booking, $pedidos, $nombre, $placa, $telefono, $cont_ped ) {
    echo'
        <form action="#" method="POST" id="confirm_insert" name="confirm_insert" class="confirm_insert" style="color: darkgray;">
            <input type="hidden" value="'.$documento.'" id="txt_doc"     name="txt_doc" class="txt_doc">
            <input type="hidden" value="'.$booking.'"   id="txt_bok"     name="txt_bok" class="txt_bok">
            <input type="hidden" value="'.$pedidos.'"   id="txt_ped"     name="txt_ped" class="txt_ped">
            <input type="hidden" value="'.$nombre.'"    id="txt_nom"     name="txt_nom" class="txt_nom">
            <input type="hidden" value="'.$placa.'"     id="txt_plc"     name="txt_plc" class="txt_plc">
            <input type="hidden" value="'.$telefono.'"  id="txt_tel"     name="txt_tel" class="txt_tel">
            <input type="hidden" value="'.$cont_ped.'"  id="txt_con_ped" name="txt_con_ped" class="txt_con_ped">
            <input type="hidden" value="SI" id="txt_confir" name="txt_confir" class="txt_confir"  >
                
            <input type="submit" value="confirmar" id="btn_confir" name="btn_confir" class="btn_confir"
            style = "
                    margin-top:10px;
                    border: 5px solid darkgray;
                    width: 100%; 
                    height:15%; 
                    border-radius: 20px; 
                    font-size:6vh; 
                    cursor: pointer; 
                    background-color:#49944b;
                    color: white;
                    text-align: center;
                    justify-item: center;
       "
            >
        </form>
    
    ';

    if ( $_POST[ 'txt_confir' ] == 'SI' ) {
        require_once( '../../../conection/conexion_sql.php' );

        $conn = new con_sql( 'sqlfacturas' );

        $documento   = $_POST[ 'txt_doc' ]    ;

        $booking =     $_POST[ 'txt_bok' ]    ;
        $pedidos =     $_POST[ 'txt_ped' ]    ;
        $nombre =      $_POST[ 'txt_nom' ]    ;
        $placa =       $_POST[ 'txt_plc' ]    ;
        $telefono =    $_POST[ 'txt_tel' ]    ;
        $cont_ped =    $_POST[ 'txt_con_ped' ];
        $insertar_por_book = ( "INSERT INTO API_ASIGNACION (CEDULA,HORA_INGRESO,ESTADO,ID_PEDIDO_PROV,ID_PEDIDOS_AGRO,NOMBRE,PLACA,CELULAR,CANTIDAD_PED_AGRO,EMPRESA) VALUES ($documento,GETDATE(),'INGRESO','$booking','$pedidos','$nombre','$placa','$telefono',$cont_ped,'PIBOX')" );
        $conn->insertar( $insertar_por_book );
        echo 'Se ha insertado en el tomen los datos del Booking, favor indicar que escanee la cedula. <br>';
    }

}

?>

