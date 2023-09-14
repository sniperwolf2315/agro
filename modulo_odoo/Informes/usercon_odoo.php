<?php
//POSTGRES ODDO

class Conexion {
    public static $Conexion;

    public static function abrirConexion() {
        if ( !isset( self::$Conexion ) ) {

            try {
                // include_once 'config.php';
                include 'config.php';
                self::$Conexion = new PDO( 'pgsql:host='.NOMBRE_SERVIDOR.'; port='.PUERTO.'; dbname='.BASE_DE_DATOS, NOMBRE_USUARIO, PASSWORD );
                self::$Conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                self::$Conexion->exec( "SET NAMES 'utf8'" );

                //  echo NOMBRE_SERVIDOR.' '.PUERTO.''.BASE_DE_DATOS.''. NOMBRE_USUARIO.''. PASSWORD.'<br>'   ;
            } catch( PDOException $ex ) {
                print 'ERROR'. $ex->getMessage().'';
            }
        }
    }

    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/

    public static function cerrarConexion() {
        if ( isset( self::$Conexion ) ) {
            self::$Conexion = null;
        }
    }
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/
    /*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX*/

    public static function obtenerConexion() {
        if ( isset( self::$Conexion ) ) {
            return self::$Conexion;

        } else {
            return null;
        }
    }
}

/*
Conexion::abrirConexion();
Conexion::obtenerConexion();
Conexion::cerrarConexion();

*/

?>