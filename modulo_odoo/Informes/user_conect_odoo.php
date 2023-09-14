<!-- FIXME: REPARAR EL REENVIO DEL FURMOLOARIO NO REDIRIJE
 -->
<?php

if (session_start() == FALSE) {
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
$inicio = "";


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
            border-radius: 5px;
            line-height: 1;
            padding: 20px 40px;
        }
    </style>
    <script type="text/javascript" src="/antenna/auto.js"></script>
    <script>
        function cambiarRuta(url) {
            // setTimeout("location.reload(true);", 500); /* NO HABILITAR OJO */
            location.href = url;
            return true;
        }
    </script>
</head>
<!--class="Aglobal"-->
<?php
function php_function_ruta()
{
    $v1 = $_POST['var'];
    $v2 = $_GET['var'];
    $ruta = '';

    if (empty($v1) || $v1 === '') {
        $ruta = $v2;
    } else {
        $ruta = $v1;
    }
    return $ruta;
};
$ruta_form = php_function_ruta();

?>

<body class="fimg">
    <center>
        <br><br>
        <table style="height:478; width:471;">
            <tr>

                <td align="center" valign="bottom" style="background-image: url('../../images/agroc_logoINI.png'); background-repeat:no-repeat; background-position:center; ">

                    <table width=300 height="262" border=0 cellpadding="2" cellspacing="1" style=" top:400; ">
                        <form name="<?= rand() ?>" id="<? rand() ?>" class="frxl" action="user_conect_odoo.php" method="post" autocomplete="off">
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
    //conexion odoo # ESTO SOLO VA A REALZIAR LA CONEXION CON PSSQL
    session_start();
    include_once 'usercon_odoo.php';

    if (isset($_POST['Enviar'])) {
        $loginU = $_POST['UsuOdo'];
        $refU   = $_POST['passU'];
        $loginU = strtoupper( $loginU); 
        $refU  = strtoupper( $refU ); 
         

        Conexion::abrirConexion();
        $Conn = Conexion::obtenerConexion();
        $query1 = "
            select 
                u.active,
                u.login,
                u.partner_id, 
                rp.ref as refid, 
                rp.name as nomb 
            from 
                res_users u 
                left join res_partner rp ON u.partner_id=rp.id 
            where 
                u.login='$loginU' 
                and u.active='true' 
                and rp.ref='$refU'";
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
            $roll =  $dato1['Userroll'];
        }
        $Acc = "0";
        if (($uStatus == "true" || $uStatus == "1") && $uId != '' && $rfId != '') {
            $usuB = trim($loginU);
            $_SESSION['usuARio'] = trim($loginU);
            $_SESSION['partner'] = $uId;
            $_SESSION['nomu'] = $unom;
            $_SESSION['emp'] = $_SESSION['empresA'][0];
            if (
                   $_SESSION["usuARio"] === 'CARDOZOJ'
                || $_SESSION["usuARio"] === 'TORRESC'
                || $_SESSION["usuARio"] === 'GOMEZD'
                || $_SESSION["usuARio"] === 'LOPEZJ'
                || $_SESSION["usuARio"] === 'MORANTESN'
                || $_SESSION["usuARio"] === 'TORREZC'
                || $_SESSION["usuARio"] === 'SIERRAJ'
                || $_SESSION["usuARio"] === 'JIMENEZR'
                || $_SESSION["usuARio"] === 'DIAZD'
                || $_SESSION["usuARio"] === 'ALVAREZR'
                || $_SESSION["usuARio"] === 'RODRIGUEZC'
                || $_SESSION["usuARio"] === 'MONTILLAJ'
                || $_SESSION["usuARio"] === 'DRAMIREZ'
                || $_SESSION["usuARio"] === 'BARONF'
                || $_SESSION["usuARio"] === 'SILVAJ'
                || $_SESSION["usuARio"] === 'DIAZD'
                || $_SESSION["usuARio"] === 'VILLALOBOSC'
                || $_SESSION["usuARio"] === 'CIFUENTESE'
            ) {
                $_SESSION["dIr"] = 'SI';
                $Acc = "1";
            } else {
                $_SESSION["dIr"] = 'NO';
                $Acc = "0";
            }

            if ($Acc == "1") {
                if($_SESSION["usuARio"] === 'CIFUENTESE'){
                    echo "<script> cambiarRuta('index_des_new.php');  </script> ";
                }else{
                    echo "<script> cambiarRuta('index.php');  </script> ";
                }
            }
        } else {
            if ($Acc == "0") {
                header("location:user_conect_odoo.php");
                $_SESSION['acc'] = '1';
                $_SESSION['usuARio'] = "";
            }
        }

        Conexion::cerrarConexion();
        
        //usuarios para botones
        require('conectarbasepruebas.php');
        $inicio = '';
        $primarios = "";
        $secundarios = "";
        $resultSqlP = mssql_query(" select * from [InformesCompVentas].[dbo].[usuariosReportodoo] WHERE Usuario='$usuB'");

        $numero2 = mssql_num_rows($resultSqlP);
        if ($numero2 == 0) {
            $inicio = "El usuario no tiene acceso a ningun boton principal!, favor verificar..";
            echo $inicio;
        } else {
            $inicio = "El usuario si tiene acceso ";
            while ($fila = mssql_fetch_array($resultSqlP)) {
                $datoP = $fila['MenuPri'];
                $datoS = $fila['MenuSec'];
                if ($datoP != '') {
                    $primarios .= $datoP . "^";
                }
                if ($datoS != '') {
                    $secundarios .= $datoS . "^";
                }
                $inicio = "";
            }
            $_SESSION['verbtnP'] = $primarios;
            $_SESSION['verbtnS'] = $secundarios;
        }
        mssql_close();
    }
    ?>
</body>

</html>