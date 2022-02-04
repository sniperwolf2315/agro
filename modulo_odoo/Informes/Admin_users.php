<?php
    $pasa=false;
    //USUARIOS ADMINISTRADORES:
    if(
    ($_SESSION['usuARio'] == 'CARDOZOJ')||
    ($_SESSION['usuARio'] == 'LOPEZJ')||
    ($_SESSION['usuARio'] == 'GOMEZD')||
    ($_SESSION['usuARio'] == 'VILLALOBOSC')||
    ($_SESSION['usuARio'] == 'JIMENEZR')||
    ($_SESSION['usuARio'] == 'TORRESC')
    ){
        $pasa=true;    
    }
    
?>