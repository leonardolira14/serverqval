<?

/**
 * 
 */
class Model_Grupo extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para obter los detalles de un grupo por el id
	public function getID($_ID_Grupo){
		$respuesta=$this->db->select("*")->where("IDGrupo='$_ID_Grupo'")->get("grupos");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->row_array();
		}
	}
	public function numgrupo($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as numgrupo")->where("IDEmpresa='$_ID_Empresa'")->get("grupos");
		return $respuesta->row();
	}
	public function getgruposID($_ID_Empresa,$_Status){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_ID_Empresa' and Status='$_Status'")->get("grupos");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result_array();
		}
	}
	public function getgruposIDTipo($_ID_Grupo,$_Tipo){
		$respuesta=$this->db->select("*")->where("IDGrupo='$_ID_Grupo' and Tipo='$_Tipo'")->get("grupos");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->row_array();
		}
	}
	//function para obtener el numero de miembros de un grupo
	public function getNumMiembros($_IDGrupo,$_Tipo_Grupo){
		if($_Tipo_Grupo==='I'){
			$respuesta=$this->db->select("count(*) as num")->where("IDConfig='$_IDGrupo'")->get("usuario");
		}
		if($_Tipo_Grupo==='E'){
			$respuesta=$this->db->select("count(*) as num")->where("IDConfig='$_IDGrupo'")->get("clientes");
		}
		return $respuesta->row_array();
	}	
	//funcion para obtener grupos
	public function getGrupos($_ID_Empresa,$_Tipo){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_ID_Empresa' and Tipo='$_Tipo'")->get("grupos");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			$resultados=$respuesta->result_array();
			foreach($resultados as $item  =>  $resultado){
				$numero=$this->getNumMiembros($resultado["IDGrupo"],$resultado["Tipo"]);
				$resultados[$item]["NoMiembros"]=$numero["num"];
			}
			return $resultados;
			
		}
	}
	public function updatestatus($_ID,$_staus){
		$array=array("Status"=>$_staus);
		$this->db->where("IDGrupo='$_ID'")->update("grupos",$array);
	}
	public function update($_ID,$_Nombre,$_Tipo){
		$array=array("Nombre"=>$_Nombre,"Tipo"=>$_Tipo);
		$this->db->where("IDGrupo='$_ID'")->update("grupos",$array);
	}
	public function addgrupo($_Empresa,$_Nombre,$_Tipo,$_Status){
		$array=array("Nombre"=>$_Nombre,"Tipo"=>$_Tipo,"Status"=>$_Status,"IDEmpresa"=>$_Empresa);
		$this->db->insert("grupos",$array);
	}
	public function delete($_ID_Grupo){
		$respuesta=$this->db->where("IDGrupo='$_ID_Grupo'")->delete("grupos");
		
	}
}