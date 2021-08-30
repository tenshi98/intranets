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
$original = "informe_vehiculos_detenciones.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Detenciones';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['submit_filter']) ) { 

//tomo el numero de la pagina si es que este existe
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
//Inicia variable
$z="WHERE vehiculos_listado_error_detenciones.idDetencion>0";
$search  = '?idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search .='&submit_filter=Filtrar';
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''){
	$z.=" AND vehiculos_listado_error_detenciones.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$search .='&f_inicio='.$_GET['f_inicio'].'&f_termino='.$_GET['f_termino'];
}
//verifico si se selecciono un equipo
if(isset($_GET['idVehiculo'])&&$_GET['idVehiculo']!=''){
	$z.=" AND vehiculos_listado_error_detenciones.idVehiculo='".$_GET['idVehiculo']."'";
	$search .='&idVehiculo='.$_GET['idVehiculo'];
}
//Verifico el tipo de usuario que esta ingresando
$z.=" AND vehiculos_listado_error_detenciones.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];		
$z.=" AND vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT vehiculos_listado_error_detenciones.idDetencion FROM `vehiculos_listado_error_detenciones`  LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_error_detenciones.idVehiculo ".$z;
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
$arrErrores = array();
$query = "SELECT 
vehiculos_listado_error_detenciones.idDetencion,
vehiculos_listado_error_detenciones.Fecha, 
vehiculos_listado_error_detenciones.Hora, 
vehiculos_listado_error_detenciones.Tiempo,
vehiculos_listado.Nombre AS NombreEquipo

FROM `vehiculos_listado_error_detenciones`
LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_error_detenciones.idVehiculo
".$z."
ORDER BY idDetencion DESC
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
array_push( $arrErrores,$row );
}

 ?>	

<div class="col-sm-12">
	<a target="new" href="<?php echo 'informe_vehiculos_detenciones_to_excel.php'.$search.'&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']; ?>" class="btn btn-sm btn-metis-2 fright margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	<a target="new" href="<?php echo 'informe_vehiculos_detenciones_to_pdf.php'.$search.'&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']; ?>" class="btn btn-sm btn-metis-3 fright margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
</div>

<div class="col-sm-12">
	<div class="box">	
		<header>		
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Fuera de Linea</h5>	
			<div class="toolbar">
				<?php 
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">    
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre Equipo</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Tiempo Detenido</th>
						<th>Ubicacion</th> 
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ( $arrErrores as $error ) { ?>
						<tr>
							<td><?php echo $error['NombreEquipo']; ?></td>
							<td><?php echo fecha_estandar($error['Fecha']); ?></td>
							<td><?php echo $error['Hora'].' hrs'; ?></td>
							<td><?php echo $error['Tiempo'].' hrs'; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_detenciones.php?view='.$error['idDetencion']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>				                 
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>


<?php widget_modal(80, 95); ?>
	


<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
			
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
//Verifico el tipo de usuario que esta ingresando
$w  = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$w .= " AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];

 ?>			
	<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Filtro de busqueda</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" action="<?php echo $location ?>" id="form1" name="form1" novalidate>
               
				<?php 
				//Se verifican si existen los datos
				if(isset($f_inicio)) {      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($f_termino)) {     $x2  = $f_termino;    }else{$x2  = '';}
				if(isset($idVehiculo)) {    $x3  = $idVehiculo;   }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x3, 1, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
				
				?>        
	   
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Filtrar" name="submit_filter">	
				</div>
			</form>
			<?php widget_validator(); ?> 
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
