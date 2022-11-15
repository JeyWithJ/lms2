import './app.scss';
import SliderControl from './slider/control';
import ColorControl from './color/control';
import DimensionControl from './dimension/control';
import DynamicControl from './base/control';
import SortableControl from './sortable/control';
import SelectControl from './select/control';
import TypographyControl from './typography/control';
import ThimDependencies from './dependencies';
import ImageControl from './image/control';
import SwitchControl from './switch/control';
import ThimTooltips from './tooltips';

const { controlConstructor } = wp.customize;

controlConstructor['thim-slider'] = SliderControl;
controlConstructor['thim-color'] = ColorControl;
controlConstructor['thim-dimension'] = DimensionControl;
controlConstructor['thim-radio'] = DynamicControl.extend({});
controlConstructor['thim-radio-buttonset'] = DynamicControl.extend({});
controlConstructor['thim-image'] = DynamicControl.extend({ initThimControl: ImageControl });
controlConstructor['thim-switch'] = DynamicControl.extend({ initThimControl: SwitchControl });
controlConstructor['thim-toggle'] = DynamicControl.extend({ initThimControl: SwitchControl });
controlConstructor['thim-sortable'] = SortableControl;
controlConstructor['thim-select'] = SelectControl;


// TypographyControl.
jQuery(document).ready(function () {
    _.each(thimTypographyControls, function (id) {
        TypographyControl(id);

        wp.customize(id, function (value) {
            value.bind(function (newval) {
                TypographyControl(id, newval);
            });
        });
    });

    ThimDependencies();
    ThimTooltips();
});
