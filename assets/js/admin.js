// Admin Page Tabs
var wpz_payments_tabs_navigate = function () {
    jQuery('#wpz-payments-settings-tabs-content > div, #wpz-payments-settings-tabs > li').removeClass('wpz-payments-settings-active');
    jQuery('#wpz-payments-settings-' + location.hash.substr(1)).addClass('wpz-payments-settings-active');
    jQuery('#wpz-payments-settings-tabs > li:has(a[href="' + location.hash + '"])').addClass('wpz-payments-settings-active');
};

if (location.hash) {
    wpz_payments_tabs_navigate();
}
jQuery(window).on('hashchange', wpz_payments_tabs_navigate);