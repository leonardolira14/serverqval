<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Resumen extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
    	parent::__construct();
    	$this->load->model("Model_Cliente");
    	$this->load->model("Model_Grupo");
    	$this->load->model("Model_General");
    	$this->load->model("Model_Pregunta");
    	$this->load->model("Model_Cuestionario");
    	$this->load->model("Model_Calificacion");
	}
	public function getresumen_post(){
		$datos=$this->post();

		$fechas=explode('-',$datos["fecha"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];
		$_ID_cuestionario=$datos["id"];
		//obtengo los datos del cuestionario;
		$datoscuestionario=$this->Model_Cuestionario->getdata($_ID_cuestionario);
		$detallesduestionario=$this->Model_Cuestionario->getdetalles($_ID_cuestionario);
		$detallesemisor=$this->Model_Grupo->getgruposIDTipo($detallesduestionario["PerfilCalifica"],$detallesduestionario["TPEmisor"]);
		$detallesreceptor=$this->Model_Grupo->getgruposIDTipo($detallesduestionario["PerfilCalificado"],$detallesduestionario["TPReceptor"]);
		//ahora necesito obtener las veces que fue realizado ese cuestionario en esas fechas
		$veces=$this->Model_Calificacion->numquestionary($_ID_cuestionario,$fecha_Inicio,$fecha_Fin);
		$_data["detalles"]=array("Nombre"=>$datoscuestionario["Nombre"],"Status"=>($datoscuestionario["Status"]==="1")?"Activo":"Desactivado","Emisor"=>$detallesemisor["Nombre"],"Receptor"=>$detallesreceptor["Nombre"],"dialogo"=>comentario($fecha_Inicio,$fecha_Fin,$veces));
		//DATOS PARA LLENAR LA TABLA
		//obtengo la lista de preguntas
		$litsa_preguntas=explode(",",$detallesduestionario["Cuestionario"]);
		$tabla=[];
		//ahora obtengo los detalles de cada pregunta y voy obtennieno las veces que han contestado esa pregunta
		foreach ($litsa_preguntas as $nomenclatura) {
			$detall=$this->Model_Pregunta->nomeclatura($nomenclatura);
			$num_veces_contestadas=$this->Model_Calificacion->numcontestadas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin);
			if($detall["Forma"]!="AB" || $detall!="ML"){
			$num_de_respuestas_correctas=$this->Model_Calificacion->numcontestadascorrectas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin,$detall["Respuesta"]);
			}else{
				$num_de_respuestas_correctas="NA";
			}

			array_push($tabla,array("pregunta"=>$detall["Pregunta"],"respuesta"=>$detall["Respuesta"],"vecescontestada"=>$num_veces_contestadas,"numrespuestascorrectas"=>$num_de_respuestas_correctas));
			
		}
		$_data["table"]=$tabla;
		//ahora obtengo los datos apra la grafica que es por dia las veces que se conesto ese cuestionario
		$grafica=[];
		$fechas=[];
		$fecha_Inicio=strtotime($fecha_Inicio);
		$fecha_Fin=strtotime($fecha_Fin);
		for($i=date("Y/m/d",$fecha_Inicio);$i<=date("Y/m/d",$fecha_Fin);$i=date("Y/m/d", strtotime($i ."+ 1 days"))){
			
				$cadena=$this->Model_Calificacion->numquestionary($_ID_cuestionario,$i,$i);
				array_push($fechas,$i);
				array_push($grafica,$cadena);
				
				
		}
		$_data["grafica"]=array("labels"=>$fechas,"datos"=>array("data"=>$grafica,"label"=>'# de veces realizado el cuestioario'));

		$this->response($_data);
		
	}
	//funcion para obter los detalles de la tabla
	public function getdetailstable_post(){
		$datos=$this->post();
		$fechas=explode('-',$datos["fecha"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];
		$_ID_Cuestionario=$datos["id"];
		$_data["tabledetaills"]=$this->Model_Calificacion->getdatacalificacion($_ID_Cuestionario,$fecha_Inicio,$fecha_Fin);
		$this->response($_data);
		
	}
}