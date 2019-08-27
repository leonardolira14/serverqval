<?
class Pruebacorreo extends CI_Controller{
    function __construct()
	{
		header("Access-Control-Allow-Methods: GET");
    	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    	header("Access-Control-Allow-Origin: *");
		parent::__construct();
		
		$this->load->model("Model_Email");
    }
    
    //funcion para prueba de contraseña
    public function Recuperarpass(){
        $_Correo_envio="bernardodetomas@admyo.com";
        $Token="sfljhgskjdfh";
        $respuesta=$this->Model_Email->Recuperar_pass($_Correo_envio,$Token);
        var_dump($respuesta);
    }
    //funcion para prueba de activar usuario
    public function activarusuario(){
        $_Correo_envio="bernardodetomas@admyo.com";
        $Token="sfljhgskjdfh";
        $_Nombre="Leonardo";
        $_Apellido="Lira";
        $_Usuario="lira053@gmail.com";
        $_Clave="clave12345+6";
        $respuesta=$this->Model_Email->Activar_Usuario($Token,$_Correo_envio,$_Nombre,$_Apellido,$_Usuario,$_Clave);
        var_dump($respuesta);
    }
    //funcion para bienvenida
    public function bienvenida(){
        $_Correo_envio="bernardodetomas@admyo.com";
        $Token="sfljhgskjdfh";
        $_Nombre="Leonardo";
        $_Apellido="Lira";
        $_Usuario="lira053@gmail.com";
        $_Clave="clave12345+6";
        $respuesta=$this->Model_Email->bienvenida($_Correo_envio,$_Nombre,$_Apellido,$_Clave,$_Usuario,$Token);
        vdebug($respuesta);
    }
    //funcion para baja de usuario
    public function downuser(){
        $_Correo_envio="bernardodetomas@admyo.com";
        $respuesta=$this->Model_Email->down_user($_Correo_envio);
        vdebug($respuesta);
    }
    //funcion para baja de usuario admin
    public function downusernotification(){
        $_Correo_envio="bernardodetomas@admyo.com";
        $_Nombre="Leonardo";
        $_Apellido="Lira";
        $respuesta=$this->Model_Email->down_user_notification($_Correo_envio, $_Nombre,$_Apellido);
        vdebug($respuesta);
    }
}