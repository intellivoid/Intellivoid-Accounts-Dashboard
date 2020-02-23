<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
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
function toggle_anim()
{
    if($("#linear-spinner").hasClass("indeterminate") === true)
    {
        $("#linear-spinner").removeClass("indeterminate");
        $("#linear-spinner").addClass("indeterminate-none");
        $("#username_email").prop("disabled", false);
        $("#password").prop("disabled", false);
        $("#label_1").removeClass("text-muted");
        $("#label_2").removeClass("text-muted");
        $("#submit_button").prop("disabled", false);
        $("#label_3").removeClass("text-muted");
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#username_email").prop("disabled", true);
        $("#password").prop("disabled", true);
        $("#label_1").addClass("text-muted");
        $("#label_2").addClass("text-muted");
        $("#submit_button").prop("disabled", true);
        $("#trusted_device").prop("disabled", true);
        $("#label_3").addClass("text-muted");
    }
}
$('#authentication_form').on('submit', function () {
    var username_email = $("#username_email").val();
    var password = $("#password").val();
    $("#callback_alert").empty();
    toggle_anim();

    $.redirectPost("<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>",
        {
            "username_email": username_email,
            "password": password
        }
    );
    return false;
});
toggle_anim();