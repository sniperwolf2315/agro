function validar_check(valor_chk) {
    chk_turno = document.getElementById('Trabajo_Agrocampo');
    chk_visitante = document.getElementById('Visitante');
    chk_proveedor = document.getElementById('Proveedor');
    select_turno = document.getElementById('turno');
    chk_turno.disabled = false;
    chk_visitante.disabled = false;
    if (chk_proveedor !== null) {
        chk_proveedor.disabled = false;
    }


    // turno sabatino 
    if (valor_chk == 'Trabajo_Agrocampo' && chk_turno.checked) {
        chk_visitante.disabled = true;

        if (chk_proveedor !== null) { chk_proveedor.disabled = true; }

        select_turno.innerHTML = "<option> Ingreso </option><option>Salida_alm</option><option>Entrada_alm</option><option>Salida</option> ";
        select_turno.focus();
    } else if (valor_chk == 'Visitante' && chk_visitante.checked) {
        chk_turno.disabled = true;

        if (chk_proveedor !== null) { chk_proveedor.disabled = true; }

        select_turno.innerHTML = "<option> Ingreso </option><option>Salida</option> ";
        select_turno.focus();
    } else if (valor_chk == 'Proveedor' && chk_proveedor.checked) {
        chk_turno.disabled = true;
        chk_visitante.disabled = true;
        select_turno.innerHTML = "<option> Ingreso </option><option>Salida</option> ";
        select_turno.focus();
    }
}

function focus_doc() {
    chk_turno = document.getElementById('Trabajo_Agrocampo');
    chk_visitante = document.getElementById('Visitante');

    if (chk_turno.checked == false && chk_visitante.checked == false) {
        alert('FAVOR INDICAR UN MOTIVO DE INGRESO');
        chk_turno.focus();
    } else {
        select_doc = document.getElementById('identificacion');
        select_doc.focus();

    }

}

