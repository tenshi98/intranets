<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim); }else{set_time_limit(2400);}             
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M'); }else{ini_set('memory_limit', '4096M');}  
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//identificador
$Identif = simpleDecode($_GET['view'], fecha_actual());	
// Se traen todos los datos de mi usuario
$query = "SELECT  
seg_vecinal_peligros_listado.Direccion,
seg_vecinal_peligros_listado.GeoLatitud,
seg_vecinal_peligros_listado.GeoLongitud,
seg_vecinal_peligros_listado.Fecha,
seg_vecinal_peligros_listado.Hora,
seg_vecinal_peligros_listado.Descripcion,

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

WHERE seg_vecinal_peligros_listado.idPeligro = ".$Identif;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
$rowdata = mysqli_fetch_assoc ($resultado);

//Se traen las rutas
$arrArchivos = array();
$query = "SELECT idArchivo, Nombre
FROM `seg_vecinal_peligros_listado_archivos`
WHERE idPeligro = ".$Identif."
ORDER BY Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrArchivos,$row );
}
/************************************************/
//se cuentan los archivos
$N_Archivos = 0;
foreach ($arrArchivos as $zona) {
	$N_Archivos++;
}
?>

<style>.tab-content {min-height: 250px !important;}</style>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos de la Zona de Peligro</h5>
			<div class="toolbar"> </div>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-flag" aria-hidden="true"></i> Datos</a></li>
				<li class=""><a href="#archivos" data-toggle="tab"><span class="label label-danger"><?php echo $N_Archivos; ?></span> <i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos Adjuntos</a></li>
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="col-sm-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-sm-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de la Zona de Peligro</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Peligro : </strong><?php echo $rowdata['Tipo']; ?><br/>
								<strong>Ciudad : </strong><?php echo $rowdata['Ciudad']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowdata['Comuna']; ?><br/>
								<strong>Direccion : </strong><?php echo $rowdata['Direccion']; ?><br/>
								<strong>Fecha : </strong><?php echo fecha_estandar($rowdata['Fecha']); ?><br/>
								<strong>Hora : </strong><?php echo $rowdata['Hora']; ?><br/>
								<strong>Descripcion : </strong><?php echo $rowdata['Descripcion']; ?><br/>
								<strong>Estado : </strong><label class="label <?php if(isset($rowdata['idEstado'])&&$rowdata['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $rowdata['Estado']; ?></label><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<?php 
						//se arma la direccion
						$direccion = "";
						if(isset($rowdata["Direccion"])&&$rowdata["Direccion"]!=''){   $direccion .= $rowdata["Direccion"];}
						if(isset($rowdata["Comuna"])&&$rowdata["Comuna"]!=''){         $direccion .= ', '.$rowdata["Comuna"];}
						if(isset($rowdata["Ciudad"])&&$rowdata["Ciudad"]!=''){         $direccion .= ', '.$rowdata["Ciudad"];}
						//se despliega mensaje en caso de no existir direccion
						if($direccion!=''){
							echo mapa_from_gps($rowdata['GeoLatitud'], $rowdata['GeoLongitud'], 'Zona de Peligro', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 19, 2);
						}else{
							$Alert_Text = 'No tiene una direccion definida';
							alert_post_data(4,2,2, $Alert_Text);
						} ?>
					</div>
				</div>
				<div class="clearfix"></div>
				
			</div>
			
			<div class="tab-pane fade" id="archivos">
				<div class="wmd-panel">
					
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th width="10">Acciones</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($arrArchivos as $zona) { ?>
									<tr class="odd">		
										<td><?php echo $zona['Nombre']; ?></td>	
										<td>
											<div class="btn-group" style="width: 70px;" >
												<a href="view_doc_preview.php?path=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($zona['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<a href="1download.php?dir=<?php echo simpleEncode(DB_SITE_REPO.DB_SITE_ALT_1_PATH.'/upload', fecha_actual()).'&file='.simpleEncode($zona['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
											</div>
										</td>
									</tr>
								<?php } ?>                    
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			
			
        </div>	
	</div>
</div>


<?php 
//si se entrega la opcion de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){ 
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php 
	//para las versiones nuevas que indican donde volver
	}else{ 
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
		
	<?php }		
} ?>


<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
?>
