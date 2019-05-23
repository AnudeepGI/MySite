<?php
/**
 * Admin theme page
 *
 * @package Verbosa
 */
 
// Framework
require_once( get_template_directory() . "/cryout/framework.php" );

// Theme particulars
require_once( get_template_directory() . "/admin/defaults.php" );
require_once( get_template_directory() . "/admin/options.php" );
//require_once( get_template_directory() . "/includes/tgmpa.php" );

// Custom CSS Styles for customizer
require_once( get_template_directory() . "/includes/custom-styles.php" );

// Get the theme options and make sure defaults are used if no values are set
function verbosa_get_theme_options() {
	$optionsVerbosa = wp_parse_args(
		get_option( 'verbosa_settings', array() ),
		verbosa_get_option_defaults()
	);
	return apply_filters( 'verbosa_theme_options_array', $optionsVerbosa );
} // verbosa_get_theme_options()

function verbosa_get_theme_structure() {
	global $verbosa_big;
	return apply_filters( 'verbosa_theme_structure_array', $verbosa_big );
} // verbosa_get_theme_structure()

// load up theme options
$cryout_theme_settings = apply_filters( 'verbosa_theme_structure_array', $verbosa_big );
$cryout_theme_options = verbosa_get_theme_options();
$cryout_theme_defaults = verbosa_get_option_defaults();

// Hooks/Filters
add_action( 'admin_menu', 'verbosa_add_page_fn' );

// Add admin scripts
function verbosa_admin_scripts($hook) {
	global $verbosa_page;
	if( $verbosa_page != $hook ) {
        return;
    }

	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_style( 'verbosa-admin-style', get_template_directory_uri() . '/admin/css/admin.css', NULL, _CRYOUT_THEME_VERSION );
	wp_enqueue_script( 'verbosa-admin-js', get_template_directory_uri() . '/admin/js/admin.js', array('jquery-ui-dialog'), _CRYOUT_THEME_VERSION );
}

// Create admin subpages
function verbosa_add_page_fn() {
	global $verbosa_page;
	$verbosa_page = add_theme_page( __('Verbosa Theme', 'verbosa'), __('Verbosa Theme','verbosa'), 'edit_theme_options', 'about-verbosa-theme', 'verbosa_page_fn');
	add_action( 'admin_enqueue_scripts', 'verbosa_admin_scripts' );
} // verbosa_add_page_fn()


// Display the admin options page
function verbosa_page_fn() {

	$verbosas = cryout_get_option();

	if (!current_user_can('edit_theme_options'))  {
		wp_die( __( 'Sorry, but you do not have sufficient permissions to access this page.','verbosa') );
	}

?>
<div class="wrap" id="main-page"><!-- Admin wrap page -->
	<div id="lefty">
	<?php if( isset($_GET['settings-loaded']) ) { ?>
		<div class="updated fade">
			<p><?php _e('Verbosa settings loaded successfully.', 'verbosa') ?></p>
		</div> <?php
	} ?>
	<?php
	// Reset settings to defaults if the reset button has been pressed
	if ( isset( $_POST['verbosa_reset_defaults'] ) ) {
		delete_option( 'verbosa_settings' ); ?>
		<div class="updated fade">
			<p><?php _e('Verbosa settings have been reset successfully.', 'verbosa') ?></p>
		</div> <?php
	} ?>

		<div id="admin_header">
			<img src="<?php echo get_template_directory_uri() . '/admin/images/logo-about-top.png' ?>" />
			<span id="version">
				Verbosa Theme v<?php echo _CRYOUT_THEME_VERSION; ?> by
				<a href="https://www.cryoutcreations.eu" target="_blank">Cryout Creations</a>
			</span>
		</div>

		<div id="admin_links">
			<a href="https://www.cryoutcreations.eu/wordpress-themes/verbosa" target="_blank"><?php _e( 'Verbosa Homepage', 'verbosa' ) ?></a>
			<a href="https://www.cryoutcreations.eu/forum" target="_blank"><?php _e( 'Theme Support', 'verbosa' ) ?></a>
			<a href="https://www.cryoutcreations.eu" target="_blank">Cryout Creations</a>
		</div>


		<div id="description">
			<?php _e( "<p>You wake up and you're a WordPress theme. You have a funny yet resonating name. You can't quite recall it but it's definitely a feminine name,
			one word, ending with the vowel 'a'. Always ending with that darn vowel - that's a clear trademark for a Cryout Creations theme.</p>
			<p>People are always checking you out, previewing your lines, curves and colors. Always keeping you in the spotlight, they're testing various elements,
			checking to see if you can satisfy their specific needs, if you can fit within the confines of their preconceived ideas of a perfect theme.
			And when you do fit that description- the install button is pressed and the horror begins...</p>
			<p>Articles and pages are constantly added, edited, sometimes deleted. Countless plugins are cramped in, all shapes and sizes,
			shamelessly biting at the fringes of compatibility. And when that compatibility does fail, you're always the one to take the blame.
			And so you're always being tampered with by those damned developers, adding patch over patch over patch, relentlessly changing you
			(they use the word 'improving' but we all know that's a lie) until you barely resemble your initial form.</p>
			<p>And since you're a Cryout Creations theme, people can, and will, customize you a great deal. You're one but you're not the same.
			Different layouts, color schemes, fonts, widgets - you name it and it's customizable. It's near impossible for you to know who you really are anymore,
			a myriad of personas and you can't relate with any of them. Plus, with the whole responsive trend lately, they keep putting you in all these tight,
			uncomfortable places and expect you to just act natural.</p>
			<p>And sometimes, after all this probing and poking around, they decide you're simply not good enough. You don't fit with the subject matter.
			You're too dark. Too round. Not enough umph. So they choose another theme, the first that shows up in search, some soulless Twenty-something
			theme and then just move on. And that- that is the worst. You feel dirty, used and abandoned. But somehow you must move on as well,
			because another download is in progress and that Install button is about to be pressed once more... </p>
			<p>You wake up and you're a WordPress theme. You don't know your name but that's all right. </p>", "verbosa" );?>
		</div>

		<a class="button" href="customize.php" id="customizer"> <?php _e( 'Customize Verbosa', 'verbosa'); ?> </a>

	</div><!--lefty -->


	<div id="righty" >
		<div id="verbosa-donate" class="postbox donate">

			<h3 class="hndle"> Coffee Break </h3>
			<div class="inside">
			<?php _e( "<p>This is a desperate cry for help. We've been awake non-stop for several months now and it's getting harder and harder to keep our eyes open.
			We can't tell what's real from what our own tired brains fabricate anymore. We live in constant fear, just one lullaby away from eternal suffering.</p>

			<p>Unbelievable as it may sound, Freddy Krueger is out to get us. There's not enough time (or space) to explain how it's come to this but he's waiting
			for us to fall asleep so he can trap and torture us in our own dreams and make us create themes for nightmares (whatever that means). </p>

			<p>So after much though we've come to the conclusion that the only way to beat this is to stay awake until he dies of old age.
			But in order for us to stay awake that long, we'd need some sort of stimulant. So, unless you have a better idea,
			we'd really appreciate it if you'd...  </p>", "verbosa" );?>
				<div style="display:block;float:none;margin:0 auto;text-align:center;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="KYL26KAN4PJC8">
						<input type="hidden" name="item_name" value="Cryout Creations - Verbosa Theme">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHosted">
						<input type="image" src="<?php echo get_template_directory_uri() . '/admin/images/coffee.png' ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>

			</div><!-- inside -->

		</div><!-- donate -->

		<div id="verbosa-export" class="postbox export" >

			<h3 class="hndle"><?php _e( 'Settings Management', 'verbosa' ); ?></h3>
			<div class="panel-wrap inside">

				<input id="verbosa-themesettings" name="verbosa-themesettings" type="hidden" value="<?php echo htmlentities(cryout_savesettings($verbosas)) ?>">
				<button class="button" id="verbosa-savesettings-button"> <?php _e('Save Theme Settings', 'verbosa'); ?> </button>
				<br />

				<button class="button" id="verbosa-loadsettings-button"> <?php _e('Load Theme Settings', 'verbosa'); ?> </button>
				<br />

				<form action="" method="post">
					<input type="hidden" name="verbosa_reset_defaults" value="true" />
					<input type="submit" class="button" id="verbosa_reset_defaults" value="<?php _e('Reset to Defaults','verbosa'); ?>" />
				</form>

				<div id="verbosa-settings-dialog" title="Settings Management">
				  <p>
					<strong><?php _e('Copy-paste all the information below to a file of your choosing and save it to a safe location.','verbosa') ?></strong>
					<strong><?php _e('Paste your previously saved settings in the field below and press the Load button.<br><u>All your current settings will be overwritten!</u>','verbosa') ?></strong><br>
					<br>
					<textarea id="verbosa-themesettings-textarea"></textarea>
					<input name="verbosa-settings-nonce" id="verbosa-settings-nonce" type="hidden" value="<?php echo wp_create_nonce( "cryout-special-string" ); ?>">
				  </p>
				</div>


			</div><!-- inside -->

		</div><!-- export -->

		<div id="verbosa-news" class="postbox news" >
			<h3 class="hndle"><?php _e( 'Theme Updates', 'verbosa' ); ?></h3>
			<div class="panel-wrap inside">
			</div><!-- inside -->
		</div><!-- news -->

	</div><!--  righty -->
</div><!--  wrap -->

<script type="text/javascript">
var reset_confirmation = '<?php echo esc_html(__('Reset Verbosa Settings to Defaults?', 'verbosa')); ?>';
</script> <?php
} // verbosa_page_fn()
