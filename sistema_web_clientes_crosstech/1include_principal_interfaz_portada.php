<?php

echo '<div class="wrapper">';
	//Variables
	$currentTime = strtotime(hora_actual());
	$startTime = strtotime('21:00:00');
	$endTime = strtotime('07:00:00');

	/******************************* Animacion *******************************/
	//identifico la hora actual y defino si esta dentro del rango deseado
	if (
		($startTime < $endTime && $currentTime >= $startTime && $currentTime <= $endTime) ||
		($startTime > $endTime && ( $currentTime >= $startTime || $currentTime <= $endTime))
		) {
		//animacion para la noche
		echo '
		<div class="image fb_animation_back_night">
			<div class="fb_animation_night" >
				<div class="londonScene"></div>
				<div class="train"></div>
				<div class="crane">
					<div class="logo"></div>
				</div>
			</div>
		</div>';
	} else {
		echo '
		<div class="image fb_animation_back">
			<div class="fb_animation" >
				<div class="londonScene"></div>
				<div class="train"></div>
				<div class="crane">
					<div class="logo"></div>
				</div>
				<div class="wolf"></div>
				<div class="sam"></div>
				<div class="ari-uzi"></div>
				<div class="royal"></div>
				<div class="darjeeling"></div>
				<div class="car1"></div>
				<div class="car2"></div>
				<div class="car3"></div>
				<div class="car4"></div>
				<div class="car5"></div>
				<div class="car6"></div>
			</div>
		</div>';
	}
	
			
echo '</div>';


?>
