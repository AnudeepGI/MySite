<?php
/**
 * The Sidebar Area that is normally displayed conditionally after the main navigation (Tertiary).
 *
 * @package Verbosa
 */
?>

<aside id="tertiary" class="widget-area sidey" role="complementary" <?php cryout_schema_microdata('sidebar');?>>
	<?php do_action('cryout_before_tertiary_widgets_hook'); ?>

	<?php if ( is_active_sidebar('sidebar-3') ) { 
				dynamic_sidebar( 'sidebar-3' );
	} ?>

	<?php do_action('cryout_after_tertiary_widgets_hook'); ?>
</aside>

