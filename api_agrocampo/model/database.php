<?php

/*
$server = '192.168.6.15\SQL2017';
$link = mssql_connect( $server, 'sa', '%19Sis60Tem@s17' );
if ( !$link ) {
    die( 'Algo fue mal mientras se conectaba a MSSQL' );
} else {
    echo 'se conecto a sqlserver';
}

$con_ins = odbc_connect( 'IBM-AGROCAMPO-P', 'CONSULTA', 'CONSULTA' );
if ( !$con_ins ) {
    die( 'Algo fue mal mientras se conectaba a ibs' );
} else {
    echo 'se conecto a ibs';
}
*/

class Database
 {
    protected $connection = null;

    public function __construct()
 {
        try {
            // $this->connection = new mysqli( DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME );
            $this->connection = odbc_connect( 'IBM-AGROCAMPO-P', 'CONSULTA', 'CONSULTA' );

            if ( mysqli_connect_errno() ) {
                throw new Exception( 'Could not connect to database.' );

            }
        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );

        }

    }

    public function select( $query = '', $params = [] )
 {
        try {
            $stmt = $this->executeStatement( $query, $params );
            // $result = $stmt->get_result()->fetch_all( MYSQLI_ASSOC );
            $result = $stmt->get_result()->odbc_fetch_array( MYSQLI_ASSOC );

            $stmt->close();

            return $result;
        } catch( Exception $e ) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    private function executeStatement( $query = '', $params = [] )
 {
        try {
            $stmt = $this->connection->prepare( $query );

            if ( $stmt === false ) {
                throw New Exception( 'Unable to do prepared statement: ' . $query );
            }

            if ( $params ) {
                $stmt->bind_param( $params[ 0 ], $params[ 1 ] );
            }

            $stmt->execute();

            return $stmt;
        } catch( Exception $e ) {
            throw New Exception( $e->getMessage() );
        }

    }
}

?>