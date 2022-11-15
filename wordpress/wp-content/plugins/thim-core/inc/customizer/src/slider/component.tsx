import { useRef, useEffect } from "@wordpress/element";

const SliderComponent = (props) => {
    const { control, customizerSetting, choices } = props;

    const sliderRef = useRef(null);
    const valueRef = useRef(null);

    useEffect(() => {
        if (sliderRef.current) {
            const min = choices.min
            const max = choices.max
            const val = sliderRef.current?.value || props.default

            sliderRef.current.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
        }
    }, [sliderRef]);

    let trigger = "";

    control.updateComponentState = (val) => {
        if (sliderRef.current && valueRef.current) {
            if ("slider" === trigger) {
                valueRef.current.textContent = val;
            } else if ("input" === trigger) {
                sliderRef.current.value = val;
            } else if ("reset" === trigger) {
                valueRef.current.textContent = val;
                sliderRef.current.value = val;
            }
        }
    };

    const handleChange = (e) => {
        trigger = "range" === e.target.type ? "slider" : "input";

        let value = e.target.value;

        if (value < choices.min) value = choices.min;

        if (value > choices.max) value = choices.max;

        if ("input" === trigger) e.target.value = value;

        customizerSetting.set(value);

        const min = e.target.min
        const max = e.target.max
        const val = e.target.value

        e.target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
    };

    const handleReset = (e) => {
        if ("" !== props.default && "undefined" !== typeof props.default) {
            sliderRef.current.value = props.default;
            valueRef.current.textContent = props.default;
        } else {
            if ("" !== props.value) {
                sliderRef.current.value = props.value;
                valueRef.current.textContent = props.value;
            } else {
                sliderRef.current.value = choices.min;
                valueRef.current.textContent = "";
            }
        }

        trigger = "reset";

        customizerSetting.set(sliderRef.current.value);

        const min = choices.min
        const max = choices.max
        const val = props.default

        sliderRef.current.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
    };

    // Preparing for the template.
    const fieldId = `thim-control-input-${customizerSetting.id}`;
    const value = "" !== props.value ? props.value : 0;

    return (
        <div className="thim-control-form" tabIndex="1">
            <label className="thim-control-label" htmlFor={fieldId}>
                <span className="customize-control-title">{props.label}</span>
                <span
                    className="customize-control-description description"
                    dangerouslySetInnerHTML={{ __html: props.description }}
                />
            </label>

            <div
                className="customize-control-notifications-container"
                ref={props.setNotificationContainer}
            ></div>

            <button
                type="button"
                className="thim-control-reset"
                onClick={handleReset}
            >
                <i className="dashicons dashicons-image-rotate"></i>
            </button>

            <div className="thim-control-cols">
                <div className="thim-control-left-col">
                    <input
                        ref={sliderRef}
                        type="range"
                        id={fieldId}
                        defaultValue={value}
                        min={choices.min}
                        max={choices.max}
                        step={choices.step}
                        className="thim-control-slider"
                        onChange={handleChange}
                    />
                </div>
                <div className="thim-control-right-col">
                    <div className="thim-control-value" ref={valueRef}>
                        {value}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default SliderComponent;
