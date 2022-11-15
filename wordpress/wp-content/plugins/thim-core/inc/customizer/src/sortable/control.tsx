const SortableControl = wp.customize.Control.extend({

    ready: function () {
        var control = this;

        jQuery(control.container.find('ul.sortable').first()).sortable({
            axis: "y",
            update: function () {
                control.setting.set(control.getNewVal());
            }
        }).disableSelection().find('li').each(function () {
            jQuery(this).find('i.visibility').click(function () {
                jQuery(this).toggleClass('dashicons-visibility-faint').parents('li:eq(0)').toggleClass('invisible');
            });
        }).on('click', function () {
            control.setting.set(control.getNewVal());
        });
    },

    getNewVal: function () {
        var items = jQuery(this.container.find('li'));

        const newVal = [];

        items.each(function (item) {
            if (!jQuery(item).hasClass('invisible')) {
                newVal.push(jQuery(this).data('value'));
            }
        });

        return newVal;
    }
});

export default SortableControl;
