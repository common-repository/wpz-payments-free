/*! For licensing and copyright information applicable to the product that this file belongs to, please see ../license.txt. */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 16);
/******/ })
/************************************************************************/
/******/ ({

/***/ 16:
/*!***********************************!*\
  !*** multi ./scripts/frontend.js ***!
  \***********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /usr/src/app/scripts/frontend.js */17);


/***/ }),

/***/ 17:
/*!*****************************!*\
  !*** ./scripts/frontend.js ***!
  \*****************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function () {
  var globalSettings = null;
  var instances = {};
  var nextInstanceId = 1;
  var stripeInitSent = false;

  function getSourceId() {
    var bodyClasses = document.body.className.split(' ');

    for (var i = 0; i < bodyClasses.length; ++i) {
      if (bodyClasses[i].substring(0, 7) === 'postid-') {
        return bodyClasses[i].substring(7);
      } else if (bodyClasses[i].substring(0, 8) === 'page-id-') {
        return bodyClasses[i].substring(8);
      }
    }

    return null;
  }

  window.wpz_payments_format_price = function (amount, noCurrency) {
    if (isNaN(amount)) {
      amount = 0;
    }

    if (window.WpzPaymentsFrontendData.stripe_currency_no_decimals) {
      amount = Math.round(amount);
    } else {
      amount = Math.round(amount * 100) / 100;
    }

    var amountString = amount.toString();
    var position = window.WpzPaymentsFrontendData.currency_symbol_position;

    if (!noCurrency && (position === 'before' || position === 'before_space')) {
      var result = window.WpzPaymentsFrontendData.currency_symbol;

      if (position === 'before_space') {
        result += ' ';
      }
    } else {
      var result = '';
    }

    result += amount + (amountString.indexOf('.') === -1 ? '.00' : amountString.indexOf('.') === amountString.length - 2 ? '0' : '');

    if (!noCurrency && (position === 'after' || position === 'after_space')) {
      if (position === 'after_space') {
        result += ' ';
      }

      result += window.WpzPaymentsFrontendData.currency_symbol;
    }

    return result;
  }; // Also used for confirmation dialog text


  window.wpz_payments_pay_button_text = function ($container, textTemplate) {
    var $price = $container.find('.wpz-payments-price-amount:first');
    var price = parseFloat($price.is('input') ? $price.val() : $price.attr('data-value'));
    var $quantity = $container.find('.wpz-payments-quantity-amount:first');
    var quantity = $quantity.length ? parseFloat($quantity.val()) : 1;
    return textTemplate.replaceAll(/%s/g, window.wpz_payments_format_price(price * quantity));
  };

  window.wpz_payments_pay_button_is_disabled = function ($container) {
    return $container.has('.wpz-payments-pay-button.ds-dpm-loading, .wpz-payments-pay-button.wpz-payments-disabled, .wpz-payments-validation-error:not(.wpz-payments-agreement-validation-error)').length ? true : false;
  }; // Keypress handler for modal mode


  window.wpz_payments_handle_keydown = function (ev) {
    if (ev.originalEvent && ev.originalEvent.key === 'Escape') {
      jQuery('.wpz-payments-container .wpz-payments-close-button').click();
    }
  };

  window.jQuery(document.body).on('click', '.wpz-payments-type-options a', function () {
    var $container = window.jQuery(this).closest('.wpz-payments-container');
    var changeTo = window.jQuery(this).parent().hasClass('wpz-payments-type-option-paypal') ? 'paypal' : 'stripe';

    if ($container.hasClass('wpz-payments-' + changeTo)) {
      return;
    }

    for (var instanceId in instances) {
      if (instances[instanceId].type !== changeTo && $container.is(instances[instanceId].$container)) {
        window.wpz_payments_unmount(instances[instanceId].id);
        break;
      }
    }

    $container.removeClass('wpz-payments-stripe wpz-payments-paypal').addClass('wpz-payments-' + changeTo);
    $container.find('.wpz-payments-credit.wpz-payments-credit-' + changeTo).attr('aria-hidden', null).siblings('.wpz-payments-credit').attr('aria-hidden', 'true');

    for (var instanceId in instances) {
      if (instances[instanceId].type === changeTo && $container.is(instances[instanceId].$container)) {
        window.wpz_payments_mount(instances[instanceId].id);
        return;
      }
    }

    window.wpz_payments_init($container[0]);
  });

  window.wpz_payments_init = function (containerElem) {
    var instance = {
      id: nextInstanceId++,
      $container: window.jQuery(containerElem)
    };
    instance.type = instance.$container.hasClass('wpz-payments-paypal') ? 'paypal' : 'stripe';
    instances['i' + instance.id] = instance;
    instance.$container.find('.wpz-payments-reload-info').remove();
    var isVisualBuilder = instance.$container.closest('body.et-fb').length;

    if (instance.$container.attr('data-success')) {
      var successUrl = instance.$container.attr('data-success-url');

      if (successUrl) {
        location.href = successUrl;
        return;
      }
    }

    if (instance.type === 'stripe') {
      var updateStripePaymentIntent = function updateStripePaymentIntent(cb) {
        globalSettings.stripe.controllingInstance = null;
        var $button = instance.$container.find('.wpz-payments-pay-button:first');

        var onUpdateError = function onUpdateError() {
          $button.removeClass('ds-dpm-loading').attr('disabled', wpz_payments_pay_button_is_disabled(instance.$container));
        };

        $button.text(wpz_payments_pay_button_text(instance.$container, $button.attr('data-text-template'))).addClass('ds-dpm-loading').attr('disabled', true);

        if (!globalSettings || !globalSettings.stripe || !globalSettings.stripe.api) {
          onUpdateError();

          if (cb) {
            cb();
          }

          return;
        }

        globalSettings.stripe.api.retrievePaymentIntent(globalSettings.stripe.intent).then(function (response) {
          if (response.error || !response.paymentIntent) {
            onUpdateError();

            if (cb) {
              cb();
            }

            return;
          }

          var paymentIntentId = response.paymentIntent.id;
          $button.data('wpz-payment-intent-id', paymentIntentId);
          var preflightData = {
            action: 'wpz_payments_preflight',
            _wpnonce: instance.$container.attr('data-payment-nonce'),
            intentId: paymentIntentId,
            paymentMethod: 'stripe',
            description: instance.$container.find('h4:first').text()
          };
          var statementDescriptor = instance.$container.attr('data-statement-descriptor');

          if (statementDescriptor) {
            preflightData.statementDescriptor = statementDescriptor;
          }

          var $price = instance.$container.find('.wpz-payments-price-amount:first');
          var price = parseFloat($price.is('input') ? $price.val() : $price.attr('data-value'));
          var $quantity = instance.$container.find('.wpz-payments-quantity-amount:first');

          if ($quantity.length) {
            preflightData.amount = price * $quantity.val();
            preflightData.quantity = $quantity.val();
          } else {
            preflightData.amount = price;
          }

          var $notes = instance.$container.find('.wpz-payments-notes-field:first');

          if ($notes.length) {
            preflightData.notes = $notes.val();
          }

          var sourceId = getSourceId();

          if (sourceId) {
            preflightData.sourceId = sourceId;
          }

          window.jQuery.post(window.WpzPaymentsFrontendData.ajax_url, preflightData, function (response) {
            if (response.success) {
              instance.stripeElements.fetchUpdates().then(function (r) {
                if (r.error) {
                  onUpdateError();
                } else {
                  globalSettings.stripe.controllingInstance = instance.id;
                }
              });
              $button.removeClass('ds-dpm-loading').attr('disabled', wpz_payments_pay_button_is_disabled(instance.$container));
            } else {
              onUpdateError();

              if (response.data && response.data.newIntentId) {
                onComplete(true);
                var message = instance.$container.attr('data-reload-info-message');

                if (message) {
                  window.jQuery('<div>').addClass('wpz-payments-reload-info').text(message).insertBefore(instance.$container.find('.wpz-payments-form:first'));
                }
              }
            }
          }, 'json').fail(function () {
            return onUpdateError();
          }).always(function () {
            return cb && cb();
          });
        });
      };
    }

    var formatAmountField = function formatAmountField() {
      var $amountField = instance.$container.find('.wpz-payments-price-amount:first');
      $amountField.val(window.wpz_payments_format_price($amountField.val(), true));
    };

    instance.$container.on('change update:wpzPayments', '.wpz-payments-price-amount, .wpz-payments-quantity-amount', function () {
      var $amount = window.jQuery(this);
      var currentValue = parseFloat($amount.val());
      $amount.parent().prev('.wpz-payments-validation-error').remove();
      var min = $amount.attr('min');
      var max = $amount.attr('max');
      var step = $amount.attr('step');

      if (min !== undefined && currentValue < parseFloat(min)) {
        var message = $amount.attr('data-validation-message-minimum').replaceAll(/%f/g, wpz_payments_format_price(min));
      } else if (max !== undefined && currentValue > parseFloat(max)) {
        var message = $amount.attr('data-validation-message-maximum').replaceAll(/%f/g, wpz_payments_format_price(max));
      } else if (step && (currentValue / parseFloat(step)).toString().indexOf('.') !== -1) {
        var message = $amount.attr('data-validation-message-step').replaceAll(/%f/g, wpz_payments_format_price(step));
      } else {
        var message = null;
      }

      if (message) {
        window.jQuery('<p>').addClass('wpz-payments-validation-error').text(message).insertBefore($amount.parent());
      }

      $amount.toggleClass('wpz-field-invalid', !!message);

      if (instance.type === 'stripe') {
        updateStripePaymentIntent();
      }
    });
    instance.$container.on('change', '.wpz-payments-notes-field', function () {
      if (instance.type === 'stripe') {
        updateStripePaymentIntent();
      }
    });
    instance.$container.on('change', '.wpz-payments-price-amount', formatAmountField);
    formatAmountField();

    var onComplete = function onComplete(isError) {
      switch (instance.type) {
        case 'stripe':
          var noSelfReload = !isError && instance.$container.attr('data-no-reload-on-success');

          for (instanceKey in instances) {
            if (instances[instanceKey].type === 'stripe' && (!noSelfReload || instances[instanceKey].id !== instance.id)) {
              window.wpz_payments_unmount(instances[instanceKey].id);
            }
          }

          if (noSelfReload) {
            instance.$container.children().not('.wpz-payments-title, .wpz-payments-description, .wpz-payments-success').remove();
          }

          delete globalSettings.stripe.initErrorMessage;
          window.jQuery.post(window.WpzPaymentsFrontendData.ajax_url, {
            action: 'divi_payment_module_init'
          }, function (response) {
            if (response.success && response.data && response.data.stripe) {
              if (response.data.stripe.hasOwnProperty('initErrorMessage')) {
                globalSettings.stripe.initErrorMessage = response.data.stripe.initErrorMessage;
              }

              globalSettings.stripe.intent = response.data.stripe.intent;
            }
          }, 'json').always(function () {
            instance.$container.find('.wpz-payments-pay-button:first').removeClass('ds-dpm-loading');

            for (instanceKey in instances) {
              if (instances[instanceKey].type === 'stripe' && (!noSelfReload || instances[instanceKey].id !== instance.id)) {
                window.wpz_payments_mount(instances[instanceKey].id);
              }
            }
          });
          break;

        case 'paypal':
          instance.$container.removeClass('wpz-payments-loading');
          break;
      }
    };

    var _onError = function onError(reason, noReload) {
      var errorMessageTemplate = instance.$container.attr('data-error-message');
      var $modalContent = instance.$container.find('.wpz-payment-modal-content:first');

      if (reason) {
        reason = reason.trim();

        if (reason && reason[reason.length - 1] === '.') {
          reason = reason.substring(0, reason.length - 1).trim();
        }
      }

      window.jQuery('<div>').addClass('wpz-payments-error').text(errorMessageTemplate.replaceAll(/%\{error_reason\}/g, reason ? reason : window.wp.i18n.__('Unknown', 'wpz-payments'))).appendTo($modalContent.length ? $modalContent : instance.$container);

      if (!noReload) {
        onComplete(true);
      }
    };

    instance.$container.attr('data-load-error-message');

    var onSuccess = function onSuccess() {
      if (instance.$container.is('[data-success-url]')) {
        location.href = instance.$container.attr('data-success-url');
        return;
      }

      var successMessageTemplate = instance.$container.attr('data-success-message');
      var $modalContent = instance.$container.find('.wpz-payment-modal-content:first');
      window.jQuery('<div>').addClass('wpz-payments-success').text(successMessageTemplate).appendTo($modalContent.length ? $modalContent : instance.$container);
      onComplete(false);
    };

    if (!isVisualBuilder) {
      instance.$container.on('click', '.wpz-payments-close-button', function () {
        var $showButton = window.jQuery('.wpz-payments-modal-open:first');
        $showButton.removeClass('wpz-payments-modal-open');
        window.jQuery(this).closest('.wpz-payments-container').removeClass('wpz-payments-active').attr('aria-hidden', true).insertAfter($showButton.parent());
      });
    }

    switch (instance.type) {
      case 'stripe':
        instance.$container.on('click', '.wpz-payments-pay-button', function () {
          var $button = window.jQuery(this);

          if ($button.attr('disabled') || isVisualBuilder) {} else {
            if ($button.closest('.wpz-payments-confirm').length) {
              $button = instance.$container.find('.wpz-payments-button-wrapper .wpz-payments-pay-button:first');
            }

            window.jQuery('.wpz-payments-confirm').remove();
            instance.$container.find('.wpz-payments-success, .wpz-payments-error, .wpz-payments-agreement-validation-error, .wpz-payments-reload-info').remove();
            var $agreementCheckbox = instance.$container.find('.wpz-payments-agreement-checkbox:not(:checked):first');

            if ($agreementCheckbox.length) {
              $agreementCheckbox.parent().parent().before(window.jQuery('<p>').addClass('wpz-payments-validation-error wpz-payments-agreement-validation-error').text($agreementCheckbox.attr('data-validation-message')));
              return;
            }

            if (globalSettings.stripe.controllingInstance !== instance.id) {
              updateStripePaymentIntent(function () {
                window.jQuery('.wpz-payments-confirm').remove();
                window.jQuery('<div>').addClass('wpz-payments-confirm').append(window.jQuery('<p>').text(wpz_payments_pay_button_text(instance.$container, instance.$container.attr('data-confirm-message')))).append(window.jQuery('<div>').addClass('wpz-payments-button-confirm-wrapper').append(window.jQuery('<button>').attr('type', 'button').addClass('wpz-payments-confirm-yes wpz-payments-pay-button et_pb_button').text(instance.$container.attr('data-confirm-yes'))).append(window.jQuery('<button>').attr('type', 'button').addClass('wpz-payments-confirm-no et_pb_button wpz-payments-button-secondary').text(instance.$container.attr('data-confirm-no')).on('click', function (ev) {
                  window.jQuery(ev.target).closest('.wpz-payments-confirm').remove();
                }))).insertAfter(instance.$container.find('.wpz-payments-button-wrapper:first'));
              });
              return;
            }

            window.jQuery('.wpz-payments-pay-button').addClass('wpz-payments-disabled').attr('disabled', true);
            $button.addClass('ds-dpm-loading');
            var moduleClasses = instance.$container[0].className.split(' ');

            for (var i = 0; i < moduleClasses.length; ++i) {
              if (moduleClasses[i].substring(0, 25) === 'wpz_payments_divi_module_' && moduleClasses[i].substring(moduleClasses[i].length - 19) === '_payments_container') {
                var moduleIndex = parseInt(moduleClasses[i].substring(25, moduleClasses[i].length - 19)) + 1;
              }
            }

            globalSettings.stripe.api.confirmPayment({
              elements: instance.stripeElements,
              confirmParams: {
                return_url: location.href + (location.href.indexOf('?') === -1 ? '?' : '&') + 'wpz_payments_payment=stripe&wpz_payments_target=' + moduleIndex
              },
              redirect: 'if_required'
            }).then(function (response) {
              if (response.error) {
                if (response.error.type === 'validation_error') {
                  instance.$container.find('.wpz-payments-pay-button').removeClass('ds-dpm-loading wpz-payments-disabled').attr('disabled', false);
                } else {
                  _onError(response.error.message);
                }
              } else {
                window.jQuery.get(location.href, {
                  wpz_payments_payment: 'stripe',
                  payment_intent: $button.data('wpz-payment-intent-id'),
                  payment_intent_client_secret: globalSettings.stripe.intent,
                  ajax: 1
                }, function (response) {
                  if (response.success) {
                    onSuccess();
                  } else {
                    _onError(response.data);
                  }
                }, 'json').fail(function () {
                  return _onError();
                });
              }
            });
          }
        });
        var stripeStyles = instance.$container.attr('data-stripe-styles');

        if (stripeStyles) {
          window.wpz_payments_set_styles(instance.id, stripeStyles, instance.$container.attr('data-stripe-theme'));
        }

        break;

      case 'paypal':
        var setupPayment = function setupPayment(data, pp) {
          instance.$container.find('.wpz-payments-success, .wpz-payments-error, .wpz-payments-agreement-validation-error').remove();
          var $agreementCheckbox = instance.$container.find('.wpz-payments-agreement-checkbox:not(:checked):first');

          if ($agreementCheckbox.length) {
            $agreementCheckbox.parent().parent().before(window.jQuery('<p>').addClass('wpz-payments-validation-error wpz-payments-agreement-validation-error').text($agreementCheckbox.attr('data-validation-message')));
            return false;
          } // instance.$container.addClass('wpz-payments-loading'); // this is currently disabled because it interferes with the credit card fields


          var $quantity = instance.$container.find('.wpz-payments-quantity-amount:first');
          var quantity = $quantity.length ? parseFloat($quantity.val()) : 1;
          var $price = instance.$container.find('.wpz-payments-price-amount:first');
          var price = parseFloat($price.is('input') ? $price.val() : $price.attr('data-value')); // PayPal doesn't support decimal quantities

          while (quantity % 1) {
            quantity *= 10;
            price /= 10;
          }

          switch (instance.$container.attr('data-paypal-category')) {
            case 'digital':
              var itemCategory = 'DIGITAL_GOODS';
              break;

            case 'donation':
              var itemCategory = 'DONATION';
              break;

            default:
              var itemCategory = 'PHYSICAL_GOODS';
          }

          var purchase = {
            items: [{
              name: instance.$container.find('h4:first').text(),
              quantity: quantity,
              category: itemCategory,
              unit_amount: {
                currency_code: window.WpzPaymentsFrontendData.paypal_currency,
                value: price
              }
            }],
            amount: {
              currency_code: window.WpzPaymentsFrontendData.paypal_currency,
              value: price * quantity,
              breakdown: {
                item_total: {
                  currency_code: window.WpzPaymentsFrontendData.paypal_currency,
                  value: price * quantity
                }
              }
            }
          };
          var statementDescriptor = instance.$container.attr('data-statement-descriptor');

          if (statementDescriptor) {
            purchase.soft_descriptor = statementDescriptor.substring(0, 22);
          }

          return pp.order.create({
            intent: 'CAPTURE',
            purchase_units: [purchase]
          });
        };

        var doPayment = function doPayment(data, pp) {
          var sourceId = getSourceId();
          var notes = instance.$container.find('.wpz-payments-notes-field:first').val();
          pp.order.capture().then(function (payment) {
            if (payment.purchase_units && payment.purchase_units.length && payment.purchase_units[0].payments && payment.purchase_units[0].payments.captures && payment.purchase_units[0].payments.captures.length && payment.purchase_units[0].payments.captures[0].id) {
              window.jQuery.post(location.href, {
                wpz_payments_payment: 'paypal',
                payment_id: payment.purchase_units[0].payments.captures[0].id,
                post_id: sourceId ? sourceId : 0,
                notes: notes ? notes : '',
                ajax: 1
              }, function (response) {
                if (response.success) {
                  onSuccess();
                } else {
                  _onError(response.data);
                }
              }, 'json').fail(function () {
                return _onError();
              });
            } else {
              _onError();
            }
          });
        };

        instance.paypalOptions = {
          createOrder: setupPayment,
          onApprove: doPayment,
          onCancel: function onCancel() {
            return onComplete();
          },
          onError: function onError() {
            if (!instance.$container.has('.wpz-payments-agreement-validation-error').length) {
              _onError();
            }
          }
        };
        break;
    }

    window.wpz_payments_mount(instance.id);
    return instance.id;
  };

  var arrayDeepCompare = function arrayDeepCompare(arr1, arr2) {
    if (arr1.length !== arr2.length) {
      return false;
    }

    for (var i = 0; i < arr1.length; ++i) {
      if (_typeof(arr1[i]) !== _typeof(arr2[i])) {
        return false;
      }

      if (_typeof(arr1[i]) === 'object') {
        if (!arrayDeepCompare(arr1[i], arr2[i])) {
          return false;
        }
      } else if (arr1[i] !== arr2[i]) {
        return false;
      }
    }

    return true;
  };

  window.wpz_payments_set_styles = function (instanceId, styles, stripeTheme) {
    if (!instances['i' + instanceId] || instances['i' + instanceId].type !== 'stripe') {
      return;
    }

    var neededComputedProps = ['fontFamily', 'fontSize', 'lineHeight', 'color', 'fontWeight'];
    var computedStyles = [// 0 = text input, 1 = label, 2 = p
    '<input type="text">', '<label>', '<p>'].map(function (item) {
      $item = window.jQuery(item).prependTo(instances['i' + instanceId].$container);
      var myComputedStyles = window.getComputedStyle($item[0]);
      var result = {};

      for (var i = 0; i < neededComputedProps.length; ++i) {
        result[neededComputedProps[i]] = myComputedStyles[neededComputedProps[i]];
      }

      $item.remove();
      return result;
    });

    switch (stripeTheme) {
      case 'none':
        var defaultStyles = {
          999999: [[['.Input'], [['fontFamily', computedStyles[0].fontFamily], ['fontSize', '14px'], ['lineHeight', 'normal'], ['color', '#999'], ['padding', '16px'], ['backgroundColor', '#EEE'], ['borderRadius', 0], ['transition', 'all 0.2s ease'], ['borderWidth', 0], ['borderStyle', 'solid'], ['borderColor', '#BBB'], ['boxShadow', 'none']]], [['.Input::placeholder'], [['color', '#999']]], [['.Input:disabled'], [['backgroundColor', '#EEE'], ['color', '#999'], ['boxShadow', 'none']]], [['.Input:focus'], [['outline', 'none'], ['boxShadow', 'none']]], [['.Input--invalid'], [['outline', 'none'], ['boxShadow', 'none'], ['color', '#FF0000'], ['border', '1px solid #FF0000']]], [['.Label'], [['fontFamily', computedStyles[1].fontFamily], ['fontSize', computedStyles[1].fontSize], ['lineHeight', computedStyles[1].lineHeight], ['color', computedStyles[1].color], ['marginBottom', '0.5em'], ['fontWeight', computedStyles[1].fontWeight]]], [['.Error'], [['fontFamily', computedStyles[2].fontFamily], ['fontSize', computedStyles[2].fontSize], ['lineHeight', computedStyles[2].lineHeight], ['color', 'red'], ['fontWeight', computedStyles[2].fontWeight]]]]
        };
        break;

      default:
        var defaultStyles = {
          999999: [[['.Input'], [['fontFamily', computedStyles[0].fontFamily]]], [['.Label'], [['fontFamily', computedStyles[1].fontFamily], ['fontSize', computedStyles[1].fontSize], ['lineHeight', computedStyles[1].lineHeight], ['color', computedStyles[1].color]]], [['.Error'], [['fontFamily', computedStyles[2].fontFamily], ['fontSize', computedStyles[2].fontSize], ['lineHeight', computedStyles[2].lineHeight]]]]
        };
    }

    var stylesByMq = {};
    styles = styles.split('@media');

    for (var i = 0; i < styles.length; ++i) {
      var styleBlock = styles[i].trim();
      var startingSelectorMatch = styleBlock.substring(0, styleBlock.indexOf('{')).match(/max\-width\:[ ]*([0-9]+)px/i);
      var mq = startingSelectorMatch ? parseInt(startingSelectorMatch[1]) : 999999;

      if (startingSelectorMatch) {
        styleBlock = styleBlock.substring(styleBlock.indexOf('{') + 1, styleBlock.length - 1).trim();
      }

      stylesByMq[mq] = styleBlock;
    }

    for (var mq in stylesByMq) {
      stylesByMq[mq] = stylesByMq[mq].split('}').map(function (block) {
        return [block.substring(0, block.indexOf('{')).trim(), block.substring(block.indexOf('{') + 1).trim()];
      }).filter(function (block) {
        return block[0].indexOf('#STRIPE ') !== -1 || block[0].indexOf('#STRIPE.theme-' + stripeTheme + ' ') !== -1;
      }).map(function (block) {
        return [block[0].split(',').map(function (selector) {
          return selector.trim();
        }).filter(function (selector) {
          return selector.indexOf(' #STRIPE ') !== -1 || selector.indexOf(' #STRIPE.theme-' + stripeTheme + ' ') !== -1;
        }).map(function (selector) {
          return selector.substring(selector.indexOf(' ', selector.indexOf(' #STRIPE') + 8)).trim();
        }), block[1].split(';').filter(function (rule) {
          return rule.length;
        }).map(function (rule) {
          rule = rule.split(':').map(function (rulePart) {
            return rulePart.trim();
          });
          rule[0] = rule[0].split('-').map(function (word, index) {
            return index ? word[0].toUpperCase() + word.substring(1).toLowerCase() : word.toLowerCase();
          }).join('');

          if (rule[1].substring(rule[1].length - 10) === '!important') {
            rule[1] = rule[1].substring(0, rule[1].length - 10).trim();
          }

          return rule;
        })];
      });

      if (defaultStyles[mq]) {
        for (var i = 0; i < defaultStyles[mq].length; ++i) {
          var foundSelector = false;
          var combinedSelector = defaultStyles[mq][i][0].join(',');

          for (var j = 0; j < stylesByMq[mq].length; ++j) {
            if (stylesByMq[mq][j][0].join(',') === combinedSelector) {
              foundSelector = true;

              for (var k = 0; k < defaultStyles[mq][i][1].length; ++k) {
                var foundProperty = false;

                for (var l = 0; l < stylesByMq[mq][j][1].length; ++l) {
                  if (stylesByMq[mq][j][1][l][0] === defaultStyles[mq][i][1][k][0]) {
                    foundProperty = true;
                    break;
                  }
                }

                if (!foundProperty) {
                  stylesByMq[mq][j][1].unshift(defaultStyles[mq][i][1][k]);
                }
              }

              break;
            }
          }

          if (!foundSelector) {
            stylesByMq[mq].unshift(defaultStyles[mq][i]);
          }
        }
      }
    } //console.log(stylesByMq);


    if (!instances['i' + instanceId].styles || !arrayDeepCompare(Object.entries(stylesByMq), Object.entries(instances['i' + instanceId].styles))) {
      instances['i' + instanceId].styles = stylesByMq;

      if (instances['i' + instanceId].stripeElements) {
        window.wpz_payments_unmount(instanceId);
        window.wpz_payments_mount(instanceId);
      }
    }
  };

  window.wpz_payments_mount = function (instanceId) {
    var instance = instances['i' + instanceId];
    var isVisualBuilder = instance.$container.closest('body.et-fb').length;

    var initModule = function initModule() {
      switch (instance.type) {
        case 'stripe':
          var initForm = function initForm() {
            if (!globalSettings.stripe || !globalSettings.stripe.api || !globalSettings.stripe.intent || !globalSettings.stripe.publicKey || globalSettings.stripe.hasOwnProperty('initErrorMessage')) {
              var $modalContent = instance.$container.find('.wpz-payment-modal-content:first');
              instance.$container.find('.wpz-payments-error').remove();
              window.jQuery('<div>').addClass('wpz-payments-error').text(globalSettings.stripe.initErrorMessage ? wp.i18n.__('An error occurred while loading the payment form: %s', 'wpz-payments').replace('%s', globalSettings.stripe.initErrorMessage ? globalSettings.stripe.initErrorMessage : __('Unspecified error', 'wpz-payments')) : instance.$container.attr('data-load-error-message')).prependTo($modalContent.length ? $modalContent : instance.$container);
              return;
            }

            var theme = instance.$container.attr('data-stripe-theme');

            if (!theme) {
              theme = 'stripe';
            }

            var appearance = {
              theme: theme,
              rules: {}
            };

            if (instance.styles) {
              var breakpoints = Object.keys(instance.styles);
              breakpoints.sort();
              var screenWidth = window.jQuery(document).width();

              for (var i = breakpoints.length - 1; i >= 0; --i) {
                if (screenWidth > breakpoints[i]) {
                  break;
                }

                var breakpointStyles = instance.styles[breakpoints[i]];

                for (var j = 0; j < breakpointStyles.length; ++j) {
                  var rules = {};

                  for (var k = 0; k < breakpointStyles[j][1].length; ++k) {
                    rules[breakpointStyles[j][1][k][0]] = breakpointStyles[j][1][k][1];
                  }

                  for (var k = 0; k < breakpointStyles[j][0].length; ++k) {
                    appearance.rules[breakpointStyles[j][0][k]] = appearance.rules[breakpointStyles[j][0][k]] ? Object.assign({}, appearance.rules[breakpointStyles[j][0][k]], rules) : rules;
                  }
                }
              }
            }

            var fonts = [];

            for (var selector in appearance.rules) {
              if (appearance.rules[selector].fontFamily) {
                fonts = fonts.concat(appearance.rules[selector].fontFamily.split(',').map(function (fontFamily) {
                  fontFamily = fontFamily.trim();

                  if (fontFamily[0] === '\'' || fontFamily[0] === '"') {
                    fontFamily = fontFamily.substring(1, fontFamily.length - 1).trim();
                  }

                  return fontFamily;
                }).filter(function (fontFamily) {
                  return fonts.indexOf(fontFamily) === -1;
                }));
              }
            }

            fonts = fonts.map(function (font) {
              fontLc = font.toLowerCase();
              var $font = window.jQuery('#et-gf-' + fontLc.replaceAll(/ /g, '-') + ',#et_gf_' + fontLc.replaceAll(/ /g, '_'));

              if ($font.length) {
                var fontUrl = $font.attr('href');
              } else {
                var fontUrlSearch = '://fonts.googleapis.com/css?family=' + font.replaceAll(/ /g, '+');
                var fontLinks = window.jQuery('link[href*="' + fontUrlSearch + '"]').filter(function (i, elem) {
                  var hrefIndex = elem.href.indexOf(fontUrlSearch),
                      hrefIndexAfter = hrefIndex + fontUrlSearch.length;
                  return hrefIndex !== -1 && (hrefIndexAfter === elem.href.length - 1 || elem.href[hrefIndexAfter] === ':' || elem.href[hrefIndexAfter] === '&');
                });

                if (fontLinks.length) {
                  fontUrl = fontLinks[0].href;
                } else {
                  var cachedFonts = [jQuery('head:first style[id$="builder-googlefonts-cached-inline"]').text(), jQuery('body:first style[id$="builder-googlefonts-inline"]').text()];

                  for (var i = 0; i < cachedFonts.length; ++i) {
                    if (cachedFonts[i] && cachedFonts[i].indexOf(fontUrlSearch) !== -1) {
                      var fontUrlSearchIndex = cachedFonts[i].indexOf(fontUrlSearch);
                      var fontUrl = cachedFonts[i].substring(cachedFonts[i].lastIndexOf(' ', fontUrlSearchIndex) + 1, cachedFonts[i].indexOf(' ', fontUrlSearchIndex));
                      break;
                    }
                  }
                }
              }

              return fontUrl ? {
                cssSrc: fontUrl
              } : {};
            }).filter(function (font) {
              return font.cssSrc;
            });
            instance.stripeElements = globalSettings.stripe.api.elements({
              clientSecret: globalSettings.stripe.intent,
              appearance: appearance,
              fonts: fonts
            });
            instance.stripeTheme = theme;
            var paymentElementOptions = {
              wallets: {
                applePay: 'never',
                googlePay: 'never'
              }
            };
            var paymentElement = instance.stripeElements.create('payment', paymentElementOptions);
            paymentElement.on('ready', function () {
              instance.$container.removeClass('wpz-payments-loading');
              instance.$container.find('.wpz-payments-pay-button').removeClass('wpz-payments-disabled').attr('disabled', false);
            });
            paymentElement.mount(instance.$container.find('.wpz-payments-form:first')[0]);
            instance.$container.find('.wpz-payments-price-amount:first').trigger('update:wpzPayments');
          };

          if (globalSettings) {
            initForm();
          } else if (stripeInitSent) {
            var stripeInitInterval = setInterval(function () {
              if (globalSettings) {
                clearInterval(stripeInitInterval);
                initForm();
              }
            }, 500);
          } else {
            stripeInitSent = true;
            window.jQuery.post(window.WpzPaymentsFrontendData.ajax_url, {
              action: 'divi_payment_module_init'
            }, function (response) {
              if (response.success && response.data && response.data.stripe) {
                globalSettings = response.data;

                try {
                  globalSettings.stripe.api = window.Stripe(globalSettings.stripe.publicKey);
                } catch (ex) {}

                initForm();
              }
            }, 'json');
          }

          break;

        case 'paypal':
          if (!window.paypal || !window.paypal.Buttons) {
            var $modalContent = instance.$container.find('.wpz-payment-modal-content:first');
            instance.$container.find('.wpz-payments-error').remove();
            window.jQuery('<div>').addClass('wpz-payments-error').text(instance.$container.attr('data-load-error-message')).prependTo($modalContent.length ? $modalContent : instance.$container);
            instance.$container.removeClass('wpz-payments-loading');
          } else {
            var paypalStyle = {
              label: instance.$container.attr('data-paypal-button-text') ? instance.$container.attr('data-paypal-button-text') : 'paypal',
              color: instance.$container.attr('data-paypal-button-color') ? instance.$container.attr('data-paypal-button-color') : 'gold'
            };

            if (!instance.$container.attr('data-paypal-show-tagline')) {
              paypalStyle.tagline = false;
            }

            if (instance.$container.attr('data-paypal-buttons-horizontal')) {
              paypalStyle.layout = 'horizontal';
            }

            if (instance.$container.attr('data-paypal-button-border-radius') === 'more') {
              paypalStyle.shape = 'pill';
            }

            if (instance.$container.attr('data-paypal-button-height')) {
              paypalStyle.height = parseInt(instance.$container.attr('data-paypal-button-height'));
            }

            instance.paypalOptions.style = paypalStyle;
            $buttonContainer = instance.$container.find('.wpz-payments-paypal-button:first').empty();
            instance.paypalButtons = window.paypal.Buttons(instance.paypalOptions);
            instance.paypalButtons.render($buttonContainer[0]).then(function () {
              instance.$container.removeClass('wpz-payments-loading');
            });
          }

          break;
      }
    };

    var $showButton = instance.$container.siblings('.wpz-payments-show-button-wrapper:first').children();

    if ($showButton.length) {
      if (!isVisualBuilder) {
        $showButton.click(function () {
          window.jQuery(window).off('keydown', window.wpz_payments_handle_keydown).on('keydown', window.wpz_payments_handle_keydown);

          if (instance.$container.hasClass('wpz-payments-display-modal')) {
            $showButton.addClass('wpz-payments-modal-open');
            instance.$container.appendTo(document.body);
          } else {
            $showButton.remove();
          }

          instance.$container.addClass('wpz-payments-active').attr('aria-hidden', null);
          initModule();
        });

        if (instance.$container.has('.wpz-payments-success, .wpz-payments-error').length) {
          $showButton.click();
        }
      }
    } else {
      initModule();
    }
  };

  window.wpz_payments_unmount = function (instanceId) {
    switch (instances['i' + instanceId].type) {
      case 'stripe':
        var paymentElement = instances['i' + instanceId].stripeElements && instances['i' + instanceId].stripeElements.getElement('payment');

        if (paymentElement) {
          paymentElement.destroy();
        }

        break;

      case 'paypal':
        if (instances['i' + instanceId].paypalButtons) {
          instances['i' + instanceId].paypalButtons.close();
          delete instances['i' + instanceId].paypalButtons;
        }

        break;
    }
  };
})();

/***/ })

/******/ });