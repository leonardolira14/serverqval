<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Empresa extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->model("Model_Empresa");
		$this->load->model("Model_Usuarios");
	}
	public function index_post(){

	}
	//funcion para actualizar los datos de la empresa
	public function updateempresa_post(){
		$datos= $this->post();
		$respuesta=$this->Model_Empresa->udateinfo($datos["empresa"],$datos["razon_social"],$datos["nombre_comercial"],$datos["rfc"],$datos["tem"],$datos["nempleados"],$datos["facanual"],$datos["tel"],$datos["perfile"],$datos["calle"],$datos["municipio"],$datos["colonia"],$datos["estado"],$datos["cp"]);
		if($respuesta===null){
			$_data["ok"]=1;
		}else{
			$_data["ok"]=0;
			$_data["mensaje"]=$respuesta;
		}
		$this->response($_data);
	}

}