<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Cuestionario extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->model("Model_Cuestionario");
		$this->load->model("Model_Grupo");
		$this->load->model("Model_Pregunta");
		$this->load->model("Model_Calificacion");

	}
	public function borrar_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cuestionario->borrar($datos["IDCuestionario"]);
		$this->Model_Calificacion->delete_Calificacion_Custionario($datos["IDCuestionario"]);
		$this->response($_data);
	}
	public function numregistros_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cuestionario->getnumregistros($datos["IDCuestionario"]);
		$this->response($_data);
	}
	//funcion para obtener todos los cuestionarios de una empresa
	public function getall_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cuestionario->getallpanel($datos["empresa"]);
		$this->response($_data);
	}
	//funcion para obtener los datos de los cuestionarios
	public function getdatoscuest_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cuestionario->getallquestionary($datos["empresa"],$datos["status"]);
		$this->response($_data);
	}
	//funcion para obtener los datos de los cuestionarios
	public function getdatoscues_post(){
		$datos=$this->post();
		$_data["grupos"]=$this->Model_Grupo->getgruposID($datos["empresa"],"1");
		$_data["preguntas"]=$this->Model_Pregunta->getPreguntas($datos["empresa"],"1");
		$this->response($_data);
	}
	public function save_post(){
		$datos=$this->post();
		$IDCuestionario=$this->Model_Cuestionario->save($datos["Nombre"],$datos["Status"],$datos["IDEmpresa"],($datos["Email"]===false)?'0':'1',($datos["Wats"]===false)?'0':'1');
		//ahora inerto el detalle
		$emisor=$this->Model_Grupo->getID($datos["PerfilCalifica"][0]);
		$receptor=$this->Model_Grupo->getID($datos["PerfilCalificado"][0]);
		$lis=substr($datos["cuestionario"],0,strlen($datos["cuestionario"])-1);
		$_data["ok"]=$this->Model_Cuestionario->savedatelle($IDCuestionario,$lis,$datos["PerfilCalifica"][0],$datos["PerfilCalificado"][0],$emisor["Tipo"],$receptor["Tipo"]);
		$this->response($_data);
	}
	public function getdata_post(){
		$datos=$this->post();
	    $_data["cuestionario"]=$this->Model_Cuestionario->getdata($datos["cuestionario"]);
	    $_data["detalles"]=$this->Model_Cuestionario->getdetalles($datos["cuestionario"]);
	    $this->response($_data);
	}
	public function update_post(){
		$datos=$this->post();
		$this->Model_Cuestionario->update($datos["IDCuestionario"],$datos["Nombre"],$datos["Status"],$datos["IDEmpresa"],($datos["Email"]===false)?'0':'1',($datos["Wats"]===false)?'0':'1');
		//ahora inerto el detalle
		$emisor=$this->Model_Grupo->getID($datos["PerfilCalifica"][0]);
		$receptor=$this->Model_Grupo->getID($datos["PerfilCalificado"][0]);
		$lis=substr($datos["cuestionario"],0,strlen($datos["cuestionario"])-1);
		$_data["ok"]=$this->Model_Cuestionario->updatedatelle($datos["IDCuestionario"],$lis,$datos["PerfilCalifica"][0],$datos["PerfilCalificado"][0],$emisor["Tipo"],$receptor["Tipo"]);
		$this->response($_data);
	}
	

	//funcion para modificar el estatus de un cuestioonario
	public function delete_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cuestionario->delete($datos["IDCuestionario"],$datos["status"]);
		$this->response($_data);
	}
}