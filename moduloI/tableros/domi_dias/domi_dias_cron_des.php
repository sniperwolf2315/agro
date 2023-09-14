<?php
// echo 'ESTE ES EL ARCHIVO DE DESARROLLO<br>';
//ESTO NO SE DEBE BORRAR PARA IDENTIFICAR QUE ES EL ARCHIVO DE DESARROLLO

include_once( './conection/conexion_db.php' );
include_once ('../../../nuevo_sia_v2/conection/conexion_sql.php');
/* Cada media hora: Extrae la informacion de IBS y guarda en tabla MySql la infor a ser morstrada en el control de dias de despacho A las 8pm gurada los dpatos para el indicador en dia 3  */

/*LAMMAMOS LA CLASE DE LA CONEXION A IBS */
if ( conexion_ibs::abrir_ibs() ) {
    $con_ibs = conexion_ibs::abrir_ibs();
} else {
    $con_ibs = 'No se conecto a IBS';
    conexion_ibs::cerrar_ibs();
}

/*LAMMAMOS LA CLASE DE LA CONEXION A MYSQL */
$con_mysql = new conexion_mysql();
if ( $con_mysql->abrir_mysql() ) {
    $mysqliL = $con_mysql->abrir_mysql();
} else {
    $con_mysql->cerrar_mysql();
    echo 'no se pudo conectar a la SQL';
}

$hoy    = date( 'Ymd' );
$hoy_1  = date( 'Ymd', strtotime( "$hoy - 1 day" ) );
$hoy_2  = date( 'Ymd', strtotime( "$hoy - 2 day" ) );
$hoy_3  = date( 'Ymd', strtotime( "$hoy - 3 day" ) );
$hoy_4  = date( 'Ymd', strtotime( "$hoy - 4 day" ) );
$hoy_10 = date( 'Ymd', strtotime( "$hoy - 10 day" ) );



$n = 1;
$hoy_n = date( 'Ymd', strtotime( "$hoy - $n day" ) );

$ahora = date( 'M-d. H:i' );
$ahoraHM = date( 'H:i' );
$ahora = str_replace( 'Jan', 'Ene', $ahora );

$area = 'Moto';
if ( $area == 'Portos' ) {
}
if ( $area == 'Calle73' ) {
}
if ( $area == 'Moto' ) {
    $farea = "and SROORSHE.OHDEST IN ('1','2','3') ";
}
$cuantoantes = $hoy_10;

$con_sql = new con_sql('sqlFacturas');
/* esta variable enlista todas las ordenes que ya estan despachadas */
$ya_despachadas = $con_sql->consultar("select Orden from facRegistroFactura where year(Fecha)=YEAR(GETDATE()) and month(Fecha) = MONTH(getdate())");
$no_incluir ='';

while ($ordenes  = mssql_fetch_array($ya_despachadas ) ){
  $no_incluir .="$ordenes[0],";
}
$no_incluir=substr($no_incluir,0,-1);




/* DESEAMOS SABER CUANTAS RONDAS DEBEN HACERCE */
$sql_rondas = ( "select distinct (OHODAT) from agr620cfag.sroorshe where  OHORDT in( '01', '03', '04', '06','D3','D5','S1','S2', 'S3', 'S5' ) and ohodat >= '$cuantoantes' and ohstat <> 'D' and ohords <> 0 order by ohodat" );
$rondas_grupos_fechas = odbc_exec( $con_ibs,  $sql_rondas );

while( $rondas = odbc_fetch_array( $rondas_grupos_fechas ) ) {

    $id++;
    $cuantoantes = $rondas[ 'OHODAT' ];
    $sql = "select 
    ohorno as ORDEN
   ,ohordt as TIPO
   ,replace(ohcuno,'-','') as CC
   ,ohords as ESTADO_OV
   ,case when
     (select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) = '10'
     then '10'
       else
         case when
           (select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) = '60'
           then '60'
           else
             '20-45'
         end
     end as ESTADO	    
   ,(select min(olords) as min_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) as MIN_ESTADO
   ,(select max(olords) as max_estado from sroorspl srbsol where srbsol.olorno = sroorshe.ohorno ) as MAX_ESTADO
   ,substr(ohodat,1,4)||'-'||substr(ohodat,5,2)||'-'||substr(ohodat,7,2) as FECHA
   ,case when
     ohodat = '$hoy'
     then '1'
       else
         case when ohodat between '$hoy_2' and '$hoy_1'
           then '2'
           else
             case when
               ohodat = '$hoy_3'
                 then '3'
                 else
                   case when
                     ohodat <= '$hoy_4'
                     then '4 o mas'
                   end
              end
           end
         end
     as dia
   , ifnull(( select case when substr(sroorshe.ohdest,1,4)= '1100'
              then 'domi-agro'
              else
                case when substr(sroorshe.ohdest,1,4) < 10
                then substr(trim(dtdesc),1,7)
                else
                'rem-'||substr(trim(dtdesc),1,7)
                end
              end  
     FROM AGR620CFAG.SRODST where dtdest = sroorshe.ohdest),'SIN DEST')  as DESTINO
   FROM AGR620CFAG.SROORSHE SROORSHE
   where
   OHORDT in( '01', '03', '04', '06','D3','D5','S1','S2', 'S3', 'S5' )
   and ohodat = '$cuantoantes'
   and ohstat <> 'D'
   and ohords <> '0'
   order by ohodat  
   ";
  //  and ohorno not in ($no_incluir)
  //  echo $sql.'<br>';
    //PREPARAR LA CONSULTA PARA INSERTAR LOS DATOS A MYSQL
    $result = odbc_exec( $con_ibs, $sql ) ;
    while( $row = odbc_fetch_array( $result ) ) {
        $row[ 'ACTUALIZADO' ] = $ahora;
        $dia = $row[ 'DIA' ];
        $orden = $row[ 'ORDEN' ];
        $estado = $row[ 'ESTADO' ];
        $row[ 'DEST' ] = SUBSTR( $row[ 'DESTINO' ], 0, 3 );
        if ( $row[ 'MAX_ESTADO' ] == '60' ) {
            $e60 .= ",'$row[ORDEN]'" ;
        }
        $comaC = '';
        $comaV = '';
        foreach ( $row as $campo => $valor ) {
            //datos tablero
            $ti[ "$dia" ][ "$orden" ][ "$campo" ] = utf8_encode( strtoupper( $valor ) );
            //construye insert MySQL
            $campos .= "$comaC$campo";
            $valores .= "$comaV$valor";
            $comaC = ',';
            $comaV = "','";
        }
        $mysqlINSERT[ "$orden" ] = "INSERT INTO tablero_dias ($campos) VALUES ('$valores'); ";
        $campos = '';
        $valores = '';
        
      }
    //WHILE
}
/*
HACER PAQUETES INSERT POR DIAS
limit 5680
21072022 por conversacion con Nancy Morantes se agregan las 01 03 04 06 D3
NOTA: correo del 29072022 Segun lo indicado por Nancy Morantes
Se creo documento D5, para bodega 005  Domicilios pagos, se comporta igual que una D3, con la diferencia  que este tipo al realizarla el cliente la paga de una vez,
Cuando sale para entrega de Domicilios sale ya pagada.
ohordt in( '01', '03', '04', '06', 'D3', 'D5', 'S1', 'S2', 'S3', 'S5' )
ohordt in( '01', '03', '04', '06', 'D3', 'S1', 'S2', 'S3', 'S5' )
OHORDT in( 'S1', 'S2', 'S3', 'S5' )
OHORDT in( 'S1', 'S3' )
27072022 Carlos Castelblanco indica agrear replace( ohcuno, '-', '' ) as cc para eliminar el simbolo -
*/

$e60 = substr( $e60, 1 );
$con_server = $con_mysql->abrir_mysql();
$sqlMS = "select orden from facregistrofactura where fecha >= '$cuantoantes' and orden in($e60) ";
// echo $sqlMS ;
$resultMS = mssql_query( $con_server, $sqlMS );
//*VALIDAMOS QUE REGRESE REGISTROS LA CONSULTA
while( $rowMS = mssql_fetch_assoc( $resultMS ) ) {
    $orden = $rowMS[ 'orden' ];
    foreach ( $ti AS $day => $algo ) {
        unset( $ti[ "$day" ][ "$orden" ] );
    }
    unset( $mysqlINSERT[ "$orden" ] );
}
 
//inserta encabezados mysql local
// mysqli_query( $mysqliL, "DELETE from tablero_dias where orden in($e60)");
mysqli_query( $mysqliL, "truncate tablero_dias ");
foreach ( $mysqlINSERT AS $ins ) {
    mysqli_query( $mysqliL, $ins ) ;
    //or die( mysqli_error( $mysqliL )."<br> $ins" );
    if ( mysqli_query( $mysqliL, $ins ) ) {
    } else {
        // echo mysqli_error( $mysqliL )."<br> ALERTA! $ins<br>";
    }
}
//a las 8 pm guarda la infor del indicador
if ( $ahoraHM >= '06:00' AND $ahoraHM <= '24:00' ) {
    $sql = "
    select '".date( 'y-m-d' )."' as FECHA
	, (select count(*) from tablero_dias b where b.dia = a.dia and (estado in('10'))) as CAL
	, (select count(*) from tablero_dias b where b.dia = a.dia and ((estado in('20-45')) or (estado in('60') and dest not in('exp','web','rem') ))) as DOM
	, (select count(*) from tablero_dias b where b.dia = a.dia and (estado in('60') and dest in('rem') ) ) as REM
	, (select count(*) from tablero_dias b where b.dia = a.dia and (estado in('60') and dest in('exp') ) ) as EXP
	, (select count(*) from tablero_dias b where b.dia = a.dia and (estado in('60') and tipo in('S1','S5') ) ) as WEB
	from tablero_dias a where a.dia = '3'
	limit 0 ,1 ";
    $result = mysqli_query( $mysqliL, $sql );
    while( $row = mysqli_fetch_assoc( $result ) ) {
        $comaC = '';
        $comaV = '';
        foreach ( $row as $campo => $valor ) {
            //construye insert MySQL
            $campos .= "$comaC$campo";
            $valores .= "$comaV$valor";
            $comaC = ',';
            $comaV = "','";
        }
        $sqlINS = "INSERT INTO tablero_dias_indicador ($campos) VALUES ('$valores'); ";
        //-> mysqli_query( $mysqliL, $sqlINS ) or die( mysqli_error( $mysqliL ) );
        $campos = '';
        $valores = '';
    }

}
mssql_close();
odbc_close_all();
echo "Todo OK";
?>