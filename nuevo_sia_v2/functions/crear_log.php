<?php
// echo $log_filename = $_SERVER['DOCUMENT_ROOT']."/nuevo_sia_v2/log";
function crear_log($log_msg,$ruta='') {
    $log_filename = $_SERVER['DOCUMENT_ROOT']."/nuevo_sia_v2/log";
    if (!file_exists($log_filename))
    {
        mkdir($log_filename, 0777, true);
    }
    if($ruta==''){
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    }else{
        
        $log_file_data = $ruta.'log_' . date('d-M-Y') . '.log';
    }
    echo "$log_file_data";

    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}

// crear_log('log to file');
?>