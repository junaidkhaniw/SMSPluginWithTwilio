<h2> <?php esc_attr_e( 'Send message easily', 'WpAdminStyle' ); ?></h2>
<div class="wrap">
    <div class="metabox-holder columns-2">
        <div class="meta-box-sortables ui-sortable">
            <div class="postbox">
                <h2 class="hndle">
                    <span> <?php esc_attr_e( 'SEND SMS', 'WpAdminStyle' ); ?></span>
                </h2>
                <div class="inside">
                    <form id="smsform" method="post" name="cleanup_options" action="">
                        
                        <label>Sender Number</label><br>
                        <input type="text" name="sender" value="<?php echo get_option('sendex')['api_phone_number']; ?>" class="regular-text formInput" placeholder="Sender ID" required /><br><br>
                        
                        <label>User Numbers</label><br>
                        <input type="text" name="numbers" class="regular-text formInput" placeholder="+23480597..." required /><br><br>
                        
                        <label>Message</label><br>
                        <textarea class="formInput" name="message" cols="50" rows="7" placeholder="Message"></textarea><br><br>

                        <input class="button-primary" type="submit" value="SEND MESSAGE" name="send_sms_message" />

                    </form>

                    <form id="smsToDbForm" method="post" name="savetodb" action="">

                        <input type="text" value="AUTO_GENERATED" class="none">

                        <label>Title</label><br>
                        <input type="text" name="title" class="regular-text formInput" placeholder="Title" required /><br><br>

                        <label>Datetime</label><br>
                        <input id="datepicker" type="text" name="datepick" class="regular-text formInput" autocomplete="off" defaultValue="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>"  required /><br><br>
                        
                        <label>Numnber List</label><br>
                        <input type="text" name="numbers" class="regular-text formInput" placeholder="+1400000000, +120000000..." required /><br>
                        <span id="numberlistspan">Multiple Numbers Separate With Comma(,)</span><br><br>

                        <label>Message</label><br>
                        <textarea class="formInput" name="message" cols="50" rows="7" placeholder="Message"></textarea><br><br>

                        <input class="button-primary" type="submit" value="Save MESSAGE" name="send_message_to_db" />


                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrap">
    <div class="metabox-holder columns-2">
        <div class="meta-box-sortables ui-sortable">
            <div class="postbox">
                <h2 class="hndle">
                    <span>ALL MESSAGES</span>
                </h2>
                <div class="inside">
                    <table style="font-family:arial,sans-serif; border-collapse: collapse; width: 100%">
                        <style>
                            td, th{
                                border: 1px solid #ccc;
                                text-align: center;
                                padding: 8px;
                            }
                        </style>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Time</th>
                                <th>Numbers List</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                global $wpdb;
                                $table_name = $wpdb->prefix . "sendexsmslist"; 
                                $result = $wpdb->get_results ( "SELECT * FROM $table_name" );
                                foreach ( $result as $print )   {
                            ?>
                                <tr>
                                    <td><?php echo $print->name;?></td>
                                    <td><?php echo $print->time;?></td>
                                    <td><?php echo $print->phonelist;?></td>
                                    <td><?php echo $print->text;?></td>
                                    <td width='15%'>
                                        <a href='tools.php?page=sendex-sms&upt=<?php echo $print->id ?>'>
                                            <input class="table-button" type="submit" value="Update" name="update_message_from_db" />
                                        </a>
                                        <a href='tools.php?page=sendex-sms&del=<?php echo $print->id ?>'>
                                            <input class="table-button" type="submit" value="Delete" name="delete_message_from_db" />
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

//setting up the form
function db_add_new_message() {
    
    $title      = $_POST['title'];
    $datepicker = $_POST['datepick']; 
    $numbers    = $_POST['numbers']; 
    $message    = $_POST['message']; 
    
    global $wpdb; 
    $table_name = $wpdb->prefix . "sendexsmslist"; 

    $wpdb->insert($table_name, array(
        'name'      => $title,
        'time'      => $datepicker,
        'phonelist' => $numbers,
        'text'      => $message,
    ));
    echo "<script>location.replace('tools.php?page=sendex-sms');</script>";
}

//And now to connect the  two:  
if( isset($_POST['send_message_to_db']) ) db_add_new_message();


function deleteMessageFromDb() {
    if (isset($_GET['del'])) {
        $del_id = $_GET['del'];
        global $wpdb; 
        $table_name = $wpdb->prefix . "sendexsmslist"; 
        $wpdb->query("DELETE FROM $table_name WHERE id='$del_id'");
        echo "<script>location.replace('tools.php?page=sendex-sms');</script>";
    }
}
deleteMessageFromDb();

function updateMessageFromDb() {

    if (isset($_GET['upt'])) {
        $upt_id = $_GET['upt'];
        global $wpdb; 
        $table_name = $wpdb->prefix . "sendexsmslist"; 
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$upt_id'");
        foreach($result as $print) {
            $time = $print->time;
            $name = $print->name;
            $phonelist = $print->phonelist;
            $text = $print->text;
        }
        echo "
        <table class='wp-list-table widefat striped'>
            <thead>
                <tr>
                <th width='5%'>ID</th>
                <th width='20%'>Title</th>
                <th width='20%'>Time</th>
                <th width='25%'>Numbers List</th>
                <th width='25%'>Message</th>
                <th width='5%'>Action</th>
                </tr>
            </thead>
            <tbody>
                <form action='' method='post'>
                    <tr>
                        <td width='5%'>$print->id <input type='hidden' id='uptid' name='uptid' value='$print->id'></td>
                        <td width='20%'><input type='text' id='uptname' name='uptname' value='$print->name'></td>
                        <td width='20%'><input type='text' id='datepicker' name='upttime' value='$print->time' autocomplete='off'></td>
                        <td width='25%'><input type='text' id='uptphonelist' name='uptphonelist' value='$print->phonelist'></td>
                        <td width='25%'><input type='text' id='upttext' name='upttext' value='$print->text'></td>
                        <td width='5%'>
                            <a href='tools.php?page=sendex-sms'>
                                <input id='uptsubmit' class='table-button' type='submit' value='Update' name='uptsubmit' />
                            </a>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>";
    }

}
updateMessageFromDb();

if (isset($_POST['uptsubmit'])) {
    $uid = $_POST['uptid'];
    $uname = $_POST['uptname'];
    $utime = $_POST['upttime'];
    $uphonelist = $_POST['uptphonelist'];
    $utext = $_POST['upttext'];
    global $wpdb; 
    $table_name = $wpdb->prefix . "sendexsmslist"; 
    $wpdb->query("UPDATE $table_name SET time='$utime',name='$uname',text='$utext',phonelist='$uphonelist' WHERE id='$uid'");
    
    echo "<script>location.replace('tools.php?page=sendex-sms');</script>";
}

?>

<style>

    .none {
        display: none;
    }
    .postbox {
        display: grid;
    }
    #smsform {
        float: left;
    }
    #smsToDbForm {
        float: right;
    }
    .inside label {
        font-size: 16px;
        font-weight: 500;
    }
    .inside .formInput {
        margin-top: 5px;
    }
    #numberlistspan {
        font-size: 10px;
    }
    .table-button {
        padding: 5px;
        font-size: 10px;
        background: #3871b1;
        border: none;
        border-radius: 2px;
        color: #fff;
        cursor: pointer;
    }

</style>