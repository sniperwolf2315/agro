let listado_seguridad = [
      '1012442314 - AGUIRRE	HERRERA	DANIELA ELIZABETH'
    , '1010025559 - BERRIO	CACERES	MARLON STEVEN'
    , '79500517	  - CAMARGO	DIAZ	JORGE LIBARD'
    , '1010011300 - CARVAJAL	SALGADO	RONALD JAIR'
    , '1000596667 - CHACON	ORDOÑEZ	YEISON SEBASTIAN'
    , '1023974402 - IBARGUEN	LUNA	ERWIN FELIPE'
    , '1006898316 - JIMENEZ	AVILEZ	JHON FREDIS'
    , '1083561981 - LEIVA	SEQUEDA	CECIL DE JESUS'
    , '52870524	  - MONTAÑA	ALDANA	LUZ MARINA'
    , '1000351211 - PEREZ	MELENDEZ	JOSE FRANCISCO'
    , '1002604816 - PEREZ	VALENCIA	CRISTIAN ARBEY'
    , '1003481939 - PIÑEROS	RINCON	MIGUEL ANGEL'
    , '1000987768 - RAMIREZ	PIMENTEL	BRAYAN CAMILO'
    , '1013580618 - VALENCIA	VARGAS	YENIFER'
    , '1020850358 - VILLALBA	SANZ	AXDREL ALEXANDER'
];


var selector = document.getElementById('per_seg');
listado_seguridad.forEach(function (personal) {
        
            var option=document.createElement("OPTION");
            option.innerHTML=personal;
            document.getElementById("per_seg").appendChild(option);
            // selector.add(opcion);
})


