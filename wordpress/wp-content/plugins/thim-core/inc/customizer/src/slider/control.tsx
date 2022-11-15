import SliderComponent from './component';
import { render, unmountComponentAtNode } from '@wordpress/element';

const SliderControl = wp.customize.Control.extend({

    initialize: function (id, params) {
        const control = this;

        control.setNotificationContainer = control.setNotificationContainer.bind(control);

        wp.customize.Control.prototype.initialize.call(control, id, params);

        function onRemoved(removedControl) {
            if (control === removedControl) {
                control.destroy();
                control.container.remove();
                wp.customize.control.unbind('removed', onRemoved);
            }
        }
        wp.customize.control.bind('removed', onRemoved);
    },

    setNotificationContainer: function setNotificationContainer(element) {
        const control = this;

        control.notifications.container = jQuery(element);
        control.notifications.render();
    },


    renderContent: function renderContent() {
        const control = this;

        render(
            <SliderComponent
                {...control.params}
                control={control}
                customizerSetting={control.setting}
                setNotificationContainer={control.setNotificationCotainer}
                value={control.params.value}
            />,
            control.container[0]
        );

        if (false !== control.params.choices.allowCollapse) {
            control.container.addClass('allowCollapse');
        }
    },


    ready: function ready() {
        const control = this;

        control.setting.bind((val) => {
            control.updateComponentState(val);
        });
    },

    updateComponentState: (val) => { },


    destroy: function destroy() {
        const control = this;

        unmountComponentAtNode(control.container[0]);

        if (wp.customize.Control.prototype.destroy) {
            wp.customize.Control.prototype.destroy.call(control);
        }
    }
});

export default SliderControl;
