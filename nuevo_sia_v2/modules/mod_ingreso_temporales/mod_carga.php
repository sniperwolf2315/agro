<!DOCTYPE html>
<html>
<head>
<title>Menu Temporales Agrocampo</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src='../../assets/js/funciones.js'></script>


</head>
<body>



<main class="d-flex flex-nowrap " style="font-size:2vh; height:900px;">
  <div class="b-example-divider b-example-vr"></div>
  
<?php
if ( !isset( $_SESSION[ 'usuARioS' ] ) ) {
  echo "<div class='contaier'> <center></center> No puede continuar no ha iniciado sesion vaya a : <a href='../../index.php'> AGROCAMPO</a></center> </div>";
  return; 
  exit;
}
?>
  <div class="d-flex flex-column flex-shrink-0 p-3 bg-light disabled" style="width: 200px; overflow: auto; resize: horizontal;">


    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none  "disabled>
      <svg class="bi pe-none me-2" width="30" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">
        AGROCAMPO
    </span>
    </a>
  
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

    <?php

    $menu_ver = $_GET['area'];

    // seccion validar que opciones podemos ver
    if($menu_ver=='1000'){
      echo "GRUPO SISTEMAS";
      $lista_menu = [
        'carga_data'  =>'Carga',
        'con_data'    =>'Consulta',
        'up_data'     =>'Actualizar',
        'del_data'    =>'Borrar',
        'repro_data'  =>'Reprogramar',
        'consulta_retardos'  =>'Retardos planta',
      ];
    }else if($menu_ver=='1001'){
      echo "Grupo METODOS";
      $lista_menu = [
        'carga_data' =>'Carga',
        'con_data'   =>'Consulta',
        'del_data'   =>'Borrar',
      ];
    }  
    else if($menu_ver=='1002'){
      echo "Grupo GH";
      $lista_menu = [
        'carga_data' =>'Carga',
        'con_data'   =>'Consulta',
        'up_data'    =>'Actualizar',
        'del_data'   =>'Borrar',
        'repro_data' =>'Reprogramar',
        'consulta_retardos'  =>'Retardos planta',
      ];
    }else if($menu_ver=='1003'){
      echo "Grupo MERCADEO";
      $lista_menu = [
        'carga_data' =>'Carga',
        'con_data'   =>'Consulta',
        'up_data'    =>'Actualizar',
        'del_data'   =>'Borrar',
        'repro_data' =>'Reprogramar',
      ];
    }else if($menu_ver=='1004'){
      echo "Grupo ALMACEN";
      $lista_menu = [
        'carga_data' =>'Carga',
        'del_data'   =>'Borrar',
        'repro_data' =>'Reprogramar',
      ];
    }else if($menu_ver=='1005'){
      echo "Grupo Seguridad";
      $lista_menu = [
        'carga_data' =>'Carga',
        'con_data'   =>'Consulta',
        'con_totem'  =>'Consulta_tot',
      ];
    }else if($menu_ver=='1010'){
      echo "Grupo AUDITORIA";
      $lista_menu = [
        'con_data'   =>'Consulta',
      ];
    }
    
    else{
      $lista_menu = ['carga_data_area'=>'Carga'];
    }

      foreach( $lista_menu as $key => $value ){

        echo '<li id="'.$key.'" name="'.$key.'" class="'.$key.'" >';  
        if($key=='up_data'){
          echo "<a href="."javascript:popUp('update_temporales.php')"." class='nav-link link-dark' ><span ></span> ";
        
        }else if($key=='del_data'){
          echo "<a href="."javascript:popUp('delete_temporales.php')"." class='nav-link link-dark' ><span></span> ";
        
        }else if($key=='repro_data'){
          echo "<a href="."javascript:popUp('reprogramar_visitantes.php?area=$menu_ver')"." class='nav-link link-dark' ><span></span> ";
        
        }else if($key=='con_totem'){
          echo "<a href="."javascript:popUp('../mod_rest_clientes/usuario/usuario_admin.php?perf=sec')"." class='nav-link link-dark' ><span></span> ";
        
        }
        else{
          echo '<a href="#" class="nav-link link-dark" >';  
        }
          echo '<svg class="bi pe-none me-2" width="10" height="16"></svg>';  
          echo "$value <br>";
          echo '</a></li></hr>';
      }
    
    ?>
     
    </ul>
      <span>
        <a href="../../salir.php">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="34" height="34" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
            <path d="M7 12h14l-3 -3m0 6l3 -3" />
          </svg>
          Salir
        
        </a>
      </span>
  </div>
  <div class="b-example-divider b-example-vr"></div>
  <div class="b-example-divider b-example-vr"></div>
  
  <div id="pedidos_all" name="pedidos_all" class="container pedidos_all justify-align-center text-align-center">
    <center>
      <span>
          <img src="../../assets/images/logo_agro.png">
        </span>
      </center>
    </div>
</main>
<!-- <a href="usuario_admin.php?perf=sadm"><span class="btn btn-primary">⏪</span></a> -->
<script src='../../assets/js/renderizado.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
