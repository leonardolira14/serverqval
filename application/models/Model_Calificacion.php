<?
/**
 * 
 */
class Model_Calificacion extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//fucnion para obtenr la cantidad de veces que fue contestatado esa pregunta
	public function numquestionary($_ID_Cuestionario,$Fecha1,$Fecha2){
		$resp=$this->db->select("count(*) as num")->where("date(Fecha) between '$Fecha1' and '$Fecha2' and IDCuestionario=$_ID_Cuestionario")->get("tbcalificaciones");
		return $resp->result()[0]->num;
	}
	//funcion para saber cuantas veces contestaron esa pregunta de una fecha a otra
	public function numcontestadas($_ID_Pregunta,$fecha1,$fecha2){
		$respuesta=$this->db->select("count(*) as num")->From("tbcalificaciones")->join("detallecalificacion","detallecalificacion.IDValora=tbcalificaciones.IDCalificacion")->where("date(Fecha) between  '$fecha1' and '$fecha2' and IDPregunta=$_ID_Pregunta")->get();
		return $respuesta->result()[0]->num;
	}
	//funcion para obtern el numero e respuestas correctas
	public function numcontestadascorrectas($_ID_Pregunta,$fecha1,$fecha2,$resuesta){
	$respuesta=$this->db->select("count(*) as num")->From("tbcalificaciones")->join("detallecalificacion","detallecalificacion.IDValora=tbcalificaciones.IDCalificacion")->where("date(Fecha) between '$fecha1' and '$fecha2' and IDPregunta='$_ID_Pregunta' and detallecalificacion.Respuesta='$resuesta'")->get();
	return $respuesta->result()[0]->num;
	}
	//funcion para obtener los datos de una cuestionario
	public function getdatacalificacion($numC,$_fechaInicio,$_fechaFin){
		$cuestionario=$this->ObtenerId($numC);
		$sql=$this->db->select("*")->where("date(Fecha) between '$_fechaInicio' and '$_fechaFin' and IDCuestionario='$numC'")->get("tbcalificaciones");

		if($sql->num_rows()===0){
			return false;
		}else{
			$veces=$sql->result();
			// si ya  hay calificaciones con ese cuestionario empieso a llenar el array
			
			$resumen=[];
		    foreach ($veces as $key) {
				foreach ($cuestionario as $pregunta) {
					$datospregunta=$this->dettalles_pregunta_cuestionario($key->IDCalificacion,$pregunta["ID"]);
					$emisor=$this->getname($key->IDEmisor,$key->TEmisor);
					$receptor=$this->getname($key->IDReceptor,$key->TReceptor);
					$fechas=explode(" ",$key->Fecha);
					array_push($resumen,array("IDCalificacion"=>$key->IDCalificacion,"Fecha"=>$fechas[0],"Emisor"=>$emisor,"Receptor"=>$receptor,"Pregunta"=>$pregunta["Pregunta"],"Respuesta"=>$datospregunta["Respuesta"],"Puntos"=>$datospregunta["Calificacion"])); 

					
				}
				
			}

			
			return $resumen;
		}
	}
	public function dettalles_pregunta_cuestionario($ID,$IDPregunta){
		$sql=$this->db->select("Respuesta,Calificacion")->where("IDValora='$ID' and IDPregunta='$IDPregunta'")->get("detallecalificacion");
		return $sql->result_array()[0];
	}
	public function getname($ID,$Tipo){
		if($Tipo==="E"){
			$respuesta=$this->db->select("Nombre")->where("IDCliente='$ID'")->get("clientes");
		}else{
			$respuesta=$this->db->select("Nombre")->where("IDUsuario='$ID'")->get("usuario");
		}
		return $respuesta->row()->Nombre;
	}
	//funcion para obtener un cuestionario y separarlo este me devuelve los datos de las preguntas en un array
	public function ObtenerId($numC){
		//primero obtengo el cuestionario
		$sql=$this->db->select("Cuestionario")->where("IDCuestionario='$numC'")->get("detallecuestionario");
		$cuestionario=explode(",",$sql->result()[0]->Cuestionario);
		$ncuest=[];
		foreach ($cuestionario as $pregunta) {
			$sql=$this->db->select('*')->where("Nomenclatura='$pregunta'")->get("preguntas");
			array_push($ncuest,array("ID"=>$sql->result()[0]->IDPregunta,"Pregunta"=>$sql->result()[0]->Pregunta,"Puntos"=>$sql->result()[0]->Peso,"RespuestaPos"=>$sql->result()[0]->Respuesta,"Forma"=>$sql->result()[0]->Forma));
		}
		return $ncuest;
	}
}