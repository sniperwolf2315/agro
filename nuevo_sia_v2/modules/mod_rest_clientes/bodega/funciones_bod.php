<?php

function estados($ventanilla,$turno,$placa,$est_act) {
    return "
    <select name="."ESTADOS"." id="."ESTADOS"." class"."ESTADOS"." 
    onchange="."cambiarestado(this.value,'$ventanilla','$turno','$placa','$est_act')"." >
        <option value=".""." disabled selected></option>
        <option value="."ESPERA".">ESPERA</option>
        <option value="."CARGA".">CARGA</option>
        <option value="."SALIDA".">SALIDA</option>
    </select>
    ";
}



function estados_2() {
    return "
    <input list="."ESTADOS"." placeholder="."ESTATUS"." >
    <datalist name="."ESTADOS"." id="."ESTADOS"." class"."ESTADOS".">
        <option value="."ESPERA".">ESPERA</option>
        <option value="."CARGA".">CARGA</option>
        <option value="."SALIDA".">SALIDA</option>
    </datalist>
    ";
}



function guardar( $btn_opciones ) {

}

?>