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
$original = "pasajeros_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){             $location .= "&Nombre=".$_GET['Nombre'];            $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat'] != ''){   $location .= "&ApellidoPat=".$_GET['ApellidoPat'];  $search .= "&ApellidoPat=".$_GET['ApellidoPat'];}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat'] != ''){   $location .= "&ApellidoMat=".$_GET['ApellidoMat'];  $search .= "&ApellidoMat=".$_GET['ApellidoMat'];}
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Pasajeros';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_hijos.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Pasajero Creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Pasajero Modificado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Pasajero borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
//Obtengo los datos de una observacion
$query = "SELECT Nombre, ApellidoPat, idPlan, idDia_1, idDia_2, idDia_3, idDia_4,
idDia_5, idDia_6, idDia_7, idVehiculo, idVehiculoVuelta
FROM `apoderados_listado_hijos`
WHERE idHijos = ".$_GET['id'];
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

//Variable de busqueda
$z  = "idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
$w  = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$w .= " AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
$w .= " AND idProceso='2' ";
?>

<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Editar Pasajero <?php echo $rowdata['Nombre'].' '.$rowdata['ApellidoPat']; ?></h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>

				<?php 
				//Se verifican si existen los datos
				if(isset($idVehiculo)) {         $x1  = $idVehiculo;        }else{$x1  = $rowdata['idVehiculo'];}
				if(isset($idVehiculoVuelta)) {   $x2  = $idVehiculoVuelta;  }else{$x2  = $rowdata['idVehiculoVuelta'];}
				if(isset($idPlan)) {             $x3  = $idPlan;            }else{$x3  = $rowdata['idPlan'];}
				
				if(isset($idDia_1)) {            $x4  = $idDia_1;           }else{$x4  = $rowdata['idDia_1'];}
				if(isset($idDia_2)) {            $x4 .= ','.$idDia_2;       }else{$x4 .= ','.$rowdata['idDia_2'];}
				if(isset($idDia_3)) {            $x4 .= ','.$idDia_3;       }else{$x4 .= ','.$rowdata['idDia_3'];}
				if(isset($idDia_4)) {            $x4 .= ','.$idDia_4;       }else{$x4 .= ','.$rowdata['idDia_4'];}
				if(isset($idDia_5)) {            $x4 .= ','.$idDia_5;       }else{$x4 .= ','.$rowdata['idDia_5'];}
				if(isset($idDia_6)) {            $x4 .= ','.$idDia_6;       }else{$x4 .= ','.$rowdata['idDia_6'];}
				if(isset($idDia_7)) {            $x4 .= ','.$idDia_7;       }else{$x4 .= ','.$rowdata['idDia_7'];}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				echo '<h3>Transporte</h3>';
				$Form_Inputs->form_select('Vehiculo Ida','idVehiculo', $x1, 1, 'idVehiculo', 'Patente', 'vehiculos_listado', $w, '', $dbConn);
				$Form_Inputs->form_select('Vehiculo Vuelta','idVehiculoVuelta', $x2, 1, 'idVehiculo', 'Patente', 'vehiculos_listado', $w, '', $dbConn);
				
				//$Form_Inputs->form_select_filter('Vehiculo Ida','idVehiculo', $x1, 1, 'idVehiculo', 'Patente', 'vehiculos_listado', $w, '',$dbConn);
				//$Form_Inputs->form_select_filter('Vehiculo Vuelta','idVehiculoVuelta', $x2, 1, 'idVehiculo', 'Patente', 'vehiculos_listado', $w, '',$dbConn);
				
				echo '<h3>Plan</h3>';
				$Form_Inputs->form_select('Plan Contratado','idPlan', $x3, 2, 'idPlan', 'Nombre', 'sistema_planes', $z, '', $dbConn);
				$Form_Inputs->form_input_disabled('Valor Plan','valor_plan', 0, 1);
				echo '<h3>Periodicidad</h3>';
				$Form_Inputs->form_checkbox_active('Dias','idDia', $x4, 2, 'idDia', 'Nombre', 'core_tiempo_dias', 0, $dbConn);
				
				$Form_Inputs->form_input_hidden('idHijos', $_GET['id'], 2);
				
				
				$arrPlanes = array();
				$query = "SELECT idPlan, Valor
				FROM `sistema_planes`
				ORDER BY idPlan ASC";
				$resultado = mysqli_query($dbConn, $query);
				while ( $row = mysqli_fetch_assoc ($resultado)) {
				array_push( $arrPlanes,$row );
				}
				
				$cadena = '';			
				$cadena .= '<script>';
				foreach ($arrPlanes as $plan) {
					$cadena .= 'var id_data_'.$plan['idPlan'].'= "'.valores($plan['Valor'], 0).'";';	
				}
				$cadena .= '</script>';
				
				$cadena .= '
				<script>
					//se ejecuta al cargar la página (OBLIGATORIO)
					$(document).ready(function(){ 
						var Sensores_val_1;
						Sensores_val_1= $("#idPlan").val();
						if (Sensores_val_1 != "") {
							id_data1=eval("id_data_" + Sensores_val_1)
							//escribo dentro del input
							var elem1 = document.getElementById("valor_plan");
							elem1.value = id_data1;
						}
					});
					
					
					document.getElementById("idPlan").onchange = function() {myFunction_idPlan()};

					function myFunction_idPlan() {
						var Componente = document.getElementById("idPlan").value;
						if (Componente != "") {
							id_data1=eval("id_data_" + Componente)
							//escribo dentro del input
							var elem1 = document.getElementById("valor_plan");
							elem1.value = id_data1;
						}
					}
				</script>
				';
				
				//se imprime funcion
				echo $cadena;
				
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
		case 'pasajero_asc':           $order_by = 'ORDER BY apoderados_listado_hijos.ApellidoPat ASC, apoderados_listado_hijos.ApellidoMat ASC, apoderados_listado_hijos.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Pasajero Ascendente'; break;
		case 'pasajero_desc':          $order_by = 'ORDER BY apoderados_listado_hijos.ApellidoPat DESC, apoderados_listado_hijos.ApellidoMat DESC, apoderados_listado_hijos.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Pasajero Descendente';break;
		case 'apoderado_asc':          $order_by = 'ORDER BY apoderados_listado.ApellidoPat ASC, apoderados_listado.ApellidoMat ASC, apoderados_listado.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Apoderado Ascendente'; break;
		case 'apoderado_desc':         $order_by = 'ORDER BY apoderados_listado.ApellidoPat DESC, apoderados_listado.ApellidoMat DESC, apoderados_listado.Nombre DESC ';                     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Apoderado Descendente';break;
		case 'direccion_asc':          $order_by = 'ORDER BY core_ubicacion_ciudad.Nombre ASC, core_ubicacion_comunas.Nombre ASC, apoderados_listado.Direccion ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Direccion Ascendente'; break;
		case 'direccion_desc':         $order_by = 'ORDER BY core_ubicacion_ciudad.Nombre DESC, core_ubicacion_comunas.Nombre DESC, apoderados_listado.Direccion DESC ';                     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Direccion Descendente';break;
		case 'vehiculo_ida_asc':       $order_by = 'ORDER BY vehiculos_listado.Patente ASC';                                                                                                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vehiculo Ascendente'; break;
		case 'vehiculo_ida_desc':      $order_by = 'ORDER BY vehiculos_listado.Patente DESC';                                                                                                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vehiculo Descendente';break;
		case 'vehiculo_vuelta_asc':    $order_by = 'ORDER BY VehiculoVuelta.Patente ASC';                                                                                                    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vehiculo Ascendente'; break;
		case 'vehiculo_vuelta_desc':   $order_by = 'ORDER BY VehiculoVuelta.Patente DESC';                                                                                                   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vehiculo Descendente';break;
		case 'plan_asc':               $order_by = 'ORDER BY sistema_planes.Nombre ASC';                                                                                                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Plan Ascendente'; break;
		case 'plan_desc':              $order_by = 'ORDER BY sistema_planes.Nombre DESC';                                                                                                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Plan Descendente';break;
		
		default: $order_by = 'ORDER BY apoderados_listado_hijos.ApellidoPat ASC, apoderados_listado_hijos.ApellidoMat ASC, apoderados_listado_hijos.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Pasajero Ascendente';
	}
}else{
	$order_by = 'ORDER BY apoderados_listado_hijos.ApellidoPat ASC, apoderados_listado_hijos.ApellidoMat ASC, apoderados_listado_hijos.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Pasajero Ascendente';
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE (vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte']." OR VehiculoVuelta.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'].") ";

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){            $z .= " AND apoderados_listado_hijos.Nombre LIKE '%".$_GET['Nombre']."%'";}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat'] != ''){  $z .= " AND apoderados_listado_hijos.ApellidoPat LIKE '%".$_GET['ApellidoPat']."%'";}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat'] != ''){  $z .= " AND apoderados_listado_hijos.ApellidoMat LIKE '%".$_GET['ApellidoMat']."%'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idHijos FROM `apoderados_listado_hijos` 
LEFT JOIN `vehiculos_listado`                ON vehiculos_listado.idVehiculo   = apoderados_listado_hijos.idVehiculo 
LEFT JOIN `vehiculos_listado` VehiculoVuelta ON VehiculoVuelta.idVehiculo      = apoderados_listado_hijos.idVehiculoVuelta
".$z;
$registros = mysqli_query($dbConn, $query);
$cuenta_registros = mysqli_num_rows($registros);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);	
// Se trae un listado con todos los usuarios
$arrTrabajador = array();
$query = "SELECT 
apoderados_listado_hijos.idHijos,
apoderados_listado_hijos.Nombre AS PasajeroNombre, 
apoderados_listado_hijos.ApellidoPat AS PasajeroApellidoPat, 

apoderados_listado_hijos.idApoderado,
apoderados_listado.Nombre AS ApoderadoNombre, 
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat, 
core_ubicacion_ciudad.Nombre AS ApoderadoCiudad, 
core_ubicacion_comunas.Nombre AS ApoderadoComuna,
apoderados_listado.Direccion AS ApoderadoDireccion,  
core_estados.Nombre AS Estado,
apoderados_listado.idEstado,

vehiculos_listado.Patente AS VehiculoIda,
VehiculoVuelta.Patente AS VehiculoVuelta,

sistema_planes.Nombre AS PlanNombre,
sistema_planes.Valor AS PlanValor

FROM `apoderados_listado_hijos`
LEFT JOIN `sistema_planes`                   ON sistema_planes.idPlan             = apoderados_listado_hijos.idPlan
LEFT JOIN `vehiculos_listado`                ON vehiculos_listado.idVehiculo      = apoderados_listado_hijos.idVehiculo
LEFT JOIN `vehiculos_listado` VehiculoVuelta ON VehiculoVuelta.idVehiculo         = apoderados_listado_hijos.idVehiculoVuelta
LEFT JOIN `apoderados_listado`               ON apoderados_listado.idApoderado    = apoderados_listado_hijos.idApoderado
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad    = apoderados_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna   = apoderados_listado.idComuna
LEFT JOIN `core_estados`                     ON core_estados.idEstado             = apoderados_listado.idEstado
".$z."
".$order_by."
LIMIT $comienzo, $cant_reg ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrTrabajador,$row );
}?>
<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	

</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($Rut)) {                 $x4  = $Rut;                  }else{$x4  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 1);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 1);
				
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 2);
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Pasajeros</h5>
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
						<th colspan="3" style="text-align:center;">Datos del Apoderado</th>
						<th colspan="3" style="text-align:center;">Datos del Transporte</th>
						<th style="text-align:center;">Sistema</th>
						<th></th>
					</tr>
					<tr role="row">
						<th>
							<div class="pull-left">Pasajero</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=pasajero_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=pasajero_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Apoderado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=apoderado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=apoderado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Direccion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=direccion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=direccion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Vehiculo Ida</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=vehiculo_ida_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=vehiculo_ida_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Vehiculo Vuelta</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=vehiculo_vuelta_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=vehiculo_vuelta_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Plan</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=plan_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=plan_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
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
				<?php foreach ($arrTrabajador as $trab) { ?>
					<tr class="odd">
						<td><?php echo $trab['PasajeroApellidoPat'].' '.$trab['PasajeroNombre']; ?></td>
						<td><?php echo $trab['ApoderadoApellidoPat'].' '.$trab['ApoderadoNombre']; ?></td>
						<td><?php echo $trab['ApoderadoCiudad'].', '.$trab['ApoderadoComuna'].', '.$trab['ApoderadoDireccion']; ?></td>
						<td><?php echo $trab['VehiculoIda']; ?></td>
						<td><?php echo $trab['VehiculoVuelta']; ?></td>
						<td><?php echo $trab['PlanNombre'].'('.valores($trab['PlanValor'], 0).')'; ?></td>
						<td><label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $trab['Estado']; ?></label></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_apoderado.php?view='.$trab['idApoderado']; ?>" title="Ver Informacion Apoderado del Pasajero" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo 'view_apoderado_hijo.php?view='.$trab['idHijos']; ?>" title="Ver Informacion Pasajero" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&id='.$trab['idHijos']; ?>" title="Editar Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
