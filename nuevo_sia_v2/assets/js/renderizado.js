



//  console.log('si realizo el llamado');

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

const btn_facturas_despachas = document.querySelector('.facturas_despachadas');
if (btn_facturas_despachas !== null) {

    btn_facturas_despachas.addEventListener('click', function () {
        console.log('click inf');
        renderizar('facturas_despachadas');
    });
}



function consultar_despachadas() {

    let retorna_consulta = '';
    const valores = window.location.search;

    fecha_desde = document.getElementById('fec_desde').value;
    fecha_hasta = document.getElementById('fec_hasta').value;
    num_embarque = document.getElementById('num_embarque').value;

    fecha_desde = fecha_desde.replaceAll('-', '/');
    fecha_hasta = fecha_hasta.replaceAll('-', '/');
    
    if (num_embarque ==' '){
        num_embarque.value='';
        retorna_consulta = `SELECT frf.ConsecutivoCarga,    frf.Fecha as FechaQuemado,    frf.Cedula CedulaCliente,    frf.Nombres NombreCliente,    frf.Factura as NumeroFactura,  frf.Valor,frf.Problema,frf.Orden as NumeroOrden, frf.ShipmentNumber Embarque,frf.idruta Ruta,fc.Nombres Conductor,fv.Descripcion NumeroPlaca,frf.IdDestino IdDestino,      frf.Destino,  frf.Direccion, frf.FechaProgramada,   frf.FechaIngreso FROM     dbo.facRegistroFactura   FRF left join facVehiculo FV on FRF.IdVehiculo = FV.IdVehiculo left join facConductor FC on FRF.IdConductor = fc.IdConductor where CONVERT(nvarchar(30),frf.Fecha, 111) between '${fecha_desde}' and '${fecha_hasta}' order by Fecha desc,ConsecutivoCarga,frf.Cedula`;
        
    }else if(num_embarque != ' '){
        fecha_desde.value='';
        fecha_hasta.value='';
        retorna_consulta = `SELECT frf.ConsecutivoCarga,    frf.Fecha as FechaQuemado,    frf.Cedula CedulaCliente,    frf.Nombres NombreCliente,    frf.Factura as NumeroFactura,  frf.Valor,frf.Problema,frf.Orden as NumeroOrden, frf.ShipmentNumber Embarque,frf.idruta Ruta,fc.Nombres Conductor,fv.Descripcion NumeroPlaca,frf.IdDestino IdDestino,      frf.Destino,  frf.Direccion, frf.FechaProgramada,   frf.FechaIngreso FROM     dbo.facRegistroFactura   FRF left join facVehiculo FV on FRF.IdVehiculo = FV.IdVehiculo left join facConductor FC on FRF.IdConductor = fc.IdConductor where frf.ConsecutivoCarga = '${num_embarque}'  order by Fecha desc,ConsecutivoCarga,frf.Cedula`;
        
    }else {
         swal('Favor seleccione una opción de filtro');
        return;
    }
    
    $.ajax({
        data: retorna_consulta,
        url: `facturas_despachadas_descarga.php?consul_des=${retorna_consulta}`,
        type: 'post',
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor");
        },
        success: function (response) {
            $("#resultado").html(response);
        }
    });
}

function tipo_filtro_despachadas(valor_filtro) {

    lbl_fecha_desde = document.getElementById('lbl_fec_desde');
    lbl_fecha_hasta = document.getElementById('lbl_fec_hasta');

    fecha_desde = document.getElementById('fec_desde');
    fecha_hasta = document.getElementById('fec_hasta');

    lbl_num_embarque = document.getElementById('lbl_nume_embarque');
    num_embarque = document.getElementById('num_embarque');

    if (valor_filtro == 'embarque') {
        fecha_desde.disabled     = true;
        fecha_hasta.disabled     = true;
        num_embarque.disabled    = false;

        fecha_desde.value         ='';
        fecha_hasta.value         ='';
        num_embarque.focus();
    } else if (valor_filtro == 'fechas') {
        fecha_desde.disabled     = false;
        fecha_hasta.disabled     = false;
        num_embarque.disabled    = true;
        num_embarque.value       ='';
        fecha_desde.focus();
    }else{
        fecha_desde.disabled     = true;
        fecha_hasta.disabled     = true;
        num_embarque.disabled    = true;

    }
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

const btn_consulta_retardos = document.querySelector('.consulta_retardos');
if (btn_consulta_retardos !== null) {
    btn_consulta_retardos.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        campo = obtner_variables_url('area');
        renderizar('descargar-informe-retardos', '', `?area=${campo}`);
    });

}
const btn_cargue_gh = document.querySelector('.carga_data');
if (btn_cargue_gh !== null) {
    btn_cargue_gh.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        campo = obtner_variables_url('area');
        renderizar('cargar_archivo', '', `?area=${campo}`);
    });

}
const btn_cons_gh = document.querySelector('.con_data');
if (btn_cons_gh !== null) {
    btn_cons_gh.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        campo = obtner_variables_url('area');
        renderizar('descargar-informe', '', `?area=${campo}`);
    });

}

function consultar_query() {
    fecha_desde = document.getElementById('f_desde').value;
    fecha_hasta = document.getElementById('f_hasta').value;
    area_consulta = document.getElementById('area_con').value;
    area_consulta_cod = document.getElementById('area_cod').value;


    fecha_desde = fecha_desde.replaceAll('-', '/');
    fecha_hasta = fecha_hasta.replaceAll('-', '/');

    retorna_consulta = '';

    if (fecha_desde == '' && fecha_hasta == '') {
        if (area_consulta_cod == 'SEGURIDAD' || area_consulta_cod == 'SISTEMAS' || area_consulta_cod == 'AUDITORIA') {
            retorna_consulta = `select * from registro_visitantes  order by  Hora_ingreso desc`;
        } else {
            retorna_consulta = `select * from registro_visitantes where Area_agenda='${area_consulta_cod}' order by  Hora_ingreso desc`;
        }
    } else {
        if (area_consulta_cod == 'SEGURIDAD' || area_consulta_cod == 'SISTEMAS' || area_consulta_cod == 'AUDITORIA') {
            retorna_consulta = `select * from registro_visitantes where CONVERT(nvarchar(30),hora_ingreso, 111) between '${fecha_desde}' and '${fecha_hasta}' order by  Hora_ingreso desc`;
        } else {
            retorna_consulta = `select * from registro_visitantes where CONVERT(nvarchar(30),hora_ingreso, 111) between '${fecha_desde}' and '${fecha_hasta}' and Area_agenda ='${area_consulta_cod}' order by  Hora_ingreso desc`;
        }
    }
    renderizar('info_tabla', '0', `?v1=${retorna_consulta}&area=${area_consulta}&area_cod=${area_consulta_cod}`);
}
function consultar_query_retardos() {
    // document.body.style.cursor = 'wait';
    fecha_desde       = document.getElementById('f_desde').value;
    fecha_hasta       = document.getElementById('f_hasta').value;



    area_consulta     = document.getElementById('area_con').value;
    area_consulta_cod = document.getElementById('area_cod').value;

    fecha_desde = fecha_desde.replaceAll('-', '/');
    fecha_hasta = fecha_hasta.replaceAll('-', '/');
    let fechaInicio = new Date(fecha_desde ).getTime();
    let fechaFin    = new Date(fecha_hasta).getTime();
    let diff        = fechaFin - fechaInicio;
    let dias_dif    = (diff/(1000*60*60*24) );
    fecha_array = fecha_desde.split("/");
   
    

    if(fecha_desde=='' || fecha_hasta=='') {
         swal("No pueden quedar fechas vacías.");
        return;
    }

    if(dias_dif >= 40){
        swal('El rango consultado excede los 30 días')
        return;
    }
    if(fechaFin < fechaInicio){
         swal('La fecha fin no puede ser menor que la fecha de incio')
        return;
    }
    


    anio_ini = fecha_array[0];
    mes_ini  = fecha_array[1];
    dia_ini  = fecha_array[2];
    dias_dif = (dias_dif == 0 )?0:dias_dif;
    retorna_consulta = '';
    swal("Procesando...", "Por favor espere", {icon: "../../assets/images/CARGA_7.gif",buttons: false,allowOutsideClick: false,});
    renderizar('info_tabla_retardos', '0', `?anio=${anio_ini}&mes=${mes_ini}&dia=${dia_ini}&difdias=${dias_dif}&fh=${fecha_hasta}`);
}


function ver_lista_retardos() {
    let fecha_desde = document.getElementById('f_desde').value;
    let fecha_hasta = document.getElementById('f_hasta').value;
    let reporte = 'info_tabla_retardos_2';
    let variables = `?fd=${fecha_desde}&fh=${fecha_hasta}`;
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
        swal({title: "Cargando",text: "",timer: 200});
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('tbl_retardos_mes').innerHTML = dato;
            }
        }
    }
    
}

/* MODULO GH*/


// function renderizar(arreglo) {
function renderizar(reporte, id_usuario, variables = '') {

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
                 swal({title: "El proceso termino",text: "",timer: 400});
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('pedidos_all').innerHTML = dato;
            }
        }
    }
}

function obtner_variables_url(campo) {
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);

    //Accedemos a los valores
    campos = urlParams.get(campo);
    return campos;

}