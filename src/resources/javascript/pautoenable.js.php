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

$("#submit_button").prop("disabled", true);
setTimeout(function(){
    $("#linear-spinner").removeClass("indeterminate");
    $("#linear-spinner").addClass("indeterminate-none");
    $("#confirm_password_label").removeClass("text-muted");
    $("#submit_button").prop("disabled", false);
    $("#confirm_password").prop("disabled", false);
    $("#submit_preloader").prop("hidden", true);
    $("#submit_label").prop("hidden", false);
}, <?PHP print(mt_rand(3000, 6000)); ?>
);

function toggle_anim(){
    $("#linear-spinner").removeClass("indeterminate-none");
    $("#linear-spinner").addClass("indeterminate");
    $("#confirm_password_label").addClass("text-muted");
    $("#submit_button").prop("disabled", true);
    $("#confirm_password").prop("disabled", true);
    $("#submit_preloader").prop("hidden", false);
    $("#submit_label").prop("hidden", true);
}


$('#purchase_form').on('submit', function () {
    $("#callback_alert").empty();
    toggle_anim();
    <?PHP
        if(isset($_GET['callback']))
        {
            unset($_GET['callback']);
        }
    ?>
    $.redirectPost("<?PHP DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET, true); ?>",
        {
            "confirm_password": $("#confirm_password").val()
        }
    );
    return false;
});