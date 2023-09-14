<br>
<?php
require( '../../../services/rest_pibox_service.php' );/* IMPORTAMOS LA CLASE DE API_REST */
require( '../../../environments/production.php' );/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include( '../../../environments/develop.php' );/* IMPORTAMOS LAS VARIABLES DE API_REST  */
include( '../../../funciones.php' );

$end_point  = '/GetList';

$fechaactual = getdate();
$fecha =  $fechaactual[year]."/".($fechaactual[mon])."/". ($fechaactual[mday]);

$data       = ["FechaDesde"=>"$fecha","FechaHasta"=>"$fecha"];
$rs 	      = API_REST::GET_BODY_HEADER($PROD_URL_RAPIBOY.$end_point, $PROD_TOKEN_RAPIBOY,$data );
$array      = API_REST::JSON_TO_ARRAY( $rs );


echo "<br> PEDIDOS RAPIBOY <br>" ;
$groupkey='IdMotoboy';
$n_array = groupArray($array,$groupkey);


foreach ( $n_array as $arr ) {

    if($arr[IdMotoboy ] !=''){
      echo "<details><summary>Repartidor : ".$arr[IdMotoboy ]."</summary>";
      $nombre = '';
      foreach($arr[groupeddata] as $array_domi){
                      if($array_domi[EstadoNombre]!='Entregado' || $array_domi[EstadoNombre]!='Retirado en camino a destino'){
                          $CEDULA      = $array_domi[ DNI ]  ;
                          $nombre      = $array_domi[ Nombre ]  ;
                          $nombre      =(eliminar_duplicados($nombre));
                          $telefono_rep= $array_domi[ TelefonoRepartidor];
                          $telefono_rep= eliminar_duplicados($telefono_rep);
                          $fecha_act   = $array_domi[ UltimaActualizacion];
                          $fecha_act   = eliminar_duplicados($fecha_act);
                          $Placa       = $array_domi[ Patente ];
                          $Placa       = eliminar_duplicados($Placa);
                          $Placa       = ($Placa=='')?'SIN PLACA':$Placa ;
                          
                          $tracking_url       = $array_domi[ TrackingUrl ];

                          echo "📦".$array_domi[ ReferenciaExterna ]." <a href='$tracking_url' target='_blanck'>Seguimiento</a>   <br>";    
                          $ped .=$array_domi[ ReferenciaExterna ];
                          $estad='NO_ENTREGADO';
                        }else{
                        $estad='ENTREGADO';
                        $ped='';
                      }
                }

                if($ped!=''){

                  echo "
                        Cedula     : $CEDULA       <br>
                        Nombre     : $nombre       <br>
                        Placa      : $Placa        <br>
                        Telefono   : $telefono_rep <br>
                        Fecha      : $fecha_act    <br>
                      "; 
                }else{
                $arr[IdMotoboy ]='';
                }
                
              echo '
              </details><br>';
          }
    }

if (empty($n_array)){
    echo "
      <span>No tenemos pedidos por ahora.</span>
    ";
  }


?>