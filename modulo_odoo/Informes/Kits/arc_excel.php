<?php

if($_FILES['file']['name'] != ''){
    $test = explode('.', $_FILES['file']['name']);
    $extension = end($test);    
    $name = rand(100,999).'.'.$extension;

    $location = '/var/www/html/modulo_odoo/Informes/Kits/archivos/'.$name;
    move_uploaded_file($_FILES['file']['tmp_name'], $location);
    
    echo "archivo";
    //echo '<img src="'.$location.'" height="100" width="100" />';
}
/*
$archivo="C:/xamp2/htdocs/InformesOdoo/Kits/".$_GET['f'];
$dir_subida = '/var/www/html/modulo_odoo/Informes/Kits/archivos/';
$fichero_subido = $dir_subida . basename($archivo);// basename($_FILES['fichero_usuario']['name']);
//if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
if (move_uploaded_file($archivo, $fichero_subido)) {
    echo "El archivo se subio bien.\n";
} else {
    echo "¡Falla de subida de archivo!\n";
}
//sleep(5);
   */         
   //$_FILES['file']['name']                               
/*$name = $_GET( 'obj2' );
$tmp_name = $_GET( $_FILES['file']['tmp_name'] );
if(isset($name))
{
    if(!empty($name))
    {
        $location = '/var/www/html/modulo_odoo/Informes/Kits/archivos/';
        //$location ='images/';
        if(move_uploaded_file($tmp_name, $location.$name))
        {
            echo "Uploaded!!";
        }
        else {
                echo "Please choose the file";
            }
    }                                   
}                    
  */                  
/*
foreach($_FILES['excel']['tmp_name'] as $key => $tmp_name){
    if($_FILES['excel']['name'][$key]){
        $filename=$_FILES['excel']['name'][$key];
        $temporal=$_FILES['excel']['tmp_name'][$key];
        $directorio = "archivos/";
        $not=$_FILES['excel']['name'][$key];
        echo "Dato origen".$not;
        if(!file_exists($directorio)){
            mkdir($directorio,0777);
        }
        $dir=opendir($directorio);
        $ruta=$directorio.'/'.$filename;
        
        if(move_uploaded_file($temporal, $ruta)){
            //echo "El archivo $filename se ha almacenado correctamente";
            $r=$r. "<script>alert('El archivo $filename se ha almacenado correctamente');</script>";
        }else{
            //echo "ha ocurrido un error";
            $r=$r. "<script>alert('ha ocurrido un error');</script>";
        }
        closedir($dir);
    }else{
        $r=$r. "error";
    }
}*/



echo $r;
?>