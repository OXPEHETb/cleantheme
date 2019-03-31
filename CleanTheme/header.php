<!DOCTYPE html>
<html>
<head>
	<base href="<?php bloginfo('url');?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo wp_get_document_title(); ?></title>
	<link rel="icon" href="<?php bloginfo('template_url');?>/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="<?php bloginfo('template_url');?>/favicon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/normalize.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/js/bx/jquery.bxslider.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style.css" />

	<!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<?php wp_head();?>

</head>
<body>

	<div class="blackkkk"></div>
	<div class="Form">
		<div class="close close-form"></div>
		<h2>Заголовок формы</h2>	
		<?php echo do_shortcode('');?>	
	</div>

	<div class="container">
		<?php bloginfo('title');?>
		<?php bloginfo('description');?>
		<?php wp_nav_menu( array(
			'container_class' => 'MainMenu',
			'theme_location' => 'top_menu'
		) ); ?>
		<div class="OpenForm">Открыть форму</div>
		<ul class="TheSlider">
			<li>Текст 1</li>
			<li>Текст 2</li>
			<li>Текст 3</li>
			<li>Текст 4</li>
			<li>Текст 5</li>
		</ul>

