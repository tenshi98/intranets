<?php if (isset($_SESSION['usuario']['basic_data']['Config_imgLogo'])&&$_SESSION['usuario']['basic_data']['Config_imgLogo']!=''){?>
	<div class="logo_empresa">
		<div class="fleft">
			<img src="<?php echo DB_SITE_ALT_1.'/upload/'.$_SESSION['usuario']['basic_data']['Config_imgLogo']; ?>" alt="">
		</div>
		<div class="texto fleft">
			<h1><?php if(isset($_SESSION['usuario']['basic_data']['RazonSocial'])&&$_SESSION['usuario']['basic_data']['RazonSocial']!=''){echo $_SESSION['usuario']['basic_data']['RazonSocial'].' - ' ;}?> <?php echo DB_SOFT_NAME ?><br/>
			<span><?php echo DB_SOFT_SLOGAN ?></span>
			</h1>
		</div>
	</div>
<?php }else{?>
	<div class="logo_empresa">
		<div class="content_gearbox fleft">
			<div class="gearbox">
				<div class="overlay"></div>
				<div class="gear one">
					<div class="gear-inner">
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
					</div>
				</div>
				<div class="gear two">
					<div class="gear-inner">
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
					</div>
				</div>
							
				<div class="gear four large">
					<div class="gear-inner">
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
						<div class="bar"></div>
					</div>
				</div>
			</div>				  
		</div>
		<div class="texto fleft">
			<h1><?php if(isset($_SESSION['usuario']['basic_data']['RazonSocial'])&&$_SESSION['usuario']['basic_data']['RazonSocial']!=''){echo $_SESSION['usuario']['basic_data']['RazonSocial'].' - ' ;}?> <?php echo DB_SOFT_NAME ?><br/>
			<span><?php echo DB_SOFT_SLOGAN ?></span>
			</h1>
		</div>
	</div>
<?php } ?>
