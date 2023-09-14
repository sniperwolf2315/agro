<? 
session_start();
include("../../user_con.php");
global $user_ibs,$pass_ibs,$Conn;
	
class conectar_ibs{
	function __constructor(){}
	public function conectar(){
		session_start();
		$user_ibs  = $_SESSION['usuARio'];
		$pass_ibs  = $_SESSION['clAVe'];
		$Conn = odbc_connect('IBM-AGROCAMPO-P',$user_ibs ,$pass_ibs );
	return $Conn;
	}
	public function cerrar(){
		odbc_close( $Conn);
	}

	/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
}
	function conectar_ibs_general(){
		$user_ibs  = $_SESSION['usuARio'];
		$pass_ibs  = $_SESSION['clAVe'];
		$lOGin     = sha1(date("Y-m-d:H"));  
		$pASs	   = sha1(date("H:Y-m-d"));
		$loginBO   = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
		$passBO    = trim(mb_strtoupper($_POST["$pASs"]));
		$val_rta   = 0;
		// $Conn = odbc_connect('IBM-AGROCAMPO-P',$user_ibs ,$pass_ibs );
		$Conn = conectar_ibs::conectar();
		$consulta_query = "select * from XXXXXX";
		$result_query   = odbc_exec($Conn, $consulta_query);
		
	}
	/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
	function conectar_ibs_consulta_vendedor($cod_vend) {
		$user_ibs  = $_SESSION['usuARio'];
		$pass_ibs  = $_SESSION['clAVe'];
		$lOGin     = sha1(date("Y-m-d:H"));  
		$pASs	   = sha1(date("H:Y-m-d"));
		$loginBO   = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
		$passBO    = trim(mb_strtoupper($_POST["$pASs"]));
		$val_rta   = '';
		$Conn = odbc_connect('IBM-AGROCAMPO-P',$user_ibs ,$pass_ibs );
		$sql_result = odbc_exec($Conn, "
		select  
			distinct
			SRBNAM.NAARHA AS VENDEDOR_IBS
			,SRBNAM.nanum AS CLIENTES_ACTIVOS 
		from 
			AGR620CFAG.SRONAM SRBNAM 
			LEFT JOIN AGR620CFAG.Z3ONAM Z3BNAM ON SRBNAM.NANUM = Z3BNAM.Z3NANUM
			LEFT JOIN AGR620CFAG.Z3OCTLDN Z3BCTLDN ON Z3BCTLDN.Z3DNMCOD=Z3BNAM.Z3NAMCOD
			LEFT JOIN AGR620CFAG.SROCTLSD SRBCTLSD ON SRBNAM.NAARHA = SRBCTLSD.CTSIGN
			LEFT JOIN AGR620CFAG.SROCMA SRBCMA ON SRBNAM.NANUM = SRBCMA.CMCUNO
			LEFT JOIN AGR620CFAG.COOCTLDN COBCTLDN ON Z3BNAM.Z3NAMCOD = COBCTLDN.DNMCOD
			LEFT JOIN AGR620CFAG.SROCTLC4 SRBCTLC4 ON SRBNAM.NANCA4 = SRBCTLC4.CTNCA4 
		where 
			SRBNAM.NATYPP <> 2 
			AND SRBNAM.NASTAT <> 'D' 
			AND SRBNAM.NAARHA = '".$cod_vend."' 
			AND SRBNAM.NANCA4 IN ('CC03A','CC03','CC02A','CC02','CC04A','CC04','CC01') 
		");
		while($row = odbc_fetch_array($sql_result)){
			$val_rta .= trim($row['CLIENTES_ACTIVOS']).";";
		}
		$val_rta = substr($val_rta,0,-1);
		return  $val_rta;
	};
	// echo conectar_ibs_consulta_vendedor('VEND183');

	function conectar_ibs_consulta_vendedor_mdl($vendedor,$desde,$hasta,$ini_mdl,$fin_mdl){

		

	}



/* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */	
					/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
/* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */	

function tamanio_interface(){
	if($_POST['claves'] < 750){
		$_SESSION['ancho'] = 'cel' ;
	}else{
		$_SESSION['ancho'] = 'pc' ;
	}	
	header("location:index.php");
	
}
/* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */	
					/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
/* ████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████████ */	
/* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
	function conectar_ibs_general_query($consulta_query){
		$Conn= (conectar_ibs::conectar());
		$lOGin     = sha1(date("Y-m-d:H"));  
		$pASs	   = sha1(date("H:Y-m-d"));
		$loginBO   = htmlspecialchars(trim(strtoupper($_POST["$lOGin"])));
		$passBO    = trim(mb_strtoupper($_POST["$pASs"]));
		$val_rta   = 0;
		$result_query   = odbc_exec($Conn, $consulta_query);
		$result_query = ($result_query)? $result_query:'no';
		conectar_ibs::cerrar();
		return $result_query ;
	}

?>
