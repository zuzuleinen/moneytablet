/**
 * This file was created for js validation on tablet create page
 */

jQuery('#name').change(removeErrorMsg);
jQuery('#amount').change(removeErrorMsg);
jQuery('#economies').change(removeErrorMsg);
function removeErrorMsg() {
    var element = jQuery(this);
    element.parent().next('.help-block').text('');
    element.parents('.form-group').removeClass('has-error');
}

var validator = new FormValidator('create-tablet-form',
        [{
                name: 'name',
                display: 'name',
                rules: 'required'
            }, {
                name: 'amount',
                display: 'amount',
                rules: 'required|decimal'
            }, {
                name: 'economies',
                display: 'economies',
                rules: 'decimal'
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
validator.setMessage('required', 'This field is required.');
validator.setMessage('decimal', 'This field must be a decimal value. Ex: 90, 12.2');
