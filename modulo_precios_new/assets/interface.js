/* var enviar = document.getElementById('nro_copias');
var btn_enviar = document.getElementById('envio');
console.log(enviar);


if( enviar == null) {
btn_enviar.style.display="none";    
}else{
 btn_enviar.style.display="block";    
} */
function impimir_funcion_php(){
    console.log('si se ejecuto ');
    var result ="<?php erik()(); ?>"
    document.write(result);
}