/* global wp, jQuery, React, ReactDOM, _ */
import SelectComponent from "./component";
import { render, unmountComponentAtNode } from '@wordpress/element';

const SelectControl = wp.customize.Control.extend({

    initialize: function (id, params) {
        const control = this;

        control.setNotificationContainer =
            control.setNotificationContainer.bind(control);

        wp.customize.Control.prototype.initialize.call(control, id, params);

        function onRemoved(removedControl) {
            if (control === removedControl) {
                control.destroy();
                control.container.remove();
                wp.customize.control.unbind("removed", onRemoved);
            }
        }
        wp.customize.control.bind("removed", onRemoved);
    },

    setNotificationContainer: function setNotificationContainer(element) {
        const control = this;
        control.notifications.container = jQuery(element);
        control.notifications.render();
    },

    renderContent: function renderContent() {
        const control = this;
        let value = control.setting.get();

        const form = (
            <SelectComponent
                {...control.params}
                value={value}
                setNotificationContainer={control.setNotificationContainer}
                isClearable={control.params.isClearable}
                customizerSetting={control.setting}
                isOptionDisabled={control.isOptionDisabled}
                control={control}
                isMulti={control.isMulti()}
                maxSelectionNumber={control.params.maxSelectionNumber}
            />
        );

        render(form, control.container[0]);
    },

    ready: function ready() {
        const control = this;

        // Re-render control when setting changes.
        control.setting.bind(() => {
            control.renderContent();
        });
    },

    isMulti: function () {
        return this.params.isMulti;
    },

    destroy: function destroy() {
        const control = this;

        unmountComponentAtNode(control.container[0]);

        if (wp.customize.Control.prototype.destroy) {
            wp.customize.Control.prototype.destroy.call(control);
        }
    },

    isOptionDisabled: function (option) {
        const control = this;

        if (!control) return false;
        if (!control.disabledSelectOptions) return false;
        if (control.disabledSelectOptions.indexOf(option)) return true;

        return false;
    },

    doSelectAction: function (action, arg) {
        const control = this;
        let i;

        switch (action) {
            case "disableOption":
                control.disabledSelectOptions =
                    "undefined" === typeof control.disabledSelectOptions
                        ? []
                        : control.disabledSelectOptions;
                control.disabledSelectOptions.push(control.getOptionProps(arg));
                break;

            case "enableOption":
                if (control.disabledSelectOptions) {
                    for (i = 0; i < control.disabledSelectOptions.length; i++) {
                        if (control.disabledSelectOptions[i].value === arg) {
                            control.disabledSelectOptions.splice(i, 1);
                        }
                    }
                }
                break;

            case "selectOption":
                control.value = arg;
                break;
        }

        control.renderContent();
    },

    formatOptions: function () {
        var self = this;
        this.formattedOptions = [];

        if (Array.isArray(this.params.choices)) {
            this.formattedOptions = this.params.choices;
            return;
        }

        _.each(self.params.choices, function (label, value) {
            var optGroup;

            if ("object" === typeof label) {
                optGroup = {
                    label: label[0],
                    options: [],
                };

                _.each(label[1], function (optionVal, optionKey) {
                    optGroup.options.push({
                        label: optionVal,
                        value: optionKey,
                    });
                });

                self.formattedOptions.push(optGroup);
            } else if ("string" === typeof label) {
                self.formattedOptions.push({
                    label: label,
                    value: value,
                });
            }
        });
    },

    getFormattedOptions: function () {
        if (!this.formattedOptions || !this.formattedOptions.length) {
            this.formatOptions();
        }
        return this.formattedOptions;
    },

    getOptionProps: function (value) {
        const control = this;

        var options = this.getFormattedOptions(),
            i,
            l;

        if (control.isMulti()) {
            let values = [];

            for (i = 0; i < options.length; i++) {
                if (Array.isArray(value)) {
                    const valueArray = value;

                    valueArray.forEach(function (val) {
                        if (options[i].value === val) {
                            values.push(options[i]);
                            return;
                        }

                        if (options[i].options) {
                            for (l = 0; l < options[i].options.length; l++) {
                                if (options[i].options[l].value === val) {
                                    values.push(options[i].options[l]);
                                }
                            }
                        }
                    });
                } else {
                    if (options[i].value === value) {
                        values.push(options[i]);
                    }

                    if (options[i].options) {
                        for (l = 0; l < options[i].options.length; l++) {
                            if (options[i].options[l].value === value) {
                                values.push(options[i].options[l]);
                            }
                        }
                    }
                }
            }

            return values;
        } else {
            for (i = 0; i < options.length; i++) {
                if (options[i].value === value) {
                    return options[i];
                }

                if (options[i].options) {
                    for (l = 0; l < options[i].options.length; l++) {
                        if (options[i].options[l].value === value) {
                            return options[i].options[l];
                        }
                    }
                }
            }
        }
    },
});

export default SelectControl;
