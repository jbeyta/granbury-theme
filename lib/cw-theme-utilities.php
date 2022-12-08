<?php

/**
 * Sets up theme defaults
 *
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since CW 1.1
 */
function cw_setup() {
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css' ) );

	/*
	 * Adds RSS feed links to <head> for posts and comments.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support(
		'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		)
	);

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo', array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Create the main menu location.
	 */
	register_nav_menu( 'primary', __( 'Main Menu', 'cw' ) );
	/*
	 * This theme uses a custom image size for featured images, displayed on "standard" posts.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 768, 9999 ); // Unlimited height, soft crop
	add_image_size('slide_lrg', 1400, 800, true);
	add_image_size('slide_sml', 1024, 589, true);
}
add_action( 'after_setup_theme', 'cw_setup' );

/**
 * Register Widget Areas
 *
 * Uncomment and edit to create widget areas where needed.
 * These are default examples so make changes before production.
 *
 * @since CW 1
 *
 */
function cw_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the sidebar section of the site.' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// register_sidebar( array(
	// 	'name'          => __( 'Secondary Widget Area' ),
	// 	'id'            => 'sidebar-2',
	// 	'description'   => __( 'Appears on posts and pages in the sidebar.' ),
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h3 class="widget-title">',
	// 	'after_title'   => '</h3>',
	// ) );
}
add_action( 'widgets_init', 'cw_widgets_init' );


/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since CW 1.1
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function cw_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'cw_wp_title', 10, 2 );


/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function remove_empty_p( $content ) {
    $content = force_balance_tags( $content );
    $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
    $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
    return $content;
}
// add_filter('the_content', 'remove_empty_p', 20, 1);

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since CW 1.1
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function cw_body_class( $classes ) {
	// if ( ! is_multi_author() )
	// 	$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	// if ( ! get_option( 'show_avatars' ) )
	// 	$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'cw_body_class' );

// custom excerpt
function cw_excerpt($content, $limit = 50) {
	if(!empty($content)) {
		$no_tags = strip_tags(strip_shortcodes($content));
		$explode = explode(' ', $no_tags);
		$limited = array_slice($explode, 0, $limit);
		$excerpt = implode(' ', $limited);
	} else {
		$excerpt = 'ERROR: Oops! looks like your content is empty. Make sure you include the content! cw_excerpt($content, $limit)';
	}

	return $excerpt;
}

// get rid of [...]
function new_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');

// change "enter title here"
add_filter('gettext','custom_enter_title');
function custom_enter_title( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input )
    	if('testimonials' == $post_type )
        	return 'Enter Name Here';
        elseif('staff' == $post_type )
        	return 'Enter Name Here';
        elseif('faqs' == $post_type )
        	return 'Question';

    return $input;
}

/**
 * Rename "Posts" to "News"
 *
 * @link http://new2wp.com/snippet/change-wordpress-posts-post-type-news/
 */
 
// add_action( 'admin_menu', 'pilau_change_post_menu_label' );
// add_action( 'init', 'pilau_change_post_object_label' ); 
function pilau_change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
	$submenu['edit.php'][16][0] = 'News Tags';
	echo '';
}
function pilau_change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
}

function get_cw_logo($h1 = false, $link = true) {
	$logo_img_id = cw_options_get_option( '_cwo_logo_id' );
	$logo_svg = cw_options_get_option( '_cwo_logo_svg' );

	$html = '';

	if($h1) { $html .= '<h1 class="logo">'; }
		if($link) { $html .= '<a href="'.get_bloginfo('url').'" title="'.get_bloginfo( 'name' ).'">'; }
				if(!empty($logo_svg)) {
					$html .= $logo_svg;
					$html .= '<span class="visually-hidden">'.get_bloginfo('name').'</span>';
				} elseif(!empty($logo_img_id)) {
					$html .= get_cw_img($logo_img_id);
					$html .= '<span class="visually-hidden">'.get_bloginfo('name').'</span>';
				} else {
					$html .= get_bloginfo( 'name' );
				}
		if($link) { $html .= '</a>'; }
	if($h1) { $html .= '</h1>'; }

	return $html;
}

function cw_logo($h1 = false, $link = true) {
	echo get_cw_logo($h1, $link);
}

// custom post title override
function cw_set_staff_title( $data , $post ) {
	if($_POST['action'] == 'editpost') {
		if($data['post_type'] == 'cwextrarealtors') {
			
			$first_name = !!$_POST['_cwmb_first_name'] ? $_POST['_cwmb_first_name'] : '';
			$last_name = !!$_POST['_cwmb_last_name'] ? $_POST['_cwmb_last_name'] : '';
			
			$post_title = $first_name.' '.$last_name;
			

			if($_POST['_office_name']) {
				$post_title .= ' - '.$_POST['_office_name'];
			}
			
			$post_slug = sanitize_title_with_dashes($post_title, '', 'save');
			$post_slugsan = sanitize_title($post_slug);
	
			$data['post_title'] = $post_title;
			$data['post_name'] = $post_slugsan;
		}
	}

	return $data;
}
add_filter( 'wp_insert_post_data' , 'cw_set_staff_title' , '10', 2 );