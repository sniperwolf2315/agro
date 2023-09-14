<?php
function getRealIP() {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}

function consultar_turno( $con_sql, $capacidad_por_ventanilla ) {
    /** limite de atencion por ventanilla */
    // $capacidad_por_ventanilla = 15;
   $ventanilla_atencion = 0 ;
//    $consulta = ( " select VENTANILLA, count(VENTANILLA) ASIGNADOS from API_REPARTIDORES where ESTADO in('ESPERA','CARGA') and VENTANILLA=1 group by VENTANILLA" );
   $consulta = ( "SELECT 
VENTANILLA, 
max(TURNO) ASIGNADOS 
from API_REPARTIDORES 
where ESTADO in('ESPERA','CARGA') 
and VENTANILLA=1 
and year(HORA_INGRESO)=year(GETDATE()) 
and month(HORA_INGRESO)=month(GETDATE()) 
and day(HORA_INGRESO) = day(GETDATE())
group by VENTANILLA
   " );
   $turnos = $con_sql->consultar( $consulta );

   if(mssql_num_rows( $turnos ) <= 0 ){
        $ventanilla_atencion = 1;
        return $ventanilla_atencion;
        // $con_sql->insertar( "UPDATE API_CONFIGURACION SET VALOR=$ventanilla_atencion WHERE id = 3" );

    }else{
            /* validamos en que turno estamos */
            $consulta_turno  = ( 'select VALOR from API_CONFIGURACION where id =3' );
            $t               = $con_sql->consultar( $consulta_turno );
            $tur             = mssql_fetch_array( $t );
            
            /* validamos cuantas ventanas o bahias tenemos disponibles para despachar */
            $consulta_ventana= ( 'select VALOR from API_CONFIGURACION where id =1' );
            $ven             = $con_sql->consultar( $consulta_ventana );
            $ven_arr         = mssql_fetch_array( $ven );

            /* VALIDAMOS CUANTAS VENTANILLAS ESTAN ACTIVAS SI 1 LA VENTANILLA SIEMPRE ES 1 CASO CONTRARIO ROTA */
             if($ven_arr[0]== '1'){
                $ventanilla_atencion = 1;
                $con_sql->insertar( "UPDATE API_CONFIGURACION SET VALOR=$ventanilla_atencion WHERE id = 3" );
            } else{
                if ( $tur[ 0 ] == 1 ) {
                        $ventanilla_atencion = 2;
                        $con_sql->insertar( "UPDATE API_CONFIGURACION SET VALOR=$ventanilla_atencion WHERE id = 3" );
                    } else if ( $tur[ 0 ] == 2 ) {
                        $ventanilla_atencion = 3;
                        $con_sql->insertar( "UPDATE API_CONFIGURACION SET VALOR=$ventanilla_atencion WHERE id = 3" );
                    } else  if ( $tur[ 0 ] == 3 ) {
                        $ventanilla_atencion = 1;
                        $con_sql->insertar( "UPDATE API_CONFIGURACION SET VALOR=$ventanilla_atencion WHERE id = 3" );
                    }
            }

            return $ventanilla_atencion;
        }
    
}
/**
* ESTA FUNCION VA A VALIDAR QUE NO SE REGISTRE 2 VECES EN EL MISMO INSTANTE EJE: PUSO 2 VECES EL DOCUMENTO DE IDENTIDAD
*/

?>