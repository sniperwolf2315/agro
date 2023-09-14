var ancho, largo;

ancho = screen.width;
alto = screen.height;




// console.log(`ancho ${ancho } y alto ${ alto }`);
// msj_back('pruebas');


function msj_back(mensaje) {
    Push.Permission.request();
    Push.create('Bienvenido a sia.agrocampo.com', {
        body: `${mensaje}`,
        icon: 'modules/assets/images/logo_agro.png',
        timeout: 8000,               // Timeout before notification closes automatically.
        vibrate: [150, 150, 150],    // An array of vibration pulses for mobile devices.
        onClick: function() {
            // Callback for when the notification is clicked. 
            console.log(this);
        }  
    });
    
}