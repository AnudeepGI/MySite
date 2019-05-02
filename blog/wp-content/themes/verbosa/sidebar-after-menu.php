<?php
/**
 * The Sidebar Area that is normally displayed after the main navigation (Secondary).
 *
 * @package Verbosa
 */
?>

<aside id="secondary" class="widget-area sidey" role="complementary" <?php cryout_schema_microdata('sidebar');?>>
<?php cryout_before_secondary_widgets_hook(); ?>

		<?php if ( is_active_sidebar('sidebar-1') ) { 
				dynamic_sidebar( 'sidebar-1' );
		} ?>

	<?php cryout_after_secondary_widgets_hook(); ?>
</aside>
