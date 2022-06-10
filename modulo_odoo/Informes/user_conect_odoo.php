<?
if (session_start() === FALSE) {
    session_start();
}

$ip = $_SERVER['REMOTE_ADDR'];
//$error=$_GET['a'];
$error = $_SESSION['acc'];
if ($error == '1') {
    $msg = "Acceso Denegado, Usuario o Identificacion errada!";
} else {
    $msg = "BIENVENIDOS";
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Informes Odoo</title>
    <meta name="generator" content="Antenna 3.0">
    <meta http-equiv="imagetoolbar" content="no">
    <link rel="stylesheet" type="text/css" href="../../antenna.css" id="css">
    <style type="text/css">
        .abs {
            position: absolute
        }

        .auto-style1 {
            color: #FFFFFF;
        }

        .fimg {

            background-image: url('img/huellas.png');
            /*background-repeat:no-repeat;
    background-position:center;*/
            /*background-color: rgba(255, 255, 255, 0.3);*/
            border-radius: 5px;
            line-height: 1;
            /*backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);*/
            padding: 20px 40px;
        }
    </style>
    <script type="text/javascript" src="/antenna/auto.js"></script>
    <script>
        function cambiarRuta(url) {
            location.href = url;
            setTimeout("location.reload(true);", 500);
            return true;
        }
    </script>
</head>
<!--class="Aglobal"-->

<body class="fimg">
    <center>
        <br><br>
        <table style="height:478; width:471;">
            <tr>

                <td align="center" valign="bottom" style="background-image: url('../../images/agroc_logoINI.png'); background-repeat:no-repeat; background-position:center; ">

                    <table width=300 height="262" border=0 cellpadding="2" cellspacing="1" style=" top:400; ">
                        <form name="<?= rand() ?>" id="<?= rand() ?>" class="frxl" action="user_conect_odoo.php" method="post">
                            <tr>
                                <th colspan="2" style="height: 55px;">
                                    <font color="white">
                                        <center>CONSULTAS ODOO <br /><?php echo $msg; ?> </center>
                                    </font>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 46px">
                                    <font color="white">
                                        <center>
                                            <hr />
                                        </center>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 38px;" class="auto-style1">Usuario Odoo</td>
                                <td style="height: 38px">
                                    <input type="hidden" id="claves" name="claves" />
                                    <?
                                    //$lOGin= sha1(date("Y-m-d:H"));  
                                    //$pASs=  sha1(date("H:Y-m-d"));
                                    ?>
                                    <center><input autofocus style="height:20;width:150" autocomplete="off" name="UsuOdo" id="UsuOdo" type="text" value='' maxlength="50" /></center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font color="white">
                                        <center>Identificaci&oacute;n</center>
                                    </font>
                                </td>
                                <td>

                                    <center>
                                        <input style="height:20;width:150; letter-spacing:5px; font-family:gatos" autocomplete="off" name="passU" id="passU" type="text" maxlength="50" />
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td height="60" colspan="2">
                                    <center><input type="submit" name="Enviar" value="enviar"></center>
                                </td>
                            </tr>

                        </form>
                    </table>

                </td>
            </tr>
        </table>
    </center>
    <script>
        document.getElementById('claves').value = screen.width;
    </script>
    <?php
    //conexion odoo


    if (isset($_POST['Enviar'])) {

        $loginU = $_POST['UsuOdo'];
        $refU = $_POST['passU'];

        include_once 'usercon_odoo.php';
        Conexion::abrirConexion();
        $Conn = Conexion::obtenerConexion();

        $query1 = "select u.active, u.login, u.partner_id, rp.ref as refid, rp.name as nomb from res_users u left join res_partner rp ON u.partner_id=rp.id where u.login='$loginU' and u.active='true' and rp.ref='$refU'";

        $uId = "";
        $uStatus = "false";
        $resultado1 = $Conn->prepare($query1);
        $resultado1->execute();
        $datos1 = $resultado1->fetchAll();
        foreach ($datos1 as $dato1) {
            $uStatus = $dato1['active'];
            $uId = $dato1['partner_id'];
            $rfId = $dato1['refid'];
            $unom = $dato1['nomb'];
        }

        /*$lOGin= sha1(date("Y-m-d:H"));  
$loginBO = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));

$pASs=  sha1(date("H:Y-m-d"));
$passBO = trim(mb_strtoupper($_POST["$pASs"]));

*/

        //CONECCION DB2

        //echo "odbc_connect('IBM-AGROCAMPO',$loginBO,$passBO)";
        /*
$emP = "";
$handle = odbc_connect('IBM-AGROCAMPO-P',$loginBO,$passBO);
$result = odbc_exec($handle, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='AG- AGROCAMPO'; $emP = "DeNtR";
		}
		
$handleP = odbc_connect('IBM-PESTAR-P',$loginBO,$passBO);
$result = odbc_exec($handleP, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='X1- PESTAR'; $emP = "DeNtR"; 
		}

$handleC = odbc_connect('IBM-COMERVET-P',$loginBO,$passBO);
$result = odbc_exec($handleC, "select 'AG- AGROCAMPO' AS EMPRESA from SRBUSP where UPUSER = '$loginBO'");
	while($row = odbc_fetch_array($result)){
		$_SESSION['empresA'][] ='ZZ- COMERVET'; $emP = "DeNtR"; 
		}
*/
        $Acc = "0";
        if (($uStatus == "true" || $uStatus == "1") && $uId != '' && $rfId != '') {
            $_SESSION['usuARio'] = trim($loginU);
            $_SESSION['partner'] = $uId;
            $_SESSION['nomu'] = $unom;
            $usuB = trim($loginU);
            //$_SESSION['emp'] = $_SESSION['empresA'][0];
            if (
                $_SESSION["usuARio"] == 'CARDOZOJ'
                or $_SESSION["usuARio"] == 'TORRESC'
                or $_SESSION["usuARio"] == 'GOMEZD'
                or $_SESSION["usuARio"] == 'LOPEZJ'
                or $_SESSION["usuARio"] == 'MORANTESN'
                or $_SESSION["usuARio"] == 'TORREZC'
                or $_SESSION["usuARio"] == 'SIERRAJ'
                or $_SESSION["usuARio"] == 'JIMENEZR'
                or $_SESSION["usuARio"] == 'DIAZD'
                or $_SESSION["usuARio"] == 'ALVAREZR'
                or $_SESSION["usuARio"] == 'RODRIGUEZC'
                or $_SESSION["usuARio"] == 'MONTILLAJ'
                or $_SESSION["usuARio"] == 'DRAMIREZ'
                or $_SESSION["usuARio"] == 'BARONF'
                or $_SESSION["usuARio"] == 'SILVAJ'
                or $_SESSION["usuARio"] == 'DIAZD'
                or $_SESSION["usuARio"] == 'VILLALOBOSC'
                or $_SESSION["usuARio"] == 'CIFUENTES"'
            ) {
                $_SESSION["dIr"] = 'SI';
                $Acc = "1";
            } else {
                $_SESSION["dIr"] = 'NO';
                $Acc = "0";
            }


            /*if($_POST['claves'] < 750){
    	$_SESSION['ancho'] = 'cel' ;
   	 	}else{
    	$_SESSION['ancho'] = 'pc' ;
    	}
        */
            //echo "Aqui2";	
            // echo $_SESSION['usuARio'];
            if ($Acc == "1") {
                //echo "kgldgkldsfkglfdkglkdflgklfdgkldfkgld";
                //header("location:index.php");

                echo "<script>";
                echo "cambiarRuta('index.php');";
                echo "</script>";
            }
            //header("location: index.php");
            //header( "refresh:1; url=index.php" );
        } else {
            if ($Acc == "0") {
                header("location:user_conect_odoo.php");
                $_SESSION['acc'] = '1';
                $_SESSION['usuARio'] = "";
            }
            /*if(session_start()===TRUE){
            session_destroy();
        }*/
        }
        Conexion::cerrarConexion();
        //usuarios para botones
        require_once('conectarbasepruebas.php');
        $primarios = "";
        $secundarios = "";
        $resultSqlP = mssql_query("SELECT * FROM [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE Usuario='$usuB'");
        $numero2 = mssql_num_rows($resultSqlP);
        if ($numero2 == 0) {
            echo "El usuario no tiene acceso a ningun boton principal!, favor verificar..";
        } else {
            while ($fila = mssql_fetch_array($resultSqlP)) {
                $datoP = $fila['MenuPri'];
                $datoS = $fila['MenuSec'];
                if ($datoP != '') {
                    $primarios .= $datoP . "^";
                }
                if ($datoS != '') {
                    $secundarios .= $datoS . "^";
                }
            }
            $_SESSION['verbtnP'] = $primarios;
            $_SESSION['verbtnS'] = $secundarios;
        }
        mssql_close();
    }
    //echo "d1".$d1;
    ?>
</body>

</html>