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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!************************!*\
  !*** external "React" ***!
  \************************/
/*! dynamic exports provided */
/*! exports used: Component, default */
/***/ (function(module, exports) {

module.exports = React;

/***/ }),
/* 1 */
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports) {

module.exports = ReactDOM;

/***/ }),
/* 2 */
/*!********************************************************!*\
  !*** ./includes/fields/DSLayoutMultiselect/style.scss ***!
  \********************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 3 */
/*!*****************************************************!*\
  !*** ./includes/fields/WPZUpgradeNotice/style.scss ***!
  \*****************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 4 */
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./dev/divi-scripts-modified/config/polyfills.js ./includes/loader.js ./includes/admin.scss ./includes/modules/PaymentModule/style.scss ./includes/fields/DSLayoutMultiselect/style.scss ./includes/fields/WPZUpgradeNotice/style.scss ./includes/backend/style.scss ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /usr/src/app/dev/divi-scripts-modified/config/polyfills.js */5);
__webpack_require__(/*! /usr/src/app/includes/loader.js */6);
__webpack_require__(/*! /usr/src/app/includes/admin.scss */13);
__webpack_require__(/*! /usr/src/app/includes/modules/PaymentModule/style.scss */14);
__webpack_require__(/*! /usr/src/app/includes/fields/DSLayoutMultiselect/style.scss */2);
__webpack_require__(/*! /usr/src/app/includes/fields/WPZUpgradeNotice/style.scss */3);
module.exports = __webpack_require__(/*! /usr/src/app/includes/backend/style.scss */15);


/***/ }),
/* 5 */
/*!*******************************************************!*\
  !*** ./dev/divi-scripts-modified/config/polyfills.js ***!
  \*******************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// @remove-on-eject-begin

/**
 * Copyright (c) 2018-present, Elegant Themes, Inc.
 * Copyright (c) 2015-2018, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
// @remove-on-eject-end

/*if (typeof Promise === 'undefined') {
  // Rejection tracking prevents a common issue where React gets into an
  // inconsistent state due to an error, but it gets swallowed by a Promise,
  // and the user has no idea what causes React's erratic future behavior.
  require('promise/lib/rejection-tracking').enable();
  window.Promise = require('promise/lib/es6-extensions.js');
}*/
// fetch() polyfill for making API calls.
// require('whatwg-fetch');
// Object.assign() is commonly used with React.
// It will use the native implementation if it's present and isn't buggy.
// Object.assign = require('object-assign');
// In tests, polyfill requestAnimationFrame since jsdom doesn't provide it yet.
// We don't polyfill it in the browser--this is user's responsibility.

if (false) {
  require('raf').polyfill(global);
}

/***/ }),
/* 6 */
/*!****************************!*\
  !*** ./includes/loader.js ***!
  \****************************/
/*! no exports provided */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery__ = __webpack_require__(/*! jquery */ 7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_jquery__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__modules__ = __webpack_require__(/*! ./modules */ 8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__fields__ = __webpack_require__(/*! ./fields */ 10);
// External Dependencies
 // Internal Dependencies



__WEBPACK_IMPORTED_MODULE_0_jquery___default()(window).on('et_builder_api_ready', function (event, API) {
  __WEBPACK_IMPORTED_MODULE_2__fields__["a" /* default */].map(function (field) {
    field.slug += '_DSDPM';
  }); // Register custom modules

  API.registerModules(__WEBPACK_IMPORTED_MODULE_1__modules__["a" /* default */]);
  API.registerModalFields(__WEBPACK_IMPORTED_MODULE_2__fields__["a" /* default */]);
});

/***/ }),
/* 7 */
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ }),
/* 8 */
/*!***********************************!*\
  !*** ./includes/modules/index.js ***!
  \***********************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__PaymentModule_PaymentModule__ = __webpack_require__(/*! ./PaymentModule/PaymentModule */ 9);
// Internal Dependencies

/* harmony default export */ __webpack_exports__["a"] = ([__WEBPACK_IMPORTED_MODULE_0__PaymentModule_PaymentModule__["a" /* default */]]);

/***/ }),
/* 9 */
/*!**********************************************************!*\
  !*** ./includes/modules/PaymentModule/PaymentModule.jsx ***!
  \**********************************************************/
/*! exports provided: apply_responsive, default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export apply_responsive */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ 0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(/*! react-dom */ 1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/
// External Dependencies


function apply_responsive(props, key, selector) {
  var css_prop_key = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'padding';
  var important = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
  var additionalCss = [];

  if (!props[key]) {
    return;
  }

  var importantValue = important ? '!important' : '';
  var desktop = props[key];
  var isLastEdit = props["".concat(key + "_last_edited")];
  var statusActive = isLastEdit && isLastEdit.startsWith("on");

  switch (css_prop_key) {
    case 'padding':
    case 'margin':
      desktop = !["padding", "margin"].includes(css_prop_key) ? props[key] : props[key].split("|");
      additionalCss.push([{
        selector: selector,
        declaration: !["padding", "margin"].includes(css_prop_key) ? "".concat(css_prop_key, ": ").concat(desktop, " ").concat(importantValue, ";") : "".concat(css_prop_key, "-top: ").concat(desktop[0], " ").concat(importantValue, "; ").concat(css_prop_key, "-right: ").concat(desktop[1], " ").concat(importantValue, "; ").concat(css_prop_key, "-bottom: ").concat(desktop[2], " ").concat(importantValue, "; ").concat(css_prop_key, "-left: ").concat(desktop[3], " ").concat(importantValue, ";")
      }]);

      if (props["".concat(key + "_tablet")] && statusActive) {
        var tablet = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_tablet")].split("|");
        additionalCss.push([{
          selector: selector,
          declaration: !["padding", "margin"].includes(css_prop_key) ? "".concat(css_prop_key, ": ").concat(tablet, " ").concat(importantValue, ";") : "".concat(css_prop_key, "-top: ").concat(tablet[0], " ").concat(importantValue, "; ").concat(css_prop_key, "-right: ").concat(tablet[1], " ").concat(importantValue, "; ").concat(css_prop_key, "-bottom: ").concat(tablet[2], " ").concat(importantValue, "; ").concat(css_prop_key, "-left: ").concat(tablet[3], " ").concat(importantValue, ";"),
          'device': 'tablet'
        }]);
      }

      if (props["".concat(key + "_phone")] && statusActive) {
        var phone = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_phone")].split("|");
        additionalCss.push([{
          selector: selector,
          declaration: !["padding", "margin"].includes(css_prop_key) ? "".concat(css_prop_key, ": ").concat(phone, " ").concat(importantValue, ";") : "".concat(css_prop_key, "-top: ").concat(phone[0], " ").concat(importantValue, "; ").concat(css_prop_key, "-right: ").concat(phone[1], " ").concat(importantValue, "; ").concat(css_prop_key, "-bottom: ").concat(phone[2], " ").concat(importantValue, "; ").concat(css_prop_key, "-left: ").concat(phone[3], " ").concat(importantValue, ";"),
          'device': 'phone'
        }]);
      }

      return additionalCss;

    default:
      additionalCss.push([{
        selector: selector,
        declaration: css_prop_key + ':' + props[key] + importantValue
      }]);

      if (props["".concat(key + "_tablet")] && statusActive) {
        additionalCss.push([{
          selector: selector,
          declaration: css_prop_key + ':' + props[key + "_tablet"] + importantValue,
          device: 'tablet'
        }]);
      }

      if (props["".concat(key + "_phone")] && statusActive) {
        additionalCss.push([{
          selector: selector,
          declaration: css_prop_key + ':' + props[key + "_phone"] + importantValue,
          device: 'phone'
        }]);
      }

      return additionalCss;
  }
}
;

var WPZ_Payments_Divi_Module =
/*#__PURE__*/
function (_Component) {
  _inherits(WPZ_Payments_Divi_Module, _Component);

  function WPZ_Payments_Divi_Module(props) {
    var _this;

    _classCallCheck(this, WPZ_Payments_Divi_Module);

    _this = _possibleConstructorReturn(this, (WPZ_Payments_Divi_Module.__proto__ || Object.getPrototypeOf(WPZ_Payments_Divi_Module)).call(this, props));
    Object.defineProperty(_assertThisInitialized(_this), "containerRef", {
      configurable: true,
      enumerable: true,
      writable: true,
      value: void 0
    });
    Object.defineProperty(_assertThisInitialized(_this), "activeTogglePollInterval", {
      configurable: true,
      enumerable: true,
      writable: true,
      value: void 0
    });
    Object.defineProperty(_assertThisInitialized(_this), "wpzInstanceId", {
      configurable: true,
      enumerable: true,
      writable: true,
      value: void 0
    });
    _this.containerRef = __WEBPACK_IMPORTED_MODULE_0_react___default.a.createRef();
    _this.state = {
      instanceId: {},
      currentType: null,
      preview: 'default'
    };

    var types = _this.getTypes();

    for (var type in types) {
      if (types[type]) {
        _this.state.currentType = type;
        break;
      }
    }

    if (!window.et_gb.wp.hooks.hasFilter('wpz.payments.divi.module.processed.css.selector', 'wpzone/wpzPayments/processedCssSelector')) {
      window.et_gb.wp.hooks.addFilter('wpz.payments.divi.module.processed.css.selector', 'wpzone/wpzPayments/processedCssSelector', function (selector) {
        return selector.replaceAll(/[^,]*(\.wpz_payments_divi_module[^ ,]+_payments_container)/g, '$1');
      });
    }

    return _this;
  }

  _createClass(WPZ_Payments_Divi_Module, [{
    key: "getLoaderIconSvg",
    value: function getLoaderIconSvg(svg) {
      var _this2 = this;

      var svg = svg.replaceAll(/[^a-z0-9\-_]/g, '');

      if (this.state.hasOwnProperty('loaderIconSvg_' + svg)) {
        return this.state['loaderIconSvg_' + svg];
      }

      var setIcon = function setIcon(icon) {
        var newState = {};
        newState['loaderIconSvg_' + svg] = icon;

        _this2.setState(newState);
      };

      setIcon(null); // try to prevent duplicate fetches during this fetch

      window.jQuery.get(window.WpzPaymentsBuilderData.icons_url + '/spinners/' + svg + '.svg', null, setIcon, 'text');
      return '';
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      if (this.state.currentType) {
        if (this.state.instanceId[this.state.currentType]) {
          window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
          window.wpz_payments_mount(this.state.instanceId[this.state.currentType]);
        } else {
          var newInstanceId = {};
          newInstanceId[this.state.currentType] = window.wpz_payments_init(this.containerRef.current);
          this.setState({
            instanceId: Object.assign({}, this.state.instanceId, newInstanceId)
          });
        }
      }

      if (!window.et_gb.wpzone_module_instance_id) {
        window.et_gb.wpzone_module_instance_id = 0;
      }

      this.wpzInstanceId = ++window.et_gb.wpzone_module_instance_id;
      this.addModuleSettingsHooks(this.props.moduleInfo.orderClassName);
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate(oldProps, oldState) {
      if (oldProps.moduleInfo.orderClassName !== this.props.moduleInfo.orderClassName) {
        this.removeModuleSettingsHooks(oldProps.moduleInfo.orderClassName);
        this.addModuleSettingsHooks(this.props.moduleInfo.orderClassName);
      }

      if (oldState.currentType && this.state.currentType !== oldState.currentType && this.state.instanceId[oldState.currentType]) {
        window.wpz_payments_unmount(this.state.instanceId[oldState.currentType]);
      }

      if (this.props.payment_type !== oldProps.payment_type) {
        var newTypes = this.getTypes();

        if (!this.state.currentType || !newTypes[this.state.currentType]) {
          var newType = null;

          for (var type in newTypes) {
            if (newTypes[type]) {
              newType = type;
              break;
            }
          }

          this.setState({
            currentType: newType
          });
        }
      } else if (this.state.currentType) {
        if (this.state.instanceId[this.state.currentType] && this.state.currentType !== oldState.currentType) {
          window.wpz_payments_mount(this.state.instanceId[this.state.currentType]);
        } else if (!this.state.instanceId[this.state.currentType] || this.props.display_mode === 'modal' && this.state.preview === 'form' && (oldProps.display_mode !== 'modal' || oldState.preview !== 'form') || oldProps.display_mode === 'modal' && oldState.preview === 'form' && (this.props.display_mode !== 'modal' || this.state.preview !== 'form')) {
          var newInstanceId = {};
          newInstanceId[this.state.currentType] = window.wpz_payments_init(this.containerRef.current);
          this.setState({
            instanceId: Object.assign({}, this.state.instanceId, newInstanceId)
          });
        } else if (this.props.paypal_button_text !== oldProps.paypal_button_text || this.props.paypal_show_tagline !== oldProps.paypal_show_tagline || this.props.paypal_button_layout !== oldProps.paypal_button_layout || this.props.paypal_button_color !== oldProps.paypal_button_color || this.props.paypal_button_border_radius !== oldProps.paypal_button_border_radius || this.props.paypal_button_height !== oldProps.paypal_button_height || this.props.stripe_theme !== oldProps.stripe_theme || this.props.display_mode !== oldProps.display_mode) {
          window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
          window.wpz_payments_mount(this.state.instanceId[this.state.currentType]);
        }

        window.wpz_payments_set_styles(this.state.instanceId[this.state.currentType], window.jQuery('.' + this.props.moduleInfo.orderClassName + ' > .et-fb-custom-css-output').text(), this.props.stripe_theme);
      }
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      if (this.state.instanceId[this.state.currentType]) {
        window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
      }

      this.removeModuleSettingsHooks(this.props.moduleInfo.orderClassName);
    } // ds-gravity-forms-for-divi/includes/modules/GravityForms/GravityForms.jsx

  }, {
    key: "addModuleSettingsHooks",
    value: function addModuleSettingsHooks(moduleOrder) {
      var _this = this,
          moduleSlug = WPZ_Payments_Divi_Module.slug;

      window.et_gb.wp.hooks.addAction('et.builder.store.module.settings.open', 'wpzone/m' + this.wpzInstanceId + '/moduleSettingsOpen', function (module) {
        if (_this.activeTogglePollInterval) {
          clearTimeout(_this.activeTogglePollInterval);
          _this.activeTogglePollInterval = null;
        }

        if (module.props && module.props.moduleClassName.indexOf(_this.props.moduleInfo.orderClassName) !== -1) {
          _this.activeTogglePollInterval = setInterval(function () {
            var newActiveToggle = window.et_gb.jQuery('.et-fb-tabs__panel--active:first .et-fb-form__toggle-opened:first').data('name');

            switch (newActiveToggle) {
              case 'confirm':
              case 'confirm_buttons':
                var previewMode = 'confirm';
                break;

              case 'success':
              case 'notification_success':
                var previewMode = 'success';
                break;

              case 'error':
              case 'notification_error':
                var previewMode = 'error';
                break;

              case 'load_error':
                var previewMode = 'load_error';
                break;

              case 'reload_info':
              case 'reload_message':
                var previewMode = 'reload_info';
                break;

              case 'product':
              case 'price':
              case 'quantity':
              case 'form':
              case 'form_fields':
              case 'payment':
              case 'module_text':
              case 'title':
              case 'description':
              case 'price_fixed':
              case 'price_custom_field':
              case 'price_custom_currency':
              case 'price_label':
              case 'form_fields_design':
              case 'labels':
              case 'checkbox':
              case 'notes_field_instructions_design':
              case 'pay_button':
              case 'close_button':
              case 'modal':
              case 'background':
              case 'width':
              case 'margin_padding':
              case 'box_shadow':
              case 'border':
                var previewMode = 'form';
                break;

              case 'form_fields_error':
              case 'fields_validation':
                var previewMode = 'validation';
                break;

              case 'preloader':
                var previewMode = 'preloader';
                break;

              default:
                var previewMode = 'default';
            }

            if (_this.state.activeToggle !== newActiveToggle) {
              _this.setState({
                activeToggle: newActiveToggle,
                preview: previewMode
              });
            }
          }, 500);
        }
      });
      window.et_gb.wp.hooks.addAction('et.builder.store.module.settings.close', 'wpzone/m' + this.wpzInstanceId + '/moduleSettingsClose', function (module) {
        if (module.props && module.props.type === moduleSlug) {
          if (_this.activeTogglePollInterval) {
            clearTimeout(_this.activeTogglePollInterval);
            _this.activeTogglePollInterval = null;
          }

          _this.setState({
            activeToggle: null,
            preview: 'default'
          });
        }
      });
    }
  }, {
    key: "removeModuleSettingsHooks",
    value: function removeModuleSettingsHooks(moduleOrder) {
      window.et_gb.wp.hooks.removeAction('et.builder.store.module.settings.open', 'wpzone/m' + this.wpzInstanceId + '/moduleSettingsOpen');
      window.et_gb.wp.hooks.removeAction('et.builder.store.module.settings.close', 'wpzone/m' + this.wpzInstanceId + '/moduleSettingsClose');
    }
    /**
     * All component inline styling.
     *
     * @since 1.0.0
     *
     * @return array
     */

  }, {
    key: "getTypes",
    value: function getTypes() {
      var types = this.props.payment_type.split('|');
      return {
        stripe: types[0] === 'on',
        paypal: types[1] === 'on'
      };
    }
    /**
     * Render component output
     *
     * @return {JSX.Element}
     */

  }, {
    key: "render",
    value: function render() {
      var _this3 = this,
          _React$createElement;

      var types = this.getTypes();
      var dataAttrs = {
        'data-load-error-message': this.props.load_error_message
      };

      if (types.stripe) {
        dataAttrs['data-reload-info-message'] = this.props.reload_info_message;
      }

      if (types.paypal) {
        dataAttrs['data-paypal-category'] = this.props.paypal_category ? this.props.paypal_category : 'physical';

        if (this.props.paypal_button_text && this.props.paypal_button_text !== 'none') {
          dataAttrs['data-paypal-button-text'] = this.props.paypal_button_text;
        }

        if (this.props.paypal_button_layout && this.props.paypal_button_layout === 'horizontal') {
          dataAttrs['data-paypal-buttons-horizontal'] = 1;

          if (this.props.paypal_show_tagline === 'on') {
            dataAttrs['data-paypal-show-tagline'] = 1;
          }
        }

        if (this.props.paypal_button_text && this.props.paypal_button_text !== 'gold') {
          dataAttrs['data-paypal-button-color'] = this.props.paypal_button_color;
        }

        if (this.props.paypal_button_border_radius === 'more') {
          dataAttrs['data-paypal-button-border-radius'] = 'more';
        }

        if (this.props.paypal_button_height) {
          dataAttrs['data-paypal-button-height'] = parseInt(this.props.paypal_button_height);
        }
      }

      if (this.props.stripe_theme) {
        dataAttrs['data-stripe-theme'] = this.props.stripe_theme;
      }

      if (this.props.no_reload_on_success === 'on') {
        dataAttrs['data-no-reload-on-success'] = 1;
      }

      if (this.props.statement_descriptor) {
        dataAttrs['data-statement-descriptor'] = this.props.statement_descriptor;
      }
      /*
      if (this.props.phone_field === 'on') {
          dataAttrs['data-phone-field'] = 1;
      }
       if (this.props.billing_address_field === 'on') {
          dataAttrs['data-billing-address-field'] = 1;
      }
      */


      if (this.props.price_type === 'custom') {
        var priceFieldValidationAttrs = {
          min: Math.max(0, this.props.minimum_price)
        };
        priceFieldValidationAttrs['data-validation-message-minimum'] = this.props.validation_minimum_price;

        if (this.props.maximum_price) {
          priceFieldValidationAttrs.max = this.props.maximum_price;
          priceFieldValidationAttrs['data-validation-message-maximum'] = this.props.validation_maximum_price;
        }

        if (this.props.price_step) {
          priceFieldValidationAttrs.step = this.props.price_step;
          priceFieldValidationAttrs['data-validation-message-step'] = this.props.validation_step_price;
        }
      }

      var handleShowButtonClick = function handleShowButtonClick() {
        _this3.setState({
          preview: 'form'
        });
      };

      var handleCloseButtonClick = function handleCloseButtonClick() {
        _this3.setState({
          preview: 'default'
        });
      };

      var paymentsContainerContents = __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Fragment, null, this.props.display_mode === 'modal' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-close-button-wrapper"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        className: "wpz-payments-close-button",
        "aria-label": "Close",
        onClick: handleCloseButtonClick
      })), this.state.preview === 'load_error' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-error"
      }, this.props.load_error_message), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("h4", {
        className: "wpz-payments-title"
      }, this.props.title), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-description"
      }, this.props.content()), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-price"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("label", null, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-label wpz-payments-price-label"
      }, this.props.price_label), this.props.price_type === 'custom' ? __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Fragment, null, this.state.preview === 'validation' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("p", {
        className: "wpz-payments-validation-error"
      }, window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-price-wrapper"
      }, (window.WpzPaymentsFrontendData.currency_symbol_position === 'before' || window.WpzPaymentsFrontendData.currency_symbol_position === 'before_space') && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-price-currency wpz-payments-price-currency-" + window.WpzPaymentsFrontendData.currency_symbol_position
      }, window.WpzPaymentsFrontendData.currency_symbol), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("input", Object.assign({
        type: "number",
        className: "wpz-payments-price-amount wpz-payments-form-field",
        defaultValue: this.props.price_default
      }, priceFieldValidationAttrs)), (window.WpzPaymentsFrontendData.currency_symbol_position === 'after' || window.WpzPaymentsFrontendData.currency_symbol_position === 'after_space') && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-price-currency wpz-payments-price-currency-" + window.WpzPaymentsFrontendData.currency_symbol_position
      }, window.WpzPaymentsFrontendData.currency_symbol))) : __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-price-amount wpz-payments-fixed-price-amount",
        "data-value": this.props.price_default
      }, window.wpz_payments_format_price(this.props.price_default)))), this.props.quantity === 'on' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-quantity"
      }, this.state.preview === 'validation' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("p", {
        className: "wpz-payments-validation-error"
      }, window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("label", null, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-label wpz-payments-quantity-label"
      }, this.props.quantity_label), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("input", (_React$createElement = {
        type: "number",
        className: "wpz-payments-quantity-amount wpz-payments-form-field",
        defaultValue: this.props.quantity_default,
        min: Math.max(0, this.props.minimum_quantity),
        max: this.props.maximum_quantity ? this.props.maximum_quantity : null
      }, _defineProperty(_React$createElement, "min", this.props.quantity_step), _defineProperty(_React$createElement, "data-validation-message-minimum", this.props.validation_minimum_quantity), _defineProperty(_React$createElement, "data-validation-message-maximum", this.props.maximum_quantity ? this.props.validation_maximum_quantity : null), _defineProperty(_React$createElement, "data-validation-message-step", this.props.validation_step_quantity), _React$createElement)))), types.paypal && types.stripe && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("ul", {
        className: "wpz-payments-type-options"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("li", {
        className: "wpz-payments-type-option-stripe"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("a", {
        href: "javascript:void(0)",
        onClick: function onClick() {
          return _this3.setState({
            currentType: 'stripe'
          });
        }
      }, window.wp.i18n.__('Stripe', 'wpz-payments'))), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("li", {
        className: "wpz-payments-type-option-paypal"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("a", {
        href: "javascript:void(0)",
        onClick: function onClick() {
          return _this3.setState({
            currentType: 'paypal'
          });
        }
      }, window.wp.i18n.__('PayPal', 'wpz-payments')))), this.state.preview === 'reload_info' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-reload-info"
      }, this.props.reload_info_message), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-form"
      }), this.props.notes_field === 'on' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-notes"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("label", {
        htmlFor: this.props.moduleInfo.orderClassName + "_notes_field",
        className: "wpz-payments-label wpz-payments-notes-label"
      }, this.props.notes_field_label), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-notes-instructions",
        dangerouslySetInnerHTML: {
          __html: this.props.notes_field_instructions
        }
      }), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("textarea", {
        id: this.props.moduleInfo.orderClassName + "_notes_field",
        className: "wpz-payments-notes-field wpz-payments-form-field",
        required: this.props.notes_field_required === 'on'
      })), this.props.agreement_checkbox === 'on' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Fragment, null, this.state.preview === 'validation' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("p", {
        className: "wpz-payments-validation-error wpz-payments-agreement-validation-error"
      }, window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-agreement"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-agreement-checkbox-wrapper"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("input", {
        id: this.props.moduleInfo.orderClassName + "_payment_module_agreement_checkbox",
        type: "checkbox",
        className: "wpz-payments-agreement-checkbox",
        "data-validation-message": this.props.validation_agreement
      }), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "checkbox-StyledInput"
      })), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("label", {
        htmlFor: this.props.moduleInfo.orderClassName + "_payment_module_agreement_checkbox"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-agreement-text",
        dangerouslySetInnerHTML: {
          __html: this.props.agreement_text
        }
      })))), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-button-wrapper"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        type: "button",
        className: "wpz-payments-pay-button et_pb_button",
        "data-text-template": this.props.button_text,
        disabled: window.wpz_payments_pay_button_is_disabled(window.jQuery(this.containerRef.current))
      }, window.wpz_payments_pay_button_text(window.jQuery(this.containerRef.current), this.props.button_text)), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-paypal-button"
      })), this.state.preview === 'error' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-error"
      }, this.props.error_message.replaceAll(/%\{error_reason\}/g, window.wp.i18n.__('Unknown', 'wpz-payments'))), this.state.preview === 'success' && this.props.success_action === 'message' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-success"
      }, this.props.success_message), this.state.preview === 'confirm' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-confirm"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("p", null, this.props.confirm_message.replaceAll(/%s/g,
      /* translators: amount placeholder */
      window.wp.i18n.__('[amount]', 'wpz-payments'))), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-button-confirm-wrapper"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        className: "wpz-payments-confirm-yes wpz-payments-pay-button et_pb_button"
      }, this.props.confirm_yes), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        className: "wpz-payments-confirm-no et_pb_button wpz-payments-button-secondary"
      }, this.props.confirm_no))), this.props.show_credit === 'on' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Fragment, null, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("small", {
        className: "wpz-payments-credit wpz-payments-credit-stripe",
        "aria-hidden": this.state.currentType !== 'stripe',
        dangerouslySetInnerHTML: {
          // translators: %s are <a> tags, except for second %s which is payment processor name
          __html: window.jQuery('<div>').text(window.wp.i18n.__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments')).html().replace('%s', '<a href="https://stripe.com/" target="_blank">').replace('%s', window.wp.i18n.__('Stripe')).replace('%s', '</a>').replace('%s', '<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">').replace('%s', '</a>')
        }
      }), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("small", {
        className: "wpz-payments-credit wpz-payments-credit-paypal",
        "aria-hidden": this.state.currentType !== 'paypal',
        dangerouslySetInnerHTML: {
          // translators: %s are <a> tags, except for second %s which is payment processor name
          __html: window.jQuery('<div>').text(window.wp.i18n.__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments')).html().replace('%s', '<a href="https://paypal.com/" target="_blank">').replace('%s', window.wp.i18n.__('PayPal')).replace('%s', '</a>').replace('%s', '<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">').replace('%s', '</a>')
        }
      })), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-preloader"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-preloader-icon",
        dangerouslySetInnerHTML: {
          __html: this.getLoaderIconSvg(this.props.preloader_style)
        }
      }), this.props.preloader_text_enable === 'on' && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
        className: "wpz-payments-preloader-text"
      }, this.props.preloader_text)));
      var ariaAttrs = {};

      if (this.props.display_mode !== 'page' && this.state.preview !== 'default') {
        ariaAttrs['aria-hidden'] = true;
      }

      var paymentsContainer = __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", Object.assign({
        className: 'wpz-payments-container wpz-payments-' + this.state.currentType + ' wpz-payments-display-' + this.props.display_mode + ' ' + this.props.moduleInfo.orderClassName + '_payments_container' + (this.props.display_mode !== 'page' && this.state.preview !== 'default' ? ' wpz-payments-active' : '') + (this.state.preview === 'preloader' ? ' wpz-payments-loading' : ''),
        ref: this.containerRef
      }, ariaAttrs, dataAttrs), this.props.display_mode === 'modal' ? __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payment-modal-content"
      }, paymentsContainerContents) : paymentsContainerContents);
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Fragment, null, this.props.display_mode !== 'page' && (this.props.display_mode === 'modal' || this.state.preview === 'default') && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-payments-show-button-wrapper"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        className: "wpz-payments-show-button et_pb_button",
        onClick: handleShowButtonClick
      }, this.props.show_button_text)), this.props.display_mode === 'modal' && this.state.preview !== 'default' ? __WEBPACK_IMPORTED_MODULE_1_react_dom___default.a.createPortal(paymentsContainer, window.document.body) : paymentsContainer);
    }
  }], [{
    key: "css",
    value: function css(props) {
      var generateStyles = window.ET_Builder.API.Utils.generateStyles;
      var additionalCss = []; // -----------------------------------------------------
      // CSS
      // -----------------------------------------------------

      additionalCss.push([{
        selector: '%%order_class%% .wpz-payments-title, %%order_class%%_payments_container .wpz-payments-title',
        declaration: "background: ".concat(props.title_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-description, %%order_class%%_payments_container .wpz-payments-description',
        declaration: "background: ".concat(props.description_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-notes-instructions, %%order_class%%_payments_container .wpz-payments-notes-instructions',
        declaration: "background: ".concat(props.notes_field_instructions_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-error, %%order_class%%_payments_container .wpz-payments-error',
        declaration: "background: ".concat(props.notification_error_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-success, %%order_class%%_payments_container .wpz-payments-success',
        declaration: "background: ".concat(props.notification_success_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-confirm, %%order_class%%_payments_container .wpz-payments-confirm',
        declaration: "background: ".concat(props.confirmation_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-reload-info, %%order_class%%_payments_container .wpz-payments-reload-info',
        declaration: "background: ".concat(props.reload_message_background, ";")
      }, {
        selector: '%%order_class%%_payments_container.wpz-payments-display-modal',
        declaration: "background: ".concat(props.modal_overlay_background, ";")
      }, {
        selector: '%%order_class%% .wpz-payments-validation-error, %%order_class%%_payments_container .wpz-payments-validation-error',
        declaration: "background: ".concat(props.fields_validation_background, ";")
      }]);

      if (props.pay_button_fullwidth === 'on') {
        additionalCss.push([{
          selector: '%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button, %%order_class%%_payments_container  .wpz-payments-button-wrapper button.wpz-payments-pay-button',
          declaration: 'width: 100%;'
        }]);
      }

      if (props.show_payment_button_fullwidth === 'on') {
        additionalCss.push([{
          selector: '%%order_class%% button.wpz-payments-show-button',
          declaration: 'width: 100%;'
        }]);
      } // Fields Error


      additionalCss.push(generateStyles({
        attrs: props,
        name: 'fields_error_text_color',
        selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
        cssProperty: 'color'
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'fields_error_background_color',
        selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
        cssProperty: 'background-color'
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'fields_error_border_color',
        selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
        cssProperty: 'border-color'
      })); // Labels

      additionalCss.push(generateStyles({
        attrs: props,
        name: 'labels_text_color',
        selector: '%%order_class%% .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-label, %%order_class%% #STRIPE .Label',
        cssProperty: 'color'
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'labels_error_text_color',
        selector: '%%order_class%% label.wpz-field-invalid .wpz-payments-label, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-label, %%order_class%% #STRIPE .Label--invalid',
        cssProperty: 'color'
      })); // Custom Price Label

      additionalCss.push(generateStyles({
        attrs: props,
        name: 'price_label_text_color',
        selector: '%%order_class%% .wpz-payments-price .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price .wpz-payments-label',
        cssProperty: 'color'
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'price_label_error_text_color',
        selector: '%%order_class%% .wpz-payments-price label.wpz-field-invalid .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price  label.wpz-field-invalid .wpz-payments-label',
        cssProperty: 'color'
      })); // Checkboxes

      additionalCss.push(generateStyles({
        attrs: props,
        name: 'checkbox_background_color',
        selector: '%%order_class%% .wpz-payments-agreement .checkbox-StyledInput, %%order_class%%_payments_container .wpz-payments-agreement .checkbox-StyledInput',
        cssProperty: 'background',
        important: true
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'checkbox_checked_background_color',
        selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput',
        cssProperty: 'background',
        important: true
      }));

      if (props.stripe_theme === 'none') {
        additionalCss.push(generateStyles({
          attrs: props,
          name: 'checkbox_checked_color',
          selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
          cssProperty: 'color',
          important: true
        }));
      } else {
        additionalCss.push(generateStyles({
          attrs: props,
          name: 'checkbox_checked_color',
          selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
          cssProperty: 'border-bottom-color'
        }));
        additionalCss.push(generateStyles({
          attrs: props,
          name: 'checkbox_checked_color',
          selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
          cssProperty: 'border-right-color'
        }));
      } // Checkbox Label


      additionalCss.push(generateStyles({
        attrs: props,
        name: 'checkbox_list_item_color',
        selector: '%%order_class%% .wpz-payments-agreement label, %%order_class%%_payments_container .wpz-payments-agreement label',
        cssProperty: 'color'
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'checkbox_checked_list_item_color',
        selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ label, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ label',
        cssProperty: 'color'
      })); // Pay Button Icon

      if (props.pay_button_use_icon === 'on' && props.pay_button_icon) {
        var icon = window.ET_Builder.API.Utils.processFontIcon(props.pay_button_icon);
        var placement = props.pay_button_icon_placement === 'left' ? 'before' : 'after';
        additionalCss.push([{
          selector: "%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button::".concat(placement, ", %%order_class%%_payments_container .wpz-payments-button-wrapper button.wpz-payments-pay-button::").concat(placement),
          declaration: "content: '".concat(icon, "'!important;")
        }]);
      } // Confirm No Icon


      if (props.custom_confirm_no === 'on' && props.confirm_no_use_icon === 'on' && props.confirm_no_icon) {
        var _icon = window.ET_Builder.API.Utils.processFontIcon(props.confirm_no_icon);

        var _placement = props.confirm_no_icon_placement === 'left' ? 'before' : 'after';

        additionalCss.push([{
          selector: "%%order_class%% button.wpz-payments-confirm-no::".concat(_placement, ", %%order_class%%_payments_container button.wpz-payments-confirm-no::").concat(_placement),
          declaration: "content: '".concat(_icon, "'!important;")
        }]);
      } // Confirm Yes Icon


      if (props.custom_confirm_yes === 'on' && props.confirm_yes_use_icon === 'on' && props.confirm_yes_icon) {
        var _icon2 = window.ET_Builder.API.Utils.processFontIcon(props.confirm_yes_icon);

        var _placement2 = props.confirm_yes_icon_placement === 'left' ? 'before' : 'after';

        additionalCss.push([{
          selector: "%%order_class%% button.wpz-payments-pay-button.wpz-payments-confirm-yes::".concat(_placement2, ", %%order_class%%_payments_container button.wpz-payments-pay-button.wpz-payments-confirm-yes::").concat(_placement2),
          declaration: "content: '".concat(_icon2, "'!important;")
        }]);
      } // Show Payments Button Icon


      if (props.show_payment_button_use_icon === 'on' && props.show_payment_button_icon) {
        var _icon3 = window.ET_Builder.API.Utils.processFontIcon(props.show_payment_button_icon);

        var _placement3 = props.show_payment_button_icon_placement === 'left' ? 'before' : 'after';

        additionalCss.push([{
          selector: "%%order_class%% button.wpz-payments-show-button::".concat(_placement3),
          declaration: "content: '".concat(_icon3, "'!important;")
        }]);
      } // Close button


      additionalCss.push(generateStyles({
        attrs: props,
        name: 'close_button_background',
        selector: '%%order_class%%_payments_container button.wpz-payments-close-button',
        cssProperty: 'background',
        important: true
      }));
      additionalCss.push(generateStyles({
        attrs: props,
        name: 'close_button_color',
        selector: '%%order_class%%_payments_container button.wpz-payments-close-button',
        cssProperty: 'color',
        important: true
      })); // Preloader Icon

      var preloaderIconColor = '#2EA3F2';

      if (props.preloader_icon_color !== '') {
        preloaderIconColor = props.preloader_icon_color;
      }

      additionalCss.push([{
        selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_stroke',
        declaration: "stroke: ".concat(preloaderIconColor, ";")
      }, {
        selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_fill',
        declaration: "fill: ".concat(preloaderIconColor, ";")
      }]);

      if (props.preloader_style === 'spinning_circles') {
        additionalCss.push([{
          selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_spinning_circles',
          declaration: "stroke: ".concat(preloaderIconColor, ";")
        }, {
          selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_spinning_circles circle',
          declaration: "fill: ".concat(preloaderIconColor, ";")
        }]);
      } // -----------------------------------------------------
      // Responsive CSS
      // -----------------------------------------------------


      var additionalCss_ = additionalCss;
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_padding', '%%order_class%% .wpz-payments-title, %%order_class%%_payments_container .wpz-payments-title', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_margin', '%%order_class%% .wpz-payments-title, %%order_class%%_payments_container .wpz-payments-title', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'description_padding', '%%order_class%% .wpz-payments-description, %%order_class%%_payments_container .wpz-payments-description', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'description_margin', '%%order_class%% .wpz-payments-description, %%order_class%%_payments_container .wpz-payments-description', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notes_field_instructions_padding', '%%order_class%% .wpz-payments-notes-instructions, %%order_class%%_payments_container .wpz-payments-notes-instructions', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notes_field_instructions_margin', '%%order_class%% .wpz-payments-notes-instructions, %%order_class%%_payments_container .wpz-payments-notes-instructions', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'labels_padding', '%%order_class%% .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-label, %%order_class%% #STRIPE .Label', 'padding', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'labels_margin', '%%order_class%% .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-label, %%order_class%% #STRIPE .Label', 'margin', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'price_label_padding', '%%order_class%% .wpz-payments-price .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price .wpz-payments-label', 'padding', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'price_label_margin', '%%order_class%% .wpz-payments-price .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price .wpz-payments-label', 'margin', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'price_currency_offset', '%%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-before, %%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-before_space, %%order_class%%_payments_container .wpz-payments-price-wrapper .wpz-payments-price-currency-before, %%order_class%%_payments_container .wpz-payments-price-wrapper .wpz-payments-price-currency-before_space', 'margin-right', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'price_currency_offset', '%%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-after, %%order_class%% .wpz-payments-price-wrapper .wpz-payments-price-currency-after_space, %%order_class%%_payments_container .wpz-payments-price-wrapper .wpz-payments-price-currency-after, %%order_class%%_payments_container .wpz-payments-price-wrapper .wpz-payments-price-currency-after_space', 'margin-left', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notification_error_padding', '%%order_class%% .wpz-payments-error, %%order_class%%_payments_container .wpz-payments-error', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notification_error_margin', '%%order_class%% .wpz-payments-error, %%order_class%%_payments_container .wpz-payments-error', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notification_success_padding', '%%order_class%% .wpz-payments-success, %%order_class%%_payments_container .wpz-payments-success', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'notification_success_margin', '%%order_class%% .wpz-payments-success, %%order_class%%_payments_container .wpz-payments-success', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'confirmation_padding', '%%order_class%% .wpz-payments-confirm, %%order_class%%_payments_container .wpz-payments-confirm', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'confirmation_margin', '%%order_class%% .wpz-payments-confirm, %%order_class%%_payments_container .wpz-payments-confirm', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'reload_message_padding', '%%order_class%% .wpz-payments-reload-info, %%order_class%%_payments_container .wpz-payments-reload-info', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'reload_message_margin', '%%order_class%% .wpz-payments-reload-info, %%order_class%%_payments_container .wpz-payments-reload-info', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'fields_validation_padding', '%%order_class%% .wpz-payments-validation-error, %%order_class%%_payments_container .wpz-payments-validation-error', 'padding', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'fields_validation_margin', '%%order_class%% .wpz-payments-validation-error, %%order_class%%_payments_container .wpz-payments-validation-error', 'margin', true));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'close_button_alignment', '%%order_class%%_payments_container .wpz-payments-close-button-wrapper', 'text-align'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'close_button_icon_size', '%%order_class%%_payments_container button.wpz-payments-close-button', 'font-size'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'close_button_padding', '%%order_class%%_payments_container button.wpz-payments-close-button', 'padding'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'close_button_margin', '%%order_class%%_payments_container button.wpz-payments-close-button', 'margin'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'preloader_icon_size', '%%order_class%%_payments_container .wpz-payments-preloader .wpz-payments-preloader-icon .wpz_payments_spinner', 'width'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'preloader_text_offset', '%%order_class%%_payments_container .wpz-payments-preloader .wpz-payments-preloader-icon + .wpz-payments-preloader-text', 'margin-top'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'paypal_button_max_width', '%%order_class%% .wpz-payments-paypal-button', 'max-width'));
      additionalCss_ = additionalCss_.concat(apply_responsive(props, 'paypal_button_align', '%%order_class%% .wpz-payments-paypal .wpz-payments-button-wrapper', 'text-align'));
      return additionalCss_;
    }
  }]);

  return WPZ_Payments_Divi_Module;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

Object.defineProperty(WPZ_Payments_Divi_Module, "slug", {
  configurable: true,
  enumerable: true,
  writable: true,
  value: 'wpz_payments_divi_module'
});
/* harmony default export */ __webpack_exports__["a"] = (WPZ_Payments_Divi_Module);

/***/ }),
/* 10 */
/*!**********************************!*\
  !*** ./includes/fields/index.js ***!
  \**********************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__DSLayoutMultiselect_DSLayoutMultiselect__ = __webpack_require__(/*! ./DSLayoutMultiselect/DSLayoutMultiselect */ 11);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__WPZUpgradeNotice_WPZUpgradeNotice__ = __webpack_require__(/*! ./WPZUpgradeNotice/WPZUpgradeNotice */ 12);


/* harmony default export */ __webpack_exports__["a"] = ([__WEBPACK_IMPORTED_MODULE_0__DSLayoutMultiselect_DSLayoutMultiselect__["a" /* default */], __WEBPACK_IMPORTED_MODULE_1__WPZUpgradeNotice_WPZUpgradeNotice__["a" /* default */]]);

/***/ }),
/* 11 */
/*!*********************************************************************!*\
  !*** ./includes/fields/DSLayoutMultiselect/DSLayoutMultiselect.jsx ***!
  \*********************************************************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ 0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__style_scss__ = __webpack_require__(/*! ./style.scss */ 2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__style_scss__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

// External Dependencies
 // Internal Dependencies



var DSLayoutMultiselect =
/*#__PURE__*/
function (_React$Component) {
  _inherits(DSLayoutMultiselect, _React$Component);

  function DSLayoutMultiselect() {
    var _this;

    _classCallCheck(this, DSLayoutMultiselect);

    _this = _possibleConstructorReturn(this, (DSLayoutMultiselect.__proto__ || Object.getPrototypeOf(DSLayoutMultiselect)).call(this));
    _this.state = {
      activeOption: []
    };
    _this._onChange = _this._onChange.bind(_assertThisInitialized(_this));
    _this.switchButton = _this.switchButton.bind(_assertThisInitialized(_this));
    _this.getProcessedValue = _this.getProcessedValue.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(DSLayoutMultiselect, [{
    key: "shouldComponentUpdate",
    value: function shouldComponentUpdate(newProps, newState) {
      return this.state.activeOption.join('|') !== newState.activeOption.join('|') || this.props.activeTabMode !== newProps.activeTabMode || this.props.value !== newProps.value;
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      this.setState({
        activeOption: this.getProcessedValue()
      });
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate() {
      this.setState({
        activeOption: this.getProcessedValue()
      });
    }
  }, {
    key: "getProcessedValue",
    value: function getProcessedValue() {
      var value = this.props.value || this.props.default;

      if (typeof value === 'undefined' || '' === value) {
        return [];
      } // Support toggleable, multi selection, on tablet and phone. Convert 'none' value as empty
      // array because it has been modified on mobile.


      if (this.props.emptyMobileNone && 'none' === value) {
        return [];
      }

      return value.split('|');
    }
  }, {
    key: "switchButton",
    value: function switchButton(event) {
      event.preventDefault();
      var $clickedButton = window.jQuery(event.target).closest('.et-fb-multiple-buttons-toggle');
      var clickedButtonVal = $clickedButton.data('option_value');
      var newProcessedValue = this.state.activeOption; // support multi selection

      if (this.props.toggleable && this.state.activeOption.indexOf(clickedButtonVal) !== -1) {
        if (this.props.multi_selection) {
          newProcessedValue = newProcessedValue.filter(function (item) {
            return item !== clickedButtonVal;
          }).join('|');
        } else {
          newProcessedValue = this.props.default;
        }
      } else {
        // support multi selection
        if (this.props.multi_selection) {
          newProcessedValue.push(clickedButtonVal);
        }

        newProcessedValue = this.props.multi_selection ? newProcessedValue.join('|') : clickedButtonVal;
      } // Support toggleable, multi selection, on tablet and phone. Set empty value as 'none' to ensure
      // this value can be used as a flag to tell VB if current option has been modified on mobile.


      if (this.props.emptyMobileNone && '' === newProcessedValue) {
        newProcessedValue = 'none';
      }

      this._onChange(newProcessedValue);
    }
  }, {
    key: "_onChange",
    value: function _onChange(newValue) {
      var _props = this.props,
          name = _props.name,
          _onChange = _props._onChange;
      var activeOption = newValue; // Support toggleable, multi selection, on tablet and phone. Convert 'none' value as empty
      // string because it has been modified on mobile.

      if (this.props.emptyMobileNone && 'none' === newValue) {
        activeOption = '';
      }

      this.setState({
        activeOption: (typeof activeOption === 'string' ? activeOption : activeOption.toString()).split('|')
      });

      _onChange(name, newValue);
    }
  }, {
    key: "render",
    value: function render() {
      var thisClass = this;
      var optionsSet = thisClass.props.fieldDefinition.options;
      var customClass = thisClass.props.fieldDefinition.customClass ? thisClass.props.fieldDefinition.customClass : '';
      var buttonsOutput = Object.entries(optionsSet).map(function (entry) {
        var optionData = entry[1];
        var optionValue = entry[0];
        var isActiveButton = thisClass.state.activeOption.indexOf(optionValue) !== -1;
        var buttonClasses = 'et-fb-multiple-buttons-toggle-internal' + (isActiveButton ? ' et-fb-multiple-buttons-toggle-internal__active' : '');
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("li", {
          className: "et-fb-multiple-buttons-toggle",
          "data-tooltip": optionData.title,
          "data-option_value": optionValue,
          onClick: thisClass.switchButton,
          key: optionValue
        }, optionData.isPro && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
          className: "wpz-image-select-pro-option"
        }, window.wp.i18n.__('Pro', 'wpz-payments')), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("span", {
          className: buttonClasses,
          dangerouslySetInnerHTML: {
            __html: optionData.iconSvg
          }
        }));
      });
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', {
        className: "et-fb-multiple-buttons-outer " + customClass
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('ul', {
        className: "et-fb-multiple-buttons-container"
      }, buttonsOutput));
    }
  }]);

  return DSLayoutMultiselect;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

Object.defineProperty(DSLayoutMultiselect, "slug", {
  configurable: true,
  enumerable: true,
  writable: true,
  value: 'DSLayoutMultiselect'
});
/* harmony default export */ __webpack_exports__["a"] = (DSLayoutMultiselect);

/***/ }),
/* 12 */
/*!***************************************************************!*\
  !*** ./includes/fields/WPZUpgradeNotice/WPZUpgradeNotice.jsx ***!
  \***************************************************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ 0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(/*! react-dom */ 1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss__ = __webpack_require__(/*! ./style.scss */ 3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__style_scss__);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }





var WPZUpgradeNotice =
/*#__PURE__*/
function (_Component) {
  _inherits(WPZUpgradeNotice, _Component);

  function WPZUpgradeNotice(props) {
    var _this;

    _classCallCheck(this, WPZUpgradeNotice);

    _this = _possibleConstructorReturn(this, (WPZUpgradeNotice.__proto__ || Object.getPrototypeOf(WPZUpgradeNotice)).call(this, props));
    _this.state = {};
    return _this;
  }

  _createClass(WPZUpgradeNotice, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      this.checkProps();
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate(oldProps) {
      this.checkProps(oldProps.moduleSettings);
    }
  }, {
    key: "checkProps",
    value: function checkProps(oldSettings) {
      var result = false;

      for (var setting in this.props.fieldDefinition.conditions) {
        if (Array.isArray(this.props.fieldDefinition.conditions[setting])) {
          if (this.props.fieldDefinition.conditions[setting].indexOf(this.props.moduleSettings[setting]) !== -1) {
            result = true;
            this.resetSetting(setting, oldSettings);
            break;
          }
        } else if (this.props.moduleSettings[setting] === this.props.fieldDefinition.conditions[setting]) {
          result = true;
          this.resetSetting(setting, oldSettings);
          break;
        }
      }

      if (result && !this.state.visible && window.et_gb.jQuery(window.et_gb.document.body).has('.et-fb-modal__module-settings').length) {
        this.setState({
          visible: true
        });
      }
    }
  }, {
    key: "resetSetting",
    value: function resetSetting(setting, oldSettings) {
      if (oldSettings && oldSettings[setting]) {
        var resetValue = oldSettings[setting];
      } else if (window.ETBuilderBackend.componentDefinitions.generalFields[this.props.fieldDefinition.module_slug].hasOwnProperty(setting)) {
        var resetValue = window.ETBuilderBackend.componentDefinitions.generalFields[this.props.fieldDefinition.module_slug][setting];
      } else {
        var resetValue = '';
      }

      this.props._onChange(setting, resetValue);
    }
  }, {
    key: "render",
    value: function render() {
      var _this2 = this;

      return this.state.visible ? __WEBPACK_IMPORTED_MODULE_1_react_dom___default.a.createPortal(__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-upgrade-notice-container"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-upgrade-notice"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("p", null, this.props.fieldDefinition.message), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", {
        className: "wpz-upgrade-buttons"
      }, __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        onClick: function onClick() {
          return window.open(_this2.props.fieldDefinition.upgrade_url) && _this2.setState({
            visible: false
          });
        }
      }, window.wp.i18n.__('Upgrade', 'wpz-payments')), __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("button", {
        onClick: function onClick() {
          return _this2.setState({
            visible: false
          });
        }
      }, window.wp.i18n.__('Close', 'wpz-payments'))))), window.et_gb.document.body) : null;
    }
  }]);

  return WPZUpgradeNotice;
}(__WEBPACK_IMPORTED_MODULE_0_react__["Component"]);

Object.defineProperty(WPZUpgradeNotice, "slug", {
  configurable: true,
  enumerable: true,
  writable: true,
  value: 'WPZUpgradeNotice'
});
/* harmony default export */ __webpack_exports__["a"] = (WPZUpgradeNotice);

/***/ }),
/* 13 */
/*!*****************************!*\
  !*** ./includes/admin.scss ***!
  \*****************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 14 */
/*!***************************************************!*\
  !*** ./includes/modules/PaymentModule/style.scss ***!
  \***************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 15 */
/*!*************************************!*\
  !*** ./includes/backend/style.scss ***!
  \*************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);