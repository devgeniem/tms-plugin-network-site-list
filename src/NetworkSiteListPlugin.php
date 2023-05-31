<?php
/**
 * Copyright (c) 2021 Geniem Oy.
 */

namespace TMS\Plugin\NetworkSiteList;

/**
 * Class Plugin
 *
 * @package TMS\Plugin\NetworkSiteList
 */
final class NetworkSiteListPlugin {

    /**
     * Holds the singleton.
     *
     * @var NetworkSiteListPlugin
     */
    protected static $instance;

    /**
     * Current plugin version.
     *
     * @var string
     */
    protected $version = '';

    /**
     * Get the instance.
     *
     * @return NetworkSiteListPlugin
     */
    public static function get_instance() : NetworkSiteListPlugin {
        return self::$instance;
    }

    /**
     * The plugin directory path.
     *
     * @var string
     */
    protected $plugin_path = '';

    /**
     * The plugin root uri without trailing slash.
     *
     * @var string
     */
    protected $plugin_uri = '';

    /**
     * Route namespace.
     *
     * @var string
     */
    protected $route_namespace = 'tms';

    /**
     * Get the version.
     *
     * @return string
     */
    public function get_version() : string {
        return $this->version;
    }

    /**
     * Get the plugin directory path.
     *
     * @return string
     */
    public function get_plugin_path() : string {
        return $this->plugin_path;
    }

    /**
     * Initialize the plugin by creating the singleton.
     *
     * @param string $version     The current plugin version.
     * @param string $plugin_path The plugin path.
     */
    public static function init( $version = '', $plugin_path = '' ) {
        if ( empty( self::$instance ) ) {
            self::$instance = new self( $version, $plugin_path );
            self::$instance->hooks();
        }
    }

    /**
     * Register plugin hooks.
     */
    public function hooks() {
        add_action(
            'rest_api_init',
            [ $this, 'register_rest_routes' ]
        );

        // Remove the force login filter from the REST API.
        remove_filter(
            'rest_authentication_errors',
            'v_forcelogin_rest_access',
            99
        );
    }

    /**
     * Register REST routes.
     */
    public function register_rest_routes() {
        register_rest_route(
            $this->route_namespace,
            'sites',
            [
                'methods'             => 'GET',
                'callback'            => [ $this, 'route_site_list' ],
                'permission_callback' => '__return_true',
            ]
        );
    }

    /**
     * Endpoint for site listing.
     *
     * @return \WP_REST_Response
     */
    public function route_site_list() : \WP_REST_Response {
        $sites         = get_sites();
        $response_data = [];

        if ( ! empty( $sites ) ) {
            $response_data = array_map( function ( $site ) {
                return [
                    'ID'   => $site->blog_id,
                    'name' => $site->blogname,
                ];
            }, $sites );
        }

        return new \WP_REST_Response(
            $response_data,
            200
        );
    }

    /**
     * Get the plugin instance.
     *
     * @return NetworkSiteListPlugin
     */
    public static function plugin() {
        return self::$instance;
    }

    /**
     * Initialize the plugin functionalities.
     *
     * @param string $version     The current plugin version.
     * @param string $plugin_path The plugin path.
     */
    protected function __construct( $version = '', $plugin_path = '' ) {
        $this->version     = $version;
        $this->plugin_path = $plugin_path;
    }
}
