<?php
/**
 * Plugin Name: TMS Network Site List
 * Plugin URI: https://github.com/devgeniem/tms-plugin-network-site-list
 * Description: Provides a REST endpoint that lists the sites in a network installation.
 * Version: 1.2.0
 * Requires PHP: 8.1
 * Author: Geniem Oy
 * Author URI: https://geniem.com
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

use TMS\Plugin\NetworkSiteList\NetworkSiteListPlugin;

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
NetworkSiteListPlugin::init( $plugin_version, $plugin_path );

if ( ! function_exists( 'tms_network_site_list' ) ) {
    /**
     * Get the NetworkSiteListPlugin plugin instance.
     *
     * @return NetworkSiteListPlugin
     */
    function tms_network_site_list() : NetworkSiteListPlugin {
        return NetworkSiteListPlugin::plugin();
    }
}
