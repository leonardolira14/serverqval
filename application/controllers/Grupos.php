<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Grupos extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->model("Model_Grupo");
	}
	//fucnion para obtener todos los grupos
	public function getall_post(){
		$datos= $this->post();
		
		$_data["internos"]=$this->Model_Grupo->getGrupos($datos[0],"I");
		$_data["externos"]=$this->Model_Grupo->getGrupos($datos[0],"E");
		$this->response($_data);
	}
	//funcion para elimar un grupo
	public function delete_post(){
		$datos= $this->post();
		$this->Model_Grupo->updatestatus($datos["grupo"],$datos["status"]);
		$_data["ok"]=1;
		$this->response($_data);
	}
	//funcion para updategrupo
	public function update_post(){
		$datos= $this->post();
		$this->Model_Grupo->update($datos["grupo"],$datos["nombregrupo"],$datos["tipog"]);
		$_data["ok"]=1;
		$this->response($_data);
	}
	//funcion para agregar un nuevo grupo
	public function add_post(){
		$datos= $this->post();
		$this->Model_Grupo->addgrupo($datos["grupo"],$datos["nombregrupo"],$datos["tipog"],"1");
		$_data["ok"]=1;
		$this->response($_data);
	}
}