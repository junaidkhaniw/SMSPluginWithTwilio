<?php

/*

Plugin Name: Sendex
Plugin URI: https://example:com/
Description: A wordpress plugin for sending bulk SMS using Twilio
Version:  1.0.0
Author: JK

*/

require_once( plugin_dir_path( __FILE__ ) .'/twilio-lib/src/Twilio/autoload.php');
use Twilio\Rest\Client;

class Sendex 
{

    public $pluginName = "sendex";

    public function displaySendexSettingsPage() {
       include_once "sendex-admin-settings-page.php";
   }

   public function addSendexAdminOption() {
       add_options_page(
           "SENDEX SMS PAGE",
           "SENDEX",
           "manage_options",
           $this->pluginName,
           [$this, "displaySendexSettingsPage"]
       );

   }

   /**
     * Registers and Defines the necessary fields we need.
     *  @since    1.0.0
     */

    public function sendexSMSList(){
        global $wpdb;

        if (!in_array('sendexSMSList', $wpdb->tables)) {
       
            $charset_collate = $wpdb->get_charset_collate();

            $tableName = $wpdb->prefix . 'sendexSMSList';

            $sql = "CREATE TABLE $tableName (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            phonelist text NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
    
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
       
    }

    public function sendexAdminSettingsSave()
    {
        register_setting(
            $this->pluginName,
            $this->pluginName,
            [$this, "pluginOptionsValidate"]
        );
        add_settings_section(
            "sendex_main",
            "Main Settings",
            [$this, "sendexSectionText"],
            "sendex-settings-page"
        );
        add_settings_field(
            "api_sid",
            "API SID",
            [$this, "sendexSettingSid"],
            "sendex-settings-page",
            "sendex_main"
        );
        add_settings_field(
            "api_auth_token",
            "API AUTH TOKEN",
            [$this, "sendexSettingToken"],
            "sendex-settings-page",
            "sendex_main"
        );
        add_settings_field(
            "api_phone_number",
            "Sender Number",
            [$this, "sendexSettingPhone"],
            "sendex-settings-page",
            "sendex_main"
        );
    }

    /**
     * Displays the settings sub header
     *  @since    1.0.0
     */
    public function sendexSectionText()
    {
        echo '<h3 style="text-decoration: underline;">Edit api details</h3>';
    }

    /**
     * Renders the sid input field
     *  @since    1.0.0
     */
    public function sendexSettingSid()
    {
        $options = get_option($this->pluginName);
        echo "
            <input
                id='$this->pluginName[api_sid]'
                name='$this->pluginName[api_sid]'
                size='40'
                type='text'
                value='{$options['api_sid']}'
                placeholder='Enter your API SID here'
            />
        ";
    }

    /**
     * Renders the auth_token input field
     *
     */
    public function sendexSettingToken()
    {
        $options = get_option($this->pluginName);
        echo "
            <input
                id='$this->pluginName[api_auth_token]'
                name='$this->pluginName[api_auth_token]'
                size='40'
                type='text'
                value='{$options['api_auth_token']}'
                placeholder='Enter your API AUTH TOKEN here'
            />
        ";
    }

    public function sendexSettingPhone()
    {

        
        $options = get_option($this->pluginName);
        echo "
            <input
                id='$this->pluginName[api_phone_number]'
                name='$this->pluginName[api_phone_number]'
                size='40'
                type='text'
                value='{$options['api_phone_number']}'
                placeholder='Enter your Sender Phone here'
            />
        ";
    }

    /**
     * Sanitizes all input fields.
     *
     */
    public function pluginOptionsValidate($input)
    {
        $newinput["api_sid"] = trim($input["api_sid"]);
        $newinput["api_auth_token"] = trim($input["api_auth_token"]);
        $newinput["api_phone_number"] = trim($input["api_phone_number"]);
        return $newinput;
    }



    /**
     * Register the sms page for the admin area.
     *  @since    1.0.0
     */
    public function registerSendexSmsPage()
    {
        // Create our settings page as a submenu page.
        add_submenu_page(
            "tools.php", // parent slug
            __("SENDEX SMS PAGE", $this->pluginName . "-sms"), // page title
            __("SENDEX SMS", $this->pluginName . "-sms"), // menu title
            "manage_options", // capability
            $this->pluginName . "-sms", // menu_slug
            [$this, "displaySendexSmsPage"] // callable function
        );
    }

    /**
     * Display the sms page - The page we are going to be sending message from.
     *  @since    1.0.0
     */
    public function displaySendexSmsPage()
    {

        include_once "sendex-admin-sms-page.php";
    }

   
    public function send_message()
    {
        if (!isset($_POST["send_sms_message"])) {
            return;
        }

        $numbers      = (isset($_POST["numbers"])) ? $_POST["numbers"] : "";

        $numbers = explode(',',  $numbers);



        $sender_id = (isset($_POST["sender"]))  ? $_POST["sender"]  : "";
        $message   = (isset($_POST["message"])) ? $_POST["message"] : "";

        //gets our api details from the database.

       
            $api_details = get_option($this->pluginName);
            if (is_array($api_details) and count($api_details) != 0) {
                $TWILIO_SID = $api_details["api_sid"];
                $TWILIO_TOKEN = $api_details["api_auth_token"];
            }
           
            foreach($numbers as $to){
                
            try {
                $client = new Client($TWILIO_SID, $TWILIO_TOKEN);
                $response = $client->messages->create(
                    $to,
                    array(
                        "from" => $sender_id,
                        "body" => $message
                    )
                );
                self::DisplaySuccess();
            } catch (Exception $e) {
                self::DisplayError($e->getMessage());
            }
        }
    }

    /**
     * Designs for displaying Notices
     *
     * @since    1.0.0
     * @access   private
     * @var $message - String - The message we are displaying
     * @var $status   - Boolean - its either true or false
     */
    public static function adminNotice($message, $status = true) {
        $class =  ($status) ? "notice notice-success" : "notice notice-error";
        $message = __( $message, "sample-text-domain" );
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }

    /**
     * Displays Error Notices
     *
     * @since    1.0.0
     * @access   private
     */
    public static function DisplayError($message = "Aww!, there was an error.") {
        add_action( 'adminNotices', function() use($message) {
            self::adminNotice($message, false);
        });
    }

    /**
     * Displays Success Notices
     *
     * @since    1.0.0
     * @access   private
     */
    public static function DisplaySuccess($message = "Successful!") {
        add_action( 'adminNotices', function() use($message) {
            self::adminNotice($message, true);
        });
    }

    /**
     * Load jQuery datepicker.
     *
     * By using the correct hook you don't need to check `is_admin()` first.
     * If jQuery hasn't already been loaded it will be when we request the
     * datepicker script.
     */
   

}

// Create a new sendex instance
$sendexInstance = new Sendex();
// Add setting menu item
add_action("admin_init", [$sendexInstance , 'sendexSMSList']);
add_action("admin_menu", [$sendexInstance , "addSendexAdminOption"]);
// Saves and update settings
add_action("admin_init", [$sendexInstance , 'sendexAdminSettingsSave']);
// Hook our sms page
add_action("admin_menu", [$sendexInstance , "registerSendexSmsPage"]);

// calls the sending function whenever we try sending messages.
add_action( 'admin_init', [$sendexInstance , "send_message"] );

 
function Zumper_widget_enqueue_script() {   
    wp_register_style( 'sendexsmslist-jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css' );
    wp_enqueue_style( 'sendexsmslist-jquery-ui' ); 
    wp_enqueue_script( 'sendexsmslist-jquery-ui-datepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js');
    wp_enqueue_script( 'sendexsmslist-script', plugins_url( '/assets/js/script.js', __FILE__ ));
}
add_action('admin_enqueue_scripts', 'Zumper_widget_enqueue_script');

