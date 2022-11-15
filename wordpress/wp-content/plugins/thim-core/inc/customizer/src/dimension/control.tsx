import DynamicControl from '../base/control';

const DimensionControl = DynamicControl.extend({

    initThimControl: function (control) {
        var value;
        control = control || this;

        control.thimNotifications();

        control.container.on('change keyup paste', 'input', function () {
            value = jQuery(this).val();
            control.setting.set(value);
        });
    },

    thimNotifications: function () {
        var control = this,
            acceptUnitless = ('undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.accept_unitless && true === control.params.choices.accept_unitless);

        wp.customize(control.id, function (setting) {
            setting.bind(function (value) {
                var code = 'long_title';

                if (false === control.validateCssValue(value) && (!acceptUnitless || isNaN(value))) {
                    setting.notifications.add(code, new wp.customize.Notification(code, {
                        type: 'warning',
                        message: 'Invalid value'
                    }));
                } else {
                    setting.notifications.remove(code);
                }
            });
        });
    },

    validateCssValue: function (value) {

        var control = this,
            validUnits = ['fr', 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'],
            numericValue,
            unit,
            multiples,
            multiplesValid = true;

        if (!value || '' === value || 0 === value || '0' === value || 'auto' === value || 'inherit' === value || 'initial' === value) {
            return true;
        }

        if (0 <= value.indexOf('calc(') && 0 <= value.indexOf(')')) {
            return true;
        }

        numericValue = parseFloat(value);

        unit = value.replace(numericValue, '');

        if (!unit) {
            return true;
        }

        multiples = value.split(' ');
        if (2 <= multiples.length) {
            multiples.forEach(function (item) {
                if (item && !control.validateCssValue(item)) {
                    multiplesValid = false;
                }
            });

            return multiplesValid;
        }

        return (!isNaN(numericValue) && -1 !== validUnits.indexOf(unit));
    }
});

export default DimensionControl;