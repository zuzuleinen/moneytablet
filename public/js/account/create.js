/**
 * This file was created for js validation on user registration page
 */

jQuery('#inputEmail').change(removeErrorMsg);
jQuery('#inputPassword1').change(removeErrorMsg);
jQuery('#inputPassword2').change(removeErrorMsg);

function removeErrorMsg() {
    var element = jQuery(this);
    element.parent().next('.help-block').text('');
    element.parents('.form-group').removeClass('has-error');
}

var validator = new FormValidator('create-user-form',
        [{
                name: 'email',
                display: 'Email',
                rules: 'required|valid_email'
            }, {
                name: 'inputPassword1',
                display: 'password',
                rules: 'required|min_length[6]'
            }, {
                name: 'inputPassword2',
                display: 'password',
                rules: 'required|min_length[6]|matches[inputPassword1]'
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
validator.setMessage('required', 'This field should not be empty.');
validator.setMessage('min_length', 'The %s must have at least 6 characters.');
validator.setMessage('matches', 'Password fields must match.');
