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
$original = "trabajadores_listado.php";
$location = $original;
$new_location = "trabajadores_listado_antecedentes.php";
$new_location .='?pagina='.$_GET['pagina'];
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Choferes';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'submit_antecedentes';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
//se borra un dato
if ( !empty($_GET['del_File_Antecedentes']) )     {
	//Nueva ubicacion
	$location = $new_location;
	$location.='&id='.$_GET['id'];
	//Llamamos al formulario
	$form_trabajo= 'del_File_Antecedentes';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Chofer creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Chofer editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Chofer borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT Nombre, ApellidoPat, ApellidoMat, File_Antecedentes
FROM `trabajadores_listado`
WHERE idTrabajador = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);
?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Chofer', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Editar Papel de Antecedentes');?>
</div>
<div class="clearfix"></div>


<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'trabajadores_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'trabajadores_listado_laboral.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Informacion Laboral</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_cargas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Cargas Familiares</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_licencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Licencia Conducir</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Foto</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Contrato</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Curriculum</a></li>
						<li class="active"><a href="<?php echo 'trabajadores_listado_antecedentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Antecedentes</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_carnet.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Carnet</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_rhtm.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - RHTM</a></li>
						
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;">
				
				<?php if(isset($rowdata['File_Antecedentes'])&&$rowdata['File_Antecedentes']!=''){?>
        
					<div class="col-sm-10 fcenter">
						<h3>Archivo</h3>
						<?php echo preview_docs('upload', $rowdata['File_Antecedentes'], '', DB_SITE_REPO, DB_SITE_ALT_1_PATH); ?>
					</div>
					<a href="<?php echo $new_location.'&id='.$_GET['id'].'&del_File_Antecedentes='.$_GET['id']; ?>" class="btn btn-danger fright margin_width" style="margin-top:10px;margin-bottom:10px;"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Archivo</a>
					<div class="clearfix"></div>
					
				<?php }else{?>

					<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
					
						<?php 
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_multiple_upload('Seleccionar archivo','File_Antecedentes', 1, '"doc","docx","pdf","jpg", "png", "gif", "jpeg"');
						
						$Form_Inputs->form_input_hidden('idTrabajador', $_GET['id'], 2);
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
