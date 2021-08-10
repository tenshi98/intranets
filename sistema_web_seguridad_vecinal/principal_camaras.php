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
$original = "principal_camaras.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-video-camera" aria-hidden="true"></i> Mis Grupos de Camaras';
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){                          $location .= "&Nombre=".$_GET['Nombre'];                          $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idEstado']) && $_GET['idEstado'] != ''){                      $location .= "&idEstado=".$_GET['idEstado'];                      $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['N_Camaras']) && $_GET['N_Camaras'] != ''){                    $location .= "&N_Camaras=".$_GET['N_Camaras'];                    $search .= "&N_Camaras=".$_GET['N_Camaras'];}
if(isset($_GET['idSubconfiguracion']) && $_GET['idSubconfiguracion'] != ''){  $location .= "&idSubconfiguracion=".$_GET['idSubconfiguracion'];  $search .= "&idSubconfiguracion=".$_GET['idSubconfiguracion'];}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'grupo_insert';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_camaras_listado.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'grupo_del';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_camaras_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Grupo Camaras creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Grupo Camaras editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Grupo Camaras borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['id']) ) { 
// Se traen todos los datos de mi usuario
$query = "SELECT 
seg_vecinal_camaras_listado.idCamara,
seg_vecinal_camaras_listado.Nombre,
seg_vecinal_camaras_listado.idSubconfiguracion,
seg_vecinal_camaras_listado.N_Camaras,
seg_vecinal_camaras_listado.Config_usuario,
seg_vecinal_camaras_listado.Config_Password,
seg_vecinal_camaras_listado.Config_IP,
seg_vecinal_camaras_listado.Config_Puerto,

core_sistemas.Nombre AS sistema,
core_estados.Nombre AS estado,
core_sistemas_opciones.Nombre AS Subconfiguracion,
core_tipos_camara.Nombre AS TipoCamara

FROM `seg_vecinal_camaras_listado`
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema             = seg_vecinal_camaras_listado.idSistema
LEFT JOIN `core_estados`               ON core_estados.idEstado               = seg_vecinal_camaras_listado.idEstado
LEFT JOIN `core_sistemas_opciones`     ON core_sistemas_opciones.idOpciones   = seg_vecinal_camaras_listado.idSubconfiguracion
LEFT JOIN `core_tipos_camara`          ON core_tipos_camara.idTipoCamara      = seg_vecinal_camaras_listado.idTipoCamara

WHERE seg_vecinal_camaras_listado.idCamara = ".simpleDecode($_GET['id'], fecha_actual());
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

//Se traen las rutas
$arrCamaras = array();
$query = "SELECT 
seg_vecinal_camaras_listado_canales.idCanal,
seg_vecinal_camaras_listado_canales.idCamara,
seg_vecinal_camaras_listado_canales.Nombre,
seg_vecinal_camaras_listado_canales.Config_usuario,
seg_vecinal_camaras_listado_canales.Config_Password,
seg_vecinal_camaras_listado_canales.Config_IP,
core_estados.Nombre AS estado,
seg_vecinal_camaras_listado_canales.idEstado

FROM `seg_vecinal_camaras_listado_canales`
LEFT JOIN `core_estados`   ON core_estados.idEstado = seg_vecinal_camaras_listado_canales.idEstado
WHERE seg_vecinal_camaras_listado_canales.idCamara = ".simpleDecode($_GET['id'], fecha_actual())."
ORDER BY seg_vecinal_camaras_listado_canales.idCanal ASC";
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
array_push( $arrCamaras,$row );
}

?>
<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowdata['Nombre'], 'Resumen');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_camaras.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-ol" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'principal_camaras_config.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					
					<div class="col-sm-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/camara_seg.jpg">
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre del Grupo : </strong><?php echo $rowdata['Nombre']; ?><br/>
							<strong>Numero de Camaras: </strong><?php echo $rowdata['N_Camaras']; ?><br/>
							<strong>Estado : </strong><?php echo $rowdata['estado']; ?><br/>
							<strong>Subconfiguracion : </strong><?php echo $rowdata['Subconfiguracion']; ?>
						</p>
										
						<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==2){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Subconfiguracion</h2>
							<p class="text-muted">
								<strong>Tipo de Camara : </strong><?php echo $rowdata['TipoCamara']; ?><br/>
								<strong>Usuario : </strong><?php echo $rowdata['Config_usuario']; ?><br/>
								<strong>Password: </strong><?php echo $rowdata['Config_Password']; ?><br/>
								<strong>IP : </strong><?php echo $rowdata['Config_IP']; ?><br/>
								<strong>Puerto : </strong><?php echo $rowdata['Config_Puerto']; ?><br/>
							</p>
						<?php } ?>
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Listado Camaras</h2>
						<table  class="table table-bordered">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==1){ ?>
										<th>Usuario</th>
										<th>Password</th>
										<th>IP</th>
									<?php } ?>
									<th width="160">Estado</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrCamaras as $zona) { ?>
									<tr class="odd">		
										<td><?php echo $zona['Nombre']; ?></td>	
										<?php if(isset($rowdata['idSubconfiguracion'])&&$rowdata['idSubconfiguracion']==1){ ?>
											<td><?php echo $zona['Config_usuario']; ?></td>	
											<td><?php echo $zona['Config_Password']; ?></td>	
											<td><?php echo $zona['Config_IP']; ?></td>	
										<?php } ?>
										<td><label class="label <?php if(isset($zona['idEstado'])&&$zona['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $zona['estado']; ?></label></td>		
									</tr>
								<?php } ?>                    
							</tbody>
						</table>
						
					</div>	
					<div class="clearfix"></div>
					
					
				</div>
			</div>
        </div>	
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['new']) ) { ?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Crear Grupo Camaras</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {          $x1  = $Nombre;           }else{$x1  = '';}
				if(isset($N_Camaras)) {       $x2  = $N_Camaras;        }else{$x2  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 2);
				
				$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idEstado', simpleEncode(1, fecha_actual()), 2);
				$Form_Inputs->form_input_hidden('idSubconfiguracion_new', simpleEncode(1, fecha_actual()), 2);
					
				?>
			
				<div class="form-group">	
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit">	
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
				</div>
			</form>
			<?php widget_validator(); ?> 
		</div>
	</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
/**********************************************************/
//paginador de resultados
if(isset($_GET["pagina"])){
	$num_pag = $_GET["pagina"];	
} else {
	$num_pag = 1;	
}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){
	$comienzo = 0 ;$num_pag = 1 ;
} else {
	$comienzo = ( $num_pag - 1 ) * $cant_reg ;
}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'nombre_asc':    $order_by = 'ORDER BY seg_vecinal_camaras_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'ORDER BY seg_vecinal_camaras_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'estado_asc':    $order_by = 'ORDER BY core_estados.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':   $order_by = 'ORDER BY core_estados.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'ncamaras_asc':  $order_by = 'ORDER BY core_estados.N_Camaras ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Camaras Ascendente';break;
		case 'ncamaras_desc': $order_by = 'ORDER BY core_estados.N_Camaras DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Camaras Descendente';break;
		case 'subconf_asc':   $order_by = 'ORDER BY core_sistemas_opciones.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Subconfiguracion Ascendente';break;
		case 'subconf_desc':  $order_by = 'ORDER BY core_sistemas_opciones.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Subconfiguracion Descendente';break;
		
		default: $order_by = 'ORDER BY seg_vecinal_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'ORDER BY seg_vecinal_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$z="WHERE seg_vecinal_camaras_listado.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];	
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){                          $z .= " AND seg_vecinal_camaras_listado.Nombre LIKE '%".$_GET['Nombre']."%'";}
if(isset($_GET['idEstado']) && $_GET['idEstado'] != ''){                      $z .= " AND seg_vecinal_camaras_listado.idEstado=".$_GET['idPais'];}
if(isset($_GET['N_Camaras']) && $_GET['N_Camaras'] != ''){                    $z .= " AND seg_vecinal_camaras_listado.N_Camaras=".$_GET['N_Camaras'];}
if(isset($_GET['idSubconfiguracion']) && $_GET['idSubconfiguracion'] != ''){  $z .= " AND seg_vecinal_camaras_listado.idSubconfiguracion=".$_GET['idSubconfiguracion'];}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idCamara FROM `seg_vecinal_camaras_listado` ".$z;
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
$cuenta_registros = mysqli_num_rows($resultado);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);	
// Se trae un listado con todos los usuarios
$arrCamaras = array();
$query = "SELECT 
seg_vecinal_camaras_listado.idCamara,
seg_vecinal_camaras_listado.Nombre,
seg_vecinal_camaras_listado.N_Camaras,
core_estados.Nombre AS estado,
seg_vecinal_camaras_listado.idEstado,
core_sistemas_opciones.Nombre AS Subconfiguracion

FROM `seg_vecinal_camaras_listado`
LEFT JOIN `core_estados`            ON core_estados.idEstado              = seg_vecinal_camaras_listado.idEstado
LEFT JOIN `core_sistemas_opciones`  ON core_sistemas_opciones.idOpciones  = seg_vecinal_camaras_listado.idSubconfiguracion
".$z."
".$order_by."
LIMIT $comienzo, $cant_reg ";
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
array_push( $arrCamaras,$row );
}
?>

<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Grupo Camaras</a>
	
</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter" style="min-height:500px;">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;              }else{$x1  = '';}
				if(isset($N_Camaras)) {           $x2  = $N_Camaras;           }else{$x2  = '';}
				if(isset($idEstado)) {            $x3  = $idEstado;            }else{$x3  = '';}
				if(isset($idSubconfiguracion)) {  $x4  = $idSubconfiguracion;  }else{$x4  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x3, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				$Form_Inputs->form_select('Subconfiguracion','idSubconfiguracion', $x4, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 1);
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div> 
                      



                                
<div class="col-sm-12">
	<div class="box">	
		<header>		
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Grupo Camaras</h5>
			<div class="toolbar">
				<?php 
				//se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>	
		</header>
		<div class="table-responsive">    
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">N° Camaras</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ncamaras_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ncamaras_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Subconfiguracion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=subconf_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=subconf_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCamaras as $usuarios) { ?>
						<tr class="odd">		
							<td><?php echo $usuarios['Nombre']; ?></td>	
							<td><?php echo $usuarios['N_Camaras']; ?></td>	
							<td><?php echo $usuarios['Subconfiguracion']; ?></td>	
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $usuarios['estado']; ?></label></td>		
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo 'view_camaras_listado.php?view='.simpleEncode($usuarios['idCamara'], fecha_actual()); ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&id='.simpleEncode($usuarios['idCamara'], fecha_actual()); ?>" title="Editar Informacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $location.'&del='.simpleEncode($usuarios['idCamara'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el Predio '.$usuarios['Nombre'].'?';?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Informacion" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>                    
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>


<?php widget_modal(80, 95); ?>
	
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
