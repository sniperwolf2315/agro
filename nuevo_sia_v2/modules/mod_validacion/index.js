let array_items = [];
let array_items_origins = [];



function abrir_ventana(tipo) {
    // console.log('Si dio click',tipo);
    let empresa = document.getElementById('emp').value;
    let orden = document.getElementById('ov').value;
    let num_caja = document.getElementById('cajas').value;
    let tte = document.getElementById('tte').value;
    let peso = document.getElementById('guia').value;
    let guia = document.getElementById('peso').value;
    tipo = (tipo == 'tirilla') ? 'bolsa' : 'caja';
    window.close();
    window.open(`rotulo.php?ov=${orden}&cajas=${num_caja}&emp=${empresa}&tte=${tte}&guia=${guia}&peso=${peso}&tipo=${tipo}`, "Rotulos", "width=1000, height=800")
    // console.log(` ${empresa} ${orden} ${num_caja} ${tte} ${peso} ${guia} ${tipo} ` );

}


function clear_form() {
    document.getElementById("frm_validacion").reset();
    window.location.reload()
}




const btn_cons_factura = document.querySelector('.consulta_factura');
if (btn_cons_factura !== null) {
    btn_cons_factura.addEventListener('click', function () {
        document.body.style.cursor = 'wait';
        const valores = window.location.search;
        let factura_orden = document.getElementById('fac_validacion').value;
        let validador_orden = document.getElementById('ls_alistadores').value;
        let num_cajas = document.getElementById('num_cajas').value;
        if (factura_orden == '' || validador_orden == '') {
            
            alert('No puede tener la orden o el validador en blanco');
            return;
        }
        renderizar('consulta_ordenes', `?num_factura=${factura_orden}&validador=${validador_orden}&cajas=${num_cajas}`);
    });

}

function get_items_origins() {
    this.array_items_origins = [];
    let items_origin = document.querySelectorAll('.item_origin');
    let init = 0;
    while (init < items_origin.length) {
        array_items_origins.push(items_origin[init].innerHTML.trim());
        init++;
    }

}



function insertar_items(valor_item) {

    let item_producto = document.getElementById('num_item').value;
    let cantidad_producto = document.getElementById('cantidad_item').value;
    let ls_productos = document.getElementById('ls_agregados');
    let lista_items = [{ item_producto, ls_productos }]
    /* validar que no se repitan los items  */

    existe_in_array = array_items_origins.includes(item_producto)
    if (!existe_in_array) {
        alert('Este prodcuto no pertenece a la orden');
        return;
    }
    if (cantidad_producto == '') {
        alert("Cantidad no valida o en blanco");
        return;
    }

    
    array_items.push({ "item" : item_producto, "cantidad" : cantidad_producto })
    // ls_productos.innerHTML = ((JSON.stringify(array_items)).replace("[","")).replace("]","");
    ls_productos.innerHTML = JSON.stringify(array_items);
    document.getElementById('num_item').value = "";
    document.getElementById('cantidad_item').value = "";
}


function borrar_items(params) {
    let item_producto = document.getElementById('num_item').value;
    let ls_productos = document.getElementById('ls_agregados');
    let cantidad_producto = document.getElementById('cantidad_item').value;
    array_items = array_items.filter(item_b => item_b.item !== item_producto)
    item_producto.innerHTML = '';
    cantidad_producto.innerHTML = '';
    ls_productos.innerHTML = JSON.stringify(array_items);
    document.getElementById('num_item').value = "";
    document.getElementById('cantidad_item').value = "";
}


function validar_orden() {
    // let lista_items_ori =  document.getElementById('item_result').value;
    let lista_items_ori = document.querySelector('.item_result');
    let lista_items_new = document.getElementById('ls_agregados').value;
    if (lista_items_new == '') {
        alert('No ha registrador item');
        continuar();
        return;
    }
    renderizar_items('validar_items', `?valores_item=${lista_items_new}`);
}



function renderizar_items(reporte, variables = '') {
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
                // swal("El proceso termino", "", "success");
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('pedidos_alistamiento').innerHTML = dato;
            }
        }
    }
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
    // console.log(` la ulr es ${reporte}.php${variables}`);
    peticion_http.open('POST', `${reporte}.php${variables}`, true);
    peticion_http.send(null);
    function muestraContenido() {
        document.body.style.cursor = 'auto';
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                console.clear();
                // swal("El proceso termino", "", "success");
                var dato = peticion_http.responseText;
                document.body.style.cursor = 'auto';
                document.getElementById('pedidos_all').innerHTML = dato;
                get_items_origins();
            }
        }
    }
}