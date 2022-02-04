<?php
echo "bienvenidos";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>GMaps.js &mdash; Geolocation</title>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="js/gmaps.js"></script>
  
  <style type="text/css">
  /*#map{
  display: block;
  width: 100%;
  height: 600px;
  margin: 0 auto;
  -moz-box-shadow: 0px 5px 20px #ccc;
  -webkit-box-shadow: 0px 5px 20px #ccc;
  box-shadow: 0px 5px 20px #ccc;
}*/
  </style>
  <script type="text/javascript">
    var map, lat, lng;
    $(document).ready(function(){
      //creamos el mapa
      var map = new GMaps({
        el: '#map',
        lat: 0,
        lng: 0
      });
      // Creamos la geolocalización
      GMaps.geolocate({
        success: function(position){
          lat = position.coords.latitude;  
          lng = position.coords.longitude;
          alert("Latitud:" + lat + " Longitud: " + lng);
          return false;
          //Definimos la vista del mapa sobre las coordenadas obtenidas
          //map.setCenter(lat, lng);
          //Añadimos un marcador
          //map.addMarker({ lat: lat, lng: lng});  
        },
        error: function(error){
          alert('Geolocation failed: '+error.message);
        },
        not_supported: function(){
          alert("Your browser does not support geolocation");
        }
      });
    });


  </script>
</head>
<body>
  <h1>GMaps.js &mdash; Geolocation</h1>
  <div id="map"></div>
  
</body>
</html>