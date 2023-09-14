function loadspinner(msj) {

    msj = (msj=='')?'!Bienvenido al tracking unificado Agrocampo':msj;

    const showLoading = function () {
        Swal.fire({
            title: `${msj}`,
            allowEscapeKey: true,
            allowOutsideClick: true,
            background: '#fff',
            showConfirmButton: false,
            onOpen: () => {
                Swal.showLoading();
            }

            , timer: 2000
            // , timerProgressBar: true
        });
    };

    showLoading();
}

function viewspinner() {

    Swal.fire('Consultando...')
    Swal.showLoading()
    
}
function closespinner() {
    loadspinner('Término');

}