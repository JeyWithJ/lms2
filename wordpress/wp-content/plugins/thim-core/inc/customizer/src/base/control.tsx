import { doAction } from '@wordpress/hooks';

const DynamicControl = wp.customize.Control.extend({
	initialize: function (id, options) {
		let control = this;
		let args = options || {};

		args.params = args.params || {};

		if (!args.params.type) {
			args.params.type = 'thim-generic';
		}

		let className;

		if (args.content) {
			let splits = args.content.split('class="');
			splits = splits[1].split('"');
			className = splits[0];
		} else {
			className = 'customize-control customize-control-' + args.params.type;
		}

		if (!args.params.wrapper_attrs && args.params.wrapper_atts) {
			args.params.wrapper_attrs = args.params.wrapper_atts;
		}

		// Hijack the container to add wrapper_attrs.
		args.params.content = jQuery("<li></li>");
		args.params.content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'));
		args.params.content.attr('class', className);

		_.each(args.params.wrapper_attrs, function (val, key) {
			if ('class' === key) {
				val = val.replace('{default_class}', className);
			}

			args.params.content.attr(key, val);
		});

		control.propertyElements = [];
		wp.customize.Control.prototype.initialize.call(control, id, args);
		doAction('thim.dynamicControl.init.after', id, control, args);
	},

	_setUpSettingRootLinks: function () {
		var control = this,
			nodes = control.container.find('[data-customize-setting-link]');

		nodes.each(function () {
			var node = jQuery(this);

			wp.customize(node.data('customizeSettingLink'), function (setting) {
				var element = new wp.customize.Element(node);
				control.elements.push(element);
				element.sync(setting);
				element.set(setting());
			});
		});
	},

	_setUpSettingPropertyLinks: function () {
		var control = this,
			nodes;

		if (!control.setting) {
			return;
		}

		nodes = control.container.find('[data-customize-setting-property-link]');

		nodes.each(function () {
			var node = jQuery(this),
				element,
				propertyName = node.data('customizeSettingPropertyLink');

			element = new wp.customize.Element(node);
			control.propertyElements.push(element);
			element.set(control.setting()[propertyName]);

			element.bind(function (newPropertyValue) {
				var newSetting = control.setting();
				if (newPropertyValue === newSetting[propertyName]) {
					return;
				}
				newSetting = _.clone(newSetting);
				newSetting[propertyName] = newPropertyValue;
				control.setting.set(newSetting);
			});
			control.setting.bind(function (newValue) {
				if (newValue[propertyName] !== element.get()) {
					element.set(newValue[propertyName]);
				}
			});
		});
	},

	ready: function () {
		var control = this;

		control._setUpSettingRootLinks();
		control._setUpSettingPropertyLinks();

		wp.customize.Control.prototype.ready.call(control);

		control.deferred.embedded.done(function () {
			control.initThimControl();
			doAction('thim.dynamicControl.ready.deferred.embedded.done', control);
		});

		doAction('thim.dynamicControl.ready.after', control);
	},

	embed: function () {
		var control = this,
			sectionId = control.section();

		if (!sectionId) {
			return;
		}

		wp.customize.section(sectionId, function (section) {
			if ('thim-expanded' === section.params.type || section.expanded() || wp.customize.settings.autofocus.control === control.id) {
				control.actuallyEmbed();
			} else {
				section.expanded.bind(function (expanded) {
					if (expanded) {
						control.actuallyEmbed();
					}
				});
			}
		});

		doAction('thim.dynamicControl.embed.after', control);
	},

	actuallyEmbed: function () {
		var control = this;

		if ('resolved' === control.deferred.embedded.state()) {
			return;
		}

		control.renderContent();
		control.deferred.embedded.resolve();
		doAction('thim.dynamicControl.actuallyEmbed.after', control);
	},


	focus: function (args) {
		var control = this;
		control.actuallyEmbed();
		wp.customize.Control.prototype.focus.call(control, args);
		doAction('thim.dynamicControl.focus.after', control);
	},

	initThimControl: function (control) {
		control = control || this;
		doAction('thim.dynamicControl.initThimControl', this);

		// Save the value
		control.container.on('change keyup paste click', 'input', function () {
			control.setting.set(jQuery(this).val());
		});
	}
});

export default DynamicControl;

(function (api) {

	api.Value.prototype.set = function (to) {
		var from = this._value,
			parentSetting,
			newVal;

		to = this._setter.apply(this, arguments);
		to = this.validate(to);

		if (null === to || _.isEqual(from, to)) {
			return this;
		}

		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			newVal = {};
			newVal[this.id.replace(parentSetting + '[', '').replace(']', '')] = to;
			api.control(parentSetting).setting.set(jQuery.extend({}, api.control(parentSetting).setting._value, newVal));
		}

		this._value = to;
		this._dirty = true;

		this.callbacks.fireWith(this, [to, from]);

		return this;
	};

	api.Value.prototype.get = function () {
		var parentSetting;

		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			return api.control(parentSetting).setting.get()[this.id.replace(parentSetting + '[', '').replace(']', '')];
		}

		return this._value;
	};
}(wp.customize));
