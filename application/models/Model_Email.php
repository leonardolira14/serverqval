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
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
        .img-fluid{width: 250px;}
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
		button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
		h4{text-align: justify;}h5{text-align: justify;}
		table {
			border-collapse: separate;
			border: 4px solid #fff;  
			background: #fff;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 20px auto;
			-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		thead {
			-moz-border-radius: 8px;
			-webkit-border-radius: 8px;
			border-radius: 8px;
		}

		thead td {
			font-family: "Open Sans", sans-serif;
			font-size: 23px;
			font-weight: 400;
			color: #fff;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-align: left;
			padding: 20px;
			background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
			background-size: 100%;
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #005d8f), color-stop(100%, #4a5564));
			background-image: -moz-linear-gradient(#005d8f, #004266);
			background-image: -webkit-linear-gradient(#005d8f, #004266);
			background-image: linear-gradient(#005d8f, #004266);
			border-top: 1px solid #005d8f;
		}
		thead th:first-child {
			-moz-border-radius-topleft: 8px;
			-webkit-border-top-left-radius: 8px;
			border-top-left-radius: 8px;
		}
		thead th:last-child {
			-moz-border-radius-topright: 8px;
			-webkit-border-top-right-radius: 8px;
			border-top-right-radius: 8px;
		}

		tbody tr td {
			font-family: "Open Sans", sans-serif;
			font-weight: 400;
			color: #5f6062;
			font-size: 16px;
			padding: 20px 20px 20px 20px;
			border-bottom: 1px solid #e0e0e0;
		}

		tbody tr:nth-child(2n) {
			background: #e6f2f5;
		}

		tbody tr:last-child td {
			border-bottom: none;
		}
		tbody tr:last-child td:first-child {
			-moz-border-radius-bottomleft: 8px;
			-webkit-border-bottom-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}
		tbody tr:last-child td:last-child {
			-moz-border-radius-bottomright: 8px;
			-webkit-border-bottom-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		tbody:hover > tr td {
			filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
			opacity: 0.5;
			/* uncomment for blur effect */
			/* color:transparent;
			@include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
		}

		tbody:hover > tr:hover td {
			text-shadow: none;
			color: #2d2d2d;
			filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
			opacity: 1;
		}

		</style>
		</head>
		<body>
		<div class="container">
		<div class="col-sm-7">
            <img src="https://qval.admyo.com/assets/img/Qval-logo_1024x500.png" class="img-fluid" alt="">
		</div>
		<center><div class="col-sm-7">
		<div class="col-sm-12">
		<center><br><h3>¡Cambio de contraseña!</h3></center>
        </div>
        <center>
            <span class="text-center" style="color:#878788">Ha solicitado un cambio de contraseña en la herramienta.</span>
        </center>
        <div class="col-sm-12"><center><a href="https://qvaluation.com/changepassword/'.$Token.'" >
            <button type="button" >Cambiar Contraseña</button>
        </a><br><br>
        </div>
		
        <center>
                <h5 style="font-weight: bold;color:#878788; text-align: center;"> Haga clic en el botón</h5>
        </center>

		</div>
		
		<div class="col-sm-12">
                <h5 style="color:#878788">Dentro de qvaluation.com podrás cambiar tu contraseña en cualquier momento.</h5>
        </div>
        <p>
            <small style="color:#878788">Gracias por elegir Qvaluation.</small>
        </p>
		<p>Saludos,<br> 
        <font color="#005288" style="font-weight: bold;">Equipo qvaluation</font></p> 
        <div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >The most important thing for a young man is to establish credit - a reputation and character”... <br><font style="font-weight: bold;">John D. Rockefeller</font></font></p></div>
        <p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
        
		</div></center></div>
		</body>
		</html>';
		
		$this->email->message($body);
		return $this->email->send();
	}
	public function Activar_Usuario($Token,$_Correo_envio,$_Nombre,$_Apellido,$_Usuario,$_Clave){
		$this->email->to($_Correo_envio);
		$this->email->subject("Bienvenido ".$_Nombre." ".$_Apellido.", active su cuenta");
		$body  =
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
        .img-fluid{width: 250px;}
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
		button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
		h4{text-align: justify;}h5{text-align: justify;}
		table {
			border-collapse: separate;
			border: 4px solid #fff;  
			background: #fff;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 20px auto;
			-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		thead {
			-moz-border-radius: 8px;
			-webkit-border-radius: 8px;
			border-radius: 8px;
		}

		thead td {
			font-family: "Open Sans", sans-serif;
			font-size: 23px;
			font-weight: 400;
			color: #fff;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-align: left;
			padding: 20px;
			background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
			background-size: 100%;
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #005d8f), color-stop(100%, #4a5564));
			background-image: -moz-linear-gradient(#005d8f, #004266);
			background-image: -webkit-linear-gradient(#005d8f, #004266);
			background-image: linear-gradient(#005d8f, #004266);
			border-top: 1px solid #005d8f;
		}
		thead th:first-child {
			-moz-border-radius-topleft: 8px;
			-webkit-border-top-left-radius: 8px;
			border-top-left-radius: 8px;
		}
		thead th:last-child {
			-moz-border-radius-topright: 8px;
			-webkit-border-top-right-radius: 8px;
			border-top-right-radius: 8px;
		}

		tbody tr td {
			font-family: "Open Sans", sans-serif;
			font-weight: 400;
			color: #5f6062;
			font-size: 16px;
			padding: 20px 20px 20px 20px;
			border-bottom: 1px solid #e0e0e0;
		}

		tbody tr:nth-child(2n) {
			background: #e6f2f5;
		}

		tbody tr:last-child td {
			border-bottom: none;
		}
		tbody tr:last-child td:first-child {
			-moz-border-radius-bottomleft: 8px;
			-webkit-border-bottom-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}
		tbody tr:last-child td:last-child {
			-moz-border-radius-bottomright: 8px;
			-webkit-border-bottom-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		tbody:hover > tr td {
			filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
			opacity: 0.5;
			/* uncomment for blur effect */
			/* color:transparent;
			@include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
		}

		tbody:hover > tr:hover td {
			text-shadow: none;
			color: #2d2d2d;
			filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
			opacity: 1;
		}

		</style>
		</head>
		<body>
		<div class="container">
		<div class="col-sm-7">
            <img src="https://qvaluation.com/assets/img/Qval-logo_1024x500.png" class="img-fluid" alt="">
		</div>
		<center><div class="col-sm-7">
		<div class="col-sm-12">
		<center><br><h3>¡Bienvenido a Qvaluation!</h3></center>
        </div>
        <center>
            <h4 class="text-center" style="color:#878788">La herramienta con la que podrás medir y gestionar cualquier variable o interrogante de negocio a tiempo real.</h4>
        </center>
        <div class="col-sm-12"><center><a href="https://qvaluation.com/activarcuenta/'.$Token.'" >
            <button type="button" >ACTIVA TU CUENTA</button>
        </a><br><br>
        </div>
		
        <center>
                <h5 style="font-weight: bold;color:#878788; text-align: center;"> Haga clic en el botón</h5>
        </center>

		</div>
		<div class="col-sm-12" style="margin-top:40px">
                <h4 style="color:#878788">Usuario: '.$_Usuario.'</h4>
                <h4 style="color:#878788">Contraseña: '.$_Clave.'</h4>
        </div> 
		<div class="col-sm-12">
                <h5 style="color:#878788">Dentro de qvaluation.com podrás cambiar tu contraseña en cualquier momento.</h5>
        </div>
        <p>
            <small style="color:#878788">Gracias por elegir Qvaluation.</small>
        </p>
		<p>Saludos,<br> 
        <font color="#005288" style="font-weight: bold;">Equipo qvaluation</font></p> 
        <div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >The most important thing for a young man is to establish credit - a reputation and character”... <br><font style="font-weight: bold;">John D. Rockefeller</font></font></p></div>
        <p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
        
		</div></center></div>
		</body>
		</html>';
		
		$this->email->message($body);
		return $this->email->send();
	}
	public function bienvenida($_Correo_envio,$_Nombre,$_Apellido,$_Clave,$_Usuario,$Token){
		$this->email->to($_Correo_envio);
		$this->email->subject("Bienvenido ".$_Nombre." ".$_Apellido.", a Qval");
		$body  =
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
        .img-fluid{width: 250px;}
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
		button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
		h4{text-align: justify;}h5{text-align: justify;}
		table {
			border-collapse: separate;
			border: 4px solid #fff;  
			background: #fff;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 20px auto;
			-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		thead {
			-moz-border-radius: 8px;
			-webkit-border-radius: 8px;
			border-radius: 8px;
		}

		thead td {
			font-family: "Open Sans", sans-serif;
			font-size: 23px;
			font-weight: 400;
			color: #fff;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-align: left;
			padding: 20px;
			background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
			background-size: 100%;
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #005d8f), color-stop(100%, #4a5564));
			background-image: -moz-linear-gradient(#005d8f, #004266);
			background-image: -webkit-linear-gradient(#005d8f, #004266);
			background-image: linear-gradient(#005d8f, #004266);
			border-top: 1px solid #005d8f;
		}
		thead th:first-child {
			-moz-border-radius-topleft: 8px;
			-webkit-border-top-left-radius: 8px;
			border-top-left-radius: 8px;
		}
		thead th:last-child {
			-moz-border-radius-topright: 8px;
			-webkit-border-top-right-radius: 8px;
			border-top-right-radius: 8px;
		}

		tbody tr td {
			font-family: "Open Sans", sans-serif;
			font-weight: 400;
			color: #5f6062;
			font-size: 16px;
			padding: 20px 20px 20px 20px;
			border-bottom: 1px solid #e0e0e0;
		}

		tbody tr:nth-child(2n) {
			background: #e6f2f5;
		}

		tbody tr:last-child td {
			border-bottom: none;
		}
		tbody tr:last-child td:first-child {
			-moz-border-radius-bottomleft: 8px;
			-webkit-border-bottom-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}
		tbody tr:last-child td:last-child {
			-moz-border-radius-bottomright: 8px;
			-webkit-border-bottom-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		tbody:hover > tr td {
			filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
			opacity: 0.5;
			/* uncomment for blur effect */
			/* color:transparent;
			@include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
		}

		tbody:hover > tr:hover td {
			text-shadow: none;
			color: #2d2d2d;
			filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
			opacity: 1;
		}

		</style>
		</head>
		<body>
		<div class="container">
		<div class="col-sm-7">
            <img src="https://qvaluation.com/assets/img/Qval-logo_1024x500.png" class="img-fluid" alt="">
		</div>
		<center><div class="col-sm-7">
		<div class="col-sm-12">
		<center><br><h3>¡Bienvenido a Qvaluation!</h3></center>
        </div>
        <center>
            <h4 class="text-center" style="color:#878788">La herramienta con la que podrás medir y gestionar cualquier variable o interrogante de negocio a tiempo real.</h4>
        </center>
        <div class="col-sm-12"><center><a href="https://qvaluation.com/activarcuenta/'.$Token.'" >
            <button type="button" >ACTIVA TU CUENTA</button>
        </a><br><br>
        </div>
		
        <center>
                <h5 style="font-weight: bold;color:#878788; text-align: center;"> Haga clic en el botón</h5>
        </center>

		</div>
		<div class="col-sm-12" style="margin-top:40px">
                <h4 style="color:#878788">Usuario: '.$_Usuario.'</h4>
                <h4 style="color:#878788">Contraseña: '.$_Clave.'</h4>
        </div> 
		<div class="col-sm-12">
                <h5 style="color:#878788">Dentro de qvaluation.com podrás cambiar tu contraseña en cualquier momento.</h5>
        </div>
        <div class="col-sm-12">
                <h5 style="color:#878788">Tu pago en qvalution.com ha sido procesado correctamente</h5>
        </div>
        <div class="col-sm-12">
                <h5 style="color:#878788">Has contratado el paquete:</h5>
        </div>
        <div class="col-sm-12">
                <h4 style="color:#e96610">Empresarial Mensual de 3.000 MXN + IVA </h4>
        </div>
        <div class="col-sm-12" style="color:#878788">
               Una vez vencido tendrá que volver a pagar para acceder a la herramienta. Si requiere una factura por favor solicítela en facturacion@qvaluation.com
        </div>
        <p>
            <small style="color:#878788">Gracias por elegir Qvaluation.</small>
        </p>
		<p>Saludos,<br> 
        <font color="#005288" style="font-weight: bold;">Equipo qvaluation</font></p> 
        <div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >The most important thing for a young man is to establish credit - a reputation and character”... <br><font style="font-weight: bold;">John D. Rockefeller</font></font></p></div>
        <p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
        
		</div></center></div>
		</body>
		</html>';
		
		$this->email->message($body);
		return $this->email->send();
	}
	// cooreo para notificar al usuario que se ha dado de baja ese usuario
	public function down_user($_Correo_envio){
		$this->email->to($_Correo_envio);
		$this->email->subject("Baja de Usuario qvaluation");
		$body  = 
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
        .img-fluid{width: 250px;}
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
		button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
		h4{text-align: justify;}h5{text-align: justify;}
		table {
			border-collapse: separate;
			border: 4px solid #fff;  
			background: #fff;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 20px auto;
			-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		thead {
			-moz-border-radius: 8px;
			-webkit-border-radius: 8px;
			border-radius: 8px;
		}

		thead td {
			font-family: "Open Sans", sans-serif;
			font-size: 23px;
			font-weight: 400;
			color: #fff;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-align: left;
			padding: 20px;
			background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
			background-size: 100%;
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #005d8f), color-stop(100%, #4a5564));
			background-image: -moz-linear-gradient(#005d8f, #004266);
			background-image: -webkit-linear-gradient(#005d8f, #004266);
			background-image: linear-gradient(#005d8f, #004266);
			border-top: 1px solid #005d8f;
		}
		thead th:first-child {
			-moz-border-radius-topleft: 8px;
			-webkit-border-top-left-radius: 8px;
			border-top-left-radius: 8px;
		}
		thead th:last-child {
			-moz-border-radius-topright: 8px;
			-webkit-border-top-right-radius: 8px;
			border-top-right-radius: 8px;
		}

		tbody tr td {
			font-family: "Open Sans", sans-serif;
			font-weight: 400;
			color: #5f6062;
			font-size: 16px;
			padding: 20px 20px 20px 20px;
			border-bottom: 1px solid #e0e0e0;
		}

		tbody tr:nth-child(2n) {
			background: #e6f2f5;
		}

		tbody tr:last-child td {
			border-bottom: none;
		}
		tbody tr:last-child td:first-child {
			-moz-border-radius-bottomleft: 8px;
			-webkit-border-bottom-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}
		tbody tr:last-child td:last-child {
			-moz-border-radius-bottomright: 8px;
			-webkit-border-bottom-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		tbody:hover > tr td {
			filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
			opacity: 0.5;
			/* uncomment for blur effect */
			/* color:transparent;
			@include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
		}

		tbody:hover > tr:hover td {
			text-shadow: none;
			color: #2d2d2d;
			filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
			opacity: 1;
		}

		</style>
		</head>
		<body>
		<div class="container">
		<div class="col-sm-7">
            <img src="https://qvaluation.com/assets/img/Qval-logo_1024x500.png" class="img-fluid" alt="">
		</div>
		<center>
		<div class="col-sm-12">
		<center>
            <h3>¡Baja del sistema qvaluation.com.!</h3>
        </center>
        </div>
        <center style="color:#878788">
            Usted ha sido dado de baja del sistema qvaluation.com.
        </center>
        		
		 
		<div class="col-sm-12">
                <h5 style="color:#878788">Si cree que le han dado de baja de forma indebida por favor ponerse en contacto con nosotros.</h5>
        </div>
        
        <p>
            <small style="color:#878788">Gracias por elegir Qvaluation.</small>
        </p>
		<p>Saludos,<br> 
        <font color="#005288" style="font-weight: bold;">Equipo qvaluation</font></p> 
        <div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >The most important thing for a young man is to establish credit - a reputation and character”... <br><font style="font-weight: bold;">John D. Rockefeller</font></font></p></div>
        <p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
        
		</div></center></div>
		</body>
		</html>';
		$this->email->message($body);
		return $this->email->send();
	}
	//funcion para notificar al usuario que dio de baja a ese usuario
	public function down_user_notification($_Correo_envio, $_Nombre,$_Apellidos){
		$this->email->to($_Correo_envio);
		$this->email->subject("Baja de Usuario qvaluation");
		$body =
		'<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
		@import url(http://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
        .img-fluid{width: 250px;}
		body{font-family: "arial";}p{text-align: justify;font-size: 11pt;color: #878788;}
		.container {margin-right: auto;margin-left: auto; width: 100%;}.col-sm-7 {width: 90%;}.img-responsive{display: block;max-width: 100%;height: auto;}
		h3{font-size: 18pt;color: #005288;font-style: italic;font-weight: bold;}
		button{border-radius: 10px;border: 2px solid #e96610;padding: 15px 75px;cursor:pointer;background-color:#e96610;color: #ffffff;}
		h4{text-align: justify;}h5{text-align: justify;}
		table {
			border-collapse: separate;
			border: 4px solid #fff;  
			background: #fff;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 20px auto;
			-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}

		thead {
			-moz-border-radius: 8px;
			-webkit-border-radius: 8px;
			border-radius: 8px;
		}

		thead td {
			font-family: "Open Sans", sans-serif;
			font-size: 23px;
			font-weight: 400;
			color: #fff;
			text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
			text-align: left;
			padding: 20px;
			background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
			background-size: 100%;
			background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #005d8f), color-stop(100%, #4a5564));
			background-image: -moz-linear-gradient(#005d8f, #004266);
			background-image: -webkit-linear-gradient(#005d8f, #004266);
			background-image: linear-gradient(#005d8f, #004266);
			border-top: 1px solid #005d8f;
		}
		thead th:first-child {
			-moz-border-radius-topleft: 8px;
			-webkit-border-top-left-radius: 8px;
			border-top-left-radius: 8px;
		}
		thead th:last-child {
			-moz-border-radius-topright: 8px;
			-webkit-border-top-right-radius: 8px;
			border-top-right-radius: 8px;
		}

		tbody tr td {
			font-family: "Open Sans", sans-serif;
			font-weight: 400;
			color: #5f6062;
			font-size: 16px;
			padding: 20px 20px 20px 20px;
			border-bottom: 1px solid #e0e0e0;
		}

		tbody tr:nth-child(2n) {
			background: #e6f2f5;
		}

		tbody tr:last-child td {
			border-bottom: none;
		}
		tbody tr:last-child td:first-child {
			-moz-border-radius-bottomleft: 8px;
			-webkit-border-bottom-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}
		tbody tr:last-child td:last-child {
			-moz-border-radius-bottomright: 8px;
			-webkit-border-bottom-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		tbody:hover > tr td {
			filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
			opacity: 0.5;
			/* uncomment for blur effect */
			/* color:transparent;
			@include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
		}

		tbody:hover > tr:hover td {
			text-shadow: none;
			color: #2d2d2d;
			filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
			opacity: 1;
		}

		</style>
		</head>
		<body>
		<div class="container">
		<div class="col-sm-7">
            <img src="https://qvaluation.com/assets/img/Qval-logo_1024x500.png" class="img-fluid" alt="">
		</div>
		<center>
		<div class="col-sm-12">
		<center>
            <h3>¡Baja del sistema qvaluation.com.!</h3>
        </center>
        </div>
        <center style="color:#878788">
                Ha solicitado una baja de usuario del sistema.
        </center>
        		
		 
		<div class="col-sm-12">
                <h5 style="color:#878788">El siguiente usuario ya no podrá acceder más al sistema:</h5>
        </div>
        <div class="col-sm-12">
                <h5 ><span style="font-weight: bold;color:#878788"> '.$_Nombre.' '.$_Apellidos.'</span></h5>
        </div>
        <p>
            <small style="color:#878788">Gracias por elegir Qvaluation.</small>
        </p>
		<p>Saludos,<br> 
        <font color="#005288" style="font-weight: bold;">Equipo qvaluation</font></p> 
        <div class="col-sm-12" style="border-width: 1px; border-style: dashed; border-color: #fcb034; "></div>
		<div class="col-sm-12"><br><p><font color="#cc9829" >The most important thing for a young man is to establish credit - a reputation and character”... <br><font style="font-weight: bold;">John D. Rockefeller</font></font></p></div>
        <p><small class="color:#777">Ha recibido este email por que se ha suscrito en qvaluation.com </small></p>
						<p><small class="color:#777">infoadmyo S.A. de C.V. es una empresa legalmente constituida en México con RFC IAD120302T35 y es propietaria de la marca admyo y sus logos. Si tiene cualquier duda puede contactar con nosotros al email atencioncliente@admyo.com. Todas nuestras condiciones de uso y privacidad las puede encontrar en el <a href="">siguiente enlace</a>
							</small></p>
        
		</div></center></div>
		</body>
		</html>';
		$this->email->message($body);
		return $this->email->send();
		
	} 
	

	

	
	
}