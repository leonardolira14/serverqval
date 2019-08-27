<?
/**
 * 
 */
class Model_Notificacion extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para obtener las notificaciones de una empresa
	public function getAll($_IDEmpresa){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_IDEmpresa' and Status='1'")->get("notificaciones");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result();
		}
		
	}
	//funcion para obtener las notificaciones de preguntas
	public function getAllPregunta($_Usuario,$_status)
	{
		$respuesta=$this->db->select('*')->where("IDUsuarioNotificacion='$_Usuario' and Status='$_status'")->get("tbnotificacionpreg");
		return $respuesta->result_array();
	}
	//funcion para eliminar una notificacion
	public function not_pregunta($IDNotificacion){
		$this->db->where("IDNotificacion='$IDNotificacion'")->delete('tbnotificacionpreg');
	}
}