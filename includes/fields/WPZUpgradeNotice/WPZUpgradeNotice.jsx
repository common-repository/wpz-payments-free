import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import './style.scss';

class WPZUpgradeNotice extends Component {
	static slug = 'WPZUpgradeNotice';
	
	constructor(props) {
		super(props);
		this.state = {};
	}
	
	componentDidMount() {
		this.checkProps();
	}
	
	componentDidUpdate(oldProps) {
		this.checkProps(oldProps.moduleSettings);
	}
	
	checkProps(oldSettings) {
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
			this.setState({visible: true});
		}
	}
	
	resetSetting(setting, oldSettings) {
		if (oldSettings && oldSettings[setting]) {
			var resetValue = oldSettings[setting];
		} else if (window.ETBuilderBackend.componentDefinitions.generalFields[this.props.fieldDefinition.module_slug].hasOwnProperty(setting)) {
			var resetValue = window.ETBuilderBackend.componentDefinitions.generalFields[this.props.fieldDefinition.module_slug][setting];
		} else {
			var resetValue = '';
		}
		
		this.props._onChange(setting, resetValue);
	}
	
	render() {
		return this.state.visible
			? ReactDOM.createPortal(
				<div className="wpz-upgrade-notice-container">
					<div className="wpz-upgrade-notice">
						<p>{this.props.fieldDefinition.message}</p>
						<div className="wpz-upgrade-buttons">
							<button onClick={() => window.open(this.props.fieldDefinition.upgrade_url) && this.setState({visible: false})}>{window.wp.i18n.__('Upgrade', 'wpz-payments')}</button>
							<button onClick={() => this.setState({visible: false})}>{window.wp.i18n.__('Close', 'wpz-payments')}</button>
						</div>
					</div>
				</div>,
				window.et_gb.document.body
			)
			: null;
	}
	
}

export default WPZUpgradeNotice;