jQuery(document).ready(function ($) {
    $(".settings-social-information-to-click").click(function () {
        if ($(".settings-social-information-to-open").hasClass("hide-div")) {
            $(".settings-social-information-to-open").removeClass("hide-div");
            $(".fas").removeClass("fa-chevron-down");
            $(".fas").addClass("fa-chevron-up");
        } else {
            $(".settings-social-information-to-open").addClass("hide-div");
            $(".fas").removeClass("fa-chevron-up");
            $(".fas").addClass("fa-chevron-down");
        }
    });
});
