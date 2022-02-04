<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script language="JavaScript">
var success = function(position){
var latlng = new google.maps.LatLng('4.76', '-74.14')
var myOptions = {
zoom: 15,
center: latlng,
mapTypeControl: false,
navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
mapTypeId: google.maps.MapTypeId.ROADMAP
}
var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions)
var marker = new google.maps.Marker({
position: latlng,
map: map,
title:"Estás aquí! (en un radio de "+position.coords.accuracy+" metros)"
})
}
</script>
<div id="mapcanvas" style="width:400px; height:400px"></div>
