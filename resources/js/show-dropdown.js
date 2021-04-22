(function($) { 
    "use strict";

    // Show dropdown
    $('#programmatically-show-dropdown').on('click', function() {
        $('#programmatically-dropdown').dropdown('show')
    })

    // Hide dropdown
    $('#programmatically-hide-dropdown').on('click', function() {
        $('#programmatically-dropdown').dropdown('hide')
    })

    // Toggle dropdown
    $('#programmatically-toggle-dropdown').on('click', function() {
        $('#programmatically-dropdown').dropdown('toggle')
    })
})($)