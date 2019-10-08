<?php
/**
 * Plugin Name: Custom Api Data Woocommerce Users
 * Plugin URI:
 * Description:
 * Version:     0.1.0
 * Author:      JuanJavier1979
 * Author URI:  https://github.com/JuanJavier1979
 * Text Domain: custom-api-data-woocommerce-users
 * Domain Path: /languages
 *
 * @package CustomApiDataWoocommerceUsers
 */

// Useful global constants.
define( 'CUSTOM_API_DATA_WOOCOMMERCE_USERS_VERSION', '0.1.0' );
define( 'CUSTOM_API_DATA_WOOCOMMERCE_USERS_URL', plugin_dir_url( __FILE__ ) );
define( 'CUSTOM_API_DATA_WOOCOMMERCE_USERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'CUSTOM_API_DATA_WOOCOMMERCE_USERS_INC', CUSTOM_API_DATA_WOOCOMMERCE_USERS_PATH . 'includes/' );

// Include files.
require_once CUSTOM_API_DATA_WOOCOMMERCE_USERS_INC . 'functions/core.php';
require_once CUSTOM_API_DATA_WOOCOMMERCE_USERS_INC . 'functions/tab.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\CustomApiDataWoocommerceUsers\Core\activate' );
register_deactivation_hook( __FILE__, '\CustomApiDataWoocommerceUsers\Core\deactivate' );

// Bootstrap.
CustomApiDataWoocommerceUsers\Core\setup();
CustomApiDataWoocommerceUsers\Tab\setup();

// Require Composer autoloader if it exists.
if ( file_exists( CUSTOM_API_DATA_WOOCOMMERCE_USERS_PATH . '/vendor/autoload.php' ) ) {
	require_once CUSTOM_API_DATA_WOOCOMMERCE_USERS_PATH . 'vendor/autoload.php';
}
