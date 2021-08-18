<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                                          Seguridad                                                             */
/**********************************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_seguridad/AntiXSS.php';
require_once '../A2XRXS_gears/xrxs_seguridad/Bootup.php';
require_once '../A2XRXS_gears/xrxs_seguridad/UTF8.php';
$security = new AntiXSS();
$_POST = $security->xss_clean($_POST);
$_GET  = $security->xss_clean($_GET);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
//Configuracion de la plataforma
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';

//Carga de las funciones del nucleo
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Utils.Load.php';                  //Carga de variables
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Common.php';            //Funciones comunes
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Convertions.php';       //Conversiones de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Date.php';         //Funciones relacionadas a las fechas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Numbers.php';      //Funciones relacionadas a los numeros
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Operations.php';   //Funciones relacionadas a operaciones matematicas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Text.php';         //Funciones relacionadas a los textos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Time.php';         //Funciones relacionadas a las horas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Validations.php';  //Funciones de validacion de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.DataBase.php';          //Funciones relacionadas a la base de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Location.php';          //Funciones relacionadas a la geolozalizacion
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Client.php';     //Funciones para entregar informacion del cliente
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Server.php';     //Funciones para entregar informacion del servidor
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Web.php';        //Funciones para entregar informacion de la web

//carga librerias propias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';
require_once '../Legacy/gestion_modular/funciones/Components.UI.FormInputs.Extended.php';
require_once '../Legacy/gestion_modular/funciones/Components.UI.Inputs.Extended.php';
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';

// obtengo puntero de conexion con la db
$dbConn = conectar();
/**********************************************************************************************************************************/
/*                                               Se cargan los formularios                                                        */
/**********************************************************************************************************************************/
//formulario para recuperar la contraseña
if ( !empty($_POST['submit_register']) )  { 
	$location = "index.php";
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_clientes_listado.php';
}
?>
<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">
		
		<!-- Informacion del sitio-->
		<title>Registro</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">
		
		<!-- WEB FONT -->
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_1.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css">
		
		<!-- Javascript -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/html5shiv/html5shiv.js"></script>
			<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/respond/respond.min.js"></script>
			<![endif]-->
		<!--Modulos de javascript-->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/personel.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/modernizr/modernizr.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		
		<!-- Favicons-->
		<?php
		//Favicon Personalizado
		$nombre_fichero = 'img/mifavicon.png';
		if (file_exists($nombre_fichero)) { ?>
			<link rel="icon"             type="image/png"                    href="img/mifavicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="img/mifavicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="img/mifavicon-57x57.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="img/mifavicon-72x72.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/mifavicon-114x114.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/mifavicon-144x144.png">
		<?php 
		//Favicon predefinido	
		}else{ ?>
			<link rel="icon"             type="image/png"                    href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
			<link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-57x57-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-72x72-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-114x114-precomposed.png">
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-144x144-precomposed.png">
		<?php } ?>
		
		<!-- Correcciones CSS -->
		<style>
			.form-horizontal .form-group {margin-left: 0px;margin-right: 0px;}
			.formbox {background-color: #ffffff;border-radius: 3px; margin-bottom:25px;padding-top:5px;}
			.register-heading {margin-top: 0;}
			.login {background-color: #191d1e;background-image: none;background-size: 100%;}
			html, body{
				width:100%; 
				height:100%; 
				padding:0px; 
				margin:0px;
				/*overflow: hidden;*/
				background: #191d1e; /* Old browsers */
				background: -moz-linear-gradient(0deg,  #191d1e 50%, #283139 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, right bottom, color-stop(50%,#191d1e), color-stop(100%,#283139)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* IE10+ */
				background: linear-gradient(0deg,  #191d1e 50%,#283139 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#191d1e', endColorstr='#283139',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
				background-attachment: fixed
			}
			#projector {position: absolute; top: 0px;left: 0px;width:100%;height:100%;} 
			.center-div {width:580px;height:374px;position:absolute;left:50%;top:50%;margin-left: -290px;margin-top:  -187px;}
			#preloaderDiv{position:absolute;left:50%;top:50%;margin-left: -27px;margin-top:  -27px;}
			#logo{opacity:0;filter: alpha(opacity=0);}
			#date2014{position:absolute;padding-left: 210px;padding-top:15px;opacity:0;top:303px;left:0;filter: alpha(opacity=0);}		
		</style>
	</head>
	<body class="login">
		<!-- partial:index.partial.html -->
		<canvas id="projector">Your browser does not support the Canvas element.</canvas>
		<!-- partial -->
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/easeljs-0.7.1.min.js"></script>
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/TweenMax.min.js"></script>
		<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/ambient-background/js/script.js"></script>
		
		
		<?php 
		
		/***********************************************/
		//Elimino los datos previos del form
		unset($_SESSION['form_require']);
		//se carga dato previo
		$_SESSION['form_require'] = 'required';
		if(isset($error)&&$error!=''){echo notifications_list($error);} ?>

		<div class="">
			<div class="formbox col-md-6 fcenter clearfix">
				<div class="">
					
					<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
					<h3 class="register-heading">¡Regístrate!</h3>

					<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
						<div class="col-md-12">
							<?php
							//Se verifican si existen los datos
							if(isset($Nombre)) {           $x1  = $Nombre;            }else{$x1  = '';}
							if(isset($Rut)) {              $x2  = $Rut;               }else{$x2  = '';}
							if(isset($password)) {         $x3  = $password;          }else{$x3  = '';}
							if(isset($email)) {            $x4  = $email;             }else{$x4  = '';}
							if(isset($Fono1)) {            $x5  = $Fono1;             }else{$x5  = '';}
							if(isset($idCiudad)) {         $x6  = $idCiudad;          }else{$x6  = '';}
							if(isset($idComuna)) {         $x7  = $idComuna;          }else{$x7  = '';}
							if(isset($Direccion)) {        $x8  = $Direccion;         }else{$x8  = '';}
							
							//se dibujan los inputs
							$Form_Inputs = new Inputs();
							$Form_Inputs->input_hidden('idTipo', 2, 2);
							$Form_Inputs->input_hidden('fNacimiento', fecha_actual(), 2);
							$Form_Inputs->input_hidden('Giro', 'Ninguno', 2);
							$Form_Inputs->input_hidden('idSistema', simpleEncode(1, fecha_actual()), 2);
							$Form_Inputs->input_hidden('idEstado', 1, 2);
							$Form_Inputs->input_hidden('idCompartir', 2, 2);
							$Form_Inputs->input_hidden('idVerificado', 1, 2);
							
							?>
							
							<br/>
							<?php $Form_Inputs->form_post_data(1, 'Los datos de registro seran enviados por correo'); ?>
							<div class="row register-form">
								<div class="col-md-12">
									<h4>Datos Personales</h4>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input('text', 'Nombre Completo', 'Nombre', $x1, 2); ?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input_rut('Rut', 'Rut', $x2, 2);?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input_icon('text', 'Contraseña', 'password', $x3, 2,'fa fa-key');?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input_icon('text', 'Email', 'email', $x4, 2,'fa fa-envelope-o');?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input_phone('Telefono', 'Fono1', $x5, 1);?>
									</div>
								</div>
								
								<div class="col-md-12">
									<h4>Direccion</h4>
								</div>
								<div class="col-md-6">
									<?php $Form_Inputs->select_depend1('Ciudad','idCiudad', $x6, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
																	   'Comuna','idComuna', $x7, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
																		$dbConn, 'form1');
									?>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input_icon('text', 'Direccion', 'Direccion', $x8, 2,'fa fa-map');	?>
									</div>
								</div>
								
								<div class="col-md-12">
									<h4>Terminos y condiciones</h4>
									<div class="form-group">
										<?php $Form_Inputs->terms_and_conditions('Terminos', 'He leido los', 'PoliticaPrivacidad.php', 'Terminos y Condiciones', 'submit_register');	?>
									</div>
								</div>
								
								
								<div class="col-md-12">
									<br/>
									<div class="text-center">
										<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
										<input type="submit" class="btn btn-primary fa-input" value="&#xf0c7; Registrarse" name="submit_register" id="submit_register">
									</div>
									<br/>
								</div>
									
							</div>
						</div>
						
						
						
					</form> 
					<?php widget_validator(); ?>
					<?php widget_modal(80, 95); ?>
					
				</div>
			</div>
		</div>
            


	</body>
</html>
