<?php

/**
* Plugin Name:       JK ScrollToTop
* Plugin URI:        https://example.com/plugins/the-basics/
* Description:       Handle the basics with this plugin.
* Version:           1.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Junaid Khan
* Author URI:        https://author.example.com/
* Text Domain:       jk_scrolltotop
*/

if (!defined( 'ABSPATH' )) {
	exit();
} 

class jkScrollToTop {

	public $plugins_url = '';

	public function __construct() {

		// Activated Plugin
		if (function_exists('register_activation_hook')) {
			register_activation_hook( __FILE__, array($this, 'activationHook'));
		}

		// Deactivated Plugin
		if (function_exists('register_deactivation_hook')) {
			register_deactivation_hook( __FILE__, array($this, 'deactivationHook' ));
		}

		// Unistall Plugin
		if (function_exists('register_uninstall_hook')) {
			register_uninstall_hook( __FILE__, $this, 'uninstallHook' );
		}

		// Header Hook
		add_action('wp_head', array($this, 'filter_header'));

		// Footer Hook
		add_filter('wp_footer', array($this, 'filter_footer'));

		//Init
		add_action('init', array($this, 'init'));

		//admin page
        add_action('admin_menu', array($this, 'jk_scroll_to_top_admin_menu'));
		
	}

	public function init() {
		$this->plugins_url = untrailingslashit(plugins_url('', __FILE__));
	}

	//Include the admin page
	public function jk_scroll_to_top_admin_menu() {
		add_options_page('JK Scroll To Top', 'JK Scroll To Top setting' , 'manage_options' , 'jk_scroll_to_top_admin_menu',array($this, 'jk_scroll_to_top_edit_setting'));
	}

	//Link the admin page
	public function jk_scroll_to_top_edit_setting()
	{
		include(sprintf("inc/jk_scroll_to_top_admin.php", dirname(__FILE__)));
	}

	// Activated Plugin
	public function activationHook() {
		if (!get_option('jk_scroll_to_top_color')) {
			update_option('jk_scroll_to_top_color', 'black');
		}
		if (!get_option('jk_scroll_to_top_speed')) {
			update_option('jk_scroll_to_top_speed', 'slow');
		}
	}

	// Deactivated Plugin
	public function deactivationHook() {
		delete_option('jk_scroll_to_top_color');
		delete_option('jk_scroll_to_top_speed');
	}

	// Uninstall Plugin
	public function uninstallHook() {
		delete_option('jk_scroll_to_top_color');
		delete_option('jk_scroll_to_top_speed');
	}

	// Header
	public function filter_header() {
		include(sprintf('assets/css/jk-scroll-to-top-style.php', dirname(__FILE__)));

        wp_enqueue_script('jquery');
		include(sprintf('assets/js/jk-scroll-to-top-script.php', dirname(__FILE__)));
	}

	// Echo "to top" button on to the footer section
    public function filter_footer()
    {
        ?>
            <div id="To_top_animate" class="To_top_btn"><a href="#" >▲</a></div>
        <?php
    }

}

$jkScrollToTop = new jkScrollToTop();