import { applyFilters } from '@wordpress/hooks';

const thimPostMessage = {

    fields: {},

    styleTag: {

        add: function (id) {
            id = id.replace(/[^\w\s]/gi, '-');
            if (null === document.getElementById('thim-postmessage-' + id) || 'undefined' === typeof document.getElementById('thim-postmessage-' + id)) {
                jQuery('head').append('<style id="thim-customizer-postmessage-' + id + '"></style>');
            }
        },

        addData: function (id, styles) {
            id = id.replace('[', '-').replace(']', '');
            thimPostMessage.styleTag.add(id);
            jQuery('#thim-customizer-postmessage-' + id).text(styles);
        }
    },

    util: {

        processValue: function (output, value) {
            var self = this,
                settings = window.parent.wp.customize.get(),
                excluded = false;

            if ('object' === typeof value) {
                _.each(value, function (subValue, key) {
                    value[key] = self.processValue(output, subValue);
                });
                return value;
            }
            output = _.defaults(output, {
                prefix: '',
                units: '',
                suffix: '',
                value_pattern: '$',
                pattern_replace: {},
                exclude: []
            });

            if (1 <= output.exclude.length) {
                _.each(output.exclude, function (exclusion) {
                    if (value == exclusion) {
                        excluded = true;
                    }
                });
            }

            if (excluded) {
                return false;
            }

            value = output.value_pattern.replace(new RegExp('\\$', 'g'), value);
            _.each(output.pattern_replace, function (id, placeholder) {
                if (!_.isUndefined(settings[id])) {
                    value = value.replace(placeholder, settings[id]);
                }
            });
            return output.prefix + value + output.units + output.suffix;
        },

        backgroundImageValue: function (url) {
            return (-1 === url.indexOf('url(')) ? 'url(' + url + ')' : url;
        }
    },

    css: {

        fromOutput: function (output, value, controlType) {
            var styles = '',
                mediaQuery = false,
                processedValue;

            try {
                value = JSON.parse(value);
            } catch (e) { }

            if (output.js_callback && 'function' === typeof window[output.js_callback]) {
                value = window[output.js_callback[0]](value, output.js_callback[1]);
            }

            styles = applyFilters('thimCustomizerPostMessageStylesOutput', styles, value, output, controlType);

            if ('' === styles) {
                switch (controlType) {
                    case 'thim-multicolor':
                    case 'thim-sortable':
                        styles += output.element + '{';
                        _.each(value, function (val, key) {
                            if (output.choice && key !== output.choice) {
                                return;
                            }

                            processedValue = thimPostMessage.util.processValue(output, val);

                            if ('' === processedValue) {
                                if ('background-color' === output.property) {
                                    processedValue = 'unset';
                                } else if ('background-image' === output.property) {
                                    processedValue = 'none';
                                }
                            }

                            var customProperty = controlType === 'thim-sortable' ? output.property + '-' + key : output.property;

                            if (false !== processedValue) {
                                styles += output.property ? customProperty + ":" + processedValue + ";" : key + ":" + processedValue + ";";
                            }
                        });
                        styles += '}';
                        break;
                    default:
                        if ('thim-image' === controlType) {
                            value = (!_.isUndefined(value.url)) ? thimPostMessage.util.backgroundImageValue(value.url) : thimPostMessage.util.backgroundImageValue(value);
                        }
                        if (_.isObject(value)) {
                            styles += output.element + '{';
                            _.each(value, function (val, key) {
                                var property;
                                if (output.choice && key !== output.choice) {
                                    return;
                                }
                                processedValue = thimPostMessage.util.processValue(output, val);
                                property = output.property ? output.property : key;

                                if ('' === processedValue) {
                                    if ('background-color' === property) {
                                        processedValue = 'unset';
                                    } else if ('background-image' === property) {
                                        processedValue = 'none';
                                    }
                                }

                                if (false !== processedValue) {
                                    styles += property + ':' + processedValue + ';';
                                }
                            });
                            styles += '}';
                        } else {
                            processedValue = thimPostMessage.util.processValue(output, value);
                            if ('' === processedValue) {
                                if ('background-color' === output.property) {
                                    processedValue = 'unset';
                                } else if ('background-image' === output.property) {
                                    processedValue = 'none';
                                }
                            }

                            if (false !== processedValue) {
                                styles += output.element + '{' + output.property + ':' + processedValue + ';}';
                            }
                        }
                        break;
                }
            }

            if (output.media_query && 'string' === typeof output.media_query && !_.isEmpty(output.media_query)) {
                mediaQuery = output.media_query;

                if (-1 === mediaQuery.indexOf('@media')) {
                    mediaQuery = '@media ' + mediaQuery;
                }
            }

            if (mediaQuery) {
                return mediaQuery + '{' + styles + '}';
            }

            return styles;
        }
    },

    html: {
        fromOutput: function (output, value) {
            if (output.js_callback && 'function' === typeof window[output.js_callback]) {
                value = window[output.js_callback[0]](value, output.js_callback[1]);
            }

            if (_.isObject(value) || _.isArray(value)) {
                if (!output.choice) {
                    return;
                }
                _.each(value, function (val, key) {
                    if (output.choice && key !== output.choice) {
                        return;
                    }
                    value = val;
                });
            }
            value = thimPostMessage.util.processValue(output, value);

            if (output.attr) {
                jQuery(output.element).attr(output.attr, value);
            } else {
                jQuery(output.element).html(value);
            }
        }
    },

    toggleClass: {
        fromOutput: function (output, value) {
            if ('undefined' === typeof output.class || 'undefined' === typeof output.value) {
                return;
            }

            if (value === output.value && !jQuery(output.element).hasClass(output.class)) {
                jQuery(output.element).addClass(output.class);
            } else {
                jQuery(output.element).removeClass(output.class);
            }
        }
    }
};

export default function ThimPostMessageOutput() {
    let styles: string = '';

    _.each(thimPostMessageFields, function (field) {
        var fieldSetting = field.id;

        if ("option" === field.option_type && field.option_name && 0 !== fieldSetting.indexOf(field.option_name + '[')) {
            fieldSetting = field.option_name + "[" + fieldSetting + "]";
        }

        wp.customize(fieldSetting, function (value) {
            value.bind(function (newVal) {
                styles = '';
                _.each(field.js_vars, function (output) {
                    output.function = (!output.function || 'undefined' === typeof thimPostMessage[output.function]) ? 'css' : output.function;
                    field.type = (field.choices && field.choices.parent_type) ? field.choices.parent_type : field.type;

                    if ('css' === output.function) {
                        styles += thimPostMessage.css.fromOutput(output, newVal, field.type);
                    } else {
                        thimPostMessage[output.function].fromOutput(output, newVal, field.type);
                    }
                });

                thimPostMessage.styleTag.addData(fieldSetting, styles);
            });
        });
    });
};
