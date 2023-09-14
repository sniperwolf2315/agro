<?php
//POSTGRES ODDO
class Conexion{
    private static $Conexion;
    
    public static function abrirConexion(){
        if(!isset(self::$Conexion)){           
            try{
                include_once 'config.php';
                self::$Conexion=new PDO('pgsql:host='.NOMBRE_SERVIDOR.'; port='.PUERTO.'; dbname='.BASE_DE_DATOS, NOMBRE_USUARIO, PASSWORD);
                self::$Conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Conexion->exec("SET NAMES 'utf8'");     
            }catch(PDOException $ex){
                print "ERROR". $ex->getMessage()."<br />";
            }
        }
    }
    
    public static function cerrarConexion(){
        if(isset(self::$Conexion)){
            self::$Conexion = null;
        }
    }
    
    public static function obtenerConexion(){
        if(isset(self::$Conexion)){
            return self::$Conexion;   
        }
        else{
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