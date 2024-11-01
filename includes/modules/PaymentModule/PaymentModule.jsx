/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/


// External Dependencies
import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export function apply_responsive(props, key, selector, css_prop_key = 'padding', important = false) {
    let additionalCss = [];
    if (!props[key]) {
        return;
    }
    let importantValue = important ? '!important' : '';
    let desktop = props[key];
    const isLastEdit = props["".concat(key + "_last_edited")];
    const statusActive = isLastEdit && isLastEdit.startsWith("on");

    switch (css_prop_key) {
        case 'padding':
        case 'margin' :

            desktop = !["padding", "margin"].includes(css_prop_key) ? props[key] : props[key].split("|");

            additionalCss.push([{
                selector,
                declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${desktop} ${importantValue};` : `${css_prop_key}-top: ${desktop[0]} ${importantValue}; ${css_prop_key}-right: ${desktop[1]} ${importantValue}; ${css_prop_key}-bottom: ${desktop[2]} ${importantValue}; ${css_prop_key}-left: ${desktop[3]} ${importantValue};`,
            }]);

            if (props["".concat(key + "_tablet")] && statusActive) {
                const tablet = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_tablet")].split("|");
                additionalCss.push([{
                    selector,
                    declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${tablet} ${importantValue};` : `${css_prop_key}-top: ${tablet[0]} ${importantValue}; ${css_prop_key}-right: ${tablet[1]} ${importantValue}; ${css_prop_key}-bottom: ${tablet[2]} ${importantValue}; ${css_prop_key}-left: ${tablet[3]} ${importantValue};`,
                    'device': 'tablet',
                }]);
            }
            if (props["".concat(key + "_phone")] && statusActive) {
                const phone = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_phone")].split("|");
                additionalCss.push([{
                    selector,
                    declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${phone} ${importantValue};` : `${css_prop_key}-top: ${phone[0]} ${importantValue}; ${css_prop_key}-right: ${phone[1]} ${importantValue}; ${css_prop_key}-bottom: ${phone[2]} ${importantValue}; ${css_prop_key}-left: ${phone[3]} ${importantValue};`,
                    'device': 'phone',
                }]);
            }
            return additionalCss;

        default:
            additionalCss.push([{
                selector,
                declaration: css_prop_key + ':' + props[key] + importantValue,
            }]);

            if (props["".concat(key + "_tablet")] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: css_prop_key + ':' + props[key + "_tablet"] + importantValue,
                    device: 'tablet'
                }]);
            }
            if (props["".concat(key + "_phone")] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: css_prop_key + ':' + props[key + "_phone"] + importantValue,
                    device: 'phone'
                }]);
            }
            return additionalCss;
    }

};

class WPZ_Payments_Divi_Module extends Component {

    static slug = 'wpz_payments_divi_module';
    containerRef;
    activeTogglePollInterval;
	wpzInstanceId;

    constructor(props) {
        super(props);
        this.containerRef = React.createRef();
		
        this.state = {
			instanceId: {},
			currentType: null,
            preview: 'default'
        };
		
		var types = this.getTypes();
		for (var type in types) {
			if (types[type]) {
				this.state.currentType = type;
				break;
			}
		}
		
		if (!window.et_gb.wp.hooks.hasFilter('wpz.payments.divi.module.processed.css.selector', 'wpzone/wpzPayments/processedCssSelector')) {
			window.et_gb.wp.hooks.addFilter(
				'wpz.payments.divi.module.processed.css.selector',
				'wpzone/wpzPayments/processedCssSelector',
				function (selector) {
					return selector.replaceAll(/[^,]*(\.wpz_payments_divi_module[^ ,]+_payments_container)/g, '$1');
				}
			);
		}
    }
	
	getLoaderIconSvg(svg) {
		var svg = svg.replaceAll(/[^a-z0-9\-_]/g, '');
		if (this.state.hasOwnProperty('loaderIconSvg_' + svg)) {
			return this.state['loaderIconSvg_' + svg];
		}
		var setIcon = (icon) => {
			var newState = {};
			newState['loaderIconSvg_' + svg] = icon;
			this.setState(newState);
		};
		setIcon(null); // try to prevent duplicate fetches during this fetch
		window.jQuery.get(
			window.WpzPaymentsBuilderData.icons_url + '/spinners/' + svg + '.svg',
			null,
			setIcon,
			'text'
		);
		return '';
	}

    componentDidMount() {
		if (this.state.currentType) {
			if (this.state.instanceId[this.state.currentType]) {
				window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
				window.wpz_payments_mount(this.state.instanceId[this.state.currentType]);
			} else {
				var newInstanceId = {};
				newInstanceId[ this.state.currentType ] = window.wpz_payments_init(this.containerRef.current);
				
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

    componentDidUpdate(oldProps, oldState) {
		
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
			} else if (
				!this.state.instanceId[this.state.currentType]
				|| (this.props.display_mode === 'modal' && this.state.preview === 'form' && (oldProps.display_mode !== 'modal' || oldState.preview !== 'form'))
				|| (oldProps.display_mode === 'modal' && oldState.preview === 'form' && (this.props.display_mode !== 'modal' || this.state.preview !== 'form'))
			) {
				var newInstanceId = {};
				newInstanceId[this.state.currentType] = window.wpz_payments_init(this.containerRef.current);
				this.setState({
					instanceId: Object.assign({}, this.state.instanceId, newInstanceId)
				});
			} else if (
					this.props.paypal_button_text !== oldProps.paypal_button_text || this.props.paypal_show_tagline !== oldProps.paypal_show_tagline
						|| this.props.paypal_button_layout !== oldProps.paypal_button_layout || this.props.paypal_button_color !== oldProps.paypal_button_color
						|| this.props.paypal_button_border_radius !== oldProps.paypal_button_border_radius || this.props.paypal_button_height !== oldProps.paypal_button_height
						|| this.props.stripe_theme !== oldProps.stripe_theme || this.props.display_mode !== oldProps.display_mode
			) {
				window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
				window.wpz_payments_mount(this.state.instanceId[this.state.currentType]);
			}
			
			window.wpz_payments_set_styles(this.state.instanceId[this.state.currentType], window.jQuery('.' + this.props.moduleInfo.orderClassName + ' > .et-fb-custom-css-output').text(), this.props.stripe_theme);
			
		}
    }

    componentWillUnmount() {
        if (this.state.instanceId[this.state.currentType]) {
            window.wpz_payments_unmount(this.state.instanceId[this.state.currentType]);
        }
        this.removeModuleSettingsHooks(this.props.moduleInfo.orderClassName);
    }

    // ds-gravity-forms-for-divi/includes/modules/GravityForms/GravityForms.jsx
    addModuleSettingsHooks(moduleOrder) {
        var _this = this, moduleSlug = WPZ_Payments_Divi_Module.slug;

        window.et_gb.wp.hooks.addAction(
            'et.builder.store.module.settings.open',
            'wpzone/m' + this.wpzInstanceId + '/moduleSettingsOpen',
            function (module) {
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

            }
        );

        window.et_gb.wp.hooks.addAction(
            'et.builder.store.module.settings.close',
            'wpzone/m' + this.wpzInstanceId + '/moduleSettingsClose',
            function (module) {
                if (module.props && module.props.type === moduleSlug) {
                    if (_this.activeTogglePollInterval) {
                        clearTimeout(_this.activeTogglePollInterval);
                        _this.activeTogglePollInterval = null;
                    }

                    _this.setState({activeToggle: null, preview: 'default'});
                }
            }
        );
    }

    removeModuleSettingsHooks(moduleOrder) {
        window.et_gb.wp.hooks.removeAction(
            'et.builder.store.module.settings.open',
            'wpzone/m' + this.wpzInstanceId + '/moduleSettingsOpen'
        );
        window.et_gb.wp.hooks.removeAction(
            'et.builder.store.module.settings.close',
            'wpzone/m' + this.wpzInstanceId + '/moduleSettingsClose'
        );
    }

    /**
     * All component inline styling.
     *
     * @since 1.0.0
     *
     * @return array
     */
    static css(props) {
        const {
            generateStyles,
        } = window.ET_Builder.API.Utils;

        const additionalCss = [];

        // -----------------------------------------------------
        // CSS
        // -----------------------------------------------------

        additionalCss.push([
            {
                selector: '%%order_class%% .wpz-payments-title, %%order_class%%_payments_container .wpz-payments-title',
                declaration: `background: ${props.title_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-description, %%order_class%%_payments_container .wpz-payments-description',
                declaration: `background: ${props.description_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-notes-instructions, %%order_class%%_payments_container .wpz-payments-notes-instructions',
                declaration: `background: ${props.notes_field_instructions_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-error, %%order_class%%_payments_container .wpz-payments-error',
                declaration: `background: ${props.notification_error_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-success, %%order_class%%_payments_container .wpz-payments-success',
                declaration: `background: ${props.notification_success_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-confirm, %%order_class%%_payments_container .wpz-payments-confirm',
                declaration: `background: ${props.confirmation_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-reload-info, %%order_class%%_payments_container .wpz-payments-reload-info',
                declaration: `background: ${props.reload_message_background};`
            },
            {
                selector: '%%order_class%%_payments_container.wpz-payments-display-modal',
                declaration: `background: ${props.modal_overlay_background};`
            },
            {
                selector: '%%order_class%% .wpz-payments-validation-error, %%order_class%%_payments_container .wpz-payments-validation-error',
                declaration: `background: ${props.fields_validation_background};`
            },
        ]);

        if (props.pay_button_fullwidth === 'on') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button, %%order_class%%_payments_container  .wpz-payments-button-wrapper button.wpz-payments-pay-button',
                    declaration: 'width: 100%;'
                },
            ]);
        }

        if (props.show_payment_button_fullwidth === 'on') {
            additionalCss.push([
                {
                    selector: '%%order_class%% button.wpz-payments-show-button',
                    declaration: 'width: 100%;'
                },
            ]);
        }

        // Fields Error
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'fields_error_text_color',
            selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'fields_error_background_color',
            selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
            cssProperty: 'background-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'fields_error_border_color',
            selector: '%%order_class%% #STRIPE .Input--invalid, %%order_class%% label.wpz-field-invalid .wpz-payments-form-field, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-form-field',
            cssProperty: 'border-color',
        }));

        // Labels
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'labels_text_color',
            selector: '%%order_class%% .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-label, %%order_class%% #STRIPE .Label',
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'labels_error_text_color',
            selector: '%%order_class%% label.wpz-field-invalid .wpz-payments-label, %%order_class%%_payments_container label.wpz-field-invalid .wpz-payments-label, %%order_class%% #STRIPE .Label--invalid',
            cssProperty: 'color',
        }));

        // Custom Price Label
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'price_label_text_color',
            selector: '%%order_class%% .wpz-payments-price .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price .wpz-payments-label',
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'price_label_error_text_color',
            selector: '%%order_class%% .wpz-payments-price label.wpz-field-invalid .wpz-payments-label, %%order_class%%_payments_container .wpz-payments-price  label.wpz-field-invalid .wpz-payments-label',
            cssProperty: 'color',
        }));

        // Checkboxes
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'checkbox_background_color',
            selector: '%%order_class%% .wpz-payments-agreement .checkbox-StyledInput, %%order_class%%_payments_container .wpz-payments-agreement .checkbox-StyledInput',
            cssProperty: 'background',
            important: true,
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'checkbox_checked_background_color',
            selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput',
            cssProperty: 'background',
            important: true,
        }));

        if (props.stripe_theme === 'none') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'checkbox_checked_color',
                selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
                cssProperty: 'color',
                important: true,
            }));
        } else {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'checkbox_checked_color',
                selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
                cssProperty: 'border-bottom-color',
            }));
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'checkbox_checked_color',
                selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ .checkbox-StyledInput:before',
                cssProperty: 'border-right-color',
            }));
        }

        // Checkbox Label
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'checkbox_list_item_color',
            selector: '%%order_class%% .wpz-payments-agreement label, %%order_class%%_payments_container .wpz-payments-agreement label',
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'checkbox_checked_list_item_color',
            selector: '%%order_class%% .wpz-payments-agreement input[type=checkbox]:checked ~ label, %%order_class%%_payments_container .wpz-payments-agreement input[type=checkbox]:checked ~ label',
            cssProperty: 'color',
        }));

        // Pay Button Icon
        if (props.pay_button_use_icon === 'on' && props.pay_button_icon) {
            const icon = window.ET_Builder.API.Utils.processFontIcon(props.pay_button_icon);
            const placement = props.pay_button_icon_placement === 'left' ? 'before' : 'after';
            additionalCss.push([{
                selector: `%%order_class%% .wpz-payments-button-wrapper button.wpz-payments-pay-button::${placement}, %%order_class%%_payments_container .wpz-payments-button-wrapper button.wpz-payments-pay-button::${placement}`,
                declaration: `content: '${icon}'!important;`
            }]);
        }

        // Confirm No Icon
        if (props.custom_confirm_no === 'on' && props.confirm_no_use_icon === 'on' && props.confirm_no_icon) {
            const icon = window.ET_Builder.API.Utils.processFontIcon(props.confirm_no_icon);
            const placement = props.confirm_no_icon_placement === 'left' ? 'before' : 'after';
            additionalCss.push([{
                selector: `%%order_class%% button.wpz-payments-confirm-no::${placement}, %%order_class%%_payments_container button.wpz-payments-confirm-no::${placement}`,
                declaration: `content: '${icon}'!important;`
            }]);
        }

        // Confirm Yes Icon
        if (props.custom_confirm_yes === 'on' && props.confirm_yes_use_icon === 'on' && props.confirm_yes_icon) {
            const icon = window.ET_Builder.API.Utils.processFontIcon(props.confirm_yes_icon);
            const placement = props.confirm_yes_icon_placement === 'left' ? 'before' : 'after';
            additionalCss.push([{
                selector: `%%order_class%% button.wpz-payments-pay-button.wpz-payments-confirm-yes::${placement}, %%order_class%%_payments_container button.wpz-payments-pay-button.wpz-payments-confirm-yes::${placement}`,
                declaration: `content: '${icon}'!important;`
            }]);
        }

        // Show Payments Button Icon
        if (props.show_payment_button_use_icon === 'on' && props.show_payment_button_icon) {
            const icon = window.ET_Builder.API.Utils.processFontIcon(props.show_payment_button_icon);
            const placement = props.show_payment_button_icon_placement === 'left' ? 'before' : 'after';
            additionalCss.push([{
                selector: `%%order_class%% button.wpz-payments-show-button::${placement}`,
                declaration: `content: '${icon}'!important;`
            }]);
        }

        // Close button
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'close_button_background',
            selector: '%%order_class%%_payments_container button.wpz-payments-close-button',
            cssProperty: 'background',
            important: true,
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'close_button_color',
            selector: '%%order_class%%_payments_container button.wpz-payments-close-button',
            cssProperty: 'color',
            important: true,
        }));

        // Preloader Icon
        let preloaderIconColor = '#2EA3F2';
        if (props.preloader_icon_color !== '') {
            preloaderIconColor = props.preloader_icon_color;
        }

        additionalCss.push([
            {
                selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_stroke',
                declaration: `stroke: ${preloaderIconColor};`
            },
            {
                selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_fill',
                declaration: `fill: ${preloaderIconColor};`
            },
        ]);

        if (props.preloader_style === 'spinning_circles') {
            additionalCss.push([
                {
                    selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_spinning_circles',
                    declaration: `stroke: ${preloaderIconColor};`
                },
                {
                    selector: '%%order_class%%_payments_container .wpz_payments_spinner.spinner_spinning_circles circle',
                    declaration: `fill: ${preloaderIconColor};`
                },
            ]);
        }

        // -----------------------------------------------------
        // Responsive CSS
        // -----------------------------------------------------

        let additionalCss_ = additionalCss;

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
	
	getTypes() {
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
    render() {
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
		
		if ( this.props.no_reload_on_success === 'on' ) {
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
		
		var handleShowButtonClick = () => {
			this.setState({preview: 'form'});
		};
		
		var handleCloseButtonClick = () => {
			this.setState({preview: 'default'});
		};
		
		var paymentsContainerContents = <>
			{this.props.display_mode === 'modal'
				&& <div className="wpz-payments-close-button-wrapper">
                        <button className="wpz-payments-close-button" aria-label="Close" onClick={handleCloseButtonClick}></button>
                    </div>}
			{
				this.state.preview === 'load_error' &&
				<div className="wpz-payments-error">
					{this.props.load_error_message}
				</div>
			}
			<h4 className="wpz-payments-title">{this.props.title}</h4>
			<div className="wpz-payments-description">
				{this.props.content()}
			</div>
			<div className="wpz-payments-price">
				<label>
					<span className="wpz-payments-label wpz-payments-price-label">
						{this.props.price_label}
					</span>
					{
						this.props.price_type === 'custom'
							? <>
							{this.state.preview === 'validation' && <p className="wpz-payments-validation-error">{window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')}</p>}
							<span className="wpz-payments-price-wrapper">
								{(window.WpzPaymentsFrontendData.currency_symbol_position === 'before' || window.WpzPaymentsFrontendData.currency_symbol_position === 'before_space') &&
									<span className={"wpz-payments-price-currency wpz-payments-price-currency-" + window.WpzPaymentsFrontendData.currency_symbol_position}>
										{window.WpzPaymentsFrontendData.currency_symbol}
									</span>
								}
								<input
									type="number"
									className="wpz-payments-price-amount wpz-payments-form-field"
									defaultValue={this.props.price_default}
									{...priceFieldValidationAttrs}
								/>
								{(window.WpzPaymentsFrontendData.currency_symbol_position === 'after' || window.WpzPaymentsFrontendData.currency_symbol_position === 'after_space') &&
									<span className={"wpz-payments-price-currency wpz-payments-price-currency-" + window.WpzPaymentsFrontendData.currency_symbol_position}>
										{window.WpzPaymentsFrontendData.currency_symbol}
									</span>
								}
							</span>
							</>
							: <span className="wpz-payments-price-amount wpz-payments-fixed-price-amount" data-value={this.props.price_default}>{window.wpz_payments_format_price(this.props.price_default)}</span>
					}
				</label>
			</div>
			{
				this.props.quantity === 'on'
				&& <div className="wpz-payments-quantity">
					{this.state.preview === 'validation' && <p className="wpz-payments-validation-error">{window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')}</p>}
					<label>
							<span className="wpz-payments-label wpz-payments-quantity-label">
								{this.props.quantity_label}
							</span>
						<input
							type="number"
							className="wpz-payments-quantity-amount wpz-payments-form-field"
							defaultValue={this.props.quantity_default}
							min={Math.max(0, this.props.minimum_quantity)}
							max={this.props.maximum_quantity ? this.props.maximum_quantity : null}
							min={this.props.quantity_step}
							data-validation-message-minimum={this.props.validation_minimum_quantity}
							data-validation-message-maximum={this.props.maximum_quantity ? this.props.validation_maximum_quantity : null}
							data-validation-message-step={this.props.validation_step_quantity}
						/>
					</label>
				</div>
			}
			
			{
				(types.paypal && types.stripe) &&
					<ul className="wpz-payments-type-options">
						<li className="wpz-payments-type-option-stripe">
							<a href="javascript:void(0)" onClick={() => this.setState({currentType: 'stripe'})}>{window.wp.i18n.__('Stripe', 'wpz-payments')}</a>
						</li>
						<li className="wpz-payments-type-option-paypal">
							<a href="javascript:void(0)" onClick={() => this.setState({currentType: 'paypal'})}>{window.wp.i18n.__('PayPal', 'wpz-payments')}</a>
						</li>
					</ul>
			}
			
			{
				this.state.preview === 'reload_info' &&
				<div className="wpz-payments-reload-info">
					{this.props.reload_info_message}
				</div>
			}
			<div className="wpz-payments-form"></div>
			{
				this.props.notes_field === 'on'
				&& <div className="wpz-payments-notes">
					<label htmlFor={this.props.moduleInfo.orderClassName + "_notes_field"} className="wpz-payments-label wpz-payments-notes-label">
						{this.props.notes_field_label}
					</label>
					<div className="wpz-payments-notes-instructions" dangerouslySetInnerHTML={{__html: this.props.notes_field_instructions}}></div>
					<textarea
						id={this.props.moduleInfo.orderClassName + "_notes_field"}
						className="wpz-payments-notes-field wpz-payments-form-field"
						required={this.props.notes_field_required === 'on'}
					/>
				</div>
			}
			{
				this.props.agreement_checkbox === 'on'
				&& <>
					{this.state.preview === 'validation' && <p className="wpz-payments-validation-error wpz-payments-agreement-validation-error">{window.wp.i18n.__('This is a sample field validation message.', 'wpz-payments')}</p>}
					<div className="wpz-payments-agreement">
						<div className="wpz-payments-agreement-checkbox-wrapper">
							<input id={this.props.moduleInfo.orderClassName + "_payment_module_agreement_checkbox"} type="checkbox" className="wpz-payments-agreement-checkbox" data-validation-message={this.props.validation_agreement}/>
							<span className="checkbox-StyledInput"/>
						</div>
						<label htmlFor={this.props.moduleInfo.orderClassName + "_payment_module_agreement_checkbox"}>
							<span className="wpz-payments-agreement-text" dangerouslySetInnerHTML={{__html: this.props.agreement_text}}/>
						</label>
					</div>
				</>
			}

			<div className="wpz-payments-button-wrapper">
				<button type="button" className="wpz-payments-pay-button et_pb_button" data-text-template={this.props.button_text} disabled={window.wpz_payments_pay_button_is_disabled(window.jQuery(this.containerRef.current))}>{window.wpz_payments_pay_button_text(window.jQuery(this.containerRef.current), this.props.button_text)}</button>
				<div className="wpz-payments-paypal-button"></div>
			</div>

			{
				this.state.preview === 'error' &&
				<div className="wpz-payments-error">
					{this.props.error_message.replaceAll(/%\{error_reason\}/g, window.wp.i18n.__('Unknown', 'wpz-payments'))}
				</div>
			}

			{
				this.state.preview === 'success' && this.props.success_action === 'message' &&
				<div className="wpz-payments-success">
					{this.props.success_message}
				</div>
			}

			{
				this.state.preview === 'confirm' &&
				<div className="wpz-payments-confirm">
					<p>{this.props.confirm_message.replaceAll(/%s/g, /* translators: amount placeholder */ window.wp.i18n.__('[amount]', 'wpz-payments'))}</p>
					<div className="wpz-payments-button-confirm-wrapper">
                        <button className="wpz-payments-confirm-yes wpz-payments-pay-button et_pb_button">{this.props.confirm_yes}</button>
                        <button className="wpz-payments-confirm-no et_pb_button wpz-payments-button-secondary">{this.props.confirm_no}</button>
                    </div>
				</div>
			}
			
			{
				this.props.show_credit === 'on'
				&&
				<>
					<small className="wpz-payments-credit wpz-payments-credit-stripe" aria-hidden={this.state.currentType !== 'stripe'} dangerouslySetInnerHTML={{
						// translators: %s are <a> tags, except for second %s which is payment processor name
						__html: window.jQuery('<div>').text(window.wp.i18n.__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments')).html()
											.replace('%s', '<a href="https://stripe.com/" target="_blank">')
											.replace('%s', window.wp.i18n.__('Stripe'))
											.replace('%s', '</a>')
											.replace('%s', '<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">')
											.replace('%s', '</a>')
					}}>
					</small>
					<small className="wpz-payments-credit wpz-payments-credit-paypal" aria-hidden={this.state.currentType !== 'paypal'} dangerouslySetInnerHTML={{
						// translators: %s are <a> tags, except for second %s which is payment processor name
						__html: window.jQuery('<div>').text(window.wp.i18n.__('Payment form powered by %s%s%s and %sSimple Payment Module for Divi%s', 'wpz-payments')).html()
											.replace('%s', '<a href="https://paypal.com/" target="_blank">')
											.replace('%s', window.wp.i18n.__('PayPal'))
											.replace('%s', '</a>')
											.replace('%s', '<a href="https://wpzone.co/product/simple-payment-module-for-divi/" target="_blank">')
											.replace('%s', '</a>')
					}}>
					</small>

				</>
			}

            <div className="wpz-payments-preloader">
				<span className="wpz-payments-preloader-icon" dangerouslySetInnerHTML={{__html: this.getLoaderIconSvg(this.props.preloader_style)}}></span>
                {
                    this.props.preloader_text_enable === 'on' &&
                    <span className="wpz-payments-preloader-text">
                        {this.props.preloader_text}
                    </span>
                }
            </div>
		</>;
		
		var ariaAttrs = {};
		if (this.props.display_mode !== 'page' && this.state.preview !== 'default') {
			ariaAttrs['aria-hidden'] = true;
		}
		
		var paymentsContainer = <div className={'wpz-payments-container wpz-payments-' + this.state.currentType + ' wpz-payments-display-' + this.props.display_mode + ' ' + this.props.moduleInfo.orderClassName + '_payments_container' + (this.props.display_mode !== 'page' && this.state.preview !== 'default' ? ' wpz-payments-active' : '') + (this.state.preview === 'preloader' ? ' wpz-payments-loading' : '')} ref={this.containerRef} {...ariaAttrs} {...dataAttrs}>
			{this.props.display_mode === 'modal'
				? <div className="wpz-payment-modal-content">{paymentsContainerContents}</div>
				: paymentsContainerContents
			}
		</div>;

        return (
			<>
				{
					this.props.display_mode !== 'page' && (this.props.display_mode === 'modal' || this.state.preview === 'default') &&
                    <div className="wpz-payments-show-button-wrapper">
                        <button className="wpz-payments-show-button et_pb_button" onClick={handleShowButtonClick}>
                            {this.props.show_button_text}
                        </button>
                    </div>
				}
				{
					this.props.display_mode === 'modal' && this.state.preview !== 'default'
						? ReactDOM.createPortal(paymentsContainer, window.document.body)
						: paymentsContainer
				}
			</>
        );
    }
}

export default WPZ_Payments_Divi_Module;