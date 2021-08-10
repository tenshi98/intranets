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
$original = "principal.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Ver Facturacion';
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
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// Se traen todos los datos
$query = "SELECT  
usuarios_listado.Nombre AS NombreUsuario,
core_sistemas.Nombre AS NombreSistema,
vehiculos_facturacion_listado.Fecha, 
vehiculos_facturacion_listado.Observaciones, 
vehiculos_facturacion_listado.fCreacion

FROM `vehiculos_facturacion_listado`
LEFT JOIN `usuarios_listado`  ON usuarios_listado.idUsuario   = vehiculos_facturacion_listado.idUsuario
LEFT JOIN `core_sistemas`     ON core_sistemas.idSistema      = vehiculos_facturacion_listado.idSistema
WHERE vehiculos_facturacion_listado.idFacturacion = ".$_GET['view'];
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
$rowFacturacion = mysqli_fetch_assoc ($resultado);

			


//traigo todos los apoderados con hijos
$arrHijos = array();
$query = "SELECT
vehiculos_facturacion_listado_detalle.idFacturacionDetalle,

hijo_1.Nombre AS Hijo_1_Nombre,
hijo_1.ApellidoPat AS Hijo_1_ApellidoPat,
hijo_1.ApellidoMat AS Hijo_1_ApellidoMat,

hijo_2.Nombre AS Hijo_2_Nombre,
hijo_2.ApellidoPat AS Hijo_2_ApellidoPat,
hijo_2.ApellidoMat AS Hijo_2_ApellidoMat,

hijo_3.Nombre AS Hijo_3_Nombre,
hijo_3.ApellidoPat AS Hijo_3_ApellidoPat,
hijo_3.ApellidoMat AS Hijo_3_ApellidoMat,

hijo_4.Nombre AS Hijo_4_Nombre,
hijo_4.ApellidoPat AS Hijo_4_ApellidoPat,
hijo_4.ApellidoMat AS Hijo_4_ApellidoMat,

hijo_5.Nombre AS Hijo_5_Nombre,
hijo_5.ApellidoPat AS Hijo_5_ApellidoPat,
hijo_5.ApellidoMat AS Hijo_5_ApellidoMat,

apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,

vehiculo_1.Nombre AS Vehiculo_1_Nombre,
vehiculo_1.Patente AS Vehiculo_1_Patente,

vehiculo_2.Nombre AS Vehiculo_2_Nombre,
vehiculo_2.Patente AS Vehiculo_2_Patente,

vehiculo_3.Nombre AS Vehiculo_3_Nombre,
vehiculo_3.Patente AS Vehiculo_3_Patente,

vehiculo_4.Nombre AS Vehiculo_4_Nombre,
vehiculo_4.Patente AS Vehiculo_4_Patente,

vehiculo_5.Nombre AS Vehiculo_5_Nombre,
vehiculo_5.Patente AS Vehiculo_5_Patente,

core_estado_facturacion.Nombre AS Estado

FROM `vehiculos_facturacion_listado_detalle`
LEFT JOIN `apoderados_listado_hijos`  hijo_1    ON hijo_1.idHijos                    = vehiculos_facturacion_listado_detalle.idHijos_1
LEFT JOIN `apoderados_listado_hijos`  hijo_2    ON hijo_2.idHijos                    = vehiculos_facturacion_listado_detalle.idHijos_2
LEFT JOIN `apoderados_listado_hijos`  hijo_3    ON hijo_3.idHijos                    = vehiculos_facturacion_listado_detalle.idHijos_3
LEFT JOIN `apoderados_listado_hijos`  hijo_4    ON hijo_4.idHijos                    = vehiculos_facturacion_listado_detalle.idHijos_4
LEFT JOIN `apoderados_listado_hijos`  hijo_5    ON hijo_5.idHijos                    = vehiculos_facturacion_listado_detalle.idHijos_5
LEFT JOIN `vehiculos_listado`   vehiculo_1      ON vehiculo_1.idVehiculo             = vehiculos_facturacion_listado_detalle.idVehiculo_1
LEFT JOIN `vehiculos_listado`   vehiculo_2      ON vehiculo_2.idVehiculo             = vehiculos_facturacion_listado_detalle.idVehiculo_2
LEFT JOIN `vehiculos_listado`   vehiculo_3      ON vehiculo_3.idVehiculo             = vehiculos_facturacion_listado_detalle.idVehiculo_3
LEFT JOIN `vehiculos_listado`   vehiculo_4      ON vehiculo_4.idVehiculo             = vehiculos_facturacion_listado_detalle.idVehiculo_4
LEFT JOIN `vehiculos_listado`   vehiculo_5      ON vehiculo_5.idVehiculo             = vehiculos_facturacion_listado_detalle.idVehiculo_5
LEFT JOIN `apoderados_listado`                  ON apoderados_listado.idApoderado    = vehiculos_facturacion_listado_detalle.idApoderado
LEFT JOIN `core_estado_facturacion`                  ON core_estado_facturacion.idEstado    = vehiculos_facturacion_listado_detalle.idEstado

WHERE vehiculos_facturacion_listado_detalle.idFacturacion = '".$_GET['view']."'  ";
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
array_push( $arrHijos,$row );
}


?>








<div class="col-sm-11 fcenter table-responsive">

<div id="page-wrap">
    <div id="header"> Facturacion Mes de <?php echo Fecha_mes_ano($rowFacturacion['Fecha']); ?> </div>
   

    <div id="customer">


        <table id="meta" class="fleft otdata">
            <tbody>
				<tr>
                    <td class="meta-head" colspan="2"><strong>DATOS BASICOS</strong></td>
                </tr>
				<tr>
                    <td class="meta-head">Fecha Creacion</td>
                    <td><?php echo Fecha_estandar($rowFacturacion['fCreacion']); ?></td>
                </tr>
				<tr>
                    <td class="meta-head">Creador</td>
                    <td><?php echo $rowFacturacion['NombreUsuario']; ?></td>
                </tr>
				<tr>
                    <td class="meta-head">Sistema</td>
                    <td><?php echo $rowFacturacion['NombreSistema']; ?></td>
                </tr>

                
            </tbody>
        </table>
        <table id="meta" class="otdata2">
            <tbody>
                <tr>
					<td class="meta-head">Fecha Facturacion</td>
					<td><?php echo Fecha_estandar($rowFacturacion['Fecha']);?></td>
				</tr>
            </tbody>
        </table>
    </div>
    <table id="items">
        <tbody>
            
			<tr>
				<th colspan="5">Detalle</th>
			</tr>		  
            
    
				
				<tr class="item-row linea_punteada" bgcolor="#F0F0F0">
					<td class="item-name"><strong>Vehiculo</strong></td>
					<td class="item-name"><strong>Apoderado</strong></td>
					<td class="item-name"><strong>Hijo</strong></td>
					<td class="item-name"><strong>Estado</strong></td>
					<td width="120"  style="width:120px;"><strong>Acciones</strong></td>
				</tr>
				
	

				<?php 
				//recorro el lsiatdo entregado por la base de datos
				foreach ($arrHijos as $hijo) { ?>

					<?php if(isset($hijo['Vehiculo_1_Nombre'])&&$hijo['Vehiculo_1_Nombre']!=''){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $hijo['Vehiculo_1_Nombre'].' Patente '.$hijo['Vehiculo_1_Patente']; ?></td>
							<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Hijo_1_Nombre'].' '.$hijo['Hijo_1_ApellidoPat'].' '.$hijo['Hijo_1_ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$hijo['idFacturacionDetalle'].'&return='.basename($_SERVER["REQUEST_URI"], ".php") ?>" title="Ver Datos Apoderado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>	
					<?php }?>
					
					<?php if(isset($hijo['Vehiculo_2_Nombre'])&&$hijo['Vehiculo_2_Nombre']!=''){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $hijo['Vehiculo_2_Nombre'].' Patente '.$hijo['Vehiculo_2_Patente']; ?></td>
							<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Hijo_2_Nombre'].' '.$hijo['Hijo_2_ApellidoPat'].' '.$hijo['Hijo_2_ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$hijo['idFacturacionDetalle'].'&return='.basename($_SERVER["REQUEST_URI"], ".php") ?>" title="Ver Datos Apoderado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>	
					<?php }?>
					
					<?php if(isset($hijo['Vehiculo_3_Nombre'])&&$hijo['Vehiculo_3_Nombre']!=''){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $hijo['Vehiculo_3_Nombre'].' Patente '.$hijo['Vehiculo_3_Patente']; ?></td>
							<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Hijo_3_Nombre'].' '.$hijo['Hijo_3_ApellidoPat'].' '.$hijo['Hijo_3_ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$hijo['idFacturacionDetalle'].'&return='.basename($_SERVER["REQUEST_URI"], ".php") ?>" title="Ver Datos Apoderado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>	
					<?php }?>
					
					<?php if(isset($hijo['Vehiculo_4_Nombre'])&&$hijo['Vehiculo_4_Nombre']!=''){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $hijo['Vehiculo_4_Nombre'].' Patente '.$hijo['Vehiculo_4_Patente']; ?></td>
							<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Hijo_4_Nombre'].' '.$hijo['Hijo_4_ApellidoPat'].' '.$hijo['Hijo_4_ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$hijo['idFacturacionDetalle'].'&return='.basename($_SERVER["REQUEST_URI"], ".php") ?>" title="Ver Datos Apoderado" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>	
					<?php }?>
					
					<?php if(isset($hijo['Vehiculo_5_Nombre'])&&$hijo['Vehiculo_5_Nombre']!=''){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><?php echo $hijo['Vehiculo_5_Nombre'].' Patente '.$hijo['Vehiculo_5_Patente']; ?></td>
							<td class="item-name"><?php echo $hijo['ApoderadoNombre'].' '.$hijo['ApoderadoApellidoPat'].' '.$hijo['ApoderadoApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Hijo_5_Nombre'].' '.$hijo['Hijo_5_ApellidoPat'].' '.$hijo['Hijo_5_ApellidoMat']; ?></td>
							<td class="item-name"><?php echo $hijo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$hijo['idFacturacionDetalle'].'&return='.basename($_SERVER["REQUEST_URI"], ".php") ?>" title="Ver Boleta" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>	
					<?php }?>
					
					
				
							 
				<?php } ?>
			
			
			
				
				<tr id="hiderow"><td colspan="5"></td></tr>
			
			
			


			
            <tr>
                <td colspan="5" class="blank"> 
					<p>
						<?php echo $rowFacturacion['Observaciones'];?>
					</p>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="blank"><p>Observaciones</p></td> 
            </tr>
        </tbody>
    </table>
    	<div class="clearfix"></div>
    	
    </div>


</div>



<?php widget_modal(80, 95); ?>





 
          
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
require_once 'core/Web.Footer.Main.php';
?>
