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
		$this->load->model("Model_Usuarios");

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
		$_data["grupos"]=$this->Model_Cuestionario->getAllgroup($datos["empresa"]);
		$_data["usuarios"]=$this->Model_Usuarios->getAll($datos["empresa"]);
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
	//nueva funcion para guardar un cuestionario
	public function addcuestionario_post(){
		$datos=$this->post();
		// veo si solo se actualiza 
		
		if(isset($datos['IDCuestionario'])){
			//quiere decir que estoy modificando un cuestionario
			//modifico los datos principales
			$this->Model_Cuestionario->update($datos["IDCuestionario"],$datos["Nombre"],$datos["IDEmpresa"]);
			//ahora modifico los detalles
			if($datos["PEmisor"]!=="0"){
				$datosemisor=explode("-",$datos["PEmisor"]);
				$_PerfilCalifica=$datosemisor[0];
				$_TPEmisor=$datosemisor[1];
			}else{
				$_PerfilCalifica=0;
				$_TPEmisor=0;
			}
			if($datos["PReceptor"]!=="0"){
				$datosreceptor=explode("-",$datos["PReceptor"]);
				$_PerfilCalificado=$datosreceptor[0];
				$_TPReceptor=$datosreceptor[1];
			}else{
				$_PerfilCalificado=0;
				$_TPReceptor=0;
			}
						
			$lista_cuestionario=[];
			foreach($datos["Cuestionario"] as $pregunta){
				if(isset($pregunta["Respuesta"])){
					$Respuesta=$pregunta["Respuesta"];
				}else{
					$Respuesta="";
				}
				if(isset($pregunta["Respuestas"])){
					$Respuestas=$pregunta["Respuestas"];
				}else{
					$Respuestas="";
				}
				if(isset($pregunta["IDPregunta"])){
					$IDPregunta=$this->Model_Pregunta->update($pregunta["IDPregunta"],$pregunta["Pregunta"],$pregunta["Forma"],$pregunta["Frecuencia"],$pregunta["Peso"],$Respuesta,$Respuestas,$pregunta["Obligatoria"]);
				}else{
					$IDPregunta=$this->Model_Pregunta->save($pregunta["Pregunta"],$pregunta["Forma"],$pregunta["Frecuencia"],$pregunta["Peso"],$Respuesta,$Respuestas,$pregunta["Obligatoria"]);
				}	
				array_push($lista_cuestionario,$IDPregunta);
				$_data["ok"]=$this->Model_Cuestionario->updatedatelle($datos["IDCuestionario"],json_encode($lista_cuestionario),$_PerfilCalifica,$_PerfilCalificado,$_TPEmisor,$_TPReceptor);
				$this->response($_data);
			}
		}else {
			if($datos["PEmisor"]!=="0"){
				$datosemisor=explode("-",$datos["PEmisor"]);
				$_PerfilCalifica=$datosemisor[0];
				$_TPEmisor=$datosemisor[1];
			}else{
				$_PerfilCalifica=0;
				$_TPEmisor=0;
			}
			if($datos["PReceptor"]!=="0"){
				$datosreceptor=explode("-",$datos["PReceptor"]);
				$_PerfilCalificado=$datosreceptor[0];
				$_TPReceptor=$datosreceptor[1];
			}else{
				$_PerfilCalificado=0;
				$_TPReceptor=0;
			}
			//guardo los datos del cuestionario
			$IDCuestionario=$this->Model_Cuestionario->save($datos["Nombre"],'1',$datos["IDEmpresa"],'0','0');
			//ahora agrego las preguntas a las tablas
			$lista_cuestionario=[];
			foreach($datos["Cuestionario"] as $pregunta){
				if(isset($pregunta["Respuesta"])){
					$Respuesta=$pregunta["Respuesta"];
				}else{
					$Respuesta="";
				}
				if(isset($pregunta["Respuestas"])){
					$Respuestas=$pregunta["Respuestas"];
				}else{
					$Respuestas="";
				}
				
				$IDPregunta=$this->Model_Pregunta->save($pregunta["Pregunta"],$pregunta["Forma"],$pregunta["Frecuencia"],$pregunta["Peso"],$Respuesta,$Respuestas,$pregunta["Obligatoria"]);
				array_push($lista_cuestionario,$IDPregunta);
			}
			//ahora guardo los datos de los detalles
			$_data["ok"]= $this->Model_Cuestionario->savedatelle($IDCuestionario,$lista_cuestionario,$_PerfilCalifica,$_PerfilCalificado,$_TPEmisor,$_TPReceptor);
			$this->response($_data);
		}
		
		
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

	//funcion para agregar un grupo de cuestionario
	public function addgroup_post(){
		$datos=$this->post();
		$this->Model_Cuestionario->add_group($datos["IDEmpresa"],$datos["Nombre"]);
		$data["ok"]=$this->Model_Cuestionario->getAllgroup($datos["IDEmpresa"]);
		$this->response($data);
	}
	public function updategroup_post(){
		$datos=$this->post();
		$this->Model_Cuestionario->update_gruop($datos["IDGrupo"],$datos["Nombre"]);
		$data["ok"]=$this->Model_Cuestionario->getAllgroup($datos["IDEmpresa"]);
		$this->response($data);
	}
	public function deletegroup_post(){
		$datos=$this->post();
		$this->Model_Cuestionario->delete_group($datos["IDGrupo"]);
		//al eliminar un grupo quito tas las relaciones que tengan este grupo
		$this->Model_Cuestionario->update_group_c($datos["IDEmpresa"],$datos["IDGrupo"]);
		$data["ok"]=$this->Model_Cuestionario->getAllgroup($datos["IDEmpresa"]);
		$this->response($data);
	}
	public function addcuesgrp_post(){
		$datos=$this->post();
		$this->Model_Cuestionario->update_group_cu($datos["IDEmpresa"],$datos["IDGrupo"],$datos["Cuestionario"]);
		$data["ok"]=$this->Model_Cuestionario->getallpanel($datos["IDEmpresa"]);
		$this->response($data);
	}
	public function updatenotificacion_post(){
		$datos=$this->post();
		$data["ok"]=$this->Model_Cuestionario->update_notificaciones($datos["IDCuestionario"],$datos["Notificacion"]);
		$this->response($data);
	}
	// funcion para cambiar el archivo de una encuesta
	public function upsategrupo_post(){
		$datos=$this->post();
		$data["ok"]= $this->Model_Cuestionario->add_gropu_encuesta($datos['IDCuestionario'],$datos['IDGrupo']);
		$this->response($data);
	}
	//funcion para eliminar las respuestas de una encuesta
	public function deleterespuestas_post(){
		$datos=$this->post();
		$data["ok"]= $this->Model_Cuestionario->deleterespuestas($datos['IDCuestionario']);
		$this->response($data);
	}
	//funcion para agregar iun cuestionario a un borrador
	public function addborradorencuesta_post(){
		$datos=$this->post();
		$data['ok']=$this->Model_Cuestionario->add_borrador($datos["IDEmpresa"],$datos['IDUsuario'],$datos["Datos"]);
		$this->response($data);
	}
	// funcion para obtener los datos de una encuesta
	public function getdatosencuesta_post(){
		$datos=$this->post();
		$_ID_Cuestionario=$datos["IDCuestionario"];
		//necito prmero los datos del cuestionario
		$datoscuestionario=$this->Model_Cuestionario->getdata($_ID_Cuestionario);
		$detalles_cuestionario=$this->Model_Cuestionario->getdetalles($_ID_Cuestionario);
		$_numero_de_preguntas=count(json_decode($detalles_cuestionario["Cuestionario"]));
		if($detalles_cuestionario['PerfilCalifica']==="0"){
			$datos_emisor=array("Nombre"=>"Encuesta  Abierta","IDGrupo"=>0);
		}else{
			$datos_emisor=$this->Model_Grupo->getID($detalles_cuestionario['PerfilCalifica']);;
		}
		if($detalles_cuestionario['PerfilCalificado']==="0"){
			$datos_receptor=array("Nombre"=>"Encuesta  Abierta","IDGrupo"=>0);
		}else{
			$datos_receptor=$this->Model_Grupo->getID($detalles_cuestionario['PerfilCalificado']);;
		}
		// ahora el numero de respuestas 
		$numero_respuestas=$this->Model_Cuestionario->getnumregistros($_ID_Cuestionario);
		//ahora necesito obtener las veces que fue realizado ese cuestionario en esas fechas
		$fechas=docemeces();
		$fecha_Inicio=$fechas[11]."-".date('d');
		$fecha_Fin=$fechas[12]."-".date('d');
		//ahora obtengo los datos apra la grafica que es por dia las veces que se conesto ese cuestionario
		$grafica=[];
		$fechas=[];
		$fecha_Inicio=strtotime($fecha_Inicio);
		$fecha_Fin=strtotime($fecha_Fin);
		for($i=date("Y/m/d",$fecha_Inicio);$i<=date("Y/m/d",$fecha_Fin);$i=date("Y/m/d", strtotime($i ."+ 1 days"))){

				$cadena=$this->Model_Calificacion->numquestionary($_ID_Cuestionario,$i,$i);
				array_push($fechas,$i);
				array_push($grafica,$cadena);	
		}

		$_grafica=array("labels"=>$fechas,"datos"=>array("data"=>$grafica,"label"=>'# de veces realizado el cuestioario'));
		// ahora traigo las preguntas de ese cuestionario
		$Lista_cuestionario=[];
		$datosLista=json_decode($detalles_cuestionario['Cuestionario']);
		foreach($datosLista as $pregunta){
			array_push($Lista_cuestionario,$this->Model_Pregunta->get_detalle_pregunta($pregunta));
		}
		// hora mando los datos
		$_data_print=array(
			"datos_cuestionario"=>$datoscuestionario,
			"detalles_cuestionario"=>$detalles_cuestionario,
			"numero_preguntas"=>$_numero_de_preguntas,
			"datos_Emisor"=>$datos_emisor,
			"datos_Receptor"=>$datos_receptor,
			"numero_respuestas"=>$numero_respuestas,
			"grafica"=>$_grafica,
			"lista_preguntas"=>$Lista_cuestionario
			
		);
		$this->response($_data_print);
	}
}