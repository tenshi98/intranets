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
$original = "vehiculos_facturacion_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Fecha']) && $_GET['Fecha'] != ''){                  $location .= "&Fecha=".$_GET['Fecha'];                 $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones'] != ''){  $location .= "&Observaciones=".$_GET['Observaciones']; $search .= "&Observaciones=".$_GET['Observaciones'];}
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Facturaciones';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/

//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'create_new';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';
}
//se borran los datos temporales
if ( !empty($_GET['clear_all']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'clear_all';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit_temp_datos']) )  { 
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'edit_datos';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';
}
/*************************************************/
//se agregan todos los clientes
if ( !empty($_GET['addclientall']) )     {
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'add_all_cliente';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';	
}
//se borra un dato
if ( !empty($_GET['del_cliente']) )     {
	//se agregan ubicaciones
	$location .='&view=true';
	//Llamamos al formulario
	$form_trabajo= 'del_cliente';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';	
}
/*************************************************/
//se borran los datos temporales
if ( !empty($_GET['facturar']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'facturar';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Datos Creados correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Datos Modificados correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Datos borrados correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['moddatos']) ) { ?>

<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificacion de los datos basicos</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
			
				<?php 
				//Se verifican si existen los datos
				if(isset($Fecha)) {          $x1  = $Fecha;          }else{$x1  = $_SESSION['basicos']['Fecha'];}
				if(isset($Observaciones)) {  $x2  = $Observaciones;  }else{$x2  = $_SESSION['basicos']['Observaciones'];}
				if(isset($idSistema)) {      $x3  = $idSistema;      }else{$x3  = $_SESSION['basicos']['idSistema'];}
					
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select('Sistema','idSistema', $x3, 2, 'idSistema', 'Nombre', 'core_sistemas', 0, '', $dbConn);
				}else{
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				}
				$Form_Inputs->form_input_hidden('idApoderado', $_GET['id'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_temp_datos"> 
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
			<?php widget_validator(); ?>
                    
		</div>
	</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}elseif ( ! empty($_GET['view']) ) {
//variables
$SIS_Fecha_Ano       = fecha2Ano($_SESSION['basicos']['Fecha']);
$SIS_Fecha_Mes       = fecha2NMes($_SESSION['basicos']['Fecha']);

// Se traen todos los datos
$query = "SELECT  Nombre
FROM `usuarios_listado`
WHERE idUsuario = ".$_SESSION['basicos']['idUsuario'];
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
$rowCreador = mysqli_fetch_assoc ($resultado);
				
// Se traen todos los datos
$query = "SELECT  Nombre
FROM `core_sistemas`
WHERE idSistema = ".$_SESSION['basicos']['idSistema'];
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
$rowSistema = mysqli_fetch_assoc ($resultado);

//traigo todos los apoderados con hijos
$arrHijos = array();
$query = "SELECT
apoderados_listado_hijos.idHijos,
apoderados_listado_hijos.idApoderado,

apoderados_listado_hijos.Nombre AS HijoNombre,
apoderados_listado_hijos.ApellidoPat AS HijoApellidoPat,
apoderados_listado_hijos.ApellidoMat AS HijoApellidoMat,

apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,

vehiculos_listado.Nombre AS VehiculoNombre,
vehiculos_listado.Patente AS VehiculoPatente

FROM `apoderados_listado_hijos`
LEFT JOIN `apoderados_listado`  ON apoderados_listado.idApoderado  = apoderados_listado_hijos.idApoderado
LEFT JOIN `vehiculos_listado`   ON vehiculos_listado.idVehiculo    = apoderados_listado_hijos.idVehiculo

WHERE apoderados_listado.idSistema = '".$_SESSION['basicos']['idSistema']."' 
AND apoderados_listado.idEstado = 1
GROUP BY apoderados_listado_hijos.idHijos
ORDER BY vehiculos_listado.Nombre  ASC, apoderados_listado_hijos.idApoderado ASC, apoderados_listado_hijos.Nombre ASC ";
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
array_push( $arrHijos,$row );
}



?>



<div class="col-sm-12" style="margin-top:15px;margin-bottom:15px;" >

	<?php 
	$ubicacion = $location.'&view=true&facturar=true';
	$dialogo   = '¿Desea ingresar el documento?';?>
	<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary fright margin_width"><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>
									
									
	<a href="<?php echo $location; ?>"  class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

	<?php 
	$ubicacion = $location.'&clear_all=true';
	$dialogo   = '¿Realmente deseas eliminar todos los datos del documento en curso?';?>
	<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger fright margin_width"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

	<div class="clearfix"></div>
</div>


<div class="col-sm-11 fcenter table-responsive">

	<div id="page-wrap">
		<div id="header"> Ingreso Datos </div>
	   

		<div id="customer">


			<table id="meta" class="fleft otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&view=true&moddatos=true' ?>" class="btn btn-xs btn-primary fright">Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td><?php echo Fecha_estandar($_SESSION['basicos']['fCreacion']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Creador</td>
						<td><?php echo $rowCreador['Nombre']?></td>
					</tr>
					<tr>
						<td class="meta-head">Sistema</td>
						<td><?php echo $rowSistema['Nombre']?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td><?php echo Fecha_estandar($_SESSION['basicos']['Fecha']);?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table id="items">
			<tbody>
				
				<tr>
					<th colspan="3">Detalle</th>
					<th width="120" style="width:120px;">
						<a href="<?php echo $location.'&view=true&addclientall=true' ?>" class="btn btn-xs btn-primary fright" style="margin-right:10px;">Agregar Todos</a>
					</th>
				</tr>		  
				
				<?php if (isset($_SESSION['hijos'])){ ?>
					
					<tr class="item-row linea_punteada" bgcolor="#F0F0F0">
						<td class="item-name"><strong>Vehiculo</strong></td>
						<td class="item-name"><strong>Apoderado</strong></td>
						<td class="item-name"><strong>Hijo</strong></td>
						<td width="120"  style="width:120px;"><strong>Acciones</strong></td>
					</tr>
					
		

					<?php 
					//recorro el lsiatdo entregado por la base de datos
					foreach ($arrHijos as $hijo) { 
						foreach ($_SESSION['hijos'] as $key => $clientes){
							if($hijo['idHijos']==$clientes['idHijos']){?>
								<tr class="item-row linea_punteada">

									<td class="item-name"><?php echo $hijo['VehiculoNombre'].' Patente '.$hijo['VehiculoPatente']; ?></td>
									<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
									<td class="item-name"><?php echo $hijo['HijoNombre'].' '.$hijo['HijoApellidoPat'].' '.$hijo['HijoApellidoMat']; ?></td>
									
									<td width="120" style="width:120px;">
										<div class="btn-group" style="width: 70px;" >
											<a href="<?php echo 'view_apoderado.php?view='.$hijo['idApoderado'] ?>" title="Ver Datos Apoderado" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
											<?php 
											$ubicacion = $location.'&view=true&del_cliente='.simpleEncode($hijo['idHijos'], fecha_actual());
											$dialogo   = '¿Realmente deseas eliminar el dato '.$hijo['HijoNombre'].' '.$hijo['HijoApellidoPat'].' '.$hijo['HijoApellidoMat'].'?';?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Cliente" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>							
										</div>
									</td>
								</tr> 
					  <?php }
						}
					}?>

					<tr id="hiderow"><td colspan="4"></td></tr>
				<?php } ?>
				
				
				<tr>
					<td colspan="4" class="blank"> 
						<p>
							<?php 
							if(isset($_SESSION['basicos']['Observaciones'])&&$_SESSION['basicos']['Observaciones']!=''){
								echo $_SESSION['basicos']['Observaciones'];
							}else{
								echo 'Sin Observaciones';
							}?>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="4" class="blank"><p>Observaciones</p></td> 
				</tr>
			</tbody>
		</table>
			<div class="clearfix"></div>
			
		</div>

</div>

<?php widget_modal(80, 95); ?>


	
	
<div class="clearfix"></div>


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}elseif ( ! empty($_GET['new']) ) { ?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Facturacion</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
        	
				<?php 
				//Se verifican si existen los datos
				if(isset($Fecha)) {            $x1  = $Fecha;            }else{$x1  = '';}
				if(isset($Observaciones)) {    $x2  = $Observaciones;    }else{$x2  = '';}
				if(isset($idSistema)) {        $x3  = $idSistema;        }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 2);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);
				
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', 1, 2);
				$Form_Inputs->form_input_hidden('fCreacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idTransporte', $_SESSION['usuario']['basic_data']['idTransporte'], 2);
				
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
	$comienzo = 0 ;
	$num_pag = 1 ;
} else {
	$comienzo = ( $num_pag - 1 ) * $cant_reg ;
}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'fechacreacion_asc':  $order_by = 'ORDER BY vehiculos_facturacion_listado.fCreacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ascendente'; break;
		case 'fechacreacion_desc': $order_by = 'ORDER BY vehiculos_facturacion_listado.fCreacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Creacion Descendente';break;
		case 'fechafact_asc':      $order_by = 'ORDER BY vehiculos_facturacion_listado.Fecha ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Facturacion Ascendente';break;
		case 'fechafact_desc':     $order_by = 'ORDER BY vehiculos_facturacion_listado.Fecha DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';break;
		case 'creador_asc':        $order_by = 'ORDER BY usuarios_listado.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Creador Ascendente';break;
		case 'creador_desc':       $order_by = 'ORDER BY usuarios_listado.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Creador Descendente';break;
		
		default: $order_by = 'ORDER BY vehiculos_facturacion_listado.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';
	}
}else{
	$order_by = 'ORDER BY vehiculos_facturacion_listado.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Facturacion Descendente';
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE vehiculos_facturacion_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
//Verifico el tipo de usuario que esta ingresando
$z.=" AND vehiculos_facturacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];	

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Fecha']) && $_GET['Fecha'] != ''){                  $z .= " AND vehiculos_facturacion_listado.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['Observaciones']) && $_GET['Observaciones'] != ''){  $z .= " AND vehiculos_facturacion_listado.Observaciones LIKE '%".$_GET['Observaciones']."%'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idFacturacion FROM `vehiculos_facturacion_listado` ".$z;
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
// Se trae un listado con todos los elementos
$arrDatos = array();
$query = "SELECT 
vehiculos_facturacion_listado.idFacturacion,
vehiculos_facturacion_listado.fCreacion,
vehiculos_facturacion_listado.Fecha

FROM `vehiculos_facturacion_listado`


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
array_push( $arrDatos,$row );
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
	
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Facturacion</a>

</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($Fecha)) {            $x1  = $Fecha;            }else{$x1  = '';}
				if(isset($Observaciones)) {    $x2  = $Observaciones;    }else{$x2  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha de Facturacion','Fecha', $x1, 1);
				$Form_Inputs->form_textarea('Observaciones', 'Observaciones', $x2, 1);
				
				
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Facturaciones</h5>
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
							<div class="pull-left">Fecha Creacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechacreacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechacreacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Facturacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechafact_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechafact_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>	
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrDatos as $cont) { ?>
					<tr class="odd">
						<td><?php echo Fecha_estandar($cont['fCreacion']); ?></td>
						<td><?php echo Fecha_estandar($cont['Fecha']); ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo 'view_vehiculos_facturacion_listado.php?view='.$cont['idFacturacion']; ?>" title="Ver Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>							
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
<?php } ?>           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>
