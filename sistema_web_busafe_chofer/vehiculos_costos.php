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
$original = "vehiculos_costos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){                  $location .= "&idTipo=".$_GET['idTipo'];                  $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idVehiculo']) && $_GET['idVehiculo'] != ''){          $location .= "&idVehiculo=".$_GET['idVehiculo'];          $search .= "&idVehiculo=".$_GET['idVehiculo'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha'] != ''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];  $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['Valor']) && $_GET['Valor'] != ''){                    $location .= "&Valor=".$_GET['Valor'];                    $search .= "&Valor=".$_GET['Valor'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones'] != ''){    $location .= "&Observaciones=".$_GET['Observaciones'];    $search .= "&Observaciones=".$_GET['Observaciones'];}
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Costos Asociados';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';
}
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_costos.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Costo Creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Costo Modificado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Costo borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];

// consulto los datos
$query = "SELECT idTipo,idVehiculo,Creacion_fecha,Valor,Observaciones
FROM `vehiculos_costos`
WHERE idCosto = ".$_GET['id'];
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
$rowdata = mysqli_fetch_assoc ($resultado);	?>
 
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificacion Costo</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
			
				<?php 
				//Se verifican si existen los datos
				if(isset($idTipo)) {             $x1  = $idTipo;            }else{$x1  = $rowdata['idTipo'];}
				if(isset($idVehiculo)) {         $x2  = $idVehiculo;        }else{$x2  = $rowdata['idVehiculo'];}
				if(isset($Creacion_fecha)) {     $x3  = $Creacion_fecha;    }else{$x3  = $rowdata['Creacion_fecha'];}
				if(isset($Valor)) {              $x4  = $Valor;             }else{$x4  = $rowdata['Valor'];}
				if(isset($Observaciones)) {      $x5  = $Observaciones;     }else{$x5  = $rowdata['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 2, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '',$dbConn);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '',$dbConn);
				$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 2);
				$Form_Inputs->form_values('Valor', 'Valor', $x4, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);
				
				$Form_Inputs->form_input_hidden('idCosto', $_GET['id'], 2);
				?>
				

				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit"> 
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['new']) ) { 
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Costo</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
        	
				<?php 
				//Se verifican si existen los datos
				if(isset($idTipo)) {             $x1  = $idTipo;            }else{$x1  = '';}
				if(isset($idVehiculo)) {         $x2  = $idVehiculo;        }else{$x2  = '';}
				if(isset($Creacion_fecha)) {     $x3  = $Creacion_fecha;    }else{$x3  = '';}
				if(isset($Valor)) {              $x4  = $Valor;             }else{$x4  = '';}
				if(isset($Observaciones)) {      $x5  = $Observaciones;     }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 2, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '',$dbConn);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '',$dbConn);
				$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 2);
				$Form_Inputs->form_values('Valor', 'Valor', $x4, 2);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);
				
				$Form_Inputs->form_input_hidden('idUsuario', 1, 2);
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
		case 'fecha_asc':     $order_by = 'ORDER BY vehiculos_costos.Creacion_fecha ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
		case 'fecha_desc':    $order_by = 'ORDER BY vehiculos_costos.Creacion_fecha DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
		case 'tipo_asc':      $order_by = 'ORDER BY vehiculos_costos_tipo.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':     $order_by = 'ORDER BY vehiculos_costos_tipo.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'vehiculo_asc':  $order_by = 'ORDER BY vehiculos_listado.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vehiculo Ascendente'; break;
		case 'vehiculo_desc': $order_by = 'ORDER BY vehiculos_listado.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vehiculo Descendente';break;
		case 'valor_asc':     $order_by = 'ORDER BY vehiculos_costos.Valor ASC ';             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Valor Ascendente';break;
		case 'valor_desc':    $order_by = 'ORDER BY vehiculos_costos.Valor DESC ';            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Valor Descendente';break;
		
		default: $order_by = 'ORDER BY vehiculos_costos.Creacion_fecha ASC, vehiculos_costos_tipo.Nombre ASC, vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha, Tipo, Vehiculo Ascendente';
	}
}else{
	$order_by = 'ORDER BY vehiculos_costos.Creacion_fecha ASC, vehiculos_costos_tipo.Nombre ASC, vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha, Tipo, Vehiculo Ascendente';
}
/**********************************************************/
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];

/**********************************************************/
//Variable de busqueda
$z = "WHERE vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){                  $z .= " AND vehiculos_costos_tipo.idTipo=".$_GET['idTipo'];}
if(isset($_GET['idVehiculo']) && $_GET['idVehiculo'] != ''){          $z .= " AND vehiculos_costos_tipo.idVehiculo=".$_GET['idVehiculo'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha'] != ''){  $z .= " AND vehiculos_costos_tipo.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['Valor']) && $_GET['Valor'] != ''){                    $z .= " AND vehiculos_costos_tipo.Valor LIKE '%".$_GET['Valor']."%'";}
if(isset($_GET['Observaciones']) && $_GET['Observaciones'] != ''){    $z .= " AND vehiculos_costos_tipo.Observaciones LIKE '%".$_GET['Observaciones']."%'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idCosto FROM `vehiculos_costos` LEFT JOIN `vehiculos_listado`       ON vehiculos_listado.idVehiculo   = vehiculos_costos.idVehiculo ".$z;
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
$arrCategorias = array();
$query = "SELECT 
vehiculos_costos.idCosto,
vehiculos_costos_tipo.Nombre AS Tipo,
vehiculos_listado.Nombre AS VehiculoNombre,
vehiculos_listado.Patente AS VehiculoPatente,
vehiculos_costos.Creacion_fecha,
vehiculos_costos.Valor

FROM `vehiculos_costos`
LEFT JOIN `vehiculos_costos_tipo`   ON vehiculos_costos_tipo.idTipo   = vehiculos_costos.idTipo
LEFT JOIN `vehiculos_listado`       ON vehiculos_listado.idVehiculo   = vehiculos_costos.idVehiculo
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
array_push( $arrCategorias,$row );
}?>

<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Costo</a>

</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($idTipo)) {             $x1  = $idTipo;            }else{$x1  = '';}
				if(isset($idVehiculo)) {         $x2  = $idVehiculo;        }else{$x2  = '';}
				if(isset($Creacion_fecha)) {     $x3  = $Creacion_fecha;    }else{$x3  = '';}
				if(isset($Valor)) {              $x4  = $Valor;             }else{$x4  = '';}
				if(isset($Observaciones)) {      $x5  = $Observaciones;     }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Costo','idTipo', $x1, 1, 'idTipo', 'Nombre', 'vehiculos_costos_tipo', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x2, 1, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha','Creacion_fecha', $x3, 1);
				$Form_Inputs->form_values('Valor', 'Valor', $x4, 1);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x5, 1);
				
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Costos Asociados</h5>
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
						<th width="120">
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Vehiculo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=vehiculo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=vehiculo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Valor</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=valor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=valor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCategorias as $cat) { ?>
					<tr class="odd">
						<td><?php echo fecha_estandar($cat['Creacion_fecha']); ?></td>
						<td><?php echo $cat['Tipo']; ?></td>
						<td><?php echo $cat['VehiculoNombre'].' Patente '.$cat['VehiculoPatente']; ?></td>
						<td><?php echo valores($cat['Valor'], 0); ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_vehiculos_costos.php?view='.$cat['idCosto']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&id='.$cat['idCosto']; ?>" title="Editar Informacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php 
								$ubicacion = $location.'&del='.simpleEncode($cat['idCosto'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar la zona '.$cat['VehiculoNombre'].' Patente '.$cat['VehiculoPatente'].'?';?>
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
