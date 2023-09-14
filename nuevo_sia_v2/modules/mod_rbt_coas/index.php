<?php

header('Access-Control-Allow-Origin: *');
// echo "<script src='../../assets/js/funciones.js'></script> ";
// http://192.168.1.115/nuevo_sia_v2/modules/mod_rbt_coas/
// http://190.25.224.2/coaspharma/mod_seguridad/ingreso_intranet.php
// 860069284
// 123
$nit = 860069284;
define ('URL_COAS','http://190.25.224.2/coaspharma/mod_seguridad/portal_web.php');
define ('URL_COAS2',"http://190.25.224.2/coaspharma/sima/consulta_pedidos.php?dato1=$nit&usuario=$nit");

// echo "<button onclick=\"exportar_excelss('tbl_coas');\">Conuslta</button>";
// echo "<button onclick=\"tabla();\">TBLA </button>";

// echo URL_COA2;
$texto = file_get_contents(URL_COAS2);
// echo "<div class='pedidos_all' id='pedidos_all' name='pedidos_all'>
// Info
// </div> ";

echo $texto;




// echo "<a href='".URL_COA2."' target='_blank'> COAS</a> <br>";

?>
<script>
    const tbl_coas = document.getElementsByTagName("table");
    tbl_coas[1].remove();
    tbl_coas[1].setAttribute("id","tbl_coas");
    // console.log(tbl_coas[1]);


    function exportar_excelss(nombre_tabla, nombre_archivo = '') {
  let descarga_enlace;
  let data_type = 'application/vnd.ms-excel';
  let table_select = document.getElementById(nombre_tabla);

  //   let tabla_html = table_select.outerHTML.replaceAll(/ /g, '%20');
  let tabla_html = table_select.outerHTML.replaceAll('%20','');
  console.log(tabla_html);

  /** se establece la hora actual del sistema para asignar y ver la generacion del informe */
  let hoy = new Date();
  let fecha_actual = hoy.getDate() + '_' + (hoy.getMonth() + 1) + '_' + hoy.getFullYear();

  //  SE LE ASIGNA UN NOMBRE SI NO TIENE 
//   nombre_archivo = nombre_archivo ? nombre_archivo + '.xls' : 'Informe-mes-' + fecha_actual + '.xlsx';
  nombre_archivo = nombre_archivo ? nombre_archivo + '.csv' : 'PAGINA_COAS_' + fecha_actual + '.txt';
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


</script>