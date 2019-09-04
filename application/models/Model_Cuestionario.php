<?

/**
 * 
 */
class Model_Cuestionario extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model("Model_Usuariosplus");
	}
	//funcion para obteno los registro de un cuestionario
	public function getnumregistros($_ID_cuestionario){
		$realizado=$this->db->select("count(*) as numero")->where("IDCuestionario='$_ID_cuestionario'")->get("tbcalificaciones");
		return (int)$realizado->row_array()["numero"];
	}
	//funcion para obtenr los cuestionarios segun su estatus
	public function getallquestionary($_empresa,$_status){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_empresa' and Status='$_status'")->get("cuestionario");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result_array();
		}
	}
	//funcion para saber le numero de cuestionarios registrados de una empresa
	public function numcuestionarios($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as numcuestionarios")->where("IDEmpresa='$_ID_Empresa'")->get("cuestionario");
		return $respuesta->row();
	}
	//funcion para obtener todos los grupos
	public function  getAllcuestionarios($_IDEmpresa){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_IDEmpresa'")->get("cuestionario");
		return $respuesta->result_array();
	}
	//funcion para obtener todos los cuestionarios de una empresa
	public function getallpanel($_ID_Empresa){
		$respuesta=$this->db->select("detallecuestionario.Notificaciones as Notificaciones,detallecuestionario.Grupo as Grupo,cuestionario.status as estado,cuestionario.IDCuestionario as numero,cuestionario.Nombre as nombre,IDDetalle as numdetalle,PerfilCalifica,PerfilCalificado,TPEmisor,TPReceptor")->from("cuestionario")->join('detallecuestionario','detallecuestionario.IDCuestionario=cuestionario.IDCuestionario')->where("IDEmpresa='$_ID_Empresa'")->get();
		
		if($respuesta->num_rows()===0){
			return $respuesta->result_array();
		}else{
			$listcues=[];
			foreach ($respuesta->result_array() as $resp) {
				if($resp["PerfilCalifica"]==="0"){
					$Emisor="Encuesta Abierta";	
				}else{
					$Emisor=$this->getdatperfil($resp["PerfilCalifica"],$resp["TPEmisor"]);
					$Emisor=$Emisor["Nombre"];
				}
				
				if($resp["PerfilCalificado"]==="0"){
					$Receptor="Encuesta Abierta";
				}else{
					$Receptor=$this->getdatperfil($resp["PerfilCalificado"],$resp["TPReceptor"]);
					$Receptor=$Receptor["Nombre"];
				}
			 		array_push($listcues,array("Notificaciones"=>$resp["Notificaciones"],"Grupo"=>$resp["Grupo"],"Nombre"=>$resp["nombre"],"IDCuestionario"=>$resp["numero"],"IDDetalles"=>$resp["numdetalle"],"Emisor"=>$Emisor,"Receptor"=>$Receptor,"Estado"=>$resp["estado"]));
			}
			return $listcues;
		}
	}
	//obtener datos del pefil
	function getdatperfil($_ID_Perfil,$_Tipo_Perfil){
		$respuesta=$this->db->select("*")->where("IDGrupo='$_ID_Perfil' and Tipo='$_Tipo_Perfil'")->get("grupos");
		return $respuesta->row_array();
	}
	//funcion para guardar un cuestionario
	public function save($_Nombre,$_status,$_ID_Empresa,$_Email,$_Wats){
		$array=array("Nombre"=>$_Nombre,"Status"=>$_status,"IDEmpresa"=>$_ID_Empresa,'Email'=>$_Email,"Wats"=>$_Wats);
		$this->db->insert("cuestionario",$array);
		return $this->db->insert_id();
	}
	//funcion para add detalles
	public function savedatelle(
		
		$_ID_Cuestionario,
		$_Cuestionario,
		$_PerfilCalifica,
		$_PerfilCalificado,
		$_TPEmisor,
		$_TPReceptor,
		$_Tipo_App,
		$_Lista_Empresas,
		$_IDEmpresa_emisora
		){
		if($_Tipo_App==="1"){
			foreach($_Lista_Empresas as $empresa){
				// obtengo los usuarios que pertenescan a esa empresa
				$_lista_usuarios=$this->Model_Usuariosplus->getAll_empresa($empresa["IDCliente"]);
				foreach($_Lista_Empresas as $usuario){
					$array=array(
						"IDEmpresa"=>$empresa["IDCliente"],
						"IDUsuario"=>$usuario["IDUsuario"],
						"IDCuestionario"=>$_ID_Cuestionario,
						"Status"=>0,
						"Fecha_Envio"=>date("Y-m-d"),
						"Hora_Envio"=>date("h:i:s"),
						"Fecha_Respuesta"=>'',
						"Hora_Respuesta"=>'',
						"IDEmpresa_Emisora"=>$_IDEmpresa_emisora
					);
					$this->db->insert("tb_cuestionarios_usuarios_plus",$array);
				}
			}
		}	
		$array=array(
			"IDCuestionario"=>$_ID_Cuestionario,
			"Cuestionario"=>json_encode($_Cuestionario),
			"PerfilCalifica"=>$_PerfilCalifica,
			"PerfilCalificado"=>$_PerfilCalificado,
			"TPEmisor"=>$_TPEmisor,
			"TPReceptor"=>$_TPReceptor,
			"Tipoapp"=>$_Tipo_App,
			"Lista_empresas"=> json_encode($_Lista_Empresas)
		);
		$this->db->insert("detallecuestionario",$array);
	}
	//funcion para obtener 
	public function getdata($_ID_Cuestionario){
		$respuesta=$this->db->select("*")->where("IDCuestionario='$_ID_Cuestionario'")->get("cuestionario");
		return $respuesta->row_array();
	}
	//funcion para solo actualizat la lista de preguntas de un curdstionario
	public function updatedatelle_listapreguntas($_ID_Cuestionario,$_Lista){
		$array=array("Cuestionario"=>$_Lista);
		$this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("detallecuestionario",$array);
	}
	//funcion para obtener los detalles
	public function getdetalles($_ID_Cuestionario){
		$resp=$this->db->select("*")->where("IDCuestionario='$_ID_Cuestionario'")->get("detallecuestionario");
		return $resp->row_array();
	}
	//funcion para modificar un cuestionario
	public function update($_ID_Cuestionario,$_Nombre,$_ID_Empresa){
		$array=array("Nombre"=>$_Nombre,"IDEmpresa"=>$_ID_Empresa);
		$this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("cuestionario",$array);
	}
	function unique_multidim_array($data) { 
		
		$final = array(); 
		foreach ($data as $array) 
		{ 
			if(!in_array($array, $final))
			{ 
				$final[] = $array; 
			} 
		} 
		return $final;
	} 
	//funcion para modifar detalles
	public function updatedatelle(
		$_ID_Cuestionario,
		$_Cuestionario,
		$_PerfilCalifica,
		$_PerfilCalificado,
		$_TPEmisor,
		$_TPReceptor,
		$_Tipo_App,
		$_Lista_Empresas,
		$_Empresa_emisora
		){
		$flag_disminuir=false;
		$flag_aumentar=false;
		// ahora obtengo la lista anterior y verifico si se elimino o se agrego 
		$respuesta=$this->db->select('Lista_empresas')->where("IDCuestionario='$_ID_Cuestionario'")->get("detallecuestionario");
		$_Lista_Empresas_anterior=json_decode($respuesta->row_array()["Lista_empresas"]);
		$_Lista_Empresas_anterior = json_decode(json_encode($_Lista_Empresas_anterior), True);
		$d=[];
		//ahora comparo si se aumento o se diminuyo
		if($_Tipo_App==="0"){
			//si la app ahroa se contestara por qval app no tiene caso tener los registros y los elimino de la tabla
			$_Lista_Empresas=[];
			foreach($_Lista_Empresas_anterior as $empresa){
				//ahora elimino todos los que pertenescan a esa empresa
				$this->db->where("IDEmpresa='".$empresa["IDCliente"]."'")->delete("tb_cuestionarios_usuarios_plus");
			}

		}else{
			if(count($_Lista_Empresas_anterior)<>count($_Lista_Empresas)){
				if(count($_Lista_Empresas_anterior)<count($_Lista_Empresas)){
					// aumentaron de empresas
					$flag_aumentar=true;
					$d = array_map('unserialize',array_diff(array_map('serialize', $_Lista_Empresas), array_map('serialize', $_Lista_Empresas_anterior)));
					// quito de la tabla a todos los que pertenescan a esa empresa
					foreach($d as $empresa){
						// obtengo los usuarios que pertenescan a esa empresa
						$_lista_usuarios=$this->Model_Usuariosplus->getAll_empresa($empresa["IDCliente"]);
						foreach($_lista_usuarios as $usuario){
							$array=array(
								"IDEmpresa"=>$empresa["IDCliente"],
								"IDUsuario"=>$usuario["IDUsuario"],
								"IDCuestionario"=>$_ID_Cuestionario,
								"Status"=>0,
								"Fecha_Envio"=>date("Y-m-d"),
								"Hora_Envio"=>date("h:i:s"),
								"Fecha_Respuesta"=>'',
								"Hora_Respuesta"=>'',
								"IDEmpresa_Emisora"=>$_Empresa_emisora
							);
							$this->db->insert("tb_cuestionarios_usuarios_plus",$array);
						}
					}	
					
					
				}else if(count($_Lista_Empresas_anterior)>count($_Lista_Empresas)){
					// disminuyo de empresas
					$flag_disminuir=true;	
					$d = array_map('unserialize',array_diff(array_map('serialize', $_Lista_Empresas_anterior ), array_map('serialize', $_Lista_Empresas)));
					foreach($d as $empresa){
						//ahora elimino todos los que pertenescan a esa empresa
						$this->db->where("IDEmpresa='".$empresa["IDCliente"]."'")->delete("tb_cuestionarios_usuarios_plus");
						
					}			
				}			
			}
		}
		
		$array=array(
			"Cuestionario"=>$_Cuestionario,
			"PerfilCalifica"=>$_PerfilCalifica,
			"PerfilCalificado"=>$_PerfilCalificado,
			"TPEmisor"=>$_TPEmisor,
			"TPReceptor"=>$_TPReceptor,
			"Tipoapp"=>$_Tipo_App,
			"Lista_empresas"=> json_encode($_Lista_Empresas)
		);
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("detallecuestionario",$array);
	}
	public function  delete($_ID_Cuestionario,$_status){
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->update("cuestionario",array("Status"=>$_status));
	}
	public function borrar($_ID_Cuestionario){
		return $this->db->where("IDCuestionario='$_ID_Cuestionario'")->delete("cuestionario");
	}
	//funcion para quitar a todos de un grupo
	public function update_group_c($_IDEmpresa,$_IDGroup){
		$array=array("Grupo"=>0);
		$this->db->where("Grupo='$_IDGroup'")->update("detallecuestionario",$array);
	}
	//funcion para quitar a todos de un grupo
	public function update_group_cu($_IDEmpresa,$_IDGroup,$_IDCuestionario){
		$array=array("Grupo"=>$_IDGroup);
		$this->db->where("IDCuestionario='$_IDCuestionario'")->update("detallecuestionario",$array);
	}
	
	//funcion para agregar un grupo de encuestas
	public function add_group($_IDEmpresa,$_Name){
		$array=array("IDEmpresa"=>$_IDEmpresa,"Nombre"=>$_Name);
		$this->db->insert("tbgruposencuestas",$array);
	}
	//funcion para obtener todos los grupos
	public function  getAllgroup($_IDEmpresa){
		$respuesta=$this->db->select("*")->where("IDEmpresa='$_IDEmpresa'")->get("tbgruposencuestas");
		return $respuesta->result_array();
	}
	public function update_gruop($_IDGroup,$_Name){
		$array=array("Nombre"=>$_Name);
		$this->db->where("IDGrupo='$_IDGroup'")->update("tbgruposencuestas",$array);
	}
	public function delete_group($_IDGroup){
		$this->db->where("IDGrupo='$_IDGroup'")->delete("tbgruposencuestas");
	}

	//funcionpara modificar las notificacfiones de uun cuestionario
	public function update_notificaciones($_IDCuestionario,$_Notificaciones){
		$array=array("Notificaciones"=>json_encode($_Notificaciones));
		return $this->db->where("IDCuestionario='$_IDCuestionario'")->update("detallecuestionario",$array);
	}
	
	//funcion para archivar una encuesta
	public function add_gropu_encuesta($_IDCuestionario,$_IDGrupo){
		$array=array("Grupo"=>$_IDGrupo);
		return $this->db->where("IDCuestionario='$_IDCuestionario'")->update("detallecuestionario",$array);
	}

	//funcion para borrrar las respuestas de este cuestionario
	public function deleterespuestas($_Calificacion){
		//primero obtengo los idvalora para poder eliminar los detalles
		$respuesta=$this->db->select('*')->where("IDCalificacion='$_Calificacion'")->get('tbcalificaciones');
		$respuesta=$respuesta->result_array();
		foreach($respuesta as $item){
			$this->db->where("IDValora='".$item['IDCalificacion']."'")->delete('detallecalificacion');
		}
		//ahora elimino las calificaciones de la tabla
		return $this->db->where("IDCalificacion='$_Calificacion'")->delete('tbcalificaciones');
	}
	//funcion para guardar como borrador
	public function add_borrador($_IDEmpresa,$_IDUsuario,$_Datos){
		$array=array("IDEmpresa"=>$_IDEmpresa,"IDUsuario"=>$_IDUsuario,"Datos"=>$_Datos);
		return $this->db->insert("tbencuestasborrador",$array);
	}

	public function encuestas_panel($_ID_Empresa){
		// funcion para obtener las ultimas encuestas 
		$respuesta=$this->db->select('*')->where("IDEmpresa='$_ID_Empresa'")->order_by('Fecha', 'DESC')->limit(5)->get('cuestionario');
		if($respuesta->num_rows()=== 0){
			return false;
		}else{
			$cuestionarios = $respuesta->result_array();
			$data=[];
			// ahroa obtengo los detalles de esos cuestionario
			foreach ($cuestionarios as $cuestionario) {
				$detalles=$this->getdetalles($cuestionario["IDCuestionario"]);
				$cuestionariolist=json_decode($detalles['Cuestionario']);
				$_numero_de_preguntas=count($cuestionariolist);
				$_numero_de_calificaciones=$this->getnumregistros($cuestionario["IDCuestionario"]);
				array_push($data,array(
				"IDCuestionario"=>$cuestionario["IDCuestionario"],
				"Nombre"=>$cuestionario["Nombre"],
				"Fecha"=>$cuestionario["Fecha"],
				"NumeroPreguntas"=>$_numero_de_preguntas,
				"NumerodeRegistros"=>$_numero_de_calificaciones
				));
			}
			return $data;

			
		}
	}
}