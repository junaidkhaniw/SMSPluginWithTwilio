jQuery(document).ready(function($) {

    jQuery("#datepicker").datetimepicker({ 
        format:'Y-m-d H:i:s',
    });

    jQuery(".addButton").click(function(event) {
        // event.preventDefault();
    
        var ID = jQuery(this).next().attr('id');
        let message = jQuery('#'+ID).html();
        jQuery('#hereMessage').append(message);
    });
    jQuery('.js-example-basic-multiple').select2();

//     jQuery('#smsToDbForm').submit(function() {
//         event.preventDefault();
//         let link = "<?php echo admin_url('admin-ajax.php') ?>";
//         let form = jQuery('#smsToDbForm').serialize();
//         let formData = new FormData;
//         formData.append('action', 'contact_us');
//         formData.append('contact_us', form);
//         jQuery.ajax({
//             url: link,
//             data: formData,
//             processData: false,
//             contentType: false,
//             type: 'post',
//             success: function(result) {
//                 alert(result);
                
//             }
//         })
//     });

});