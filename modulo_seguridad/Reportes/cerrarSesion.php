<?php
if(session_start()===FALSE){
        session_start();
    }
$_SESSION['usuARio']='';
$_SESSION['acc']='0';
session_destroy();
header("location:user_conect.php");
//header("location:user_conect.php?a=0");

?>