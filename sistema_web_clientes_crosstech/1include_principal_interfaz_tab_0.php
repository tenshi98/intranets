<?php

/**************************************************************************/
echo '
<div class="tab-pane fade active in" id="Menu_tab_0">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 admin-grid">';

			/*************************************************************/
			//Panel de notificaciones
			echo '
			<div class="sort-disable">

				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">Bienvenido '.$_SESSION['usuario']['basic_data']['Nombre'].'</span>
				</div>

				<div class="panel-body mnw700 of-a">
					<div class="row">';
						/*************************************************************/
						//Lado izquierdo
						//echo '<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">';
						echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
							/******************************************************/
							//Verifico que esten abiertas
							$z1 = "idEstado=1";
							$z2 = "idEstado=1";
							$z3 = "idEstado=1";
							$z4 = "idEstado=1";
							//Verifico el sistema
							$z1.=" AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
							$z2.=" AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
							$z3.=" AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
							$z4.=" AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
							//Verifico que sean solo compras
							$z1.=" AND (idTipo=2 OR idTipo=12)";
							$z2.=" AND (idTipo=2 OR idTipo=12)";
							$z3.=" AND (idTipo=2 OR idTipo=12)";
							$z4.=" AND (idTipo=2 OR idTipo=12)";
							//se filtra el cliente
							$z1.=" AND idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
							$z2.=" AND idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
							$z3.=" AND idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
							$z4.=" AND idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
							//se filtra que este vencida
							$z1.=" AND Pago_fecha<='".fecha_actual()."'";
							$z2.=" AND Pago_fecha<='".fecha_actual()."'";
							$z3.=" AND Pago_fecha<='".fecha_actual()."'";
							$z4.=" AND Pago_fecha<='".fecha_actual()."'";
							//se consultan los documentos
							$FactVenta_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_arriendos_facturacion', '', $z1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'FactVenta_1');
							$FactVenta_2 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', $z2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'FactVenta_2');
							$FactVenta_3 = db_select_nrows (false, 'idFacturacion', 'bodegas_productos_facturacion', '', $z3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'FactVenta_3');
							$FactVenta_4 = db_select_nrows (false, 'idFacturacion', 'bodegas_servicios_facturacion', '', $z4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'FactVenta_4');
							//se guardan los valores
							$totalFactVenta   = $FactVenta_1 + $FactVenta_2 + $FactVenta_3 + $FactVenta_4;
							$totalAsistencias = db_select_nrows (false, 'idTicket', 'crosstech_gestion_tickets', '', "idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."' AND idCliente='".$_SESSION['usuario']['basic_data']['idCliente']."' AND idEstado='1'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'totalAsistencias');

							//se imprimen widgets
							echo '<div class="row">';
								echo widget_Ficha_1('bg-aqua', 'fa-address-card-o', 100, 'Mis Datos', 'Datos del perfil', 'principal_datos.php', 'Ver Mas', 1,1);
								echo widget_Ficha_1('bg-yellow', 'fa-usd', 100, 'Documentos Vencidos', $totalFactVenta.' Pendientes', 'gestion_documentos_pendientes.php', 'Ver Pendientes', 1,1);
								echo widget_Ficha_1('bg-purple', 'fa-handshake-o', 100, 'Tickets Abiertos', $totalAsistencias.' Pendientes', 'gestion_tickets.php?pagina=1', 'Ver Mas', 1,1);
							echo '</div>';

						echo '</div>';
						/*************************************************************/
						//Lado Derecho
						/*echo '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">';
							echo '<div class="row">';

								/*************************************************************/
								//meteo
								/*if(isset($_SESSION['usuario']['basic_data']['Pronostico'])&&$_SESSION['usuario']['basic_data']['Pronostico']!=''){
									echo '
									<a class="weatherwidget-io" href="'.$_SESSION['usuario']['basic_data']['Pronostico'].'" data-label_1="'.$_SESSION['usuario']['basic_data']['Region'].'" data-label_2="Pronostico" data-theme="pure" >'.$_SESSION['usuario']['basic_data']['Region'].'</a>
									<script>
									!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\'https://weatherwidget.io/js/widget.min.js\';fjs.parentNode.insertBefore(js,fjs);}}(document,\'script\',\'weatherwidget-io-js\');
									</script>
									';
								}
								/*************************************************************/
								//Sismos
								/*echo '<div class="clearfix" ></div>';
								//echo widget_sismologia();

							echo '</div>';
						echo '</div>';
						/*************************************************************/

					/*************************************************************/
					echo '
					</div>
				</div>
			</div>

		</div>
	</div>

';

?>
