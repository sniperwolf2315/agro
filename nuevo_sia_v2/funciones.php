<?php
// echo " Funciones raiz";
function validar_documento_numero( $dato_validar ) {
    // if ( ereg( "^[a-zA-Z0-9\-_]{3,20}$", $dato_validar ) ) {
    if ( ereg( "^[0-9\-_]{3,20}$", $dato_validar ) ) {
        // echo "$dato_validar es correcto<br>";
        return true;
    } else {
        // echo "$dato_validar no es válido<br>";
        return false;
    }
}

function ced_vene( $ced_domi ) {
    $ult_coma = strrpos( $ced_domi, ',' );

    if ( $ult_coma > 0 && strlen( $ced_domi )>10 ) {
        // echo 'Ultima coma en toda la cadena';
        $total_caracter = strlen( $ced_domi );
        $ced_domi =  substr( substr( $ced_domi, $ult_coma ), 1 ) ;
        return $ced_domi ;

    } else if ( $ult_coma > 1 && strlen( $ced_domi )<10 ) {
        // echo 'Coma al final del texto';
        $ced_domi = substr( $ced_domi, 0, -1 );
        return $ced_domi ;

    } else {
        // echo 'No tiene coma';
        // $ced_domi = substr( $ced_domi, 1 );
        return $ced_domi ;

    }

}

/**
* ESTA FUNCION VA A VALIDAR QUE NO SE REGISTRE 2 VECES EN EL MISMO INSTANTE EJE: PUSO 2 VECES EL DOCUMENTO DE IDENTIDAD
*/

function valida_registro_turno( $conection, $cedula ) {
    $consulta = ( "select * from API_REPARTIDORES where ESTADO in('ESPERA','CARGA') and CEDULA='".$cedula."'" );
    $cantidad_duplicados = $conection->consultar( $consulta );
    $cantidad = mssql_num_rows( $cantidad_duplicados );
    $cantidads = mssql_fetch_array( $cantidad_duplicados );
    if ( $cantidad>0 ) {
        return $cantidads[ 11 ];
    } else {
        return 0;
    }

}

function msj_informacion( $msj, $color, $icon ) {
    echo"
    <script>
    Swal.fire({
       icon: '".$icon."',
       title: 'AGROCAMPO DICE',
       text: '".$msj."' ,
       color: '".$color."',
       backdrop: '".$color."'
      
     });
    </script>
    ";

}

function eliminar_duplicados( $text ) {
    $text = explode( ',', $text );
    $text = array_unique( $text );
    $text = implode( ',', $text );
    if ( strlen( $text ) <= 10 ) {
        $text = $text;
    } else {
        $text = substr( $text, 0, -1 );
    }
    return $text;
}

function groupArray( $array, $groupkey )
 {
    if ( count( $array )>0 )
 {
        $keys = array_keys( $array[ 0 ] );
        $removekey = array_search( $groupkey, $keys );
        if ( $removekey === false )
        return array( 'Clave \'$groupkey\' no existe' );
        else
        unset( $keys[ $removekey ] );
        $groupcriteria = array();
        $return = array();
        foreach ( $array as $value )
        {
            $item = null;
            foreach ( $keys as $key )
            {
                $item[ $key ] = $value[ $key ];
            }
            $busca = array_search( $value[ $groupkey ], $groupcriteria );
            if ( $busca === false )
            {
                $groupcriteria[] = $value[ $groupkey ];
                $return[] = array( $groupkey=>$value[ $groupkey ], 'groupeddata'=>array() );
                $busca = count( $return )-1;
            }
            $return[ $busca ][ 'groupeddata' ][] = $item;
        }
        return $return;
    } else
    return array();
}

function format_fecha_hora_sia($fecha_hora){
    $hora_novedad = date("Y/m/d h:i:s", strtotime($fecha_hora));
    $date = new DateTime($hora_novedad);
    $hora_novedad_fn = $date->format('Y-m-d h:i:s');

    return $hora_novedad_fn;
}


?>