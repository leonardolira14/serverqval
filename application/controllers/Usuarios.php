<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Usuarios extends REST_Controller
{
	
	function __construct()
	{
		
		header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
    	parent::__construct();
    	$this->load->model("Model_Usuarios");
    	$this->load->model("Model_Empresa");
    	$this->load->model("Model_General");
    	$this->load->model("Model_Grupo");

	}
	public function index_post(){
		
	}
	//funcion para le login de un usuario;
	public function loginn_post()
	{
		$datos= $this->post();
		$_Usuario=$datos["datos"]["user"];
		$_Clave=$datos["datos"]["pas"];
		$respuesta=$this->Model_Usuarios->login($_Usuario,$_Clave);
		if($respuesta===false){
			$_data["pass"]=0;
			$_data["mensaje"]="no";
		}else{
			$_data["pass"]=1;
			$_data["datos"]=$respuesta;
			$_data["empresa"]=$this->Model_Empresa->getEmpresa($respuesta->IDEmpresa);
			
		}
		$this->response($_data);

	}
	//funcion para recuperar contraseña de un usuario;
	public function forgetpass_post(){
		$datos= $this->post();
		$_Usuario=$datos["datos"];
		$respuesta=$this->Model_Usuarios->recuperar_clave($_Usuario);
		if($respuesta===false){
			$_data["pass"]=0;
			$_data["ok"]="La dirección de correo electrónico no existe";
		}else{
			//aqui envio el correo electronico que va a llevar las instrucciones 
			$_data["pass"]=1;
			$_data["ok"]="Datos enviados al correo que esta registrado";
		}
		$this->response($_data);
	}
	//funcion para obtener todos los usuarios
	public function getAll_post(){
		$datos=$this->post();
		$_data["usuarios"]=$this->Model_Usuarios->getAll($datos["0"]);
		$_data["grupos"]=$this->Model_Grupo->getGrupos($datos["0"],"I");;
		$this->response($_data);
	}
	//funcion para guardar 
	public function save_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Usuarios->save($datos["Empresa"],$datos["Nombre"],$datos["Apellidos"],$datos["Puesto"],$datos["Correo"],$datos["Configuracion"],$datos["functions"],$datos["Usuario"]);
	 	$this->response($_data);
	}
	//funcion para dar de baja un usario
	public function deleteuser_delete(){
		$datos=$_GET["userdelete"];
		$estado=$_GET["userstate"];
		//$datos=$this->get();
		$_data["ok"]=$this->Model_Usuarios->delete($datos,$estado);
		$this->response($_data);
	}
	//funcion para actualizar un usuario
	public function update_put(){
		$datos=$this->put();
		$_respuesta=$this->Model_Usuarios->update($datos["Id"],$datos["Nombre"],$datos["Apellidos"],$datos["Puesto"],$datos["Correo"],$datos["Configuracion"],$datos["functions"],$datos["Usuario"]);
		$_data["ok"]=$_respuesta;
		$this->response($_data);
	}
	//funcio  para actualizar las funciones de un usuarip
	public function updatefunction_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Usuarios->update_function($datos["id"],$datos["funciones"]);
		$this->response($_data);
	}
}