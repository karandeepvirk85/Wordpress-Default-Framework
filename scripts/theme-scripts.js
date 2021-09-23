jQuery(document).ready(function ($) {
    var objTheme = {
        classHideAnswer: "hide-answer",
        elementFaqQuestion: $(".faqs-question"),
        classFaqsToggleOff: "fa-chevron-down",
        classFaqsToggleOn: "fa-chevron-up",
        elementCarousel: $(".carousel"),
        elementNotificationClose: $(".btn-close-notification"),
        elementNotificationBar: $(".notification-bar"),
        elementScropToTop: $(".scroll-to-top"),

        // Init Theme
        initTheme: function () {
            // Faqs User Event
            this.elementFaqQuestion.click(function () {
                objThis = $(this);
                objTheme.handleFaqs(objThis);
            });

            // Hanle Notification Click Event
            this.elementNotificationClose.click(function () {
                objTheme.closeNotification();
            });

            // Hanle Scroll To Top Click Event
            this.elementScropToTop.click(function () {
                objTheme.scrollToTop();
            });

            this.showScroll();

            this.setHomeSliderSpeed();
        },

        closeNotification: function () {
            this.elementNotificationBar.hide();
            objData = {
                action: "close-notification",
            };

            $.getJSON(globalObject.admin_url, objData, function (response) {});
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
        showScroll: function () {
            $(window).scroll(function () {
                var Top = window.pageYOffset;
                if (Top > 600) {
                    objTheme.elementScropToTop.css("display", "flex");
                } else {
                    objTheme.elementScropToTop.css("display", "none");
                }
            });
        },
        scrollToTop: function () {
            $("html").animate({ scrollTop: 0 }, "slow");
        },
    };

    // Init Theme Object
    objTheme.initTheme();
});
