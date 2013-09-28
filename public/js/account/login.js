/**
 * This file was created for js validation on user login page
 */

jQuery('#email').change(removeErrorMsg);
jQuery('#password').change(removeErrorMsg);

function removeErrorMsg() {
    var element = jQuery(this);
    element.parent().next('.help-block').text('');
    element.parents('.form-group').removeClass('has-error');
}

var validator = new FormValidator('login-user-form',
        [{
                name: 'email',
                display: 'e-mail',
                rules: 'required|valid_email'
            }, {
                name: 'password',
                display: 'password',
                rules: 'required'
            }
        ],
        function(errors, event) {
            if (errors.length > 0) {
                jQuery.each(errors, function(key, objectError) {
                    var element = jQuery('#' + objectError.id);
                    element.parent().next('.help-block').text(objectError.message);
                    element.parents('.form-group').addClass('has-error');
                });
            }
        });
validator.setMessage('valid_email', 'Please enter a valid e-mail.');
validator.setMessage('required', 'Please enter your %s.');
