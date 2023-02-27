<div class="topnav">
    <div class="btn-group">
		<?php
		$ubicacion = 'index.php?salir=true';
		$dialogo   = '¿Realmente desea cerrar su sesion?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Cerrar sesion" class="btn btn-metis-1 btn-sm tooltip">
            <i class="fa fa-power-off" aria-hidden="true"></i> Cerrar Sesion
        </a>
    </div>
    
</div>
