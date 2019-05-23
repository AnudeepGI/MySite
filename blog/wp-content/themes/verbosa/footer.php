<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of #main and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package Verbosa
 */
?>
		<div style="clear:both;"></div>

	</div><!-- #content -->

	<aside id="colophon" role="complementary" <?php verbosa_footer_colophon_class(); cryout_schema_microdata('sidebar');?>>
		<div id="colophon-inside">
			<?php get_sidebar( 'footer' );?>
		</div>
	</aside><!-- #colophon -->

<?php cryout_after_footer_hook(); ?>
<?php wp_footer(); ?>
</body>
</html>
