import { createPopper } from "@popperjs/core";

(function($) {
    "use strict";

    // Hide dropdown
    function hide() {
        $(".dropdown-box").each(async function() {
            if (
                $(this).attr("id") !== undefined && 
                $('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length &&
                $(this).data("dropdown-programmatically") === undefined
            ) {
                let randId = $(this).attr("id");

                // Animate dropdown
                $(this).removeClass("show");

                await setTimeout(() => {
                    // Move modal element to body
                    $('[data-dropdown-replacer="' + randId + '"]').replaceWith(this);

                    // Reset attribute
                    $(this).removeAttr("style");
                    $(this).removeAttr("data-popper-placement");
                }, 200);
            } else if (
                $(this).attr("id") !== undefined &&
                !$('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length &&
                $(this).hasClass("show") &&
                $(this).data("dropdown-programmatically") === undefined
            ) {
                $(this).remove();
            } else if ($(this).data("dropdown-programmatically") == "initiate") {
                // Set programmatically attribute state
                $(this).attr("data-dropdown-programmatically", "showed");
            } else if ($(this).data("dropdown-programmatically") == "showed") {
                // Remove programmatically attribute state
                $(this).removeAttr("data-dropdown-programmatically");
            }
        });
    }

    // Show dropdown
    function show(dropdown) {
        let dropdownBox = $(dropdown).find(".dropdown-box").first();
        let dropdownToggle = $(dropdown).find(".dropdown-toggle");
        let placement = $(dropdown).data("placement") ? $(dropdown).data("placement") : "bottom-end";
        let randId = "_" + Math.random().toString(36).substr(2, 9);

        // Hide dropdown
        hide();

        if ($(dropdownBox).length) {
            // Set dropdown width
            $(dropdown).css("position") == "static" ? $(dropdown).css("position", "relative") : ""
            $(dropdownBox).css("width", $(dropdownBox).css("width"));

            // Move modal element to body
            $('<div data-dropdown-replacer="' + randId + '"></div>').insertAfter(dropdownBox);
            $(dropdownBox).attr("id", randId).appendTo("body");

            // Init popper
            createPopper(dropdownToggle[0], dropdownBox[0], {
                placement: placement
            });

            // Show dropdown
            $(dropdownBox).addClass("show");
        }
    }

    // Toggle dropdown programmatically
    function toggleProgrammatically(dropdown) {
        let dropdownBox = $(dropdown).find(".dropdown-box").first();
        if ($(dropdownBox).length) {
            showProgrammatically(dropdown);
        } else {
            hide();
        }
    }

    // Show dropdown programmatically
    function showProgrammatically(dropdown) {
        if ($(dropdown).find(".dropdown-box").length) {
            $(dropdown).find(".dropdown-box").attr("data-dropdown-programmatically", "initiate");
        } else {
            let randId = $("[data-dropdown-replacer]").data("dropdown-replacer");
            $("#" + randId).attr("data-dropdown-programmatically", "initiate");
        }

        show(dropdown);
    }

    // Dropdown event listener
    $("body").on("click", function(event) {
        let dropdown = $(event.target).closest(".dropdown");
        let dropdownToggle = $(dropdown).find(".dropdown-toggle");
        let dropdownBox = $(dropdown).find(".dropdown-box").first();
        let activeDropdownBox = $(event.target).closest(".dropdown-box").first();
        let dismissButton = $(event.target).data("dismiss");

        if (
            (!$(dropdown).length && !$(activeDropdownBox).length) ||
            ($(dropdownToggle).length && !$(dropdownBox).length) ||
            dismissButton == "dropdown"
        ) {
            // Hide dropdown
            hide();
        } else if (!$(activeDropdownBox).length) {
            // Show dropdown
            show(dropdown);
        }
    });

    $.fn.dropdown = function(event) {
        if (event == "show") {
            showProgrammatically(this);
        } else if (event == "hide") {
            hide(this);
        } else if (event == "toggle") {
            toggleProgrammatically(this);
        }
    };
})($);