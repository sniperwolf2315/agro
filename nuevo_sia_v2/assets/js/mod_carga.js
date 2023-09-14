function cambiarestado(est_upd,ventanilla, turno, placa, estado) {
    if (est_upd == 'ESPERA') {
            observacion = window.prompt('POR QUE LO DEJA EN ESPERA','');
            renderizar(est_upd, turno, placa, ventanilla,observacion);
        }else{
            observacion='';
            renderizar(est_upd, turno, placa, ventanilla,observacion);
        }
}

function renderizar(estatus, turno, placa, bahia, comentario) {
    swal({
        título: "Comprobando...",
        texto: "Por favor, espere",
        icon: "../../../assets/images/cargando_2.gif",
        Button: false,
        allowOutsideClick: false
    });
    if (window.XMLHttpRequest) {
        peticion_http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Preparar la funcion de respuesta
    peticion_http.onreadystatechange = muestraContenido;
    // Realizar peticion HTTP
    peticion_http.open('POST', `crud_usuario.php?estatus=${estatus}&turno=${turno}&placa=${placa}&bahia=${bahia}&comentario=${comentario}`, true);
    peticion_http.send(null);
    function muestraContenido() {
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                var dato = peticion_http.responseText;
                if (dato.substring(4, 0) == 'X...') {
                    swal("El proceso termino", dato, "success");
                    location.reload();
                    return;
                }
                swal("El proceso termino", "", "success");
                console.log(dato);
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        }
    }
}