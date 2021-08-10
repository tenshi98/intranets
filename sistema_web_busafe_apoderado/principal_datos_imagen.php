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
$original = "principal_datos.php";
$location = $original;
$new_location = "principal_datos_imagen.php";
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'submit_img';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
}
//se borra un dato
if ( !empty($_GET['del_img']) )     {
	//Nueva ubicacion
	$location = $new_location;
	//Llamamos al formulario
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Perfil creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Perfil editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Perfil borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// tomo los datos del usuario
$query = "SELECT Nombre, ApellidoPat, ApellidoMat, Direccion_img
FROM `apoderados_listado`
WHERE idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);
?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Apoderado', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Editar Foto');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_ubicacion.php'; ?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto</a></li>
						<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;padding-bottom:40px;">
				
				<?php if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){?>
        
					<div class="col-sm-10 fcenter">
						<img src="upload/<?php echo $rowdata['Direccion_img'] ?>" width="100%" class="img-thumbnail" > 
						<br/>
						<a href="<?php echo $new_location.'?del_img='.$_SESSION['usuario']['basic_data']['idApoderado']; ?>" class="btn btn-danger fright margin_width" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					</div> 
					<div class="clearfix"></div>
					
				<?php }else{?>

					<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
					
						<?php 
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','Direccion_img', 1, '"jpg", "png", "gif", "jpeg"');
						
						$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
						?> 

						<div class="form-group">
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf093; Subir Archivo" name="submit_edit"> 
						</div>
							  
					</form> 
					<?php widget_validator(); ?>
				<?php }?> 
				
				
				
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
