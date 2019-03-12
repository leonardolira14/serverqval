<?

/**
 * 
 */
class Model_Cuestionario extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para obteno los registro de un cuestionario
	public function getnumregistros($_ID_cuestionario){
		$realizado=$this->db->select("count(*) as numero")->where("IDCuestionario='$_ID_cuestionario'")->get("tbcalificaciones");
		return (int)$realizado->row_array()["numero"];
	}
	//funcion para obtenr los cuestionarios segun su estatus
	public function getallquestionary($_empresa,$_status){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_empresa' and Status='$_status'")->get("cuestionario");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result_array();
		}
	}
	//funcion para saber le numero de cuestionarios registrados de una empresa
	public function numcuestionarios($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as numcuestionarios")->where("IDEmpresa='$_ID_Empresa'")->get("cuestionario");
		return $respuesta->row();
	}
	//funcion para obtener todos los cuestionarios de una empresa
	public function getallpanel($_ID_Empresa){
		$respuesta=$this->db->select("cuestionario.status as estado,cuestionario.IDCuestionario as numero,cuestionario.Nombre as nombre,IDDetalle as numdetalle,PerfilCalifica,PerfilCalificado,TPEmisor,TPReceptor")->from("cuestionario")->join('detallecuestionario','detallecuestionario.IDCuestionario=cuestionario.IDCuestionario')->where("IDEmpresa='$_ID_Empresa'")->get();
		if($respuesta->num_rows()===0){
			return false;
		}else{
			$listcues=[];
			foreach ($respuesta->result_array() as $resp) {
				$Emisor=$this->getdatperfil($resp["PerfilCalifica"],$resp["TPEmisor"]);
				$Receptor=$this->getdatperfil($resp["PerfilCalificado"],$resp["TPReceptor"]);
			 		array_push($listcues,array("Nombre"=>$resp["nombre"],"IDCuestionario"=>$resp["numero"],"IDDetalles"=>$resp["numdetalle"],"Emisor"=>$Emisor["Nombre"],"Receptor"=>$Receptor["Nombre"],"Estado"=>$resp["estado"]));
			}
			return $listcues;
		}
	}
	//obtener datos del pefil
	function getdatperfil($_ID_Perfil,$_Tipo_Perfil){
		$respuesta=$this->db->select("*")->where("IDGrupo='$_ID_Perfil' and Tipo='$_Tipo_Perfil'")->get("grupos");
		return $respuesta->row_array();
	}
	//funcion para guardar un cuestionario
	public function save($_Nombre,$_status,$_ID_Empresa,$_Email,$_Wats){
		$array=array("Nombre"=>$_Nombre,"Status"=>$_status,"IDEmpresa"=>$_ID_Empresa,'Email'=>$_Email,"Wats"=>$_Wats);
		$this->db->insert("cuestionario",$array);
		return $this->db->insert_id();
	}
	//funcion para add detalles
	public function savedatelle($_ID_Cuestionario,$_Cuestionario,$_PerfilCalifica,$_PerfilCalificado,$_TPEmisor,$_TPReceptor){
		$array=array("IDCuestionario"=>$_ID_Cuestionario,"Cuestionario"=>$_Cuestionario,"PerfilCalifica"=>$_PerfilCalifica,"PerfilCalificado"=>$_PerfilCalificado,"TPEmisor"=>$_TPEmisor,"TPReceptor"=>$_TPReceptor);
		$this->db->insert("detallecuestionario",$array);
	}
	//funcion para obtener 
	public function getdata($_ID_Cuestionario){
		$respuesta=$this->db->select("*")->where("IDCuestionario='$_ID_Cuestionario'")->get("cuestionario");
		return $respuesta->row_array();
	}
	//funcion para solo actualizat la lista de preguntas de un curdstionario
	public function updatedatelle_listapreguntas($_ID_Cuestionario,$_Lista){
		$array=array("Cuestionario"=>$_Lista);
		$this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("detallecuestionario",$array);
	}
	//funcion para obtener los detalles
	public function getdetalles($_ID_Cuestionario){
		$resp=$this->db->select("*")->where("IDCuestionario='$_ID_Cuestionario'")->get("detallecuestionario");
		return $resp->row_array();
	}
	//funcion para modificar un cuestionario
	public function update($_ID_Cuestionario,$_Nombre,$_status,$_ID_Empresa,$_Email,$_Wats){
		$array=array("Nombre"=>$_Nombre,"Status"=>$_status,"IDEmpresa"=>$_ID_Empresa,'Email'=>$_Email,"Wats"=>$_Wats);
		$this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("cuestionario",$array);
	}
	//funcion para modifar detalles
	public function updatedatelle($_ID_Cuestionario,$_Cuestionario,$_PerfilCalifica,$_PerfilCalificado,$_TPEmisor,$_TPReceptor){
		$array=array("Cuestionario"=>$_Cuestionario,"PerfilCalifica"=>$_PerfilCalifica,"PerfilCalificado"=>$_PerfilCalificado,"TPEmisor"=>$_TPEmisor,"TPReceptor"=>$_TPReceptor);
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("detallecuestionario",$array);
	}
	public function  delete($_ID_Cuestionario,$_status){
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("cuestionario",array("Status"=>$_status));
	}
	public function borrar($_ID_Cuestionario){
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->delete("cuestionario");
	}

	
}