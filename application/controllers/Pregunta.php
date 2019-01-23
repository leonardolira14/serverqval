<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Pregunta extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->model("Model_Pregunta");
	}
	public function getall_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Pregunta->getall($datos["empresa"]);
		$this->response($_data);
	}
	//funcion para agregar una pregunta
	public function save_post(){
		$error="";
		$bandera=false;
		$datos=$this->post();
		if($datos["Pregunta"]==""){
			$error.="El campo Pregunta no es valido;";
			$bandera=true;
		}
		if($datos["Forma"]==""){
			$error.="El campo Forma no es valido;";
			$bandera=true;
		}
		if($datos["Frecuencia"]==""){
			$error.="El campo Frecuencia no es valido;";
			$bandera=true;
		}
		if($datos["Respuesta"]=="" && $datos["Forma"]=="AB"){
			$error.="El campo Respuesta no es valido;";
			$bandera=true;	
		}
		if($bandera==true){
			$_data["ok"]=false;
			$_data["error"]=$error;
			
		}else{
            $this->Model_Pregunta->save($datos["IDEmpresa"],$datos["Pregunta"],$datos["Peso"],$datos["Forma"],$datos["Frecuencia"],$datos["Peso"],$datos["Respuesta"]);
			$_data["ok"]=true;
		}
		$this->response($_data);

		
	}
	public function update_post(){
		$datos=$this->post();
		$error="";
		$bandera=false;
		$datos=$this->post();
		if($datos["Pregunta"]==""){
			$error.="El campo Pregunta no es valido;";
			$bandera=true;
		}
		if($datos["Forma"]==""){
			$error.="El campo Forma no es valido;";
			$bandera=true;
		}
		if($datos["Frecuencia"]==""){
			$error.="El campo Frecuencia no es valido;";
			$bandera=true;
		}
		if($datos["Respuesta"]=="" && $datos["Forma"]=="AB"){
			$error.="El campo Respuesta no es valido;";
			$bandera=true;	
		}
		if($bandera==true){
			$_data["ok"]=false;
			$_data["error"]=$error;
			
		}else{
			$this->Model_Pregunta->update($datos["IDPregunta"],$datos["Pregunta"],$datos["Peso"],$datos["Forma"],$datos["Frecuencia"],$datos["Peso"],$datos["Respuesta"]);
			$_data["ok"]=true;
		}
		$this->response($_data);
	}
	public function delete_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Pregunta->delete($datos["id"],$datos["status"]);
		$this->response($_data);
	}
}