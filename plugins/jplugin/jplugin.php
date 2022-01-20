<?php

/**
* Plugin Name:       JPlugin
* Plugin URI:        https://example.com/plugins/the-basics/
* Description:       Handle the basics with this plugin.
* Version:           1.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Junaid Khan
* Author URI:        https://author.example.com/
* Text Domain:       jplugin
*/

if (!defined( 'ABSPATH' )) {
	exit();
} 

class WpSuper {

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
		
	}

	public function init() {
		$this->plugins_url = untrailingslashit(plugins_url('', __FILE__));
	}

	// Activated Plugin
	public function activationHook() {
		if (!get_option('wp_Super')) {
			update_option('wp_Super', 'jsuper');
		}
	}

	// Deactivated Plugin
	public function deactivationHook() {
		delete_option('wp_Super');
	}

	// Uninstall Plugin
	public function uninstallHook() {
		delete_option('wp_Super');
	}

	// Header
	public function filter_header() {
		wp_enqueue_style('super-link-css', $this->plugins_url.'/assets/css/jstyle.css', array());
	}

	// Footer
	public function filter_footer() {
		$wp_super = get_option('wp_Super');
		?>
			<div id="wpsuper"><?php echo $wp_super; ?></div>
		<?php
	}

}

$WpSuper = new WpSuper();