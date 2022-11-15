import { useState, useEffect, useCallback } from "@wordpress/element";

const ColorInput = (props) => {
    const { onChange, color = "" } = props;
    const [value, setValue] = useState(() => color);

    const handleChange = useCallback(
        (e) => {
            let val = e.target.value;

            if (2 === val.length) {
                if (!val.includes("#") && !val.includes("rg") && !val.includes("hs")) {
                    val = "#" + val;
                }
            } else if (3 === val.length || 6 === val.length) {
                if (!val.includes("#") && !val.includes("rg") && !val.includes("hs")) {
                    val = "#" + val;
                }
            }

            val = val.toLowerCase();

            const pattern = new RegExp(
                /(?:#|0x)(?:[a-f0-9]{3}|[a-f0-9]{6}|[a-f0-9]{8})\b|(?:rgb|hsl)a?\([^\)]*\)/
            );

            if ("" === val || pattern.test(val)) {
                onChange(val);
            }

            setValue(val);
        },
        [onChange]
    );

    useEffect(() => {
        setValue(color);
    }, [color]);

    const pickersWithAlpha = [
        "RgbaColorPicker",
        "RgbaStringColorPicker",
        "HslaColorPicker",
        "HslaStringColorPicker",
        "HsvaColorPicker",
        "HsvaStringColorPicker",
    ];

    return (
        <div className="thim-color-input-wrapper">
            <div className="thim-color-input-control">
                <input
                    type="text"
                    value={value}
                    className="thim-color-input"
                    spellCheck="false"
                    onChange={handleChange}
                />
            </div>
        </div >
    );
};

export default ColorInput;