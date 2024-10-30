<?php
/**
 * @link              http://www.swimordiesoftware.com
 * @since             1.0.0
 * @package           Contest_Code_Checker
 * @version 1.1.9
 *
 * @wordpress-plugin
 * Plugin Name:       ContestsWP Free
 * Plugin URI:        https://wordpress.org/plugins/contest-code-checker/
 * Description:       ContestsWP makes it easy to create and run contests and giveaways on your WordPress site.
 * Author:            Swim or Die Software
 * Author URI:        http://www.swimordiesoftware.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contest-code
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!function_exists('boolval')) {
        function boolval($val) {
                return (bool) $val;
        }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_contest_code_checker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contest-code-checker-activator.php';
	CCC_Contest_Code_Checker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_contest_code_checker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-contest-code-checker-deactivator.php';
	CCC_Contest_Code_Checker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_contest_code_checker' );
register_deactivation_hook( __FILE__, 'deactivate_contest_code_checker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-contest-code-checker.php';

/**
 * Uninstall function for the free version of ContestsWP.
 */
function uninstall_free_contestswp() {
	// If uninstall not called from WordPress, then exit.
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit;
	}

	// Delete contest codes & contestants.
	$ccc_post_types = array( 'ccc_codes', 'ccc_contestants' );
	$posts = get_posts( array( 'post_type' => $ccc_post_types, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) );

	if ( $posts ) {
		foreach ( $posts as $p ) {
			wp_delete_post( $p, true);
		}
	}

	// Unregister options.
	delete_option( 'ccc_start_date' );
	delete_option( 'ccc_end_date' );
	delete_option( 'ccc_text_winning' );
	delete_option( 'ccc_text_losing' );
	delete_option( 'ccc_contest_not_running' );
	delete_option( 'ccc_hide_email' );
	delete_option( 'ccc_hide_first_name' );
	delete_option( 'ccc_hide_last_name' );
	delete_option( 'ccc_enable_captcha' );
	delete_option( 'ccc_recaptcha_secret_api' );
	delete_option( 'ccc_recaptcha_site_key' );
}
if ( function_exists( 'cccp_my_fs' ) ) {
	cccp_my_fs()->add_action('after_uninstall', 'uninstall_free_contestswp');
}

/**
 * Creates the constant for location of the root directory for this plugin.
 */
function ccc_free_create_constants() {
	global $plugin, $mu_plugin, $network_plugin;

	$my_plugin_file = __FILE__;

	if ( isset( $plugin ) ) {
		$my_plugin_file = $plugin;
	} elseif ( isset( $mu_plugin ) ) {
		$my_plugin_file = $mu_plugin;
	} elseif ( isset( $network_plugin ) ) {
		$my_plugin_file = $network_plugin;
	}

	if ( ! defined( 'CCC_FREE_PLUGIN_FILE' ) ) {
		define( 'CCC_FREE_PLUGIN_FILE', $my_plugin_file );
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_contest_code_checker() {
	ccc_free_create_constants();
	$plugin = new CCC_Contest_Code_Checker();
	$plugin->run();

}
run_contest_code_checker();
