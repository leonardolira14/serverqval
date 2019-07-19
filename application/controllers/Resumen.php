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
	public function index_get(){
		$this->response("my first api");
	}
	public function getresumen_post(){
		$datos=$this->post();
		//vdebug($datos);
		$fechas=explode('-',$datos["fecha"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];

		$_ID_cuestionario=$datos["id"];
		$_Empresa=$datos["empresa"];
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
		$litsa_preguntas= json_decode($detallesduestionario["Cuestionario"]);
		
		$tabla=[];
		
		//ahora obtengo los detalles de cada pregunta y voy obtennieno las veces que han contestado esa pregunta
		foreach ($litsa_preguntas as $nomenclatura) {
			$detall=$this->Model_Pregunta->nomeclatura($nomenclatura);
			$num_veces_contestadas=$this->Model_Calificacion->numcontestadas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin);
			switch ($detall["Forma"]) {
				case "AB":
				case "MLC":
				case "NUMERO":
				case "F/H":
				case "FECHA":
				case "HORA":
				case "DESLIZA":
				case "CARGA":
				case "START":
					$num_de_respuestas_correctas="NA";
					break;
				
				case "ML":
				case "SI/NO":
				case "SI/NO/NA":
				case "SI/NO/NS":
					$num_de_respuestas_correctas=$this->Model_Calificacion->numcontestadascorrectas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin,$detall["Respuesta"]);
					break;

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

		$_data["grafica"]=array("labels"=>$fechas,"datos"=>array("data"=>$grafica,"label"=>'# de veces realizado el cuestionario'));
		//vdebug($_data);
		$this->response($_data);
		
	}
	//funcion para obter los detalles de la tabla
	public function getdetailstable_post(){
		$datos=$this->post();
		$fechas=explode('-',$datos["fecha"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];
		$_ID_Cuestionario=$datos["id"];
		$_ID_Empresa=$datos["empresa"];
		$_data["tabledetaills"]=$this->Model_Calificacion->getdatacalificacion($_ID_Empresa,$_ID_Cuestionario,$fecha_Inicio,$fecha_Fin);
		$this->response($_data);
		
	}
	//funcion para descargar los resultados en svg
	public function detallessvg_get(){
		$datos=$this->get();
		$fechas=explode('-',$datos["fech"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];
		$_ID_Cuestionario=$datos["num"];
		$datoscuestionario=$this->Model_Cuestionario->getdata($_ID_Cuestionario);
		$_ID_Empresa=$datoscuestionario["IDEmpresa"];
		$_data["tabledetaills"]=$this->Model_Calificacion->getdatacalificacion($_ID_Empresa,$_ID_Cuestionario,$fecha_Inicio,$fecha_Fin);
		$titulos=array("IDCalificación","Fecha","Emisor","Receptor","Pregunta","Respuesta","Puntos");
		// $this->response($titulos);
		converter_cvs($_data["tabledetaills"],"Detalles_Resumen_Qval_".$datos["fech"],$titulos);
		$this->response("");
	}
	public function resumensvg_get(){
		$datos=$this->get();
		$fechas=explode('-',$datos["fech"]);
		$fecha_Inicio=$fechas[0];
		$fecha_Fin=$fechas[1];
		$_ID_cuestionario=$datos["num"];
		//obtengo los datos del cuestionario;
		$datoscuestionario=$this->Model_Cuestionario->getdata($_ID_cuestionario);
		$detallesduestionario=$this->Model_Cuestionario->getdetalles($_ID_cuestionario);

		$_ID_Empresa=$datoscuestionario["IDEmpresa"];
		
		$detallesemisor=$this->Model_Grupo->getgruposIDTipo($detallesduestionario["PerfilCalifica"],$detallesduestionario["TPEmisor"]);
		$detallesreceptor=$this->Model_Grupo->getgruposIDTipo($detallesduestionario["PerfilCalificado"],$detallesduestionario["TPReceptor"]);
		//ahora necesito obtener las veces que fue realizado ese cuestionario en esas fechas
		$veces=$this->Model_Calificacion->numquestionary($_ID_cuestionario,$fecha_Inicio,$fecha_Fin);
		$_data["detalles"]=array("Nombre"=>$datoscuestionario["Nombre"],"Status"=>($datoscuestionario["Status"]==="1")?"Activo":"Desactivado","Emisor"=>$detallesemisor["Nombre"],"Receptor"=>$detallesreceptor["Nombre"],"dialogo"=>comentario($fecha_Inicio,$fecha_Fin,$veces));
		//DATOS PARA LLENAR LA TABLA
		//obtengo la lista de preguntas
		$litsa_preguntas=json_decode($detallesduestionario["Cuestionario"]);
		$tabla=[];
		//ahora obtengo los detalles de cada pregunta y voy obtennieno las veces que han contestado esa pregunta
		foreach ($litsa_preguntas as $nomenclatura) {
			$detall=$this->Model_Pregunta->nomeclatura($nomenclatura);
			$num_veces_contestadas=$this->Model_Calificacion->numcontestadas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin);
			switch ($detall["Forma"]) {
				case "AB":
				case "MLC":
				case "NUMERO":
				case "F/H":
				case "FECHA":
				case "HORA":
				case "DESLIZA":
				case "CARGA":
				case "START":
					$num_de_respuestas_correctas="NA";
					break;
				
				case "ML":
				case "SI/NO":
				case "SI/NO/NA":
				case "SI/NO/NS":
					$num_de_respuestas_correctas=$this->Model_Calificacion->numcontestadascorrectas($detall["IDPregunta"],$fecha_Inicio,$fecha_Fin,$detall["Respuesta"]);
					break;

			}
			array_push($tabla,array("pregunta"=>mb_convert_encoding($detall["Pregunta"],"UTF-8"),"respuesta"=>$detall["Respuesta"],"vecescontestada"=>$num_veces_contestadas,"numrespuestascorrectas"=>$num_de_respuestas_correctas));
			
		}
		$titulos=array("Pregunta","Respuesta","# de veces contestada","# de respuestas correctas");
		// $this->response($titulos);
		converter_cvs($tabla,"Resumen_Qval".$datos["fech"],$titulos);
		$this->response($_data["detalles"]["dialogo"]);
	}
}