<?php

/*

Plugin Name: Ajax
Plugin URI: https://example:com/
Description: A wordpress plugin for sending bulk SMS using Twilio
Version:  1.0.0
Author: JK

*/

class Ajax 
{

    public $pluginName = "ajax";

    public function ajaxSMSList(){
        global $wpdb;

        if (!in_array('ajaxSMSList', $wpdb->tables)) {
       
            $charset_collate = $wpdb->get_charset_collate();

            $tableName = $wpdb->prefix . 'ajaxSMSList';

            $sql = "CREATE TABLE $tableName (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title tinytext NOT NULL,
            date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            numbers text NOT NULL,
            message text NOT NULL,
            status boolean DEFAULT TRUE,
            PRIMARY KEY  (id)
            ) $charset_collate;";
    
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
       
    }

    public function registerAjaxSmsPage()
    {
        // Create our settings page as a submenu page.
        add_submenu_page(
            "tools.php", // parent slug
            __("Ajax SMS PAGE", $this->pluginName . "-sms"), // page title
            __("Ajax SMS", $this->pluginName . "-sms"), // menu title
            "manage_options", // capability
            $this->pluginName . "-sms", // menu_slug
            [$this, "displayAjaxSmsPage"] // callable function
        );
    }

    /**
     * Display the sms page - The page we are going to be sending message from.
     *  @since    1.0.0
     */
    public function displayAjaxSmsPage()
    {

        include_once "sendex-admin-sms-page.php";
    }
   

}

// Create a new Ajax instance
$ajaxInstance = new Ajax();
// Add setting menu item
add_action("admin_init", [$ajaxInstance , 'ajaxSMSList']);
// Hook our sms page
add_action("admin_menu", [$ajaxInstance , "registerAjaxSmsPage"]);

 
function ajax_widget_enqueue_script() {   
    wp_register_style( 'ajaxsmslist-jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css' );
    wp_enqueue_style( 'ajaxsmslist-jquery-ui' ); 
    wp_enqueue_script( 'ajaxsmslist-jquery-ui-datepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js');
    wp_enqueue_script( 'ajaxsmslist-script', plugins_url( '/assets/js/script.js', __FILE__ ));
    wp_enqueue_script( 'ajaxsmslist-javascript', plugins_url( '/assets/js/javascript.js', __FILE__ ));
    // wp_enqueue_style( 'ajaxsmslist-bootstrap-style', plugins_url( '/assets/css/bootstrap.min.css', __FILE__ ));
    wp_enqueue_style( 'ajaxsmslist-style', plugins_url( '/assets/css/style.css', __FILE__ ));
    wp_register_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, '1.0', 'all' );
    wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
}
add_action('admin_enqueue_scripts', 'ajax_widget_enqueue_script');



// add_filter('cron_schedules', 'my_schedule');
// function my_schedule($schedules)
// {
//     $schedules['once_every_10_sec'] = array(
//         'interval' => 10, 
//         'display' => esc_html__('Once every 10 seconds')
//     );
//     return $schedules;
// }

// if (!wp_next_scheduled('jk_cron_hook'))
// {
//     global $wpdb;
//     $table_name = $wpdb->prefix . "ajaxsmslist"; 
//     $wpdb->query("SELECT time FROM $table_name");
//     $time = 'time';
//     wp_schedule_event($time, 'once_every_10_sec', 'jk_cron_hook');
// }
// add_action('jk_cron_hook', 'function_that_should_be_execute');

// function function_that_should_be_execute()
// {
//     $arg = [
//         'post_title' => 'Post with cron job every 10 sec',
//     ];
//     wp_insert_post($arg);
// }


add_filter('cron_schedules', 'post_schedules');
function post_schedules($schedule)
{
    $schedule['once_every_10_sec'] = array(
        'interval' => 7200, 
        'display' => esc_html__('Once every 10 Sec')
    );
    return $schedule;
}

if (!wp_next_scheduled('jk_post_cron_hook'))
{
    // global $wpdb;
    // $table_name = $wpdb->prefix . "ajaxsmslist"; 
    // $time = 'time';
    // $res = $wpdb->query("SELECT time FROM $table_name");
    
    wp_schedule_event(time(), 'once_every_10_sec', 'jk_cron_hook');
}
add_action('jk_post_cron_hook', 'function_that_should_be_executed_post');

function function_that_should_be_executed_post()
{
    $arg = [
        'post_title' => 'Post with cron job every 10 sec',
    ];
    wp_insert_post($arg);
}
