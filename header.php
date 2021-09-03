<!doctype html>
<html <?php language_attributes(); ?>>
<!--HEAD-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100&family=Roboto:wght@300&family=Staatliches&display=swap" rel="stylesheet">
	<?php wp_head(); ?>	
</head>

<header>
	<?php 
		$arrHeaderMenu 		= Theme_Controller::getMenuByName('Header Menu');
		$strLogoWidth 		= Theme_Controller::get_theme_option('logo_width');
		$strSiteLogo 			= Theme_Controller::get_theme_option('site_logo');
		$strPrimaryColor 		= Theme_Controller::get_theme_option('primary_color');
		$strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
	?>
	<nav class="navbar-adjust navbar navbar-expand-lg navbar-light" style="background-color:<?php echo $strPrimaryColor;?>!important;">
		<a class="navbar-brand" href="<?php echo home_url();?>">
			<div class="logo">
				<img style="width:<?php echo $strLogoWidth;?>px;" src="<?php echo $strSiteLogo;?>">
				<p style="color:<?php echo $strThemeSecondaryColor;?>"> Travel & Immigration</p>
			</div> 
		</a>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<?php
				if(!empty($arrHeaderMenu)){
					foreach($arrHeaderMenu as $key => $arrLinks){
						if(empty($arrLinks['children'])){?>
							<li class="nav-item"><a data-id="<?php echo $arrLinks['ID']?>" class="nav-link" href="<?php echo $arrLinks['url']?>"><?php echo $arrLinks['title']?></a></li>
						<?php } else{?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php echo $arrLinks['title']?>
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<?php foreach ($arrLinks['children'] as $key => $arrChildLinks){?>
										<a  data-id ="<?php echo $arrChildLinks['ID'];?>"  class="dropdown-item" href="<?php echo $arrChildLinks['url'];?>"><?php echo $arrChildLinks['title'];?></a>
									<?php }?>
								</div>
							</li>
						<?php }?>
					<?php }?>
				<?php }?>
			</ul>

			<form method="get" class="form-inline my-2 my-lg-0">
				<input name="s" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button style="border: 2px solid <?php echo $strThemeSecondaryColor;?>;color: <?php echo $strThemeSecondaryColor;?>" class="btn-theme btn-theme-transparent btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>
</header>
<!--Body Start-->
<body>