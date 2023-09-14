<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sanciones Agrocampo</title>

  <!-- STILOS -->
  <link rel="stylesheet" type="text/css" href="sanciones.css" media="screen" />

  <!-- LINK -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <!-- SCRIPT  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="sanciones.js"></script>
</head>
<body>
    
<div class="container text-center">
<label for="formGroupExampleInput" class="form-label"><strong> INFORME DE INCOSISTENCIAS</strong> </label>
 
<?php
/*██████████████████████████████████████████████ LIBRERIAS RECURSOS ███████████████████████████████████████████████████████*/
include('../../conection/conexion_sql.php');
include('../../conection/conexion_ibs.php');
/*██████████████████████████████████████████████ LIBRERIAS RECURSOS ███████████████████████████████████████████████████████*/


/*██████████████████████████████████████████████ VARIABLES ███████████████████████████████████████████████████████*/
$fechaActual = date( 'Ymd' );
$fechaActualcom = date( 'Y-m-d h:i:s ' );
$ini_corte   =  date( 'Ym', strtotime( $fechaActual.'- 2 month' ) ).'16';
$fin_corte   =  date( 'Ym', strtotime( $fechaActual ) ).'15';
$usuario_seg_log = $_GET['usr_seg'];

$listado_seguridad = array(
    '1012442314 - AGUIRRE	HERRERA	DANIELA ELIZABETH'
  , '1010025559 - BERRIO	CACERES	MARLON STEVEN'
  , '79500517	  - CAMARGO	DIAZ	JORGE LIBARD'
  , '1010011300 - CARVAJAL	SALGADO	RONALD JAIR'
  , '1000596667 - CHACON	ORDOÑEZ	YEISON SEBASTIAN'
  , '1023974402 - IBARGUEN	LUNA	ERWIN FELIPE'
  , '1006898316 - JIMENEZ	AVILEZ	JHON FREDIS'
  , '1083561981 - LEIVA	SEQUEDA	CECIL DE JESUS'
  , '52870524	  - MONTAÑA	ALDANA	LUZ MARINA'
  , '1000351211 - PEREZ	MELENDEZ	JOSE FRANCISCO'
  , '1002604816 - PEREZ	VALENCIA	CRISTIAN ARBEY'
  , '1003481939 - PIÑEROS	RINCON	MIGUEL ANGEL'
  , '1000987768 - RAMIREZ	PIMENTEL	BRAYAN CAMILO'
  , '1013580618 - VALENCIA	VARGAS	YENIFER'
  , '1020850358 - VILLALBA	SANZ	AXDREL ALEXANDER'
);
$listado_novedad = array(
 'ENTREGA MAS PRODUCTO',
 'ENTREGA MENOS PRODUCTO',
 'FACTURA CON MAS DE 10 LINEAS SIN REVISAR',
 'NO ACOMPAÑAMIENTO',
 'NO ENTREGO PRODUCTO',
 'PRODUCTO DIFERENTE AL FACTURADO',
);


/*██████████████████████████████████████████████ VARIABLES ███████████████████████████████████████████████████████*/




$conn= new con_sql();
$conn_ibs= new con_ibs('IBM-AGROCAMPO-P','ODBC','ODBC');

?>
<form id="frm-factura" name="frm-factura" action="#" method="POST">
    <input type="text" id="num_factura" name="num_factura" class="num_orden">
    <input type="submit" value="Buscar">
</form>

<?php





$buscar_factura = $_POST['num_factura'];
$numero_orden = mssql_fetch_array($conn->consultar("select distinct orden from facRegistroFactura where (Tipo+''+Factura = '$buscar_factura') or Factura = '$buscar_factura' "));
$bucar_orden_numero = $numero_orden[0];

$numero_consecutivo = mssql_fetch_array($conn->consultar("select max(valor) from API_CONFIGURACION where id = 18 and CAMPO='CONSEC_SANCION'"));
$numero_consecutivo = ($numero_consecutivo[0])+1;


/* validamos si ya existe y esta activa la novedad */
$ya_existe_novedad =  count(mssql_fetch_array($conn->consultar("SELECT * FROM SQLFACTURAS.DBO.API_SANCIONES_AGRO where NUMERO_FACT_SIA='$bucar_factura' or NUMERO_ORDE_IBS='$bucar_orden_numero' and SAN_ACTIVA = 1")));
if($ya_existe_novedad>1 ){
    echo "Ya existe una novedad cargada a la factura $bucar_factura";
    return;
}

/* validamos si ya esta quemada la factura para proceder con la novedad*/
$hay_dato =  count(mssql_fetch_array($conn->consultar("select distinct orden from facRegistroFactura where (Tipo+''+Factura = '$buscar_factura') or Factura = '$buscar_factura' ")));
if($hay_dato==1){
    echo "No hay datos para esta factura o no existe";
    return;
}



$datos_factura_ibs = ($conn_ibs->conectar("select * from AGR620CFAG.visventasorden1 where numero_orden='$bucar_orden_numero' limit 1"));
    while($datos_fac = odbc_fetch_array($datos_factura_ibs)){
            $orden_ibs= $datos_fac['NUMERO_ORDEN']; 
            $cod_vendedor= ($datos_fac['VENDEDOR']=='VEND999')?'RODRIGUEZJ':$datos_fac['VENDEDOR'];; 
            $nom_vendedor= $datos_fac['NOMBRE_VENDEDOR']; 


    
        echo "
        <form id=\"frm-sancion\" name =\"frm-sancion\" class=\"frm-sancion\" action=\"insert_data.php\" method=\"POST\">
        <center>
        <table>
        
            <tr>
                <td>
                <label>Consecutivo:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" value=\"$numero_consecutivo\" id=\"data_conse\" name=\"data_conse\" readonly > <br>
                </td>
            </tr>
            <tr>
                <td>
                <label>Fecha novedad:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" value=\"$fechaActualcom\" id=\"date_act\" name=\"date_act\" readonly> <br>
                </td>
            </tr>
            <tr>
                <td>
                <label>Orden:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" value=\"$orden_ibs\" id=\"num_ord_ibs\" name=\"num_ord_ibs\" readonly> <br>
                </td>
            </tr>
          
            <tr>
                <td>
                <label>Factura:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" value=\"$buscar_factura\" id=\"num_fac\" name=\"num_fac\" readonly> <br>
                </td>
            </tr>
           
            <tr>
                <td>
                <label>Vendedor:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" value=\"$cod_vendedor - $nom_vendedor\" id=\"dat_vende\" name=\"dat_vende\" readonly > <br>
                </td>
            </tr>
            
            <tr>
                <td>
                <label>Auxiliar:</label>
                </td>
                
                <td></td>
                
                <td>
                <input type=\"text\" placeholder=\"Nombre de Auxiliar \" id=\"dat_aux\" name=\"dat_aux\" > <br>
                </td>
            </tr>
            
            
            <tr>
                <td>
                <label>Seguridad:</label>
                </td>
                
                <td></td>
                
                <td>
                    <input list=\"text\" name=\"per_seg\" id=\"per_seg\" value=\"$usuario_seg_log\" readonly /></label>
                    ";
                    
                    echo "


                    </td>
            </tr>
        
            <tr>
                    <td>
                    <label>Novedad:</label>
                    </td>
                    
                    <td></td>
                    
                    <td>
                    <select id=\"dat_novedad\" name=\"dat_novedad\">
        ";
        
            foreach( $listado_novedad  as $nov){
                echo "<option value=\"$nov\"> $nov </option>";
            }
        echo "
                    </td>
            </tr>
        
            </select>
            
            <tr>
                <td>
                    <label> Comentarios</label>
                </td>
                <td></td>
                <td>
                    <div class=\"form-group\">
                        <textarea class=\"form-control\" id=\"cometario\" name=\"cometario\" rows=\"3\" required></textarea>
                    </div>

                </td>
            </tr>

            <tr>
                <td>
                    <input type=\"submit\" value=\"Registrar\" id=\"btn_san\" name=\"btn_san\">
                </td>
            </tr>
        </table>
        </form>
        </center>
        ";
    }
    
?>
</div>
</body>
</html>