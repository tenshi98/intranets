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
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "buscar_peligros.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-ban" aria-hidden="true"></i> Buscar Zonas Peligrosas';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['pagina']) && $_GET['pagina'] != ''){          $location .= "?pagina=".$_GET['pagina'];}
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){          $location .= "&idTipo=".$_GET['idTipo'];          $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad'] != ''){      $location .= "&idCiudad=".$_GET['idCiudad'];      $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna'] != ''){      $location .= "&idComuna=".$_GET['idComuna'];      $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['f_inicio']) && $_GET['f_inicio'] != ''){      $location .= "&f_inicio=".$_GET['f_inicio'];      $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino'] != ''){    $location .= "&f_termino=".$_GET['f_termino'];    $search .= "&f_termino=".$_GET['f_termino'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
if ( ! empty($_GET['submit_filter']) ) { 
//Se inicializa el paginador de resultados
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
	$comienzo = 0 ;
	$num_pag = 1 ;
} else {
	$comienzo = ( $num_pag - 1 ) * $cant_reg ;
}
/**********************************************************/
//Variable de busqueda
$z  = "WHERE seg_vecinal_peligros_listado.idEstado='1'";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){            $z .= " AND seg_vecinal_peligros_listado.idTipo='".$_GET['idTipo']."'";}
if(isset($_GET['idCiudad']) && $_GET['idCiudad'] != ''){        $z .= " AND seg_vecinal_peligros_listado.idCiudad='".$_GET['idCiudad']."'";}
if(isset($_GET['idComuna']) && $_GET['idComuna'] != ''){        $z .= " AND seg_vecinal_peligros_listado.idComuna='".$_GET['idComuna']."'";}
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''){
	$z.=" AND seg_vecinal_peligros_listado.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idPeligro FROM `seg_vecinal_peligros_listado` ".$z;
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
$arrPeligros = array();
$query = "SELECT 
seg_vecinal_peligros_listado.idPeligro,
seg_vecinal_peligros_listado.Direccion,
seg_vecinal_peligros_listado.Fecha,
seg_vecinal_peligros_listado.Hora,

seg_vecinal_peligros_tipos.Nombre AS Tipo,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
seg_vecinal_peligros_listado.idEstado,
core_estados.Nombre AS Estado

FROM `seg_vecinal_peligros_listado`
LEFT JOIN `seg_vecinal_peligros_tipos`  ON seg_vecinal_peligros_tipos.idTipo  = seg_vecinal_peligros_listado.idTipo
LEFT JOIN `core_ubicacion_ciudad`       ON core_ubicacion_ciudad.idCiudad     = seg_vecinal_peligros_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`      ON core_ubicacion_comunas.idComuna    = seg_vecinal_peligros_listado.idComuna
LEFT JOIN `core_estados`                ON core_estados.idEstado              = seg_vecinal_peligros_listado.idEstado

".$z."
ORDER BY seg_vecinal_peligros_listado.idEstado ASC, seg_vecinal_peligros_listado.Fecha DESC, seg_vecinal_peligros_listado.Hora DESC
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
array_push( $arrPeligros,$row );
}	 
?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Zonas de Peligros</h5>
			<div class="toolbar">
				<?php 
				//paginacion
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">    
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Tipo</th>
						<th>Ubicacion</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrPeligros as $eve) { ?>
						<tr class="odd">
							<td><?php echo $eve['Tipo']; ?></td>
							<td><?php echo $eve['Direccion'].', '.$eve['Comuna'].', '.$eve['Ciudad']; ?></td>
							<td><?php echo fecha_estandar($eve['Fecha']); ?></td>
							<td><?php echo $eve['Hora']; ?></td>
							<td><label class="label <?php if(isset($eve['idEstado'])&&$eve['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $eve['Estado']; ?></label></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_peligro_listado.php?view='.simpleEncode($eve['idPeligro'], fecha_actual()); ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>                    
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			//paginacion
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
 } else  {  ?>

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
				if(isset($idTipo)) {      $x1 = $idTipo;      }else{$x1  = '';}
				if(isset($idCiudad)) {    $x2 = $idCiudad;    }else{$x2  = '';}
				if(isset($idComuna)) {    $x3 = $idComuna;    }else{$x3  = '';}
				if(isset($f_inicio)) {    $x4 = $f_inicio;    }else{$x4  = '';}
				if(isset($f_termino)) {   $x5 = $f_termino;   }else{$x5  = '';}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Peligro','idTipo', $x1, 1, 'idTipo', 'Nombre', 'seg_vecinal_peligros_tipos', 0, '',$dbConn);
				$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x2, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
												  'Comuna','idComuna', $x3, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
												  $dbConn, 'form1');
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x4, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x5, 2);
						
				$Form_Inputs->form_input_hidden('pagina', 1, 2);
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
