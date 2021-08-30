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
$original = "principal_datos_datos_imagen.php";
$location = $original;
$location .= '?d=d';
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if ( !empty($_GET['del_img']) )     {
	//Llamamos al formulario
	echo 'entra';
	$form_trabajo= 'del_img';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_clientes_listado.php';	
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
// consulto los datos
$query = "SELECT idTipo, Direccion_img, Nombre
FROM `seg_vecinal_clientes_listado`
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

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Vecino', $rowdata['Nombre'], 'Editar Imagen Perfil');?>
</div>
<div class="clearfix"></div>

<?php
/****************************************************************************/
//mensaje en caso de no haber aceptado la ubicacion
if(isset($_SESSION['usuario']['basic_data']['idNuevo'])&&$_SESSION['usuario']['basic_data']['idNuevo']==0){
	echo '<div class="col-sm-12">';
	$Alert_Text  = '<strong>Confirmar la direccion: </strong> ';
	$Alert_Text .= 'si la ubicacion mostrada es correcta presionar <strong>Confirmar Ubicacion</strong>, si no es asi presionar <strong>Modificar Ubicacion</strong>';
	$Alert_Text .= '<a href="principal_datos.php?mod=true" title="Modificar Ubicacion" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar Ubicacion</a>';
	$Alert_Text .= '<a href="principal_datos.php?confirm=true" title="Confirmar Ubicacion" class="btn btn-success btn-sm pull-right" ><i class="fa fa-check" aria-hidden="true"></i> Confirmar Ubicacion</a>';
	alert_post_data(2,1,2, $Alert_Text);
	echo '</div>';
} ?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_datos.php';?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php';?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_mapa.php';?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion Mapa</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php';?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="<?php echo 'principal_datos_datos_imagen.php';?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen Perfil</a></li>
						<li class=""><a href="<?php echo 'principal_datos_datos_persona_contacto.php';?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
							<li class=""><a href="<?php echo 'principal_datos_datos_comerciales.php';?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'principal_datos_datos_password.php';?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div class="table-responsive">
			<div class="col-sm-8 fcenter" style="padding-top:40px;padding-bottom:40px;">
				<?php if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){?>
				
					<div class="col-sm-10 fcenter">
						<img src="<?php echo DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img'] ?>" width="100%" class="img-thumbnail" > 
						<br/>
						<a href="<?php echo $location.'&del_img=true'; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Imagen</a>
					</div>
					<div class="clearfix"></div>

				<?php }else{ ?>
						
					<link rel="stylesheet" href="<?php echo DB_SITE_REPO ?>/LIBS_js/upload_and_crop_image/croppie.css">
					<script src="<?php echo DB_SITE_REPO ?>/LIBS_js/upload_and_crop_image/croppie.js"></script>
						
					<div class="fileUpload btn btn-primary">
						<span><i class="fa fa-search" aria-hidden="true"></i> Seleccionar Imagen</span>
						<input name="upload_image" id="upload_image" type="file" class="upload" />
					</div>
					
					<div id="uploadimageModal" class="modal" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Seleccionar Zona</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-8 text-center">
											  <div id="image_demo" style="width:350px; margin-top:30px"></div>
										</div>
										<div class="col-md-4" style="padding-top:30px;">
											<br/>
											<br/>
											<br/>
											  <button class="btn btn-success crop_image"><i class="fa fa-scissors" aria-hidden="true"></i> Cortar y Subir Imagen</button>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					
					<script>  
						$(document).ready(function(){

							$image_crop = $('#image_demo').croppie({
								enableExif: true,
								viewport: {
									width:200,
									height:200,
									type:'square' //circle
								},
								boundary:{
									width:300,
									height:300
								}
							});

							$('#upload_image').on('change', function(){
								var reader = new FileReader();
								reader.onload = function (event) {
									$image_crop.croppie('bind', {
										url: event.target.result
									}).then(function(){
										console.log('jQuery bind complete');
									});
								}
								reader.readAsDataURL(this.files[0]);
								$('#uploadimageModal').modal('show');
							});

							$('.crop_image').click(function(event){
								$image_crop.croppie('result', {
									type: 'canvas',
									size: 'viewport'
								}).then(function(response){
									$.ajax({
										url:"principal_datos_datos_imagen_upload.php",
										type: "POST",
										data:{"image": response},
										success:function(data){
											$('#uploadimageModal').modal('hide');
											location.reload(); 
											//alert('listo');
										}
									});
								})
							});

						});  
					</script>
					
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
