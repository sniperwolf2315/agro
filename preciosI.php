

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Untitled Web Page</title>

<meta name="generator" content="Antenna 3.0">

<meta http-equiv="imagetoolbar" content="no">

<link rel="stylesheet" type="text/css" href="antenna.css" id="css">

<script src="aajquery.js"></script>

<style type="text/css">.abs {position:absolute}</style>

<script type="text/javascript" src="../../antenna/auto.js"></script>

<script>
$(document).ready(function(){
    $(".verloader").click(function(){
        $(".loader").show("slow");
    });
});

$(window).load(function() {
    $(".loader").fadeOut();
   });


function completa(){ 
    document.documentElement.webkitRequestFullScreen();
    var iframeV = document.getElementById('iframe');
	var tmp_src = iframeV.src; 
	iframeV.src = ''; 
	iframeV.src = tmp_src; 
	}

function setFocus(){
var miiframe = document.getElementById("iframe");
miiframe.contentDocument.forms['sistema'].ean.focus();
}
	
</script>


</head>

<body class="global">

<img  src="/images/fondoprecio.jpg" class="abs"  id="text450gwlro" style="width:100%; left: 0; top: 0;" height="100%">
<table class="abs"  width="100%" height="100%" bordercolor="silver" border="0" cellspacing="0">

    <tr>
    	<td height="32%" width="41%"> </td>
    	<td width="54%"> </td>
    	<td width="5%"> </td>
    </tr>
    <tr>
    	<td height="43%"> </td>
    	<td><iframe onload="setFocus()" id="iframe" name="iframe" class="hid" height="100%" width="100%" style="border:none" scrolling="no" src="preciosII.php"></iframe></td>
    	<td></td>
    </tr>

	<tr>
    	<td height="24%"></td>
    	<td> </td>
    	<td></td>
    </tr>

    </table>

<div class="abs fil" onclick="completa()">+</div>
</body></html>

