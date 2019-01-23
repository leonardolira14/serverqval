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
}