<?php
$tokens_permit=['YATjQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO','PET2988B0268192BC7115B898F8C344C274SPA'];
$token_var=$_GET[ 'AAMkAGE4ODJhY' ];
$pasa = (in_array($token_var,$tokens_permit) )?1:0;

if ( $pasa == 0 ) {
    echo 'lo sentimos no tienes acceso';
    return;
}


/* comprobamos que el usuario nos viene como un parametro */
if ( isset( $_GET[ 'AAMkAGE4ODJhY' ] ) ) {
    /**CLASE CONEXION IBS */
    require( '../nuevo_sia_v2/conection/conexion_ibs.php' );
    require( 'wsIntegracionquery.php' );
    /* utilizar la variable que nos viene o establecerla nosotros */
    $format = strtolower( $_GET[ 'f' ] ) == 'xml' ? 'xml' : 'json';
    
    //JSON es por defecto
    $metodo = intval( $_GET[ 'm' ] );

    /* CONEXION ibs */
    $conn_ibs  = new con_ibs( 'CONSULTA', 'CONSULTA' );


    /** SE DEFINE QUE QUERY SE VA A CONSULTAR EN BASE A LA VARIABLE m */
    if ( $metodo == 'inv' ) {
        $query_ibs = $query_ibs_inv ;
    } else if ( $metodo == '40' ) {
        $query_ibs = $query_ibs_40;
    } else if ( $metodo == '42' ) {
        $query_ibs = $query_ibs_42 ;
    }

    /* creamos el array con los datos */
    $resultado_consulta = $conn_ibs->conectar( $query_ibs );

    $posts = array();

    if ( odbc_fetch_array( $resultado_consulta ) ) {
        while( $post = odbc_fetch_array( $resultado_consulta ) ) {
            $posts[] = array( 'data'=>($post) );
        }
    }

    /* formateamos el resultado */
    if ( $format == 'json' ) {
        header( 'Content-type: application/json' );
        echo json_encode( array( 'data_agro'=>$posts ) );
    } else {
        $filename='data_agro_';
        // header("Content-Type: application/force-download");
        // header("Content-disposition: csv" .$filename. ".csv");
        // header("Content-disposition: filename=".$filename.".csv");
        
        header( 'Content-type: text/xml' );
        echo '';
        foreach ( $posts as $index => $post ) {
            if ( is_array( $post ) ) {
                foreach ( $post as $key => $value ) {
                    echo '<', $key, '>';
                    echo $key.','.$value;
                    if ( is_array( $value ) ) {
                        foreach ( $value as $tag => $val ) {
                            echo '<', $tag, '>', htmlentities( $val ), '';
                        }
                    }
                    echo '';
                }
            }
        }
        echo '';
    }

    /* nos desconectamos de la bd */
    odbc_close( $conn_ibs );
}

?>

