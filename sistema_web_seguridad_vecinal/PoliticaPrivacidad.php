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
		<title>Termino y condiciones</title>
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
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/css/bootstrap-material-datetimepicker.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker.min.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/css/bootstrap-colorpicker-plus.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/css/fileinput.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.css" media="all" >
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/css/bootstrap-select.min.css">
		
		<!-- Javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/main.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/form_functions.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/rut_validate/jquery.rut.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_touchspin/src/jquery.bootstrap-touchspin.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/material_datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/clock_timepicker/dist/bootstrap-clockpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker-plus.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/autosize/dist/autosize.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/plugins/sortable.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/fileinput.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/js/locales/es.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_fileinput/themes/explorer/theme.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/chosen/chosen.jquery.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/bootstrap-select.min.js"></script>
		
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
			body {color: #666;background-color: #efefef;}
			.site-content {margin-top: 25px;margin-bottom: 25px;}
			.site-main .content-area {padding: 2em;position: relative;background-color: #fff;}
			.site-main .content-area {white-space: initial;}
			 li {list-style-image: inherit!important;list-style-type: inherit!important;}
		</style>
	</head>

	<body>
		
		<div class="container">
			<div id="content" class="content-lift site-content">
				<div class="row">
					<div id="primary" class="col-sm-12">
						<main id="blog" class="site-main blog-main" role="blog">
							<article id="post-44364" class="post-44364 page type-page status-publish hentry">	
								<div class="content-area">
									<header class="entry-header">
										<h1 class="entry-title">Terminos &amp; Condiciones</h1>
									</header>
									
									<div class="entry-content">
										<p>El solo uso de este sistema constituye la aceptación de todas las condiciones 
										que se enumeran a continuación.</p>
										
										<p>Vecino seguro mantiene este sitio Web (de ahora en adelante "La Plataforma") 
										como expresión de cortesía hacia quienes decidan acceder a él (de ahora en adelante "Usuarios"). 
										La informacion compartida para los Usuarios que visiten el Sitio (de ahora en adelante 
										"Materiales") puede ser leida, descargada, copiada, redistribuida, o crear otros trabajos 
										a partir de los mismos.</p>
										
										<p>La presente Terminos y Condiciones establece los términos en que usa y protege la 
										información que es proporcionada por sus Usuarios al momento de utilizar La Plataforma. 
										Cuando le pedimos llenar los campos de información personal con la cual el Usuario 
										es identificado, lo hacemos asegurando que sólo se empleará de acuerdo con 
										los términos y condiciones de este documento. Sin embargo este Terminos y Condiciones puede 
										cambiar con el tiempo o ser actualizado por lo que le recomendamos y enfatizamos 
										revisar continuamente La Plataforma para asegurarse que está de acuerdo con dichos 
										cambios.</p>
										
										<h3>Información que es recogida</h3>
										<p>La plataforma podrá recoger información personal por ejemplo: Nombre,  
										información de contacto como  su dirección de correo electrónica e información 
										demográfica. Así mismo cuando sea necesario podrá ser requerida información 
										específica para procesar informacion en un formulario o transaccion en la plataforma.</p>
										
										<h3>Uso de la información recogida</h3>
										<p>La plataforma emplea la información con el fin de proporcionar el mejor 
										servicio posible, particularmente para mantener un registro de usuarios, de 
										sus interacciones con otros usuarios, sus aportes y comentarios.<br/>  
										Es posible que sean enviados correos electrónicos periódicamente a través 
										de la plataforma con información que consideremos relevante para el usuario 
										o que pueda brindarle algún beneficio, estos correos electrónicos serán 
										enviados a la dirección que el usuario proporcione.</p>
										
										<h3>Cookies</h3>
										<p>La plataforma no hace uso de Cookies</p>
										
										<h3>Enlaces a Terceros</h3>
										<p>La plataforma puede contener enlaces a otros sitios que pudieran ser del 
										interés de los usuaros. Una vez que el usuario de clic en estos enlaces y 
										abandone nuestra página, ya no tenemos control sobre al sitio al que es 
										redirigido y por lo tanto no somos responsables de los términos o privacidad 
										ni de la protección de sus datos en esos otros sitios terceros. 
										Dichos sitios están sujetos a sus propias políticas de privacidad por lo 
										cual es recomendable que los consulte para confirmar que usted está de acuerdo 
										con estas.</p>
										
										<h3>Control de su información personal</h3>
										<p>En cualquier momento el usuario puede restringir la recopilación o el uso de 
										la información personal que es proporcionada a la plataforma, asi como tambien 
										la posibilidad de que otros usuarios vean sus datos.</p>
										
										<h3>Funcionalidad</h3>
										<p>La plataforma estara en constante actualizacion, por lo que puede que algunas 
										opciones de esta se modifique, actualice, se mueva o se elimine de acuerdo a las
										necesidades del desarrollador.</p>
										
										<h3>Acceso</h3>
										<p>Este sitio está optimizado para los siguientes navegadores: Chrome y Firefox en 
										todas sus versiones, y se ofrece una visualización correcta en Internet Explorer 
										a partir de la versión 8.</p>
										
										<h3>Conducta del Usuario</h3>
										<p>El Usuario esta obligado a mantener una buena conducta, dicha conducta se 
										considerara como sana mientras no:</p>
										<ul>
											<li>Restrinja o inhiba a cualquier otro Usuario de usar y disfrutar de La Plataforma o de 
											los servicios de La Plataforma.</li>
											<li>Sea fraudulento, ilegal, amenazante, abusivo, hostigante, calumnioso, difamatorio, 
											obsceno, vulgar, ofensivo, pornográfico, profano, sexualmente explícito o indecente.</li>
											<li>Constituya o aliente conductas que pudieran constituir una ofensa criminal, 
											dar lugar a responsabilidad civil o de otro modo violar cualquier ley local, estatal, 
											nacional o internacional.</li>
											<li>Viole, plagie o infrinja los derechos de terceros incluyendo, sin limitación, 
											derechos de autor, marcas comerciales, secretos comerciales, confidencialidad, 
											contratos, patentes, derechos de privacidad o publicidad o cualquier otro derecho 
											de propiedad.</li>
											<li>Contenga un virus, elemento de espionaje u otro componente dañino en los archivos 
											que se suben a La Plataforma.</li>
											<li>Contenga enlaces fijos, publicidad, cartas de cadenas o esquemas de pirámides de 
											cualquier tipo.</li>
											<li>Constituya o contenga indicaciones de origen, endosos o declaraciones de hechos 
											falsos o engañosos. El Usuario además se obliga a no personificar a cualquier otra persona 
											o entidad, ya sea real o ficticia, incluyendo cualquier persona o Usuario dentro de La 
											Plataforma, tampoco puede ofrecer comprar o vender algún producto o servicio en o a través 
											de sus comentarios presentados en los comentarios o publicaciones. El Usuario es responsable 
											del contenido y de las consecuencias de cualquiera de sus actividades.</li>
										</ul>
										
										
										<h3>Prohibiciones al Usuario</h3>
										<p>El Usuario garantiza y está de acuerdo en que, mientras use La Plataforma y los 
										diversos servicios y artículos que se ofrecen en o a través de la misma, no:</p>
										<ul>
											<li>Intentará ganar acceso no autorizado a La plataforma.</li>
											<li>Obtendrá o intentará obtener acceso no autorizado a los sistemas de cómputo, materiales 
											o información por cualquier medio.</li>
											<li>Personificara a ninguna persona o entidad ni desvirtuará su afiliación con alguna otra 
											persona o entidad.</li>
											<li>Insertará su propio anuncio, posicionamiento de marca o algún otro contenido promocional 
											o el de un tercero  en cualquiera de los contenidos, materiales o servicios o materiales de 
											La Plataforma (por ejemplo, un enlace, una actualización RSS, un programa de radio 
											grabado (podcast), un canal de youtube, un perfil de Facebook, etc.), ni usará, redistribuirá, 
											republicará o explotará dichos contenidos o servicios con cualquier otro propósito adicional 
											comercial o promocional</li>
											<li>Participará en navegar por la red, en “raspar (scraping) la pantalla”, “raspar (scraping) 
											la base da datos”, en recolectar direcciones de correo electrónico, direcciones inalámbricas 
											u otra información personal o de contactos, o cualquier otro medio automático de obtener 
											listas de usuarios u otra información de o a través de La Plataforma o de los servicios ofrecidos 
											en o a través de La Plataforma, incluyendo, sin limitación, cualquier información que se encuentre 
											en algún servidor o base de datos relacionada con La Plataforma o los servicios ofrecidos en 
											o a través de La Plataforma</li>
											<li>Usará La Plataforma o los servicios puestos a su disposición en o a través de La Plataforma 
											de alguna manera con la intención de interrumpir, dañar, deshabilitar, sobrecargar o deteriorar 
											La Plataforma o dichos servicios, incluyendo, sin limitación, mandar mensajes masivos no 
											solicitados o “inundar” servidores con solicitudes</li>
											<li>Usará La Plataforma o los servicios o artículos de La Plataforma en violación de la propiedad 
											intelectual o de otros derechos legales o patrimoniales de La Plataforma o de algún tercero</li>
											<li>Usará La Plataforma o los servicios de La Plataforma en violación de cualquier ley aplicable. 
											El Usuario se obliga además, a no intentar (o alentar o apoyar el intento de otro) a embaucar, 
											destruir, decodificar, o de otro modo alterar o interferir con La Plataforma o con los 
											servicios de La Plataforma, o con cualquier contenido del mismo, o hacer cualquier uso no 
											autorizado del mismo. El Usuario se obliga a no usar La Plataforma de alguna manera que pudiera 
											dañar, deshabilitar, sobrecargar o deteriorar La Plataforma o interferir con que cualquier 
											otra persona pueda usar o disfrutar de La Plataforma o de cualquiera de sus servicios. 
											El Usuario no obtendrá ni intentará obtener algún material o información a través de cualquier 
											medio que no haya sido estipulado o puesto a la disposición del público intencionalmente a 
											través de La Plataforma.</li>
											<li>Tratar de acceder a traves de Web Proxy o VPN para ocultar la identidad del Usuario, asi 
											como tambien sus datos de conexion</li>
											
										</ul>
										
										<h3>Baneos al Usuario</h3>
										<p>En caso de incumplir cualquiera de las normas de conducta y prohibiciones al Usuario, La Plataforma
										se guarda el derecho de banear permanentemente a dicho Usuario</p>
										
										<h3>Minorias Sexuales</h3>
										<p>En la plataforma <strong>NO SE ACEPTAN IDEAS NI OPINIONES UNILATERALES DE LAS MINORIAS SEXUALES</strong>, 
										cualquier infraccion a este punto sera motivo de baneo permanente.</p>
										
										<h3>Vecino Seguro</h3>
										<p>Se reserva el derecho de cambiar los términos de la presente Política de Privacidad en cualquier momento.</p>
										
									</div>
								</div>
							</article>
						</main>
					</div>
				</div>
			</div>
		</div>

	</body>

</html>
