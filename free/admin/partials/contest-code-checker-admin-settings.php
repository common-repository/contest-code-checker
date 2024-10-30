<?php
/**
 * Provide a admin area settings view for the plugin
 *
 *
 * @link       http://www.swimordiesoftware.com
 * @since      1.0.0
 *
 * @package    Contest_Code_Checker
 * @subpackage Contest_Code_Checker/admin/partials
 */

/**
 * Displays the admin settings area
 */
class CCC_Contest_Code_Checker_Admin_Settings {

	public function display_settings() {
		global $wpdb;

		$settings_saved_once = get_option( 'ccc_start_date' );
		$num_contest_codes = $wpdb->get_var( "SELECT count(*) FROM $wpdb->posts WHERE post_type = 'ccc_codes'" );
		$shortcode_added = false;
		$query_string = array(
			's'        => '[contest_code_checker]',
			'sentence' => 1,
		);

		$query     = new WP_Query( $query_string );
		$event_url = '';
		if ( $query->have_posts() ) {
			$shortcode_added = true;
		}
		wp_reset_postdata();
		$correct_image = plugins_url( 'free/public/images/check_mark.png', CCC_FREE_PLUGIN_FILE );
		$error_image = plugins_url( 'free/public/images/error.png', CCC_FREE_PLUGIN_FILE );;
	?>
		<div class="wrap">
			<?php if( isset($_GET['settings-updated']) ) { ?>
			<div id="message" class="updated">
        		<p><strong><?php _e('Settings saved.') ?></strong></p>
    		</div>
			<?php } ?>
			<h1><?php _e( 'ContestsWP Settings', 'contest-code' ); ?></h1>
			<div id="ccc_ready_checklist_container">
				<h3><?php _e( 'ContestsWP Setup Checklist', 'contest-code' ); ?></h3>
				<p><span class="ccc_checklist_image_icon"><img src="<?php echo ( $settings_saved_once !== false ) ? $correct_image : $error_image; ?>" width="20" /></span><?php _e( 'Customized settings', 'contest-code' ); ?></p>
				<p><span class="ccc_checklist_image_icon"><img src="<?php echo ( $num_contest_codes > 0 ) ? $correct_image : $error_image; ?>" width="20" /></span><a href="<?php echo admin_url( '/admin.php?page=contest-codes' ); ?>"><?php _e( 'Add contests codes', 'contest-code' ); ?></a></p>
				<p><span class="ccc_checklist_image_icon"><img src="<?php echo ( $shortcode_added ) ? $correct_image : $error_image; ?>" width="20" /></span><?php _e( 'Add <code>[contest_code_checker]</code> to a page or post', 'contest-code' ); ?></p>
			</div>
			<form method="post" action="options.php">
				<?php
					settings_fields("contest_code_checker_options");
					do_settings_sections("ccc_options");
					submit_button();
				?>
			</form>
		</div>
	<?php
	}
}
