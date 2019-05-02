<?php
/**
 * The template for displaying the landing page/blog posts
 * The functions used here can be found in includes/landing-page.php
 *
 * @package Verbosa
 */

$verbosa_landingpage = cryout_get_option( 'verbosa_landingpage' );

if ( is_page() && ! $verbosa_landingpage ) {
	include( get_page_template() );
	return true;
}

if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} else {
	
	get_header(); ?>
	<div id="container" class="<?php echo verbosa_get_layout_class(); ?>">
		<?php verbosa_header_section() ?>
		<main id="main" role="main" class="main">
			<?php //cryout_before_content_hook(); ?>
			<?php

			if ( $verbosa_landingpage ) {
				verbosa_lptext('one');
				verbosa_lpslider();
				verbosa_lptext('two');
				verbosa_lpindex();
				verbosa_lptext('three');
			} else {
				verbosa_lpindex();
			}

			?>
			<?php //cryout_after_content_hook(); ?>
		</main><!-- #main -->

	</div><!-- #container -->

	<?php
	get_footer();

} //else !posts

// FIN
