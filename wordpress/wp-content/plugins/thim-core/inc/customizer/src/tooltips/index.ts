function thimTooltipAdd(control) {
    Object.entries(thimCustomizerTooltips).forEach(function ([key, tooltip]) {
        if (tooltip.id !== control.id) {
            return;
        }

        if (control.container.find('.tooltip-content').length) {
            return;
        }

        const target = document.querySelector('#customize-control-' + tooltip.id + ' .customize-control-title');

        if (!target) return;

        target.classList.add('thim-tooltip-wrapper');

        // Build the tooltip trigger.
        const trigger = '<span class="tooltip-trigger"><span class="dashicons dashicons-editor-help"></span></span>';

        // Build the tooltip content.
        const content = '<span class="tooltip-content">' + tooltip.content + '</span>';

        const $target = jQuery(target);

        // Append the trigger & content next to the control's title.
        jQuery(trigger).appendTo($target);
        jQuery(content).appendTo($target);
    });
}

export default function ThimTooltips() {
    let sectionNames = [];

    wp.customize.control.each(function (control) {
        if (!sectionNames.includes(control.section())) {
            sectionNames.push(control.section());
        }

        wp.customize.section(control.section(), function (section) {
            if (section.expanded() || wp.customize.settings.autofocus.control === control.id) {
                thimTooltipAdd(control);
            } else {
                section.expanded.bind(function (expanded) {
                    if (expanded) {
                        thimTooltipAdd(control);
                    }
                });
            }
        });
    });

    jQuery('head').append(
        jQuery('<style class="thim-tooltip-inline-styles"></style>')
    );

    const $tooltipStyleEl = jQuery('.thim-tooltip-inline-styles');
    const $sidebarOverlay = jQuery('.wp-full-overlay-sidebar-content');

    sectionNames.forEach(function (sectionName) {
        wp.customize.section(sectionName, function (section) {
            section.expanded.bind(function (expanded) {
                if (expanded) {
                    if (section.contentContainer[0].scrollHeight > $sidebarOverlay.height()) {
                        $tooltipStyleEl.html('.thim-tooltip-wrapper span.tooltip-content {min-width: 258px;}');
                    } else {
                        $tooltipStyleEl.empty();
                    }
                }
            });
        });
    });
}