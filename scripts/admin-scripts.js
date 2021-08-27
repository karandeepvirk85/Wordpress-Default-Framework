jQuery(document).ready(function ($) {
    var objAdminTheme = {
        elementSettingsHeader: $(".settings-information-header"),
        elementSettingsInformation: $(".settings-information"),
        elementIcon: $(".fas"),
        classHidediv: "hide-div",
        classIconClose: "fa-chevron-down",
        classIconOpen: "fa-chevron-up",

        // Settings Init Function To Include all events
        adminInit: function () {
            this.elementSettingsHeader.click(function () {
                var objThis = $(this);
                objAdminTheme.handleAccordian(objThis);
            });
        },
        // Handle Accordians
        handleAccordian: function (objThis) {
            if (objThis.next().hasClass(this.classHidediv)) {
                objThis.next().removeClass(this.classHidediv);
                objThis.find("i").removeClass(this.classClose);
                objThis.find("i").addClass(this.classIconOpen);
            } else {
                objThis.next().addClass(this.classHidediv);
                objThis.find("i").removeClass(this.classIconOpen);
                objThis.find("i").addClass(this.classIconClose);
            }
        },
    };
    objAdminTheme.adminInit();
});
