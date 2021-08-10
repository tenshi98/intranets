<link rel="stylesheet" href="<?php echo DB_SITE_REPO ?>/LIB_assets/css/animate/animate.min.css">
<style>
.login_text1{color: #DB4F21 !important;text-align: center;margin-top: 0px;margin-bottom: 0px;}
.tab-content .text-muted {
    margin-left: 0px !important;
}
</style>

					
<div class="form-signin">
	
	<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
	<h3 class="register-heading"><?php echo DB_SOFT_NAME ?></h3>

	<div class="tab-content" style="min-height: 200px !important;">
		<div id="login" class="tab-pane active">
			<form class="" method="post"  name="form1" novalidate>
				<h1 class="login_text1">Iniciar sesión</h1>
				<p class="text-muted text-center">Ingrese su Rut de usuario y contraseña para acceder</p>
				<?php 
				//Se verifican si existen los datos
				if(isset($Rut)) {        $x1  = $Rut;       }else{$x1  = '';}
				if(isset($password)) {   $x2  = $password;  }else{$x2  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Inputs();
				$Form_Inputs->input_login_rut('Rut', 'Rut', $x1, 2);
				$Form_Inputs->input_login_pass('Contraseña', 'password', $x2);
				
				$Form_Inputs->input_hidden('fkinput1', '', 1);
				?>

				<input type="submit" name="submit_login" class="btn btn-lg btn-primary btn-block fa-input" value="&#xf007; Ingresar" />
			</form>
		</div>
		<div id="forgot" class="tab-pane">
			<form class="" method="post"  name="form2" novalidate>
				<h1 class="login_text1">¿Olvidaste tu contraseña?</h1>
				<p class="text-muted text-center">Ingresa tu Email para recuperar tu contraseña.Revisa la bandeja de entrada o spam de tu correo.</p>
				<?php 
				//Se verifican si existen los datos
				if(isset($email)) {    $x1  = $email;   }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs->input_login_mail('mimail@midominio.cl', 'email', $x1);
				
				$Form_Inputs->input_hidden('fkinput2', '', 1);	  
				?>
				<br>
				
				<input type="submit" name="submit_pass" class="btn btn-lg btn-danger btn-block fa-input" value="&#xf003; Recuperar contraseña" />
			</form>
		</div>
	</div>
	<hr>
	<div class="text-center">
		<ul class="list-inline">
			<li class="active"> <a class="text-muted" href="#login" data-toggle="tab" aria-expanded="true">Ingresar</a>  </li>
			<li class=""> <a class="text-muted" href="#forgot" data-toggle="tab" aria-expanded="false">Recuperar contraseña</a>  </li>
		</ul>
	</div>
</div>

<!--jQuery -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--Bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		$('.list-inline li > a').click(function() {
			var activeForm = $(this).attr('href') + ' > form';
			//console.log(activeForm);
			$(activeForm).addClass('animated fadeIn');
			//set timer to 1 seconds, after that, unload the animate animation
			setTimeout(function() {
			$(activeForm).removeClass('animated fadeIn');
			}, 1000);
		});
	});
})(jQuery);
</script>
