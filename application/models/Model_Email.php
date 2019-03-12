<?
/**
 * Modelo para Email
 */
class Model_Email extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.ionos.es',
			'smtp_port' => 587,
			'smtp_user' => 'infoadmyo@admyo.com',
			'smtp_pass' => 'Admyo246*',
			'mailtype'  => 'html', 
			'charset' => 'utf-8',
			'wordwrap' => TRUE,
			'smtp_crypto'=>'tls',
			'wrapchars'=>76,
			'charset'=>'utf-8',
			'validate'=>TRUE,
			'crlf'=>"\r\n",
			'newline'=>"\r\n",
			'bcc_batch_mode'=>FALSE,
			'bcc_batch_size'=>200,

		);
		$this->email->initialize($this->config);
		$this->email->from('infoadmyo@admyo.com', 'InfoAdmyo');
	}
	
	//funcion para enviar correo de registro
	public function Recuperar_pass($_Correo_envio,$_Nombre,$_Apellido,$Usuario,$Clave){
		$this->email->to($_Correo_envio);
		$this->email->subject("Recuperar Cuenta en Qval");
		$body  =
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}h4{text-align: justify;}h5{text-align: justify;}
		</style>
		</head>
		<body>
		<div class="container">
		<center><div class="col-sm-7">
		<img class="img-responsive" src="admyo.com/assets/img/images-mail/header-admyo-bienvenida.jpg" />
		</div></center>
		<center><div class="col-sm-7">
		<div class="col-sm-12">
		<center><br><h3>¡Recuperar Contraseña en Qval!</h3></center>
		</div>
		<div class="col-sm-12">
			Hola! '.$_Nombre.', el equipo de Qval a recibido la solicitud de recuperacion de contraseña acontinuación te mandamos tu usuario y tu nueva contraseña recuenda de cambiarla ya que este contraseña es temporal y generica.
		</div>
		<div class="col-sm-12" style="margin-top:40px">
		<h5>Usuario'.$Usuario.'</h5>
		<h5>Contraseña'.$Clave.'</h5>
		</div>
		<p>En nombre del equipo de admyo, le damos la bienvenida. admyo.com es una plataforma enfocada en la reputación empresarial para que las empresas puedan crecer su negocio y gestionar su riesgo. Si no has visto nuestro video, te recomendamos que lo mires <a href="https://player.vimeo.com/video/48771589?autoplay=1" >aquí</a>.</p>
		<p><font color="#005288" style="font-weight: bold;">¿Quiere crecer su negocio diferenciándose de su competencia? </font> Descubra cuanto puede crecer su negocio requiriendo a sus clientes y proveedores que le califiquen. Promueva su perfil empresarial. </p>
		<p><font color="#005288" style="font-weight: bold;">¿Quieres aparecer en nuestra página de inicio?, ¿Que publiquemos sobre ti en redes sociales?,</font> entre más participes calificando a empresas más puntos de public static idad y descuentos obtendrás. </p>
		<p><font color="#005288" style="font-weight: bold;">¿Quieres saber el riesgo que corres con tus clientes o proveedores?</font> Exígeles que tengan y mantengan un perfil  empresarial en <a href="https://admyo.com/" >admyo.com </a></p>
		<p><font color="#005288" style="font-weight: bold;">¿Quiere saber si puede aplicar a un descuento?</font> Si es una empresa con menos de un año de antigüedad puedes obtener un descuento del <font style="font-weight: bold;"> 50% </font>, además tenemos acuerdos con algunas cámaras y asociaciones. Para más información mándenos un email a <a href="mailto:promociones@admyo.com" target="_top">promociones@admyo.com</a><br><br></p>
		<h5><font style="font-weight: bold;">Es necesario que active su cuenta. Haga clic en el siguiente botón</font></h5>
		<div class="col-sm-12"><center><a href="'.$_SERVER['HTTP_HOST'].'/" ><button type="button" >IR A SU CUENTA</button></a><br><br></div>
		<p>Si no basta con hacer clic, copie y pegue el siguiente enlace en su navegador. <br><a href="'.$_SERVER['HTTP_HOST'].'/" >"'.$_SERVER['HTTP_HOST'].'"</a><br><br></p>
		<h4><font color="#005288" style="font-weight: bold;">¡Genere su perfil para que su negocio crezca!</font></h4>
		<p>Saludos,<br> 
		<font color="#005288" style="font-weight: bold;">Equipo admyo</font></p>     
		<div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >““… A man I do not trust could not get money from me on all the bonds in Christendom. I think that is the fundamental basis of business.”…<font style="font-weight: bold;">J. P. Morgan</font></font></p></div>
		<div class="col-sm-12"><p><a href="https://www.admyo.com/terminos-condiciones/" style="color: #21334d;" target="_blank"> Politica de privacidad  |  Términos y condiciones </a></p></div>
		</div></center></div>
		</body>';
		
		$this->email->message($body);
		$this->email->send();
	}

	

	
	
}