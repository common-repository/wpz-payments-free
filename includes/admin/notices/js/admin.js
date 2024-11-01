// Admin Notice
jQuery(document).ready(function ($) {
    $('#wpz-payments-notice .notice-dismiss'
    ).on('click', function () {
        jQuery.post(ajaxurl, {action: 'wpz_payments_notice_hide'})
    });
});