=== Simple Payment Module for Divi ===
Contributors: aspengrovestudios
Tags: payment, ecommerce, paypal, stripe, divi
Requires at least: 5.0
Tested up to: 6.6.1
Stable tag: 1.1.14
Requires PHP: 5.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A payment module for Divi that supports both Stripe and PayPal!

== Description ==

This plugin adds a Payment Module to the Divi builder that allows you to easily collect payments using Stripe and/or PayPal! Ideal for sites that don't require a full-fledged ecommerce platform, such as non-profits collecting donations, service providers processing invoice payments through their websites, and ecommerce sites with only one or a few products. Includes an admin interface for viewing received payments.


=== Third Party Services ===

This plugin communicates with the Stripe API and/or PayPal API (depending on which payment services are enabled), which may include transmitting data in the backend (server to server) and/or the frontend (from site visitors' browsers).

==== Stripe ====
- [Homepage](https://stripe.com/)
- [Agreements and privacy policies](https://stripe.com/legal/)
- [US services agreement](https://stripe.com/legal/ssa)
- [Privacy policy](https://stripe.com/privacy)


==== PayPal ====
- [Homepage](https://paypal.com/)
- [Agreements and privacy policies - US](https://www.paypal.com/us/legalhub/home)

==== WP Zone ====

This plugin utilizes a third-party service hosted on our WP Zone website to fetch the latest product list. This connection is essential for the admin addons tab to function correctly and provide you with updated product information. Please be aware that by using this plugin, you are agreeing to the terms of service and privacy policy of the WP Zone website.

- Service Provider: https://wpzone.co/
- Service Usage: Retrieval of product list for display and integration within the WordPress site.
- Data Handling: No personal or sensitive data is collected or transmitted in the process of fetching the product list. The interaction is limited strictly to the retrieval of publicly available product information.
- [Terms of Service](https://wpzone.co/legal/)
- [Privacy Policy](https://wpzone.co/legal/)


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpz-payments-free` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress 


== Frequently Asked Questions ==


== Changelog ==

Version 1.1.14 October 7, 2024
- Fix missing Stripe transaction IDs
- Clear Stripe controlling instance while updating payment intent
- Fix Incorrect sanitization of notes field

Version 1.1.13 September 30, 2024
- Fix JavaScript error

Version 1.1.12 August 31, 2024
- Fix bug in Stripe styles

Version 1.1.11 January 2, 2024
- Fix: PayPal integration fails if the statement descriptor is longer than 22 characters
- Fix: Stripe payments may not working

Version 1.1.10 November 23, 2023
- Fix: PayPal webhook validation may incorrectly fail on some servers
- Add debug logging capability for PayPal webhook validation process

Version 1.1.9 October 17, 2023
- Fix: Payment validation fails on fixed price with a price that has decimals
- Add auto reload payment form
- Add confirm dialog

Version 1.1.8 October 7, 2023
- Change default  payment error message to "Unfortunately, something went wrong while we were processing your payment, and the payment may not have completed."
- Fix: Payment validation may incorrectly fail on quantities > 1

Version 1.1.7 May 22, 2023
- Remove unnecessary JS filter removal code
- Disable Apple Pay and Google Pay since it is not supported at this time
- Fix: When the PayPal integration is enabled and overlay display mode is used, re-opening the overlay after it has been closed may result in multiple PayPal buttons being rendered
- Fix: Payment may not work in some cases when there is more than one payment module with Stripe on the same page
- Fix: When a page has more than one payment module with Stripe and the user completes a payment in one of the modules, they may not be able to successfully complete a payment in one of the other modules without reloading the page
- Disable Stripe payment buttons while Stripe fields load

Version 1.1.6 April 25, 2023
- Fix: the debit/credit card payment form wasn't loading correctly in the PayPal integration

Version 1.1.5 April 10, 2023
- Fix: Potential issue rendering certain styling rules in the visual builder

Version 1.1.4 March 12, 2023
- Add option: Payment Success > Stripe - don't reload the payment form after successful payment

Version 1.1.3 February 13, 2023
- Fix: In the PayPal integration, using overlay display mode, the close button doesn't work
- Fix: In the PayPal integration, using overlay display mode, if a loading error occurs the error message isn't positioned correctly

Version 1.1.2 February 9, 2023
- Fix: Default values of new settings are not applied after plugin update

Version 1.1.1 February 8, 2023
- Fix: If the quantity step or price step setting is set to certain zero values, a PHP critical error may result during webhook processing
- Fix issue with step validation on frontend
- Fix issue with processing PayPal refund
- Fix: JS error when unmounting PayPal after failed mount

Version 1.1.0 February 7, 2023
- Add PayPal as payment method (beta version)
- Fix: The "Payment Processing" payment status may not have been useable because the status slug exceeded the maximum character length
- Fix: The parameter to the wpz_payments_divi_module_payment_params action hook was not being passed (and an associated PHP notice may occur)
- Fix: PHP notice and missing value in the status column for trashed payments
- Fix: Restoring a payment from trash gives it an incorrect payment status
- Fix: Add missing Divi module setting description
- Fix: If the quantity step or price step setting is set to certain zero values, a PHP critical error may result during webhook processing

Version 1.0.4 February 1, 2023
- Fix: Payments fail if the payment module is in a Divi theme builder body layout (note: the payment module is currently still not supported in theme builder header or footer layouts, or outside of the post content in theme builder body layouts that have a post content module

Version 1.0.3 January 30, 2023
- Admin page: fix untranslatable field descriptions
- Fix issue with hook

Version 1.0.2 January 18, 2023
- Add preloader to payment form

Version 1.0.1 December 13, 2022
- Automatically shorten the statement descriptor to 22 characters if it is longer than that, to avoid errors when processing payments
- Fix: Stripe error messages were not displayed when the error occurs during the preflight phase of payment (just showed "Unknown" error)
- Fix: "Add New" option appears in the WordPress admin Payments section for super admin users on multisite
- License key activation state related restructuring

Version 1.0.0 November 29, 2022
- Add additional error handling
- Fix: module jumping issue
- Fix: One module is triggering preview modes on other modules
- Change default quantity field type to range
- Fix: admin page, addons tab: styles are not loading

Version 0.0.4 November 23, 2022
- Add translatability to overlay close button aria-label attribute
- Add error handling when Stripe API is not loaded and payment button has been clicked
- In overlay display mode, pressing the Esc key will now close the overlay
- Add missing translatability for some module settings defaults
- Add aria-hidden attribute to payment container when it is not visible, in page after button click and overlay display modes
- Fix: pay button and show pay button icons are not rendering in Visual Builder

Version 0.0.3 November 23, 2022
- Close modal button: replace "Close" text with icon,
- Fix loading button styles
- Add `Fields Validation` design options
- Fix buttons styling issues, fix notification styling issues
- Fix: payment validation error when the product name has a leading space

Version 0.0.2 November 23, 2022
- Border styles were not working with display mode set to overlay
- Button styles were not working in frontend render with display mode set to overlay
- Some button styling settings were showing in the visual builder module settings even when the option to enable custom styling for that button was disabled
- In the visual builder, Stripe credit card fields were not being styled when the display mode was set to overlay
- Visual builder rendering issue when the display mode is set to overlay and the success message or error message toggle is open
- Incorrect z-index for overlay modal in the visual builder
- Stripe credit card fields may be missing after changing display mode
- Add form fields error (validation) preview
- Add wrapper around terms agreement checkbox in frontend render to match visual builder render
- In the visual builder, changing display modes can make the pay button text disappear
- JavaScript error when clicking the pay button with the display mode set to overlay
- Incompatibility of some payment method success/error handling with multiple instances of the module on the same page
- Payment error and/or success message may be rendered outside the modal in overlay display mode
- Payment error is not shown in the admin for payments with a Payment Invalid status
- Unspecified maximum price or maximum quantity could cause a payment validation error
- Pay button was still disabled and included loading animation after payment process was complete


Version 1.1.12 August 31, 2024
- Fix bug in Stripe styles

Version 1.1.11 January 2, 2024
- Fix: PayPal integration fails if the statement descriptor is longer than 22 characters
- Fix: Stripe payments may not working

Version 1.1.10 November 23, 2023
- Fix: PayPal webhook validation may incorrectly fail on some servers
- Add debug logging capability for PayPal webhook validation process

Version 1.1.9 October 17, 2023
- Fix: Payment validation fails on fixed price with a price that has decimals
- Add auto reload payment form
- Add confirm dialog

Version 1.1.8 October 7, 2023
- Change default  payment error message to "Unfortunately, something went wrong while we were processing your payment, and the payment may not have completed."
- Fix: Payment validation may incorrectly fail on quantities > 1

Version 1.1.7 May 22, 2023
- Remove unnecessary JS filter removal code
- Disable Apple Pay and Google Pay since it is not supported at this time
- Fix: When the PayPal integration is enabled and overlay display mode is used, re-opening the overlay after it has been closed may result in multiple PayPal buttons being rendered
- Fix: Payment may not work in some cases when there is more than one payment module with Stripe on the same page
- Fix: When a page has more than one payment module with Stripe and the user completes a payment in one of the modules, they may not be able to successfully complete a payment in one of the other modules without reloading the page
- Disable Stripe payment buttons while Stripe fields load

Version 1.1.6 April 25, 2023
- Fix: the debit/credit card payment form wasn't loading correctly in the PayPal integration

Version 1.1.5 April 10, 2023
- Fix: Potential issue rendering certain styling rules in the visual builder

Version 1.1.4 March 12, 2023
- Add option: Payment Success > Stripe - don't reload the payment form after successful payment

Version 1.1.3 February 13, 2023
- Fix: In the PayPal integration, using overlay display mode, the close button doesn't work
- Fix: In the PayPal integration, using overlay display mode, if a loading error occurs the error message isn't positioned correctly

Version 1.1.2 February 9, 2023
- Fix: Default values of new settings are not applied after plugin update

Version 1.1.1 February 8, 2023
- Fix: If the quantity step or price step setting is set to certain zero values, a PHP critical error may result during webhook processing
- Fix issue with step validation on frontend
- Fix issue with processing PayPal refund
- Fix: JS error when unmounting PayPal after failed mount

Version 1.1.0 February 7, 2023
- Add PayPal as payment method (beta version)
- Fix: The "Payment Processing" payment status may not have been useable because the status slug exceeded the maximum character length
- Fix: The parameter to the wpz_payments_divi_module_payment_params action hook was not being passed (and an associated PHP notice may occur)
- Fix: PHP notice and missing value in the status column for trashed payments
- Fix: Restoring a payment from trash gives it an incorrect payment status
- Fix: Add missing Divi module setting description
- Fix: If the quantity step or price step setting is set to certain zero values, a PHP critical error may result during webhook processing

Version 1.0.4 February 1, 2023
- Fix: Payments fail if the payment module is in a Divi theme builder body layout (note: the payment module is currently still not supported in theme builder header or footer layouts, or outside of the post content in theme builder body layouts that have a post content module

Version 1.0.3 January 30, 2023
- Admin page: fix untranslatable field descriptions
- Fix issue with hook

Version 1.0.2 January 18, 2023
- Add preloader to payment form

Version 1.0.1 December 13, 2022
- Automatically shorten the statement descriptor to 22 characters if it is longer than that, to avoid errors when processing payments
- Fix: Stripe error messages were not displayed when the error occurs during the preflight phase of payment (just showed "Unknown" error)
- Fix: "Add New" option appears in the WordPress admin Payments section for super admin users on multisite
- License key activation state related restructuring

Version 1.0.0 November 29, 2022
- Add additional error handling
- Fix: module jumping issue
- Fix: One module is triggering preview modes on other modules
- Change default quantity field type to range
- Fix: admin page, addons tab: styles are not loading

Version 0.0.4 November 23, 2022
- Add translatability to overlay close button aria-label attribute
- Add error handling when Stripe API is not loaded and payment button has been clicked
- In overlay display mode, pressing the Esc key will now close the overlay
- Add missing translatability for some module settings defaults
- Add aria-hidden attribute to payment container when it is not visible, in page after button click and overlay display modes
- Fix: pay button and show pay button icons are not rendering in Visual Builder

Version 0.0.3 November 23, 2022
- Close modal button: replace "Close" text with icon,
- Fix loading button styles
- Add `Fields Validation` design options
- Fix buttons styling issues, fix notification styling issues
- Fix: payment validation error when the product name has a leading space

Version 0.0.2 November 23, 2022
- Border styles were not working with display mode set to overlay
- Button styles were not working in frontend render with display mode set to overlay
- Some button styling settings were showing in the visual builder module settings even when the option to enable custom styling for that button was disabled
- In the visual builder, Stripe credit card fields were not being styled when the display mode was set to overlay
- Visual builder rendering issue when the display mode is set to overlay and the success message or error message toggle is open
- Incorrect z-index for overlay modal in the visual builder
- Stripe credit card fields may be missing after changing display mode
- Add form fields error (validation) preview
- Add wrapper around terms agreement checkbox in frontend render to match visual builder render
- In the visual builder, changing display modes can make the pay button text disappear
- JavaScript error when clicking the pay button with the display mode set to overlay
- Incompatibility of some payment method success/error handling with multiple instances of the module on the same page
- Payment error and/or success message may be rendered outside the modal in overlay display mode
- Payment error is not shown in the admin for payments with a Payment Invalid status
- Unspecified maximum price or maximum quantity could cause a payment validation error
- Pay button was still disabled and included loading animation after payment process was complete

Version 0.0.1 November 22, 2022
- Beta release for members

*This changelog reflects pro and free functionality