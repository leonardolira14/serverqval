<?
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class Cliente extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
    	parent::__construct();
    	$this->load->model("Model_Cliente");
    	$this->load->model("Model_Grupo");
    	$this->load->model("Model_General");
    	$this->load->model("Model_Calificacion");
	}
	public function borrar_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cliente->delete_clie($datos["IDCliente"]);
		//elimino las calificaciones que se hallan echo
		$this->Model_Calificacion->delete_Calificacion_usario($datos["IDCliente"],"Emisor");
		$this->Model_Calificacion->delete_Calificacion_usario($datos["IDCliente"],"Receptor");
		$this->response($_data);
	}
	public function numregistro_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cliente->getnumregistros($datos["IDCliente"]);
		$this->response($_data);
	}
	public function getdat_post(){
		$datos=$this->post();
		$_data["estados"]=$this->Model_General->getEstados();
		$_data["externos"]=$this->Model_Grupo->getGrupos($datos["empresa"],"E");
		$this->response($_data);
	}
	//funcion para obtener los datos de un cliente
	public function getuser_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cliente->getUser($datos["id"]);
		
		$this->response($_data);
	}
	//funcion para obtener los clientes de una empresa
	public function getAll_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cliente->getAll($datos["empresa"]);
		$_data["grupos"]=$this->Model_Grupo->getGrupos($datos["empresa"],"E");
		$this->response($_data);
	}
	public function save_post(){
		$datos=$this->post();
		$datos=json_decode($datos["datos"]);
		$_data["ok"]=$this->Model_Cliente->save($datos->IDEmpresa,$datos->Nombre,$datos->NombreComercial,$datos->RFC,$datos->Municipio,$datos->Direccion,$datos->Puesto,$datos->Tel,$datos->EEstado,$datos->Correo,$datos->IDConfig,$datos->Estado,$datos->TPersona,$datos->Apellidos,$datos->Actipass,$datos->Telcontact,$datos->Imagen);
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/clientes/avatar/';
				}
				
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				//$this->create_thumbnail($nombreactual,$ruta,$key);
				
			}
			
		} 
		$this->response($_data);
	}
	public function update_post(){
		$datos=$this->post();
		$datos=json_decode($datos["datos"]);
		$_data["ok"]=$this->Model_Cliente->update($datos->IDCliente,$datos->Nombre,$datos->NombreComercial,$datos->RFC,$datos->Municipio,$datos->Direccion,$datos->Puesto,$datos->Tel,$datos->EEstado,$datos->Correo,$datos->IDConfig,$datos->Estado,$datos->TPersona,$datos->Apellidos,$datos->Actipass,$datos->Telcontact,$datos->Imagen);
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="Imagen"){
					$ruta='./assets/img/clientes/avatar/';
				}
				
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				//$this->create_thumbnail($nombreactual,$ruta,$key);
				
			}
			
		} 
		$this->response($_data);

	}
	public function delete_post(){
		$datos=$this->post();
		$_data["ok"]=$this->Model_Cliente->updatestaus($datos["id"],$datos["status"]);
		$this->response($_data);
	}
	//funcion para obtener las empresas que pertenecen a un grupo
	public function numlistcliente_post(){
		$datos=$this->post();
		$data["response"]=$this->Model_Cliente->num_reg($datos["IDGrupo"],$datos["IDEmpresa"]);
		$this->response($data);
	}
}