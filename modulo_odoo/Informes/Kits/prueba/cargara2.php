<?php
echo "aqui1";
foreach($_FILES['excel']['tmp_name'] as $key => $tmp_name){
    echo "aqui2";
    if($_FILES['excel']['name'][$key]){
        $filename=$_FILES['excel']['name'][$key];
        $temporal=$_FILES['excel']['tmp_name'][$key];
        $directorio = "archivos/";
        if(!file_exists($directorio)){
            mkdir($directorio,0777);
        }
        $dir=opendir($directorio);
        $ruta=$directorio.'/'.$filename;
        
        if(move_uploaded_file($temporal, $ruta)){
            echo "El archivo $filename se ha almacenado correctamente";
        }else{
            echo "ha ocurrido un error";
        }
        closedir($dir);
    }else{
        echo "error";
    }
}
echo "errorjh";
?>