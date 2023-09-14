<html>
    <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
</head>
<body>
    <!-- <button onclick="msj();">Avisarme!</button> -->
    <button onclick="notifyMe();">Avisarme!</button>
<script>
// Pedimos permiso (el navegador nos preguntará)
Notification.requestPermission()
// Consultar de forma estándar el permiso
Notification.permission
// Consultar de forma estándar el permiso
window.webkitNotifications.checkPermission()

function  notifyMe()  {  
    if  (!("Notification"  in  window))  {   
        alert("Este navegador no soporta notificaciones de escritorio");  
    }  
    else  if  (Notification.permission  ===  "granted")  {
        var  options  =   {
            body:   "Descripción o cuerpo de la notificación",
            icon:   "url_del_icono.jpg",
            dir :   "ltr"
        };
        var  notification  =  new  Notification("Hola :D", options);
    }  
    else  if  (Notification.permission  !==  'denied')  {
        Notification.requestPermission(function (permission)  {
            if  (!('permission'  in  Notification))  {
                Notification.permission  =  permission;
            }
            if  (permission  ===  "granted")  {
                var  options  =   {
                    body:   "Descripción o cuerpo de la notificación",
		            icon:   "url_del_icono.jpg",
		            dir :   "ltr"
                };     
                var  notification  =  new  Notification("Hola :)", options);
            }   
        });  
    }
}
function msj(){
    
    Push.Permission.request();
    Push.Permission.has();
    Push.Permission.get();
    Push.create("Hola Erik !", {
    body: "Esto es una prueban'?",
    icon: '/icon.png',
    timeout: 4000,
    onClick: function () {
        window.focus();
        this.close();
    }
    });
    
}


</script>


<script>
        if(Notification.permission !== "granted"){
            Notification.requestPermission();
        }
        
        function notificar(){
            if(Notification.permission !== "granted"){
                Notification.requestPermission();
            }else{
                var notificacion = new Notification("Titulo",
                    {
                        icon: "https://jonathanmelgoza.com/wp-content/themes/jonathanmelgoza/images/header_menu_rs_btn.png",
                        body: "Texto de la notificación"
                    }
                );
                
                notificacion.onclick = function(){
                    window.open("https://jonathanmelgoza.com/blog/");
                }
            }
        }
    </script>
</body>
<footer></footer>
</html>


















<html>
</html>

<script>


// Push.Permission.request(onGranted, onDenied);



// Push.create('Hi there!', {
//     body: 'This is a notification.',
//     icon: 'icon.png',
//     timeout: 8000,               // Timeout before notification closes automatically.
//     vibrate: [100, 100, 100],    // An array of vibration pulses for mobile devices.
//     onClick: function() {
//         // Callback for when the notification is clicked. 
//         console.log(this);
//     }  
// });
// Notification.requestPermission();
// Notification.requestPermission().then(function (result) {
//   console.log(result);
//   alert(result);
// });



function askNotificationPermission() {
  // función para pedir los permisos
  function handlePermission(permission) {
    // configura el botón para que se muestre u oculte, dependiendo de lo que
    // responda el usuario
    if (
      Notification.permission === "denied" ||
      Notification.permission === "default"
    ) {
      notificationBtn.style.display = "block";
    } else {
      notificationBtn.style.display = "none";
    }
  }

  // Comprobemos si el navegador admite notificaciones.
  if (!("Notification" in window)) {
    console.log("Este navegador no admite notificaciones.");
  } else {
    if (checkNotificationPromise()) {
      Notification.requestPermission().then((permission) => {
        handlePermission(permission);
      });
    } else {
      Notification.requestPermission(function (permission) {
        handlePermission(permission);
      });
    }
  }
}


// function notifyMe() {
//   // Let's check if the browser supports notifications
//   if (!("Notification" in window)) {
//     alert("This browser does not support desktop notification");
//   }
 
//   // Let's check whether notification permissions have already been granted
//   else if (Notification.permission === "granted") {
//     // If it's okay let's create a notification
//     var notification = new Notification("Hi there!");
//   }
 
//   // Otherwise, we need to ask the user for permission
//   else if (Notification.permission !== 'denied') {
//     Notification.requestPermission(function (permission) {
//       // If the user accepts, let's create a notification
//       if (permission === "granted") {
//         var notification = new Notification("Hi there!");
//       }
//     });
//   }
 
//   // At last, if the user has denied notifications, and you 
//   // want to be respectful there is no need to bother them any more.
// }Notification.requestPermission().then(function(result) {
//   console.log(result);
// });function spawnNotification(theBody,theIcon,theTitle) {
//   var options = {
//       body: theBody,
//       icon: theIcon
//   }
//   var n = new Notification(theTitle,options);
// }
</script>
