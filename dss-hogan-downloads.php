<?php
/**
 * Plugin Name: DSS Hogan Module: Downloads
 * Plugin URI: https://github.com/dss-web/dss-hogan-downloads
 * GitHub Plugin URI: https://github.com/dss-web/dss-hogan-downloads
 * Description: DSS Download Module for Hogan.
 * Version: 1.0.1
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: dss-hogan-downloads
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );

namespace Dekode\DSS\Hogan\Downloads;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_register_module' );

/**
 * Register module text domain
 */
function hogan_load_textdomain() {
	\load_plugin_textdomain( 'dss-hogan-downloads', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 */
function hogan_register_module( \Dekode\Hogan\Core $core ) {
	require_once 'class-dss-downloads.php';
	$core->register_module( new \Dekode\Hogan\DSS_Downloads() );
}