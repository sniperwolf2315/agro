<!DOCTYPE html>
<html>

<head>
    <?php
    if (session_start() === FALSE) {
        session_start();
    }
    //OR $_SESSION['clAVe'] == ''
    if ($_SESSION['usuARio'] == '') {
        header("location:user_conect_odoo.php");
        die;
    }

    header("location:user_conect_odoo.php");
    require_once('Admin_users.php');
    include('user_con.php');
    include('general_functions.php');

    //VERIFICA VISUAL BOTONES
    //$btnPrim=explode("^",$_SESSION['verbtnP']);
    //$btnSecu=explode("^",$_SESSION['verbtnS']);

    $btnPrim = $_SESSION['verbtnP'];
    $btnSecu = $_SESSION['verbtnS'];

    /*
$verboton = strpos($btnPrim, '');
if($verboton !== FALSE){
    //muestra boton
}
$verboton = strpos($btnSecu, '');
if($verboton !== FALSE){
    //muestra boton
}  
*/
    //$Mp=0; //nivel 1
    //$Ms=0; // nivel 2


    ?>

    <!-- Let browser know website is optimized for mobile-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
    <!-- Import Google Icon Font-->
    <!-- Import materialize.css-->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" /> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1" />-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />


    <script language="JavaScript">
        var ruta_gerencia = 'http://sia.agrocampo.vip/modulo_odoo/Informes/index_des.php';


        var conta = 0;
        var consul = '';
        var display_yes = 'block';
        var display_not = 'none';




        function Solo_Numerico(variable) {
            Numer = parseInt(variable);
            if (isNaN(Numer)) {
                return "";
            }
            return Numer;
        }

        function ValNumero(Control) {
            Control.value = Solo_Numerico(Control.value);
        }


        function Popup(valor) {
            var windowName = 'userConsole';
            var popUp = window.open(valor, '_blank', '');
            if (popUp == null || typeof(popUp) == 'undefined') {
                alert('Por favor deshabilita el bloqueador de ventanas emergentes.');
            } else {
                popUp.focus();
            }
        }

        function verLink(valor) {
            document.getElementById('estado').innerHTML = '<a href="' + valor + '" target="_new"><h4>Descargar Informe</h4></a>';
        }

        function verLink2(valor) {
            document.getElementById('infcom').innerHTML = '<a href="' + valor + '" target="_new"><h4>Descargar Informe</h4></a>';
        }

        function GenerarReporteXLS() {
            document.getElementById('formu').innerHTML = '<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest

            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
            peticion_http.open('POST', 'generareportexcel.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        //alert(dato);
                        verLink(dato);
                        document.getElementById('formu').innerHTML = '';
                        alert('Informe generado correctamente. Puede descargarlo mediante el link');
                    }
                }
            }

        }

        function activarUsbtnP(cedu, nombre, usuario, bt1, tipomenu, estadm) {
            alert(nombre);
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Admin/editarPermisobtnP.php?c=' + cedu + '&n=' + nombre + '&u=' + usuario + '&b=' + bt1 + '&t=' + tipomenu + '&e=' + estadm, false);
            peticion_http.send(null);

            function muestraContenido() {

                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        alert(dato);
                        //setTimeout("location.reload(true);", 200);
                    }
                }
            }
            return true;
        }

        function buscarBotonesSec(botonp, titulo, estado, login, nom, cc, tipom) {
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            //return false;
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Admin/buscarbotons.php?btp=' + botonp + '&t=' + titulo + '&c=' + cc + '&n=' + nom + '&u=' + login, true);
            //peticion_http.open('POST', 'Admin/buscarbotons.php?btp=' + botonp + '&t=' + titulo, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert('a');
                if (peticion_http.readyState == 4) {
                    //alert('b');
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.getElementById('verbotons').innerHTML = dato;

                        //ACTIVAR O DESACTIVAR
                        var opcion = confirm("Desea y esta seguro(a) de activar este boton?");
                        if (opcion == true) {
                            //alert('----' + opcion + cc);
                            activarUsbtnP(cc, nom, login, botonp, tipom, estado);
                        }
                        document.body.style.cursor = 'auto';
                    }
                }
            }
        }


        function buscarDatos1() {
            var ano = document.getElementById('Anio').value;
            var mes = document.getElementById('Mes').value;
            var periodo = ano + mes;
            if (mes.length < 2) {
                alert("El mes debe tener min 2 cifras");
                return false;
            }
            if (ano.length < 4) {
                alert("El a�o debe tener min 4 cifras");
                return false;
            }
            if (periodo != "") {
                document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscardatos1.php?periodo=' + periodo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert('COMPLETADO..');
                            //INFORME_COMPRAS_VENTAS_MES.pdf
                            document.getElementById('estado').innerHTML = '';
                            verLink('INFORME_COMPRAS_VENTAS_MES.pdf');
                            document.getElementById('estado').innerHTML = 'LISTO';
                            document.body.style.cursor = 'auto';
                            //document.getElementById('refer').value = dato;
                        }
                    }
                }
            } else {
                alert('Digite a�o y mes');
            }

        }

        function buscarDatos2() {
            var ano = document.getElementById('Anio').value;
            var mes = document.getElementById('Mes').value;
            var periodo = ano + mes;
            if (mes.length < 2) {
                alert("El mes debe tener min 2 cifras");
                return false;
            }
            if (ano.length < 4) {
                alert("El a�o debe tener min 4 cifras");
                return false;
            }
            if (periodo != "") {
                document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscardatos2.php?periodo=' + periodo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert('COMPLETADO..');
                            //INFORME_COMPRAS_VENTAS_MES.pdf
                            document.getElementById('estado').innerHTML = '';
                            verLink('INFORME_COMPRAS_VENTAS_MES_ACUMULADO.pdf');
                            //document.getElementById('estado').innerHTML='LISTO';
                            document.body.style.cursor = 'auto';
                            //document.getElementById('refer').value = dato;
                        }
                    }
                }
            } else {
                alert('Digite a�o y mes');
            }

        }

        function buscarDatos3() {
            var ano = document.getElementById('Anio').value;
            var mes = document.getElementById('Mes').value;
            var periodo = ano + mes;
            if (mes.length < 2) {
                alert("El mes debe tener min 2 cifras");
                return false;
            }
            if (ano.length < 4) {
                alert("El a�o debe tener min 4 cifras");
                return false;
            }
            if (periodo != "") {
                document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscardatos3.php?periodo=' + periodo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert('COMPLETADO..');
                            //INFORME_COMPRAS_VENTAS_MES.pdf
                            document.getElementById('estado').innerHTML = '';
                            verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT.pdf');
                            //document.getElementById('estado').innerHTML='LISTO';
                            document.body.style.cursor = 'auto';
                            //document.getElementById('refer').value = dato;
                        }
                    }
                }
            } else {
                alert('Digite a�o y mes');
            }

        }

        function buscarDatos4() {
            var ano = document.getElementById('Anio').value;
            var mes = document.getElementById('Mes').value;
            var periodo = ano + mes;
            if (mes.length < 2) {
                alert("El mes debe tener min 2 cifras");
                return false;
            }
            if (ano.length < 4) {
                alert("El a�o debe tener min 4 cifras");
                return false;
            }
            if (periodo != "") {
                document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                peticion_http.open('POST', 'buscardatos4.php?periodo=' + periodo, true);
                peticion_http.send(null);

                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert('COMPLETADO..');
                            //INFORME_COMPRAS_VENTAS_MES.pdf
                            document.getElementById('estado').innerHTML = '';
                            verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT_ACUMULADO.pdf');
                            //document.getElementById('estado').innerHTML='LISTO';
                            document.body.style.cursor = 'auto';
                            //document.getElementById('refer').value = dato;
                        }
                    }
                }
            } else {
                alert('Digite a�o y mes');
            }
        }

        function buscarDatosMA() {
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'buscardatosMA.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        alert(dato + 'COMPLETADO..');
                        //INFORME_COMPRAS_VENTAS_MES.pdf
                        document.getElementById('estado').innerHTML = '';
                        //verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT_ACUMULADO.pdf');
                        //document.getElementById('estado').innerHTML='LISTO';
                        document.body.style.cursor = 'auto';
                        //document.getElementById('refer').value = dato;
                    }
                }
            }
            //}else{
            //    alert('Digite a�o y mes');
            //}      
        }

        function buscarDatosMAInv() {
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'buscardatosMAInv.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        alert('COMPLETADO..');
                        //INFORME_COMPRAS_VENTAS_MES.pdf
                        document.getElementById('estado').innerHTML = '';
                        //verLink('INFORME_VENTAS_MES_ANIOACT_VS_ANIOANT_ACUMULADO.pdf');
                        //document.getElementById('estado').innerHTML='LISTO';
                        document.body.style.cursor = 'auto';
                        //document.getElementById('refer').value = dato;
                    }
                }
            }
            //}else{
            //    alert('Digite a�o y mes');
            //}      
        }

        function Guardar_Vista() {
            var mes = document.getElementById('m').value;
            var ano = document.getElementById('a').value;
            var diai = document.getElementById('di').value;
            var diaf = document.getElementById('df').value;
            //var vista=document.getElementById('v').value;
            var periodo = ano + mes;
            if (periodo != "") {
                document.getElementById('formu').innerHTML = '<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest

                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                peticion_http.onreadystatechange = muestraContenido;
                // Realizar peticion HTTP
                //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
                peticion_http.open('POST', 'algo.php?p=' + periodo + '&diai=' + diai + '&diaf=' + diaf, true);
                peticion_http.send(null);

                function muestraContenido() {
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert(dato);
                            document.getElementById('formu').innerHTML = '';
                            document.body.style.cursor = 'auto';
                        }
                    }
                }
            } else {
                alert('Seleccione mes, a�o y vista');
            }
        }

        function Guardar_Grupo() {
            var grupo = document.getElementById('grupo').value;
            var manejador = document.getElementById('maneja').value;
            var categoria = document.getElementById('Categoria').value;
            if (grupo == "") {
                alert('Digite el Grupo');
                return false;
            }
            if (manejador == "") {
                alert('Seleccione un manejador');
                return false;
            }
            if (categoria == "") {
                alert('Digite una categoria');
                return false;
            }

            document.getElementById('formu').innerHTML = '<center><img class="responsive-img circle responsive-img center" src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            //peticion_http.open('POST', 'guardarvista.php?periodo=' + periodo + '&vista=' & vista, true);
            peticion_http.open('POST', 'grupos.php?g=' + grupo + '&m=' + manejador + '&c=' + categoria, true);
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        alert(dato);
                        document.getElementById('formu').innerHTML = '';
                        document.body.style.cursor = 'auto';
                    }
                }
            }
        }

        function buscarIngresoMercanciaP() {

            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('Carguesi').style.visibility = 'visible';

            let anio, mes, tipo_consulta, anio_hasta, mes_hasta;
            var ejecutar_por = document.getElementById('Por_Fechas').value;
            var fec_desde = document.getElementById('desde').value;
            var fec_hasta = document.getElementById('hasta').value;

            if (ejecutar_por === '' || ejecutar_por === null || ejecutar_por === undefined) { //VALIDAR SI LA OPCION TIENE VALOR VACIO
                alert("¡Por Favor seleccione un metodo de ejecución!");
                return;

            } else {

                if (ejecutar_por !== 'Por_Fechas' && ejecutar_por !== '') {
                    anio = ejecutar_por.substring(0, 4);
                    mes = ejecutar_por.substring(4.2);
                    tipo_consulta = 'normal';

                } else if (ejecutar_por === 'Por_Fechas') {

                    dia_desde = clear_date(fec_desde, 'dia');
                    dia_hasta = clear_date(fec_hasta, 'dia_hasta');
                    anio = clear_date(fec_desde, 'anio');
                    mes = clear_date(fec_desde, 'mes');
                    anio_hasta = clear_date(fec_hasta, 'anio_hasta');
                    mes_hasta = clear_date(fec_hasta, 'mes_hasta');
                    tipo_consulta = 'rangos';
                } else {
                    console.log('no cumple');
                    return;
                }
            }

            document.body.style.cursor = 'wait';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';

            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            // Realizar peticion HTTP validando el tripo de consulta
            if (tipo_consulta === 'normal') {
                peticion_http.open('POST', 'buscarIngresoMercanciaP.php?a=' + anio + '&m=' + mes + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', 'buscarIngresoMercanciaP.php?a=' + anio + '&m=' + mes + '&ah=' + anio_hasta + '&mh=' + mes_hasta + '&d=' + dia_desde + '&dh=' + dia_hasta + '&tc=' + tipo_consulta, true);
            }
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }


        function Ord_pendientesP() {
            document.getElementById('tiempo').style.visibility = 'visible';
            //document.getElementById('respuesta').innerHTML='';
            //document.getElementById('formuF').style.visibility='hidden';

            //var anio=document.getElementById('Anio').value;
            //var mes=document.getElementById('Mes').value;
            document.getElementById('Carguesi').style.visibility = 'visible';
            var tiempo = document.getElementById('tiempo').value;
            if (tiempo == "") {
                alert("Seleccione una Busqueda");
                return;
            }


            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            //alert("aqui" + tiempo);
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP

            // Realizar peticion HTTP
            if (tiempo == 'general') {
                peticion_http.open('POST', 'Ord/Ord_pendientesP.php?t=' + tiempo, true);
            }
            if (tiempo == 'progreso') {
                peticion_http.open('POST', 'Ord/Ord_ProgresoP.php?t=' + tiempo, true);
            }
            if (tiempo == 'ganaderia') {
                peticion_http.open('POST', 'Ord/Ord_GanaderiaP.php?t=' + tiempo, true);
            }
            if (tiempo == 'cancelado') {
                peticion_http.open('POST', 'Ord/Ord_CanceladoP.php?t=' + tiempo, true);
            }
            if (tiempo == 'transferido') {
                peticion_http.open('POST', 'Ord/Ord_TransferidoP.php?t=' + tiempo, true);
            }
            if (tiempo == 'pets') {
                peticion_http.open('POST', 'Ord/Ord_PetsP.php?t=' + tiempo, true);
            }
            if (tiempo == 'laboratorios') {
                peticion_http.open('POST', 'Ord/Ord_LaboratoriosP.php?t=' + tiempo, true);
            }
            peticion_http.send(null);
            //peticion_http.open('POST', 'Ord_pendientesP.php?t=' + tiempo,  true);
            //peticion_http.send(null);
            //alert("aqui");
            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }

        function Ord_pendientesA() {
            document.getElementById('respuesta').innerHTML = '';
            //include('../conectarbase.php');
            document.getElementById('Carguesi').style.visibility = 'visible';
            //document.getElementById('formuF').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            //var anio=document.getElementById('tiempo').value;
            //var anio=document.getElementById('Anio').value;
            //var mes=document.getElementById('Mes').value;
            var tiempo = document.getElementById('tiempo').value;
            if (tiempo == "") {
                alert("Seleccione una Busqueda");
                return false;
            }
            //alert("aqui" + tiempo);
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP

            // Realizar peticion HTTP
            if (tiempo == 'General') {
                peticion_http.open('POST', 'Ord/Ord_pendientesA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Progreso') {
                peticion_http.open('POST', 'Ord/Ord_ProgresoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'GANADERIA') {
                peticion_http.open('POST', 'Ord/Ord_GanaderiaA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Cancelado') {
                peticion_http.open('POST', 'Ord/Ord_CanceladoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Transferido') {
                peticion_http.open('POST', 'Ord/Ord_TransferidoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'PETS') {
                peticion_http.open('POST', 'Ord/Ord_PetsA.php?t=' + tiempo, true);
            }
            if (tiempo == 'LABORATORIOS') {
                peticion_http.open('POST', 'Ord/Ord_LaboratoriosA.php?t=' + tiempo, true);
            }
            peticion_http.send(null);
            //peticion_http.open('POST', 'Ord_pendientesP.php?t=' + tiempo,  true);
            //peticion_http.send(null);
            //alert("aqui");
            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }

        function MinHacienda() {

            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';

            //document.getElementById('Carguesi').style.visibility='visible';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP

            peticion_http.open('POST', 'minhacienda/ventasSinIva.php', true); //f='+ $fecha,
            peticion_http.send(null);
            //alert("aqui");
            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }

        function buscarIngresoMercanciaA() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/

            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('Carguesi').style.visibility = 'visible';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            /*var texto='';
             texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
             document.getElementById('respuesta').innerHTML=texto;
            */
            //document.getElementById('formuF').style.visibility='hidden';
            // var anio = document.getElementById('Anio').value;
            // var mes = document.getElementById('Mes').value;
            var anio, mes;
            if (anio == "") {
                alert("Digite un a�o");
                return false;
            }
            if (mes == "") {
                alert("Digite un mes");
                return false;
            }
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'buscarIngresoMercanciaA.php?a=' + anio + '&m=' + mes, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
            document.getElementById('frmbuscar').innerHTML = '';
        }
        ///Categorizaci�n Credito y Cartera. Consulta del cliente **busqueda general
        function Inf_Cre_Car() {
            //var cedu=document.getElementById('Cedula').value;
            document.getElementById('Carguesi').style.visibility = 'visible';
            //document.getElementById('formuF').style.visibility='hidden';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/

            /*var texto='';
             texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
             texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
             document.getElementById('respuesta').innerHTML=texto;
            */
            //document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').value = '';
                    }
                }
            }
        }
        //Perfil del cliente:
        function Cre_Car_perfileria() {
            var cedu = document.getElementById('Cedula').value;
            //document.getElementById('cartera1').style.visibility='visible';
            //document.getElementById('formuF').style.visibility='hidden';
            //document.getElementById('respuesta').style.visibility='hidden';
            //document.getElementById('cartera1').style.visibility='visible';
            //document.getElementById('cartera2').style.visibility='visible';
            //document.getElementById('cartera3').style.visibility='visible';
            //document.getElementById('cartera4').style.visibility='visible';
            //document.getElementById('cartera5').style.visibility='visible';
            document.getElementById('Carguesi').value = 'Espere por favor....'; //.style.visibility='visible';
            document.getElementById('estado').style.visibility = 'visible';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';

            if (cedu === '') {
                alert("Por Favor ingrese un documento válido");
                return
            }

            var texto = '';
            texto = texto + `
            <div class="col s4" id="formuF"></div>                                                                                                     
            <div class="col s4" id="Orden_P"></div>                                                                                                    
            <div id="cartera1" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>  
            <div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>     
            <div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>     
            <div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>     
            <div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>     
            <div id="cartera6" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>     
            `;
            document.getElementById('respuesta').innerHTML = texto;


            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Cre_Car_perfileria.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';

                        document.getElementById('cartera1').innerHTML = dato;
                        Inf_Cre_Car_Cliente();
                    }
                }
            }
        }
        //Cartera Por Cliente:
        function Inf_Cre_Car_Cliente() {
            // document.getElementById('respuesta').innerHTML='';
            //document.getElementById('cartera2').style.visibility='visible';
            //document.getElementById('formuF').style.visibility='hidden';
            //document.getElementById('cartera1').style.visibility='hidden';


            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';

            var cedu = document.getElementById('Cedula').value;


            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car_Cliente.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('cartera2').innerHTML = dato;
                        Inf_Cre_Car_Ventas();
                    }
                }
            }
        }
        //Facturas de venta del cliente:
        function Inf_Cre_Car_Ventas() {
            //document.getElementById('respuesta').innerHTML='';
            var cedu = document.getElementById('Cedula').value;
            //alert("aqui");
            //document.getElementById('cartera3').style.visibility='visible';
            //document.getElementById('formuF').style.visibility='hidden';
            //document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car_Ventas.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('cartera3').innerHTML = dato;
                        Inf_Cre_Car_Rec_Caja();
                        //document.getElementById('formuF').style.visibility='hidden';
                    }
                }
            }
        }
        //Facturas de caja del cliente:
        function Inf_Cre_Car_Rec_Caja() {
            var cedu = document.getElementById('Cedula').value;
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car_Rec_Caja.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('cartera4').innerHTML = dato;
                        Inf_Cre_Car_Fac_Abi();
                    }
                }
            }
        }
        //facturas en estado abierta
        function Inf_Cre_Car_Fac_Abi() {
            var cedu = document.getElementById('Cedula').value;

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car_Fac_Abi.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('cartera5').innerHTML = dato;
                        Inf_Cre_Car_Not_Abi();
                    }
                }
            }
        }

        //Notas en estado abierto
        function Inf_Cre_Car_Not_Abi() {
            //document.getElementById('respuesta').innerHTML='';
            var cedu = document.getElementById('Cedula').value;
            //alert("aqui");
            //document.getElementById('cartera4').style.visibility='visible';
            //document.getElementById('formuF').style.visibility='hidden';
            //document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Inf_Cre_Car/Inf_Cre_Car_Not_Abi.php?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('cartera6').innerHTML = dato;
                        //Inf_Cre_Car_Fac_Abi();
                        //document.getElementById('formuF').style.visibility='hidden';
                    }
                }
            }
            // document.getElementById('frmbuscar').innerHTML = '';
        }

        function buscarExistenciasMercanciaP() {
            let tipo_consulta = 'simple';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('Carguesi').style.visibility = 'visible';
            /*
            var texto='';
            texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
            */

            /* #╬  CAPTURAR EL VALOR DE LOS COMPONENTE POR_FECHA y fecha desde y fecha hasta  */
            /* TODO: habilitar si se requiere filtrar por fechas.  
           
           dom_por_fechas = document.getElementById('Por_Fechas').value;
            fec_desde = document.getElementById('desde').value;
            fec_hasta = document.getElementById('hasta').value;
            let anio, mes, dia, anio_hasta, mes_hasta, dia_hasta, tipo_consulta;

            if (dom_por_fechas === '') {
                alert("¡Por favor ingresar un tipo de consulta!");
                return;
            } else {
                if (dom_por_fechas !== '' && dom_por_fechas !== 'Por_Fechas') {
                    anio = clear_date(dom_por_fechas, 'anio');
                    mes = clear_date(dom_por_fechas, 'mes');
                    tipo_consulta = 'normal';
                    // console.log(anio + ' ' + mes + ' ' + tipo_consulta);
                } else if (dom_por_fechas === 'Por_Fechas') {
                    anio = clear_date(fec_desde, 'anio');
                    mes = clear_date(fec_desde, 'mes');
                    dia = clear_date(fec_desde, 'dia');

                    anio_hasta = clear_date(fec_hasta, 'anio_hasta');
                    mes_hasta = clear_date(fec_hasta, 'mes_hasta');
                    dia_hasta = clear_date(fec_hasta, 'dia_hasta');
                    tipo_consulta = 'rangos';
                }

            } */


            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            // Realizar peticion HTTP
            if (tipo_consulta === 'normal') {
                peticion_http.open('POST', 'buscarExistenciasMercanciaP.php?a=' + anio + '&m=' + mes + '&d' + dia + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', 'buscarExistenciasMercanciaP.php?a=' + anio + '&m=' + mes + '&d' + dia + '&ah=' + anio_hasta + '&mh=' + mes_hasta + '&dh' + dia_hasta + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'simple') {
                peticion_http.open('POST', 'buscarExistenciasMercanciaP.php', true);
            }
            peticion_http.send(null);

            /*  #╬  SE CAMBIA EL CONTENIDO DEL DIV id = estado POR IMAGEN DE CAGUE  */
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';


            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }

        function buscarExistenciasMercanciaA() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            /*var texto='';
            texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
            document.getElementById('respuesta').innerHTML=texto;
            */
            document.getElementById('Carguesi').style.visibility = 'visible';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'buscarExistenciasMercanciaA.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }

        function campos_en_blanco() {
            document.getElementById('Pqr').value = '';
        }

        function asignar_valor() {
            document.getElementById("Pqr").value = 'PQR-';
        }

        function formulario_control(exec_function, txt_title, ruta_reporte, con_doc = 'no') {

            document.getElementById('respuesta').style.visibility = 'hidden';
            document.getElementById('Carguesi').style.visibility = 'hidden';
            dom_respuesta = document.getElementById('respuesta');
            dom_frmbuscar = document.getElementById('frmbuscar');

            texto_html = `
            <div class="flow-text #439049 green darken-1" style="width:40%; font-size:1.5vw;text-align:center;color:white;">
                ${txt_title }
            </div>
            <div  style=" width:40%;">
                <table class="input-field col s3">
              `;
            if (con_doc === 'si') {
                texto_html = texto_html + `
                    <tr>
                        <input id="Pqr" placeholder="INGRESE NO. DOCUMENTO O UNA PQR-" value="PQR-"maxlength="15" type="text" class="validate" keyup="${exec_function}('${ruta_reporte}')"   style="background-color: white; font-size: 1.4em; text-align: center;"   />               
                    </tr>
                    O
                `;
            }

            texto_html = texto_html + ` 
                    <tr>
                       <td>
                         <?php id_periodo(0) ?>
                        </td>
                    </tr>
                    <tr>
                        <?php rangos_fechas(0) ?>
                    </tr>
                    </table>
                    <center>
                        <button type="submit" onclick="${exec_function}('${ruta_reporte}');" class="waves-efect waves-light btn #E67402 orange darken-1">
                             BUSCAR
                        </button>
                    </center>
            </div>
                        `;
            dom_frmbuscar.innerHTML = texto_html;
        }




        function consultar_informe(ruta_reporte) {

            var ruta_reporte_final = ruta_reporte;
            var anio_d, mes_d, dia_d, anio_h, mes_h, dia_h, tipo_consulta;
            var option_period = document.getElementById('Por_Fechas').value;
            var fec_desde = document.getElementById('desde').value;
            var fec_hasta = document.getElementById('hasta').value;
            var pqr_val = document.getElementById('Pqr').value;


            document.getElementById('respuesta').style.visibility = 'visible';



            if (pqr_val === '' && option_period === '') {
                alert("Por favor ingresar un No. de documento o una opción de la lista.");
                return;
            } else if (pqr_val !== '') {
                pqr_val = pqr_val;
                tipo_consulta = 'pqr';

            } else if (option_period === 'Por_Fechas') {
                anio_d = clear_date(fec_desde, 'anio');
                mes_d = clear_date(fec_desde, 'mes');
                dia_d = clear_date(fec_desde, 'dia');

                anio_h = clear_date(fec_hasta, 'anio_hasta');
                mes_h = clear_date(fec_hasta, 'mes_hasta');
                dia_h = clear_date(fec_hasta, 'dia_hasta');

                tipo_consulta = 'rangos';

            } else if (option_period !== 'Por_Fechas' && option_period !== ' ') {
                anio_d = clear_date(option_period, 'anio')
                mes_d = clear_date(option_period, 'mes')
                tipo_consulta = 'normal';

            } else {
                return;
            }

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            console.log(tipo_consulta);
            if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', ruta_reporte_final.toString() + '.php?a=' + anio_d + '&m=' + mes_d + '&d=' + dia_d + '&ah=' + anio_h + '&mh=' + mes_h + '&dh=' + dia_h + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'normal' && pqr_val === '') {
                peticion_http.open('POST', ruta_reporte_final.toString() + '.php?a=' + anio_d + '&m=' + mes_d + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'pqr' && pqr_val !== '' || pqr_val.length > 0) {
                peticion_http.open('POST', ruta_reporte_final.toString() + '.php?p=' + pqr_val + '&tc=' + tipo_consulta, true);
            } else {
                document.getElementById('estado').innerHTML = '¡No pasó!';
                document.body.style.cursor = '';
                console.log("No paso ");
                return;
            }

            // Realizar peticion HTTP
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }

        }















        function buscarSalidaMercanciaP() {
            // document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'hidden';
            document.getElementById('Carguesi').style.visibility = 'visible';


            dom_por_fechas = document.getElementById('Por_Fechas').value;
            fec_desde = document.getElementById('desde').value;
            fec_hasta = document.getElementById('hasta').value;
            let tipo_consulta, anio, mes, dia, anio_hasta, mes_hasta, dia_hasta;

            if (dom_por_fechas === '') {
                alert("Por elija un periodo o por fechas");
                return;
            } else if (dom_por_fechas !== 'Por_Fechas' && dom_por_fechas !== '') {
                anio = clear_date(dom_por_fechas, 'anio');
                mes = clear_date(dom_por_fechas, 'mes');
                dia = clear_date(dom_por_fechas, 'dia');
                tipo_consulta = 'normal';

            } else if (dom_por_fechas === 'Por_Fechas') {
                anio = clear_date(fec_desde, 'anio');
                mes = clear_date(fec_desde, 'mes');
                dia = clear_date(fec_desde, 'dia');
                anio_hasta = clear_date(fec_hasta, 'anio_hasta');
                mes_hasta = clear_date(fec_hasta, 'mes_hasta');
                dia_hasta = clear_date(fec_hasta, 'dia_hasta');
                tipo_consulta = 'rangos';

            } else {
                alert("no hay parametros validos");
                return;
            }
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';

            //# Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            //# Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            //# Realizar peticion HTTP
            if (tipo_consulta === 'normal' && tipo_consulta !== '') {
                peticion_http.open('POST', 'buscarSalidaMercanciaP.php?a=' + anio + '&m=' + mes + '&d=' + dia + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', 'buscarSalidaMercanciaP.php?a=' + anio + '&m=' + mes + '&d=' + dia + '&ah=' + anio_hasta + '&mh=' + mes_hasta + '&dh=' + dia_hasta + '&tc=' + tipo_consulta, true);
            } else {
                document.getElementById('respuesta').innerHTML = 'Error en el proceso';
                return;
            }
            peticion_http.send(null);
            muestraContenido(peticion_http);
            document.getElementById('respuesta').style.visibility = 'visible';

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('respuesta').style.visibility = 'visible';
                        document.getElementById('Carguesi').style.visibility = 'visible';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.body.style.cursor = '';
                    }
                }
            }
        }




        function buscarSalidaMercanciaA() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            /*var texto='';
            texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
            texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
            document.getElementById('respuesta').innerHTML=texto;
            */
            document.getElementById('Carguesi').style.visibility = 'visible';
            //document.getElementById('estado').innerHTML='<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'buscarSalidaMercanciaA.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }

        function Cod_Producto_Bus() {
            document.getElementById('parametros').style.visibility = 'visible';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('Carguesi').style.visibility = 'visible';


            var Bodega = document.getElementById('Bodega').value;
            var Cod_Pro_Bus = document.getElementById('Producto').value;

            if (Bodega == "" && Cod_Pro_Bus.length === 0) {
                alert("¡Por favor llenar los campos bodega  y producto !");
                return false;
            } else if (Bodega == "") {
                alert("¡Por favor seleccionar una bodega!");
                return false;
            }


            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Bus_Pro/Cod_Producto_Bus.php?pc=' + Cod_Pro_Bus + '&b=' + Bodega, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }



        function Inf_Mes_Com() {
            var tipo_consulta;
            var periodo;

            var anio, mes;
            // var anio = document.getElementById('anio').value;
            // var mes = document.getElementById('Mes').value;
            var fec_desde = document.getElementById('desde').value;
            var ejecutar_por = document.getElementById('Por_Fechas').value;
            var fec_hasta = document.getElementById('hasta').value;
            document.getElementById('infcom').innerHTML = '';



            if (ejecutar_por == "" || ejecutar_por == undefined) {
                alert("Por favor elejir un periodo ");

                return
            }
            if (ejecutar_por === 'anio_mes') {
                if (anio == "" && mes == "" && ejecutar_por == "") {
                    alert("Por favor diligenciar Año y Mes");
                    return;
                } else if (mes == "") {
                    alert("Digite un mes");
                    return;
                } else if (anio == "") {
                    alert("Digite un a�o");
                    return;
                } else {
                    anio = anio;
                    mes = mes;
                    periodo = anio + mes;
                    tipo_consulta = 'normal';
                }
            } else if (ejecutar_por === 'Por_Fechas') {
                // anio_desde = desde.replace(/-/g, "").substring(0, 6).substring(0, 4);
                // anio_hasta = hasta.replace(/-/g, "").substring(0, 6).substring(0, 4);
                anio_desde = desde.toString().replace(/-/g, "").substring(0, 6).substring(0, 4);
                anio_hasta = hasta.toString().replace(/-/g, "").substring(0, 6).substring(0, 4);
                mes_desde = desde.toString().replace(/-/g, "").substring(0, 6).slice(-2);
                mes_hasta = hasta.toString().replace(/-/g, "").substring(0, 6).slice(-2);
                tipo_consulta = 'rangos';


            } else if (ejecutar_por !== '' ||
                ejecutar_por !== 'Por_Fechas' ||
                ejecutar_por !== 'anio_mes') {

                periodo = ejecutar_por;
                tipo_consulta = 'normal';
            }


            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            // validar el tipo de consulta y realizar peticion HTTP

            if (tipo_consulta === 'normal') {
                peticion_http.open('POST', 'mescom/cuotageneral.php?periodo=' + periodo + '&category=' + tipo_consulta, true);
            } else if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', 'mescom/cuotageneral.php?periodo=' + periodo + '&fd=' + fec_desde + '&fh=' + fec_hasta + '&category=' + tipo_consulta, true);
            } else {
                peticion_http.open('POST', 'mescom/cuotageneral.php?periodo=' + periodo + '&category=' + tipo_consulta, true);
            }
            peticion_http.send(null);

            function muestraContenido() {

                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        Inf_Mes_Com_Labs(periodo);
                    }
                }
            }
            //document.getElementById('parametros').innerHTML='';  
        }

        //laboratorios informe mes comercial
        function Inf_Mes_Com_Labs(periodolab) {
            var periodo = periodolab;

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'mescom/cuotaslaboratorios.php?periodo=' + periodo, true);
            peticion_http.send(null);

            function muestraContenido() {

                if (peticion_http.readyState == 4) {
                    //alert(1);
                    if (peticion_http.status == 200) {
                        //alert(2);
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //carga ventas
                        Inf_Mes_Com_Vemtas(periodo);
                    }
                }
            }
            //document.getElementById('parametros').innerHTML='';  
        }

        function Inf_Mes_Com_Vemtas(periodolab) {
            var periodo = periodolab;

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'mescom/ventas2.php?periodo=' + periodo, true);
            peticion_http.send(null);

            function muestraContenido() {

                if (peticion_http.readyState == 4) {
                    //alert(1);
                    if (peticion_http.status == 200) {
                        //alert(2);
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //genera el informe mes comercial
                        Inf_Mes_Com_InformeXls(periodo);
                    }
                }
            }
            //document.getElementById('parametros').innerHTML='';  
        }

        //genera el archivo xls del informe mes comercial
        function Inf_Mes_Com_InformeXls(periodolab) {
            var periodo = periodolab;

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'mescom/cargardatosxls.php?periodo=' + periodo, true);
            peticion_http.send(null);

            function muestraContenido() {

                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = '';
                        dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        verLink2('mescom/' + dato);
                    }
                }
            }
        }

        function CREDITOCAR() {
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';

            texto = '';
            texto = texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:left; color: #439049;"><b>CATEGORIZACION CREDITO Y CARTERA</b></div>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Boto_cartera();">INFORME CATEGORIZACION CREDITO Y CARTERA</a>&nbsp;&nbsp;&nbsp;';
            document.getElementById('parametros').innerHTML = texto;

            return true;

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<center>';  
            //texto=texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosDec551();">MIN-HACIENDA</a>&nbsp;&nbsp;&nbsp;';
            //document.getElementById('formuF').style.visibility='hidden';
            //texto=texto + '</center>';

            //document.getElementById('cartera1').style.visibility='hidden';
            //document.getElementById('parametros').innerHTML='';
        }
        //Boton de gerencia.



        function Gerencia_Ven() {

            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';

            texto = '';
            texto = texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:left; color: #439049;"><span class="info_route">Gerencia / </span><b>COMPRAS Y VENTAS</b></div>';
            <?php
            $verboton = strpos($btnSecu, '4A');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gerencia_Ven_F(); Get_date();">Informe Compras y Ventas</a>&nbsp;&nbsp;&nbsp;';

            <?php
            }
            $verboton = strpos($btnSecu, '4B');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gerencia_Ven_A();">Informe Varios Almacen</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '4C');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gerencia_Mes_Com();">Informe Mes Comercial</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }

            ?>


            //texto=texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosDec551();">MIN-HACIENDA</a>&nbsp;&nbsp;&nbsp;';
            document.getElementById('formu').innerHTML = texto;
            document.getElementById('parametros').innerHTML = '';
            return true;
        }

        //INFORME MES COMERCIAL
        function Gerencia_Mes_Com() {
            //document.getElementById('Orden_P').style.visibility='hidden';
            //document.getElementById('formuF').style.visibility='visible';


            texto = '';
            document.getElementById('parametros').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = '';
            texto = `
            <div class="flow-text #439049 green darken-1" style="width:400px; font-size:1.5vw;text-align:center;color:white;">
                Informe Ventas Mes Comercial
            </div>

            <div class="input-field col s3" style="width:400px; float: left;">
                <table>
                    <tr>
                        <td>
                        <?php id_periodo(1); ?>
                        </td>
                    </tr>
                    <tr style="display:${this.display_not} " >
                        <?php
                        rangos_fechas(0); ?>
                    
                    </tr>
                    <tr style="display:${this.display_not }">
                        <td>
                            <input id="anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center; float: left;" />
                            <label for="anio">
                            </label>
                        </td>
                        <td>
                            <input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />
                            <label for="mes">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <center>
                                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_Mes_Com();">
                                    Generar
                                </a>
                            <center>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div id="infcom"></div>
            `;
            document.getElementById('frmbuscar').innerHTML = texto;
        }



        // ## Boton gerencia, botones de mes y fecha de la consulta en ventas
        function Get_date() {
            let fecha = new Date();
            let dia = fecha.getDate();
            let mes = fecha.getMonth();
            let mes_h = (fecha.getMonth() + 1);
            let anio = fecha.getFullYear();
            let hoy;
            let hoy_2;
            dia < 10 ? dia = '0' + dia : dia = dia;
            mes < 10 ? mes = '0' + mes : mes = mes;
            mes_h < 10 ? mes_h = '0' + mes_h : mes_h = mes_h;
        }



        function Gerencia_Ven_F() {


            texto = '';
            document.getElementById('parametros').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = '';



            texto = texto + `
                <div class="flow-text #439049 green darken-1" 
                     style="width:400px; font-size:1.5vw;text-align:center;color:white;">
                        Informe de Compras y Ventas
                </div>
                <div class="input-field col s3" style="width:400px; float: left;">
                <table> 
                        <tr>
                            <td>
                          
                            <?php
                            id_periodo(0);
                            ?>
                        
                            </td>
                            </tr>
                        
                                <tr style="display:${ this.display_not }">
                                <td>
                                <div id="anio_mes" name="anio_mes" >
                                    <input id="anio" 
                                        onkeyUp="return ValNumero(this);" 
                                        placeholder="a&ntilde;o" 
                                        maxlength="4" 
                                        type="text" 
                                        class="validate" 
                                        style="background-color: white; font-size: 1.4em; text-align: center; float: left;" />
                                    
                                </td>
                        
                                <td>
                                <input id="Mes" 
                                        placeholder="mes" 
                                        type="text" 
                                        maxlength="2" 
                                        class="validate" 
                                        style="background-color: white; font-size: 1.4em; text-align: center;" />
                                </td>
                                </div>
                                </tr>
                     
                       
                       
                        <tr>
                        <?php
                        rangos_fechas(0);
                        ?>                       
                         </tr>
                        <tr>
                            <td colspan="2">
                                <center>
                                    <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_ven();">
                                        Generar
                                    </a>
                                </center>
                            </td>
                        </tr>
                </table>
                </div>
                `;


            /*   
             texto=texto + '<div class="flow-text #439049 green darken-1" style="width:400px; font-size:1.5vw;text-align:center;color:white;">Informe de Compras y Ventas</div>';
              texto=texto + '<div class="input-field col s3" style="width:400px; float: left;">';
              texto=texto + '<table><tr><td><input id="anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center; float: left;" />';
              texto=texto + '<label for="anio"></label></td>';
              texto=texto + '<td><input id="mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
              texto=texto + '<label for="mes"></label></td></tr>';
              texto=texto + '<tr><td colspan="2"><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_ven();">Generar</a><center>';
              texto=texto + '</td></tr></table>';
              texto=texto + '</div>'; 
              // let a=document.getElementById('#FechaActual').value;
              // let b=document.getElementById('#FechaHasta').value;
              // console.log(a,b);
              */
            document.getElementById('frmbuscar').innerHTML = texto;
        }


        // Boton informes almacen gerencia
        function Gerencia_Ven_A() {
            texto = '';
            document.getElementById('estado').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('parametros').innerHTML = '';
            //document.getElementById('Orden_P').style.visibility='hidden';
            //texto=texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:center; color: #009688;">INFORMES PORTOS</div>';

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<hr />';
            //document.getElementById('formuF').style.visibility='hidden';
            texto = texto + '<center>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Geren_Ven_Al();" style="text-transform: capitalize;font-weight: bold;">Sem Prom Concentrados</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="DescuentosManA();" style="text-transform: capitalize;font-weight: bold;">Descuentos Manuales</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '</center>';

            /*
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            */

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function Geren_Ven_Al() {
            texto = '';
            document.getElementById('parametros').style.visibility = 'visible';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = '';
            texto = `
            <div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">
                    Sem Prom Concentrados
            </div>
            <div class="input-field col s3" style="width: 450px;">
            <table>
                <tr>
                
                        <input id="Orden" 
                                placeholder="Buscar Por Orden o Codigo producto" 
                                maxlength="15" 
                                type="text" 
                                class="validate" 
                                style="background-color: white; font-size: 1.4em; text-align: center;" />
                        <label for="Orden"></label>
                </tr>
                Ó

                <tr>
                            <td>
                            <?php id_periodo(0); ?>
                            </td>
                </tr>


                <tr style=" display:${this.display_not }">
                        <td rowspan="1">
                            <input id="anio" 
                                   onkeyUp="return ValNumero(this);" 
                                   placeholder="a&ntilde;o" 
                                   maxlength="4" 
                                   type="text" 
                                   class="validate" 
                                   style="background-color: white; font-size: 1.4em; text-align: center;" />
                            <label for="anio"></label>
                        </td>
                        <td rowspan="1">
                            <input id="Mes" 
                                   placeholder="mes" 
                                   type="text" 
                                   maxlength="2" 
                                   class="validate" 
                                   style="background-color: white; font-size: 1.4em; text-align: center;" />
                            <label for="mes"></label>
                        </td>
                        </tr>
                     
                        
                        <tr>
                            <?php rangos_fechas(0); ?>
                        </tr>

                        <tr>
                            <td rowspan="1">
                        Y filtrar por:
                                <select id="opc" class="browser-default light-black-text" >
                                        <option value="" selected >Seleccionar</option>   
                                        <option value="PROMOCION">Promoci&oacute;n</option> 
                                        <option value="BONO">Bono</option>
                                        <option value="ITEM">Item</option>
                                </select>
                            </td>
                        </tr>
                </table>
                <br>
                <center>
                    <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_ven_Al();">
                        Buscar
                    </a>
                <center>
            </div>
                `;

            document.getElementById('parametros').innerHTML = texto;
        }

        function DescuentosManA() {
            texto = '';
            document.getElementById('parametros').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = ''
            /*           # COFIGO ORIGINAL
                TODO: No borrar por ahora
                texto = texto + '<div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">Descuentos Manuales</div>';
                texto = texto + '<div class="input-field col s3" style="width: 450px;">';
                texto = texto + '<table><tr><input id="Orden" value="" placeholder="Buscar Por Orden o Codigo producto" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto = texto + '<label for="Orden"></label></tr>';
                texto = texto + '<tr><td rowspan="1"><input id="anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto = texto + '<label for="anio"></label></td>';

                texto = texto + '<td rowspan="1"><input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
                texto = texto + '<label for="mes"></label></td>';

                texto = texto + '</tr></table>';
                texto = texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_descman_Al();">Buscar</a><center>';
                texto = texto + '</div>';
            */

            texto = `
            <div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">
                    Descuentos Manuales
            </div>

            <div class="input-field col s3" style="width: 450px;">
            
            <table>
                <tr>
                    <input id="Orden" value="" placeholder="Buscar Por Orden o Codigo producto" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />
                    <label for="Orden"></label>
                </tr>    

                Ó
                <tr>
                    <td>
                    <?php id_periodo(0); ?>
                    </td>
                </tr>


                <tr style="display:${this.display_not}">
                    <td rowspan="1">
                        <input id="anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />
                        <label for="anio"></label>
                    </td>
                    <td rowspan="1">
                        <input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />
                        <label for="mes"></label>
                    </td>
                </tr>
               
                <tr>
                    <?php rangos_fechas(0); ?>
                </tr>
            </table>
            <br>
            <center>
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_descman_Al();">
                    Buscar
                </a>
            <center>


            `;
            document.getElementById('parametros').innerHTML = texto;
        }





        // # busqueda informe de semana promocional concentrados
        function Gere_ven_Al() {

            var cat_consulta;
            var anio
            var mes;
            var desde = document.getElementById('desde').value;
            var ejecutar_por = document.getElementById('Por_Fechas').value;
            var hasta = document.getElementById('hasta').value;
            var opc = document.getElementById('opc').value;
            var ord = document.getElementById('Orden').value;

            document.getElementById('respuesta').innerHTML = '';
            // var anio = document.getElementById('anio').value;
            // var mes = document.getElementById('Mes').value;


            if (ord === '' && ejecutar_por === '') {
                alert('Por favor diligenciar la orden o Ejecutar por...');
                return
            } else {

                if (ord !== '' || ord.length > 0) {
                    anio = 0;
                    mes = 0;
                    opc = opc;
                    ord = ord;
                    cat_consulta = 'normal';

                } else if (ejecutar_por === 'Por_Fechas' && opc !== '') {
                    anio_desde = desde.replace(/-/g, "").substring(0, 6).substring(0, 4);
                    anio_hasta = hasta.replace(/-/g, "").substring(0, 6).substring(0, 4);
                    mes_desde = desde.replace(/-/g, "").substring(0, 6).slice(-2);
                    mes_hasta = hasta.replace(/-/g, "").substring(0, 6).slice(-2);

                    anio = 0;
                    mes = 0;

                    opc = opc;
                    ord = ord;
                    cat_consulta = 'rangos';

                } else if (ejecutar_por === 'Por_Fechas' && opc === '') {
                    alert('Elejir un filtro');
                    return

                } else if (ejecutar_por !== 'anio_mes' && ejecutar_por !== 'Por_Fechas' && ejecutar_por !== ' ' && opc === '') {
                    alert('Elejir un filtro');
                    return;
                } else if (ejecutar_por !== 'anio_mes' && ejecutar_por !== 'Por_Fechas' && ejecutar_por !== ' ') {
                    anio = ejecutar_por.substring(0, 4);
                    mes = ejecutar_por.substring(6, 4, 2);
                    cat_consulta = 'normal';
                } else {
                    return
                }
            } //IF PRINCIPAL 1919

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // # Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // # Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            if (ord !== '') {
                // # Realizar peticion HTTP
                peticion_http.open('POST', 'Inf_Var_Alm/Sem_Prom_con.php?a=' + anio + '&m=' + mes + '&op=' + opc + '&or=' + ord + '&category=' + cat_consulta, true);

            } else if ((anio !== '' && mes !== '') && (anio !== 0 && mes !== 0)) {
                peticion_http.open('POST', 'Inf_Var_Alm/Sem_Prom_con.php?a=' + anio + '&m=' + mes + '&op=' + opc + '&or=' + ord + '&category=' + cat_consulta, true);
            } else {
                peticion_http.open('POST', 'Inf_Var_Alm/Sem_Prom_con.php?a=' + anio_desde + '&m=' + mes_desde + '&op=' + opc + '&or=' + ord + '&ah=' + anio_hasta + ' &mh=' + mes_hasta + '&category=' + cat_consulta, true);
            }
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
            document.getElementById('frmbuscar').innerHTML = '';
        }















        function Gere_descman_Al() {
            var cat_consulta;
            document.getElementById('respuesta').innerHTML = '';
            // document.getElementById('respuesta').style.visibility='hidden';
            //document.getElementById('Carguesi').style.visibility='visible';

            var anio, mes;
            // var anio = document.getElementById('anio').value;
            // var mes = document.getElementById('Mes').value;
            var ejecutar_por = document.getElementById('Por_Fechas').value;
            var fec_desde = document.getElementById('desde').value;
            var fec_hasta = document.getElementById('hasta').value;
            var ord = document.getElementById('Orden').value;

            if ((ord === '' || ord.length === 0) && ejecutar_por === '') {
                alert("Por favor digitar una orden o  codigo  ó \nselccionar ejecutar por");
                return
            } else {

                if (ejecutar_por === 'anio_mes') {
                    // console.log('anio_mes');
                    if (anio === '') {
                        alert("Por favor especificar un año");
                        return
                    } else if (mes === '') {
                        alert("Por favor especificar un mes");
                        return
                    } else {
                        anio = anio;
                        mes = mes;
                        cat_consulta = 'normal';
                    }

                } else if (ejecutar_por === 'Por_Fechas') {
                    // console.log('por_fechas');

                    if (!fec_desde) return
                    fec_desde = fec_desde.replace(/-/g, "")
                    if (!fec_hasta) return
                    fec_hasta = fec_hasta.replace(/-/g, "")

                    anio_desde = fec_desde.substring(0, 4);
                    mes_desde = fec_desde.substring(6, 4);

                    anio_hasta = fec_hasta.substring(0, 4);
                    mes_hasta = fec_hasta.substring(6, 4);
                    cat_consulta = 'rangos';

                    alert('consulta ' + cat_consulta + '\n' + 'Año por rango desde:' + anio_desde.toString() + '\n' + 'Mes por rango desde ' + mes_desde.toString() + '\n' + 'Año por rango hasta:' + anio_hasta.toString() + '\n' + 'Mes por rango hasta ' + mes_hasta.toString());

                } else if (ejecutar_por !== 'Por_Fechas' && ejecutar_por !== 'anio_mes') {
                    anio = ejecutar_por.substring(0, 4);
                    mes = ejecutar_por.substring(6, 4, 2);
                    cat_consulta = 'normal';

                } else {
                    return;
                }

            } // # ELSE DEL IF

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;


            // Realizar peticion HTTP
            if (ejecutar_por === 'Por_Fechas') {
                peticion_http.open('POST', 'Inf_Var_Alm/Desc_Man_Alm.php?a=' + anio_desde + '&m=' + mes_desde + '&ah=' + anio_desde + '&mh=' + mes_desde + '&or=' + ord + '&category=' + cat_consulta, true);
            } else {
                peticion_http.open('POST', 'Inf_Var_Alm/Desc_Man_Alm.php?a=' + anio + '&m=' + mes + '&or=' + ord + '&category=' + cat_consulta, true);
            }
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
            document.getElementById('frmbuscar').innerHTML = '';
        }
        /* ###################################_______________________________________________________################################*/
        /* ###################################_______________________________________________________################################*/
        /* ###################################_______________________________________________________################################*/
        /* ###################################_______________________________________________________################################*/
        /* ###################################_______________________________________________________################################*/
        /* ###################################_______________________________________________________################################*/



        //Boton gerencia, botones de mes y fecha de la consulta en compras
        function Gerencia_Com_F() {
            //document.getElementById('Orden_P').style.visibility='hidden';
            //document.getElementById('formuF').style.visibility='visible';
            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';

            texto = texto + '<div class="flow-text #439049 green darken-1" style="width:200px; font-size:1.5vw;text-align:center;color:white;">Ingreso Mercancia</div>';

            texto = texto + '<div class="input-field col s3" style="width:200px;">';
            texto = texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto = texto + '<label for="Anio"></label>';
            texto = texto + '</div>';

            texto = texto + '<div class="input-field col s3" style="width:200px;">';
            texto = texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto = texto + '<label for="Mes"></label>';
            texto = texto + '</div>';
            texto = texto + '<div class="input-field col s3" style="width:200px;">';
            texto = texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Gere_com();">Buscar</a><center>';
            texto = texto + '</div>';

            document.getElementById('frmbuscar').innerHTML = texto;
        }

        function buscarSeparacionAlistamientoP() {
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            texto = '';

            texto = `
            <div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">
                Separaci&oacute;n y Alistamiento
            </div>               
            <div class="input-field col s3" style="width:450px; float: left;">                                                                                                     
                <table>
                    <tr>
                        <?php
                        id_periodo(0);
                        ?>
                    <tr>
                    <tr>
                        <?php
                        rangos_fechas(0);
                        ?>
                    <tr>
                        <td colspan="12">
                            <center>
                                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="separacionAlistaP();">
                                    Generar
                                </a>
                            <center>                         
                        </td>
                    </tr>
                </table>                                                                                                                                                     
            </div>                                                                                                                                                                 
            `;
            document.getElementById('frmbuscar').innerHTML = texto;
        }

        function buscarValidacionEmpaqueP() {
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            texto = '';

            texto = `
            <div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">
                    Separaci&oacute;n y Alistamiento
            </div>               
            <div class="input-field col s3" style="width:450px; float: left;">                                                                                                     
                <table>
                    <tr>
                        <td>Fecha Inicio: 
                            <hr style="width: 90%;">
                                <input type="date" maxlength="2" id="inicial" name="trip-start" value="" min="2018-01-01" max="2025-12-31">
                        </td>  
                        <td>Fecha Fin: 
                            <hr style="width: 90%;">
                                <input type="date" maxlength="2" id="fin" name="trip-start" value="" min="2018-01-01" max="2025-12-31">
                        </td>
                    <tr>
                    <tr>
                        <td colspan="12">
                            <center>
                                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="ValidacionEmpaP();">
                                    Generar
                                </a>
                            <center>                           
                        </td>
                    </tr>
                </table>                                                                                                                                                     
            </div>                                                                                                                                                                 
            `;
            /*
             */
            document.getElementById('frmbuscar').innerHTML = texto;

        }






        function separacionAlistaP() {
            // var inicial = document.getElementById('inicial').value;
            // var fin = document.getElementById('fin').value;
            var option_period = document.getElementById('Por_Fechas').value;
            var fec_desde = document.getElementById('desde').value;
            var fec_hasta = document.getElementById('hasta').value;
            var anio_d, mes_d, dia_d, anio_h, mes_h, dia_h, tipo_consulta;

            if (option_period === '') {
                alert("Por favor elegir una opción de consulta.");
                return;
            } else if (option_period === 'Por_Fechas') {
                anio_d = clear_date(fec_desde, 'anio');
                mes_d = clear_date(fec_desde, 'mes');
                dia_d = clear_date(fec_desde, 'dia');

                anio_h = clear_date(fec_hasta, 'anio_hasta');
                mes_h = clear_date(fec_hasta, 'mes_hasta');
                dia_h = clear_date(fec_hasta, 'dia_hasta');

                tipo_consulta = 'rangos';
            } else if (option_period !== 'Por_Fechas' && option_period !== ' ') {
                anio_d = clear_date(option_period, 'anio')
                mes_d = clear_date(option_period, 'mes')
                tipo_consulta = 'normal';

            } else {
                return;
            }


            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }


            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;

            if (tipo_consulta === 'rangos') {
                peticion_http.open('POST', 'bodega/Inf_SeparacionAlistamiento.php?a=' + anio_d + '&m=' + mes_d + '&d=' + dia_d + '&ah=' + anio_h + '&mh=' + mes_h + '&dh=' + dia_h + '&tc=' + tipo_consulta, true);
            } else if (tipo_consulta === 'normal') {
                peticion_http.open('POST', 'bodega/Inf_SeparacionAlistamiento.php?a=' + anio_d + '&m=' + mes_d + '&tc=' + tipo_consulta, true);
            } else {
                console.log("No paso ");
                return;
            }

            // Realizar peticion HTTP
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }

        function ValidacionEmpaP() {
            var inicial = document.getElementById('inicial').value;
            var fin = document.getElementById('fin').value;
            if (inicial == "") {
                alert("Seleccione una fecha inicial");
                return false;
            }
            if (fin == "") {
                alert("Seleccione una fecha final");
                return false;
            }
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'bodega/Inf_ValidacionEmpaque.php?i=' + inicial + '&f=' + fin, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        //document.getElementById('Carguesi').style.visibility='hidden';
                        //ocument.getElementById('frmbuscar').innerHTML='';
                    }
                }
            }
            document.getElementById('frmbuscar').innerHTML = '';
        }

        //funcion de consulta a la base compras.
        function Gere_ven() {
            document.getElementById('Carguesi').style.visibility = 'visible';
            var id_period = document.getElementById('Por_Fechas').value;
            var fec_desde = document.getElementById('desde').value;
            var fec_hasta = document.getElementById('hasta').value;
            var anio, mes;



            if ((anio == '' || anio == ' ' || anio == undefined) &&
                (mes == '' || mes == ' ' || mes == undefined)
            ) {

                if ((id_period !== 'Por_Fechas')) {
                    id_period = id_period.replace(/-/g, "")

                    anio = id_period.substring(0, 4);

                    mes = id_period.substring(6, 4);

                    this.consul = 'normal';
                } else {
                    if (!fec_desde) return
                    fec_desde = fec_desde.replace(/-/g, "")
                    if (!fec_hasta) return
                    fec_hasta = fec_hasta.replace(/-/g, "")

                    anio_desde = fec_desde.substring(0, 4);
                    mes_desde = fec_desde.substring(6, 4);

                    anio = fec_desde.substring(0, 4);
                    mes = fec_desde.substring(6, 4);

                    anio_hasta = fec_hasta.substring(0, 4);
                    mes_hasta = fec_hasta.substring(6, 4);
                    this.consul = 'especial';

                    alert('consulta ' + this.consul + '\n' + 'Año por rango desde:' + anio_desde.toString() + '\n' + 'Mes por rango desde ' + mes_desde.toString() + '\n' + 'Año por rango hasta:' + anio_hasta.toString() + '\n' + 'Mes por rango hasta ' + mes_hasta.toString());
                    // console.log('1:2');
                }

            } else {
                anio = anio;
                mes = mes;
                alert('Anio ' + anio + ' \n' + 'Mes ' + mes);
                this.consul = 'normal';
                // console.log('2:1');

            }

            /* 
                            BUSQUEDA POR ARCHIVOS DESDE OTRO INFORME
                // var old_rute = window.location.href;         
                // var new_rute = window.location.href+"?anio_cyv=" + anio + "&mes_cyv=" + mes+"&anio2="+anio;         
                // window.location.href = window.location.href+"?anio_cyv=" + anio + "&mes_cyv=" + mes+"&anio2="+anio;;
            */
            <?php
            session_start();
            $anio  =  $_GET["anio_cyv"];
            $anio2 =  $_GET["anio2"];
            $mes   =  $_GET["mes_cyv"];
            if ($anio == 202222) {
                include_once('general_functions.php');
                copy_file($anio, $mes);
            }
            $_SESSION['a'] = $anio;
            $_SESSION['a2'] = $anio2;
            $_SESSION['m'] = $mes;
            ?>
            /* BUSQUEDA POR ARCHIVOS DESDE OTRO INFORME*/




            if (anio !== "" && mes !== "") {
                // if (anio == "1000" && mes == "1000"){
                document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
                document.body.style.cursor = 'wait';
                // Obtener la instancia del objeto XMLHttpRequest
                if (window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = muestraContenido;
                if (this.consul == 'normal') {
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'geren/Inf_Compras_Ventas.php?a=' + anio + '&m=' + mes + '&consulta=' + this.consul, true);
                } else {
                    // Realizar peticion HTTP
                    peticion_http.open('POST', 'geren/Inf_Compras_Ventas.php?a=' + anio + '&m=' + mes + '&consulta=' + this.consul + '&anio_desde=' + anio_desde + '&mes_desde=' + mes_desde + '&anio_hasta=' + anio_hasta + '&mes_hasta=' + mes_hasta, true);
                }
                peticion_http.send(null);


                function muestraContenido() {
                    //alert(dato1);
                    if (peticion_http.readyState == 4) {
                        if (peticion_http.status == 200) {
                            var dato = peticion_http.responseText;
                            alert('COMPLETADO..');
                            //INFORME_COMPRAS_VENTAS_MES.pdf
                            verLink('./pdf/INFORME_COMPRAS_VENTAS_MES.pdf');
                            document.body.style.cursor = 'auto';
                            document.getElementById('estado').innerHTML = 'LISTO';
                            document.getElementById('estado').innerHTML = '<a href="./pdf/INFORME_COMPRAS_VENTAS_MES.pdf" target="_new"><h4>Descargar Informe</h4></a>';
                            document.getElementById('respuesta').innerHTML = dato;
                        }

                    }
                }

                conta += 1;

            } else {
                alert('No conto con datos suficientes');
                console.log('No conto con datos suficientes');

            }
            document.getElementById('frmbuscar').style.visibility = 'visible';
        }

        //funcion de consulta a la base Ventas.
        function Gere_com() {
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('Carguesi').style.visibility = 'visible';

            // var anio = document.getElementById('Anio').value;
            // var mes = document.getElementById('Mes').value;
            var anio, mes;
            if (anio == "") {
                alert("Digite un a�o");
                return false;
            }
            if (mes == "") {
                alert("Digite un mes");
                return false;
            }
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'geren/Inf_Gere_Compras.php?a=' + anio + '&m=' + mes, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
        }

        function MinAgricultura() {
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'minagricultura/minAgricultura.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;

                    }
                }
            }
        }
        ////////////////
        function Boto_cartera() {
            texto = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            // texto = texto + '<center>                                                                                                                                                                                       ';
            // texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_Cre_Car();" style="text-transform: capitalize;font-weight: bold;" disabled>Informa General</a>&nbsp;&nbsp;&nbsp;   ';
            // texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Cedula_Cartera();" style="text-transform: capitalize;font-weight: bold;">Busqueda Usuario</a>&nbsp;&nbsp;&nbsp;        ';
            // texto = texto + '</center>                                                                                                                                                                                      ';

            texto = texto + `
            <center>                                                                                                                                                                                       
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_Cre_Car();" style="text-transform: capitalize;font-weight: bold;" disabled>Informa General</a>&nbsp;&nbsp;&nbsp;   
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Cedula_Cartera();" style="text-transform: capitalize;font-weight: bold;">Busqueda Usuario</a>&nbsp;&nbsp;&nbsp;        
                </center>                                                                                                                                                                                      
                `;






            document.getElementById('estado').innerHTML = texto;
            return true;
        }
        ///////////////
        function Cedula_Cartera() {
            document.getElementById('respuesta').innerHTML = '';

            var texto = '';
            texto = texto + `
            
            <div style="width: 200px; text-align: center;" class="#439049 green darken-1 white-text text-darken-2" style="font-size:1.5vw;text-align:center;color:white;">Ingrese No. De Cedula.</div>             
            <div class="input-field col s8" style="width: 200px;">                                                                                                                                                 
                <input id="Cedula" onkeyUp="return ValNumero(this);" placeholder="Cedula" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" value="51751493"/>        
                <label for="Cedula"></label>                                                                                                                                                                           
                </div>                                                                                                                                                                                                 
                <div class="input-field col s3" style="width: 200px;">                                                                                                                                                 
                <br>
                    <center>
                        <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Cre_Car_perfileria();">
                            Buscar
                        </a>
                    <center>                                                                        
            </div>                                                                                                                                                                                                 
            `;
            document.getElementById('frmbuscar').innerHTML = texto;
        }

        function Ministerio() {
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('Carguesi').value = '';
            document.getElementById('estado').innerHTML = '';
            //document.getElementById('Orden_P').style.visibility='hidden';
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            //document.getElementById('cartera1').style.visibility='hidden';
            /*
            var texto='';
                    texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
                    document.getElementById('respuesta').innerHTML=texto;
            */
            //document.getElementById('formuF').style.visibility='hidden';
            texto = '';
            texto = texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:left; color: #439049;"> <span class="info_route">Ministerio / </span><b>INFORMES MINISTERIO</b></div>';

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<center>';    
            <?php
            $verboton = strpos($btnSecu, '3A');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosMinAgricultura();">MIN-AGRICULTURA</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '3B');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                // texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosDec551();" disabled>MIN-HACIENDA</a>&nbsp;&nbsp;&nbsp;';
                texto = texto + `
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosDec551();" disabled >MIN-HACIENDA</a>&nbsp;&nbsp;&nbsp;
                <div class="tooltip">
                <span class="tooltip-content">
                !Este reporte se esta migrando!
                </span>
                </div>
                `;
                //document.getElementById('formuF').style.visibility='hidden';
                //texto=texto + '</center>';
            <?php
            }
            ?>
            document.getElementById('formu').innerHTML = texto;
            document.getElementById('parametros').innerHTML = '';
            return true;
        }

        function Portos() {
            document.getElementById('estado').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('Carguesi').value = '';
            texto = '';
            texto = texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:left; color: #439049;"><span class="info_route">Portos / </span><b>INFORMES PORTOS</b></div>';

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<center>';
            <?php
            $verboton = strpos($btnSecu, '2A');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosINVP();">INVENTARIO</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '2B');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosProcesosP();">PROCESAMIENTO</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '2C');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarPqrP();">PQR</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '2D');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Busc_Produ();">BUSQUEDA PRODUCTO</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '2E');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="CREDITOCAR();">CREDITO Y CARTERA</a>&nbsp;&nbsp;&nbsp;';
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_Rec_CliP();">INF REC CLI</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            ?>
            //document.getElementById('formuF').style.visibility='hidden';
            //texto=texto + '</center>';

            document.getElementById('formu').innerHTML = texto;
            document.getElementById('parametros').innerHTML = '';
            return true;
        }

        function Inf_Rec_CliP() {
            //document.getElementById('respuesta').innerHTML=texto;
            //document.getElementById('cartera1').style.visibility='hidden';
            //var cedu=document.getElementById('Cedula').value;
            //var texto='';
            document.getElementById('Carguesi').value = 'Espere por favor....'; //.style.visibility='visible';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';

            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Almacen/Inf_Rec_CliP.php', true); //?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }

        function Inf_His_Com() {
            //var cedu=document.getElementById('Cedula').value;
            //var texto='';
            document.getElementById('Carguesi').value = 'Espere por favor....'; //.style.visibility='visible';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            //document.getElementById('respuesta').innerHTML=texto;
            //document.getElementById('cartera1').style.visibility='hidden';

            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Almacen/Inf_His_Com.php', true); //?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }

        function buscarPqrP() {
            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = ''
            formulario_control('consultar_informe', 'PQR', 'Pqr/Inf_Pqr_P', 'si');
            document.getElementById('parametros').innerHTML = texto;
        }

        function Pqr_P() {

            document.getElementById('respuesta').style.visibility = 'visible';
            var ini = document.getElementById('inicial').value;
            var fin = document.getElementById('fin').value;
            var pqr = document.getElementById('Pqr').value;
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';

            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Pqr/Inf_Pqr_P.php?i=' + ini + '&f=' + fin + '&p=' + pqr, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        //document.getElementById('Carguesi').style.visibility='hidden';
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }

        function Almacen() {
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('Carguesi').value = '';
            document.getElementById('estado').innerHTML = '';
            texto = '';
            texto = texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:left; color: #439049;"><span class="info_route">Almacén / </span><b>INFORMES ALMACEN</b></div>';

            //texto=texto + '<center>';
            <?php
            $verboton = strpos($btnSecu, '1A');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosINVA();">INVENTARIO</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '1B');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarDatosProcesosA();">PROCESAMIENTO</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '1C');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarPqrA();">PQR</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            $verboton = strpos($btnSecu, '1D');
            if ($verboton !== FALSE || $pasa == true) {
            ?>
                texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="BusKist();">KITS</a>&nbsp;&nbsp;&nbsp;';
            <?php
            }
            ?>
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_His_Com();">INF HIS COMPRAS</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Inf_Rec_Cli();">INF REC CLI</a>&nbsp;&nbsp;&nbsp;';
            //texto=texto + '</center>';
            //document.getElementById('formuF').style.visibility='hidden';
            document.getElementById('formu').innerHTML = texto;
            document.getElementById('parametros').innerHTML = '';
            return true;
        }

        function Inf_Rec_Cli() {
            //var cedu=document.getElementById('Cedula').value;
            document.getElementById('Carguesi').value = 'Espere por favor....'; //.style.visibility='visible';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            //var texto='';
            //document.getElementById('respuesta').innerHTML=texto;

            //document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Almacen/Inf_Rec_CliA.php', true); //?c=' + cedu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                    }
                }
            }
        }

        function buscarPqrA() {
            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = ''

            texto = texto + '<div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">Validaci&oacute;n y Empaque</div>';

            texto = texto + '<div class="input-field col s3" style="width:450px; float: left;">';
            texto = texto + '<table><tr><input id="Pqr" value="PQR-" placeholder="PQR-" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto = texto + '<label for="Pqr"></label></tr>';
            texto = texto + '<tr><td>Fecha Inicio: <hr style="width: 90%;"><input type="date" maxlength="2" id="inicial" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td>';
            texto = texto + '<td>Fecha Fin: <hr style="width: 90%;"><input type="date" maxlength="2" id="fin" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td><tr></table>';
            /*
            texto=texto + '<table><tr><td><input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center; float: left;" />';
            texto=texto + '<label for="Anio"></label></td>';
            texto=texto + '<td><input id="Mes" placeholder="Mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label></td>';
            texto=texto + '<td><input id="Dia" placeholder="Dia" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto=texto + '<label for="Dia"></label></td></tr>';
            texto=texto + '<table><tr><td><input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center; float: left;" />';
            texto=texto + '<label for="Anio"></label></td>';
            texto=texto + '<td><input id="Mes" placeholder="Mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto=texto + '<label for="Mes"></label></td>';
            texto=texto + '<td><input id="Dia" placeholder="Dia" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto=texto + '<label for="Dia"></label></td></tr>';*/
            //texto=texto + '<tr><td colspan="12"><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Pqr_A();">Generar</a><center>';
            texto = texto + '<tr><td colspan="12"><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Pqr_a();">Generar</a><center>';
            texto = texto + '</td></tr></table>';
            texto = texto + '</div>';

            document.getElementById('parametros').innerHTML = texto;
        }

        function Pqr_a() {
            var ini = document.getElementById('inicial').value;
            var fin = document.getElementById('fin').value;
            var pqr = document.getElementById('Pqr').value;
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Pqr/Inf_Pqr_A.php?i=' + ini + '&f=' + fin + '&p=' + pqr, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }

        function BusKist() {

            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'hidden';
            document.getElementById('respuesta').innerHTML = '';

            texto = '';
            texto = texto + '<div class="flow-text #439049 green darken-1" style="width:480px; font-size:1.5vw;text-align:center;color:white;">Kits</div>';
            texto = texto + '<div class="input-field col s3" style="width:450px; float: left;">';
            texto = texto + '<table><tr><td>Fecha Inicio: <hr style="width: 90%;"><input type="date" maxlength="2" id="inicial" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td>';
            texto = texto + '<td>Fecha Fin: <hr style="width: 90%;"><input type="date" maxlength="2" id="fin" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td>';
            texto = texto + '<td><select id="Kits" onchange="Agr_N(this.value);" class="browser-default light-black-text" style="width: 170px;">';
            texto = texto + '<option value="" disabled selected >Seleccione Consulta</option>';
            texto = texto + '<option value="KitsP">Kist Padre</option>';
            texto = texto + '<option value="KistA">Kits Asociados</option>';
            texto = texto + '<option value="Kist_Lis_Mat">Kits Lis Materiales</option>';
            texto = texto + '<option value="Kist_Agr_N">Kits Agronotas</option>';
            texto = texto + '</select></td><tr></table>';
            //texto=texto + '<table><tr><td colspan="12"><center><a id="bb" class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Agr_N();">Buscar</a><center>';
            texto = texto + '</td></tr></table>';
            texto = texto + '</div>';
            //document.getElementById('bb').style.visibility='visible';
            // document.getElementById('parametros').innerHTML = texto;
            document.getElementById('parametros').innerHTML = '';
        }

        function Agr_N(valor) {
            var inic = document.getElementById('inicial').value;
            var fin = document.getElementById('fin').value;
            var kitsB = valor; //document.getElementById('Kits').value;
            if (kitsB == 'Kist_Agr_N') {
                texto = texto + '<form enctype="multipart/form-data" action="index_des.php" method="POST">'; //Kits/arc_excel.php
                texto = texto + '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />';
                texto = texto + '<input name="fichero_usuario" type="file" class="waves-efect waves-light btn"  /><br /><br />';
                //texto=texto + '<center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Pqr_A();">Buscar</a><center>';
                texto = texto + '<input type="hidden" style="width: 10px;" name="iniciox" value="' + inic + '" >';
                texto = texto + '<input type="hidden" style="width: 10px;" name="finx" value="' + fin + '" >';
                texto = texto + '<input type="hidden" style="width: 10px;" name="kitsB" value="' + kitsB + '" >';
                texto = texto + '<input type="submit" class="waves-efect waves-light btn" name="Enviar" value="Enviar fichero" /><br /><br />';
                texto = texto + '</form>';
                //document.getElementById('bb').style.visibility='hidden';
                document.getElementById('parametros').innerHTML = texto;
            } else {
                BusKistA(inic, fin, kitsB);
            }
        }

        /*
        $("#upload").on("click", function() {
            var file_data = $("#sortpicture").prop("files")[0];   
            var form_data = new FormData();
            form_data.append("file", file_data);
            alert(form_data);
            $.ajax({
                url: "/var/www/html/modulo_odoo/Informes/Kits/archivos",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(){
                    alert("works"); 
                }
            });
        });
        
        */


        function Pqr_A() {

            //var f = document.getElementById('files').files[0];
            //file1=escape(f.name); 

            //var f2 = document.getElementById('files').files[0];
            //file2=escape(f2.type); 

            //var f2 = document.getElementById('files').files[0][tmp_name];
            //file2=escape(f2.name);

            //alert('archivo:' + file1 + ' arvhivo:' + file2);

            return false;

            var obj = document.getElementById('files').files[0];
            //alert('archivo:' + file1 + '-----' +var1);
            //return false;
            //var form=document.getElementById('f').
            //document.getElementById('parametros').innerHTML=form;
            //alert(form);       
            //return false;            
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Kits/arc_excel.php?obj=' + obj + '&obj2=' + file1, true);
            peticion_http.send(null);
            //peticion_http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            // peticion_http.send(this.getElementById('fichero_usuario').value);
            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        document.getElementById('parametros').innerHTML = dato;
                        document.getElementById('estado').innerHTML = '';
                        document.body.style.cursor = 'auto';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }


        function Ord_pendientesA() {
            document.getElementById('respuesta').innerHTML = '';
            //include('../conectarbase.php');
            document.getElementById('Carguesi').style.visibility = 'visible';
            //document.getElementById('formuF').style.visibility='hidden';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            //var anio=document.getElementById('tiempo').value;
            //var anio=document.getElementById('Anio').value;
            //var mes=document.getElementById('Mes').value;
            var tiempo = document.getElementById('tiempo').value;
            if (tiempo == "") {
                alert("Seleccione una Busqueda");
                return false;
            }
            //alert("aqui" + tiempo);
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP

            // Realizar peticion HTTP
            if (tiempo == 'General') {
                peticion_http.open('POST', 'Ord/Ord_pendientesA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Progreso') {
                peticion_http.open('POST', 'Ord/Ord_ProgresoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'GANADERIA') {
                peticion_http.open('POST', 'Ord/Ord_GanaderiaA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Cancelado') {
                peticion_http.open('POST', 'Ord/Ord_CanceladoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'Transferido') {
                peticion_http.open('POST', 'Ord/Ord_TransferidoA.php?t=' + tiempo, true);
            }
            if (tiempo == 'PETS') {
                peticion_http.open('POST', 'Ord/Ord_PetsA.php?t=' + tiempo, true);
            }
            if (tiempo == 'LABORATORIOS') {
                peticion_http.open('POST', 'Ord/Ord_LaboratoriosA.php?t=' + tiempo, true);
            }
            peticion_http.send(null);
            //peticion_http.open('POST', 'Ord_pendientesP.php?t=' + tiempo,  true);
            //peticion_http.send(null);
            //alert("aqui");
            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        document.getElementById('Carguesi').style.visibility = 'hidden';
                    }
                }
            }
        }


        function BusKistA(Inicio, Fin, Kits) {
            var inic = Inicio; //document.getElementById('inicial').value;
            var fin = Fin; //document.getElementById('fin').value;
            var kitsB = Kits; //document.getElementById('Kits').value;
            //alert("prueba inicial: "+inic+" final: "+fin+" kits: "+kitsB);
            if (kitsB == "") {
                alert("Seleccione una opcion");
                return false;
            }
            //return false;
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            document.body.style.cursor = 'wait';
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            if (kitsB == 'KitsP') {
                peticion_http.open('POST', 'Kits/Inf_Kits_PadreA.php?k=' + kitsB + '&i=' + inic + '&f=' + fin, true);
            }
            if (kitsB == 'KistA') {
                peticion_http.open('POST', 'Kits/Inf_Kits_Asociados.php?k=' + kitsB + '&i=' + inic + '&f=' + fin, true);
            }
            if (kitsB == 'Kist_Lis_Mat') {
                peticion_http.open('POST', 'Kits/Inf_kis_base.php?k=' + kitsB + '&i=' + inic + '&f=' + fin, true);
            }
            if (kitsB == 'Kist_Agr_N') {
                peticion_http.open('POST', 'Kits/Inf_Kits_Agronotas.php?k=' + kitsB + '&i=' + inic + '&f=' + fin, true); //Inf_Kits_Agronotas.php
            }

            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }

        //FILTROS PORTOS*************************************************

        function buscarDatosMinAgricultura() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            document.getElementById('estado').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            /*
            var texto='';
                    texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
                    document.getElementById('respuesta').innerHTML=texto;
                    
            */
            //document.getElementById('Orden_P').style.visibility='hidden';
            texto = '';
            texto = texto + '<center>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="MinAgricultura();" style="text-transform: capitalize;font-weight: bold;">Reporte MinAgricultura</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '</center>';

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function buscarDatosDec551() {
            texto = '';
            document.getElementById('estado').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            //document.getElementById('Orden_P').style.visibility='hidden';
            //document.getElementById('formuF').style.visibility='hidden';

            //texto=texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:center; color: #009688;">INFORMES PORTOS</div>';

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<hr />';
            texto = texto + '<center>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="MinHacienda();" style="text-transform: capitalize;font-weight: bold;">Reporte MinHacienda</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '</center>';

            /*
            texto=texto + '<div class="input-field col s6">';
            texto=texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.8em; text-align: center;" />';
            texto=texto + '<label for="Anio"></label>';
            texto=texto + '</div>';
            */

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function buscarDatosINVP() {
            texto = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            texto = `
            <center>                                                                                                                                                                                               
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Fecha_ing_MerP();" style="text-transform: capitalize;font-weight: bold;">Ingreso Mercancia</a>&nbsp;&nbsp;&nbsp;               
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="formulario_control('buscarSalidaMercanciaP','Salida de  Mercancia','');" style="text-transform: capitalize;font-weight: bold;">Salida Mercancia</a>&nbsp;&nbsp;&nbsp;        
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarExistenciasMercanciaP();" style="text-transform: capitalize;font-weight: bold;" disabled>Existencias Bodega</a>&nbsp;&nbsp;&nbsp; 
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Orden_f();" style="text-transform: capitalize;font-weight: bold;">Ordenes Pendientes</a>&nbsp;&nbsp;&nbsp;                     
            </center>                                                                                                                                                                                              
            `;

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function Fecha_ing_MerP() {

            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';


            texto = `
            <div class="flow-text #439049 green darken-1" style="width:200px; font-size:1.5vw;text-align:center;color:white;">
                Ingreso Mercancia
            </div>                                                          
            <div class="input-field col s3" style="width:200px;">                                                                                                                                              
                <br>
                
                <?php
                echo ' 
                            <table>
                             <tr>
                            ';
                id_periodo(0);
                echo '
                             </tr>
                            ';

                rangos_fechas(0);
                ?>
                </table>


                <center>
                    <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarIngresoMercanciaP();">
                        Buscar
                    </a>
            <center>                                                               
            </div>                                                                                                                                                                                             
            `;

            document.getElementById('frmbuscar').innerHTML = texto;
        }

        function buscarDatosINVA() {
            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            //document.getElementById('Orden_P').style.visibility='hidden';
            //document.getElementById('formuF').style.visibility='hidden';
            document.getElementById('respuesta').innerHTML = '';
            //texto=texto + '<div class="flow-text gray" style="font-size:1.5vw;text-align:center; color: #009688;">INFORMES PORTOS</div>';

            //texto=texto + '<label>Par&aacute;metros de busqueda:</label><hr />';   
            //texto=texto + '<hr />';
            texto = texto + '<center>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Fecha_ing_MerA();" style="text-transform: capitalize;font-weight: bold;"              disabled>Ingreso Mercancia</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarSalidaMercanciaA();" style="text-transform: capitalize;font-weight: bold;"      disabled>Salida Mercancia</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarExistenciasMercanciaA();" style="text-transform: capitalize;font-weight: bold;" disabled>Existencias Bodega</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Orden_A();" style="text-transform: capitalize;font-weight: bold;"                     disabled>Ordenes Pendientes</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '</center>';

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function Fecha_ing_MerA() {
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            //document.getElementById('formuF').style.visibility='visible';



            /*  
            texto = '';
             texto = texto + '<div class="flow-text #439049 green darken-1" style="width:200px; font-size:1.5vw;text-align:center;color:white;">Ingreso Mercancia</div>                                                        ';
             texto = texto + '<div class="input-field col s3" style="width:200px;">                                                                                                                                            ';
             texto = texto + '<input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" /> ';
             texto = texto + '<label for="Anio"></label>                                                                                                                                                                       ';
             texto = texto + '</div>                                                                                                                                                                                           ';
             texto = texto + '<div class="input-field col s3" style="width:200px;">                                                                                                                                            ';
             texto = texto + '<input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />                                           ';
             texto = texto + '<label for="Mes"></label>                                                                                                                                                                        ';
             texto = texto + '</div>                                                                                                                                                                                           ';
             texto = texto + '<div class="input-field col s3" style="width:200px;">                                                                                                                                            ';
             texto = texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarIngresoMercanciaA();">Buscar</a><center>                                                             ';
             texto = texto + '</div>                                                                                                                                                                                           ';
             */

            texto = `
            <div class="flow-text #439049 green darken-1" style="width:200px; font-size:1.5vw;text-align:center;color:white;">
                Ingreso Mercancia
            </div>                                                        
            <div class="input-field col s3" style="width:200px;">                                                                                                                                            
                <input id="Anio" onkeyUp="return ValNumero(this);" placeholder="a&ntilde;o" maxlength="4" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" /> 
                <label for="Anio"></label>                                                                                                                                                                       
            </div>                                                                                                                                                                                           
            <div class="input-field col s3" style="width:200px;">                                                                                                                                            
                <input id="Mes" placeholder="mes" type="text" maxlength="2" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />                                           
                <label for="Mes"></label>                                                                                                                                                                        
            </div>                                                                                                                                                                                           
            <div class="input-field col s3" style="width:200px;">                                                                                                                                            
                <br />
                    <center>
                        <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarIngresoMercanciaA();">
                            Buscar
                        </a>
                    <center>                                                             
            </div>                                                                                                                                                                                           
            `;
            document.getElementById('frmbuscar').innerHTML = texto;
        }




        function Orden_f() {
            var texto = '';

            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';


            texto = `
                    <div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>
                    <div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>   
                    <div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>   
                    <div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>   
                    <div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>                
                `;


            document.getElementById('respuesta').innerHTML = texto;
            texto = select_tiempo('Ord_pendientesP');
            document.getElementById('frmbuscar').innerHTML = texto;


        }





        function select_tiempo(nombre_funcion) {
            var texto = '';
            let lista_consultas = ['general', 'progreso', 'ganaderia', 'cancelado', 'transferido', 'pets', 'laboratorios'];
            texto = `
            <div class="input-field col l9">                                                                                  
                <select id="tiempo" onchange="${nombre_funcion}();" class="browser-default light-black-text" style="width: 300px;"> 
                    <option value="" disabled selected >Seleccione Consulta</option>                                  
            `;
            lista_consultas.forEach(ls_options => {
                texto = texto + `<option value="${ls_options}">${ ls_options.toUpperCase().trim()}</option> `;
            });
            texto = texto + ` 
                </select>                                                                                                         
            </div>                                                                                                            
            `;
            return texto;
        }









        function Orden_A() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            /*var texto='';
                    texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                    texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
                    document.getElementById('respuesta').innerHTML=texto;
            */
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            //document.getElementById('formuF').style.visibility='hidden';
            //document.getElementById('Orden_P').style.visibility='visible';
            texto = '';
            texto = texto + '<select id="tiempo" onchange="Ord_pendientesA();" class="browser-default light-black-text" style="width: 300px;">';
            texto = texto + '<option value="" disabled selected >Seleccione Consulta</option>';
            texto = texto + '<option value="General">Informe General</option>';
            texto = texto + '<option value="Progreso">Progreso</option>';
            texto = texto + '<option value="GANADERIA">Ganaderia</option>';
            texto = texto + '<option value="Cancelado">Cancelado</option>';
            texto = texto + '<option value="Transferido">Transferido</option>';
            texto = texto + '<option value="PETS">Pets</option>';
            texto = texto + '<option value="LABORATORIOS">Laboratorios</option>';
            texto = texto + '</select>';
            //texto=texto + '<div class="input-field col s3">';
            //texto=texto + '<br /><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Ord_pendientesP();">Buscar</a><center>';   
            //texto=texto + '</div>';
            document.getElementById('frmbuscar').innerHTML = texto;
            //Ord_pendientesP();
        }

        function buscarDatosProcesosP() {
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            texto = `
            <center>                                                                                                                                                                                                                                           
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarProcesoActualP();" style="text-transform: capitalize;font-weight: bold;" title="Aún no se define query para este modulo">Proce terminados hoy</a>&nbsp;&nbsp;        
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarProcesoPendienteP();" style="text-transform: capitalize;font-weight: bold;"title="Aún no se define query para este modulo">Proce Pendientes hoy</a>&nbsp;&nbsp;      
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarSeparacionAlistamientoP();" style="text-transform: capitalize;font-weight: bold;">Separaci&oacute;n y Alistamiento</a>&nbsp;&nbsp;                                   
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="formulario_control('consultar_informe','Validación y Empaque','bodega/Inf_ValidacionEmpaque');" style="text-transform: capitalize;font-weight: bold;">Validaci&oacute;n y Empaque</a>&nbsp;&nbsp;                                             
                <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="formulario_control('consultar_informe','Despachos','Portos/Despachos_Bus');" style="text-transform: capitalize;font-weight: bold;">Despachos</a>&nbsp;&nbsp;                                                                              
                
                
                </center>                                                                                                                                                                                                                                          
                `;
            /*
            <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarValidacionEmpaqueP();" style="text-transform: capitalize;font-weight: bold;">Validaci&oacute;n y Empaque</a>&nbsp;&nbsp;                                             
            */
            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function Despachos() {
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('frmbuscar').innerHTML = '';
            texto = '';
            texto = texto + '<div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">Despachos</div>';

            texto = texto + '<div class="input-field col s3" style="width:450px; float: left;">';
            texto = texto + '<table><tr><td>Fecha Inicio: <hr style="width: 90%;"><input type="date" maxlength="2" id="inicial" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td>';
            texto = texto + '<td>Fecha Fin: <hr style="width: 90%;"><input type="date" maxlength="2" id="fin" name="trip-start" value="PQR-" min="2018-01-01" max="2022-12-31"></td><tr></table>';
            texto = texto + '<tr><td colspan="12"><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="DespachosB();">Generar</a><center>';
            texto = texto + '</td></tr></table>';
            texto = texto + '</div>';
            document.getElementById('frmbuscar').innerHTML = texto;
        }

        function DespachosB() {
            //var ini=document.getElementById('inicial').value;
            var ini = document.getElementById('inicial').value;
            var fin = document.getElementById('fin').value;
            if (ini == "") {
                alert("Seleccione Fecha Inicial");
                return false;
            }
            if (fin == "") {
                alert("Seleccione Fecha Final");
                return false;
            }
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Portos/Despachos_Bus.php?i=' + ini + '&f=' + fin, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        //document.getElementById('Carguesi').style.visibility='hidden';
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }

        function buscarDatosProcesosA() {
            /*document.getElementById('cartera1').style.visibility='hidden';
            document.getElementById('cartera2').style.visibility='hidden';
            document.getElementById('cartera3').style.visibility='hidden';
            document.getElementById('cartera4').style.visibility='hidden';
            document.getElementById('cartera5').style.visibility='hidden';*/
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';
            /*
             var texto='';
                     texto=texto + '<div id="cartera1" style="height: 300px; width: 48%; border: 1px solid #ddd; background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                     texto=texto + '<div id="cartera2" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                     texto=texto + '<div id="cartera3" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                     texto=texto + '<div id="cartera4" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll; float: left;"></div>';
                     texto=texto + '<div id="cartera5" style="height: 300px;width: 48%;border: 1px solid #ddd;background: #f1f1f1;overflow-y: scroll;"></div>';
                     document.getElementById('respuesta').innerHTML=texto;
             */

            texto = '';
            texto = texto + '<center>';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarProcesoActualA();" style="text-transform: capitalize;font-weight: bold;">Procesos terminados hoy</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '<a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="buscarProcesoPendienteA();" style="text-transform: capitalize;font-weight: bold;">Procesos Pendientes hoy</a>&nbsp;&nbsp;&nbsp;';
            texto = texto + '</center>';

            document.getElementById('parametros').innerHTML = texto;
            return true;
        }

        function Busc_Produ() {
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').style.visibility = 'visible';
            document.getElementById('respuesta').innerHTML = '';

            var texto = '';
            var lista_bodegas = [
                "PDES - Prueba Destruccion",
                "001 - BODEGA-001-CONTABILIDAD",
                "003 - BODEGA-003-LABORTORIO 73",
                "005 - BODEGA-005-CALLE 73",
                "004 - BODEGA-004-PROMOCIONALES IMPORTADOS Y SUMINISTROS",
                "006 - BODEGA-006-CALIDAD 73 ",
                "007 - BODEGA-007-CALIDAD PORTOS",
                "008 - BODEGA-008-CEDI PORTOS",
                "020 - BODEGA-020-RAPPI BOSQUE",
                "030 - BODEGA-030-RAPPI  ANIMAL FACTOR",
                "040 - BODEGA-040-RAPPI CHIA",
                "050 - BODEGA-050-RAPPI TOBERIN",
            ];


            texto = texto + `
            
        <div style="width: 500px; text-align: center;" class="#439049 green darken-1 white-text text-darken-2" style="font-size:1.5vw;text-align:center;color:white;">
            Ingrese Producto.
        </div>                                                                                      
        <div class="input-field col s8" style="width: 200px;">                                                                                                                                                                                                                     
            
        </div>   
        <div>                 
        <table>
            
            <tr>
                <td>
                    <select id="Bodega" class="browser-default light-black-text" style="width: 100%;">                                                                                                                                                                       
                        <option value="" disabled selected >Seleccione Una Bodega</option>                                                                                                                                                                                                         
                        <option value="TODAS">TODAS</option>                                                                                                                                                                                                         
                                    `;
            lista_bodegas.forEach(data => {
                texto = texto + `<option value="${data.substr(0,4).trim()}">${ data.toString() } </option>   `;
            });
            texto = texto + `                                                                                                                                                                                                  
                    </select>       
               </td>
            </tr>
            <tr>
                <td>
                    <input id="Producto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();" key placeholder="Producto o Cod. Producto" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />   
                    <label for="Producto"></label>                                                                                                                                                                                                                                              
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-field col s3" style="width: 200px;">                                                                                                                                                                                                                     
                        <center>
                            <a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="Cod_Producto_Bus();">
                            Buscar
                            </a>
                        <center>                                                                                                                                              
                    </div>                                                                                                                                                                                                                                                                     
                </td>
            </tr>
        </table>                                                                                                                                                                                                                                                           
        </div>                                                                                                                                                                                                                                                                     
                `;
            document.getElementById('parametros').innerHTML = texto;
        }

        function Admin() {
            texto = '';
            document.getElementById('frmbuscar').innerHTML = '';
            document.getElementById('respuesta').innerHTML = '';
            document.getElementById('estado').innerHTML = ''

            texto = texto + '<div class="flow-text #439049 green darken-1" style="width:450px; font-size:1.5vw;text-align:center;color:white;">Usuario a Buscar</div>';

            texto = texto + '<div class="input-field col s3" style="width:450px; float: left;">';
            texto = texto + '<table><tr><input id="Bus" value="" placeholder="Usuario a Buscar" maxlength="15" type="text" class="validate" style="background-color: white; font-size: 1.4em; text-align: center;" />';
            texto = texto + '<label for="Bus"></label></tr>';
            texto = texto + '<tr><td colspan="12"><center><a class="waves-efect waves-light btn #E67402 orange darken-1" onclick="AdminB();">Buscar</a><center>';
            texto = texto + '</td></tr></table>';
            texto = texto + '</div>';

            document.getElementById('parametros').innerHTML = texto;
        }

        function AdminB() {
            //var ini=document.getElementById('inicial').value;
            //var fin=document.getElementById('fin').value;
            var Bus_usu = document.getElementById('Bus').value;
            //alert("busqueda: "+Bus_usu);
            //return false;
            document.getElementById('estado').innerHTML = '<center><img src="img/escribe.gif" width="180px" height="180px"></center>';
            document.body.style.cursor = 'wait';
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'Admin/Admin_usuarios.php?b=' + Bus_usu, true);
            peticion_http.send(null);

            function muestraContenido() {
                //alert(dato1);
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        //alert(dato);
                        document.body.style.cursor = 'auto';
                        document.getElementById('estado').innerHTML = '';
                        document.getElementById('respuesta').innerHTML = dato;
                        //document.getElementById('formuF').style.visibility='hidden';
                        //document.getElementById('Carguesi').style.visibility='hidden';
                        document.getElementById('frmbuscar').innerHTML = '';
                    }
                }
            }
            document.getElementById('parametros').innerHTML = '';
        }

        function Salir() {
            // Obtener la instancia del objeto XMLHttpRequest
            if (window.XMLHttpRequest) {
                peticion_http = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Preparar la funcion de respuesta
            peticion_http.onreadystatechange = muestraContenido;
            // Realizar peticion HTTP
            peticion_http.open('POST', 'cerrarSesion.php', true);
            peticion_http.send(null);

            function muestraContenido() {
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {
                        var dato = peticion_http.responseText;
                        alert("Usted a salido.");
                        setTimeout("location.reload(true);", 500);
                        location.href = "user_conect_odoo.php";
                    }
                }
            }
        }

        function validar_rango(valor) {


            // var fecha = document.getElementById("ocultarPeriodo");
            // var anio = document.getElementById("anio");
            var anio_mes = document.getElementById("anio_mes");
            var desde = document.getElementById("td_desde");
            var hasta = document.getElementById("td_hasta");
            // var mes = document.getElementById("Mes");
            var periodo = document.getElementById("Por_Fechas");
            var mes;
            var anio;

            if (valor === 'Por_Fechas' || valor === 'selected') {
                desde.style.display = 'block';
                hasta.style.display = 'block';
                campos_en_blanco();
            } else if (valor === 'anio_mes') {
                desde.style.display = 'none';
                hasta.style.display = 'none';
                campos_en_blanco();
            } else if (valor !== 'Por_Fechas' && valor !== 'selected' && valor.length > 0) {
                desde.style.display = 'none';
                hasta.style.display = 'none';
                campos_en_blanco();
            } else if (valor === ' ' || valor === '' || valor.length == 0) {
                desde.style.display = 'none';
                hasta.style.display = 'none';
                asignar_valor();
            } else {
                desde.style.display = 'none';
                hasta.style.display = 'none';
                asignar_valor();
            }
        }

        function pop_up_confirmar() {
            let confirmAction = confirm("Desea Continuar?");
            if (confirmAction) {
                alert("Siguiente");
            } else {
                alert("Conacelado");
            }
        }

        function clear_date(fecha, return_data) {
            var data;
            if (return_data === 'anio') {
                data = fecha.toString().replace(/-/g, "").substring(0, 6).substring(0, 4);
            } else if (return_data === 'anio_hasta') {
                data = fecha.toString().replace(/-/g, "").substring(0, 6).substring(0, 4);
            } else if (return_data === 'mes') {
                data = fecha.toString().replace(/-/g, "").substring(0, 6).slice(-2);
            } else if (return_data === 'mes_hasta') {
                data = fecha.toString().replace(/-/g, "").substring(0, 6).slice(-2);
            } else if (return_data === 'dia') {
                data = fecha.toString().replace(/-/g, "").substring(0, 10).slice(-2);
            } else if (return_data === 'dia_hasta') {
                data = fecha.toString().replace(/-/g, "").substring(0, 10).slice(-2);
            } else {
                data = 'sin fechas ';
            }
            return data;
        }
    </script>
    <style>
        .rojo {
            background-color: #E52428;
            height: 60px;
        }
    </style>

</head>

<body>

    <div class="container" style="width: 98%;">

        <div class="row #439049 green darken-1" style="padding: 5px;">
            <!--logo #439049 green darken-1, #1565c0 blue darken-2-->
            <div class="col">
                <img class="responsive-img center " src="img/logoAG.png" style="width: 2.5em;" />&nbsp;&nbsp;<label style="font-size: medium; color: whitesmoke; font-weight: bold;">Informes Odoo</label>
            </div>
            <!--menu blue #3980C3-->
            <div class="col right #439049 green darken-1">
                <nav class="right #E67402 orange darken-1" style="height: 50px;">
                    <ul id="nav-mobile" class="right #439049 green darken-1" style="height: 0.5em;">
                        <?php
                        $verboton = strpos($btnPrim, '4');
                        if ($verboton !== FALSE || $pasa == true) {
                        ?>
                            <!-- boton informe rosalbina -->
                            <!-- <li><a href="javascript:Gerencia_Ven() disable "><b>GERENCIA</b></a>&nbsp;</li> -->
                            <li><a href="javascript:Gerencia_Ven()"><b>GERENCIA</b></a>&nbsp;</li>
                            <li class="col #439049 green darken-1" style="height: 60px;  ">&nbsp;</li>
                        <?php
                        }
                        $verboton = strpos($btnPrim, '3');
                        if ($verboton !== FALSE || $pasa == true) {
                        ?>
                            <li>
                                <a href="javascript:Ministerio()" class="a_menues"><b>MINISTERIO</b>
                                </a>&nbsp;
                            </li>
                            <li class="col #439049 green darken-1" style="height: 60px;">&nbsp;</li>
                        <?php
                        }
                        $verboton = strpos($btnPrim, '2');
                        if ($verboton !== FALSE || $pasa == true) {
                        ?>
                            <li><a href="javascript:Portos()" class="a_menues"><b>PORTOS</b></a>&nbsp;</li>
                            <li class="col #439049 green darken-1" style="height: 60px;">&nbsp;</li>
                        <?php
                        }
                        $verboton = strpos($btnPrim, '1');
                        if ($verboton !== FALSE || $pasa == true) {
                        ?>
                            <li><a href="javascript:Almacen()"><b>ALMACEN</b></a>&nbsp;</li>
                            <li class="col #439049 green darken-1" style="height: 60px;">&nbsp;</li>
                        <?php
                        }
                        ?>
                        <!--<a href="javascript:Salir()">Salir</a>-->
                    </ul>

                </nav>

            </div>

        </div>

        <!--contenidos #F0F0F0-->


        <div class="row #F0F0F0 gray darken-1">
            <label style="float: right;"><?php echo $_SESSION['nomu']; ?>&nbsp;<a href="javascript:Salir()">Salir</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <?php
            if ($pasa == true) {
            ?>
                <label style="float: right;"><a href="javascript:Admin()">Admin</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <?php
            }
            ?>
            <div class="col" id="formu">

            </div>
        </div>
        <div class="row">
            <label style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filtros de busqueda:</label>
            <hr style="width: 100%;" />
            <div class="col" id="parametros">

            </div>
            <?
            if (isset($_POST['Enviar'])) {
                $inic = $_POST['iniciox'];
                $fin = $_POST['finx'];
                $KitsA = $_POST['kitsB'];
                //$dir_subida = '/var/www/html/modulo_plan/informes/Meses/';
                $dir_subida = '/var/www/html/modulo_odoo/Informes/Kits/archivos/';
                $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);
                if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
                    echo "El archivo se subio bien.\n";
                } else {
                    echo "�Falla de subida de archivo!\n";
                }
                sleep(5);
                //ENVIA DATOS A LA BASE DEL MES
                //excel
                $archis = $_FILES['fichero_usuario']['name'];
                $miruta = 'Kits/archivos';
                $mipath = $miruta . '/' . $archis;
                //echo $mipath;
                if (file_exists($mipath)) {

                    include('Kits/Inf_Kits_Agronotas.php');
                } else {
                    echo "Archivo no encontrado en el servidor. datos no fueron actualizados.";
                }
            }
            ?>
            <!--<div class="col" id="estado">-->

            <!--</div>-->
        </div>
        <div class="row">
            <div class="col" id="estado"></div>
        </div>

        <!-- 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
-->
        <?php






        ?>

        <!-- 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
     XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX=======================================XXXXXXXXXXXXXXXXXXXXXXXXXXXX 
-->


        <p>
            <label id="Carguesi"></label>
        <div id="frmbuscar"></div>
        <br />
        <div id="respuesta" style="
        height: 400px; 
        width: 100%; 
        border: 1px solid #ddd; 
        background: #f1f1f1;
        overflow-y: auto;
        overflow-x: auto;
        float: left;
        
        ">

        </div>

        <br />

        </p>
        <div class="col" id="estado"></div>
        <?php
        if (isset($_POST['Enviar1'])) {
            echo "aqui";
            if ($_FILES['file']['name'] != '') {
                $test = explode('.', $_FILES['file']['name']);
                $extension = end($test);
                $name = rand(100, 999) . '.' . $extension;

                $location = '/var/www/html/modulo_odoo/Informes/Kits/archivos/' . $name;
                move_uploaded_file($_FILES['file']['tmp_name'], $location);

                echo "archivo";
                //echo '<img src="'.$location.'" height="100" width="100" />';
            }
        }
        // En versiones de PHP anteriores a la 4.1.0, deber�a utilizarse $HTTP_POST_FILES en lugar
        // de $_FILES.
        /*if (isset($_POST['Enviar1'])){
                                    $dir_subida = '/var/www/html/modulo_odoo/Informes/Kits/archivos/';
                                    $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);
                                    if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
                                        echo "El archivo se subio bien.\n";
                                    } else {
                                        echo "�Falla de subida de archivo!\n";
                                    }
                                    sleep(5);
                                           
                                    
                                }*/
        ?>
        <!--fin container-->
    </div>


</body>
<?php


?>

</html>