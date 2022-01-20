<div class="tabs">
<h1>Pure CSS Tabs With Indicator</h1>
    <input type="radio" id="tab1" name="tab-control" checked>
    <input type="radio" id="tab2" name="tab-control">
    <input type="radio" id="tab3" name="tab-control">

    <ul>
        <li title="All Messages" class="lili" id="1">
            <label for="tab1" role="button">
                <svg viewBox="0 0 24 24">
                    <path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <br>
                <span>All Messages</span>
            </label>
        </li>
        <li title="Create Messages" class="lili" id="2">
            <label for="tab2" role="button">
                <svg viewBox="0 0 24 24">
                    <path d="M2,10.96C1.5,10.68 1.35,10.07 1.63,9.59L3.13,7C3.24,6.8 3.41,6.66 3.6,6.58L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.66,6.72 20.82,6.88 20.91,7.08L22.36,9.6C22.64,10.08 22.47,10.69 22,10.96L21,11.54V16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V10.96C2.7,11.13 2.32,11.14 2,10.96M12,4.15V4.15L12,10.85V10.85L17.96,7.5L12,4.15M5,15.91L11,19.29V12.58L5,9.21V15.91M19,15.91V12.69L14,15.59C13.67,15.77 13.3,15.76 13,15.6V19.29L19,15.91M13.85,13.36L20.13,9.73L19.55,8.72L13.27,12.35L13.85,13.36Z" />
                </svg>
                <br>
                <span>Create Messages</span>
            </label>
        </li>
        <li title="Plugin Settings" class="lili" id="3">
            <label for="tab3" role="button">
                <svg viewBox="0 0 24 24">
                    <path d="M3,4A2,2 0 0,0 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8H17V4M10,6L14,10L10,14V11H4V9H10M17,9.5H19.5L21.47,12H17M6,15.5A1.5,1.5 0 0,1 7.5,17A1.5,1.5 0 0,1 6,18.5A1.5,1.5 0 0,1 4.5,17A1.5,1.5 0 0,1 6,15.5M18,15.5A1.5,1.5 0 0,1 19.5,17A1.5,1.5 0 0,1 18,18.5A1.5,1.5 0 0,1 16.5,17A1.5,1.5 0 0,1 18,15.5Z" />
                </svg>
                <br>
                <span>Plugin Settings</span>
            </label>
        </li>
    </ul>

    <div class="slider">
        <div class="indicator"></div>
    </div>
    <hr>
    <div class="content">
        <section>
            <h2 class="sec-heading">All Messages</h2>
            <div class="main-container">
                <div class="jcards">
                    <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "ajaxsmslist"; 
                        $result = $wpdb->get_results ( "SELECT * FROM $table_name" );
                        foreach ( $result as $print )   {
                    ?>
                    <div id="<?php echo $print->id;?>_jcard" class="jcard jcard-1">
                        <h2 class="jcard__title"><?php echo $print->title;?></h2>
                        <!-- <input type="checkbox" data-id="'.$data['id'].'" data-status="'.$data['status'].'" ../> -->
                        <?php 
                            if( $print->status == 1 ) {
                                echo 'hello';
                        ?>
                            <a href='tools.php?page=ajax-sms&upt=<?php echo $print->id ?>' name="addButton" class="jcard__exit addButton">
                                <label for="tab2">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 128 128" style=" fill:#000000;">
                                        <path fill="#fff" d="M64 9A55 55 0 1 0 64 119A55 55 0 1 0 64 9Z" transform="rotate(-45.001 64 64.001)"></path>
                                        <path fill="#444b54" d="M64,122c-14.9,0-29.7-5.7-41-17C0.4,82.4,0.4,45.6,23,23c22.6-22.6,59.4-22.6,82,0c0,0,0,0,0,0 c22.6,22.6,22.6,59.4,0,82C93.7,116.3,78.9,122,64,122z M64,12c-13.3,0-26.6,5.1-36.8,15.2C7,47.5,7,80.5,27.2,100.8 c20.3,20.3,53.3,20.3,73.5,0c20.3-20.3,20.3-53.3,0-73.5C90.6,17.1,77.3,12,64,12z"></path>
                                        <path fill="#71c2ff" d="M83,61H67V45c0-1.7-1.3-3-3-3s-3,1.3-3,3v16H45c-1.7,0-3,1.3-3,3s1.3,3,3,3h16v16c0,1.7,1.3,3,3,3s3-1.3,3-3 V67h16c1.7,0,3-1.3,3-3S84.7,61,83,61z"></path>
                                    </svg>
                                </label>
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.25 8.891l-1.421-1.409-6.105 6.218-3.078-2.937-1.396 1.436 4.5 4.319 7.5-7.627z"/></svg> -->
                            </a>
                        <?php 
                            } else {
                        ?>
                            <a href='' name="addButton" class="jcard__exit addButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style=" fill:#000000;">
                                    <path fill="#71c2ff" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.25 8.891l-1.421-1.409-6.105 6.218-3.078-2.937-1.396 1.436 4.5 4.319 7.5-7.627z"/>
                                </svg>
                            </a>
                        <?php } ?>

                        <h2 id="<?php echo $print->id;?>_message" class="addMessage jcard__message"><?php echo $print->message;?></h2>
                    </div>
                    <?php 
                        }
                    ?>
                    
                </div>
            </div>
        </section>

        <section>
            <h2 class="sec-heading">Create Messages</h2>
            <div class="contact1">
                <div class="container-contact1">
                    <div class="contact1-pic js-tilt" data-tilt>
                        <img src="<?php echo plugins_url('ajax/assets/images/img-01.png'); ?>" alt="IMG">
                    </div>

                    <form id="" method="post" class="contact1-form validate-form" action="">
                        <span class="contact1-form-title">
                            Create a Message
                        </span>

                        <input type="text" value="AUTO_GENERATED" class="none">

                        <div class="wrap-input1">
                            <input class="input1" type="text" name="m_title" placeholder="Name">
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="wrap-input1">
                            <input id="datepicker" class="input1" type="text" name="m_date" placeholder="Select Date">
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="wrap-input1">
                            <textarea class="input1" name="m_numbers" placeholder="Add Numbers"></textarea>
                            <span class="shadow-input1"></span>
                            <span id="numberlistspan">Multiple Numbers Separate With Comma(,)</span>
                        </div>

                        <div class="wrap-input1">
                            <textarea id="hereMessage" class="input1" name="m_message" placeholder="Message"></textarea>
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="container-contact1-form-btn">
                            <input type="submit" class="contact1-form-btn" name="create_message" value="Create Message">
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section>
            <h2 class="sec-heading">Plugin Settings</h2>
                                        
        </section>
    </div>
    <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
    <?php
        global $wpdb; 
        $table_name = $wpdb->prefix . "frm_item_metas";

        $api = $wpdb->get_results( "SELECT * FROM $table_name where field_id in 
                            (SELECT id FROM wp_frm_fields WHERE id = '7' )
                            ");

?>
        <option value="<?php echo $apiData ?>"><?php echo $apiData ?></option>
        <?php
        foreach($api as $apiData){
        ?>
            
            <option value="<?php echo $apiData->meta_value ?>"><?php echo $apiData->meta_value ?></option>
        <?php
        }
        ?>
        </select>
</div>



<?php


global $wpdb; 
$table_name = $wpdb->prefix . "frm_item_metas";

$api = $wpdb->get_results( "SELECT * FROM $table_name where field_id in 
                            (SELECT id FROM wp_frm_fields WHERE id = '7' )
                            ");
foreach($api as $apiData){
    print_r($apiData->meta_value);
}

// $entries = FrmEntry::getAll(
//     array(
//         'it.form_id' => 2
//     ),
// );

// print_r($entries);

// echo $entries[1]['item_key'];

// global $wpdb; 
// $table_name = $wpdb->prefix . "frm_item_metas";

// $api = $wpdb->get_results( "SELECT * FROM $table_name where field_id=7 ");

// foreach($api as $apiData){
//     print_r($apiData->meta_value);
// }




//setting up the form
function create_message_db() {
    
    $title      = $_POST['m_title'];
    $date       = $_POST['m_date']; 
    $numbers    = $_POST['m_numbers']; 
    $message    = $_POST['m_message']; 
    
    global $wpdb; 
    $table_name = $wpdb->prefix . "ajaxsmslist"; 

    $wpdb->insert($table_name, array(
        'title'     => $title,
        'date'      => $date,
        'numbers'   => $numbers,
        'message'   => $message,
    ));
    echo "<script>location.replace('tools.php?page=ajax-sms');</script>";
}

if( isset($_POST['create_message']) ) create_message_db();

function change_message_status() {
    $id = $_POST['uptid'];
    global $wpdb; 
    $table_name = $wpdb->prefix . "ajaxsmslist"; 
    $wpdb->query("UPDATE $table_name SET status = '0' WHERE id='$id'");
}

if( isset($_POST['addButton']) ) change_message_status();

// add_filter('cron_schedules', 'my_schedules');

// function my_schedules($schedules)
// {
//     $schedules['once_every_10_sec'] = array(
//         'interval' => 10, 
//         'display' => esc_html__('Once every 10 seconds')
//     );
//     return $schedules;
// }

// if (!wp_next_scheduled('jk_cron_hook'))
// {
//     wp_schedule_event(time(), 'once_every_10_sec', 'jk_cron_hook');
// }
// add_action('jk_cron_hook', 'function_that_should_be_executed');

// function function_that_should_be_executed()
// {
//     $arg = [
//         'post_title' => 'Post with cron job every 10 seconds',
//     ];
//     wp_insert_post($arg);
// }

// add_action('wp_ajax_contact_us', 'ajax_contact_us');
// function ajax_contact_us() {
//     wp_send_json_success('test');
// }

//setting up the form
// function db_add_new_message() {
    
//     $title      = $_POST['title'];
//     $datepicker = $_POST['datepick']; 
//     $numbers    = $_POST['numbers']; 
//     $message    = $_POST['message']; 

//     global $wpdb; 
//     $table_name = $wpdb->prefix . "ajaxsmslist"; 

//     $wpdb->insert($table_name, array(
//         'name'      => $title,
//         'time'      => $datepicker,
//         'phonelist' => $numbers,
//         'text'      => $message,
//     ));
//     echo "<script>location.replace('tools.php?page=ajax-sms');</script>";
// }

// //And now to connect the  two:  
// if( isset($_POST['send_message_to_db']) ) db_add_new_message();

?>





