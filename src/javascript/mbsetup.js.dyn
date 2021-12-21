<?php
    use DynamicalWeb\DynamicalWeb;
?>
$.extend({
    redirectPost: function(location, args)
    {
        var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", location);

        $.each( args, function( key, value ) {
            var field = $('<input></input>');

            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);

            form.append(field);
        });
        $(form).appendTo('body').submit();
    }
});
$("#mobile_verification_setup_wizard").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Verify'
    },
    onFinished: function (event, currentIndex) {
        $.redirectPost("<?PHP DynamicalWeb::getRoute('settings/setup_mobile_verification', array('action'=>'authentication/verification/verify'), true); ?>",
            {
                "verification_code": $("#verification_code").val()
            }
        );
    }
});