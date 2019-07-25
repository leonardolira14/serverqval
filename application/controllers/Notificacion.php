<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Notificacion extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
    	parent::__construct();
		$this->load->model("Model_Notificacion");
		$this->load->model("Model_Usuarios");
		$this->load->model("Model_Pregunta");
		$this->load->model("Model_Cuestionario");
		$this->load->model("Model_Grupo");
	}
	//funcion para mandar las notificaciones
	public function notificaciones_post(){
		$datos= $this->post();
		$_data["notificaciones"]=$this->Model_Notificacion->getAll($datos["datos"]);
		
		$this->response($_data);
	}
	//funcion para obtener las notificaciones por usuario
	public function getNotificaciones_post(){
		$datos= $this->post();
		$datos_notificacion=$this->Model_Notificacion->getAllPregunta($datos["usuario"],'1');
		
		//ahora recorro cada uno de los items y tomo los datos necesarios
		foreach($datos_notificacion as $key=>$notificacion){
			//traigo los datos del que contesto
			
			$datos_receptor=$this->Model_Usuarios->getdata($notificacion["IDUsuarioReceptor"]);
			$datos_notificacion[$key]["NombreReceptor"]=$datos_receptor["Nombre"]." ".$datos_receptor["Apellidos"];
			// datos del cuestionario
			$_Datos_cuestionario=$this->Model_Cuestionario->getdata($notificacion["IDCuestionario"]);
			$_Detalle_Cuestionario=$this->Model_Cuestionario->getdetalles($notificacion["IDCuestionario"]);
			$datos_notificacion[$key]["NombreCuestionario"]=$_Datos_cuestionario["Nombre"];
			$datos_notificacion[$key]["PerfilCalifica"]=$_Detalle_Cuestionario["PerfilCalifica"];
			$datos_notificacion[$key]["PerfilCalificado"]=$_Detalle_Cuestionario["PerfilCalificado"];
			
			// datos pregunta
			$_Datos_Pregunta=$this->Model_Pregunta->get_detalle_pregunta($notificacion["IDPregunta"]);
			$datos_notificacion[$key]["Pregunta"]=$_Datos_Pregunta["Pregunta"];
						
		}
		$_data["cuestionardios"]=$this->Model_Cuestionario->getAllcuestionarios($datos["empresa"]);
		$_data["gruposexternos"]=$this->Model_Grupo->getGrupos($datos["empresa"],"E");
		$_data["gruposinternos"]=$this->Model_Grupo->getGrupos($datos["empresa"],"I");
		$_data["notificaciones"]=$datos_notificacion;
		$this->response($_data);
	}
	//funcion para eliminar una notificacion
	public function deletepreg_post(){
		$datos= $this->post();
		//elimino la notificacion
		$this->Model_Notificacion->not_pregunta($datos["notificacion"]);
		$datos_notificacion=$this->Model_Notificacion->getAllPregunta($datos["usuario"],'1');
		
		//ahora recorro cada uno de los items y tomo los datos necesarios
		foreach($datos_notificacion as $key=>$notificacion){
			//traigo los datos del que contesto
			
			$datos_receptor=$this->Model_Usuarios->getdata($notificacion["IDUsuarioReceptor"]);
			$datos_notificacion[$key]["NombreReceptor"]=$datos_receptor["Nombre"]." ".$datos_receptor["Apellidos"];
			// datos del cuestionario
			$_Datos_cuestionario=$this->Model_Cuestionario->getdata($notificacion["IDCuestionario"]);
			$_Detalle_Cuestionario=$this->Model_Cuestionario->getdetalles($notificacion["IDCuestionario"]);
			$datos_notificacion[$key]["NombreCuestionario"]=$_Datos_cuestionario["Nombre"];
			$datos_notificacion[$key]["PerfilCalifica"]=$_Detalle_Cuestionario["PerfilCalifica"];
			$datos_notificacion[$key]["PerfilCalificado"]=$_Detalle_Cuestionario["PerfilCalificado"];
			
			// datos pregunta
			$_Datos_Pregunta=$this->Model_Pregunta->get_detalle_pregunta($notificacion["IDPregunta"]);
			$datos_notificacion[$key]["Pregunta"]=$_Datos_Pregunta["Pregunta"];
						
		}
	}

}