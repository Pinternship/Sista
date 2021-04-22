import Velocity from 'velocity-animate'

(function($) { 
    "use strict";

    // Show accordion content
    $('body').on('click', '.accordion__pane__toggle', function() {
        // Close active accordion
        Velocity(
            $(this)
                .closest(".accordion")
                .find(".accordion__pane")
                .find(".accordion__pane__content"),
            "slideUp",
            {
                duration: 300,
                complete: function(el) {
                    $(el)
                        .closest(".accordion__pane")
                        .removeClass("active")
                }
            }
        )

        // Set active accordion
        if ($(this).closest('.accordion__pane').hasClass('active')) {
            Velocity(
                $(this)
                    .closest(".accordion__pane")
                    .find(".accordion__pane__content"),
                "slideUp",
                {
                    duration: 300,
                    complete: function(el) {
                        $(el)
                            .closest(".accordion__pane")
                            .removeClass("active");
                    }
                }
            )
        } else {
            Velocity(
                $(this)
                    .closest(".accordion__pane")
                    .find(".accordion__pane__content"),
                "slideDown",
                {
                    duration: 300,
                    complete: function(el) {
                    $(el)
                        .closest(".accordion__pane")
                        .addClass("active");
                    }
                }
            )
        }
    })
})($)