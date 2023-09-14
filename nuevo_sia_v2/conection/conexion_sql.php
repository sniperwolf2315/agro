<?php
// echo'Nos conectamos a sql <br>';

class con_sql {
    public $server = '192.168.6.15' ;
    public $user  = 'sa' ;
    public $pass  = '%19Sis60Tem@s17' ;
    public $bd  ;
    public $rta_consul  ;

    public function __construct( $base_datos ) {
        $base_datos =($base_datos=='')?'sqlfacturas':$base_datos;
        $this->bd = $base_datos;
        $conn = mssql_connect( $this->server, $this->user, $this->pass ) or die( mssql_get_last_message() );

    }

    public function conectar_motor() {
        $conn = mssql_connect( $this->server, $this->user, $this->pass ) or die( mssql_get_last_message() );
        if ( $conn ) {
            return $conn;
        } else {
            return 'Error al conectar'.die;

        }

    }

    public function conectar( $query_consulta ) {
        $conn = mssql_connect( $this->server, $this->user, $this->pass ) or die( mssql_get_last_message() );
        if ( $conn ) {
            mssql_select_db( $this->bd, $conn );
            $this->rta_consul = mssql_query( $query_consulta );
            return ( $this->rta_consul ) ;
            // mssql_free_result( $this->rta_consul );
        } else {
            $this->rta_consul = 'error no se puede conectar a la base de datos SQLSRV';
            return  $this->rta_consul;
        }
    }

    public function insertar( $query_consulta ) {
        $conn = mssql_connect( $this->server, $this->user, $this->pass ) or die( mssql_get_last_message() );
        if ( $conn ) {
            mssql_select_db( $this->bd, $conn );
            mssql_query( $query_consulta ) or die(mssql_get_last_message());
            // echo 'OK';

        } else {
            $this->rta_consul = 'error no al Insertar a la base de datos SQLSRV';
            return  $this->rta_consul;
        }
    }

    public function consultar( $query_consulta ) {
        $con = $this->conectar_motor();
        mssql_select_db( $this->bd, $con );
        $this->rta_consul = mssql_query( $query_consulta );
        if($this->rta_consul){
            return $this->rta_consul;
        }else{
            return "ERROR DE EJECUCION CONSULTA <br>".$query_consulta ;

        }
    }

    public function cerrar( $con ) {
        mssql_close( $con );
    }

    function contador()
 {
        /* time();
        $today = strtotime( 'today 12:00' );
        $tomorrow = strtotime( 'tomorrow 12:00' );
        $time_now = time();
        $timeLeft = ( $time_now > $today ? $tomorrow : $today ) - $time_now;
        return gmdate( 'H:i:s', $timeLeft );
        */
        $time_pre = microtime( true );
        $time_post = microtime( true );
        $exec_time = $time_post - $time_pre;
        echo( $exec_time.'ms' );

    }

}

?>