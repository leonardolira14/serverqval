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
		$this->load->model("Model_Pregunta");
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
	public function getdatacalificacion($_empresa,$numC,$_fechaInicio,$_fechaFin){
		$cuestionario=$this->ObtenerId($_empresa,$numC);
		
		$sql=$this->db->select("*")->where("date(Fecha) between '$_fechaInicio' and '$_fechaFin' and IDCuestionario='$numC'")->get("tbcalificaciones");
		//vdebug(	$sql->result());
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
						array_push($resumen,array("IDCalificacion"=>$key->IDCalificacion,"Fecha"=>$fechas[0],"Emisor"=>$emisor,"Receptor"=>$receptor,"Pregunta"=>$pregunta["Pregunta"],"Forma"=>$pregunta["Forma"],"Respuesta"=>$datospregunta["Respuesta"],"Puntos"=>$datospregunta["Calificacion"])); 	
					}
				
			}
			return $resumen;
		}
	}
	public function dettalles_pregunta_cuestionario($ID,$IDPregunta){
		$sql=$this->db->select("Respuesta,Calificacion")->where("IDValora='$ID' and IDPregunta='$IDPregunta'")->get("detallecalificacion");
		return $sql->row_array();
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
	public function ObtenerId($_empresa,$numC){
		//primero obtengo el cuestionario
		
		$sql=$this->db->select("Cuestionario")->where("IDCuestionario='$numC'")->get("detallecuestionario");
		
		$cuestionario=json_decode($sql->result()[0]->Cuestionario);
		$ncuest=[];
		foreach ($cuestionario as $pregunta) {
			$sql=$this->db->select('*')->where("IDPregunta='$pregunta'")->get("tbpreguntas");
			array_push($ncuest,array("ID"=>$sql->result()[0]->IDPregunta,"Pregunta"=>$sql->result()[0]->Pregunta,"Puntos"=>$sql->result()[0]->Peso,"RespuestaPos"=>$sql->result()[0]->Respuesta,"Forma"=>$sql->result()[0]->Forma));
		}

		return $ncuest;
	}
	public function delete_Calificacion_usario($IDusuario,$tipo){

		if($tipo==="Emisor"){
			$datos=$this->db->select("IDCalificacion")->where("IDEmisor='$IDusuario'")->get("tbcalificaciones");
			foreach ($datos->result_array() as $IDValora) {
				$Idvalora=$IDValora["IDCalificacion"];
				$this->db->where("IDValora='$Idvalora'")->delete("detallecalificacion");
			}
			return $this->db->where("IDEmisor='$IDusuario'")->delete("tbcalificaciones");
		}else{
			$datos=$this->db->select("IDCalificacion")->where("IDReceptor='$IDusuario'")->get("tbcalificaciones");
			foreach ($datos->result_array() as $IDValora) {
				$Idvalora=$IDValora["IDCalificacion"];
				$this->db->where("IDValora='$Idvalora'")->delete("detallecalificacion");
			}
			return $this->db->where("IDReceptor='$IDusuario'")->delete("tbcalificaciones");
		}

	}
	public function delete_Calificacion_Custionario($IDCuestionario){

		
			$datos=$this->db->select("IDCalificacion")->where("IDCuestionario='$IDCuestionario'")->get("tbcalificaciones");
			foreach ($datos->result_array() as $IDValora) {
				$Idvalora=$IDValora["IDCalificacion"];
				$this->db->where("IDValora='$Idvalora'")->delete("detallecalificacion");
			}
			return $this->db->where("IDCuestionario='$IDCuestionario'")->delete("tbcalificaciones");
		

	}
	public function delete_Calificacion_pregunta($_ID_Pregunta){
		$this->db->where("IDPregunta='$_ID_Pregunta'")->delete("detallecalificacion");
	}
	//fucion para transferir las calificaciones de un usuario a otro
	public function transferencia_de_calificaciones($_Emisor,$_Receptor,$_Tipo){
		if($_Tipo==="Realizadas"){
			return $this->db->where("IDEmisor='$_Emisor' and TEmisor='I'")->update("tbcalificaciones",array("IDEmisor"=>$_Receptor));
		}
		if($_Tipo==="Recibidas"){
			return $this->db->where("IDReceptor='$_Emisor' and TReceptor='I'")->update("tbcalificaciones",array("IDReceptor"=>$_Receptor));
		}
	}
}