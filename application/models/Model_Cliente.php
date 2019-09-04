<?php

/**
 * 
 */
class Model_Cliente extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para saber cuantos registros tiene ese cliente
	public function getnumregistros($_ID_Cliente){
		$emisor=$this->db->select("count(*) as numero")->where("IDEmisor='$_ID_Cliente'")->get("tbcalificaciones");
		$receptor=$this->db->select("count(*) as numero")->where("IDReceptor='$_ID_Cliente'")->get("tbcalificaciones");

		$total=(int)$emisor->row_array()["numero"]+(int)$receptor->row_array()["numero"];

		return $total;
	}
	//funcion para saber le numero de clientes registrados de una empresa
	public function numclientes($_ID_Empresa){
		$respuesta=$this->db->select("count(*) as numclientes")->where("IDEmpresa='$_ID_Empresa'")->get("clientes");
		return $respuesta->row();
	}
	//funcion para obtener los datos de un cliente
	public function getUser($_ID_Cliente){
		$sql=$this->db->where("IDCliente='$_ID_Cliente'")->get("clientes");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row_array();
		}
	}
	//funcion para obtener todos los clientes
	public function getAll($_ID_Empresa){
		$sql=$this->db->select('*')->where("IDEmpresa='$_ID_Empresa'")->get("clientes");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->result_array();
		}
	}
	//funcion para actualizar un cliente
	public function update($_ID_Cliente,$_Razon,$_NombreC,$RFC,$_Municipo,$_Direccion,$_Puesto,$_Tel,
		$_EEstado,$_Correo,$_IDConfig,$_Estado,$_TPersona,$_Apellidos,$_Actipass,$_Tel_contact,$_Imagen){
		$array=array("Nombre"=>$_Razon,"NombreComercial"=>$_NombreC,"RFC"=>$RFC,"Municipio"=>$_Municipo,"Direccion"=>$_Direccion,"Puesto"=>$_Puesto,"Tel"=>$_Tel,"EEstado"=>$_EEstado,"Correo"=>$_Correo,"IDConfig"=>$_IDConfig,"Estado"=>$_Estado,"TPersona"=>$_TPersona,"Apellidos"=>$_Apellidos,"Actipass"=>$_Actipass,"Telcontact"=>$_Tel_contact,"Imagen"=>$_Imagen);
		return $this->db->where("IDCliente='$_ID_Cliente'")->update("clientes",$array);

	}
	//funcion para agregar un nuevo cliente
	public function save($_ID_Empresa,$_Razon,$_NombreC,$RFC,$_Municipo,$_Direccion,$_Puesto,$_Tel,
		$_EEstado,$_Correo,$_IDConfig,$_Estado,$_TPersona,$_Apellidos,$_Actipass,$_Tel_contact,$_Imagen)
		{
		
		$usuario=md5(date('Y-m-d').$_Razon.date('H:i'));
		$array=array("Usuario"=>$usuario,"IDEmpresa"=>$_ID_Empresa,"Nombre"=>$_Razon,"NombreComercial"=>$_NombreC,"RFC"=>$RFC,"Municipio"=>$_Municipo,"Direccion"=>$_Direccion,"Puesto"=>$_Puesto,"Tel"=>$_Tel,"EEstado"=>$_EEstado,"Correo"=>$_Correo,"IDConfig"=>$_IDConfig,"Estado"=>$_Estado,"TPersona"=>$_TPersona,"Apellidos"=>$_Apellidos,"Actipass"=>$_Actipass,"Telcontact"=>$_Tel_contact,"Imagen"=>$_Imagen);
		return $this->db->insert("clientes",$array);
	}
	//funcion para desactvar un cliente oo activar
	public function updatestaus($_ID_Cliente,$_status){
		$array=array("Estado"=>$_status);
		return $this->db->where("IDCliente='$_ID_Cliente'")->update("clientes",$array);
	}
	public function delete_clie($_ID_Usuario){
		$this->db->where("IDCliente='$_ID_Usuario'")->delete("clientes");
	}
	//funcuion para obtener las empresas que pertenescan a un grupo
	public function num_reg($_ID_Grupo,$_ID_Empresa){
		$respuesta=$this->db->select("Nombre,IDCliente")->where("IDConfig='$_ID_Grupo' and IDEmpresa='$_ID_Empresa'")->get("clientes");
		$_data["numero"]=$respuesta->num_rows();
		$_data["empresas"]=$respuesta->result_array();
		return $_data;
		
	}
}