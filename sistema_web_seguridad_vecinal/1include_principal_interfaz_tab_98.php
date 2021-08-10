<div class="tab-pane fade" id="Menu_tab_98">
	
	<?php 
	//cuento las categorias de los canales de youtube
	$chanel_count = 0;
	foreach($_SESSION['canales'] as $categoria=>$canales){
		$chanel_count++;
	}
	
	//arreglo con colores
	$colores = array('color-red','color-red-light','color-red-dark','color-blue','color-blue-light','color-blue-dark','color-green','color-green-light','color-green-dark','color-yellow','color-yellow-light','color-yellow-dark','color-dark','color-dark-light','color-dark-dark','color-gray','color-gray-light','color-gray-dark','color-mdb-text','color-red-text','color-pink-text','color-purple-text','color-deep-purple-text','color-indigo-text','color-blue-text','color-light-blue-text','color-cyan-text','color-teal-text','color-green-text','color-light-green-text','color-lime-text','color-yellow-text','color-amber-text','color-orange-text','color-deep-orange-text','color-brown-text','color-blue-grey-text','color-grey-text');
	$claves_aleatorias = array_rand($colores, $chanel_count);
	
	//recorro
	$n_cat = -1;
	foreach($_SESSION['canales'] as $categoria=>$canales){ 
		$n_cat++;
		?>
		<div class="col-sm-4" style="margin-top:15px;">
			<div style="border-color: #a6acaa;border-style: dashed;border-width: 1px;">
				<h5 style="color: #666;font-weight: 600 !important;padding-left:5px;"> <i class="fa fa-youtube" aria-hidden="true"></i> <?php echo $categoria; ?>
					<small class="pull-right fw600 text-primary"></small>
				</h5>
				
				<div style="height: 400px;overflow-y: auto!important;">												
					<table class="table mbn covertable">
						<tbody>
							<?php foreach ($canales as $canal) { ?>
								<tr>
									<td class="text-muted">
										<a target="_blank" rel="noopener noreferrer" href="<?php echo $canal['CanalDireccion']; ?>"><i class="fa fa-link <?php echo $colores[$claves_aleatorias[$n_cat]]; ?>" aria-hidden="true"></i> <?php echo $canal['CanalNombre']; ?></a>
									</td>
								</tr>
							<?php } ?> 
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } ?> 
	
	
					
</div>
