import { useState, useEffect } from "@wordpress/element";

const ColorCircle = (props) => {
    const { color = "" } = props;
    const [value, setValue] = useState(() => color);

    useEffect(() => {
        setValue(color);
    }, [color]);

    return (
        <div className="thim-trigger-circle-wrapper">
            <button
                type="button"
                className="thim-trigger-circle"
                onClick={props.togglePickerHandler}
                style={{
                    backgroundImage:
                        'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==")'
                }}
            >
                <div className="thim-color-preview" style={{ backgroundColor: value ? value : "transparent" }}></div>
            </button>
        </div>
    );
};

export default ColorCircle;