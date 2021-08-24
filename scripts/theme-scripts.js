jQuery(document).ready(function ($) {
    $(".carousel").carousel({
        interval: parseInt(globalObject.home_slider_speed),
    });

    var objTheme = {
        classHideAnswer: "hide-answer",
        elementFaqQuestion: $(".faqs-question"),
        classFaqsToggleOff: "fa-toggle-off",
        classFaqsToggleOn: "fa-toggle-on",

        initTheme: function () {
            this.elementFaqQuestion.click(function () {
                objThis = $(this);
                objTheme.handleFaqs(objThis);
            });
        },

        handleFaqs: function (objThis) {
            if ($(objThis).next().hasClass(this.classHideAnswer)) {
                $(objThis).next().removeClass(this.classHideAnswer);
                $(objThis).find("i").removeClass(this.classFaqsToggleOff);
                $(objThis).find("i").addClass(this.classFaqsToggleOn);
            } else {
                $(objThis).next().addClass(this.classHideAnswer);
                $(objThis).find("i").removeClass(this.classFaqsToggleOn);
                $(objThis).find("i").addClass(this.classFaqsToggleOff);
            }
        },
    };
    objTheme.initTheme();
});
