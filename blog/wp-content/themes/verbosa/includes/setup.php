<?php
/*
 * Theme setup functions. Theme initialization, add_theme_support(), widgets, navigation
 *
 * @package Verbosa
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
add_action( 'template_redirect', 'verbosa_content_width' );

/** Tell WordPress to run verbosa_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'verbosa_setup' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function verbosa_setup() {

	$verbosas = cryout_get_option();

	// This theme styles the visual editor with editor-style.css to match the theme style.
	if ($verbosas['verbosa_editorstyles']) add_editor_style( "resources/styles/editor-style.css" );

	// Support title tag since WP 4.1
	add_theme_support( 'title-tag' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add HTML5 support
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Add post formats
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'audio', 'video') );

	// Make theme available for translation
	load_theme_textdomain( 'verbosa', get_template_directory() . '/languages' );
	load_textdomain( 'cryout', '' );

	// This theme allows users to set a custom backgrounssd
	add_theme_support( 'custom-background' );

	// This theme supports WordPress 4.5 logos
	add_theme_support( 'custom-logo', array( 'height' => 240, 'width' => 240, 'flex-height' => true, 'flex-width'  => true ) );
 	add_filter('get_custom_logo', 'verbosa_filter_wp_logo_img' );

	// This theme uses wp_nav_menu().
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'verbosa' ),
		'socials' => __( 'Social Icons', 'verbosa' ),
	) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1440, 1440 ); // default Post Thumbnail dimensions (cropped)
	// Custom image size for use with post thumbnails
	add_image_size( 'verbosa-featured', 1440, 1440, array( 'center', 'center') );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the same size as the header.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.

	$verbosa_headerwidth = apply_filters( 'verbosa_header_image_width',	(int)$verbosas['verbosa_sidebar'] );
	$verbosa_headerheight = apply_filters( 'verbosa_header_image_height',	(int)$verbosas['verbosa_headerheight'] );
	add_image_size('header', $verbosa_headerwidth, $verbosa_headerheight,	true);

	// Add support for flexible headers
	add_theme_support( 'custom-header', array(
		'flex-height' => true,
		'flex-width' => true,
		'height' => $verbosa_headerheight,
		'width' => $verbosa_headerwidth,
		'default-image' => get_template_directory_uri() . '/resources/images/headers/typewriter.jpg'
	));

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'typewriter' => array(
			'url' => '%s/resources/images/headers/typewriter.jpg',
			'thumbnail_url' => '%s/resources/images/headers/typewriter.jpg',
			'description' => __( 'Typewriter', 'verbosa' )
		),

		'breakfast' => array(
			'url' => '%s/resources/images/headers/breakfast.jpg',
			'thumbnail_url' => '%s/resources/images/headers/breakfast.jpg',
			'description' => __( 'Breakfast', 'verbosa' )
		),

		'homeoffice' => array(
			'url' => '%s/resources/images/headers/homeoffice.jpg',
			'thumbnail_url' => '%s/resources/images/headers/homeoffice.jpg',
			'description' => __( 'Home Office', 'verbosa' )
		),

	) );
	
	// WooCommerce compatibility
	// add_theme_support( 'woocommerce' );
	
} // verbosa_setup()

/*
 * Have two textdomains work with translation systems.
 * https://gist.github.com/justintadlock/7a605c29ae26c80878d0
 */
function verbosa_override_load_textdomain( $override, $domain ) {
	// Check if the domain is our framework domain.
	if ( 'cryout' === $domain ) {
		global $l10n;
		// If the theme's textdomain is loaded, assign the theme's translations
		// to the framework's textdomain.
		if ( isset( $l10n[ 'verbosa' ] ) )
			$l10n[ $domain ] = $l10n[ 'verbosa' ];
		// Always override.  We only want the theme to handle translations.
		$override = true;
	}
	return $override;
}
add_filter( 'override_load_textdomain', 'verbosa_override_load_textdomain', 10, 2 );

/*
 * Remove inline logo styling
 */
function verbosa_filter_wp_logo_img ( $input ) {
	return preg_replace( '/(height=".*?"|width=".*?")/i', '', $input);
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function verbosa_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'verbosa_page_menu_args' );

/** Main menu */
function verbosa_main_menu() { ?>
	<div class="skip-link screen-reader-text">
		<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'verbosa' ); ?>"> <?php _e( 'Skip to content', 'verbosa' ); ?> </a>
	</div>
	<?php
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'prime_nav',
		'menu_class'	=> '',
		'theme_location'=> 'primary',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div><ul id="%s" class="%s">%s</ul></div>'

	) );
} // verbosa_main_menu()
add_action( 'cryout_access_hook', 'verbosa_main_menu' );

/** MOBILE MENU **/
function verbosa_mobile_menu() {
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'mobile-nav',
		'menu_class'	=> '',
		'theme_location'=> 'primary',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div><ul id="%s" class="%s">%s</ul></div>'
	) );
} // verbosa_mobile_menu()
add_action( 'cryout_mobilemenu_hook', 'verbosa_mobile_menu' );

/** SOCIALS MENU **/
function verbosa_socials_menu( $location ) {
	if ( has_nav_menu( 'socials' ) )
		echo strip_tags(
			wp_nav_menu( array(
				'container' => 'nav',
				'container_class' => 'socials',
				'container_id' => $location,
				'theme_location' => 'socials',
				'link_before' => '<span>',
				'link_after' => '</span>',
				'depth' => 0,
				'items_wrap' => '%3$s',
				'walker' => new Cryout_Social_Menu_Walker(),
				'echo' => false,
			) ),
		'<a><div><span><nav>'
		);
} //verbosa_socials_menu()
function verbosa_socials_menu_header_above() { verbosa_socials_menu('sheader_above'); }
function verbosa_socials_menu_header_below() { verbosa_socials_menu('sheader_below'); }
function verbosa_socials_menu_footer()   { verbosa_socials_menu('sfooter');   }

/* social hooking moved to master hook in core.php */


/**
 * Register widgetized areas defined by theme options.
 * Uses cryout_widgets_init() from cryout/widget-areas.php
 */
function cryout_widgets_init() {

	$areas = cryout_get_theme_structure('widget-areas');

	if ( ! empty( $areas ) ):
		foreach ( $areas as $aid => $area ):
			register_sidebar( array(
				'name' 			=> $area['name'],
				'id' 			=> $aid,
				'description' 	=> ( isset( $area['description'] ) ? $area['description'] : '' ),
				'before_widget' => $area['before_widget'],
				'after_widget' 	=> $area['after_widget'],
				'before_title' 	=> $area['before_title'],
				'after_title' 	=> $area['after_title'],
			) );
		endforeach;
	endif;
} // cryout_widgets_init()
add_action( 'widgets_init', 'cryout_widgets_init' );

/**
 * Creates different class names for footer widgets depending on their number.
 * This way they can fit the footer area.
 */
function verbosa_footer_colophon_class() {
	$opts = cryout_get_option( array('verbosa_footercols', 'verbosa_footeralign') );
	$class = '';
	switch ( $opts['verbosa_footercols'] ) {
		case '0': 	$class = 'all';		break;
		case '1':	$class = 'one';		break;
		case '2':	$class = 'two';		break;
		case '3':	$class = 'three';	break;
		case '4':	$class = 'four';	break;
	}
	if ( !empty($class) ) echo 'class="footer-' . $class . ' ' . ( $opts['verbosa_footeralign'] ? 'footer-center' : '' ) . ' cryout"';
} // verbosa_footer_colophon_class()

/**
 * Set up widget areas
 */

function verbosa_widget_before() {
	if ( is_active_sidebar( 'content-widget-area-before' )) { ?>
			<aside class="content-widget content-widget-before" <?php cryout_schema_microdata('sidebar');?>>
				<?php dynamic_sidebar( 'content-widget-area-before' ); ?>
			</aside><!--content-widget--><?php
	}
}
function verbosa_widget_after() {
	if ( is_active_sidebar( 'content-widget-area-after' )) { ?>
			<aside class="content-widget content-widget-after" <?php cryout_schema_microdata('sidebar');?>>
				<?php dynamic_sidebar( 'content-widget-area-after' ); ?>
			</aside><!--content-widget--><?php
	}
}

add_action ('cryout_before_content_hook', 'verbosa_widget_before');
add_action ('cryout_after_content_hook', 'verbosa_widget_after');


/* FIN */
