import Velocity from 'velocity-animate'

(function($) { 
    "use strict";
        
    // Mobile Menu
    $('#mobile-menu-toggler').on('click', function() {
        if ($('.mobile-menu').find('ul').first()[0].offsetParent !== null) {
            Velocity($('.mobile-menu').find('ul').first(), "slideUp")
        } else {
            Velocity($('.mobile-menu').find('ul').first(), "slideDown")
        }
    })

    $('.mobile-menu').find('.menu').on('click', function() {
        if ($(this).parent().find('ul').length) {
            if ($(this).parent().find('ul').first()[0].offsetParent !== null) {
                $(this).find('.menu__sub-icon').removeClass('transform rotate-180')
                Velocity(
                    $(this).parent().find('ul').first(), 
                    "slideUp", 
                    {
                        duration: 300,
                        complete: function(el) {
                            $(this).removeClass('menu__sub-open')
                        }
                    }
                )
            } else {
                $(this).find('.menu__sub-icon').addClass('transform rotate-180')
                Velocity(
                    $(this).parent().find('ul').first(), 
                    "slideDown", 
                    {
                        duration: 300,
                        complete: function(el) {
                            $(this).addClass('menu__sub-open')
                        }
                    }
                )
            }
        }
    })
})($)