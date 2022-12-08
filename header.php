<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?><!DOCTYPE html>

<!--[if lt IE 7]> <html style="margin-top: 0!important;" class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html style="margin-top: 0!important;" class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html style="margin-top: 0!important;" class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html style="margin-top: 0!important;" class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head >
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/humans.txt">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">

	<!-- WP_HEAD() -->
	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css">
	<![endif]-->

	<?php
		$tracking = cw_options_get_option( '_cwo_tracking_code' );
		if(!empty($tracking)) {
			echo $tracking;
		}

		$ga_code = cw_options_get_option('_cwo_ga');
		if( !empty($ga_code) ) {

		// only put the tracking on code when the site is not on a .dev
		// $extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);
		?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129765766-1"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php echo $ga_code; ?>');
			</script>

	<?php } ?>
</head>

<body <?php body_class(); ?>>
	<div>
		<a class="screen-reader-text" href="#main-content">skip navigation</a>
	</div>

	<header role="banner">
		<div class="cw-nav-cont row ai-stretch">
			<div class="s4 m2">
				<?php cw_logo(true, true); ?>
			</div>

			<nav class="cw-nav s4 m9" role="navigation">
				<span class="menu-toggle" data-menu="cw-nav-ul">
					<span class="open">
						<?php echo cw_get_icon_svg('menu'); ?>
					</span>

					<span class="close">
						<?php echo cw_get_icon_svg('close'); ?>
					</span>
				</span>
				
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container' => '',
							'menu_class' => 'menu cw-nav-ul',
							'depth' => 2,
							'fallback_cb' => 'wp_page_menu',
						)
					);
				?>
			</nav>

			<div class="s4 m1 the-search">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>

	<?php
		if(is_front_page()) {
			get_template_part('template-parts/content', 'slides');
		} else {
			get_template_part('template-parts/pageheader');
		}
	?>