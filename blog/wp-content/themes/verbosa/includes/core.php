<?php
/**
 * Core theme functions
 *
 * @package Verbosa
 */
 
/**
 * Calculates the correct content_width value depending on site with and configured layout
 */
if ( ! function_exists( 'verbosa_content_width' ) ) :
function verbosa_content_width() {
	global $content_width;
	$deviation = 0.80;

	$options = cryout_get_option( array(
		'verbosa_sitelayout', 'verbosa_landingpage', 'verbosa_magazinelayout', 'verbosa_sitewidth', 'verbosa_sidebar', 'verbosa_elementpadding',
	) );

	$content_width = 0.97 * (int)$options['verbosa_sitewidth'];

	switch( $options['verbosa_sitelayout'] ) {
		case '2cSl': case '2cSr': $content_width -= (int)$options['verbosa_sidebar']; // sidebar
	}
	

	if ( is_front_page() && $options['verbosa_landingpage'] ) {
		// landing page could be a special case;
	}

	$deviation = round( (100-intval($options['verbosa_elementpadding'])*2)/100, 2);
	$content_width = floor($content_width*$deviation);
	
	if ( ! is_singular() ) {
		switch ( $options['verbosa_magazinelayout'] ):
			case 2: $content_width = floor($content_width*0.98/2); break; // magazine-two
			case 3: $content_width = floor($content_width*0.96/3); break; // magazine-three
		endswitch;
	};

} // verbosa_content_width()
endif;

/**
 * Header image handler (via div with background image)
 */
add_action ('cryout_headerimage_hook', 'verbosa_header_image', 99);
if ( ! function_exists( 'verbosa_header_image' ) ) :
function verbosa_header_image() {
	if (get_header_image() != '') {
		$header_image = get_header_image();
	}

	if ( !empty($header_image) ):?>
		<?php cryout_header_widget_hook(); ?>
		<img class="header-image" alt="<?php if ( is_single() ) the_title_attribute(); elseif ( is_archive() ) echo strip_tags( get_the_archive_title() ); else echo get_bloginfo( 'name' ) ?>" src="<?php echo esc_url( $header_image ) ?>" />
	<?php endif;
} // verbosa_header_image()
endif;

/**
 * Adds title and description to header
 * Used in header.php
*/
if ( ! function_exists( 'verbosa_title_and_description' ) ) :
function verbosa_title_and_description() {

	$verbosas = cryout_get_option( array('verbosa_logoupload','verbosa_siteheader') );
	echo '<div class="identity">';
	if ( in_array($verbosas['verbosa_siteheader'], array( 'logo', 'both' ) ) ) {
		echo verbosa_logo_helper($verbosas['verbosa_logoupload']);
	}
	if ( in_array($verbosas['verbosa_siteheader'], array('title', 'both') ) ) {
		$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
		echo '<' . $heading_tag . cryout_schema_microdata('site-title', 0) . ' id="site-title">';
		echo '<span> <a href="' . esc_url( home_url( '/' ) ) . '"  rel="home">' . esc_attr( get_bloginfo( 'name' ) ) . '</a> </span>';
		echo '</' . $heading_tag . '>';
		echo '<span id="site-description" ' . cryout_schema_microdata('site-description', 0) . ' >' . esc_attr( get_bloginfo( 'description' ) ) . '</span>';
	}

	echo '</div>';
} // verbosa_title_and_description()
endif;
add_action ('cryout_branding_hook', 'verbosa_title_and_description');

function verbosa_logo_helper( $verbosa_logo ) {
	    if ( function_exists( 'the_custom_logo' ) ) {
	        // WP 4.5+
	        $wp_logo = str_replace( 'class="custom-logo-link"', 'id="logo" class="custom-logo-link" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"', get_custom_logo() );
	        if ( ! empty( $wp_logo ) ) return $wp_logo;
	    } else {
	        // older WP
	        if ( ! empty( $verbosa_logo ) ) :
	            $img = wp_get_attachment_image_src( $verbosa_logo, 'full' );
	            return '<a id="logo" href="' . esc_url( home_url( '/' ) ) . '" >
							<img title="' . get_bloginfo( 'name' ) . '" alt="' . get_bloginfo( 'name' ) . '" src="' . esc_url( $img[0] ) . '" />
						</a>';
	        endif;
	    }
	    return '';
} // verbosa_logo_helper()

// cryout_schema_publisher() located in cryout/prototypes.php
add_action( 'cryout_after_inner_hook', 'cryout_schema_publisher' );
add_action( 'cryout_singular_after_inner_hook', 'cryout_schema_publisher' );

// cryout_schema_main() located in cryout/prototypes.php
add_action( 'cryout_after_inner_hook', 'cryout_schema_main' );
add_action( 'cryout_singular_after_inner_hook', 'cryout_schema_main' );

/**
 * Verbosa back to top button
 * Creates div for js
*/
if ( ! function_exists( 'verbosa_back_top' ) ) :
function verbosa_back_top() {
	echo '<div id="toTop"><i class="icon-back2top"></i> </div>';
} // verbosa_back_top()
endif;
add_action ('cryout_after_footer_hook', 'verbosa_back_top');


/**
 * Creates pagination for blog pages.
 */
if ( ! function_exists( 'verbosa_pagination' ) ) :
function verbosa_pagination($pages = '', $range = 2, $prefix ='')
{
	$pagination = cryout_get_option('verbosa_pagination');
	if ($pagination && function_exists( 'the_posts_pagination' ) ):
		the_posts_pagination( array(
			'prev_text' => '<i class="icon-arrow-left2"></i>',
			'next_text' => '<i class="icon-arrow-right2"></i>',
			'mid_size' => $range
		) );
	else:
		//posts_nav_link();
		verbosa_content_nav( 'nav-old-below' );
	endif;

} // verbosa_pagination()
endif;

/**
 *
 */
if ( ! function_exists( 'verbosa_nextpage_links' ) ) :
function verbosa_nextpage_links($defaults) {
	$args = array(
		'link_before'      => '<em>',
		'link_after'       => '</em>',
	);
	$r = wp_parse_args($args, $defaults);
	return $r;
} // verbosa_nextpage_links()
endif;
add_filter('wp_link_pages_args','verbosa_nextpage_links');


/**
 * Footer Hook
 */
add_action('cryout_master_footer_hook', 'verbosa_master_footer');
function verbosa_master_footer() {
	$verbosa_theme = wp_get_theme();
	do_action('cryout_footer_hook');
	echo '<div id="site-copyright">' . do_shortcode( wp_kses_post( cryout_get_option( 'verbosa_copyright' ) ) ) . '</div>';
	echo '<div id="poweredby">' . __("Powered by","verbosa") .
		'<a target="_blank" href="' . esc_html( $verbosa_theme->get( 'ThemeURI' ) )  . '" title="';
	echo 'Verbosa Theme by' . ' Cryout Creations"> ' . 'Verbosa' .'</a> &amp; <a target="_blank" href="' . "http://wordpress.org/";
	echo '" title="' . esc_attr__( "Semantic Personal Publishing Platform", "verbosa" ) . '"> ' . sprintf( " %s.", "WordPress" ) . '</a></div>';
}


if ( ! function_exists( 'verbosa_header_section' ) ) :
function verbosa_header_section() { ?>
	<div id="sidebar">

		<header id="header" <?php cryout_schema_microdata('header') ?>>
			<nav id="mobile-menu">
				<span id="nav-cancel"><i class="icon-cross"></i></span>
				<?php cryout_mobilemenu_hook(); ?>
			</nav>
			<div id="branding" role="banner">
			<?php cryout_branding_hook();?>
			<?php cryout_headerimage_hook(); ?>
			<?php get_sidebar('before-menu'); ?>
				<a id="nav-toggle"><span>&nbsp;</span></a>
				<nav id="access" role="navigation"  aria-label="Primary Menu" <?php cryout_schema_microdata('menu'); ?>>
				<h3 class="widget-title menu-title"><span><?php _e("Menu", "verbosa");?></span></h3>
					<?php cryout_access_hook();?>
				</nav><!-- #access -->

			</div><!-- #branding -->
		</header><!-- #header -->

		<?php get_sidebar('after-menu'); ?>
		<?php get_sidebar('conditional'); ?>
		<?php cryout_master_footer_hook(); ?>

		</div><!--sidebar-->
		<div id="sidebar-back"></div>
<?php }// verbosa_header_section
endif;

if ( ! function_exists( 'verbosa_get_layout_class' ) ) :
function verbosa_get_layout_class() {
	$verbosa_sitelayout = cryout_get_option( 'verbosa_sitelayout' );

	/*  If page template, return the page template's layout */
	global $verbosa_template_layout;
	if (isset($verbosa_template_layout)) return $verbosa_template_layout;

	/*  If not, return the general layout */
	switch($verbosa_sitelayout) {
		case '2cSl': return "two-columns-left"; break;
		case '2cSr': return "two-columns-right"; break;
		case '1c':
		default: return "one-column"; break;
	}
} // verbosa_get_layout_class()
endif;


/**
* Checks the browser agent string for mobile ids and adds "mobile" class to body if true
* @return array list of classes.
*/
function verbosa_mobile_body_class($classes){
	$browser = (!empty($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'');
	$keys = 'mobile|android|mobi|tablet|ipad|opera mini|series 60|s60|blackberry';
	if (preg_match("/($keys)/i",$browser)): $classes[] = 'mobile'; endif; // mobile browser detected
	return $classes;
} // verbosa_mobile_body_class()
add_filter('body_class', 'verbosa_mobile_body_class');


/**
* Creates breadcrumbs with page sublevels and category sublevels.
* Hooked in master hook
*/
if ( ! function_exists( 'verbosa_breadcrumbs' ) ) :
function verbosa_breadcrumbs() {
	cryout_breadcrumbs(
		'<i class="icon-ctrl-right"></i>',						// $separator
		'<a href="'. esc_url( home_url() ).'" title="'.__('Home','verbosa').'"><i class="icon-home"></i></a>',	// $home
		1,														// $showCurrent
		'<span class="current">', 								// $before
		'</span>', 												// $after
		'<div id="breadcrumbs-container" class="cryout %1$s"><div id="breadcrumbs-container-inside"><div id="breadcrumbs"> <nav id="breadcrumbs-nav" %2$s>', // $wrapper_pre
		'</nav></div></div></div><!-- breadcrumbs -->', 		// $wrapper_post
		verbosa_get_layout_class(),								// $layout_class
		__( 'Home', 'verbosa' ),								// $text_home
		__( 'Archive for category', 'verbosa' ),				// $text_archive
		__( 'Search results for', 'verbosa' ), 					// $text_search
		__( 'Posts tagged', 'verbosa' ), 						// $text_tag
		__( 'Articles posted by', 'verbosa' ), 					// $text_author
		__( 'Not Found', 'verbosa' ),							// $text_404
		__( 'Post format', 'verbosa' ),							// $text_format
		__( 'Page', 'verbosa' )									// $text_page
	);
} // verbosa_breadcrumbs()
endif;

/**
* Master hook to bypass customizer options
*/
if ( ! function_exists( 'cryout_master_hook' ) ) :
function cryout_master_hook(){
	$verbosa_interim_options = cryout_get_option( array(
		'verbosa_breadcrumbs',
		'verbosa_searchboxmain',
		'verbosa_searchboxfooter',
		'verbosa_comlabels',
		'verbosa_socials_header_above',
		'verbosa_socials_header_below',
		'verbosa_socials_sidebar',
		)
	);
	if ( $verbosa_interim_options['verbosa_breadcrumbs'] ) {
		if (is_singular()) {
			add_action('cryout_before_content_hook', 'verbosa_breadcrumbs' );
		} else {
			add_action('cryout_breadcrumbs_hook', 'verbosa_breadcrumbs' );
		}
	};

	if ( $verbosa_interim_options['verbosa_comlabels'] == 1) {
		add_filter('comment_form_default_fields', 'verbosa_comments_form');
		add_filter('comment_form_field_comment', 'verbosa_comments_form_textarea');
	}

	if ( $verbosa_interim_options['verbosa_socials_header_above'] ) add_action('cryout_branding_hook', 'verbosa_socials_menu_header_above', 5);
	if ( $verbosa_interim_options['verbosa_socials_header_below'] ) add_action('cryout_branding_hook', 'verbosa_socials_menu_header_below', 30);
	if ( $verbosa_interim_options['verbosa_socials_sidebar'] ) add_action('cryout_footer_hook', 'verbosa_socials_menu_footer', 17);

};
endif;
add_action('wp', 'cryout_master_hook');
