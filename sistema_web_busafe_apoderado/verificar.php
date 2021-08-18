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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "verificar.php";
$location = $original;
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Patente']) && $_GET['Patente'] != ''){   $location .= "?Patente=".$_GET['Patente'];   $search .= "?Patente=".$_GET['Patente'];}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/prospectos_transportistas_listado.php';
}

?>
<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<meta charset="UTF-8">
		<title>Verificar</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--Hoja de Estilos-->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/font-awesome-animation/font-awesome-animation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/main.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/theme_color_72.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/lib/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/my_colors.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/css/my_corrections.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/html5shiv/html5shiv.js"></script>
			<script src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/respond/respond.min.js"></script>
			<![endif]-->
		<!--Modulos de javascript-->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/js/personel.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-1.11.0.min.js"></script>
		<!-- Icono de la pagina -->
		<link rel="icon" type="image/png" href="img/mifavicon.png" />
		<!-- Estilos Personalizados -->
		<style>
			.form-horizontal .form-group {
				margin-left: 0px;
				margin-right: 0px;
			}
			.formbox {
				background-color: #ffffff;
				border-radius: 3px;
			}
			.register-heading {
				margin-top: 0;
			}
			.inner {
				background-color: #F3C500;
				background-image: url("img/Fondo.jpg");
				background-size: 100%;
			}
		</style>
	</head>
	<body class="">
		<div class="inner">
		
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['filter']) ) { 
	//Si existe la variable patente se busca
	if (isset($_GET['Patente'])&&$_GET['Patente']!='' ) { 
	/*******************************************************************/
	//variables
	$ndata_2 = 0;
	if(isset($_GET['Patente'])){
		$query  = "SELECT idVehiculo FROM vehiculos_listado WHERE Patente='".$_GET['Patente']."' AND idEstado='1' AND idProceso='2' ";
		$result = mysqli_query($dbConn, $query);
		$ndata_2 = mysqli_num_rows($result);
		$rowveh = mysqli_fetch_assoc ($result);
	}
	//generacion de errores
	if($ndata_2 == 0) { ?>
		
		<div class="col-sm-8 fcenter clearfix">
			<div class="">
							
				<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
				<h3 class="register-heading">Datos Contacto Vehiculo</h3>

				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
					<div class="formbox col-md-12">
						<?php
						//Se verifican si existen los datos
						if(isset($Nombre)) {       $x1  = $Nombre;       }else{$x1  = '';}
						if(isset($Fono)) {         $x2  = $Fono;         }else{$x2  = '';}
						if(isset($email)) {        $x3  = $email;        }else{$x3  = '';}
						if(isset($email_noti)) {   $x4  = $email_noti;   }else{$x4  = '';}
						
						//se dibujan los inputs
						$Form_Inputs = new Inputs();
						$Form_Inputs->input_hidden('idSistema', 1, 2);			
						$Form_Inputs->input_hidden('F_Ingreso', fecha_actual(), 2);			
						$Form_Inputs->input_hidden('idEstadoFidelizacion', 1, 2);			
						$Form_Inputs->input_hidden('idEtapa', 1, 2);
						?>
									
						<br/>
						<?php $Form_Inputs->form_post_data(1, 'El vehiculo no esta registrado en la plataforma, ¿desea registrar los datos para que nosotros nos comuniquemos?'); ?>
							<div class="row register-form">
							
							<div class="col-md-12">
								<h4>Datos Chofer</h4>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php $Form_Inputs->input('text', 'Nombre del chofer', 'Nombre', $x1, 2); ?>
								</div>
								<div class="form-group">
									<?php $Form_Inputs->input_icon('text', 'Email', 'email', $x3, 1,'fa fa-envelope-o');?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php $Form_Inputs->input_phone('Telefono', 'Fono', $x2, 2);?>
								</div>
							</div>
							
							<div class="col-md-12">
								<h4>Datos Apoderado</h4>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php $Form_Inputs->input_icon('text', 'Email del Apoderado', 'email', $x4, 2,'fa fa-envelope-o');?>
								</div>
							</div>

						</div>
					</div>
								
					<div class="col-md-12">
						<br/>
						<div class="text-center">
							<input type="submit" class="btn btn-primary fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
							<a href="<?php echo $original; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
						</div>
					</div>
								
				</form> 
				<?php widget_validator(); ?>
			</div>
		</div>


	<?php }elseif($ndata_2 != 0){ ?>
		<div class="col-sm-8 fcenter">
			<?php 
			$Alert_Text  = 'El vehiculo existe, puede registrarse.';
			alert_post_data(2,1,1, $Alert_Text);
			?>
			<a href="<?php echo 'registrar.php?ndata='.$rowveh['idVehiculo']; ?>" class="btn btn-primary fright margin_width"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Continuar</a>
			<a href="<?php echo $original; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		</div>
	<?php }
	//si no existe la variable patente
	} else  { ?> 
		<div class="col-sm-8 fcenter">
			<?php 
			$Alert_Text  = 'Ingrese una Patente y pruebe nuevamente.';
			alert_post_data(2,1,1, $Alert_Text);
			?>
			<a href="<?php echo $original; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		</div>
	<?php } ?> 
	 		
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { ?>
	 
<div class="col-sm-8 fcenter clearfix">
	<div class="">
					
		<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
		<h3 class="register-heading">Buscar Vehiculo</h3>

		<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
			<div class="formbox col-md-12">
				<?php
				//Se verifican si existen los datos
				if(isset($Patente)) {  $x1  = $Patente;  }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Inputs();
				?>
							
				<br/>
				<div class="row register-form">
					<div class="col-md-12">
						<h4>Verificar si furgon existe dentro de la Plataforma</h4>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<?php $Form_Inputs->input('text', 'Patente', 'Patente', $x1, 2); ?>
						</div>
					</div>
				</div>
			</div>
						
			<div class="col-md-12">
				<br/>
				<div class="text-center">
					<input type="submit" class="btn btn-primary fa-input" value="&#xf002; Buscar" name="filter">
				</div>
			</div>
						
		</form> 
		<?php widget_validator(); ?>
	</div>
</div>		


<?php } ?>		
		
		</div>
	</body>
</html>
