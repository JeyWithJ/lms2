import { addAction } from '@wordpress/hooks';

export default function TypographyControl(id, value) {
    const control = wp.customize.control(id);

    if ("undefined" === typeof control) {
        return;
    }

    value = value || control.setting.get();

    const isGoogle = value["font-family"] && thimGoogleFonts.items[value["font-family"]];
    const variantValue = value["variant"] ? value["variant"].toString() : "regular";
    const fontFamilyVariantValue = value["family-variant"] ? value["family-variant"] : ["regular"];
    const fontFamilyVariantControl = wp.customize.control(id + "[family-variant]");
    const variantControl = wp.customize.control(id + "[variant]");

    const sortVariants = function (a, b) {
        if (a < b) return -1;
        if (a > b) return 1;
        return 0;
    };

    let variants = [];

    if (isGoogle) {
        let gFontVariants = thimGoogleFonts.items[value["font-family"]].variants;
        gFontVariants.sort(sortVariants);

        thimFontVariants.complete.forEach(function (variant) {
            if (-1 !== gFontVariants.indexOf(variant.value)) {
                variants.push({
                    value: variant.value,
                    label: variant.label,
                });
            }
        });
    } else {
        let customVariantKey = id.replace(/]/g, '');
        customVariantKey = customVariantKey.replace(/\[/g, '_');

        if (thimCustomVariants[customVariantKey][value["font-family"]]) {
            variants = thimCustomVariants[customVariantKey][value["font-family"]];
        } else {
            variants = thimFontVariants.standard;
        }
    }

    // Set the font-style value.
    if (-1 !== variantValue.indexOf("i")) {
        value["font-style"] = "italic";
    } else {
        value["font-style"] = "normal";
    }

    // Set the font-weight value.
    value["font-weight"] = "regular" === variantValue || "italic" === variantValue ? 400 : parseInt(variantValue, 10);

    if (variantControl) {
        // Hide/show variant options depending on which are available for this font-family.
        if (1 < variants.length && control.active()) {
            variantControl.activate();
        } else {
            // If there's only 1 variant to choose from, we can hide the control.
            variantControl.deactivate();
        }

        variantControl.params.choices = variants;
        variantControl.formattedOptions = [];
        variantControl.destroy();

        if (!variants.includes(variantValue)) {
            // If the selected font-family doesn't support the currently selected variant, switch to "regular".
            variantControl.doSelectAction("selectOption", "regular");
        } else {
            variantControl.doSelectAction("selectOption", variantValue);
        }
    }

    if (fontFamilyVariantControl) {
        // Hide/show variant options depending on which are available for this font-family.
        if (1 < variants.length && control.active()) {
            fontFamilyVariantControl.activate();
        } else {
            // If there's only 1 variant to choose from, we can hide the control.
            fontFamilyVariantControl.deactivate();
        }

        fontFamilyVariantControl.params.choices = variants;
        fontFamilyVariantControl.formattedOptions = [];

        if (!variants.includes(fontFamilyVariantValue)) {
            // If the selected font-family doesn't support the currently selected variant, switch to "regular".
            fontFamilyVariantControl.doSelectAction("selectOption", ["regular"]);
        } else {
            fontFamilyVariantControl.doSelectAction("selectOption", fontFamilyVariantValue);
        }
    }

    addAction(
        "thim.dynamicControl.initThimControl",
        "thim",
        function (controlInit) {
            if (variantControl && id + "[variant]" === controlInit.id) {
            }
        }
    );
}
