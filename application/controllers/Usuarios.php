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
		$this->load->library('form_validation');

	}
	public function valid_password($password = '')
	{
		$password = trim($password);
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
		if (empty($password))
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} es requerido.');
			return FALSE;
		}
		if (preg_match_all($regex_lowercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} debe contener al menos una letra minúscula.');
			return FALSE;
		}
		if (preg_match_all($regex_uppercase, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} debe contener al menos una letra mayúscula.');
			return FALSE;
		}
		if (preg_match_all($regex_number, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} debe contener al menos un número.');
			return FALSE;
		}
		if (preg_match_all($regex_special, $password) < 1)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} debe contener al menos un carácter especial.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
			return FALSE;
		}
		if (strlen($password) < 6)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} debe contener al menos 6 caracteres de longitud.');
			return FALSE;
		}
		if (strlen($password) > 32)
		{
			$this->form_validation->set_message('valid_password', 'El campo {field} no debe sobrepasar los 32 caracteres.');
			return FALSE;
		}
		return TRUE;
	}
	//funcion para el cambio de password
	public function cambiopas_post(){
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		$config=array( 
		array(
			'field'=>'anterior', 
			'label'=>'Anterior', 
			'rules'=>'trim|required|xss_clean'					
		),array(
			'field'=>'nueva', 
			'label'=>'Contraseña nueva', 
			'rules'=>'callback_valid_password'					
		),array(
			'field'=>'repetir', 
			'label'=>'Confirmar Contraseña', 
			'rules'=>'matches[nueva]'					
		));
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules($config);
		$array=array("required"=>'El campo %s es obligatorio',"valid_email"=>'El campo %s no es valido',"min_length[3]"=>'El campo %s debe ser mayor a 3 Digitos',"min_length[10]"=>'El campo %s debe ser mayor a 10 Digitos','alpha'=>'El campo %s debe estar compuesto solo por letras',"matches"=>"Las contraseñas no coinciden",'is_unique'=>'El contenido del campo %s ya esta registrado');
		$this->form_validation->set_message($array);
		if($this->form_validation->run() !=false){
			//ahora cambio los datos 
			$IDUsuario=$_POST["IDUsuario"];
			$IDEmpresa=$_POST["IDEmpresa"];
			$claveanterior=$_POST["anterior"];
			$claveNueva=$_POST["nueva"];
			//valido si la contraseña anterior es valida
			$respuesta=$this->Model_Usuarios->verificar_clave($IDUsuario,$claveanterior);
			if($respuesta==false){
				$_data["code"]=1990;
				$_data["ok"]="Error";
				$_data["result"]="Contraseña anterior no valida.";
			}else{
				$this->Model_Usuarios->update_clave($IDUsuario,$claveNueva);
			$_data["code"]=0;
			$_data["ok"]="SUCCESS";
			$_data["result"]="Access";
			}
			
		}else{
			$_data["code"]=1990;
			$_data["ok"]="Error";
			$_data["result"]=validation_errors();
		}
		$this->response(array("response"=>$_data));
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
			//genero token para la recuperacion  de contraseña
			$Token=genereclabe();
			//ahora guardo la esa secion para revisar de quien ese token
			$this->Model_General->save_token_recupera_clave($respuesta["IDUsuario"],$Token);
			$this->Model_Email->Recuperar_pass($respuesta["Correo"],$Token);

			$_data["pass"]=1;
			$_data["ok"]="Te enviaremos un email con instrucciones sobre cómo restablecer tu contraseña.";
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
		$clave=genereclabe();
		$_data["token"]=$this->Model_Usuarios->save(
			$datos->Empresa,
			$datos->Nombre,
			$datos->Apellidos,
			$datos->Puesto,
			$datos->Correo,
			$datos->IDConfig,
			$datos->functions,
			$datos->Usuario,
			$datos->Imagen,
			$datos->Celular,
			$clave
		);
		$_data["ok"]=true;
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/usuarios/avatar/';
				}
				
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				
				
			}
			
		} 
		$this->Model_Email->Activar_Usuario($_data["token"],$datos->Correo,$datos->Nombre,$datos->Apellidos,$datos->Usuario,$clave);
		$this->response($_data);
	}
	//funcion para dar de baja un usario
	public function deleteuser_delete(){
		$datos=$this->post();
		//$datos=$this->get();
		$datos_usuario= $this->Model_Usuarios->getdata($datos["id"]);
		$this->Model_Email->down_user($datos_usuario["Correo"]);
		$this->Model_Email->down_user_notification($datos["correo_baja"],$datos_usuario["Nombre"],$datos_usuario["Apellidos"]);
		$_data["ok"]=$this->Model_Usuarios->update_status($datos["id"],$datos["state"]);
		$this->response($_data);
	}
	//funcion para actualizar un usuario
	public function update_post(){
		$datos=$this->post();

		$datos=json_decode($datos["datos"]);
		$_respuesta=$this->Model_Usuarios->update($datos->Id,$datos->Nombre,$datos->Apellidos,$datos->Puesto,$datos->Correo,$datos->IDConfig,$datos->functions,$datos->Usuario,$datos->Imagen,$datos->Celular);
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
		
		$datos_usuario= $this->Model_Usuarios->getdata($datos["IDUsuario"]);
		$this->Model_Email->down_user($datos_usuario["Correo"]);
		
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
	public function changepassword_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$config=array( 
		array(
			'field'=>'clave', 
			'label'=>'Contraseña', 
			'rules'=>'callback_valid_password'					
		));
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		$this->form_validation->set_rules($config);
		$array=array("required"=>'El campo %s es obligatorio',"valid_email"=>'El campo %s no es valido',"min_length[3]"=>'El campo %s debe ser mayor a 3 Digitos',"min_length[10]"=>'El campo %s debe ser mayor a 10 Digitos','alpha'=>'El campo %s debe estar compuesto solo por letras',"matches"=>"Las contraseñas no coinciden",'is_unique'=>'El contenido del campo %s ya esta registrado');
		$this->form_validation->set_message($array);
		if($this->form_validation->run() !=false){
			// traigo lo datos del token 
			$claveNueva=$_POST["clave"];
			$Token=$_POST["token"];

			$datos_token=$this->Model_General->get_datos_token($Token);
		
			if(count($datos_token)===0){
				$_data["code"]=1990;
				$_data["ok"]="Error";
				$_data["result"]="El token de la sesion no existe.";
			}else{
				// ahora obtengo los datos del usuario que quiero cambiar la contraseña
				$datos_usuarios=$this->Model_Usuarios->getdata($datos_token["IDUsuario"]);
				$this->Model_Usuarios->update_clave($datos_token["IDUsuario"],$claveNueva);
				//elimino la sesion 
				$this->Model_General->delete_session_password($datos_token["IDSesion"]);
				$_data["code"]=0;
				$_data["ok"]="Success";
			}
			
		}else{
			$_data["code"]=1990;
			$_data["ok"]="Error";
			$_data["result"]=validation_errors();
		}
		$this->response(array("response"=>$_data));
	}
	public function activacuenta_post(){
		$datos=$this->post();
		$respuesta=$this->Model_Usuarios->activacuenta($datos["token"]);
		if($respuesta===false){
			$_data["ok"]="Error";
			$_data["mensaje"]="Token no valido";
		}else{
			$_data["ok"]="Success";
			$_data["mensaje"]="Cuenta Activada.";
		}
		$this->response(array("response"=>$_data));
	}
	public function reeenvioclave_post(){
			$datos=$this->post();
			$respuesta= $this->Model_Usuarios->getdata($datos["Usuario"]);
			$Token=genereclabe();
			//ahora guardo la esa secion para revisar de quien ese token
			$this->Model_General->save_token_recupera_clave($respuesta["IDUsuario"],$Token);
			$this->Model_Email->Recuperar_pass($respuesta["Correo"],$Token);

			$_data["pass"]=1;
			$_data["ok"]="Se envio un email con instrucciones sobre cómo restablecer la contraseña.";
			$this->response($_data);
	}
}