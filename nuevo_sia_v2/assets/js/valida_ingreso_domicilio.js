document.oncontextmenu = function () { return false; }
// document.onkeydown = function () { return false; }


var nacionaliadad;
document.getElementById('nac').style.display = "none";
document.getElementById('ext').style.display = "none";



function dimePropiedades(valor) {
    if (valor == 'Nacional') {
        document.getElementById('nac').style.display = "block";
        document.getElementById('ext').style.display = "none";
        document.getElementById('ced_domi').focus();
        nacionaliadad = 1;
    } else if (valor == 'Extranjero') {
        document.getElementById('ext').style.display = "block";
        document.getElementById('nac').style.display = "none";
        document.getElementById('ced_domi_1').focus();
        nacionaliadad = 2;
    }

}



const querty_num = "1234567890";
const numero = "123 456 7890";

const idLetras = document.getElementById("letras");
const idDisposicionTeclado = document.getElementById("disposicionTeclado");

// funcion para mostrar contenido
const mostrarLetras = listadoLetras => {
    idLetras.innerHTML = "";
    listadoLetras.split('').map(el => {
        let span = document.createElement("span");
        span.addEventListener("click", teclaPulsada);
        span.innerText = el;
        if (el == " ") { span.classList.add("space"); }
        idLetras.appendChild(span);
    });
}

mostrarLetras(querty_num);

function teclaPulsada(e) {
    const tecla = this.classList && this.classList.contains("space") ? " " : this.innerText;
    if (numero.indexOf(tecla) >= 0) {
        if (nacionaliadad == 1) {
            document.getElementById("ced_domi").value += tecla;
        } else {
            document.getElementById("ced_domi_1").value += tecla;
        }
    }
}



if (this.span) {
    console.log('existe');
    Array.from(idDisposicionTeclado.querySelectorAll("span")).map(el => el.addEventListener("click", function () {
        // añadimos el estilo .selected al elemento seleccionado
        Array.from(idDisposicionTeclado.querySelectorAll("span")).map(el => el == this ? this.classList.add("selected") : el.classList.remove("selected"));
        mostrarLetras(eval(this.innerText.toLowerCase()));
    }));
}


const bt_enviar = document.querySelector('.btn_ced_domi');
bt_enviar.addEventListener('click', function () {
    swal("Buscando...", "Por favor, espere", {
        icon: "../../../assets/images/CARGA_12.gif",
        buttons: false,
        allowOutsideClick: false,
    })
})





