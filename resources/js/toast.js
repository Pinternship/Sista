import Toastify from 'toastify-js'

(function($) { 
    "use strict";
        
    // Basic Toast
    $('#basic-non-sticky-toast').on('click', function() {
        Toastify({
            text:
              "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, consequuntur doloremque eveniet eius eaque dicta repudiandae illo ullam. Minima itaque sint magnam dolorum asperiores repudiandae dignissimos expedita, voluptatum vitae velit.",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true
        }).showToast();
    })
    $('#basic-sticky-toast').on('click', function() {
        Toastify({
            text:
              "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, consequuntur doloremque eveniet eius eaque dicta repudiandae illo ullam. Minima itaque sint magnam dolorum asperiores repudiandae dignissimos expedita, voluptatum vitae velit.",
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true
        }).showToast();
    })

    // HTML Toast
    $('#html-non-sticky-toast').on('click', function() {
        Toastify({
            node: $(
              '<span>Let\'s test some HTML stuff... <a class="font-medium" href="#">Github</a></span>'
            )[0],
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true
        }).showToast();
    })
    $('#html-sticky-toast').on('click', function() {
        Toastify({
            node: $(
              '<span><strong>Remember!</strong> You can <span class="font-medium">always</span> introduce your own × HTML and <span class="font-medium">CSS</span> in the toast.<span>'
            )[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true
        }).showToast();
    })
})($)