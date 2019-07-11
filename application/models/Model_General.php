<?

/**
 * 
 */
class Model_General extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para obter los estados 
	public function getEstados(){
		$respuesta=$this->db->select("estadonombre")->where("IDPais='42'")->get("estado");
		return $respuesta->result();
	}
	//funcion para obtener numeros de empleados
	public function getNomEmpleados(){
		$respuesta=$this->db->select("Empleados")->get("noempleados");
		return $respuesta->result();
	}
	//funcion para obtener la facturaicion anual
	public function getFacanual(){
		$respuesta=$this->db->select("Facturacion")->get("tipfacturacion");
		return $respuesta->result();
	}
	//funcion para abtener los tips de empresa
	public function getTipEmpresa(){
		$respuesta=$this->db->select("TipoEmpresa")->get("tiposempresa");
		return $respuesta->result();
	} 
	//funcion para guardar la sesion para la recuperacion de contraseña
	public function save_token_recupera_clave($_IDUsuario,$_Token){
		$array=array("IDUsuario"=>$_IDUsuario,"Token"=>$_Token);
		$this->db->insert("sessiones_password",$array);

	}
	public function get_datos_token($Token){
		$respuesta=$this->db->select('*')->where("Token='$Token'")->get("sessiones_password");
		return $respuesta->row_array();
	}
	public function delete_session_password($IDToken){
		$this->db->where("IDSesion='$IDToken'")->delete("sessiones_password");
	}
}