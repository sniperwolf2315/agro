<?php
    $localhostL 	= 	'localhost'	; 	$userA 		= 	'sistemas'	;
    $claveO		=	'sistemasqgro'; 	$base_datosL	=	'agrobase'	;
    $mysqliL = new mysqli($localhostL,$userA,$claveO,$base_datosL);
    if (mysqli_connect_errno())
      { echo "Failed to connect to MySQL Local: " . mysqli_connect_error(); }

?>