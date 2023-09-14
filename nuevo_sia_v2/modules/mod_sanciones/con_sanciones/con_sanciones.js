/* FUNCIONES DOM  */
function actualiza_datos(id_registro, cod_usuario, fecha_firma) {
  let val_acepta_rechaza = document.getElementById('valor_decision').value;
  let val_comentario = document.getElementById('comentario').value;


  console.log(id_registro, cod_usuario, val_acepta_rechaza, fecha_firma, val_comentario);



  reporte = 'update_firma_vendedor';
  variables = `?id_reg=${id_registro}&cod_usuario=${cod_usuario}&fec_firma=${fecha_firma}&acepta=${val_acepta_rechaza}&comentarios=${val_comentario}`;

  if (val_comentario == '') {
    alert('FAVOR BRINDAR UNA JUSTIFICACIÓN');
    return;
  } else {
    renderizar(reporte, cod_usuario, variables);
  }
}




/* redenrizar respuesta en un elemento de la interfaz */

function renderizar(reporte, id_usuario, variables = '') {
  swal("Comprobando...", "Por favor espere", {
    icon: "../../../assets/images/cargando_2.gif",
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
        document.getElementById('status_resul').innerHTML = dato;
      }
    }
  }
}



































/* FORMUALRIO FIRMAME */

var idCanvas = "canvas";
var idForm = "formCanvas";
var inputImagen = "imagen";
var estiloDelCursor = "crosshair";
var colorDelTrazo = "#555";
var colorDeFondo = "#fff";
var grosorDelTrazo = 1;

/* Variables necesarias */
var contexto = null;
var valX = 0;
var valY = 0;
var flag = false;
// var imagen = document.getElementById(inputImagen);
// var anchoCanvas = document.getElementById(idCanvas).offsetWidth;
// var altoCanvas = document.getElementById(idCanvas).offsetHeight;
// var pizarraCanvas = document.getElementById(idCanvas);

/* Esperamos el evento load */
// window.addEventListener("load", IniciarDibujo, false);

function IniciarDibujo() {
  // Creamos la pizarra 
  pizarraCanvas.style.cursor = estiloDelCursor;
  contexto = pizarraCanvas.getContext("2d");
  contexto.fillStyle = colorDeFondo;
  contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
  contexto.strokeStyle = colorDelTrazo;
  contexto.lineWidth = grosorDelTrazo;
  contexto.lineJoin = "round";
  contexto.lineCap = "round";
  // Capturamos los diferentes eventos 
  pizarraCanvas.addEventListener("mousedown", MouseDown, false);
  pizarraCanvas.addEventListener("mouseup", MouseUp, false);
  pizarraCanvas.addEventListener("mousemove", MouseMove, false);
  pizarraCanvas.addEventListener("touchstart", TouchStart, false);
  pizarraCanvas.addEventListener("touchmove", TouchMove, false);
  pizarraCanvas.addEventListener("touchend", TouchEnd, false);
  pizarraCanvas.addEventListener("touchleave", TouchEnd, false);
}

function MouseDown(e) {
  flag = true;
  contexto.beginPath();
  valX = e.pageX - posicionX(pizarraCanvas); valY = e.pageY - posicionY(pizarraCanvas);
  contexto.moveTo(valX, valY);
}

function MouseUp(e) {
  contexto.closePath();
  flag = false;
}

function MouseMove(e) {
  if (flag) {
    contexto.beginPath();
    contexto.moveTo(valX, valY);
    valX = e.pageX - posicionX(pizarraCanvas); valY = e.pageY - posicionY(pizarraCanvas);
    contexto.lineTo(valX, valY);
    contexto.closePath();
    contexto.stroke();
  }
}

function TouchMove(e) {
  e.preventDefault();
  if (e.targetTouches.length == 1) {
    var touch = e.targetTouches[0];
    MouseMove(touch);
  }
}

function TouchStart(e) {
  if (e.targetTouches.length == 1) {
    var touch = e.targetTouches[0];
    MouseDown(touch);
  }
}

function TouchEnd(e) {
  if (e.targetTouches.length == 1) {
    var touch = e.targetTouches[0];
    MouseUp(touch);
  }
}

function posicionY(obj) {
  var valor = obj.offsetTop;
  if (obj.offsetParent) valor += posicionY(obj.offsetParent);
  return valor;
}

function posicionX(obj) {
  var valor = obj.offsetLeft;
  if (obj.offsetParent) valor += posicionX(obj.offsetParent);
  return valor;
}

/* Limpiar pizarra */
function LimpiarTrazado() {
  contexto = document.getElementById(idCanvas).getContext('2d');
  contexto.fillStyle = colorDeFondo;
  contexto.fillRect(0, 0, anchoCanvas, altoCanvas);
}

/* Enviar el trazado */
function GuardarTrazado() {
  imagen.value = document.getElementById(idCanvas).toDataURL("firmas/png");
  document.forms[idForm].submit();
}