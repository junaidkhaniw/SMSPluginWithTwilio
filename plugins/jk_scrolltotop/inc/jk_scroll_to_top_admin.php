<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/***
 * Admin page
***/

?>
<div class="wrap"><br/>
	<h1>Scroll To Top <font size="2">v1.0.0</font></h1>
<?php

    /***
	   * Save button is clicked
	***/
    $jkScrollToTop_save = @$_POST['jkScrollToTop_save'];
    $jkScrollToTop_save = wp_kses($jkScrollToTop_save, array());

    if(isset($jkScrollToTop_save)) {

        // Nonce Check
        if(isset($_POST['_wpnonce']) && $_POST['_wpnonce']) {
            if(check_admin_referer('JKscrolltototp_plugin', '_wpnonce')) {

                //POST variables
                $jk_scroll_to_top_speed = ( @$_POST['jk_scroll_to_top_speed'] == 'fast' )? 'fast' : 'slow';
                //Register to the database
                update_option('jk_scroll_to_top_speed', $jk_scroll_to_top_speed);

                $jk_scroll_to_top_color = ( @$_POST['jk_scroll_to_top_color'] == 'blue' )? 'blue' : 'red';
                //Register to the database
                update_option('jk_scroll_to_top_color', $jk_scroll_to_top_color);

            }
        }
    }

    /***
 	 * Receiving the data
 	***/
 	//Registered data
 	$jk_scroll_to_top_speed = get_option('jk_scroll_to_top_speed');
 	$jk_scroll_to_top_color = get_option('jk_scroll_to_top_color');

?>

    <form method="post" id="jk_scroll_to_top_form" action="">
 		<?php wp_nonce_field( 'JKscrolltototp_plugin', '_wpnonce' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th width="50" scope="row">Scroll To Top Button Speed</th>
                <td>
                <input type="radio" name="jk_scroll_to_top_speed" value="fast" <?php if($jk_scroll_to_top_speed == "fast") echo('checked'); ?> />
                Fast<br /><br />
                <input type="radio" name="jk_scroll_to_top_speed" value="slow" <?php if($jk_scroll_to_top_speed == "slow") echo('checked'); ?> />
                Slow<br />
                </td>
            </tr>

            <tr valign="top">
                <th width="50" scope="row">Scroll To Top Button Color</th>
                <td>
                <input type="radio" name="jk_scroll_to_top_color" value="blue" <?php if($jk_scroll_to_top_color == "blue") echo('checked'); ?> />
                Blue<br /><br />
                <input type="radio" name="jk_scroll_to_top_color" value="red" <?php if($jk_scroll_to_top_color == "red") echo('checked'); ?> />
                Red<br />
                </td>
            </tr>

            <tr>
                <th width="50" scope="row">Save this setting</th>
                <td>
                <input type="submit" name="jkScrollToTop_save" value="Save" /><br />
                </td>
            </tr>

        </table>

    </form>