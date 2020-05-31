<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
?>
$.extend(
    {
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
        $("#email").prop("disabled", false);
        $("#username").prop("disabled", false);
        $("#password").prop("disabled", false);
        $("#tos_agree").prop("disabled", false);
        $("#submit_button").prop("disabled", false);
        $("#tos_agree_label").removeClass("text-muted");
        $("#email_label").removeClass("text-muted");
        $("#username_label").removeClass("text-muted");
        $("#password_label").removeClass("text-muted");
        $("#ca_label").removeClass("text-muted");
        $("#ca_link").removeClass("text-muted");
        $("#submit_preloader").prop("hidden", true);
        $("#submit_label").prop("hidden", false);
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#email").prop("disabled", true);
        $("#username").prop("disabled", true);
        $("#password").prop("disabled", true);
        $("#tos_agree").prop("disabled", true);
        $("#submit_button").prop("disabled", true);
        $("#tos_agree_label").addClass("text-muted");
        $("#email_label").addClass("text-muted");
        $("#username_label").addClass("text-muted");
        $("#password_label").addClass("text-muted");
        $("#ca_label").addClass("text-muted");
        $("#ca_link").addClass("text-muted");
        $("#submit_preloader").prop("hidden", false);
        $("#submit_label").prop("hidden", true);
    }
}

$('#authentication_form').on('submit', function () {
    var username = $("#username").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var tos_agree = $("#tos_agree").is(":checked");
    $("#callback_alert").empty();
    toggle_anim();

    $.redirectPost("<?PHP DynamicalWeb::getRoute('register', $GetParameters, true); ?>",
        {
            "username": username,
            "email": email,
            "password": password,
            "tos_agree": tos_agree
        }
    );
    return false;
});
toggle_anim();