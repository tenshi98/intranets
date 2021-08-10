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
$original = "principal_view_evento.php";
$location = $original;
//Se agregan ubicaciones
$location .='?view='.$_GET['view'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-flag" aria-hidden="true"></i> Ver Evento';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para publicar comentario
if ( !empty($_POST['submit_comment']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'new_comment';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_eventos_listado_comentarios.php';
}
//formulario para reportar post
if ( !empty($_POST['submit_Report']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'post_report';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_reportes_post_listado.php';
}
//formulario para reportar comentario
if ( !empty($_POST['submit_Report_Comment']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'comment_report';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_reportes_comment_listado.php';
}
//formulario para sumar like
if ( !empty($_GET['like']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'comment_likes';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_eventos_listado_comentarios.php';
}
//formulario para sumar like
if ( !empty($_GET['dislike']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'comment_likes';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_eventos_listado_comentarios.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {         $error['usuario'] = 'sucess/Comentario creado correctamente';}
if (isset($_GET['report'])) {          $error['usuario'] = 'sucess/Evento reportado correctamente';}
if (isset($_GET['report_comment'])) {  $error['usuario'] = 'sucess/Comentario reportado correctamente';}
if (isset($_GET['liked'])) {           $error['usuario'] = 'sucess/Opinion Guardada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['comment_report']) ) { ?>
	
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Reportar Comentario</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
			
				<?php 
				//Se verifican si existen los datos
				if(isset($Comentario)) {  $x1  = $Comentario;   }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_post_data(1, 'Reportar el comentario solo en caso de infrinjir las normas.');
				$Form_Inputs->form_textarea('Reportar', 'Comentario', $x1, 2, 160);
					
				$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idEvento', $_GET['post_report'], 2);
				$Form_Inputs->form_input_hidden('idComentario', $_GET['comment_report'], 2);
				$Form_Inputs->form_input_hidden('idTipo', simpleEncode(2, fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
						
				?> 
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0a1; Reportar" name="submit_Report_Comment"> 
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
			<?php widget_validator(); ?>
                    
		</div>
	</div>
</div> 	
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}elseif ( ! empty($_GET['post_report']) ) { ?>

<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Reportar Evento</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
			
				<?php 
				//Se verifican si existen los datos
				if(isset($Comentario)) {  $x1  = $Comentario;   }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_post_data(1, 'Reportar el post solo en caso de infrinjir las normas.');
				$Form_Inputs->form_textarea('Reportar', 'Comentario', $x1, 2, 160);
					
				$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idEvento', $_GET['post_report'], 2);
				$Form_Inputs->form_input_hidden('idTipo', simpleEncode(2, fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
						
				?> 
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0a1; Reportar" name="submit_Report"> 
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
			<?php widget_validator(); ?>
                    
		</div>
	</div>
</div> 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
//identificador
$Identif = simpleDecode($_GET['view'], fecha_actual());

// Se trae un listado con todos los comentarios
$arrComentarios = array();
$query = "SELECT 
seg_vecinal_eventos_listado_comentarios.idComentario,
seg_vecinal_eventos_listado_comentarios.idCliente,
seg_vecinal_eventos_listado_comentarios.Fecha,
seg_vecinal_eventos_listado_comentarios.Hora,
seg_vecinal_eventos_listado_comentarios.Comentario,
seg_vecinal_eventos_listado_comentarios.idValidado,
seg_vecinal_eventos_listado_comentarios.nLikes,
seg_vecinal_eventos_listado_comentarios.nDislikes,

seg_vecinal_clientes_listado.Nombre,
seg_vecinal_clientes_listado.Direccion_img

FROM `seg_vecinal_eventos_listado_comentarios`
LEFT JOIN `seg_vecinal_clientes_listado` ON seg_vecinal_clientes_listado.idCliente = seg_vecinal_eventos_listado_comentarios.idCliente
WHERE seg_vecinal_eventos_listado_comentarios.idEvento=".$Identif;
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
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrComentarios,$row );
}
/*******************************************************************************/
//cuento los eventos
$n_Evento     = db_select_nrows (false, 'idEvento', 'seg_vecinal_eventos_listado', '', "idCliente='".$_SESSION['usuario']['basic_data']['idCliente']."' AND FechaCreacion='".fecha_actual()."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'N_Evento');
$n_max_evento = 3;		 
?>

<div class="col-sm-12 breadcrumb-bar">

	<?php if($n_Evento<=$n_max_evento){ ?>
		<a href="principal_eventos.php?pagina=1&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evento</a>
	<?php } ?>	
	
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Evento</h5>
		</header>
        <div id="div-3" class="tab-content">
			<div class="col-sm-8">
				<div class="row" style="border-right: 1px solid #333;">
					<div class="col-sm-12">
						
						<?php if($_SESSION['vecinos_eventos'][$Identif]['idValidado']==1){ ?>
							<div class="like_butons" style="margin-top:5px;">
								<a href="<?php echo $location.'&post_report='.$_GET['view']; ?>" class="fright margin_width fmrbtn like_report" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Reportar Publicacion</a>
							</div>
							<div class="clearfix"></div> 
						<?php } ?>
						
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Evento</h2>
						<p class="text-muted word_break">
							<strong>Tipo de Evento : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['Tipo']; ?><br/>
							<strong>Caracteristicas Agresor : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['DescripcionTipo']; ?><br/>
							<strong>Ciudad : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['Ciudad']; ?><br/>
							<strong>Comuna : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['Comuna']; ?><br/>
							<strong>Direccion : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['Direccion']; ?><br/>
							<strong>Fecha : </strong><?php echo fecha_estandar($_SESSION['vecinos_eventos'][$Identif]['Fecha']); ?><br/>
							<strong>Hora : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['Hora']; ?><br/>
							<strong>Descripcion Situacion : </strong><?php echo $_SESSION['vecinos_eventos'][$Identif]['DescripcionSituacion']; ?><br/>
									
						</p>
						
						<?php if(isset($_SESSION['vecinos_eventos_archivos'][$Identif])) { ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos Adjuntos</h2>
							<style>
								.file-other-icon {font-size: 4.2em;text-align: center;}
								.gridlist{margin-right: -15px;margin-left: -15px;display: flex;flex-flow: row wrap;}
							</style>
							<div class="row file-other-icon gridlist">
								<?php 
								//los recorro
								foreach ($_SESSION['vecinos_eventos_archivos'][$Identif] as $key => $arch){ ?>
									<div class="col-lg-3 col-md-4 col-xs-6 thumb items">
										<a class="iframe thumbnail" href="view_doc_preview.php?path=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($arch['Nombre'], fecha_actual()); ?>">
											<?php
											//se verifican las extensiones
											$exten  = 'JPG,jpg,jpeg,gif,png,bmp';           //Imagenes
											$exten .= ',doc,docx,xls,xlsx,ppt,pptx';        //archivos microsoft office
											$exten .= ',odt,odp,ods';                       //archivos libre office
											$exten .= ',pdf';                               //pdf
											$exten .= ',mp3,oga,wav';                       //Audio
											$exten .= ',mp4,webm,ogv,mp2,mpeg,mpg,mov,avi'; //Video
											$exten .= ',txt,rtf';                           //texto plano
											$exten .= ',gz,gzip,7Z,zip,rar';                //Archivos Comprimidos
											
											//Se verifica si el archivo dado esta dentro de los permitidos
											$path       = DB_SITE_REPO.DB_SITE_ALT_1_PATH.'/upload/'.$arch['Nombre'];
											$ext        = pathinfo($path, PATHINFO_EXTENSION);
											$num_files  = glob($path.".{".$exten."}", GLOB_BRACE);
											
											//Si existen archivos
											if($num_files > 0){
												
												switch($ext){
													/**************************************************/
													//Si son imagenes
													case 'JPG';
													case 'jpg';
													case 'jpeg';
													case 'gif';
													case 'png';
													case 'bmp';
														echo '<img src="'.$path.'" />';
													break;
													/**************************************************/
													//Si son archivos microsoft office
													case 'doc';
													case 'docx';
														echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
													break;
													case 'xls';
													case 'xlsx';
														echo '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
													break;
													case 'ppt';
													case 'pptx';
														echo '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos open office
													case 'odt';
													case 'odp';
													case 'ods';
														echo '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
													break;
													case 'pdf';
														echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos de audio
													case 'mp3';
														echo '<i class="fa fa-file-audio-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos de video
													case 'mp4';
													case 'webm';
													case 'ogv';
														echo '<i class="fa fa-file-video-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos de texto plano
													case 'txt';
													case 'rtf';
														echo '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos comprimidos
													case 'gz';
													case 'gzip';
													case '7Z';
													case 'zip';
													case 'rar';
														echo '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//Si son archivos no reproducibles por los reproductores
													case 'mp2';
													case 'mpeg';
													case 'mpg';
													case 'mov';
													case 'avi';
													case 'oga';
													case 'wav';
														echo '<i class="fa fa-file-o" aria-hidden="true"></i>';
													break;
													/**************************************************/
													//excepcion
													default;
														echo '<i class="fa fa-file" aria-hidden="true"></i>';
													break;
												}
											//cualquier otro archivo	
											}else{
												echo '<i class="fa fa-file" aria-hidden="true"></i>';
											}
											
											?>
										</a>
									</div>
							   <?php } ?> 
							</div>
        
						<?php } ?>
						
					</div>
					<?php 
					//se arma la direccion
					$direccion = "";
					if(isset($_SESSION['vecinos_eventos'][$Identif]["Direccion"])&&$_SESSION['vecinos_eventos'][$Identif]["Direccion"]!=''){   $direccion .= $_SESSION['vecinos_eventos'][$Identif]["Direccion"];}
					if(isset($_SESSION['vecinos_eventos'][$Identif]["Comuna"])&&$_SESSION['vecinos_eventos'][$Identif]["Comuna"]!=''){         $direccion .= ', '.$_SESSION['vecinos_eventos'][$Identif]["Comuna"];}
					if(isset($_SESSION['vecinos_eventos'][$Identif]["Ciudad"])&&$_SESSION['vecinos_eventos'][$Identif]["Ciudad"]!=''){         $direccion .= ', '.$_SESSION['vecinos_eventos'][$Identif]["Ciudad"];}
					//se despliega mensaje en caso de no existir direccion
					if($direccion!=''){
						echo mapa_from_gps($_SESSION['vecinos_eventos'][$Identif]['GeoLatitud'], $_SESSION['vecinos_eventos'][$Identif]['GeoLongitud'], 'Evento', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 19, 2);
					}else{
						$Alert_Text = 'No tiene una direccion definida';
						alert_post_data(4,2,2, $Alert_Text);
					}?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="text-primary"><i class="fa fa-comment-o" aria-hidden="true"></i> Comentarios</h2>
					</div>	
					<div>
						<div class="panel-footer">
							<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
								<div class="field">
									<div class="input-group">
										<input type="text" class="form-control input-sm" placeholder="Escriba su comentario aqui...." name="Comentario" id="Comentario" required="" >
										<input type="hidden" name="idEvento"   id="idEvento"   value="<?php echo $_GET['view']; ?>" required="">
										<input type="hidden" name="idCliente"  id="idCliente"  value="<?php echo simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()); ?>" required="">
										<input type="hidden" name="idValidado" id="idValidado" value="<?php echo simpleEncode(1, fecha_actual()); ?>" required="">
										<span class="input-group-btn">
											<input type="submit" class="btn btn-primary btn-sm fa-input" value="&#xf1d9;" name="submit_comment"> 
										</span>
									</div>
								</div>
							</form>
							<?php widget_validator(); ?>
						</div>
					</div>
					<div class="seg_chat">
						<ul class="chat">
							<?php foreach ($arrComentarios as $comment) {
								//si es el mismo usuario
								if(isset($comment['idCliente'])&&$comment['idCliente']==$_SESSION['usuario']['basic_data']['idCliente']){ ?>
									<li class="right clearfix">
										<span class="chat-img pull-right">
											<?php if(isset($comment['Direccion_img'])&&$comment['Direccion_img']=='') {
												echo '<img alt="User Picture" class="img-circle" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
											}else{
												echo '<img alt="User Picture" class="img-circle" src="'.DB_SITE_ALT_1.'/upload/'.$comment['Direccion_img'].'" >';
											} ?>
										</span>
										<div class="chat-body clearfix">
											<div class="header">
												<small class="text-muted" style="margin-left: 0px !important;"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $comment['Fecha'].' '.$comment['Hora']; ?></small>
												<strong class="pull-right primary-font" style="color: #337ab7;">Yo</strong>
											</div>
											<p style="white-space: initial;"><?php echo $comment['Comentario']; ?></p>
										</div>
									</li>
								<?php //si es otro	
								}else{ ?>
									<li class="left clearfix">
										<span class="chat-img pull-left">
											<?php if(isset($comment['Direccion_img'])&&$comment['Direccion_img']=='') {
												echo '<img alt="User Picture" class="img-circle" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
											}else{
												echo '<img alt="User Picture" class="img-circle" src="'.DB_SITE_ALT_1.'/upload/'.$comment['Direccion_img'].'" >';
											} ?>
										</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font" style="color: #337ab7;"><?php echo $comment['Nombre']; ?></strong> 
												<small class="pull-right text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $comment['Fecha'].' '.$comment['Hora']; ?></small>
											</div>
											<p style="white-space: initial;"><?php echo $comment['Comentario']; ?></p>
											<span class="pull-right clearfix like_butons">
												<a href="<?php echo $location.'&like='.simpleEncode($comment['idComentario'], fecha_actual()); ?>" title="Me Gusta" class="tooltip" style="position: initial;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo $comment['nLikes']; ?></a>
												<a href="<?php echo $location.'&dislike='.simpleEncode($comment['idComentario'], fecha_actual()); ?>" title="No Me Gusta" class="tooltip" style="position: initial;"> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $comment['nDislikes']; ?></a>
												<?php if($comment['idValidado']==1){ ?>
													<a href="<?php echo $location.'&post_report='.$_GET['view'].'&comment_report='.simpleEncode($comment['idComentario'], fecha_actual()); ?>" title="Reportar Comentario" class="tooltip" style="position: initial;">   <i class="fa fa-bullhorn" aria-hidden="true"></i></a>
												<?php } ?>
											</span>
											<div class="clearfix"></div>
										</div>
									</li>
								<?php 	
								}
							} ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>	
	</div>
</div>	



<div class="clearfix"></div>
	<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
	<a href="principal.php" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>


<?php widget_modal(80, 95); ?>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
