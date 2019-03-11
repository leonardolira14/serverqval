<?

/**
 * 
 */
class Model_Pregunta extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//funcion para obtener los datos de una pregunta por su nomenclatura
	public function nomeclatura($_Empresa,$_nomenclatura){
		if($_Empresa!=""){
			$resp=$this->db->select("*")->where("Nomenclatura='$_nomenclatura' and IDEmpresa='$_Empresa'")->get("preguntas");
		}else{
			$resp=$this->db->select("*")->where("Nomenclatura='$_nomenclatura'")->get("preguntas");
		}
		
		return $resp->row_array();
	}
	//funcion para obtenr el numeor de pregunta
	public function numpregunta($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as numpregunta")->where("IDEmpresa='$_ID_Empresa'")->get("preguntas");
		return $respuesta->row();
	}
	//funccion para obtener toodas las preguntas de una emrpesa
	public function getall($_ID_Empresa){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_ID_Empresa'")->get("preguntas");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result_array();
		}
	}
	//funcion para obteener las preguntas
	public function getPreguntas($_ID_Empresa,$_Status){
		$respuesta=$this->db->select("Pregunta,IDPregunta,Nomenclatura")->where("IDEmpresa='$_ID_Empresa' and Estado='$_Status'")->get("preguntas");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			$preguntas=[];
			foreach ($respuesta->result_array() as $preg) {
				array_push($preguntas,array("Pregunta"=>$preg["Pregunta"],"IDPregunta"=>$preg["IDPregunta"],"Nomenclatura"=>$preg["Nomenclatura"],"checado"=>false));
			}
			
			return $preguntas;
		}
	}
	//funcion para save una pregunta
	public function save($_IDEmpresa,$_Pregunta,$_EStado,$_Forma,$_Frecuencia,$_Peso,$_Respuesta){
		$array=array("IDEmpresa"=>$_IDEmpresa,"Pregunta"=>$_Pregunta,"Estado"=>$_EStado,"Forma"=>$_Forma,"Frecuencia"=>$_Frecuencia,"Peso"=>$_Peso,"Respuesta"=>$_Respuesta);
		 $this->db->insert("preguntas",$array);
		 $ultimo=$this->db->insert_id();
		 return $this->db->where("IDPregunta='$ultimo'")->update("preguntas",array("Nomenclatura"=>$ultimo));

	}
	//funcion para actualizar una pregunta
	public function update($_IDPregunta,$_Pregunta,$_EStado,$_Forma,$_Frecuencia,$_Peso,$_Respuesta){
		$array=array("Pregunta"=>$_Pregunta,"Estado"=>$_EStado,"Forma"=>$_Forma,"Frecuencia"=>$_Frecuencia,"Peso"=>$_Peso,"Respuesta"=>$_Respuesta);
		return $this->db->where("IDPregunta='$_IDPregunta'")->update("preguntas",$array);
	}
	public function delete($_ID_Pregunta,$_Status){
		return $this->db->where("IDPregunta='$_ID_Pregunta'")->update("preguntas",array("Estado"=>$_Status));
	}
}