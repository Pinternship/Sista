import Velocity from 'velocity-animate'

(function($) { 
    "use strict";
        
    $('.chat__chat-list').children().each(function() {
        $(this).on('click', function() {
            Velocity(
                $('.chat__box').children('div:nth-child(2)'), 
                "fadeOut", 
                {
                    duration: 300,
                    complete: function(el) {
                        Velocity(
                            $('.chat__box').children('div:nth-child(1)'), 
                            "fadeIn", 
                            {
                                duration: 300,
                                complete: function(el) {
                                    $(el).removeClass('hidden').removeAttr('style')
                                }
                            }
                        )
                    }
                }
            )
        })
    })
})($)