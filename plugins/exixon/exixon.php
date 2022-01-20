<?php

/**
* Plugin Name:       Exixon
* Plugin URI:        https://example.com/plugins/the-basics/
* Description:       Handle the basics with this plugin.
* Version:           1.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Junaid Khan
* Author URI:        https://author.example.com/
* Text Domain:       exixon
*/

defined( 'ABSPATH' ) or die( 'You cant access this file!' );

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use Inc\Activate;
use Inc\Deactivate;

if ( ! class_exists( 'ExixonPlugin' ) ) {

    class ExixonPlugin 
    {
        function __construct() {
            add_action( 'init', array( $this, 'exixon_custom_post_type' ) );
        }

        function register() {
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

            add_action( 'admin_menu', array( $this, 'exixon_admin_page' ) );

            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'exixon_admin_page_setting_links' ) );
        }

        function exixon_admin_page_setting_links( $links ) {
            $url = admin_url( 'admin.php?page=exixon_plugin' );
            $links[] = '<a href="' . $url . '">Settings</a>';
            return $links;
        }

        function exixon_admin_page() {
            $page_title     = 'Exixon Plugin';
            $menu_title     = 'Exixon';
            $capability     = 'manage_options';
            $menu_slug      = 'exixon_plugin';
            $function       = array( $this, 'exixon_admin_index' );
            $icon_url       = 'dashicons-store';
            $position       = 110;
            add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        }

        function exixon_admin_index() {
            require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
        }

        function exixon_custom_post_type() {
            register_post_type( 'book', [ 'public' => true, 'label' => 'Books' ] );
        }

        function enqueue_scripts() {
            // Enqueue Styles
            wp_enqueue_style( 'exixon-style', plugins_url( '/assets/css/exixon.css', __FILE__ ) );     

            // Enqueue Scriptss
            wp_enqueue_script( 'exixon-script', plugins_url( '/assets/css/exixon.js', __FILE__ ) );       
        }

        function enqueue_admin_scripts() {
            // Enqueue Styles  
            wp_enqueue_style( 'exixon-admin-style', plugins_url( '/assets/css/exixon-admin.css', __FILE__ ) );  

            // Enqueue Scripts    
            wp_enqueue_script( 'exixon-admin-script', plugins_url( '/assets/css/exixon-admin.js', __FILE__ ) );  
        }

        function activate() {
            // require_once plugin_dir_path( __FILE__ ) . 'inc/exixon-plugin-activate.php';
            Activate::activate();
        }

        function deactivate() {
            // require_once plugin_dir_path( __FILE__ ) . 'inc/exixon-plugin-deactivate.php';
            Deactivate::deactivate();
        }
    }


    $exixonPlugin = new ExixonPlugin();
    $exixonPlugin->register();

    // Activation
    register_activation_hook( __FILE__, array( $exixonPlugin, 'activate' ) );

    // Deactivation
    register_deactivation_hook( __FILE__, array( $exixonPlugin, 'deactivate' ) );

}











































