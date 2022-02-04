<?php
/*
$archivo="informe.txt";
$myfile = file_put_contents($archivo, $msgtxt.PHP_EOL , FILE_APPEND);
*/
$t=0;
$tarea = new ArrayIterator();
$fp = fopen("tareaejemplo.txt", "r");
while (!feof($fp)){
    $tarea[$t] = fgets($fp);
    $t++;
}
echo $tarea[0]."<br><hr>";
//encabezado
//aqui ciclo para todas las tareas**
$f=0;
$compartida=new ArrayIterator();
$cabecera = explode('body', $tarea[0] );
foreach ( $cabecera as $compartida[$f] ) {
     //echo $palabra.'<hr>';
     $f++;
}
//echo $compartida[1]."<br><hr>";

$aux=explode('author', $compartida[0] );
$auxb=explode('title', $aux[0]);
$aux2=str_replace('":"',"",$auxb[2]);
$nomtareap=str_replace('","',"",$aux2);
echo "<b>tarea padre:</b> ".$nomtareap."<br><hr>";

$aux=explode('author', $compartida[0] );
$auxb=explode('title', $aux[0]);
$auxc=explode('id', $auxb[1]);
$auxd=str_replace('":',"",$auxc[1]);
$idtareausuariop=str_replace(',"',"",$auxd);
echo "<b>Id Tarea usuario padre: </b>".$idtareausuariop."<br><hr>";

$aux=explode('author', $compartida[2] );
$auxb=explode('name', $aux[0] );
$aux2=str_replace('\":\"',"",$auxb[1]);
$nomproyectop=str_replace('\"}]","',"",$aux2);
echo "<b>Proyecto padre: </b>".$nomproyectop."<br><hr>";

$aux=explode('author', $compartida[1] );
$auxb=explode('title', $aux[1]);
$auxc=explode('dateCreated', $auxb[0]);
$auxd=explode(',', $auxc[1]);
$aux2=str_replace('":"',"",$auxd[0]);
$fechatareap=str_replace('"',"",$aux2);
echo "<b>Fecha tarea padre: </b>".$fechatareap."<br><hr>";

//autor***
$aux=explode('author', $compartida[1] );
$auxb=explode('dateCreated', $aux[1]);
$aux2=str_replace('","',"",$auxb[0]);
$aux3=str_replace('":"',"",$aux2);
echo "<b>Codigo Autor tarea padre: </b>".$aux3."<br><hr>";
//exloto por el codigo del autor
//separador usuario + cadena =      aaczMhR12sZp\"\u003e\u0026#64
//cadena anterior al que pone la tarea
$x=$aux3.'\\"\u003e\u0026#64';
$auxb=explode($x, $tarea[0]);
$auxc=explode('\u003c/a\u003e', $auxb[1]);
$autortareap=str_replace(';',"",$auxc[0]);
echo "<b>Autor tarea padre: </b>".$autortareap."<br><hr>";
//fin autor***

//compartida con
$aux=explode('shared', $tarea[0]);
$auxb=explode('comments', $aux[1]);
$auxc=explode('bot', $auxb[0]);
$auxd=explode('Forms', $auxc[1]);

$avatar=str_replace('-',"",$auxd[0]);


$shared1=str_replace('":["',"",$auxc[0]);
$shared1b=str_replace('"',"",$shared1);
$shared1c=substr($shared1b,0,strlen($shared1b)-1);  //lee antes de la utima coma
$auxcon1=explode(',', $shared1c);
$conshared1=count($auxcon1);
//usuarios compartidos
//$r='1029595\" rel\u003d\".usuariocompartido.\"\u003e\u0026#64;';
//$auxcon1=explode(',', $shared1c);
$i=0;
/*while($i < $conshared1){
    $auxcon1=explode(',', $shared1c);
    //traer e la derecha la cadena siguiente incluida la cadena
    $usu=$auxcon1[$i];  //'QmqANJNkRXnF';
    $r=$usu.'\"\u003e\u0026#64;';
    //busca con explode en array
    $nom_comp=explode($r, $tarea[0]);
    $nom_comp2=explode('\u003c/a\u003e', $nom_comp[1]);
    echo "<b>compartida $i: </b>".$auxcon1[$i]."---".$nom_comp2[0]."<br><hr>";
    
    $i++;    
}
*/



$shared2=str_replace('":["',"",$auxd[1]);
$shared2b=str_replace('"',"",$shared2);
$shared2c=substr($shared2b,1,strlen($shared2b)-3);  //lee antes de la utima coma
$auxcon2=explode(',', $shared2c);
$conshared2=count($auxcon2);

echo "<b>avatar: </b>".$avatar."<br><hr>";
echo "<b>Compartida1 con: </b>".$shared1c."<br><hr>";
echo "<b>cantidad1 </b>".$conshared1."<br><hr>";
echo "<b>Compartida2 con: </b>".$shared2c."<br><hr>";
echo "<b>cantidad2 </b>".$conshared2."<br><hr>";

//USUARIOS COMPARTIDAS  cadena de busqueda entre \"\u003e\u0026#64; usuario  \u003c/a\u003e
    //$usu='Jc0jgKs3Rmwe';
    /*$r1='\"\u003e\u0026#64;';
    $r2='\u003c/a\u003e';
    //busca con explode en array
    $nom_comp=explode($r1, $tarea[0]);
    $contacomp=count($nom_comp);
    $i=1;
    while($i<$contacomp){
        $nom_comp2=explode($r2, $nom_comp[$i]);
        $nom_comp3=$nom_comp2[0];
        $r3='\u003cbr /\u003e","author":"';
        $msg1=explode($r3,$nom_comp2[1]);
        $msg=$msg1[0];
        echo "<b>compartida $i: </b>".$nom_comp3."---msg---:".$msg."<br><hr>";
        $i++;
    }
    */
$subt=explode('{"body":', $tarea[0]);
$contacomp=count($subt);
    $i=0;
    while($i<$contacomp){
        echo "<b>tarea $i: </b>".$subt[$i]."<br><hr>";
        $r=explode(';', $subt[$i]);
        $contacomp2=count($r);
        $j=0;
        while($j<$contacomp2){
            echo "<b>componente $j: </b>".$r[$j]."<br><hr>";
            $j++;
        }
        $i++;
    }

$aux=explode('importance', $compartida[0] );
$auxb=explode('title', $aux[0]);
$aux2=str_replace('":"',"",$auxb[1]);
$estadotareap=str_replace('"},"',"",$aux2);
echo "<b>Estado tarea padre: </b>".$estadotareap."<br><hr>";

$aux=explode('description', $compartida[0] );
$auxb=explode('\u003cbr', $aux[1]);
$auxc=str_replace('":"',"",$auxb[0]);
$aux2=str_replace('\u003',"",$auxc);
$aux3=str_replace('\u003ctd',"",$aux2);
$aux4=str_replace('\u003ctr',"",$aux3);
$aux5=str_replace('\u003e',"",$aux4);
$aux6=str_replace('cstronge',"",$aux5);
$aux7=str_replace('c/',"",$aux6);
$aux8=str_replace('stronge',"",$aux7);
$descriptareap=str_replace('\u003c',"",$aux8);
echo "<b>Descripcion tarea padre: </b>".utf8_encode($descriptareap)."<br><hr>";






/*
$r=substr($compartida[0],13,strlen($compartida[0]));
$sharing=substr($r,0,strlen($r));
echo '<br>'.$sharing.'<hr><hr>';
*/
//echo '<br /><br /><br />'.$palabra[0] . '<br />Registros: '.$f.'<br />';

/*$c=SHA1('');
echo $c."<br>";
$c=sh1('Diego Ramirez');
echo $c."<br>";
*/
//$c='cty';
//$Sig = "hola:". base64_decode(hash_hmac('sha256', 'jairo.cardozo@agrocampo.com.co', $c, true));
/*class Password {
    const SALT = '1614603779';
    public static function hash($password) {
        return hash('sha256', self::SALT . $password);
    }
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}*/
// Crear la contraseña:
//$hash = password_hash('1614603779', PASSWORD_DEFAULT, [5]);
//$hash = Password::hash('1614603779');
//echo $hash;
//echo "correobase64: b3pvZHJhYy5vcmlhag==";

//compartido con:
/*$array2 = explode ('status', $palabra[0] );
     foreach ( $array2 as $palabra2 ) {
        echo $palabra2 . '<br /><br /><br />************************<br>';
     }
   */  
     
     
     
     
//$fila = 1;
/*while (($datos = fgetcsv($fp)) !== FALSE) {
        $numero = count($datos);
        echo "\n";
        $fila++;
        for ($i = 0; $i < $numero; $i++){
            echo $datos[$i] . "\t";
        }
        echo "\nFrase: el tipo de animal es {$datos[0]} y se llama {$datos[1]} <br>";
    }
    */
//$d="";
/*while (false !== ($caracter = fgetc($fp))) {
        $d=$d.$caracter;
        $c=strlen($d);
        if($c==4 && $d=="body"){
            echo $d."<br>";
            $d="";
        }
    }
*/

?>