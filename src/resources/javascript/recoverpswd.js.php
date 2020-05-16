<?PHP

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

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}

function toggle_anim() {
    if($("#linear-spinner").hasClass("indeterminate") === true)
    {
        $("#linear-spinner").removeClass("indeterminate");
        $("#linear-spinner").addClass("indeterminate-none");
        $("#new_password").prop("disabled", false);
        $("#password_label").removeClass("text-muted");
        $("#submit_button").prop("disabled", false);
        $("#submit_preloader").prop("hidden", true);
        $("#submit_label").prop("hidden", false);
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#new_password").prop("disabled", true);
        $("#password_label").addClass("text-muted");
        $("#submit_button").prop("disabled", true);
        $("#submit_preloader").prop("hidden", false);
        $("#submit_label").prop("hidden", true);
    }
}

$('#authentication_form').on('submit', function () {
    $("#callback_alert").empty();
    toggle_anim();

    <?PHP
        if(isset($_GET['callback']))
        {
            unset($_GET['callback']);
        }
        $_GET['action'] = 'submit';
    ?>
    $.redirectPost("<?PHP DynamicalWeb::getRoute('recover_password', $_GET, true); ?>",
        {
            "username": $("#username").val(),
            "new_password": $("#new_password").val()
        }
    );
    return false;
});
toggle_anim();