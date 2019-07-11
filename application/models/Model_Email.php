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
			'smtp_user' => 'info@qvaluation.com',
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
		$this->email->from('info@qvaluation.com', 'InfoQvaluation');
	}
	
	//funcion para enviar correo de registro
	public function Recuperar_pass($_Correo_envio,$Token){
		$this->email->to($_Correo_envio);
		$this->email->subject("Recuperar Cuenta en Qvaluation");
		$body  =
		'<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Document</title>
			
		</head>
		<style type="text/css">
			body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
			.container {margin-right: auto;margin-left: auto; width: 100%;}
			.col-2 {width: 16.666667%;flex: 0 0 16.666667%;}
			.col-12 {width: 100%; flex: 0 0 100%;}
			.col-sm-7 {width: 90%; flex: 0 0 90%;}
			.d-flex{
				display: flex !important;
			}
			.justify-content-end{
				justify-content: end !important;
			}
			.text-center{
				text-align: center
			}
			.img-responsive{display: block;max-width: 100%;height: auto;}
			h1{
				font-size: 20pt;color: #878788;font-style: italic;font-weight: bold;
			}
			h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
			button{border-radius: 0Px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
			h4{text-align: justify;}h5{text-align: justify;}
			</style>
		<body>
			<div class="container">
				<div class="row d-flex justify-content-end">
					<div class="col-2">
						<img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-responsive" alt="">
					</div>
					
				</div>
				<div class="row">
						<div class="col-12 text-center">
								<h1>Cambio de contraseña</h1>
						</div>
						<div class="col-12 text-center">
								<h4 class="text-center" style="color:#878788">Ha solicitado un cambio de contraseña en la herramienta.</h4>
						</div>
						<div class="col-12">
								<h5 class="text-center"><span style="font-weight: bold;color:#878788"> Presione el siguiente enlace para acceder a cambiar su contraseña:</span></h5>
						</div>
						<div class="col-12 text-center">
								<a href="https://qval.admyo.com/changepassword/'.$Token.'"><button type="button" >Cambiar Contraseña</button></a>
						 </div>
						
					   
						<p>
							<small style="color:#878788">Gracias por elegir Qvaluation.</small>
						</p>
						<p>
								<small style="color:#878788">Equipo de Qvaluation.com.</small>
							</p>
					   
		
						<div class="col-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
					   
				</div>
			</div>
			
		</body>
		</html>';
		
		$this->email->message($body);
		$this->email->send();
	}
	public function Activar_Usuario($Token,$_Correo_envio,$_Nombre,$_Apellido,$_Usuario,$_Clave){
		$this->email->to($_Correo_envio);
		$this->email->subject("Bienvenido ".$_Nombre." ".$_Apellido.", active su cuenta");
		$body  =
		'<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Document</title>
			
		</head>
		<style type="text/css">
			body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
			.container {margin-right: auto;margin-left: auto; width: 100%;}
			.col-2 {width: 16.666667%;flex: 0 0 16.666667%;}
			.col-12 {width: 100%; flex: 0 0 100%;}
			.col-sm-7 {width: 90%; flex: 0 0 90%;}
			.d-flex{
				display: flex !important;
			}
			.justify-content-end{
				justify-content: end !important;
			}
			.text-center{
				text-align: center
			}
			.img-responsive{display: block;max-width: 100%;height: auto;}
			h1{
				font-size: 20pt;color: #878788;font-style: italic;font-weight: bold;
			}
			h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
			button{border-radius: 0Px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
			h4{text-align: justify;}h5{text-align: justify;}
			</style>
		<body>
			<div class="container">
				<div class="row d-flex justify-content-end">
					<div class="col-2">
						<img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-responsive" alt="">
					</div>
					
				</div>
				<div class="row">
						<div class="col-12 text-center">
								<h1>Bienvenido a Qvaluation</h1>
						</div>
						<div class="col-12 text-center">
								<h4 class="text-center" style="color:#878788">La herramienta con la que podrás medir y gestionar cualquier variable o interrogante de negocio a tiempo real.</h4>
						</div>
						
						<div class="col-12 text-center">
							   <a href="https://qval.admyo.com/activarcuenta/'.$Token.'"><button type="button" >ACTIVA TU CUENTA</button></a>
						</div>
						<div class="col-12">
								<h5 class="text-center"><span style="font-weight: bold;color:#878788"> Haga clic en el botón</span></h5>
						</div>
						<div class="col-sm-12" style="margin-top:40px">
							<h4 style="color:#878788">Usuario'.$_Usuario.'</h4>
							<h4 style="color:#878788">Contraseña'.$_Clave.'</h4>
						</div> 
						<div class="col-12">
							<h5 style="color:#878788">Dentro de qvaluation.com podrás cambiar tu contraseña en cualquier momento.</h5>
						</div>
						
						<p>
							<small style="color:#878788">Gracias por elegir Qvaluation.</small>
						</p>
					   
		
						<div class="col-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
						<p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
					   
				</div>
			</div>
			
		</body>
		</html>';
		
		$this->email->message($body);
		$this->email->send();
	}
	public function bienvenida($_Correo_envio,$_Nombre,$_Apellido,$_Clave,$_Usuario,$Token){
		$this->email->to($_Correo_envio);
		$this->email->subject("Bienvenido ".$_Nombre." ".$_Apellido.", a Qval");
		$body  =
		'<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Document</title>
			
		</head>
		<style type="text/css">
			body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
			.container {margin-right: auto;margin-left: auto; width: 100%;}
			.col-2 {width: 16.666667%;flex: 0 0 16.666667%;}
			.col-12 {width: 100%; flex: 0 0 100%;}
			.col-sm-7 {width: 90%; flex: 0 0 90%;}
			.d-flex{
				display: flex !important;
			}
			.justify-content-end{
				justify-content: end !important;
			}
			.text-center{
				text-align: center
			}
			.img-responsive{display: block;max-width: 100%;height: auto;}
			h1{
				font-size: 20pt;color: #878788;font-style: italic;font-weight: bold;
			}
			h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
			button{border-radius: 0Px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
			h4{text-align: justify;}h5{text-align: justify;}
			</style>
		<body>
			<div class="container">
				<div class="row d-flex justify-content-end">
					<div class="col-2">
						<img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-responsive" alt="">
					</div>
					
				</div>
				<div class="row">
						<div class="col-12 text-center">
								<h1>Bienvenido a Qvaluation</h1>
						</div>
						<div class="col-12 text-center">
								<h4 class="text-center" style="color:#878788">La herramienta con la que podrás medir y gestionar cualquier variable o interrogante de negocio a tiempo real.</h4>
						</div>
						
						<div class="col-12 text-center">
							   <a href="https://qval.admyo.com/activarcuenta/'.$Token.'"><button type="button" >ACTIVA TU CUENTA</button></a>
						</div>
						<div class="col-12">
								<h5 class="text-center"><span style="font-weight: bold;color:#878788"> Haga clic en el botón</span></h5>
						</div>
						<div class="col-sm-12" style="margin-top:40px">
							<h4 style="color:#878788">Usuario'.$_Usuario.'</h4>
							<h4 style="color:#878788">Contraseña'.$_Clave.'</h4>
						</div> 
						<div class="col-12">
							<h5 style="color:#878788">Dentro de qvaluation.com podrás cambiar tu contraseña en cualquier momento.</h5>
						</div>
						<div class="col-12">
								<h5 style="color:#878788">Tu pago en qvalution.com ha sido procesado correctamente</h5>
						</div>
						<div class="col-12">
								<h5 style="color:#878788">Has contratado el paquete:</h5>
						</div>
						<div class="col-12">
								<h4 style="color:#e96610">Empresarial Mensual de 3.000 MXN + IVA </h4>
						</div>
						<div class="col-12">
								<h6 style="color:#878788">Una vez vencido tendrá que volver a pagar para acceder a la herramienta. Si requiere una factura por favor solicítela en facturacion@qvaluation.com</h6>
						</div>
						<p>
							<small style="color:#878788">Gracias por elegir Qvaluation.</small>
						</p>
					   
		
						<div class="col-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
						<p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
					   
				</div>
			</div>
			
		</body>
		</html>';
		
		$this->email->message($body);
		$this->email->send();
	}
	// cooreo para notificar al usuario que se ha dado de baja ese usuario
	public function down_user($_Correo_envio){
		$this->email->to($_Correo_envio);
		$this->email->subject("Baja de Usuario qvaluation");
		$body  = 
		'<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Document</title>
			
		</head>
		<style type="text/css">
			body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
			.container {margin-right: auto;margin-left: auto; width: 100%;}
			.col-2 {width: 16.666667%;flex: 0 0 16.666667%;}
			.col-12 {width: 100%; flex: 0 0 100%;}
			.col-sm-7 {width: 90%; flex: 0 0 90%;}
			.d-flex{
				display: flex !important;
			}
			.justify-content-end{
				justify-content: end !important;
			}
			.text-center{
				text-align: center
			}
			.img-responsive{display: block;max-width: 100%;height: auto;}
			h1{
				font-size: 20pt;color: #878788;font-style: italic;font-weight: bold;
			}
			h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
			button{border-radius: 0Px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
			h4{text-align: justify;}h5{text-align: justify;}
			</style>
		<body>
			<div class="container">
				<div class="row d-flex justify-content-end">
					<div class="col-2">
						<img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-responsive" alt="">
					</div>
					
				</div>
				<div class="row">
						<div class="col-12 text-center">
								<h1>Baja Usuario</h1>
						</div>
						<div class="col-12 text-center">
								<h4 class="text-center" style="color:#878788">Baja del sistema qvaluation.com.</h4>
						</div>
						<div class="col-12">
								<h5 class="text-center"><span style="font-weight: bold;color:#878788"> Usted ha sido dado de baja del sistema qvaluation.com         </span></h5>
						</div>
						<div class="col-12">
								<h5 class="text-center"><span style="font-weight: bold;color:#878788"> Si cree que le han dado de baja de forma indebida por favor ponerse en contacto con nosotros.</span></h5>
						</div>
						
					   
						<p>
							<small style="color:#878788">Gracias por elegir Qvaluation.</small>
						</p>
						<p>
								<small style="color:#878788">Equipo de Qvaluation.com.</small>
							</p>
					   
		
						<div class="col-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
					   
				</div>
			</div>
			
		</body>
		</html>';
		$this->email->message($body);
		$this->email->send();
	}
	//funcion para notificar al usuario que dio de baja a ese usuario
	public function down_user_notification($_Correo_envio, $_Nombre,$_Apellidos){
		$this->email->to($_Correo_envio);
		$this->email->subject("Baja de Usuario qvaluation");
		$body =
		'<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>Document</title>
			
		</head>
		<style type="text/css">
			body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
			.container {margin-right: auto;margin-left: auto; width: 100%;}
			.col-2 {width: 16.666667%;flex: 0 0 16.666667%;}
			.col-12 {width: 100%; flex: 0 0 100%;}
			.col-sm-7 {width: 90%; flex: 0 0 90%;}
			.d-flex{
				display: flex !important;
			}
			.justify-content-end{
				justify-content: end !important;
			}
			.text-center{
				text-align: center
			}
			.img-responsive{display: block;max-width: 100%;height: auto;}
			h1{
				font-size: 20pt;color: #878788;font-style: italic;font-weight: bold;
			}
			h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
			button{border-radius: 0Px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
			h4{text-align: justify;}h5{text-align: justify;}
			</style>
		<body>
			<div class="container">
				<div class="row d-flex justify-content-end">
					<div class="col-2">
						<img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-responsive" alt="">
					</div>
					
				</div>
				<div class="row">
						<div class="col-12 text-center">
								<h1>Baja Usuario</h1>
						</div>
						<div class="col-12 text-center">
								<h4 class="text-center" style="color:#878788">Ha solicitado una baja de usuario del sistema.</h4>
						</div>
						<div class="col-12">
								<h5 ><span style="font-weight: bold;color:#878788"> El siguiente usuario ya no podrá acceder más al sistema:</span></h5>
						</div>
						<div class="col-12">
								<h5 ><span style="font-weight: bold;color:#878788"> '.$_Nombre.' '.$_Apellidos.'</span></h5>
						</div>
						
					   
						<p>
							<small style="color:#878788">Gracias por elegir Qvaluation.</small>
						</p>
						<p>
								<small style="color:#878788">Equipo de Qvaluation.com.</small>
							</p>
					   
		
						<div class="col-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
					   
				</div>
			</div>
			
		</body>
		</html>';
		$this->email->message($body);
		$this->email->send();
		
	} 
	

	

	
	
}