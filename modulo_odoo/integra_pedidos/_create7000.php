<?
/**
$expiry_date = date("Y-m-d 23:59:59", strtotime("$hoy + 5 day") );
$datosCLI['name'] = $nom ;
$datosCLI['primer_nombre'] = $nom1 ;
$datosCLI['primer_apellido'] = $nom2 ;
$datosCLI['email'] = $email ;
$datosCLI['type_customer'] = 2;
$datosCLI['phone'] = $cel ;
$datosCLI['ref'] = $cc ;
$datosCLI['ref_type'] = $ref_type ;
$datosCLI['street'] = $dir_fac ;

$datosCONT['phone'] = $cel_ship ;
$datosCONT['street'] = $dir_ship ;

// lineas todas de una sola
$lines[0] = array(0,0, array('product_id'=> 83555,'name'=>'test','product_uom_qty' => 10));
$lines[1] = array(0,0, array('product_id'=> 85555,'name'=>'test','product_uom_qty' => 55));
//lineas una a una

$lines[0] = array('order_id' => '', 'product_id'=> 83555,'name'=>'test','product_uom_qty' => 100);  
$lines[1] = array('order_id' => '', 'product_id'=> 85555,'name'=>'test','product_uom_qty' => 555);
**/

//error_reporting(E_ALL); 

$url = 'http://192.168.6.55:8069'; //.13
$db = 'agrocampo'; //pruebas_tecnocalidadA
$username = 'admin'; //proyectosagro@agrocampo.com.co
$password = 'nickelcat11'; //tecnoavancys

$url = 'http://181.143.148.61:7000'; //.13
$db = 'sev_agrocampo_entrega'; //pruebas_tecnocalidadA
$username = 'proyectosagro@agrocampo.com.co'; //proyectosagro@agrocampo.com.co
$password = '1234'; //tecnoavancys

$url = 'http://181.143.148.61:7000'; //.13
$db = 'sev_agrocampo_entrega'; //pruebas_tecnocalidadA
$username = 'julian.sierra@agrocampo.com.co'; //proyectosagro@agrocampo.com.co
$password = '1234'; //tecnoavancys

$error = '';
$exito = '';
$msjLINE = array();


require_once('ripcord/ripcord.php');
$common = ripcord::client($url.'/xmlrpc/2/common');
try{
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$models->execute_kw($db, $uid, $password,
    'res.partner', 'check_access_rights',
    array('read'), array('raise_exception' => false));
}catch(Exception $e){
echo "Error WS: $e";
}
//busca por cedula
if($models){    
$ids = $models->execute_kw($db, $uid, $password,
    'res.partner', 'search'
    , array(array(array('ref', '=', $datosCLI['ref'])
                     ))
    , array('limit'=>10));
    
$partners = $models->execute_kw($db, $uid, $password,
    'res.partner', 'read',
    array($ids),
    array('fields'=>array('name', 'ref', 'street', 'comment')));
}
//error buscando x cedula

if($partners){ //print_r($partners); die;
  $crea_cliente = 'NO';
  $part_id = $partners[0]['id'];
  $contact_id = $part_id;
  if($partners[0]['street'] != $datosCLI['street'] ){
    try{
    $comment = $partners[0]['comment']."
Integracion P.Web actualiza dir $hoy, dir antigua: ".$partners[0]['street'];
    $dir = $models->execute_kw($db, $uid, $password, 'res.partner', 'write',
    array(array($part_id), array( 'street'=> $datosCLI['street']
                                , 'state_id'=> $datosCLI['state_id']
                                , 'city_id'=> $datosCLI['city_id']
                                , 'comment' => $comment)));
    $partners[0]['street'] = $datosCLI['street']; 
    }catch(Exception $e){
    $e -> getMessage();    
    $error .= "Error actualizando street Facturacion res.partner
    "; //.print_r($id);
    }
    
   }
  $ship = $partners[0]['street'];
  if($datosCONT['street'] == $ship){
    $contact_id = $part_id;  
    }else{
    if($models){
      try{
      $ids = $models->execute_kw($db, $uid, $password,
      'res.partner', 'search'
      , array(array( array('parent_id', '=', $part_id)
                  ,array('street', '=', $datosCONT['street']) 
                     ))
      , array('limit'=>10));
      $contact_id = $ids[0];
      }catch(Exception $e){
      $error .= "Error buscando dir de contacto/ no se crea contacto
      ";
      }
    }
    if(count($ids) == 0){
      $crea_contacto ='SI';
      }else{
      $contact_id = $ids[0]; 
      }
      
    }
  }else{
  $crea_cliente = 'SI';
    if($datosCLI['street'] != $datosCONT['street']){
    $crea_contacto = 'SI';
    }
  };
// sil a cedula no existe la crea              
if($crea_cliente =='SI'){
    try{
      if($models){
      $part_id = $models->execute_kw($db, $uid, $password
        , 'res.partner', 'create'
        , array($datosCLI)
        );
      }   
    $contact_id = $part_id;      
    }catch(Exception $e){
      $e -> getMessage();    
      $error .= "Error crea res.partner $idSTR
      "; //.print_r($id);
    
    }      
  }
  
//si el destino es direrente

if($crea_contacto =='SI'){
  $datosCONT['parent_id'] = $part_id;
  $datosCONT['commercial_partner_id'] = $part_id;
  $datosCONT['display_name'] = $datosCONT['name']."(Contacto: $datosCLI[name])";
  $datosCONT['ref'] .= 'C';
  if($datosCONT['name'] == $datosCLI['name']){ 
    $datosCONT['name'].= "(dir alterna)";
  }else{
    $datosCONT['name'].= "(contacto)";
  }
   try{
      if($models){
      $contact_id = $models->execute_kw($db, $uid, $password
        , 'res.partner', 'create'
        , array($datosCONT)
        );
      }   
    }catch(Exception $e){
      $e -> getMessage();    
      $error .= "Error crea contacto res.partner $contactidSTR
      "; //.print_r($id);
      
    }
         
  }


/** version que guarda todas las lineas de una
$order_vals = array(array(
                    'partner_id' => $part_id
                   ,'partner_shipping_id' => $contact_id
                   ,'expiry_date' => $expiry_date
                   ,'quotation_type_id' => 16
                   ,'order_line'=> $lines
                   )); //'order_line'=> array(array(0, 0, $line_vals))
$ov = $models->execute_kw($db, $uid, $password
        , 'sale.order', 'create'
        , $order_vals
        );
  if(is_array($ov)){
    echo "<br><br>error crea OV <br>".print_r($ov);
    }else{
    echo "<br><br><br><br>se guardo bien el id $ov";
    }                    
                     
**/
//version que guarda una a una
$datosOV['partner_id'] = $part_id;
$datosOV['partner_shipping_id'] = $contact_id;
$order_vals = array($datosOV); //'order_line'=> array(array(0, 0, $line_vals))
//print_r($datosOV);die;
try{
  if($models){
  $ov = $models->execute_kw($db, $uid, $password
        , 'sale.order', 'create'
        , array($datosOV)
        );
  $newOv = $models->execute_kw($db, $uid, $password,
    'sale.order', 'read', array(array($ov)),
    array('fields'=>array('name')));
    $exito = $newOv[0][name];
    if($exito ==''){
       $exito = 'error'; 
       $lines = array();
       $error = '$ov ....'.implode("-->>",$ov); 
       }    
  }                         
  foreach($lines AS $valores){
    $valores['order_id'] = $ov; 
    try{
      if($models){
      $ov_lines = $models->execute_kw($db, $uid, $password
        , 'sale.order.line', 'create'
        , array($valores)
        );
      }  
    }catch(Exception $e){
    $e -> getMessage();
    $ov_lines = array('Causa' => $e);    
    }

    $product_id = $valores['InfoAdd'];    
    if(is_array($ov_lines)){
        foreach($ov_lines AS $k => $v){ $ov_linesSTR .= " $k -> $v ,";}
        if($ov_lines['faultCode'] == 2 ){ $ov_linesSTR = "No hay codigo en ODOO"; }
        $msjLINE["$product_id"] = "error: $ov_linesSTR"; //.print_r($id);
      }else{
        $msjLINE["$product_id"] = "ok";
      }
  }            
}catch(Exception $e){
    $e -> getMessage();    
    $error .= "
    error crea OV $e
    "; //.print_r($id);
    $exito = 'error';
}
	
	


/**

             , array('notify_email'=> "linodmv@hotmail.com")
             , array('property_account_payable'=> "22050505")
             , array('property_account_receivable' => "13050501")
               , array('primer_nombre' => 'Linux')
               , array('primer_apellido' => 'Oyuelux')
               , array('ref'=> '82390515')
               , array('ref_type'=> '3')
               , array('customer'=> false)
               , array('phone'=> '321 2047952')
               , array('email'=> 'linodmv@hotmail.com')
               , array('country_id' => '50')
               , array('state_id' => '87')
               , array('city_id' => '1270')
               , array('street' => 'car 2 # 4 sur00'
               
**/
?>
  
