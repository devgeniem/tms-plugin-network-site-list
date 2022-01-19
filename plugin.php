<?php
/**
 * Plugin Name: {{plugin-name}}
 * Plugin URI: https://github.com/devgeniem/tms-plugin-boilerplate
 * Description: {{plugin-description}}
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Author: Geniem Oy
 * Author URI: https://geniem.com
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: {{text-domain}}
 * Domain Path: /languages
 */

use Tms\Plugin\Boilerplate\Plugin;

// Check if Composer has been initialized in this directory.
// Otherwise we just use global composer autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Get the plugin version.
$plugin_data    = get_file_data( __FILE__, [ 'Version' => 'Version' ], 'plugin' );
$plugin_version = $plugin_data['Version'];

$plugin_path = __DIR__;

// Initialize the plugin.
Plugin::init( $plugin_version, $plugin_path );

if ( ! function_exists( 'boilerplate' ) ) {
    /**
     * Get the {{plugin-name}} plugin instance.
     *
     * @return Plugin
     */
    function boilerplate() : Plugin {
        return Plugin::plugin();
    }
}
