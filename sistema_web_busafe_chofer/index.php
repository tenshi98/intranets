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

//Carga de los componentes de los formularios
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.FormInputs.php';
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Inputs.php';
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Widgets.php';

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
//formulario para iniciar sesion
if ( !empty($_POST['submit_login']) )  { 
	$form_trabajo= 'login';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado.php';
}
//formulario para recuperar la contraseña
if ( !empty($_POST['submit_pass']) )  { 
	$form_trabajo= 'getpass';
	require_once 'A1XRXS_sys/xrxs_form/transportes_listado.php';
}
/**********************************************************************************************************************************/
/*                                                     Armado del form                                                            */
/**********************************************************************************************************************************/
//Elimino los datos previos del form
unset($_SESSION['form_require']);
//se carga dato previo
$_SESSION['form_require'] = 'required';
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
		<title>Login</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">
		
		<!-- WEB FONT -->
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_73.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bs3.form.input.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/bs3.form.border.css">
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
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.js"></script>
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
			.register-heading {margin-top: 0;}
			.login {background-color: #414745;background-image: url("img/Fondo.jpg");background-size: 100%;}
		</style>
	</head>
	<body class="login">
<?php 
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Despliegue de errores
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Chofer Creado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}

/**********************************************************************************************************************************/
/*                                                   Verificacion bloqueos                                                        */
/**********************************************************************************************************************************/
//calculos
$bloqueo=0;
//reviso si se conecta desde chile
$INT_IP   = obtenerIpCliente();
$INT_Pais = obtenerInfoIp($INT_IP, "countryName");

//Se consultan los datos
$Mantenciones = db_select_data (false, 'Fecha, Hora_ini, Hora_fin', 'core_mantenciones', '', "idMantencion!=0 ORDER BY idMantencion DESC", $dbConn, 'login', basename($_SERVER["REQUEST_URI"], ".php"), 'Mantenciones');
$ip_bloqueada = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$INT_IP."'", $dbConn, 'login', basename($_SERVER["REQUEST_URI"], ".php"), 'ip_bloqueada');

//Se crean los bloqueos
if(strtotime($Mantenciones['Fecha'])>=strtotime(fecha_actual())&&strtotime($Mantenciones['Hora_ini'])<=strtotime(hora_actual())&&strtotime($Mantenciones['Hora_fin'])>=strtotime(hora_actual())&&$bloqueo==0){ $bloqueo=1;}
if(isset($INT_Pais)&&$INT_Pais!=''&&$INT_Pais!='Chile'&&$INT_IP!='::1'&&$bloqueo==0){  $bloqueo = 2;}
if(isset($ip_bloqueada)&&$ip_bloqueada!=0&&$bloqueo==0){ $bloqueo = 3;}
	
/**********************************************************************************************************************************/
/*                                                        Despliegue                                                              */
/**********************************************************************************************************************************/
//se selecciona la pantalla a mostrar
switch ($bloqueo) {
    //pantalla normal
    case 0:
        require_once '1include_login_form.php';
        break;
	//pantalla de mantenimiento
    case 1:
        require_once '1include_login_ani.php';
        break;
    //pantalla de bloqueo pais
    case 2:
        require_once '1include_login_block.php';
        //se entregan datos
        $sesion_archivo  = 'index.php';
		$sesion_tarea    = 'login-form';
        //se valida hackeo
		require_once 'A1XRXS_sys/xrxs_form/0_hacking_1.php';
        break;
    //pantalla de baneo
    case 3:
        require_once '1include_login_banned.php';
        break;
}
//validador
widget_validator(); ?>

  </body>
</html>
