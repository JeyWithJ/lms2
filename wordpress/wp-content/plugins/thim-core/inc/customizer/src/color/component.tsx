import { useState } from "@wordpress/element";
import {
	HexColorPicker,
	RgbColorPicker,
	RgbaColorPicker,
	RgbStringColorPicker,
	RgbaStringColorPicker,
	HslColorPicker,
	HslaColorPicker,
	HslStringColorPicker,
	HslaStringColorPicker,
	HsvColorPicker,
	HsvaColorPicker,
	HsvStringColorPicker,
	HsvaStringColorPicker,
} from "react-colorful";
import ColorInput from './components/ColorInput';
import ColorSwatches from "./components/ColorSwatches";
import convertColorForPicker from "./utils/convertForPicker";
import convertColorForCustomizer from "./utils/convertForCustomizer";
import convertColorForInput from "./utils/convertForInput";
import ColorCircle from "./components/ColorCircle";
import { colord } from "colord";
import { Dropdown } from '@wordpress/components';


const ColorComponent = (props) => {
	const { control, customizerSetting, useHueMode, pickerComponent, choices } = props;

	const parseEmptyValue = () => (useHueMode ? 0 : "#000000");

	const parseHueModeValue = (hueValue) => {
		hueValue = hueValue || parseEmptyValue();
		hueValue = hueValue < 0 ? 0 : hueValue;

		return hueValue > 360 ? 360 : hueValue;
	};

	const parseInputValue = (value) => {
		if ("" === value) return "";

		return useHueMode
			? parseHueModeValue(value)
			: convertColorForInput(
				value,
				pickerComponent,
				choices.formComponent
			).replace(";", "");
	};

	const parseCustomizerValue = (value) => {
		if ("" === value) return "";

		return convertColorForCustomizer(
			value,
			pickerComponent,
			choices.formComponent
		);
	};

	const parsePickerValue = (value) => {
		value = value || parseEmptyValue();

		// Hard coded saturation and lightness when using hue mode.
		return useHueMode
			? { h: value, s: 100, l: 50 }
			: convertColorForPicker(value, pickerComponent);
	};

	const [inputValue, setInputValue] = useState(() => {
		return parseInputValue(props.value);
	});

	const [pickerValue, setPickerValue] = useState(() => {
		return parsePickerValue(props.value);
	});

	let currentInputValue = inputValue;
	let currentPickerValue = pickerValue;

	// This function will be called when this control's customizer value is changed.
	control.updateComponentState = (value) => {
		const valueForInput = parseInputValue(value);
		let changeInputValue = false;

		if (typeof valueForInput === "string" || useHueMode) {
			changeInputValue = valueForInput !== inputValue;
		} else {
			changeInputValue =
				JSON.stringify(valueForInput) !== JSON.stringify(currentInputValue);
		}

		if (changeInputValue) setInputValue(valueForInput);

		const valueForPicker = parsePickerValue(value);
		let changePickerValue = false;

		if (typeof valueForPicker === "string" || useHueMode) {
			changePickerValue = valueForPicker !== pickerValue;
		} else {
			changePickerValue =
				JSON.stringify(valueForPicker) !== JSON.stringify(currentPickerValue);
		}

		if (changePickerValue) setPickerValue(valueForPicker);
	};

	const saveToCustomizer = (value) => {
		if (useHueMode) {
			/**
			 * When using hue mode, the pickerComponent is HslColorPicker.
			 * If there is value.h, then value is set from the picker.
			 * Otherwise, value is set from the input or the customizer.
			 */
			value = value.h || 0 === value.h ? value.h : value;
			value = parseHueModeValue(value);
		} else {
			value = parseCustomizerValue(value);
		}

		customizerSetting.set(value);
	};

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {string|Object} color The value returned by the picker. It can be a string or a color object.
	 */
	const handlePickerChange = (color) => {
		if (props.onChange) props.onChange(color);
		currentPickerValue = color;
		saveToCustomizer(color);
	};

	const handleInputChange = (value) => {
		currentInputValue = value;
		saveToCustomizer(value);
	};

	const handleReset = () => {
		if (!initialColor) {
			currentInputValue = "";
			currentPickerValue = "";
		}

		saveToCustomizer(initialColor);
	};

	const handleSwatchesClick = (swatchColor) => {
		saveToCustomizer(swatchColor);
	};

	let controlLabel = (
		<span
			className="customize-control-title"
			dangerouslySetInnerHTML={{ __html: props.label }}
		/>
	);

	let controlDescription = (
		<span
			className="description customize-control-description"
			dangerouslySetInnerHTML={{ __html: props.description }}
		></span>
	);

	controlLabel = (
		<label className="thim-control-label">
			{props.label ? controlLabel : ""}
			{props.description ? controlDescription : ""}
		</label>
	);

	controlLabel = props.label || props.description ? controlLabel : "";

	let PickerComponent;

	// We can't just render `pickerComponent` directly, we need these lines so that the compiler will import them.
	switch (pickerComponent) {
		case "HexColorPicker":
			PickerComponent = HexColorPicker;
			break;
		case "RgbColorPicker":
			PickerComponent = RgbColorPicker;
			break;
		case "RgbStringColorPicker":
			PickerComponent = RgbStringColorPicker;
			break;
		case "RgbaColorPicker":
			PickerComponent = RgbaColorPicker;
			break;
		case "RgbaStringColorPicker":
			PickerComponent = RgbaStringColorPicker;
			break;
		// We treat HueColorPicker (hue mode) as HslColorPicker.
		case "HueColorPicker":
			PickerComponent = HslColorPicker;
			break;
		case "HslColorPicker":
			PickerComponent = HslColorPicker;
			break;
		case "HslStringColorPicker":
			PickerComponent = HslStringColorPicker;
			break;
		case "HslaColorPicker":
			PickerComponent = HslaColorPicker;
			break;
		case "HslaStringColorPicker":
			PickerComponent = HslaStringColorPicker;
			break;
		case "HsvColorPicker":
			PickerComponent = HsvColorPicker;
			break;
		case "HsvStringColorPicker":
			PickerComponent = HsvStringColorPicker;
			break;
		case "HsvaColorPicker":
			PickerComponent = HsvaColorPicker;
			break;
		case "HsvaStringColorPicker":
			PickerComponent = HsvaStringColorPicker;
			break;
		default:
			PickerComponent = HexColorPicker;
			break;
	}

	if (jQuery.wp && jQuery.wp.wpColorPicker) {
		const wpColorPickerSwatches =
			jQuery.wp.wpColorPicker.prototype.options.palettes;

		// If 3rd parties applied custom colors to wpColorPicker swatches, let's use them.
		if (Array.isArray(wpColorPickerSwatches)) {
			if (wpColorPickerSwatches.length < 8) {
				for (let i = wpColorPickerSwatches.length; i <= 8; i++) {
					wpColorPickerSwatches.push(choices.swatches[i]);
				}
			}

			choices.swatches = wpColorPickerSwatches;
		}
	}


	let formClassName = useHueMode
		? "thim-control-form use-hue-mode"
		: "thim-control-form";

	formClassName += " has-" + choices.labelStyle + "-label-style";

	return (
		<>
			<Dropdown
				className={formClassName}
				contentClassName="thim-color-component__popover"
				renderToggle={({ isOpen, onToggle }) => (
					<>
						{choices.labelStyle === 'tooltip' ? (
							<>
								<button
									type="button"
									className="thim-control-reset"
									onClick={() => {
										onToggle();
										handleReset();
									}}
									style={{ display: isOpen ? "flex" : "none" }}
								>
									<i className="dashicons dashicons-image-rotate"></i>
								</button>

								<ColorCircle
									pickerComponent={pickerComponent}
									useHueMode={useHueMode}
									color={
										!useHueMode
											? inputValue
											: colord({ h: inputValue, s: 100, l: 50 }).toHex()
									}
									isPickerOpen={isOpen}
									togglePickerHandler={onToggle}
								/>

								<div className="thim-label-tooltip">
									{controlLabel}
									<div
										className="customize-control-notifications-container"
										ref={props.setNotificationContainer}
									/>
								</div>
							</>
						) : (
							<>
								{choices.labelStyle === 'top' ? (
									<>
										{controlLabel}
										<div
											className="customize-control-notifications-container"
											ref={props.setNotificationContainer}
										/>
										<button
											type="button"
											className="thim-control-reset"
											onClick={() => {
												onToggle();
												handleReset();
											}}
											style={{ display: isOpen ? "flex" : "none" }}
										>
											<i className="dashicons dashicons-image-rotate"></i>
										</button>

										<ColorCircle
											pickerComponent={pickerComponent}
											useHueMode={useHueMode}
											color={
												!useHueMode
													? inputValue
													: colord({ h: inputValue, s: 100, l: 50 }).toHex()
											}
											isPickerOpen={isOpen}
											togglePickerHandler={onToggle}
										/>
									</>
								) : (
									<div className="thim-control-cols">
										<div className="thim-control-left-col">
											{controlLabel}
											<div
												className="customize-control-notifications-container"
												ref={props.setNotificationContainer}
											/>
										</div>
										<div className="thim-control-right-col">
											<>
												<button
													type="button"
													className="thim-control-reset"
													onClick={() => {
														onToggle();
														handleReset();
													}}
													style={{ display: isOpen ? "flex" : "none" }}
												>
													<i className="dashicons dashicons-image-rotate"></i>
												</button>

												<ColorCircle
													pickerComponent={pickerComponent}
													useHueMode={useHueMode}
													color={
														!useHueMode
															? inputValue
															: colord({ h: inputValue, s: 100, l: 50 }).toHex()
													}
													isPickerOpen={isOpen}
													togglePickerHandler={onToggle}
												/>
											</>
										</div>
									</div>
								)}
							</>
						)}
					</>
				)}
				renderContent={() => (
					<div className="colorPickerContainer">
						{!useHueMode && (
							<ColorSwatches
								colors={choices.swatches}
								onClick={handleSwatchesClick}
							/>
						)}

						<PickerComponent
							color={pickerValue}
							onChange={handlePickerChange}
						/>

						<ColorInput
							pickerComponent={pickerComponent}
							useHueMode={useHueMode}
							color={inputValue}
							onChange={handleInputChange}
						/>
					</div>
				)}
			/>
		</>
	);
};

export default ColorComponent;
