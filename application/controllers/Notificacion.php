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
	}
	//funcion para mandar las notificaciones
	public function notificaciones_post(){
		$datos= $this->post();
		$_data["notificaciones"]=$this->Model_Notificacion->getAll($datos["datos"]);
		$this->response($_data);
	}
}