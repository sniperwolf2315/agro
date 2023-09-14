<?php

class conexion_ibs {
    function __constructor() {
    }

    public function abrir_ibs() {
        session_start();
        $db2conp = odbc_connect( 'IBM-AGROCAMPO-P', odbc, odbc );
        return( $db2conp )?$db2conp:false;
    }

    public function cerrar_ibs() {
        odbc_close( abrir_ibs() );
    }
}

class conexion_mysql {
    function __constructor() {
    }

    public function abrir_mysql() {

        $localhostL  = 	'localhost'	;
        $userA 		 = 	'sistemas'	;
        $claveO		 = 	'sistemasqgro';
        $base_datosL = 	'agrobase'	;
        $mysqliL = new mysqli( $localhostL, $userA, $claveO, $base_datosL );
        return ( $mysqliL )?$mysqliL:false;
    }

    public function cerrar_mysql() {
        mysqli_close( abrir_mysql() );
    }

}

class conexion_sql {
    function __constructor() {
    }

    public function abrir_sql() {
        $con = mssql_connect( '192.168.6.15', 'sa', '%19Sis60Tem@s17' ) or die( mssql_get_last_message() );
        mssql_select_db( 'SqlFacturas', $cLink );

        return( $con )?'secon':'nosecon';

    }

    public function cerrar_sql() {
        mssql_close( abrir_sql() );
    }
}

?>
