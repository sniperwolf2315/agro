<!-- ES MODULO ES LA PRIMERA VERSION DE PARA EL CARGUE DE LOS SABATINOS -->
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

  <div class="d-flex flex-column flex-shrink-0 p-3 bg-light disabled" style="width: 180px;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none  "disabled>
      <svg class="bi pe-none me-2" width="30" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">Agrocampo</span>
    </a>
  
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

    <?php
      $lista_menu = [
        'carga_data'=>'Carga',
        'con_data'=>'Consulta',
        'up_data'=>'Actualizar',
      ];
    
      foreach( $lista_menu as $key => $value ){

        echo '<li id="'.$key.'" name="'.$key.'" class="'.$key.'" >';  
        if($key=='up_data'){
          echo "<a href="."javascript:popUp('update_temporales.php')"." class='nav-link link-dark' ><span title='Ojo se limpia toda la tabla'></span> ";
        } 
        else{
          echo '<a href="#" class="nav-link link-dark" >';  
        }
          echo '<svg class="bi pe-none me-2" width="10" height="16"></svg>';  
          echo "$value <br>";
          echo '</a></li></hr>';
      }
    
    ?>

      
        <!-- <li id="carga_data" name="carga_data" class="carga_data" >
          <a href="#" class="nav-link link-dark" >
            <svg class="bi pe-none me-2" width="10" height="16"></svg>
            Carga
          </a>
        </li>
      <hr>
        <li id="con_data" name="con_data" class="con_data">
          <a href="#" class="nav-link link-dark" >
            <svg class="bi pe-none me-2" width="10" height="16"></svg>
            Consulta
          </a>
        </li>
        <hr>
        <li id="up_data" name="up_data" class="up_data">
          <a href="#" class="nav-link link-dark" >
            <svg class="bi pe-none me-2" width="10" height="16"></svg>
            Actualiza
          </a>
        </li>
        <hr> -->
     
    </ul>

  </div>
  <div class="b-example-divider b-example-vr"></div>
  <div class="b-example-divider b-example-vr"></div>
  <div id="pedidos_all" name="pedidos_all" class="pedidos_all justify-align-center text-align-center">
      <span>
          AGROCAMPO
       </span>
    </div>
</main>
<!-- <a href="usuario_admin.php?perf=sadm"><span class="btn btn-primary">⏪</span></a> -->
<script src='../../assets/js/renderizado.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
