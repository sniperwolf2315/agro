<?php
session_start();



$items_originales       = ($_SESSION['items_originales']);
$item_validar           = convert_array($_GET['valores_item']);
$item_validar_new       = [];
$items_faltantes        = [];
$solo_items_originales  = [];
$arr_sql_final_cab      = [];
$arr_sql_final_itm      = [];
$array_datosvalidador   = $_SESSION['datos_validador'];
$continua               = 0 ;
$cantidad               = 0;
$diponible              = 0;
$faltantes              = 0;
/* SOLO TOMAMOS LOS ITEMS INGRESADOS */
foreach($item_validar as $key=>$value){
    if (($key % 2) == 0) {/* solo se validaran los codigos  */
        array_push($item_validar_new ,$value);
    }
}

/* SOLO TOMAMOS LOS ITEMS ORIGINALES */
foreach($items_originales as $key=>$value){
        // array_push($solo_items_originales ,$value[0]);
        array_push($solo_items_originales ,$value['item']);
}

$total_items_origins = count($solo_items_originales);
$total_items_new     = count($item_validar_new);
 

echo"
<br>
Total items orden    : $total_items_origins <br>
Total items validados: $total_items_new 
<br>
<br>
<hr>
<br>
";
foreach($solo_items_originales as $itm_origins){/* RECOOREMOS EL ARRAY ORIGINAL PARA LUEGO COMPARAR CON EL DE ALISTAMIETNO */
    foreach($item_validar_new as $itm_validado){/* RECOOREMOS EL ARRAY DE ALISTAMIENTO PARA  COMPARAR CON EL ORIGINAL */
        if(in_array(trim($itm_origins), $item_validar_new)){/* SI EXISTE NO NO HACE NADA */
        }else{/* SI NO EXISTE LO AGREGA A LA LISTA DE FALTANTES */
            array_push($items_faltantes,$itm_origins);
        }
    }
}

/* ELIMINAMOS LOS DUPLICADOS */
$items_faltantes = array_unique($items_faltantes );

/*

CREAR INSERT 
*/
echo "Items Originales : ".implode(',',$solo_items_originales).'<br>';
echo "Items Validados  : ".implode(',',$item_validar_new).'<br>';
echo "Items Faltantes  : ".implode(',',$items_faltantes). '<br>';

/* clave valor items ingresados  */
// $k_v_items_validados = convert_array_2($_GET['valores_item']);
$k_v_items_validados = json_decode($_GET['valores_item']);

foreach($items_originales as $a1){
$a_item  = trim($a1['item']);
$a_cant  = trim($a1['cantidad']);
// echo "a ".$a1['cantidad']."<br>";

    foreach($k_v_items_validados as $a2){
        $b_item  = trim($a2->item);
        $b_cant  = trim($a2->cantidad);
        // echo "b ".$a2->item.' '.$a2->cantidad.'<br>';
        if($a_item == $b_item && intval($a_cant) == intval($b_cant)){
            // echo "<br> igual en orden igual en lista  <br>";
            $continua = 1;

            $cantidad  = $a_cant; 
            $diponible = $b_cant; 
            $faltantes = 0; 
        }
        else if($a_item == $b_item && intval($a_cant) > intval($b_cant)){
            $continua = 1;
            $cantidad  = $a_cant; 
            $diponible = $b_cant; 
            $faltantes = ($a_cant - $b_cant); 
        }
        else if($a_item == $b_item && intval($a_cant) < intval($b_cant)){
            echo "<br>la cantidad ingresada del item $b_item es mayor que la cantidad de la orden <br>";
            $continua = 0;
            // echo "<br> mayor en orden menor en lista <br>";
         }
    }
}
    
if ($continua==0){
    echo 'NO puede continuar';
    return;
}


// $arr_sql_final_cab
// $arr_sql_final_itm



// echo " <br><br> ORI ";
// var_export($items_originales);
// echo " <br><br> NEW ";
// var_export($item_validar_new);
// echo " <br><br> FAL ";
// var_export($items_faltantes);
// echo " <br><br> ";
// echo "<div id='ls_items' name='ls_items' class='ls_items'></div>";

/* HORA DE INICIO */
echo $_SESSION['hora_inicio_validacion']."<br>";
echo date('Y-m-d h:i:s');


echo "
<br>
<input type='button' value='Confirmar' onclick='parar();' >

";



?>

<?php
function convert_array($string){
    $origin = ['[',']','{','}',':','item','cantidad','"'];
    $replace = ['','','','','','','',''];
    $return_data = str_replace($origin,$replace,$string);
    $return_data = explode(',',$return_data);
    return $return_data;
}

function convert_array_2($string){
    $origin = ['[',']','{','}',':','item','cantidad','"'];
    $replace = ['','','',')','','','',''];
    $return_data = str_replace($origin,$replace,$string);
    $return_data = explode('),',$return_data);
    return $return_data;
    // return $string;
}

?>