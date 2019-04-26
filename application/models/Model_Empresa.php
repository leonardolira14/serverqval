<?php

/**
 * 
 */
class Model_Empresa extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//funcion para agregar una empresa
	public function add_empresa($_Razon_Social,$Nombre_Comercial,$RFC,$TipoEmpresa,$NoEmpleados,$telefono,$customer_ID,$Status_id,$PlanID,$IDAdmyo){
		$array=array(
			"RazonSocial"=>$_Razon_Social,
			"NombreComercial"=>$Nombre_Comercial,
			"RFC"=>$RFC,
			"TipoEmpresa"=>$TipoEmpresa,
			"NoEmpleados"=>$NoEmpleados,
			"Telefono"=>$telefono,
			"Customer_id"=>$customer_ID,
			"Status_Conecta"=>$Status_id,
			"PlanID"=>$PlanID,
			"IDAdmyo"=>$IDAdmyo
		);
		$this->db->insert("empresa",$array);
		return $this->db->insert_id();
	}
	//funcion para obtener los datos de una empresa
	public function getEmpresa($ID){
		$sql=$this->db->select('*')->where("IDEmpresa='$ID'")->get("empresa");
		if($sql->num_rows()===0){
			return false;
		}else{
			return $sql->row();
		}
	}
	//funcion para modificcar de la base de datos 
	public function  updateimg($_ID_Empresa,$_img,$_Tipo){
		if($_Tipo==="logo"){
			$array=array("Logo"=>$_img);
		}else{
			$array=array("Banner"=>$_img);
		}
		$this->db->where("IDEmpresa='$_ID_Empresa'")->update("empresa",$array);
		
	}
	//funcion para actulizar los datos de una empresa
	public function udateinfo($_Emrpesa,$rz,$nc,$rfc,$tem,$nempleados,$facanual,$tel,$perfile,$calle,$municipio,$colonia,$estado,$cp){
		$array=array("RazonSocial"=>$rz,"NombreComercial"=>$nc,"RFC"=>$rfc,"TipoEmpresa"=>$tem,"NoEmpleados"=>$nempleados,"FacturacionAnual"=>$facanual,"Descripcion"=>$perfile,"Calleynum"=>$calle,"Colonia"=>$colonia,"Municipio"=>$municipio,"CP"=>$cp,"Estado"=>$estado,"Telefono"=>$tel);
		$this->db->where("IDEmpresa='$_Emrpesa'")->update("empresa",$array);
		
	}
}