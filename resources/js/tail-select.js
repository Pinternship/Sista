import tail from 'tail.select'

(function($) { 
    "use strict";
        
    // Tail Select
    $('.tail-select').each(function() {
        let options = {}

        if ($(this).data('placeholder')) {
            options.placeholder = $(this).data('placeholder')
        }

        if ($(this).attr('class') !== undefined) {
            options.classNames = $(this).attr('class')
        }

        if ($(this).data('search')) {
            options.search = true
        }

        if ($(this).attr('multiple') !== undefined) {
            options.descriptions = true
            options.hideSelected = true
            options.hideDisabled = true
            options.multiLimit = 15
            options.multiShowCount = false
            options.multiContainer = true
        }

        tail(this, options)
    })
})($)