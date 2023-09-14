// console.log('si se llama');


function imprimir() {
    if (window.print) {
        window.print();
    } else {
        alert("La función de impresion no esta soportada por su navegador.");
    }
}