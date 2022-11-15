function SwitchControl(control) {
    control = control || this;

    control.container.on("change", "input", function () {
        control.setting.set(jQuery(this).is(":checked"));
    });
}

export default SwitchControl;