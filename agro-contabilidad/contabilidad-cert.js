let fecha_desde, fecha_hasta;
let fecha = new Date();

fecha_desde = document.getElementById('fecha_desde');
fecha_hasta = document.getElementById('fecha_hasta');
fecha_for = formatoFecha(fecha, 'yy-mm-dd')

function popupmsj(texto) {
    swal.fire(`${texto}`, "", "info");
    swal.fire({
        title: "Agrocampo dice: \n ",
        text: `${texto}`,
        timer: 2000,
        showConfirmButton: false
      });

    
}


function formatoFecha(fecha, formato) {
    const map = {
        dd: fecha.getDate(),
        mm: (fecha.getMonth() < 10) ? String(fecha.getMonth() + 1).padStart(2, '0') : fecha.getMonth() + 1,
        yy: fecha.getFullYear().toString().slice(-4),
        yyyy: fecha.getFullYear()
    }

    return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched])
}


function printDiv(div_print) {
    var contenido           = document.getElementById(div_print).innerHTML;
    var contenidoOriginal   = document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}



function consultar_cert(certificado) {
    if(certificado== undefined ){
        certificado = document.getElementById('type_form').value;
    }else{
        certificado = certificado
    }

    
    if (nit_empresa == '' || certificado ==''){
        document.getElementById('seccion_response').innerHTML = '';
        swal.fire("No puede tener el nit o el certificado en blanco", "", "info");
        return;
    }
    
    
    fecha_desde = document.getElementById('fecha_desde').value;
    fecha_hasta = document.getElementById('fecha_hasta').value;
    nit_empresa = document.getElementById('nit_empresa').value;

    let fechaInicio = new Date(fecha_desde ).getTime();
    let fechaFin    = new Date(fecha_hasta).getTime();
    let diff        = fechaFin - fechaInicio;
    let dias_dif    = (diff/(1000*60*60*24) );
    

    if (dias_dif >=732){/* no debe consultar mas de 2 años */
        swal.fire("La consulta supera los 2 años, favor contactarse con Agrocampo");
        return;
    }

    consulta_certificado = `?tipo_cert=${certificado}&fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&nit=${nit_empresa}`;
    
    switch (certificado) {
        case "ica_bta":
            ruta_reprote = 'certificado-ica';
            break;
        case "ica_cota":
            ruta_reprote = 'certificado-ica';
            break;
        case "iva":
            ruta_reprote = 'certificado-iva';
            break;
        case "rfte":
            ruta_reprote = 'certificado-rtfte';
            break;
        case "prov":
            ruta_reprote = 'certificado-proveedores';
            break;

        default:
            break;
    }
    
  

    renderizar(ruta_reprote, consulta_certificado);
}

function renderizar(reporte, variables = '') {
    if (window.XMLHttpRequest) {
        peticion_http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Preparar la funcion de respuesta
    peticion_http.onreadystatechange = muestraContenido;
    // Realizar peticion HTTP

    peticion_http.open('POST', `${reporte}.php${variables}`, true);
    peticion_http.send(null);
    function muestraContenido() {
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                swal.fire("Terminó", "", "success");
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('seccion_response').innerHTML = dato;
            }
        }
    }
}
