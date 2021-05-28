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

	public function borrar($_IDPregunta){
		$this->db->where("IDPregunta='$_IDPregunta'")->delete("preguntas");
	}
	public function getnumregistros($IDPregunta){
		$realizado=$this->db->select("count(*) as numero")->where("IDPregunta='$IDPregunta'")->get("detallecalificacion");
		return (int)$realizado->row_array()["numero"];
	}
	//funcion para obtener los datos de una pregunta por su nomenclatura
	public function nomeclatura($_ID_Pregunta){
		$resp=$this->db->select("*")->where("IDPregunta='$_ID_Pregunta'")->get("tbpreguntas");
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
	public function save($_Pregunta,$_Forma,$_Frecuencia,$_Peso,$_Respuesta,$_Respuestas,$Obligatoria,$Indicador,$Detalleindicador,$Notificaciones){
		if($_Forma==="DESLIZA"|| $_Forma==="ML" || $_Forma==="MLC" || $_Forma==="SI/NO"||$_Forma==="SI/NO/NA" || $_Forma==="SI/NO/NS"){
			$Respuestas=json_encode($_Respuestas);
		}else{
			$Respuestas=$_Respuestas;
		}
		$array=array(
			"Pregunta"=>$_Pregunta,
			"Forma"=>$_Forma,
			"Frecuencia"=>$_Frecuencia,
			"Peso"=>$_Peso,
			"Respuesta"=>$_Respuesta,
			"Respuestas"=>$Respuestas,
			"Obligatoria"=>$Obligatoria,
			"Indicador"=>$Indicador,
			"Detalleindicador"=>json_encode($Detalleindicador),
			"listanotificaciones"=>json_encode($Notificaciones)
		);
		 $this->db->insert("tbpreguntas",$array);
		 $ultimo=$this->db->insert_id();
		 return $ultimo;

	}
	//funcion para actualizar una pregunta
	public function update($_IDPregunta,$_Pregunta,$_Forma,$_Frecuencia,$_Peso,$_Respuesta,$_Respuestas,$_Obligatoria,$Indicador,$detalle_indicador,$_Notificaciones){
		if($_Forma==="DESLIZA"|| $_Forma==="ML" || $_Forma==="MLC" || $_Forma==="SI/NO"||$_Forma==="SI/NO/NA" || $_Forma==="SI/NO/NS"){
			$Respuestas=json_encode($_Respuestas);
		}else{
			$Respuestas=$_Respuestas;
		}
		$array=array(
			"Pregunta"=>$_Pregunta,
			"Forma"=>$_Forma,
			"Frecuencia"=>$_Frecuencia,
			"Peso"=>$_Peso,
			"Respuesta"=>$_Respuesta,
			"Respuestas"=>$Respuestas,
			"Obligatoria"=>$_Obligatoria,
			"Indicador"=>$Indicador,
			"Detalleindicador"=>$detalle_indicador,
			"listanotificaciones"=>json_encode($_Notificaciones)
		);
		$this->db->where("IDPregunta='$_IDPregunta'")->update("tbpreguntas",$array);
		return $_IDPregunta;
	}
	public function delete($_ID_Pregunta,$_Status){
		return $this->db->where("IDPregunta='$_ID_Pregunta'")->update("preguntas",array("Estado"=>$_Status));
	}
	///funcion detalles de una pregunta
	public function detalle_pregunta($IDPregunta){
		$respuesta=$this->db->select("*")->where("IDPregunta='$IDPregunta'")->get("preguntas");
		return $respuesta->row_array();
	}

	///funcion detalles de una pregunta nueva
	public function get_detalle_pregunta($IDPregunta){
	
		$respuesta=$this->db->select("*")->where("IDPregunta='$IDPregunta'")->get("tbpreguntas");
		$datos= $respuesta->row_array();
		if($datos["Forma"]=="ML" || $datos["Forma"]=="MLC" || $datos["Forma"]=="DESLIZA" || $datos["Forma"]=="SI/NO" || $datos["Forma"]=="SI/NO/NA" || $datos["Forma"]=="SI/NO/NS"){
			$respuestas_=json_decode($datos["Respuestas"]);
		}else{
			$respuestas_=$datos["Respuestas"];
		}
		$array=array(
			"IDPregunta"=>$datos["IDPregunta"],
			"Pregunta"=>$datos["Pregunta"],
			"Forma"=>$datos["Forma"],
			"Respuesta"=>$datos["Respuesta"],
			"Respuestas"=>$respuestas_,
			"Obligatoria"=>$datos["Obligatoria"],
			"Peso"=>$datos["Peso"],
			"Frecuencia"=>$datos["Frecuencia"],
			"listanotificaciones"=>$datos["listanotificaciones"]
		);
		return $array;
	}


	public function getcategias($_IDEmpresa){
		$respuesta=$this->db->query("(select * from tbcategoriaspreguntas where IDEmpresa='0') union  (select * from tbcategoriaspreguntas where IDEmpresa='$_IDEmpresa') order by Nombre asc");
		return $respuesta->result_array();
	}
	public function getpregunta_categoria($_IDCategoria){
		$respuesta=$this->db->select("*")->where("IDCategoria='$_IDCategoria'")->get("tbbancopreguntas");
		return $respuesta->result_array();
	}
	public function add_plantilla($IDEmpresa,$Nombre,$cuestionario){
		//inserto primero la categoria
		$array=array("IDEmpresa"=>$IDEmpresa,"Nombre"=>$Nombre);
		$this->db->insert("tbcategoriaspreguntas",$array);
		$IDCategoria = $this->db->insert_id();
		
		$cuestionario=json_decode($cuestionario);
		
		foreach($cuestionario as $preguntas){

			if(isset($preguntas->Respuesta)){
				
				$respuesta=$preguntas->Respuesta;
			}else{
				$respuesta="";
			}
			if(isset($preguntas->Respuestas)){
				if($preguntas->Forma === "START" || $preguntas->Forma === "CARGA" || $preguntas->Forma === "NUMERO" || $preguntas->Forma === "AB"){
					$respuestas=$preguntas->Respuestas;
				}else{
					$respuestas=json_encode($preguntas->Respuestas);
				}
				
				
			}else{
				$respuestas="";
			}
			(isset($pregunta->Obligatoria))?$Obligatoria=$pregunta->Obligatoria:$Obligatoria="SI";
			$array=array("Pregunta"=>$preguntas->Pregunta,"Forma"=>$preguntas->Forma,"Peso"=>$preguntas->Peso,"Respuestas"=>$respuestas,"Respuesta"=>$respuesta,"Obligatoria"=>$Obligatoria,"Frecuencia"=>$preguntas->Frecuencia,"Estado"=>1,"IDEmpresa"=>$IDEmpresa,"IDCategoria"=>$IDCategoria);
			$this->db->insert("tbbancopreguntas",$array);
		}
		return true;
	}	
		//funcion para obtener el nunumero de respuestas que ha obtenedo una pregunta en una fecha
		public function respuestas_fechas($IDPregunta,$IDCuestionario,$fecha,$respuesta,$tipo){
			//vdebug($tipo);
			if($tipo ==="SI/NO" || $tipo ==="SI/NO/NA" || $tipo === "SI/NO/NS" || $tipo === "ML" || $tipo === "MLC" ){
				$respuesta = $this->db->select('count(*) as num')->join('detallecalificacion','detallecalificacion.IDValora =tbcalificaciones.IDCalificacion')->where("Respuesta='$respuesta' and IDPregunta='$IDPregunta' and DATE(Fecha) BETWEEN '$fecha' AND '$fecha' and IDCuestionario='$IDCuestionario'")->get('tbcalificaciones');
				return $respuesta->result_array()[0]['num'];
			}

			if($tipo ==="NUMERO" || $tipo ==="START" || $tipo === "DESLIZA"){
				
				$respuesta = $this->db->select('AVG(Respuesta) as num')->join('detallecalificacion','detallecalificacion.IDValora =tbcalificaciones.IDCalificacion')->where("IDPregunta='$IDPregunta' and DATE(Fecha) BETWEEN '$fecha' AND '$fecha' and IDCuestionario='$IDCuestionario'")->get('tbcalificaciones');
				if($respuesta->result_array()[0]['num'] ==='' || $respuesta->result_array()[0]['num']===null){
					return 0;
				}else{
					return $respuesta->result_array()[0]['num'];
				}
				
			}
			
			
			
		}	
}