<!DOCTYPE html>
<html lang = 'en'>
<head>
<title>NUEVO SIA AGROCAMPO</title>
<meta charset = 'utf-8' />
<meta name = 'viewport' content = 'width=device-width, initial-scale=1, user-scalable=no' />
<link rel = 'stylesheet' href = './assets/css/main.css' />
<link rel = 'stylesheet' href = './assets/css/menu.css' />
</head>
<body class = 'homepage is-preload'>
<div id = 'page-wrapper'>
<div id = 'header-wrapper'>
<div class = 'container'>
<header id = 'header'>
<div class = 'inner'>
<h1><a href = 'index.php' id = 'logo'>AGROCAMPO</a></h1>
</div>
<div class = 'user_login'>
<label ><?= strtoupper( $_SESSION[ 'usuARioS' ] )?> </label>
<?php
session_start();
echo ( !isset( $_SESSION[ 'usuARioS' ] ) ) ?'':'<a href="salir.php" > (Cerrar Sesión) </a>';
?>
</div>
<nav id = 'nav'>
<ul>
</ul>
</nav>
</header>
</div>
</div>
</div>

<?php

if ( isset( $_SESSION[ 'usuARioS' ] ) ) {
    // include( 'index_nuevo_sia.php' );
    // include( './modules/mod_sql/usuario.php' );
    $usuario_log=strtoupper ($_SESSION[ 'usuARioS' ]);
    if(
        $usuario_log==='CIFUENTESE' ||
        $usuario_log==='VILLALOBOSC'||
        $usuario_log==='GOMEZD'
        ){
            /* SISTEMAS */
            $menu_areas=[
                "SISTEMAS-MODULOS"=>array(
                    'REPORTES'=>array( 
                        '../moduloI/pags/ventas_cuota_new.php'=>'REPORTE MES COMERCIAL NEW ',
                        '../moduloI/pags/ventas_area.php'=>'REPORTE MES COMERCIAL OLD',
                        './modules/mod_sanciones/descarga_sanciones/index.php'=>'DESACARGUE SANCIONES'
                    ),
                    'LISTAS'=>array( 
                        './modules/mod_ibs/usuario.php'=>'USUARIOS ACT IBS ',
                        './modules/mod_sql/usuario.php'=>'USUARIOS ACT SIA',
                        './modules/mod_pssql/usuario.php'=>'USUARIOS ACT ODOO',
                        './modules/mod_mysql/usuario.php'=>'USUARIOS ACT MYSQL'
                    ),
                    'INTEGRACIONES'=>array( 
                        './modules/mod_rest_clientes/domiciliario/ingreso_domiciliario.php'=>'PIBOX',
                        './modules/mod_rappi_integration_delta/rp_dta_r.php'=>'RAPI DELTA SERVICE',
                        '../modulo_magento/yatiIntegracion.php?AAMkAGE4ODJhY=YATjQ2LTg2YzItNGRiMy1hYjA3LTc5MzI4NzUxMGFjO&m=inv'=>'YATI SERVICE',
                    ),
                ),
                "GH-MODULOS"=>array(
                    'MENU'=>array( 
                        './modules/mod_ingreso_temporales/index-ingresos.php'=>'FORMULARIO DE INGRESO',
                        './modules/mod_ingreso_temporales/mod_carga.php?area=1002'=>'CARGUE DE INFORMACION'
                    ),
                ),
                "MERCADEO-MODULOS"=>array(
                    'MENU'=>array( 
                        './modules/mod_ingreso_temporales/index-ingresos.php'=>'FORMULARIO DE INGRESO',
                        './modules/mod_ingreso_temporales/mod_carga.php?area=1003'=>'CARGUE DE INFORMACION'
                    ),
                ),
                "AUDITORIA-MODULOS"=>array(
                    'MENU'=>array( 
                        './modules/mod_ingreso_temporales/mod_carga.php?area=1010'=>'REPORTE PERSONAL PROVISIONAL',
                        './modules/mod_sanciones/descarga_sanciones/index.php?area=1010'=>'DESACARGUE SANCIONES',
                        './modules/mod_rest_clientes/usuario/usuario_admin.php?perf=dom'=>'REPORTE QUEMADO FACTURAS'
                    ),
                ),
            ];    
        }else if($usuario_log=='MENDIETAL' || $usuario_log=='MARTINEZG' || $usuario_log=='REYESL'){
            /* GH */
            $menu_areas=[ 
                "GH-MODULOS"=>array(
                'MENU'=>array( 
                    './modules/mod_ingreso_temporales/index-ingresos.php'=>'FORMULARIO DE INGRESO',
                    './modules/mod_ingreso_temporales/mod_carga.php?area=1002'=>'CARGUE DE INFORMACION'
                ),
            ),
        ];
    }else if($usuario_log=='LLNOS'){
        /* MERCADEO */
        $menu_areas=[ 
            "MERCADEO-MODULOS"=>array(
                'MENU'=>array( 
                        './modules/mod_ingreso_temporales/index-ingresos.php'=>'FORMULARIO DE INGRESO',
                        './modules/mod_ingreso_temporales/mod_carga.php?area=1003'=>'CARGUE DE INFORMACION'
                    ),
                ),];
        }else if($usuario_log=='RODRIGUEZE' ||  $usuario_log=='RAMIREZS' || $usuario_log=='VILLAMILC'){
            /* MERCADEO */
            $menu_areas=[ 
                "AUDITORIA-MODULOS"=>array(
                    'MENU'=>array( 
                            './modules/mod_ingreso_temporales/index-ingresos.php'=>'FORMULARIO DE INGRESO',
                            './modules/mod_ingreso_temporales/mod_carga.php?area=1010'=>'CARGUE DE INFORMACION',
                            './modules/mod_sanciones/descarga_sanciones/index.php?area=1010'=>'DESACARGUE SANCIONES',
                        ),
                    ),];
            }
        else{
            echo "<center><h1>NO TIENE PERMISOS CONTACTAR A SISTEMAS</h1></center>";
            return;
        }


    


    echo "<div class=".'menu'.' id='.'menu'.' name='.'menu'."  >";
    echo "<ul class='nav'>";

    
    foreach($menu_areas as $area=>$grupos ){
        
        echo "<li><a> $area </a> </li>";

        foreach($grupos as $subgrupo => $nopgrp){
            echo "
            <li>
                <a> $subgrupo </a>
                    <ul>
            ";
            foreach($nopgrp as $ruta=> $nombre){
                    echo "<li>
                            <a href='$ruta' target ='_blank' noopener noreferrer>$nombre </a>
                        </li>";
            }
            echo"
                    </ul>
            </li>";
        }
        echo "<br><br>";
    }

    echo "</ul>";
    echo "</div>";
} else {
    echo '<center> 
            <h1> NO HAZ INICADO SESION</h1> 
            <br>
            <a class="user_login" onclick="mostrar_login()" >Iniciar</a>
            </center> ';
    
}

?>

</body>
<footer>
</footer>
<script type = 'text/javascript' src = './assets/js/login.js '></script>
<script type = 'text/javascript' src = './assets/js/generals.js '></script>
<script src = '//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</html>

