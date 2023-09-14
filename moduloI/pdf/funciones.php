<?php 


function eliminar_duplicados( $text ) {
    $text = explode( ',', $text );
    $text = array_unique( $text );
    $text = implode( ',', $text );
    if ( strlen( $text ) <= 10 ) {
        $text = $text;
    } else {
        // $text = substr( $text, 0, -1 );
        $text = $text;
        // $text = substr( $text, 0, 0 );
    }
    return $text;
}
 
?>