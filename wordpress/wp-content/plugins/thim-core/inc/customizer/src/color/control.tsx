
import ColorComponent from "./component";
import { render, unmountComponentAtNode } from '@wordpress/element';

const ColorControl = wp.customize.Control.extend({

    initialize: function (id, params) {
        const control = this;

        control.setNotificationContainer = control.setNotificationContainer.bind(control);

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
        const useHueMode = "hue" === control.params.mode;
        const choices = control.params.choices;

        let pickerComponent;

        if (choices.formComponent) {
            pickerComponent = choices.formComponent;
        } else {
            pickerComponent = choices.alpha
                ? "RgbaStringColorPicker"
                : "HexColorPicker";
        }

        pickerComponent = useHueMode ? "HueColorPicker" : pickerComponent;

        const form = (
            <ColorComponent
                {...control.params}
                control={control}
                customizerSetting={control.setting}
                useHueMode={useHueMode}
                pickerComponent={pickerComponent}
                value={control.params.value}
                setNotificationContainer={control.setNotificationContainer}
            />
        );

        render(form, control.container[0]);
    },

    ready: function ready() {
        const control = this;

        control.setting.bind((val) => {
            control.updateComponentState(val);
        });
    },

    updateComponentState: () => { },

    destroy: function destroy() {
        const control = this;

        unmountComponentAtNode(control.container[0]);

        if (wp.customize.Control.prototype.destroy) {
            wp.customize.Control.prototype.destroy.call(control);
        }
    },
});

export default ColorControl;