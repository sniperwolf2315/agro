<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISTA PEDIDOS PROVEEDORES</title>
    <link rel="stylesheet" href="../../../assets/css/side_bar.css">
    
<?php
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<?php
require( '../../../conection/conexion_sql.php' );
$perfil=$_GET['perf'];

?>

<body>
    <div id="sidebar" name="sidebar" class="sidebar">
        <div id="toggle_btn" name="toggle_btn" class="toggle_btn ">
            <span>&#9776;</span>
        </div>
        <ul class="nav">
            <li><img src="../../../assets/images/logo_agro.png" alt="logo_agrocampo" id="logo" name="logo" class="logo"></img> </li>
            <?php
        /*SE VALIDA QUE PERFIL CORRESPONDA AL REA
        * dom->DOMICILIOS
        * SEC->SEGURIDAD
        'Lista pedidos QUICK'   =>'pedidos_Q',
        */
        // <!-- SECCION DE DESPACHOS -->
        $lisa_menu=[
            'Lista pedidos PIBOX'   =>'pedidos',
            'Lista pedidos RAPIBOY' =>'pedidos_R',
            'Configuraciones'       =>'configuracion',
            'Informe mensual'       =>'informe_mensual',
            'Facturas despachadas'    =>'facturas_despachadas',
            'Cargue Dom Recaudo'    =>'ingreso_domiciliario_rec',
            '¡No lo encuentro!'     =>'rest_pibox_sql',
        ];
        $lista_seguridad_reporte=[
            "Ingresos agendados"=>"ing_seg",
            "Salida domiciliarios"=>"sal_dom",
            "Ingresos fallidos"=>"ing_fall"
        ];
        
        /** SE VALIDA SI EL PERFIL corresponda al del usuario visualizador */
        if($perfil=='dom'){
            echo"<li>
                    <a>Despachos</a>
                    <ul>";
                    foreach($lisa_menu as $lista=>$id){
                        echo "<li id="."$id"." name="."$id"." class="."$id"."><a>$lista</a></li>";
                    }

                echo "
                    <li>    
                    <a>Mas funciones</a>
                        <ul>
                            <li>
                            <a href="."javascript:popUp('crud_us.php')".">Actualiza datos</a>
                            </li>
                            <li>
                            <a href="."javascript:popUp('consulta_booking.php')".">Buscar Booking</a>
                            </li>
                        </ul>
                    </li>

                    <li>    
                    <a>Placas vehiculos</a>
                        <ul>
                            <li>
                            <a href="."javascript:popUp('../../mod_placas_empresa/index.php')".">Gestión Placas Domi</a>
                            </li>
                            
                        </ul>
                    </li>
                    </ul>    
                </li>
                ";

            }else if($perfil=='sec'){// <!-- SECCION DE SEGURIDAD -->
                echo "
                    <li>
                        <a>Seguridad</a>
                        <ul>
                ";

                foreach($lista_seguridad_reporte as $lista=>$id){
                    echo "<li id="."$id"." name="."$id"." class="."$id"."><a>$lista</a></li>";
                }
               
            }else if($perfil=='sadm'){

                echo"<li>
                <a>Despachos</a>
                <ul>";
                foreach($lisa_menu as $lista=>$id){
                    echo "<li id="."$id"." name="."$id"." class="."$id"."><a>$lista</a></li>";
                }
                echo "
                <li>
                <a>Seguridad</a>
                <ul>
                ";
                foreach($lista_seguridad_reporte as $lista=>$id){
                    echo "<li id="."$id"." name="."$id"." class="."$id"."><a>$lista</a></li>";
                }

                echo "
                </ul>    
                </li>
                ";
                echo"<a href="."javascript:popUp('configuracion.php')".">_</a>";  


            }else if ($perfil=='terc'){

                echo"<li>
                    <a>Despachos</a>
                    <ul>";

                echo "
                    <li>    
                    <a>Mas funciones</a>
                        <ul>
                            <li>
                            <a href="."javascript:popUp('crud_us.php')".">Actualiza datos</a>
                            </li>
                            <li>
                            <a href="."javascript:popUp('consulta_booking.php')".">Buscar Booking</a>
                            </li>
                            <li id="."rest_pibox_sql"." name="."rest_pibox_sql"." class="."rest_pibox_sql"."><a>¡No lo encuentro!'</a></li>
                        </ul>
                    </li>

                   
                    </ul>    
                </li>
                ";


            }    
            
            
            
            ?>
            </ul>
        </li>
    </ul>


    </div>
    <div id="content_ped" name="content_ped" class="content_ped">
    <div id="pedidos_all" name="pedidos_all" class="pedidos_all">
        <br>
        <span>
        <center>
            <h1>
                Agrocampo Integración Domicilios
            </h1>
        </center>    
        </span>

    </div>
    </div>
    <script src="../../../assets/js/side_bar.js" ></script>
    <script src="../../../assets/js/renderizado.js" ></script>
    <script src="../../../assets/js/funciones.js" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>


