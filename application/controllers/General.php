<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;
/**
 * 
 */
class General extends REST_Controller
{
	
	function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->model("Model_Empresa");
		$this->load->model("Model_Usuarios");
		$this->load->model("Model_Cliente");
		$this->load->model("Model_Grupo");
		$this->load->model("Model_Cuestionario");
		$this->load->model("Model_Pregunta");
		$this->load->model("Model_General");
		
	}
	public function index_post(){
		
	}

	//function para el panel
	public function panel_post(){
		$datos= $this->post();
		$_data["NoUsuarios"]=$this->Model_Usuarios->numus($datos["datos"]);
		$_data["NoCliente"]=$this->Model_Cliente->numclientes($datos["datos"]);
		$_data["NoGrupo"]=$this->Model_Grupo->numgrupo($datos["datos"]);
		$_data["NoPregunta"]=$this->Model_Pregunta->numpregunta($datos["datos"]);
		$_data["NoCuestionario"]=$this->Model_Cuestionario->numcuestionarios($datos["datos"]);
		$_data["tipos_empresa"]=$this->Model_General->getTipEmpresa();
		$_data["estados"]=$this->Model_General->getEstados();
		$_data["NoEmpleados"]=$this->Model_General->getNomEmpleados();
		$_data["Facturacion"]=$this->Model_General->getFacanual();
		$this->response($_data);
	}
	//funcio para modificar los datos de usaurio
	public function updatedateus_post(){
		//vdebug($_SERVER['DOCUMENT_ROOT']);
		$datos=$this->post();
		$publickey="";
		$this->Model_Usuarios->update_general($datos["nombreus"],$datos["correo"],$datos["puesto"],$datos["apellido"],$datos["num"]);
		
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="logo"){
					$ruta='./assets/img/logoempresa/';


				}
				if($key==="banner"){
					$ruta='./assets/img/bannerempresa/';
				}
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);
				//$this->create_thumbnail($nombreactual,$ruta,$key);
				$this->Model_Empresa->updateimg($datos["empresa"],$nombreactual,$key);
				
			}
			
		}

		$_data["ok"]=1;
		$this->response($_data);
		
	}
	//FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    public function create_thumbnail($filename,$ruta,$tipo){
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = $ruta.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image']=$ruta.'thumbs/'.$filename;
        if($tipo==="logo"){
        	$config['width'] = 150;
        	$config['height'] = 150;	
        }else{
        	$config['width'] = 1920;
        	$config['height'] = 200;
        }
        
        $this->load->library('image_lib', $config); 
        $this->image_lib->resize();
    }
}