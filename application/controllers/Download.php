<?

/**
 * 
 */
class Download extends CI_Controller
{
	
	function __construct()
	{
		
    	parent::__construct();
    	$this->load->model("Model_Cliente");
    	$this->load->model("Model_Grupo");
    	$this->load->model("Model_General");
    	$this->load->model("Model_Pregunta");
    	$this->load->model("Model_Cuestionario");
    	$this->load->model("Model_Calificacion");
	}
	//funcion para descargar los resultados en svg
	public function detallessvg(){
		$datos=$this->get();
		vdebug($datos);
		  $this->response("my first api");
	}
	public function resumensvg(){
		$datos=$this->get();
		vdebug($datos);
		  $this->response("my first api");
	}
}