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
										<p>El solo uso de este sistema constituye la aceptaci??n de todas las condiciones 
										que se enumeran a continuaci??n.</p>
										
										<p>Vecino seguro mantiene este sitio Web (de ahora en adelante "La Plataforma") 
										como expresi??n de cortes??a hacia quienes decidan acceder a ??l (de ahora en adelante "Usuarios"). 
										La informacion compartida para los Usuarios que visiten el Sitio (de ahora en adelante 
										"Materiales") puede ser leida, descargada, copiada, redistribuida, o crear otros trabajos 
										a partir de los mismos.</p>
										
										<p>La presente Terminos y Condiciones establece los t??rminos en que usa y protege la 
										informaci??n que es proporcionada por sus Usuarios al momento de utilizar La Plataforma. 
										Cuando le pedimos llenar los campos de informaci??n personal con la cual el Usuario 
										es identificado, lo hacemos asegurando que s??lo se emplear?? de acuerdo con 
										los t??rminos y condiciones de este documento. Sin embargo este Terminos y Condiciones puede 
										cambiar con el tiempo o ser actualizado por lo que le recomendamos y enfatizamos 
										revisar continuamente La Plataforma para asegurarse que est?? de acuerdo con dichos 
										cambios.</p>
										
										<h3>Informaci??n que es recogida</h3>
										<p>La plataforma podr?? recoger informaci??n personal por ejemplo: Nombre,  
										informaci??n de contacto como  su direcci??n de correo electr??nica e informaci??n 
										demogr??fica. As?? mismo cuando sea necesario podr?? ser requerida informaci??n 
										espec??fica para procesar informacion en un formulario o transaccion en la plataforma.</p>
										
										<h3>Uso de la informaci??n recogida</h3>
										<p>La plataforma emplea la informaci??n con el fin de proporcionar el mejor 
										servicio posible, particularmente para mantener un registro de usuarios, de 
										sus interacciones con otros usuarios, sus aportes y comentarios.<br/>  
										Es posible que sean enviados correos electr??nicos peri??dicamente a trav??s 
										de la plataforma con informaci??n que consideremos relevante para el usuario 
										o que pueda brindarle alg??n beneficio, estos correos electr??nicos ser??n 
										enviados a la direcci??n que el usuario proporcione.</p>
										
										<h3>Cookies</h3>
										<p>La plataforma no hace uso de Cookies</p>
										
										<h3>Enlaces a Terceros</h3>
										<p>La plataforma puede contener enlaces a otros sitios que pudieran ser del 
										inter??s de los usuaros. Una vez que el usuario de clic en estos enlaces y 
										abandone nuestra p??gina, ya no tenemos control sobre al sitio al que es 
										redirigido y por lo tanto no somos responsables de los t??rminos o privacidad 
										ni de la protecci??n de sus datos en esos otros sitios terceros. 
										Dichos sitios est??n sujetos a sus propias pol??ticas de privacidad por lo 
										cual es recomendable que los consulte para confirmar que usted est?? de acuerdo 
										con estas.</p>
										
										<h3>Control de su informaci??n personal</h3>
										<p>En cualquier momento el usuario puede restringir la recopilaci??n o el uso de 
										la informaci??n personal que es proporcionada a la plataforma, asi como tambien 
										la posibilidad de que otros usuarios vean sus datos.</p>
										
										<h3>Funcionalidad</h3>
										<p>La plataforma estara en constante actualizacion, por lo que puede que algunas 
										opciones de esta se modifique, actualice, se mueva o se elimine de acuerdo a las
										necesidades del desarrollador.</p>
										
										<h3>Acceso</h3>
										<p>Este sitio est?? optimizado para los siguientes navegadores: Chrome y Firefox en 
										todas sus versiones, y se ofrece una visualizaci??n correcta en Internet Explorer 
										a partir de la versi??n 8.</p>
										
										<h3>Conducta del Usuario</h3>
										<p>El Usuario esta obligado a mantener una buena conducta, dicha conducta se 
										considerara como sana mientras no:</p>
										<ul>
											<li>Restrinja o inhiba a cualquier otro Usuario de usar y disfrutar de La Plataforma o de 
											los servicios de La Plataforma.</li>
											<li>Sea fraudulento, ilegal, amenazante, abusivo, hostigante, calumnioso, difamatorio, 
											obsceno, vulgar, ofensivo, pornogr??fico, profano, sexualmente expl??cito o indecente.</li>
											<li>Constituya o aliente conductas que pudieran constituir una ofensa criminal, 
											dar lugar a responsabilidad civil o de otro modo violar cualquier ley local, estatal, 
											nacional o internacional.</li>
											<li>Viole, plagie o infrinja los derechos de terceros incluyendo, sin limitaci??n, 
											derechos de autor, marcas comerciales, secretos comerciales, confidencialidad, 
											contratos, patentes, derechos de privacidad o publicidad o cualquier otro derecho 
											de propiedad.</li>
											<li>Contenga un virus, elemento de espionaje u otro componente da??ino en los archivos 
											que se suben a La Plataforma.</li>
											<li>Contenga enlaces fijos, publicidad, cartas de cadenas o esquemas de pir??mides de 
											cualquier tipo.</li>
											<li>Constituya o contenga indicaciones de origen, endosos o declaraciones de hechos 
											falsos o enga??osos. El Usuario adem??s se obliga a no personificar a cualquier otra persona 
											o entidad, ya sea real o ficticia, incluyendo cualquier persona o Usuario dentro de La 
											Plataforma, tampoco puede ofrecer comprar o vender alg??n producto o servicio en o a trav??s 
											de sus comentarios presentados en los comentarios o publicaciones. El Usuario es responsable 
											del contenido y de las consecuencias de cualquiera de sus actividades.</li>
										</ul>
										
										
										<h3>Prohibiciones al Usuario</h3>
										<p>El Usuario garantiza y est?? de acuerdo en que, mientras use La Plataforma y los 
										diversos servicios y art??culos que se ofrecen en o a trav??s de la misma, no:</p>
										<ul>
											<li>Intentar?? ganar acceso no autorizado a La plataforma.</li>
											<li>Obtendr?? o intentar?? obtener acceso no autorizado a los sistemas de c??mputo, materiales 
											o informaci??n por cualquier medio.</li>
											<li>Personificara a ninguna persona o entidad ni desvirtuar?? su afiliaci??n con alguna otra 
											persona o entidad.</li>
											<li>Insertar?? su propio anuncio, posicionamiento de marca o alg??n otro contenido promocional 
											o el de un tercero  en cualquiera de los contenidos, materiales o servicios o materiales de 
											La Plataforma (por ejemplo, un enlace, una actualizaci??n RSS, un programa de radio 
											grabado (podcast), un canal de youtube, un perfil de Facebook, etc.), ni usar??, redistribuir??, 
											republicar?? o explotar?? dichos contenidos o servicios con cualquier otro prop??sito adicional 
											comercial o promocional</li>
											<li>Participar?? en navegar por la red, en ???raspar (scraping) la pantalla???, ???raspar (scraping) 
											la base da datos???, en recolectar direcciones de correo electr??nico, direcciones inal??mbricas 
											u otra informaci??n personal o de contactos, o cualquier otro medio autom??tico de obtener 
											listas de usuarios u otra informaci??n de o a trav??s de La Plataforma o de los servicios ofrecidos 
											en o a trav??s de La Plataforma, incluyendo, sin limitaci??n, cualquier informaci??n que se encuentre 
											en alg??n servidor o base de datos relacionada con La Plataforma o los servicios ofrecidos en 
											o a trav??s de La Plataforma</li>
											<li>Usar?? La Plataforma o los servicios puestos a su disposici??n en o a trav??s de La Plataforma 
											de alguna manera con la intenci??n de interrumpir, da??ar, deshabilitar, sobrecargar o deteriorar 
											La Plataforma o dichos servicios, incluyendo, sin limitaci??n, mandar mensajes masivos no 
											solicitados o ???inundar??? servidores con solicitudes</li>
											<li>Usar?? La Plataforma o los servicios o art??culos de La Plataforma en violaci??n de la propiedad 
											intelectual o de otros derechos legales o patrimoniales de La Plataforma o de alg??n tercero</li>
											<li>Usar?? La Plataforma o los servicios de La Plataforma en violaci??n de cualquier ley aplicable. 
											El Usuario se obliga adem??s, a no intentar (o alentar o apoyar el intento de otro) a embaucar, 
											destruir, decodificar, o de otro modo alterar o interferir con La Plataforma o con los 
											servicios de La Plataforma, o con cualquier contenido del mismo, o hacer cualquier uso no 
											autorizado del mismo. El Usuario se obliga a no usar La Plataforma de alguna manera que pudiera 
											da??ar, deshabilitar, sobrecargar o deteriorar La Plataforma o interferir con que cualquier 
											otra persona pueda usar o disfrutar de La Plataforma o de cualquiera de sus servicios. 
											El Usuario no obtendr?? ni intentar?? obtener alg??n material o informaci??n a trav??s de cualquier 
											medio que no haya sido estipulado o puesto a la disposici??n del p??blico intencionalmente a 
											trav??s de La Plataforma.</li>
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
										<p>Se reserva el derecho de cambiar los t??rminos de la presente Pol??tica de Privacidad en cualquier momento.</p>
										
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
