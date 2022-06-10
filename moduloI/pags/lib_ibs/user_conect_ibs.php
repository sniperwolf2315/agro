<? 
	session_start();
	include("../../user_con.php");
	global $user_ibs,$pass_ibs;
	function conectar_ibs_general(){
		$user_ibs  = $_SESSION['usuARio'];
		$pass_ibs  = $_SESSION['clAVe'];
		$lOGin     = sha1(date("Y-m-d:H"));  
		$pASs	   = sha1(date("H:Y-m-d"));
		$loginBO   = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
		$passBO    = trim(mb_strtoupper($_POST["$pASs"]));
		$val_rta   = 0;

		$Conn = odbc_connect('IBM-AGROCAMPO-P',$user_ibs ,$pass_ibs );
		$consulta_query = "select * from XXXXXX";
		$result_query   = odbc_exec($Conn, $consulta_query);

	}

	function conectar_ibs_consulta_vendedor($cod_vend) {
		$user_ibs  = $_SESSION['usuARio'];
		$pass_ibs  = $_SESSION['clAVe'];
		$lOGin     = sha1(date("Y-m-d:H"));  
		$pASs	   = sha1(date("H:Y-m-d"));
		$loginBO   = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
		$passBO    = trim(mb_strtoupper($_POST["$pASs"]));
		$val_rta   = 0;

		$Conn = odbc_connect('IBM-AGROCAMPO-P',$user_ibs ,$pass_ibs );
		$sql_result = odbc_exec($Conn, "
		select  
			SRBNAM.NAARHA AS VENDEDOR_IBS
			,COUNT(1) AS CLIENTES_ACTIVOS 
		from 
			AGR620CFAG.SRONAM SRBNAM 
		where 
			SRBNAM.NATYPP <> 2 
			AND SRBNAM.NASTAT <> 'D' 
			AND SRBNAM.NAARHA = '".$cod_vend."' 
			AND SRBNAM.NANCA4 IN ('CC03A','CC03','CC02A','CC02','CC04A','CC04','CC01') 
		group by SRBNAM.NAARHA ");
		
		while($row = odbc_fetch_array($sql_result)){
			$val_rta = $row['CLIENTES_ACTIVOS'];
		}
		return  $val_rta;
	};


	function tamanio_interface(){
		if($_POST['claves'] < 750){
			$_SESSION['ancho'] = 'cel' ;
			}else{
			$_SESSION['ancho'] = 'pc' ;
			}	
		header("location:index.php");
		// else{
		// echo "<BR>".odbc_errormsg()."<BR><BR><BR><BR><a href='user_conect.php' target='_self'><BR><BR> Click aca para Intentar loguearse de nuevo</a>";	
		// die;
		// }
	}
		

?>
