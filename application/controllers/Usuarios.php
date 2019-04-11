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
    	$this->load->model("Model_Calificacion");
    	$this->load->model("Model_Email");

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
			$Clave=genereclabe();

			$this->Model_Usuarios->update_clave($respuesta["IDUsuario"],$Clave);
			$this->Model_Email->Recuperar_pass($respuesta["Correo"],$respuesta["Nombre"],$respuesta["Apellidos"],$respuesta["Usuario"],$Clave);
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
	public function numderegistristros_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Usuarios->getnumregistros($datos["IDUsuario"]);
		$this->response($_data);
	}
	//funcion para guardar 
	public function save_post(){
		$datos=$this->post();
		$datos=json_decode($datos["datos"]);
		$_data["ok"]=$this->Model_Usuarios->save($datos->Empresa,$datos->Nombre,$datos->Apellidos,$datos->Puesto,$datos->Correo,$datos->Configuracion,$datos->functions,$datos->Usuario,$datos->Imagen);
		
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/usuarios/avatar/';
				}
				
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				//$this->create_thumbnail($nombreactual,$ruta,$key);
				$this->Model_Empresa->updateimg($datos->Empresa,$nombreactual,$key);
				
			}
			
		} 
		$this->response($_data);
	}
	//funcion para dar de baja un usario
	public function deleteuser_delete(){
		$datos=$_GET["userdelete"];
		$estado=$_GET["userstate"];
		//$datos=$this->get();
		$_data["ok"]=$this->Model_Usuarios->update_status($datos,$estado);
		$this->response($_data);
	}
	//funcion para actualizar un usuario
	public function update_post(){
		$datos=$this->post();

		$datos=json_decode($datos["datos"]);
		$_respuesta=$this->Model_Usuarios->update($datos->Id,$datos->Nombre,$datos->Apellidos,$datos->Puesto,$datos->Correo,$datos->Configuracion,$datos->functions,$datos->Usuario,$datos->Imagen);
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/usuarios/avatar/';
				}
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				//$this->create_thumbnail($nombreactual,$ruta,$key);
				$this->Model_Empresa->updateimg($datos->Empresa,$nombreactual,$key);	
			}
		} 
		$_data["ok"]=$_respuesta;
		$this->response($_data);
	}
	//funcio  para actualizar las funciones de un usuarip
	public function updatefunction_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Usuarios->update_function($datos["id"],$datos["funciones"]);
		$this->response($_data);
	}
	public function borrar_post(){
		$datos=$this->post();
		
		//elimino los registros de usaurio
		$_data["ok"]=$this->Model_Usuarios->delete_user($datos["IDUsuario"]);
		//elimino las calificaciones que se hallan echo
		$this->Model_Calificacion->delete_Calificacion_usario($datos["IDUsuario"],"Emisor");
		$this->Model_Calificacion->delete_Calificacion_usario($datos["IDUsuario"],"Receptor");
		$this->response($_data);
	}
	public function transferircalificaciones_post(){
		$datos=$this->post();
		// primero cambio las calificaciones recibidas
		$this->Model_Calificacion->transferencia_de_calificaciones($datos["emisor"],$datos["receptor"],"Recibidas");
		$this->Model_Calificacion->transferencia_de_calificaciones($datos["emisor"],$datos["receptor"],"Realizadas");
		$_data["ok"]="ok";
		$this->response($_data);
	}	
}