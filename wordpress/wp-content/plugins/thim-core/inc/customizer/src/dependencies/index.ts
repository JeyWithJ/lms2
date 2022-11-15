const ThimDependencies = () => {
    let dependencyControls = {};

    const getSettingLink = (controlID) => {
        var control = document.querySelector('[data-thim-setting="' + controlID + '"]');
        var setting = controlID;

        if (control) {
            if (controlID !== control.dataset.thimSettingLink) {
                setting = control.dataset.thimSettingLink;
            }
        }

        return setting;
    }

    const addSettingLink = (requirements) => {
        requirements.forEach((requirement, requirementIndex) => {
            if (requirement.setting) {
                requirements[requirementIndex].settingLink = getSettingLink(
                    requirement.setting
                );
            } else {
                // If `requirement` is an array, then it has nested dependencies, so let's loop it.
                if (requirement.length) {
                    requirements[requirementIndex] = addSettingLink(requirements[requirementIndex]);
                }
            }
        });

        return requirements;
    }

    const evaluate = (value1, value2, operator, choice) => {
        var found = false;

        if (choice && "object" === typeof value2) {
            value2 = value2[choice];
        }

        if ("===" === operator) {
            return value1 === value2;
        }

        if (
            "==" === operator ||
            "=" === operator ||
            "equals" === operator ||
            "equal" === operator
        ) {
            return value1 == value2;
        }

        if ("!==" === operator) {
            return value1 !== value2;
        }

        if ("!=" === operator || "not equal" === operator) {
            return value1 != value2;
        }

        if (
            ">=" === operator ||
            "greater or equal" === operator ||
            "equal or greater" === operator
        ) {
            return value2 >= value1;
        }

        if (
            "<=" === operator ||
            "smaller or equal" === operator ||
            "equal or smaller" === operator
        ) {
            return value2 <= value1;
        }

        if (">" === operator || "greater" === operator) {
            return value2 > value1;
        }

        if ("<" === operator || "smaller" === operator) {
            return value2 < value1;
        }

        if ("contains" === operator || "in" === operator) {
            if (Array.isArray(value1) && Array.isArray(value2)) {
                value2.forEach((value) => {
                    if (value1.includes(value)) {
                        found = true;
                        return false;
                    }
                });
                return found;
            }

            if (Array.isArray(value2)) {
                value2.forEach((value) => {
                    if (value == value1) {
                        found = true;
                    }
                });
                return found;
            }

            if (typeof value2 === "object") {
                if (typeof value2[value1] !== 'undefined') {
                    found = true;
                }
                value2.forEach(subValue => {
                    if (value1 === subValue) {
                        found = true;
                    }
                });
                return found;
            }

            if (typeof value2 === 'string') {
                if (typeof value1 === 'string') {
                    return -1 < value1.indexOf(value2) && -1 < value2.indexOf(value1);
                }
                return -1 < value1.indexOf(value2);
            }
        }

        if ("does not contain" === operator || "not in" === operator) {
            return !evaluate(value1, value2, "contains", choice);
        }

        return value1 == value2;
    };

    const checkCondition = (dependency, dependantControl, relation) => {
        let childRelation = "AND" === relation ? "OR" : "AND";
        let nestedItems;
        let value;
        let i;

        if ("undefined" !== typeof dependency[0] && "undefined" === typeof dependency.setting) {
            nestedItems = [];

            for (i = 0; i < dependency.length; i++) {
                nestedItems.push(checkCondition(dependency[i], dependantControl, childRelation));
            }

            if ("OR" === childRelation) {
                return -1 !== nestedItems.indexOf(true);
            }

            return -1 === nestedItems.indexOf(false);
        }

        if ("undefined" === typeof wp.customize.control(dependency.setting)) {
            return true;
        }

        if (!dependencyControls[dependency.setting]) {
            dependencyControls[dependency.setting] = {
                settingLink: dependency.settingLink,
                childrens: [],
            };
        }

        if (!dependencyControls[dependency.setting].childrens.includes(dependantControl.id)) {
            dependencyControls[dependency.setting].childrens.push(dependantControl.id);
        }

        if (!dependency.settingLink) {
            console.log(dependencyControls);
            console.log("--------");
        }

        value = wp.customize(dependency.settingLink).get();

        if (wp.customize.control(dependency.setting).setting) {
            value = wp.customize.control(dependency.setting).setting._value;
        }

        return evaluate(
            dependency.value,
            value,
            dependency.operator,
            dependency.choice
        );
    };

    const showThimControl = (control) => {
        let show = true;

        let i;

        if (typeof control === 'string') {
            control = wp.customize.control(control);
        }

        // Exit early if control not found or if "required" argument is not defined.
        if ("undefined" === typeof control || (control.params && !control.params.required)) {
            return true;
        }

        // Loop control requirements.
        for (i = 0; i < control.params.required.length; i++) {
            if (!checkCondition(control.params.required[i], control, "AND")) {
                show = false;
            }
        }

        return show;
    }

    Object.entries(window.thimControlDependencies).forEach(([dependantID, requirements]) => {
        const control = wp.customize.control(dependantID);

        if (control) {
            requirements = addSettingLink(requirements);
            wp.customize.control(dependantID).params.required = requirements;
            showThimControl(control);
        }
    });

    Object.entries(dependencyControls).forEach(([dependencySetting, dependency]) => {
        dependency.childrens.forEach((childrenSetting) => {
            wp.customize(dependency.settingLink, function (setting) {
                const setupControl = (control) => {
                    const isDisplayed = () => {
                        return showThimControl(
                            wp.customize.control(childrenSetting)
                        );
                    };

                    const setActiveState = () => {
                        control.active.set(isDisplayed());
                    };

                    setActiveState();
                    setting.bind(setActiveState);

                    control.active.validate = isDisplayed;
                };

                wp.customize.control(childrenSetting, setupControl);
            });
        });
    });
}

export default ThimDependencies;
