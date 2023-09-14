function mostrar_login(ruta='index.php',ruta_false='index.php') {
    Swal.fire({
        title: 'Inicio sesion SIA antiguo',
        html: `
        <input type="text" id="login" class="swal2-input" placeholder="USUARIO SIA">
        <input type="password" id="password" class="swal2-input" placeholder="PASSWORD SIA">`,
        confirmButtonText: 'Iniciar',
        confirmButtonColor: '#ff8000',

        focusConfirm: true,
        preConfirm: () => {
            const login = Swal.getPopup().querySelector('#login').value
            const password = Swal.getPopup().querySelector('#password').value
            if (!login || !password) {
                Swal.showValidationMessage(`Por favor ingresar usuario  y contraseña`)
            }
            return { login: login, password: password }
        }
    }).then((result) => {
        //     Swal.fire(`//     Login: ${result.value.login}//     Password: ${result.value.password}// `.trim())
        Logueo(result.value.login, result.value.password,ruta,ruta_false);
    }).catch((err) => {
        Swal.fire(`Usuario no tiene permiso`);
    })
}

function Logueo(user_id, user_pass,ruta,ruta_false) {
    var dato, pasa, func = '0';
    func = (user_id !== '' && user_pass !== '') ? '1' : '0';
    document.body.style.cursor = 'wait';
    if (window.XMLHttpRequest) {
        peticion_http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // Preparar la funcion de respuesta
    peticion_http.onreadystatechange = muestraContenido;
    // Realizar peticion HTTP
    // peticion_http.open('POST', '../moduloI/pags/ws_services_soap.php?user_log=' + user_id + '&pass_log=' + user_pass + '&ef=' + func, true);
    // peticion_http.open('POST', './nuevo_sia_v2/services/ws_services_soap.php?user_log=' + user_id + '&pass_log=' + user_pass + '&ef=' + func, true);
    peticion_http.open('POST', '/nuevo_sia_v2/services/ws_services_soap.php?user_log=' + user_id + '&pass_log=' + user_pass + '&ef=' + func, true);
    peticion_http.send(null);

    function muestraContenido() {
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                dato = peticion_http.responseText;
                if (dato !== undefined) {
                    if(dato.trim()=="NO" || dato.trim()=="no" || dato.trim()==""){
                        alert('No tiene permiso usuario o contraseña erronea');
                        window.location.href = ruta_false;
                        return;
                    }else{
                        if(ruta===''){
                            window.location.href = "index.php";
                        }else{
                            window.location.href = `${ruta}`;
                        }
                    }
                    // window.location.href = "../user_conect_ver.php?user=" + user_id + "&log=1";
                } else {
                    console.log('no ingreso');
                }
            }
        }
    }




}
