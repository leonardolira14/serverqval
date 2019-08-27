<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Usuariosplus extends REST_Controller
{
	
	function __construct()
	{
        header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
        $this->load->model("Model_Usuariosplus");
        $this->load->model("Model_Email");
    }
    
    //funcion para obtener todos los usuarios de una empresa
    public function getall_post(){
        $datos=$this->post();
        $_data["usuarios"] = $this->Model_Usuariosplus->getAll_empresa($datos["IDEmpresa"]);
        $this->response(array("response"=>$_data));
    }
    //funcion para actulizar un usuario 
    public function update_post(){
        $datos=$this->post();
        $datos=json_decode(base64_decode($datos["datos"]));
        // primero subo la imagen si es que se cambio
        if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/usuarios/avatar/usuariosplus/';
				}
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				
			}
			
        } 
        //ahora realizo los cambios de datos
       $_data["response"]= $this->Model_Usuariosplus->update(
            $datos->Nombre,
            $datos->Apellidos,
            $datos->Correo,
            $datos->Celular,
            $datos->Status,
            $datos->Foto,
            $datos->IDUsuario
        );
        $_data["ok"]=true;
        $this->response($_data);
    }
    //funcion para agregar un usuario
    public function add_post(){
        $datos=$this->post();
        $_Empresa=$datos["empresa"];
        $datos=json_decode(base64_decode($datos["datos"]));
        $clave=genereclabe();
        $_data["token"]=$this->Model_Usuariosplus->add_user(
           
            $datos->Nombre,
            $datos->Apellidos,
            $datos->Correo,
            $datos->Celular,
            $datos->Status,
            $datos->Foto,
            $clave,
            $_Empresa
        );
        
        $_data["ok"]=true;
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/usuarios/avatar/usuariosplus/';
				}
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				
			}
			
		} 
		$this->Model_Email->Activar_Usuario($_data["token"],$datos->Correo,$datos->Nombre,$datos->Apellidos,$datos->Correo,$clave);
		$this->response($_data);
      
    }
    public function sendpass_post(){
        $datos=$this->post();
        $datos=json_decode(base64_decode($datos["datos"]));

        $_datos_usuario=$this->Model_Usuariosplus->getdata($datos->usuario);

        $clave=genereclabe();
        $_Clave=$this->Model_Usuariosplus->update_clave_tem($clave,$datos->usuario);

        $this->Model_Email->send_password_plus_user($_datos_usuario["Correo"],$_datos_usuario["Nombre"],$_datos_usuario["Apellidos"],$_Clave,$_datos_usuario["Correo"]);
        $_data["ok"]=true;
        $this->response($_data);
    }
    //funcion para cambiar el status de un usuario
    public function changestatus_post(){
        $datos=$this->post();
        $datos=json_decode(base64_decode($datos["datos"]));
        
        $this->Model_Usuariosplus->update_status($datos->usuario,$datos->status);
        
        $_data["ok"]=true;
        $this->response($_data);
    }

    // funcion para obtener el numero de registros de un usario para eliminarlo
    public function getreg_post(){
        $datos=$this->post();
        $datos=json_decode(base64_decode($datos["datos"]));
        $_data["response"]=$this->Model_Usuariosplus->get_num_reg($datos->usuario,$datos->empresa);
        $_data["ok"]=true;
        $this->response($_data);

    }
    public function delete_post(){
        $datos=$this->post();
        $datos=json_decode(base64_decode($datos["datos"]));
        $this->Model_Usuariosplus->delete($datos->usuario,$datos->empresa);
        $_data["ok"]=true;
        $this->response($_data);
    }

}