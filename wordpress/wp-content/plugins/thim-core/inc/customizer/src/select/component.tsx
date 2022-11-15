import Select from "react-select";
import { components } from "react-select";

const SelectMenu = (props) => {
    const { selectProps } = props;
    const optionSelectedLength = props.getValue().length || 0;

    return (
        <components.Menu {...props}>
            {optionSelectedLength < selectProps.maxSelectionNumber ? (
                props.children
            ) : (
                <div style={{ padding: 15 }}>
                    {selectProps.messages.maxLimitReached}
                </div>
            )}
        </components.Menu>
    );
};

const SelectComponent = (props) => {

    const handleChangeComplete = (val, type) => {
        let newValue;

        if ("clear" === type) {
            newValue = "";
        } else {
            if (Array.isArray(val)) {
                newValue = val.map((item) => item.value);
            } else {
                newValue = val.value;
            }
        }

        wp.customize(props.customizerSetting.id).set(newValue);
    };

    const theme = (theme) => ({
        ...theme,
        colors: {
            ...theme.colors,
            primary: "#0073aa",
            primary75: "#33b3db",
            primary50: "#99d9ed",
            primary24: "#e5f5fa",
        },
    });

    const customStyles = {
        control: (base, state) => ({
            ...base,
            minHeight: "30px",
        }),
        valueContainer: (base) => ({
            ...base,
            padding: "0 6px",
        }),
        input: (base) => ({
            ...base,
            margin: "0px",
        }),
    };

    const getLabel = (props) => {
        return <div dangerouslySetInnerHTML={{ __html: props.label }}></div>;
    };

    const inputId = props.inputId ? props.inputId : "thim-react-select-input--" + props.customizerSetting.id;

    return (
        <div>
            {props.label && <label
                className="customize-control-title"
                dangerouslySetInnerHTML={{ __html: props.label }}
                htmlFor={inputId}
            />}
            {props.description && <span
                className="description customize-control-description"
                dangerouslySetInnerHTML={{ __html: props.description }}
            />}
            <div
                className="customize-control-notifications-container"
                ref={props.setNotificationContainer}
            ></div>
            <Select
                {...props}
                inputId={inputId}
                className="thim-react-select-container"
                classNamePrefix="thim-react-select"
                inputClassName="thim-react-select-input"
                openMenuOnFocus={props.openMenuOnFocus}
                formatOptionLabel={getLabel}
                options={props.control.getFormattedOptions()}
                onChange={handleChangeComplete}
                value={props.control.getOptionProps(props.value)}
                isOptionDisabled={props.isOptionDisabled}
                components={{ IndicatorSeparator: () => null, Menu: SelectMenu }}
                theme={theme}
                styles={customStyles}
            />
        </div>
    );
};

export default SelectComponent;