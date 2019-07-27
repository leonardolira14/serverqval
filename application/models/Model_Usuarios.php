<?php

/**
 * 
 */
class Model_Usuarios extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->constante="FpgH456Gtdgh43i349gjsjf%ttt";
	}

	public function verificar_clave($IDUsuario,$_Clave){
		$_Clave=md5($_Clave.$this->constante);
		$respuesta=$this->db->select('*')->where("IDUsuario='$IDUsuario' and Clave='$_Clave'")->get("usuario");
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return true;
		}

	}
	//funcion para para saber cuantos registros tengo de un usuario
	public function getnumregistros($_ID_Usuario){
		$emisor=$this->db->select("count(*) as numero")->where("IDEmisor='$_ID_Usuario' and TEmisor='I'")->get("tbcalificaciones");
		$receptor=$this->db->select("count(*) as numero")->where("IDReceptor='$_ID_Usuario' and TReceptor='I'")->get("tbcalificaciones");

		$total=(int)$emisor->row_array()["numero"]+(int)$receptor->row_array()["numero"];
		
		return $total;
	}	
	//funcion para obtener el numero de usuarios de una empresa
	public function numus($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as NumUsuarios")->where("IDEmpresa='$_ID_Empresa'")->get("usuario");
		return $respuesta->row();
	}
	//funcion para el login
	public function login($_Usuario,$_Clave){
		//concateno la clave
		$_Clave=md5($_Clave.$this->constante);
		
		//ahora realizo la consulta
		$sql=$this->db->select('*')->where("Usuario='$_Usuario' and Clave='$_Clave'")->get("usuario");
		//vdebug($_Clave);
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row();
		}	
	}
	//funcion para actualizar la clave
	public function update_clave($IDUsuario,$Clave){
		$clave=md5($Clave.$this->constante);
		$array=array("Clave"=>$clave);
		$this->db->where("IDUsuario='$IDUsuario'")->update("usuario",$array);
	}
	//funcion para recuperar la clave
	public function recuperar_clave($_Correo){
		$sql=$this->db->select("*")->where("Correo='$_Correo'")->get("usuario");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row_array();
		}	
	}
	//funcion para actulizar datos generales
	public function update_general($_nombre,$_Correo,$_puesto,$apellidos,$_ID_Usuario,$Imagen,$IDConfig,$celular){
		$array=array("Nombre"=>$_nombre,"Correo"=>$_Correo,"Puesto"=>$_puesto,"Apellidos"=>$apellidos,"Imagen"=>$Imagen,"IDConfig"=>$IDConfig,"Celular"=>$celular);
		return $this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$array);
	}
	
	//funcion para obtener todos los usuarios de una empresa
	public function getAll($_ID_Empresa){
		$respuesta=$this->db->select("IDUsuario as ID,Nombre,Apellidos,IDEmpresa,Puesto,Usuario,Correo,Funciones,IDConfig,Est as Estado,Imagen,Celular")->where("IDEmpresa='$_ID_Empresa'")->get('usuario');
		if($respuesta->num_rows()===0){
			return false;
		}else{
			return $respuesta->result();
		}	
	}
	//funcion para agregar un usuario
	public function add_usuario($IDEmpresa,$Nombre,$Apellidos,$correo){
		$array=array(
			"IDEmpresa"=>$IDEmpresa,
			"Nombre"=>$Nombre,
			"Apellidos"=>$Apellidos,
			"Usuario"=>$correo,
			"Correo"=>$correo,
			"Est"=>'1',
			"funciones"=>json_encode(["1","1","1","1","1","1","1","1","1"])
		); 
		$this->db->insert("usuario",$array);
	}
	//funcion para egregar un nuevo usuario
	public function save($_ID_Empresa,$_Nombre,$_Apellido,$_Puesto,$_Correo,$_Configuracion,$_Funciones,$_Usuario,$_Imagen,$_Celular,$clave){
		$clave=md5($clave.$this->constante);
		$Token=md5($data["H:i:s"]);
		$datos=array(
			"IDEmpresa"=>$_ID_Empresa,
			"Nombre"=>$_Nombre,
			"Apellidos"=>$_Apellido,
			"Puesto"=>$_Puesto,
			"Correo"=>$_Correo,
			"IDConfig"=>$_Configuracion,
			"Funciones"=>$_Funciones,
			"Usuario"=>$_Usuario,
			"Est"=>0,
			"Imagen"=>$_Imagen,
			"Celular"=>$_Celular,
			"Clave"=>$clave,
			"Token"=>$Token
		);
		$this->db->insert("usuario",$datos);
		return $Token;

	}
	public function update_status($_ID_Usuario,$_Estado){
		$array=array("Est"=>$_Estado);
		$respuesta=$this->db->where("IDUsuario=$_ID_Usuario")->update("usuario",$array);
		return $respuesta;
	}
	public function delete_user($_ID_Usuario){
		$this->db->where("IDUsuario='$_ID_Usuario'")->delete("usuario");
	}

	public function update($_ID_Usuario,$_Nombre,$_Apellido,$_Puesto,$_Correo,$_Configuracion,$_Funciones,$_Usuario,$_Imagen,$_Celular){
		$datos=array(
			"Nombre"=>$_Nombre,
			"Apellidos"=>$_Apellido,
			"Puesto"=>$_Puesto,
			"Correo"=>$_Correo,
			"Imagen"=>$_Imagen,
			"IDConfig"=>$_Configuracion,
			"Funciones"=>$_Funciones,
			"Usuario"=>$_Usuario,
			"Celular"=>$_Celular
		);
		return $this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$datos);
	}
	public function update_function($_ID_Usuario,$_funciones){
		$array=array("Funciones"=>$_funciones);
		return $this->db->where("IDUsuario='$_ID_Usuario'")->update("usuario",$array);
	}
	//funcion para obtener los datos del usuario
	public function getdata($_IDUsuario){
		$sql=$this->db->select("*")->where("IDUsuario='$_IDUsuario'")->get("usuario");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row_array();
		}	
	}
	public function activacuenta($_token){
		//primero veo si existe el token
		$datos=$this->db->select('*')->where("Token='$_token'")->get('usuario');
		if($datos->num_rows()===0){
			return false;
		}else{
			$datos_usuario=$datos->row_array();
			//vdebug($datos_usuario);
			return $this->db->where("IDUsuario='".$datos_usuario['IDUsuario']."'")->update("usuario",array("Est"=>1));
		}
	}
}