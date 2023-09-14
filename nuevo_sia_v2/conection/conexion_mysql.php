<?php

class con_mysql {
    public $server = 'localhost' ;
    public $user  = 'sistemas' ;
    public $pass  = 'sistemasqgro' ;
    public $bd = '' ;
    public $rta_consul  ;

    public function __construct( $base_datos ) {
        $this->bd = $base_datos;
    }

    public function conectar( $query_consulta ) {
        $conn = mysqli_connect( $this->server, $this->user, $this->pass) or die("Sin Conexion SERVER");
        if ( $conn ) {
           $db =  mysqli_select_db( $conn , $this->bd )or die("Sin conectar a la BD");
            $this->rta_consul = mysqli_query( $conn,$query_consulta )or die ("no se puedo ejecutar la consulta");
            return ( $this->rta_consul ) ;
        } else {
            $this->rta_consul = 'error no se puede conectar a la base de datos MYSQL'.mysqli_connect_error() ;
        }
        mysqli_close( $conn );
    }

}

?>