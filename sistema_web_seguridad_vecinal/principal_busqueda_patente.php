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
$original = "principal_busqueda_patente.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_filter']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'search_patente';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_busqueda_patente.php';
}
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['search']) ) {

//Funcion para conectarse
function conectarDB_EX ($servidor, $usuario, $password, $base_datos) {
	$db_con = mysqli_connect($servidor, $usuario, $password, $base_datos);
	$db_con->set_charset("utf8");
	return $db_con; 
}

//Bases de Datos
//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
	$DB_Servidor = 'localhost';
	$DB_Usuario  = 'root';
	$DB_Pass     = '';
	$BaseDatos   = 'big_data';
//si estoy en ambiente de produccion	
}else{
	$DB_Servidor = 'localhost';
	$DB_Usuario  = 'digit255_admin';
	$DB_Pass     = '24WnUSLE7wd9Xdx';
	$BaseDatos   = 'digit255_big_data';
}

//Conexiones
$dbConn1 = conectarDB_EX($DB_Servidor, $DB_Usuario, $DB_Pass, $BaseDatos);

// consulto los datos
$query = "SELECT 
pu_patentes_listado.PPU,
pu_patentes_listado.DV_PPU,
pu_patentes_listado.AnoFabricacion,
pu_patentes_listado.UltimaTransferencia,
pu_patentes_listado.NumeroMotor,
pu_patentes_listado.NumeroChasis,
pu_patentes_listado.Tasacion,
pu_patentes_listado.RutComparador,
pu_patentes_listado.Prop_Rut_Completo,
pu_patentes_listado.Prop_Rut,
pu_patentes_listado.Prop_Rut_Div,
pu_patentes_listado.Prop_Nombre,

pu_colores_listado.Nombre AS Color,
pu_comunas_listado.Nombre AS Comuna,
pu_marcas_listado.Nombre AS Marca,
pu_modelos_listado.Nombre AS Modelo,
pu_vehiculos_tipo.Nombre AS TipoVehiculo


FROM `pu_patentes_listado`
LEFT JOIN `pu_colores_listado`   ON pu_colores_listado.idColor        = pu_patentes_listado.idColor
LEFT JOIN `pu_comunas_listado`   ON pu_comunas_listado.idComuna       = pu_patentes_listado.idComuna
LEFT JOIN `pu_marcas_listado`    ON pu_marcas_listado.idMarca         = pu_patentes_listado.idMarca
LEFT JOIN `pu_modelos_listado`   ON pu_modelos_listado.idModelo       = pu_patentes_listado.idModelo
LEFT JOIN `pu_vehiculos_tipo`    ON pu_vehiculos_tipo.idTipoVehiculo  = pu_patentes_listado.idTipoVehiculo
WHERE pu_patentes_listado.PPU = '".$_GET['search']."'";
//Consulta
$resultado = mysqli_query ($dbConn1, $query);
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
?>

<div class="col-sm-12 breadcrumb-bar">
	<br/>
	<a href="http://www.prt.cl/Paginas/RevisionTecnica.aspx"                           target="_blank" rel="noopener noreferrer" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-car" aria-hidden="true"></i> Consultar en PRT</a>
	<a href="https://www.autoseguro.gob.cl/"                                           target="_blank" rel="noopener noreferrer" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-car" aria-hidden="true"></i> Consultar encargo robo</a>
	<a href="https://patenteschile.cl/"                                                target="_blank" rel="noopener noreferrer" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-car" aria-hidden="true"></i> Consultar patente</a>
	<a href="https://consultamultas.srcei.cl/ConsultaMultas/consultaMultasExterna.do"  target="_blank" rel="noopener noreferrer" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-car" aria-hidden="true"></i> Consultar de multas</a>
	
</div>
<div class="clearfix"></div> 

<?php if(isset($rowdata['PPU'])&&$rowdata['PPU']!=''){ ?>
	<div class="col-sm-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Datos del Evento</h5>
			</header>
			<div id="div-3" class="tab-content">
				
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Propietario</h2>
							<p class="text-muted word_break">
								<strong>Rut Completo : </strong><?php echo $rowdata['Prop_Rut_Completo']; ?><br/>
								<strong>Nombre Propietario : </strong><?php echo $rowdata['Prop_Nombre']; ?><br/>
							</p>
							
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Vehiculo</h2>
							<p class="text-muted word_break">
								<strong>Tipo Vehiculo : </strong><?php echo $rowdata['TipoVehiculo']; ?><br/>
								<strong>Marca : </strong><?php echo $rowdata['Marca']; ?><br/>
								<strong>Modelo : </strong><?php echo $rowdata['Modelo']; ?><br/>
								<strong>Numero Motor : </strong><?php echo $rowdata['NumeroMotor']; ?><br/>
								<strong>Numero Chasis : </strong><?php echo $rowdata['NumeroChasis']; ?><br/>
								<strong>Color : </strong><?php echo $rowdata['Color']; ?><br/>
								<strong>PPU : </strong><?php echo $rowdata['PPU']; ?><br/>
								<strong>Año Fabricacion Vehiculo : </strong><?php echo $rowdata['AnoFabricacion']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowdata['Comuna']; ?><br/>
								<strong>Ultima Transferencia : </strong><?php echo fecha_estandar($rowdata['UltimaTransferencia']); ?><br/>
								<strong>Tasacion : </strong><?php echo valores($rowdata['Tasacion'], 0); ?><br/>
							</p>
							
						</div>
						<div class="col-sm-6">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Imagenes de referencia</h2>
							<?php
							$s_query = '';
							if(isset($rowdata['Marca'])&&$rowdata['Marca']!=''){                    $s_query .= $rowdata['Marca'];}
							if(isset($rowdata['Modelo'])&&$rowdata['Modelo']!=''){                  $s_query .= '+'.$rowdata['Modelo'];}
							if(isset($rowdata['Color'])&&$rowdata['Color']!=''){                    $s_query .= '+'.$rowdata['Color'];}
							if(isset($rowdata['AnoFabricacion'])&&$rowdata['AnoFabricacion']!=''){  $s_query .= '+'.$rowdata['AnoFabricacion'];}
							//imprimo imagenes
							getGoogleImage($s_query, 10);
							
							?>
							
						</div>	
					</div>
				</div>
				<div class="clearfix"></div>
			</div>	
		</div>
	</div>
<?php }else{ ?>
	<div class="col-sm-12">
		<br/>
		<?php 
		$Alert_Text = 'No hay resultados para la Patente '.$_GET['search'];
		alert_post_data(4,2,2, $Alert_Text);
		?>

	</div>
	<div class="clearfix"></div>
<?php }?>
	
	
<div class="clearfix"></div>
	<div class="col-sm-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>"  class="btn btn-danger fright" style="margin-top:20px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
	
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
} else  { 
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
$z = "WHERE idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idBusqueda FROM `seg_vecinal_busqueda_patente` ".$z;
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
$arrPatentes = array();
$query = "SELECT idBusqueda, Fecha, Hora, Patente
FROM `seg_vecinal_busqueda_patente`
".$z."
ORDER BY Fecha DESC, Hora DESC
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
array_push( $arrPatentes,$row );
}	
//Busqueda
$search = '';

//Verifico cantidad de veces buscadas en el dia
$limite_dia    = 10;
$n_veces_dia   = 0;
$fecha_actual  = fecha_actual();
foreach ($arrPatentes as $eve) {
	if($eve['Fecha']==$fecha_actual){
		$n_veces_dia++;
	}
}

//mientras aun no se cumpla el limite
if($n_veces_dia<$limite_dia){ ?>
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Busqueda</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
				<?php 
				//Se verifican si existen los datos
				if(isset($NSolicitud)) {   $x1  = $NSolicitud;  }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_icon('Patente','Patente', $x1, 2, 'fa fa-search');
				
				$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);		
				$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
						
				?> 

				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Buscar" name="submit_filter"> 
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>
<?php 
//si ya cumplio limite, mostrar mensaje
}else{
	echo '<div class="col-sm-12"><br/>';
	 
		$Alert_Text = 'Limite de consultas diarias alcanzado';
		alert_post_data(4,2,2, $Alert_Text);
	
	echo '</div>';
}?>

<div class="clearfix"></div> 
                                 
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Busqueda de Patentes</h5>
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
						<th>Fecha</th>
						<th>Hora</th>
						<th>Patente</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrPatentes as $eve) { ?>
						<tr class="odd">
							<td><?php echo fecha_estandar($eve['Fecha']); ?></td>
							<td><?php echo $eve['Hora']; ?></td>
							<td><?php echo $eve['Patente']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'&search='.$eve['Patente']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
?>
