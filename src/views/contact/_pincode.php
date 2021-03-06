<?php

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var boolean $askPincode
 */

$isClient = !(bool)Yii::$app->user->can('role:client');
?>

<?php $this->registerJs(<<<"JS"
(function ($) { 
    var oldEmail = $('#contact-oldemail'),
        askPincode = Boolean('{$askPincode}'), 
        form = $('#contact-form'),
        pincodeInput = $('#contact-pincode'),
        isPrivilegedUser = Boolean('{$isClient}')
    
    form.on('beforeSubmit', function(event, attributes, messages, deferreds) {
        var show = isPrivilegedUser, // always show for privileged users
            attribute;

        attributes = attributes || document.getElementById('contact-form').elements; 
        for (var i in attributes) {
            attribute = attributes[i];
            
            if (
                attribute.name === 'Contact[email]' && oldEmail
                && attribute.value !== oldEmail.value
                && askPincode
            ) {
                show = true;
                break;
            }
        }
        
        if (show && !pincodeInput.val()) {
            event.preventDefault();
            
            form.pincodePrompt().then(function (pincode) {
                pincodeInput.val(pincode);
                form.submit();
            });
            
            return false;
        }
    });
})(jQuery);
JS
); ?>

<?= \hipanel\widgets\PincodePrompt::widget();
