
<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
<body>
    <h3> Evidencia servientrega </h3>
    <input id="numguia" name="numguia" class="numguia" value="2130601761">
    <br>
<div id="main"></div>
<textarea id="log"></textarea>
<br>
<img id="evidence" name ="evidence" >

<canvas width="300" height="150" id="img_servi" name="img_servi">CASA</canvas>
</body>

<script>

    let num_guia =  document.getElementById('numguia').value;
    let var_xml_guia = "";
    var rta_sevice = img_srvientrega(num_guia).then(resolve =>{
    // let OutPutFile = 


    const obj = parseXmlToJson(resolve);
    let var_img_guia = obj['Imagen'];
    // var img_decode = atob(var_img_guia);
    // var img_decode = base64ToArrayBuffer(var_img_guia);
    var img_decode = base64ToArrayBuffer(var_img_guia);


    document.getElementById("evidence").src = "data:image/png;base64," + img_decode;
    // var blob = base64toBlob(var_img_guia,'');
    console.log(img_decode);





    } ).catch(rejec => {
        console.log(rejec);
    }) ;

function base64ToArrayBuffer(base64) {
    var binaryString = atob(base64);
    var bytes = new Uint8Array(binaryString.length);
    for (var i = 0; i < binaryString.length; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    return bytes.buffer;
}



    /* FUNCION PARA CONSULTAR LA INFORMACION DE SERVIENTREGA */
    async function  img_srvientrega(numguia){
            let headersList = {"Accept": "*/*"}
            // let response = await fetch("http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuiaImagen?NumeroGuia=3047098561&BuscarImagen=true", { 
            let response = await fetch(`http://sismilenio.servientrega.com.co/wsrastreoenvios/wsrastreoenvios.asmx/ConsultarGuiaImagen?NumeroGuia=${numguia}&BuscarImagen=true`, { 
                method: "GET",
                headers: headersList
        });
        let data = await response.text();
        return data;
    }    



    /* FUNCION CONVERTIR STRING XML A JSON  */
    function parseXmlToJson(xml) {
        const json = {};
        for (const res of xml.matchAll(/(?:<(\w*)(?:\s[^>]*)*>)((?:(?!<\1).)*)(?:<\/\1>)|<(\w*)(?:\s*)*\/>/gm)) {
            const key = res[1] || res[3];
            const value = res[2] && parseXmlToJson(res[2]);
            json[key] = ((value && Object.keys(value).length) ? value : res[2]) || null;

        }
        return json;
    }

    let getXmlValue = function(str, key) {
    return str.substring(
        str.lastIndexOf('<' + key + '>') + ('<' + key + '>').length,
        str.lastIndexOf('</' + key + '>')
    );
    }
    function base64toBlob(base64Data, contentType) {
    contentType = contentType || '';
    var sliceSize = 1024;
    var byteCharacters = atob(base64Data);
    var bytesLength = byteCharacters.length;
    var slicesCount = Math.ceil(bytesLength / sliceSize);
    var byteArrays = new Array(slicesCount);

    for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
        var begin = sliceIndex * sliceSize;
        var end = Math.min(begin + sliceSize, bytesLength);

        var bytes = new Array(end - begin);
        for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
            bytes[i] = byteCharacters[offset].charCodeAt(0);
        }
        byteArrays[sliceIndex] = new Uint8Array(bytes);
    }
    return new Blob(byteArrays, { type: contentType });
}



</script>
