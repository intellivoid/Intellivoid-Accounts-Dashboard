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
var verticalForm = $("#mobile-verification-wizard");
verticalForm.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onFinished: function (event, currentIndex) {
        $.redirectPost("<?PHP DynamicalWeb::getRoute('settings_setup_mobile_verification', array('action' => 'verify'), true); ?>",
            {
                "verification_code": $("#verification_code").val()
            }
        );
    }
});
$("#mobile-verification-wizard").each(function() {
    $(this).find('.content').addClass('bg-white');
});