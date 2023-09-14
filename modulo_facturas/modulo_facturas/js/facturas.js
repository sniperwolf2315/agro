console.log('Si se importo');


// $(document).ready(function (){
(function () {
    $(".verloader").click(function () {
        $(".loader").show();
    });

    $(".verloaderB").change(function () {
        $(".loader").show();
    });

    $(".select2").select2();

});

// $(window).load(function() {
(function () {
    $(".loader").fadeOut("slow");
});


// $(window).load(function() {
(function () {
    document.getElementById('ancho').value = screen.width;
});

let existe_btn = document.body.contains(document.querySelector('#guarda'));
if (existe_btn !== false) {
    const btn_logo = document.querySelector('#guarda');
    btn_logo.addEventListener('click', function () {
        console.log('cl');
        
        let a, b, c, d, e, f, g;
        // a = document.getElementById('placa').value;
        // b = document.getElementById('tte').value;
        // c = document.getElementById('ter').value;
        // d = document.getElementById('tguia').value;
        // e = document.getElementById('num_guia').value;
        // f = document.getElementById('fact').value;
        // console.log('LOS CAMPOS SOn ' + a + '' + b + '' + c + '' + d + '' + e + '' + f + '\n');

        // console.log('si dio click en guardar \n');
        // const side_bar =  document.getElementById('sidebar');
        // const content_ped =  document.getElementById('content_ped');
        // side_bar.classList.toggle('active');
        // content_ped.classList.toggle('active');
        // btn_toggle.style.display="none";
    });
}


let existe = document.body.contains(document.getElementById('tguia'));

if (existe !== false) {
    const tiene_guia = document.getElementById('tguia').value;
    // let numero_guias = document.getElementById('num_guia');
    let numero_guias = document.getElementById('guia');

    if (tiene_guia == 'NO') {
        numero_guias.value = 'TER';
        numero_guias.disabled = true;
    }

    // console.log('El valor de la guia es ' + tiene_guia);

}


function vlr_guia() {
    let pregunta_guia = document.getElementById('tguia').value;
    let numero_guia = document.getElementById('guia');
    var status = (pregunta_guia == 'SI') ? false : true;
    let valor = (pregunta_guia == 'NO') ? 'TER' : "";
    numero_guia.disabled = status;
    numero_guia.value = valor;
}


function setReadonly() {
    var myElement = document.getElementById("fact");
    myElement.readOnly = true;

}

function setDisabled() {
    var myElement = document.getElementById("fact");
    myElement.disabled = true;

}

function sleepFor(sleepDuration) {
    var now = new Date().getTime();
    while (new Date().getTime() < now + sleepDuration) { /* do nothing */ }
}



function popUp(URL) {
    window.open(URL, 'agrocampo config', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=300,left = 400,top = 250');
  }
  