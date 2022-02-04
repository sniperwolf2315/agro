<? session_start();

//MSSQL

    $cLink = mssql_connect('192.168.6.15', 'sa', '%19Sis60Tem@s17') or die(mssql_get_last_message()); //AZURE10.10.0.5
    mssql_select_db('SqlIntegrator',$cLink);


//SEGURIDAD DE $_post
foreach ($_POST as $a=>$b) $_POST[$a] = trim(preg_replace('/\s+/', ' ', preg_replace('/\'/', '´', preg_replace('/\"/', '¨', $b))));
if($todoamayusculas =='SI'){
foreach ($_POST as $a=>$b) $_POST[$a]=mb_strtoupper($b,'UTF-8');
}		
?>
