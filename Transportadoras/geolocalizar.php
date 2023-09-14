<html>
<head>
	<title>geolocation with Google Maps</title>
	<meta name = "viewport" content = "width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />		

	<style>
		body {font-family: Helvetica;font-size:11pt;padding:0px;margin:0px}
		#title {background-color:#e22640;padding:5px;}
		#current {font-size:10pt;padding:5px;}	
	</style>
	</head>
    <!--initialiseMap();-->
	<body onload="initialise()">
		<div id="current">Initializing...</div>
		<div id="map_canvas" style="width:320px; height:350px"></div>
        <div id="formu">
         
         </div>
         <div id='box'></div>
		<script src="js/geoPosition.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

		<script>
        
		/*function initialiseMap()
		{
		    var myOptions = {
			      zoom: 4,
			      mapTypeControl: true,
			      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			      navigationControl: true,
			      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			      mapTypeId: google.maps.MapTypeId.ROADMAP      
			    }	
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		}*/
		function initialise()
		{
			if(geoPosition.init())
			{
				document.getElementById('current').innerHTML="Receiving...";
				geoPosition.getCurrentPosition(showPosition,function(){document.getElementById('current').innerHTML="Couldn't get location"},{enableHighAccuracy:true});
			}
			else
			{
				document.getElementById('current').innerHTML="Functionality not available";
			}
		}
        
        function GuardarCoordenada(latit, longit) {
                    document.body.style.cursor = 'wait';
                    // Obtener la instancia del objeto XMLHttpRequest
                    if(latit=='' || latit==null){
                        latit=0;
                    }
                    if(longit=='' || longit==null){
                        longit=0;
                    }
                    if (window.XMLHttpRequest) {
                        peticion_http = new XMLHttpRequest();
                    } else if (window.ActiveXObject) {
                        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    peticion_http.onreadystatechange = muestraContenido;
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'guardarCoordenada.php?lat=' + latit + '&lon=' + longit, true);
                    peticion_http.send(null);

                    function muestraContenido() {
                        if (peticion_http.readyState == 4) {
                            if (peticion_http.status == 200) {
                                var dato = peticion_http.responseText;
                                document.body.style.cursor = 'auto';
                                alert('Proceso terminado...');
                            }
                        }
                    } 
        }
        
                    
            
        
		function showPosition(p)
		{
			var latitude = parseFloat( p.coords.latitude );
			var longitude = parseFloat( p.coords.longitude );
			document.getElementById('current').innerHTML="latitude=" + latitude + " longitude=" + longitude;
            //GuardarCoordenada(latitude, longitude); 
            //showMacAddress();
            /*var locator = new ActiveXObject("WbemScripting.SWbemLocator");
              var service = locator.ConnectServer(".");
              var properties = service.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration");
              var e = new Enumerator (properties);
              document.write("<table border=1>");
              dispHeading();
              //for (;!e.atEnd();e.moveNext ())
              //{
                    var p = e.item ();
                    document.write("<tr>");
                    document.write("<td>" + p.Caption + "</td>");
                    document.write("<td>" + p.IPFilterSecurityEnabled + "</td>");
                    document.write("<td>" + p.IPPortSecurityEnabled + "</td>");
                    document.write("<td>" + p.IPXAddress + "</td>");
                    document.write("<td>" + p.IPXEnabled + "</td>");
                    document.write("<td>" + p.IPXNetworkNumber + "</td>");
                    document.write("<td>" + p.MACAddress + "</td>");
                    document.write("<td>" + p.WINSPrimaryServer + "</td>");
                    document.write("<td>" + p.WINSSecondaryServer + "</td>");
                    document.write("</tr>");
              //}
              document.write("</table>");*/
            
            
			/*var pos=new google.maps.LatLng( latitude , longitude);
			map.setCenter(pos);
			map.setZoom(14);

			var infowindow = new google.maps.InfoWindow({
			    content: "<strong>yes</strong>"
			});

			var marker = new google.maps.Marker({
			    position: pos,
			    map: map,
			    title:"You are here"
			});

			google.maps.event.addListener(marker, 'click', function() {
			  infowindow.open(map,marker);
			});*/
			
		}
		</script>
	</body>
</html>