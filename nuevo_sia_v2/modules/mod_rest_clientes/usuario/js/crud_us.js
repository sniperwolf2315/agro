function actualizar_placas(posision,txt_id_con,txt_ce_con,txt_no_con,txt_em_con) {
    
    txt_pl_con =document.getElementsByClassName('pl_con');
    txt_pl_con = txt_pl_con[posision].value;
    
    if(txt_pl_con==''){
        Swal.fire('Placa en blanco');
        return;
    }

    console.log(`${posision} ${txt_id_con} ${txt_ce_con} ${txt_no_con} ${txt_pl_con} ${txt_em_con}`);
    path = `?id_key=${txt_id_con}&num_ced=${txt_ce_con}&nombre=${txt_no_con}&num_placa=${txt_pl_con}&empresa=${txt_em_con}`;
    renderizar('actualizar_placas',path );
}


function renderizar(reporte, variables = '') {


    let timerInterval
    Swal.fire({
      title: 'Actualizando!',
      html: '<b></b>.',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
      }
    })
    // console.log(`${reporte}, ${variables}`);

    if (window.XMLHttpRequest) {
        peticion_http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Preparar la funcion de respuesta
    peticion_http.onreadystatechange = muestraContenido;
    // Realizar peticion HTTP
    console.log(` la ulr es ${reporte}.php${variables}`);
    peticion_http.open('POST', `${reporte}.php${variables}`, true);
    peticion_http.send(null);
    function muestraContenido() {
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('respuesta_update').innerHTML = dato;
            }
        }
    }
}