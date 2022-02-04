<?session_start();
//if($_SESSION['usuARio'] == '' OR $_SESSION['clAVe'] == '')
//    {
//    header("location:user_conect.php"); die;
//    }

//require('user_con.php'); 

//$fecha = date('l, F j, Y'); $hora = date('h:i A'); $ip=$_SERVER['REMOTE_ADDR'];
//echo "<font class='frxs'>".substr($_SESSION[NIVel],0,1)." ".substr($_SESSION[servidor],0,2)."</font>";
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Page-Enter" content="RevealTrans(duration=0.5,Transition=23)">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AGROCAMPO SIA</title>
<meta name="generator" content="Antenna 3.0">
<meta http-equiv="imagetoolbar" content="no">
<link rel="stylesheet" type="text/css" href="antenna.css" id="css">
<script type="text/javascript" src="antenna/auto.js"></script>
</head>
<body class="global" style="background-color:#E0E0E0;">
<? 
$ip = $_SERVER['REMOTE_ADDR']; 
$ip = explode('.', $ip);
$ip[3] = rand(1,100);
if (($ip[3]) % 2 ==0) 
  {
    $urlIbs ='http://181.57.147.206:8980/app';
  }else{
    $urlIbs ='http://181.57.147.206:8990/app';
  }
?>
<iframe
 name="i-frame1" class="aut abs" src="<?= $urlIbs?>" frameborder="0" style="height:100%; width:100%;">
 </iframe>
   
</body></html>
