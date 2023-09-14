// console.log('si inte');

/** DOMICILIOS */
const btn_pedidos = document.querySelector('.pedidos');
if (btn_pedidos !== null) {
    btn_pedidos.addEventListener('click', function () {
        renderizar('consulta_pedido');
    });
}

const btn_pedidos_Q = document.querySelector('.pedidos_Q');
if (btn_pedidos_Q !== null) {
    btn_pedidos_Q.addEventListener('click', function () {
        console.log('click quick');
        renderizar('consulta_pedido_Q');
    });
}

const btn_pedidos_R = document.querySelector('.pedidos_R');
if (btn_pedidos_R !== null) {
    btn_pedidos_R.addEventListener('click', function () {
        console.log('click rboy');
        renderizar('consulta_pedido_R');
    });
}

const btn_config = document.querySelector('.configuracion');
if (btn_config !== null) {
    btn_config.addEventListener('click', function () {
        console.log('click conf');
        renderizar('configuracion');
    });
}

const btn_informe_mensual = document.querySelector('.informe_mensual');
if (btn_informe_mensual !== null) {

    btn_informe_mensual.addEventListener('click', function () {
        console.log('click inf');
        renderizar('informe_mensual');
    });
}

// ESTE BOTON CARGA Y LLENA LA TABLA DE SQL PARA LEER LOS CONDUCTORES
const btn_informe_recarga = document.querySelector('.rest_pibox_sql');
if (btn_informe_recarga !== null) {
    btn_informe_recarga.addEventListener('click', function () {
        console.log('click SQL');
        renderizar('../domiciliario/rest_pibox_sql');
    });
}
const btn_carga_recaudo = document.querySelector('.ingreso_domiciliario_rec');
if (btn_carga_recaudo !== null) {
    btn_carga_recaudo.addEventListener('click', function () {
        console.log('click SQL');
        renderizar('ingreso_domiciliario_rec');
    });
}

/** DOMICILIOS */


/** SEGURIDAD */

const btn_sal_pedidos_usuario = document.querySelector('.sal_dom');
if (btn_sal_pedidos_usuario !== null) {
    btn_sal_pedidos_usuario.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        // renderizar('sal_seguridad');
        renderizar('tablero_salida');
    });

}
const btn_pedidos_usuario = document.querySelector('.ing_seg');
if (btn_pedidos_usuario !== null) {
    btn_pedidos_usuario.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        renderizar('ing_seguridad');
    });

}
const btn_ing_fall = document.querySelector('.ing_fall');
if (btn_ing_fall !== null) {
    btn_ing_fall.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        renderizar('ing_fall');
    });

}

/** SEGURIDAD */


/* MODULO GH*/

const btn_cargue_gh = document.querySelector('.carga_data');
if (btn_cargue_gh !== null) {
    btn_cargue_gh.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        campo = obtner_variables_url('area');
        renderizar('cargar_archivo','',`?area=${campo}`);
    });

}
const btn_cons_gh = document.querySelector('.con_data');
if (btn_cons_gh !== null) {
    btn_cons_gh.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        campo = obtner_variables_url('area');
        renderizar('descargar-informe','',`?area=${campo}`);
    });

}

function consultar_query(){
    fecha_desde       = document.getElementById('f_desde').value;
    fecha_hasta       = document.getElementById('f_hasta').value;
    area_consulta     = document.getElementById('area_con').value;
    area_consulta_cod = document.getElementById('area_cod').value;
   
    
    fecha_desde = fecha_desde.replaceAll('-','/');
    fecha_hasta = fecha_hasta.replaceAll('-','/');
    
    retorna_consulta ='';

    if(fecha_desde=='' &&fecha_hasta=='' ){
        if(area_consulta_cod=='SEGURIDAD'){
            retorna_consulta =`select * from registro_visitantes  order by  Hora_ingreso desc`;
        }else{
            retorna_consulta =`select * from registro_visitantes where Area_agenda='${area_consulta_cod}' order by  Hora_ingreso desc`;
        }
    }else{
        if(area_consulta_cod=='SEGURIDAD'){
            retorna_consulta= `select * from registro_visitantes where CONVERT(nvarchar(30),hora_ingreso, 111) between '${fecha_desde}' and '${fecha_hasta} order by  Hora_ingreso desc'`;
        }else{
            retorna_consulta= `select * from registro_visitantes where CONVERT(nvarchar(30),hora_ingreso, 111) between '${fecha_desde}' and '${fecha_hasta} and Area_agenda ='${area_consulta_cod}' order by  Hora_ingreso desc'`;
        }
    }
    renderizar('info_tabla','0',`?v1=${retorna_consulta}&area=${area_consulta}&area_cod=${area_consulta_cod}`);
}

/* MODULO GH*/


// function renderizar(arreglo) {
function renderizar(reporte, id_usuario,variables='') {
    // console.log(`${reporte}, ${id_usuario},${variables}`);
    swal("Comprobando...", "Por favor espere", {
        icon: "../../../assets/images/CARGA_7.gif",
        buttons: false,
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
    // console.log(` la ulr es ${reporte}.php${variables}`);
    peticion_http.open('POST', `${reporte}.php${variables}`, true);
    peticion_http.send(null);
    function muestraContenido() {
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                swal("El proceso termino", "", "success");
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('pedidos_all').innerHTML = dato;
            }
        }
    }
}

function obtner_variables_url(campo){
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);

    //Accedemos a los valores
    campos = urlParams.get(campo);
    return campos;
    
}