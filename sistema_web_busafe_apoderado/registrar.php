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
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                  //Configuracion de la plataforma
require_once '../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';         //carga librerias de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.FormInputs.Extended.php'; //carga formularios de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Inputs.Extended.php';     //carga inputs de la plataforma
require_once '../Legacy/gestion_modular/funciones/Components.UI.Widgets.Extended.php';    //carga widgets de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                               Se cargan los formularios                                                        */
/**********************************************************************************************************************************/
//formulario para recuperar la contrase??a
if ( !empty($_POST['submit_register']) )  { 
	$location = "index.php";
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
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
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		
		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_<?php if(isset($_SESSION['usuario']['basic_data']['Config_idTheme'])&&$_SESSION['usuario']['basic_data']['Config_idTheme']!=''){echo $_SESSION['usuario']['basic_data']['Config_idTheme'];}else{echo '1';} ?>.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/elegant_font/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker-plus.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/chosen/chosen.css">

		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/plotly_js/dist/plotly-locale-es-ar.js"></script>
		
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
			.formbox {background-color: #ffffff;border-radius: 3px;}
			.register-heading {margin-top: 0;}
			.inner {background-color: #F3C500;background-image: url("img/Fondo.jpg");background-size: 100%;}
		</style>
	</head>
	<body class="">

		
		
		<?php 
		
		/***********************************************/
		//Elimino los datos previos del form
		unset($_SESSION['form_require']);
		//se carga dato previo
		$_SESSION['form_require'] = 'required';
		if(isset($error)&&$error!=''){echo notifications_list($error);} ?>

		<div class="inner">
			<div class="col-md-6 fcenter clearfix">
				<div class="">
					
					<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
					<h3 class="register-heading">??Reg??strate como Apoderado!</h3>

					<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
						<div class="formbox col-md-12">
							<?php
							//Se verifican si existen los datos
							if(isset($Nombre)) {           $x1  = $Nombre;            }else{$x1  = '';}
							if(isset($ApellidoPat)) {      $x2  = $ApellidoPat;       }else{$x2  = '';}
							if(isset($Rut)) {              $x3  = $Rut;               }else{$x3  = '';}
							if(isset($email)) {            $x4  = $email;             }else{$x4  = '';}
							if(isset($Fono1)) {            $x5  = $Fono1;             }else{$x5  = '';}
							if(isset($idCiudad)) {         $x6  = $idCiudad;          }else{$x6  = '';}
							if(isset($idComuna)) {         $x7  = $idComuna;          }else{$x7  = '';}
							if(isset($Direccion)) {        $x8  = $Direccion;         }else{$x8  = '';}
							
							//se dibujan los inputs
							$Form_Inputs = new Inputs();
							$Form_Inputs->input_hidden('idEstado', 1, 2);
							$Form_Inputs->input_hidden('FNacimiento', fecha_actual(), 2);
							$Form_Inputs->input_hidden('idSistema', 1, 2);
							$Form_Inputs->input_hidden('idOpciones_1', 1, 2);
							$Form_Inputs->input_hidden('idOpciones_2', 1, 2);
							$Form_Inputs->input_hidden('F_Inicio_Contrato', fecha_actual(), 2);
							
							?>
							
							<br/>
							<?php $Form_Inputs->form_post_data(1, 'La Contrase??a sera enviada por correo'); ?>
							<div class="row register-form">
								<div class="col-md-12">
									<h4>Datos Apoderado</h4>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input('text', 'Nombre', 'Nombre', $x1, 2); ?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input('text', 'Apellido Paterno', 'ApellidoPat', $x2, 2); ?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input_rut('Rut', 'Rut', $x3, 2);?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input_icon('text', 'Email', 'email', $x4, 2,'fa fa-envelope-o');?>
									</div>
									<div class="form-group">
										<?php $Form_Inputs->input_phone('Telefono Fijo', 'Fono1', $x5, 1);?>
									</div>
								</div>
								
								<div class="col-md-12">
									<h4>Direccion Hijo</h4>
								</div>
								<div class="col-md-6">
									<?php $Form_Inputs->select_depend1('Ciudad','idCiudad', $x6, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
										'Comuna','idComuna', $x7, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
										 $dbConn, 'form1');?>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php $Form_Inputs->input_icon('text', 'Direccion', 'Direccion', $x8, 2,'fa fa-map');	?>
									</div>
								</div>
								
								<div class="col-md-12">
									<h4>Terminos y condiciones</h4>
									<div class="form-group">
										<?php $Form_Inputs->terms_and_conditions('Terminos', 'He leido los', 'PoliticaPrivacidad.htm', 'Terminos y Condiciones', 'submit_register');	?>
									</div>
								</div>
								
								
									
							</div>
						</div>
						
						<div class="col-md-12">
							<br/>
							<div class="text-center">
								<input type="submit" class="btn btn-primary fa-input" value="&#xf0c7; Registrarse" name="submit_register" id="submit_register">
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
