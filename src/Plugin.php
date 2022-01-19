<?php
/**
 * Copyright (c) 2021 Geniem Oy.
 */

namespace Tms\Plugin\Boilerplate;

/**
 * Class Plugin
 *
 * @package Tms\Plugin\Boilerplate
 */
final class Plugin {

    /**
     * Holds the singleton.
     *
     * @var Plugin
     */
    protected static $instance;

    /**
     * Current plugin version.
     *
     * @var string
     */
    protected $version = '';
    /**
     * Path to assets distribution versions.
     *
     * @var string
     */
    protected string $dist_path = '';
    /**
     * Uri to assets distribution versions.
     *
     * @var string
     */
    protected string $dist_uri = '';

    /**
     * Get the instance.
     *
     * @return Plugin
     */
    public static function get_instance() : Plugin {
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
     * Get the plugin directory uri.
     *
     * @return string
     */
    public function get_plugin_uri() : string {
        return $this->plugin_uri;
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
     * Get the plugin instance.
     *
     * @return Plugin
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
        $this->plugin_uri  = plugin_dir_url( $plugin_path ) . basename( $this->plugin_path );
        $this->dist_path   = $this->plugin_path . '/assets/dist/';
        $this->dist_uri    = $this->plugin_uri . '/assets/dist/';
    }

    /**
     * Add plugin hooks and filters.
     */
    protected function hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
    }

    /**
     * Enqueue public side scripts if they exist.
     */
    public function enqueue_public_scripts() {
        if ( file_exists( $this->dist_path . 'public.js' ) ) {
            wp_enqueue_script(
                'boilerplate-public-js',
                $this->dist_uri . 'public.js',
                [ 'jquery' ],
                $this->mod_time( 'public.js' ),
                true
            );
        }
    }

    /**
     * Enqueue admin side scripts if they exist.
     */
    public function enqueue_admin_scripts() {
        if ( file_exists( $this->dist_path . 'admin.css' ) ) {
            wp_enqueue_style(
                'boilerplate-admin-css',
                $this->dist_uri . 'admin.css',
                [],
                $this->mod_time( 'admin.css' ),
                'all'
            );
        }

        if ( file_exists( $this->dist_path . 'admin.js' ) ) {
            wp_enqueue_script(
                'boilerplate-admin-js',
                $this->dist_uri . 'admin.js',
                [ 'jquery' ],
                $this->mod_time( 'admin.js' ),
                true
            );
        }
    }

    /**
     * Get cache busting modification time or plugin version.
     *
     * @param string $file File inside assets/dist/ folder.
     *
     * @return int|string
     */
    private function mod_time( $file = '' ) {
        return file_exists( $this->dist_path . $file )
            ? (int) filemtime( $this->dist_path . $file )
            : $this->version;
    }
}
