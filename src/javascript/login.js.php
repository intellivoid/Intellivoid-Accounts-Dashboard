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
        $("#username_email_label").removeClass("text-muted");
        $("#password_label").removeClass("text-muted");
        $("#submit_button").prop("disabled", false);
        $("#ca_label").removeClass("text-muted");
        $("#ca_link").removeClass("text-muted");
        $("#submit_preloader").prop("hidden", true);
        $("#submit_label").prop("hidden", false);
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#username_email").prop("disabled", true);
        $("#password").prop("disabled", true);
        $("#username_email_label").addClass("text-muted");
        $("#password_label").addClass("text-muted");
        $("#submit_button").prop("disabled", true);
        $("#ca_label").addClass("text-muted");
        $("#ca_link").addClass("text-muted");
        $("#submit_preloader").prop("hidden", false);
        $("#submit_label").prop("hidden", true);
    }
}
$('#authentication_form').on('submit', function () {
    var username_email = $("#username_email").val();
    var password = $("#password").val();
    $("#callback_alert").empty();
    toggle_anim();

    $.redirectPost("<?PHP DynamicalWeb::getRoute('authentication/login', $GetParameters, true); ?>",
        {
            "username_email": username_email,
            "password": password
        }
    );
    return false;
});
toggle_anim();