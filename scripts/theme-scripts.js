jQuery(document).ready(function ($) {
    var objTheme = {
        classHideAnswer: "hide-answer",
        elementFaqQuestion: $(".faqs-question"),
        classFaqsToggleOff: "fa-toggle-off",
        classFaqsToggleOn: "fa-toggle-on",
        elementCarousel: $(".carousel"),

        initTheme: function () {
            // Faqs User Event
            this.elementFaqQuestion.click(function () {
                objThis = $(this);
                objTheme.handleFaqs(objThis);
            });

            // Set Slider Speed
            this.setHomeSliderSpeed();
        },

        // Handle FAQS
        handleFaqs: function (objThis) {
            if (objThis.next().hasClass(this.classHideAnswer)) {
                objThis.next().removeClass(this.classHideAnswer);
                objThis.find("i").removeClass(this.classFaqsToggleOff);
                objThis.find("i").addClass(this.classFaqsToggleOn);
            } else {
                objThis.next().addClass(this.classHideAnswer);
                objThis.find("i").removeClass(this.classFaqsToggleOn);
                objThis.find("i").addClass(this.classFaqsToggleOff);
            }
        },

        // Set Slider Speed
        setHomeSliderSpeed: function () {
            this.elementCarousel.carousel({
                interval: parseInt(globalObject.home_slider_speed),
            });
        },
    };

    // Init Theme Object
    objTheme.initTheme();
});
