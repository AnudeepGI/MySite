<?php
/**
 * Dashboard functionality
 *
 * @package Cryout Framework
 * @since Cryout Framework 0.5.1
 */

// Settings management function
function cryout_savesettings($options = array()) {
	if (!function_exists('json_encode')) return __('Your server does not support the needed functionality to manage theme settings.','cryout');
		else return str_replace('\'','&#039;',json_encode($options));
} // cryout_saveoptions()

// Load theme settings
function cryout_loadsettings() {
	check_admin_referer( 'cryout-special-string', _CRYOUT_THEME_NAME.'_settings_nonce' );
	if (! current_user_can('edit_theme_options') ) {
		die( __('Sorry, but you do not have sufficient permissions to access this page.','cryout') );
	}
	if (!function_exists('json_encode')) die(__('Your server does not support the needed functionality to manage theme settings.','cryout'));
	if (!empty($_POST[_CRYOUT_THEME_NAME.'_settings'])) {
		$data = str_replace('&#039;','\'',rawurldecode( trim($_POST[_CRYOUT_THEME_NAME.'_settings'])) );
		$data = @json_decode($data, TRUE);
		if (is_array($data) && isset($data[_CRYOUT_THEME_NAME.'_db']) && (0.9 == (float)$data[_CRYOUT_THEME_NAME.'_db']) ) {
			delete_option( _CRYOUT_THEME_NAME.'_settings' );
			if (update_option( _CRYOUT_THEME_NAME.'_settings', $data)) {
				die('OK');
			} else {
				die(__('Unable to load theme options. Try again or check that the saved options are valid.','cryout'));
			}
		} else {
			die(__('The supplied theme settings text appears invalid. Make sure you pasted it entirely and without errors.','cryout'));
		}
	} else die(__('You did not enter any theme settings. Remember to paste saved theme settings.','cryout'));
} // cryout_loadsettings();
add_action('wp_ajax_cryout_loadsettings_action', 'cryout_loadsettings');

// Truncate function for use in the Admin RSS feed
function cryout_truncate_words($string,$words=20, $ellipsis=' ...') {
	 $new = preg_replace('/((\w+\W+\'*){'.($words-1).'}(\w+))(.*)/', '${1}', $string);
	 return $new.$ellipsis;
}

// Get theme RSS
function cryout_fetch_feed() {
	$theme_news = fetch_feed( array( 'http://www.cryoutcreations.eu/cat/wordpress-themes/'.cryout_sanitize_tnp(_CRYOUT_THEME_NAME).'/feed/') );
	$maxitems = 0;
	if ( ! is_wp_error( $theme_news ) ) {
			$maxitems = $theme_news->get_item_quantity( 10 );
			$news_items = $theme_news->get_items( 0, $maxitems );
	}
	?>
         <ul class="news-list">
            <?php if ( $maxitems == 0 ) : echo '<li>' . __( 'No update news.', 'cryout' ) . '</li>'; else :
						foreach( $news_items as $news_item ) : ?>
                    	<li>
                        	<a class="news-header" target="_blank" href='<?php echo esc_url( $news_item->get_permalink() ); ?>'><?php echo esc_html( $news_item->get_title() ); ?></a>
							<span class="news-item-date"><?php _e('Posted on','cryout'); echo $news_item->get_date(' j F Y'); ?></span>
							<a class="news-more" target="_blank" href='<?php echo esc_url( $news_item->get_permalink() ); ?>'><?php _e('Read the full post','cryout');?> &#8594;</a>
                        </li>
						<?php endforeach;
				endif; ?>
          </ul>
<?php die();
} // cryout_fetch_feed()
add_action('wp_ajax_cryout_feed_action', 'cryout_fetch_feed');
