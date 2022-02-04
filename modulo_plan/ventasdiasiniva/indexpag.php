<?php
    if(session_start()===FALSE){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>SOPORTE TECNOLOGICO COLOMBIA</title>
    <meta charset="utf-8" />
    <!--materizlize-->
    <link href="css/materialize.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    <style media="screen">
      .sidebar {
        height: 80vh;
      }
      .titulo1 {
        color:  #FFFFFF;
        font-size: 2.3em;
      }
      .titulo2 {
        color:  #FF9800;
        font-size: 1.3em;
      }
      .titulo3 {
        color:  #000000;
        font-size: 1.3em;
        font-weight: 600;
      }
      .titulo4 {
        color:  #000000;
        font-size: 0.5em;
        font-weight: 300;
      }
      p {
        text-decoration: !important;
            box-shadow: inset 3px 3px 3px rgba(255,255,255,.7), inset 2px 2px 3px rgba(0,0,0,.1), 2px 2px 3px rgba(0,0,0,.1);
          -moz-border-radius:8px;
          -webkit-border-radius:8px; 
          -o-border-radius:8px;
          -ms-border-radius:8px;
          color: #424242;
      }
      .bordes {
           box-shadow: inset 3px 3px 3px rgba(255,255,255,.7), inset 2px 2px 3px rgba(0,0,0,.1), 2px 2px 3px rgba(0,0,0,.1);
          -moz-border-radius:8px;
          -webkit-border-radius:8px; 
          -o-border-radius:8px;
          -ms-border-radius:8px;
      }
      h2 {
        color: #FFFFFF;
      }
      h1 {
        vertical-align: top;
      }
      body {
        display: block;
        min-height: 200vh;
        flex-direction: column;
      }
    
      main {
        flex: 1 0 auto;
      }
    </style>
    </head>
    <!--netecolsoft-->
    <body>
    <!--<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--contenido-->
    <div class="row">
      <!--menu izq-->
      <div class="col s12 m12 l12 xl12 card-panel orange accent-2">
        <p><h1>&nbsp; <img class="responsive-img circle responsive-img" src="images/img5.png" width="160px;" />
       NETCOLSOFTEC</h1></p>
    
        <nav>
        <div class="nav-wrapper teal lighten-2 white-text bordes">
          <a href="#" class="brand-logo">&nbsp;Soluciones Tecnol&oacute;gicas</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="sass.html">Empresa</a></li>
            <li><a href="badges.html">Quienes somos</a></li>
            <li><a href="collapsible.html">Contacto</a></li>
          </ul>
        </div>
      </nav>
  
       </div>
     
    </div>
    
  
    
    <div class="row">
      <!--menu izq-->
      <div class="col s6 m5 l3 xl1 card ">
        <div class="container">
          <h1 class="flow-text">&nbsp;<img src="images/img5.png" width="40px;" />&nbsp;SERVICIOS</h1>
          <hr />
          
            <p class="flow-text orange accent-2">&nbsp;<img src="images/img2.png" width="20px;" />&nbsp;Mantenimiento</p>
          
            <p class="flow-text orange accent-2">&nbsp;<img src="images/img2.png" width="20px;" />&nbsp;Soporte Remoto</p>
         
        </div>
        
    <!--formulario-->
     
     <div class="col s12">
        <p>Cuentanos que necesitas?</p>
        <div class="row">
        
            <div class="input-field col s12">
               <i class="material-icons prefix">account_circle</i>
                <input id="Nom" placeholder="Nombre:" type="text" class="validate" />
                <label for="Nom"></label>
            </div>
            
            <div class="input-field col s12">
               <i class="material-icons prefix">phone</i>
                <input id="Tel" placeholder="Tel&eacute;fono:" type="text" class="validate" />
                <label for="Tel"></label>
            </div>
            
            <div class="input-field col s12">
               <i class="material-icons prefix">email</i>
                <input id="email" placeholder="Email:" type="text" class="validate" />
                <label for="email" data-error="wrong" data-success="right"></label>
            </div>
            
            
            <div class="input-field col s12">
                <textarea id="msg" placeholder="Mensaje:" class="materialize-textarea"></textarea>
                <label for="msg"></label>
            </div>
            
            <a class="waves-efect waves-light btn">Enviar</a>
    
        </div>
     </div>
    
        
      </div>
      <!--contenido derecho-->
      <div class="col s6 m7 l9 xl11">
        <div class="container">
          <div class="card-panel teal lighten-2 white-text">
            <h1>This is the main website</h1>
            <p class="white-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
          
          <div class="divider"></div>
          
          <div class="card-panel">
            <h3>Some more content</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ante enim, sollicitudin non tristique ut, iaculis in eros. Donec et purus eget tellus suscipit sollicitudin. Suspendisse erat turpis, faucibus ut blandit non, bibendum non tortor. Nullam et neque sed felis facilisis finibus. Nulla dictum elit enim, in finibus dolor ultrices id. Proin suscipit ipsum imperdiet dui hendrerit tempus. Donec quis aliquam velit. In viverra enim orci, nec tristique mi mollis id. Etiam a luctus eros. Duis convallis sem arcu, quis posuere tellus accumsan vel. Nunc augue nunc, tempor vel ornare a, congue ut nibh. Donec viverra arcu dui, eu rutrum ipsum elementum at. Proin ac quam ac est tincidunt lobortis vitae quis risus. <br><br>
                Donec id mollis erat. Proin porttitor tincidunt dui, ut luctus turpis lacinia a. Donec in maximus ligula, sit amet elementum erat. Curabitur rhoncus eleifend euismod. In a fringilla tellus, sed placerat felis. Pellentesque dictum risus nibh, vel sollicitudin eros facilisis nec. Proin sed auctor est. Vestibulum iaculis, eros ac sagittis sagittis, dui magna tempor arcu, in imperdiet libero neque ut odio.</p>
          </div>
        </div>
     </div>
     
     
     
  
</div>

<!--footer-->
        <footer class="page-footer  teal lighten-2">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>

    </body>
</html>