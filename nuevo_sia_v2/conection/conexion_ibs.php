<?php
//  echo "Nos conectamos a IBS <br>";
class con_ibs{
    public $server = '' ;
    public $user   = '' ;
    public $pass   = '' ;
    public $rta_consul  ;

    public function __construct( $server, $usuario, $clave ) {

        $this->server= ($server=="")?'IBM-AGROCAMPO-P':$server;
        $this->user  = ($usuario=="")?'ODBC':$usuario;
        $this->pass  = ($clave=="")?'ODBC':$clave;
    }

    public function conectar( $query_consulta ) {
        $conn = odbc_connect( $this->server, $this->user, $this->pass ) or die( 'NO SE PUEDE CONECTAR AL SERVER' );
        if ( $conn ) {
            $this->rta_consul = odbc_exec( $conn, $query_consulta );
            return $this->rta_consul  ;
        } else {
            return $this->rta_consul = 'error no se puede conectar a la base de datos IBS'.odbc_errormsg();
        }
    }

    public function cerrar() {
        // odbc_close( $conn );
        odbc_close_all();
    }

}


?>