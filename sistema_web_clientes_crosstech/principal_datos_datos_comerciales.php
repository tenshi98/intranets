<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "principal_datos.php";
$location = $original;
$new_location = "principal_datos_datos_comerciales.php";
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Cliente creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Cliente editado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Cliente Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Se traen todos los datos de mi Cliente
$query = "SELECT Nombre,Rut, RazonSocial, Giro, idRubro, idTipo
FROM `clientes_listado`
WHERE idCliente = '".$_SESSION['usuario']['basic_data']['idCliente']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
						
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
$rowdata = mysqli_fetch_assoc ($resultado); ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Cliente', $rowdata['Nombre'], 'Editar Datos Comerciales'); ?>
</div>
<div class="clearfix"></div>

<?php
/****************************************************************************/
//mensaje en caso de no haber cambiado la contraseña
if(isset($_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['password']=='81dc9bdb52d04dc20036dbd8313ed055'){
	echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	$Alert_Text  = '<strong>Cambio de contraseña: </strong> ';
	$Alert_Text .= 'Por motivos de seguridad, se recomienda <strong>cambiar</strong> la contraseña';
	$Alert_Text .= '<a href="principal_datos_datos_password.php" title="Cambio de contraseña" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cambio de contraseña</a>';
	alert_post_data(2,1,2, $Alert_Text);
	echo '</div>';
} ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php'; ?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_datos_persona_contacto.php'; ?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){ ?>
							<li class="active"><a href="<?php echo 'principal_datos_datos_comerciales.php'; ?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'principal_datos_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="table-responsive">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="padding-top:40px;padding-bottom:240px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Rut)){              $x1  = $Rut;               }else{$x1  = $rowdata['Rut'];}
					if(isset($RazonSocial)){      $x2  = $RazonSocial;       }else{$x2  = $rowdata['RazonSocial'];}
					if(isset($Giro)){             $x3  = $Giro;              }else{$x3  = $rowdata['Giro'];}
					if(isset($idRubro)){          $x4  = $idRubro;           }else{$x4  = $rowdata['idRubro'];}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x1, 2);
					$Form_Inputs->form_input_text('Razon Social', 'RazonSocial', $x2, 2);
					$Form_Inputs->form_input_icon('Giro de la empresa', 'Giro', $x3, 1,'fa fa-industry');
					$Form_Inputs->form_select_filter('Rubro','idRubro', $x4, 1, 'idRubro', 'Codigo,Nombre', 'core_rubros', 0, '',$dbConn);

					$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
