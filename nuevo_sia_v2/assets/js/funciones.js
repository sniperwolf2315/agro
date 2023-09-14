// console.log('si ingreso');
// document.getElementById('con').innerHTML = (navigator.onLine)?'el navegador está conectado a la red':'el navegador NO está conectado a la red';

function cronometro(var1, var2, var3) {
  reloj(var1, var2, var3);
}
var id = document.getElementById("numeros");

function reloj(d, a, m, r) {
  if (id.innerHTML == "pausa") {
  } else {
    if (d > a) {
      c = "resta";
    } else {
      c = "suma";
    }
    id.innerHTML = d;
    if (d == a) {
    } else {
      if (c == "suma") {
        setTimeout("reloj(" + new String(d + 1) + "," + a + "," + m + ")", m);
      } else if (c == "resta") {
        setTimeout("reloj(" + new String(d - 1) + "," + a + "," + m + ")", m);
      }
    }
  }
}
function pausa() {
  var id = document.getElementById("numeros");
  document.getElementById("temp").innerHTML = id.innerHTML;
  id.innerHTML = "pausa";
  id.style.display = "none";
  document.getElementById("temp").style.display = "";
}
function continuar() {
  document.getElementById("numeros").innerHTML = "reloj";
  p2 = document.getElementById("numeros").value = "numeros";
  p3 = document.getElementById("numeros").value = "temp";
  reloj(new Number(document.getElementById("temp").innerHTML), p2, p3);
  document.getElementById("numeros").style.display = "";
  document.getElementById("temp").style.display = "none";
}


function exportar_excel(nombre_tabla, nombre_archivo = '') {
  let descarga_enlace;
  let data_type = 'application/vnd.ms-excel';
  let table_select = document.getElementById(nombre_tabla);
  let tabla_html = table_select.outerHTML.replace(/ /g, '%20');
  /** se establece la hora actual del sistema para asignar y ver la generacion del informe */
  let hoy = new Date();
  let fecha_actual = hoy.getDate() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getFullYear();

  //  SE LE ASIGNA UN NOMBRE SI NO TIENE 
  nombre_archivo = nombre_archivo ? nombre_archivo + '.xlsx' : 'Informe-mes-' + fecha_actual + '.xlsx';
  descarga_enlace = document.createElement("a");

  document.body.appendChild(descarga_enlace);


  if (navigator.msSaveOrOpenBlob) {
    let blob = new Blob(['ufeff', tabla_html], {
      type: data_type
    });
    navigator.msSaveOrOpenBlob(blob, nombre_archivo);

  } else {
    descarga_enlace.href = 'data:' + data_type + ',' + tabla_html;
    descarga_enlace.download = nombre_archivo;
    descarga_enlace.click();
  }
}


function popUp(URL) {
  window.open(URL, 'agrocampo config', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=300,left = 400,top = 250');
}

function contador_recargas() {
  // var contador=0;
  // var contador = isNaN(parseInt(window.name)) ? 1 : parseInt(window.name);
  // alert(contador);
  contador++;
  window.name = contador;
  // window.location.href = window.location.href + "?c=" + window.name ;
  url = window.location.href + "?c=" + window.name;
  return url;
}


/* MODULO DE GH */
function filtrar_fechas() {
  fecha_desde = document.getElementById('f_desde').value;
  fecha_hasta = document.getElementById('f_hasta').value;
  fecha_desde = fecha_desde.replaceAll('-', '/');
  fecha_hasta = fecha_hasta.replaceAll('-', '/');

  retorna_consulta = '';
  if (fecha_desde == '' && fecha_hasta == '') {
    retorna_consulta = 'select * from registro_visitantes order by Hora_ingreso desc,Activo';

  } else {
    retorna_consulta = `select * from registro_visitantes where CONVERT(nvarchar(30),hora_ingreso, 111) between '${fecha_desde}' and '${fecha_hasta}'`;
  }
}


// function actualiza_datos(id, nombre_act, documento_act, area_act, jefe_act, jornada_act, actividad_act) {
function actualiza_datos() {
  
  let id_act = document.getElementById('id_act').outerText;
  let nom_act = document.getElementById('nom_act').value;
  let doc_act = document.getElementById('doc_act').value;
  let are_act = document.getElementById('are_act').value;
  let jef_act = document.getElementById('jef_act').value;
  let jor_act = document.getElementById('jor_act').value;
  let acd_act = document.getElementById('acd_act').value;
  let are_car = document.getElementById('are_car').outerText;

  if (window.XMLHttpRequest) {
    peticion_http = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // Preparar la funcion de respuesta
  peticion_http.onreadystatechange = muestraContenido;
  // Realizar peticion HTTP
  
  peticion_http.open('POST', `./update/crud_temporales.php?id_doc=${id_act}&nom_act=${nom_act}&doc_act=${doc_act}&are_act=${are_act}&jef_act=${jef_act}&jor_act=${jor_act}&acd_act=${acd_act}&are_car=${are_car}`, true);
  peticion_http.send(null);
  function muestraContenido() {
    document.body.style.cursor = 'auto';
    if (peticion_http.readyState == 4) {
      if (peticion_http.status == 200) {
        var dato = peticion_http.responseText;
        document.body.style.cursor = 'auto';
        document.getElementById('resultado').innerHTML = dato;
      }
    }
  }

}
/* MODULO DE FACTURAS */
function actualiza_datos_fac() {
  
  let num_fac  = document.getElementById('num_fact').value;
  let tipo_fac = document.getElementById('tipo_fac').value;
  let num_guia = document.getElementById('num_guia').value;
  let vlr_guia = document.getElementById('val_guia').value;
  
  if (window.XMLHttpRequest) {
    peticion_http = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // Preparar la funcion de respuesta
  peticion_http.onreadystatechange = muestraContenido;
  // Realizar peticion HTTP
  peticion_http.open('POST', `../../modulo_facturas/modulo_facturas/crud_ordenes.php?num_fac=${num_fac}&tipo_fac=${tipo_fac}&num_guia=${num_guia}&vlr_guia=${vlr_guia}`, true);
  peticion_http.send(null);
  function muestraContenido() {
    document.body.style.cursor = 'auto';
    if (peticion_http.readyState == 4) {
      if (peticion_http.status == 200) {
        var dato = peticion_http.responseText;
        document.body.style.cursor = 'auto';
        document.getElementById('resultado').innerHTML = dato;
      }
    }
  }

}





/* MODULO DE FACTURAS */



function borra_datos() {
  let id_act = document.getElementById('id_act').outerText;
  let nom_act = document.getElementById('nom_act').value;
  let doc_act = document.getElementById('doc_act').value;
  let are_act = document.getElementById('are_act').value;
  let jef_act = document.getElementById('jef_act').value;
  let jor_act = document.getElementById('jor_act').value;
  let acd_act = document.getElementById('acd_act').value;
  let are_car = document.getElementById('are_car').outerText;

  if (window.XMLHttpRequest) {
    peticion_http = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // Preparar la funcion de respuesta
  peticion_http.onreadystatechange = muestraContenido;
  // Realizar peticion HTTP
  peticion_http.open('POST', `./delete/crud_temporales.php?id_doc=${id_act}&nom_act=${nom_act}&doc_act=${doc_act}&are_act=${are_act}&jef_act=${jef_act}&jor_act=${jor_act}&acd_act=${acd_act}&are_car=${are_car}`, true);
  peticion_http.send(null);
  function muestraContenido() {
    document.body.style.cursor = 'auto';
    if (peticion_http.readyState == 4) {
      if (peticion_http.status == 200) {
        // alert("El proceso termino", "", "success");
        var dato = peticion_http.responseText;
        document.body.style.cursor = 'auto';
        document.getElementById('resultado').innerHTML = dato;
      }
    }
  }

}




function insert_datos() {
  // console.log('si ingreso por aca');
  
  let nom_act  = (document.getElementById('nom_act').value);
  let doc_act  = (document.getElementById('doc_act').value);
  let are_act  = (document.getElementById('are_act').value);
  let jef_act  = (document.getElementById('jef_act').value);
  let jor_act  = (document.getElementById('jor_act').value);
  let acd_act  = (document.getElementById('acd_act').value);
  let are_car  = (document.getElementById('are_car').value);
  let user_car = (document.getElementById('user_carg').value);


  are_act = (are_act=='')?document.getElementById('are_acts').value:are_act;


  if (window.XMLHttpRequest) {
    peticion_http = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // Preparar la funcion de respuesta
  peticion_http.onreadystatechange = muestraContenido;
  // Realizar peticion HTTP
  peticion_http.open('POST', `./create/crud_temporales.php?nom_act=${nom_act}&doc_act=${doc_act}&are_act=${are_act}&jef_act=${jef_act}&jor_act=${jor_act}&acd_act=${acd_act}&are_car=${are_car}&user_cargue=${user_car}`, true);
  peticion_http.send(null);
  function muestraContenido() {
    document.body.style.cursor = 'auto';
    if (peticion_http.readyState == 4) {
      if (peticion_http.status == 200) {
        // alert("El proceso termino", "", "success");
        var dato = peticion_http.responseText;
        document.body.style.cursor = 'auto';
        document.getElementById('resultado').innerHTML = dato;
      }
    }
  }

}





function renderizar(reporte, id_usuario, variables = '') {
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





function downloadCSV(csv, filename) {
  var csvFile;
  var downloadLink;

  csvFile = new Blob([csv], { type: "text/csv" });
  downloadLink = document.createElement("a");
  downloadLink.download = filename;

  downloadLink.href = window.URL.createObjectURL(csvFile);

  downloadLink.style.display = "none";

  document.body.appendChild(downloadLink);
  downloadLink.click();

}

function exporttablecsv(filename) {
  var csv = [];
  var rows = document.querySelectorAll("table tr");

  for (var i = 0; i < rows.length; i++) {

    var row = [], cols = rows[i].querySelectorAll("td, th");

    for (var j = 0; j < cols.length; j++) {
      row.push(cols[j].innerText);
    }
    csv.push(row.join(","));

  }
  downloadCSV(csv.join("\n"), filename);
}

function tipo_campo(valor) {
  let opc_entrada = document.getElementById('sel_ect');
  let are_act     = (document.getElementById('are_act'));

  if (valor == 'EXTERNO') {
    opc_entrada.style.display = "";
    opc_entrada.innerHTML = "<input type='text' name='are_acts' id='are_acts' placeholder = 'De que empresa proviene'>";
    are_act.style.display = "none";
  } else {
    are_act.style.display = "";
    opc_entrada.style.display = "none";
  }
}