function ejecutar_informe() {
  informe = document.getElementById("info").value;
  area = document.getElementById("area").value;
  if (window.XMLHttpRequest) {
    peticion_http = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
  }
  // Preparar la funcion de respuesta
  peticion_http.onreadystatechange = muestraContenido;

  if (informe === "Facturado") {
    // console.log("fac");
    peticion_http.open(
      "POST",
      "ventas_cuota_new.php?area=" + area + "&informe=" + informe,
      true
    );
  } else if (informe === "Ord_Venta") {
    peticion_http.open(
      "POST",
      "./services/insert_data_no_fac.php__?area=" + area + "&informe=" + informe,
      true
    );
  } else if (informe === "Fac_Ord_Venta") {
    // peticion_http.open("POST","ventas_cuota_new.php?area=" +area +"&informe=" +informe ,true);
    peticion_http.open(
      "POST",
      "./services/insert_data_no_fac_mes__.php?area=" + area + "&informe=" + informe,
      true
    );
    // console.log("fac  ord");
  }

  // Realizar peticion HTTP
  peticion_http.open(
    "POST",
    "./controller/insert_data_no_fac_mes__.php?area=" + area + "&informe=" + informe,
    true
  );
  peticion_http.send(null);

  function muestraContenido() {
    if (peticion_http.readyState == 4) {
      if (peticion_http.status == 200) {
        var dato = peticion_http.responseText;
        console.clear();
        console.log(dato);
        // document.body.style.cursor = 'auto';
      }
    } else {
      console.log("Cargando...");
    }
  }
}
