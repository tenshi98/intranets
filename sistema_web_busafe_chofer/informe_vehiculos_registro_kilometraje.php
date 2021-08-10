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
$original = "informe_vehiculos_registro_kilometraje.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Kilometros Recorridos';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['submit_filter']) ) { 

//se verifica si se ingreso la hora, es un dato optativo
$z='';
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''&&isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''&&isset($_GET['h_termino'])&&$_GET['h_termino']!=''){
	$z.="WHERE (TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''){
	$z.="WHERE (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//Se traen todos los registros
$arrRutas = array();
$query = "SELECT 
vehiculos_listado.Nombre AS NombreEquipo,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idTabla,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".FechaSistema,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".HoraSistema,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".GeoVelocidad,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".GeoMovimiento

FROM `vehiculos_listado_tablarelacionada_".$_GET['idVehiculo']."`
LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idVehiculo

".$z;
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
array_push( $arrRutas,$row );
}

//cuento la cantidad de registros obtenidos
$cant = 0;
$Kilometros = 0;
foreach ($arrRutas as $fac) {
	$cant++;
	$Kilometros = $Kilometros + $fac['GeoMovimiento'];
}
?>	

<div class="row">    
		
		<div class="col-sm-3">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Kilometros Recorridos</h3>

				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-tachometer" aria-hidden="true"></i></span>
						<span><?php echo Cantidades($Kilometros, 2) ?></span>
						Kilometros
					</div>
				</div>
			</div>
		</div>
		
		
		
	</div>
	
	
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5> Graficos </h5>
			
		</header>
		<div class="table-responsive">
			
			
			<script>
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Fecha'); 
					
					<?php $Colors  = "'#FFB347'"; ?>
					data.addColumn('number', 'Medicion');
					<?php if(isset($cant)&&$cant<30){?>
					data.addColumn({type: 'string', role: 'annotation'});
					<?php } ?>
			
					data.addRows([
					<?php foreach ($arrRutas as $fac) { 
						$chain  = "'".Fecha_estandar($fac['FechaSistema'])."'";
						$chain .= ", ".$fac['GeoMovimiento'];
						if(isset($cant)&&$cant<30){    $chain .= ",'".Cantidades_decimales_justos($fac['GeoMovimiento'])."'";}	
					?>	
						[<?php echo $chain; ?>],
					<?php } ?>
					  
					]);

					var options = {
						title: 'Informe Kilometros Recorridos equipo <?php echo $arrRutas[0]['NombreEquipo']; ?> ',
						hAxis: { 
							title: 'Fechas',
							<?php if(isset($cant)&&$cant>=30){?> 
								baselineColor: '#fff',
								gridlineColor: '#fff',
								textPosition: 'none'
							<?php } ?>
						},
						vAxis: { title: 'Medicion' },
						curveType: 'function',
						//puntos dentro de las curvas
						series: {
							0: {
								pointsVisible: true
							},
							 
						},
      	
						annotations: {
									  alwaysOutside: true,
									  textStyle: {
										fontSize: 14,
										color: '#000',
										auraColor: 'none'
									  }
									},
						colors: [<?php echo $Colors; ?>]
					};

					var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));

					chart.draw(data, options);
				}

			</script> 
			<div id="curve_chart1" style="height: 500px"></div>
						
		</div>
	</div>
</div>


<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Informe Kilometros Recorridos equipo <?php echo $arrRutas[0]['NombreEquipo']; ?></h5>
			
		</header>
		<div class="table-responsive"> 
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Fecha</th>
						<th>Hora</th>
						<th>Velocidad</th>
						<th>Kilometros Recorridos</th>
						<th>Ubicacion</th> 
					</tr>
				</thead>
			  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrRutas as $rutas) { ?>
					<tr class="odd">
						<td><?php echo $rutas['FechaSistema']; ?></td>
						<td><?php echo $rutas['HoraSistema'].' hrs'; ?></td>
						<td><?php echo Cantidades($rutas['GeoVelocidad'], 4).' KM/h'; ?></td>
						<td><?php echo Cantidades($rutas['GeoMovimiento'], 4).' KM'; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo 'informe_vehiculos_registro_kilometraje_view.php?idVehiculo='.$_GET['idVehiculo'].'&view='.$rutas['idTabla']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>                     
				</tbody>
			</table>
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
				if(isset($h_inicio)) {      $x3  = $h_inicio;     }else{$x3  = '';}
				if(isset($h_termino)) {     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idVehiculo)) {    $x5  = $idVehiculo;   }else{$x5  = '';}
				
				//Si es redireccionado desde otra pagina con datos precargados
				if(isset($_GET['view'])&&$_GET['view']!='') { $x5  = $_GET['view']; }
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 1, 1);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x5, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
				
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
