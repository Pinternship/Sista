import Velocity from 'velocity-animate'

(function($) { 
    "use strict";
        
    // Show code or preview
    $('body').on('change', '.show-code', function() {
        let elementId = $(this).data('target')
        if ($(this).is(":checked")) {
            $(elementId).find('.preview').hide()
            Velocity($(elementId).find('.source-code'), "fadeIn")
        } else {
            Velocity($(elementId).find('.preview'), "fadeIn")
            $(elementId).find('.source-code').hide()
        }
    })
})($)