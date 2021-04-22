import Pristine from 'pristinejs'
import Toastify from "toastify-js";

(function($) { 
    "use strict";

    function onSubmit(pristine) {
        let valid = pristine.validate()

        if (valid) {
            Toastify({
                text: "Registration success!",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "left",
                backgroundColor: "#91C714",
                stopOnFocus: true
            }).showToast()
        } else {
            Toastify({
                text: "Registration failed, please check the fileld form.",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "left",
                backgroundColor: "#D32929",
                stopOnFocus: true
            }).showToast()
        }
    }
        
    $('.validate-form').each(function() {
        let pristine = new Pristine(this, {
            classTo: 'input-form',
            errorClass: 'has-error',
            errorTextParent: 'input-form',
            errorTextClass: 'text-theme-6 mt-2' 
        })

        pristine.addValidator($(this).find('input[type="url"]')[0], function(value) {
            let expression = /[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/gi
            let regex = new RegExp(expression)
            if (!value.length || (value.length && value.match(regex))) {
                return true
            }
            return false
        }, "This field is URL format only", 2, false)

        $(this).on('submit', function (e) {
            e.preventDefault()
            onSubmit(pristine)
        })
    })
})($)