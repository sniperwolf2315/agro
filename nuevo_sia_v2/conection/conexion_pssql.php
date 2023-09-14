<?php
// echo "se conecto a postgres de odoo";
class con_pssql {
    public $server = '200.7.102.222' ;
    public $user   = 'agrocampo' ;
    public $pass   = 'Agro2023!.' ;
    public $port   = '5499' ;
    public $bd     = '' ;
    public $rta_consul ='' ;

    public function __construct( $base_datos ) {
        $this->bd = $base_datos;
    }

    public function conectar( $query_consulta ) {
        $conn_string = "host= $this->server  port= $this->port dbname=$this->bd user=$this->user password=$this->pass";
        
        $conn = pg_connect( $conn_string)  or die("Sin Conexion SERVER");
        if ( $conn ) {
            $this->rta_consul = pg_query( $conn,$query_consulta ) or die ("no se puedo ejecutar la consulta");
            return ( $this->rta_consul ) ;
        } else {
            return $this->rta_consul = 'error no se puede conectar a la base de datos ODOO'.pg_last_error;
        }
        pg_close( $conn );
    }

}

?>