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
//Cargamos la ubicacion 
$original = "vehiculos_listado.php";
$location = $original;
$new_location = "vehiculos_listado_password.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Vehiculos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//se agregan ubicaciones
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Vehiculo creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Vehiculo editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Vehiculo borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT Nombre,Patente,idSistema,Password
FROM `vehiculos_listado`
WHERE idVehiculo = ".$_GET['id'];
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
$rowdata = mysqli_fetch_assoc ($resultado);


?>

<div class="col-sm-12">
	<?php 
	$vehiculo = $rowdata['Nombre'];
	if(isset($rowdata['Patente'])&&$rowdata['Patente']!=''){
		$vehiculo .= ' Patente '.$rowdata['Patente'];
	}
	echo widget_title('bg-aqua', 'fa-cog', 100, 'Vehiculo', $vehiculo, 'Cambiar Password');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'vehiculos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'vehiculos_listado_opc_4.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Chofer</a></li>
						<li class="active"><a href="<?php echo 'vehiculos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password APP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_colegios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i> Colegios</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-picture-o" aria-hidden="true"></i>  Foto</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_padron.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Padron</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_permiso_circulacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Circulacion</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_soap.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - SOAP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_revision_tecnica.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Revision Tecnica</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Mantenciones</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_trans_personas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Cert. Transporte Personas</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Ficha Tecnica</a></li>
						
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>		
					<?php 
					//Se verifican si existen los datos
					if(isset($Password)) {       $x1  = $Password;       }else{$x1  = $rowdata['Password'];}
					
					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_password('Password', 'Password', $x1, 2);
					
					$Form_Inputs->form_input_hidden('idVehiculo', $_GET['id'], 2);
					?>
		
			

					<div class="form-group">		
						<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit"> 		
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>	
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>


<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
