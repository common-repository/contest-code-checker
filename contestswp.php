<?php

/**
 * Plugin Name: ContestsWP
 * Plugin URI:  https://www.contestswp.com
 * Version: 2.0.3
 * Description: ContestsWP makes it easy to create and run contests and giveaways on your WordPress site.
 *
 * @wordpress-plugin
 * Description:       Maintain a list of contest codes and have users check to see if they have won anything
 * Version:           2.0.3
 * Author:            Swim or Die Software
 * Author URI:        http://www.swimordiesoftware.com
 * Domain Path:       /languages
 *
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
if ( !function_exists( 'boolval' ) ) {
    function boolval(  $val  ) {
        return (bool) $val;
    }

}
if ( function_exists( 'cccp_my_fs' ) ) {
    cccp_my_fs()->set_basename( false, __FILE__ );
} else {
    if ( !function_exists( 'cccp_my_fs' ) ) {
        /**
         * Initializes the freemius integration for the contest code checker set of plugins.
         *
         * @return Object The freemius configuration array.
         */
        function cccp_my_fs() {
            global $cccp_my_fs;
            if ( !isset( $cccp_my_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_5652_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_5652_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $cccp_my_fs = fs_dynamic_init( array(
                    'id'             => '5652',
                    'slug'           => 'contestswp',
                    'premium_slug'   => 'contest-code-checker-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_2929116a50a12d4005e8be849b559',
                    'is_premium'     => false,
                    'premium_suffix' => 'Premium',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                        'slug'    => 'contest-code-checker',
                        'support' => false,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $cccp_my_fs;
        }

    }
    if ( !cccp_my_fs()->is_premium() ) {
        require_once dirname( __FILE__ ) . '/free/contestswp-free.php';
    }
}