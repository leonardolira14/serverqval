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
		$this->load->model("Model_Conecta");
		$this->load->model("Model_Email");
		$this->load->model("Model_Admyo");
		
	}
	public function registro_post(){
		$datos=$this->post();
		//primero veo que tipo es el pago
		$respuesta=$this->Model_Conecta->Tarjeta($datos["pago"]["nombre"],$datos["pago"]["correo"],$datos["pago"]["token"],$datos["plan"],$datos["pago"]["total"],$datos["pago"]["tel"]);
		
		if($respuesta["status"]==="active"){
			$customer_id=$respuesta["customer_id"];
			$status_conecta=$respuesta["status"];
			$plan_id=$respuesta["plan_id"];
			
			//la agregoho a admyo
			$ID_Admyo=$this->Model_Admyo->add_empresa('PF',$datos["razonsocial"],$datos["nombrecomercial"],$datos["rfc"],$datos["TipoEmpresa"],$datos["noempleados"]);
			//ahora agrego el usuario
			$token=$this->Model_Admyo->add_Usuario($ID_Admyo,$datos["nombre"],$datos["apellidos"],$datos["correo"]);
			

			//ahora inscribo a la empresa
			$ID_Empresa=$this->Model_Empresa->add_empresa($datos["razonsocial"],$datos["nombrecomercial"],$datos["rfc"],$datos["TipoEmpresa"],$datos["noempleados"],$datos["telefono"],$customer_id,$status_conecta,$plan_id,$ID_Admyo);
			//ahora agrego el usario
			$this->Model_Usuarios->add_usuario($ID_Empresa,$datos["nombre"],$datos["apellidos"],$datos["correo"]);

			$data["ok"]="succes";
			
		}else{
			
			$data["ok"]="error";
			$data["error"]=$respuesta["error"];
		}
		$this->response($data);
		
			
		

	}
	public function getdatos_get(){
		$_data["tipos_empresa"]=$this->Model_General->getTipEmpresa();
		$_data["NoEmpleados"]=$this->Model_General->getNomEmpleados();
		$this->response($_data);
	}

	//function para el panel
	public function panel_post(){
		$datos= $this->post();
		$_data["NoUsuarios"]=$this->Model_Usuarios->numus($datos["datos"]);
		$_data["NoCliente"]=$this->Model_Cliente->numclientes($datos["datos"]);
		$_data["NoGrupo"]=$this->Model_Grupo->numgrupo($datos["datos"]);
		$_data["GruposInternos"]=$this->Model_Grupo->getGrupos($datos["datos"],'I');
		$_data["NoPregunta"]=$this->Model_Pregunta->numpregunta($datos["datos"]);
		$_data["NoCuestionario"]=$this->Model_Cuestionario->numcuestionarios($datos["datos"]);
		$_data["tipos_empresa"]=$this->Model_General->getTipEmpresa();
		$_data["estados"]=$this->Model_General->getEstados();
		$_data["NoEmpleados"]=$this->Model_General->getNomEmpleados();
		$_data["Facturacion"]=$this->Model_General->getFacanual();
		$_data["encuestas"]=$this->Model_Cuestionario->encuestas_panel($datos["datos"]);
		$this->response($_data);
	}
	//funcio para modificar los datos de usaurio
	public function updatedateus_post(){
		//vdebug($_SERVER['DOCUMENT_ROOT']);
		$datos=$this->post();
		
		$_data["ok"]=$this->Model_Usuarios->update_general($datos["nombreus"],$datos["correo"],$datos["puesto"],$datos["apellido"],$datos["num"],$datos["Imagen"],$datos["IDConfig"],$datos["celular"]);
		if(count($_FILES)!==0){
			foreach ($_FILES as $key=> $nombre) {
				if($key==="logo"){
					$ruta='./assets/img/usuarios/avatar/';
				}
				
				$rutatemporal=$nombre["tmp_name"];
				$nombreactual=$nombre["name"];
				
				move_uploaded_file($rutatemporal, $ruta.$nombreactual);		
			}
			
		} 
		$this->response($_data);
		
	}
	//funcio para modificar el avatar desde la app
	public function updatedaavatar_post(){
		
		$datos=$this->post();
		$IDUsuario=$datos["IDUsuario"];
		$avatar=$_FILES["logo"];
		$ruta='./assets/img/usuarios/avatar/';
		$rutatemporal=$avatar["tmp_name"];
		$nombreactual=$avatar["name"];
		try {
			if(! move_uploaded_file($rutatemporal, $ruta.$nombreactual)){
				$_data["code"]=1991;
				$_data["ok"]="ERROR";
				$_data["result"]="No se puede subir el archivo". $nombreactual;
				$this->response($_data,400);
			}
			// ahora actualizo los el nombre de la foto
			$_data["ok"]=$this->Model_Usuarios->update_avatar($IDUsuario,$nombreactual);
			$_data["code"]=0;
			$_data["ok"]="SUCCESS";
			$this->response($_data,200);
		} catch (Exception $e) {
					$_data["code"]=1991;
					$_data["ok"]="ERROR";
					$_data["result"]=$e->getMessage();
					$this->response($_data,400);
		}
		
		
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