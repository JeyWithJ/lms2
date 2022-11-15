import { colord } from "colord";

const convertColorForCustomizer = (value, pickerComponent, formComponent) => {
    let rgba;
    let hsv;
    let hsva;
    let convertedValue;

    switch (pickerComponent) {
        case "HexColorPicker":
            convertedValue =
                "string" === typeof value && value.includes("#")
                    ? value
                    : colord(value).toHex();
            break;

        case "RgbColorPicker":
            convertedValue = colord(value).toRgb();
            delete convertedValue.a;
            break;

        case "RgbStringColorPicker":
            convertedValue =
                "string" === typeof value && value.includes("rgb(")
                    ? value
                    : colord(value).toRgbString();
            break;

        case "RgbaColorPicker":
            rgba = colord(value).toRgb();
            convertedValue = rgba;
            break;

        case "RgbaStringColorPicker":
            rgba = colord(value).toRgb();

            if (rgba.a < 1) {
                convertedValue =
                    "string" === typeof value && value.includes("rgba")
                        ? value
                        : colord(value).toRgbString();
            } else {
                if (!formComponent) {
                    convertedValue =
                        "string" === typeof value && value.includes("#")
                            ? value
                            : colord(value).toHex();
                } else {
                    convertedValue = colord(value).toRgbString();

                    if (convertedValue.includes("rgb") && !convertedValue.includes("rgba")) {
                        convertedValue = convertedValue.replace("rgb", "rgba");
                        convertedValue = convertedValue.replace(")", ", 1)");
                    }
                }
            }

            break;

        case "HslColorPicker":
            convertedValue = colord(value).toHsl();
            delete convertedValue.a;
            break;

        case "HslStringColorPicker":
            convertedValue =
                "string" === typeof value && value.includes("hsl(")
                    ? value
                    : colord(value).toHslString();
            break;

        case "HslaColorPicker":
            convertedValue = colord(value).toHsl();
            break;

        case "HslaStringColorPicker":
            convertedValue = colord(value).toHslString();

            if (convertedValue.includes("hsl") && !convertedValue.includes("hsla")) {
                convertedValue = convertedValue.replace("hsl", "hsla");
                convertedValue = convertedValue.replace(")", ", 1)");
            }
            break;

        case "HsvColorPicker":
            convertedValue = colord(value).toHsv();

            delete convertedValue.a;
            break;

        case "HsvStringColorPicker":
            hsv = colord(value).toHsv();
            convertedValue = "hsv(" + hsv.h + ", " + hsv.s + "%, " + hsv.v + "%)";
            break;

        case "HsvaColorPicker":
            convertedValue = colord(value).toHsv();
            break;

        case "HsvaStringColorPicker":
            hsva = colord(value).toHsv();
            convertedValue =
                "hsva(" +
                hsva.h +
                ", " +
                hsva.s +
                "%, " +
                hsva.v +
                "%, " +
                hsva.a +
                ")";
            break;

        default:
            convertedValue = "string" === typeof value && value.includes("#") ? value : colord(value).toHex();
            break;
    }

    return convertedValue;
};

export default convertColorForCustomizer;