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

$('#authentication_form').on('submit', function () {
    var username_email = $("#username_email").val();
    var password = $("#password").val();
    var trusted_device = $("#trusted_device").is(":checked");
    $("#callback_alert").empty();
    $("#authentication_form").empty();
    $("#authentication_form").html(
        "<div class=\"pt-3\"></div>" +
        "<div class=\"dot-opacity-loader\">\n" +
        "<span></span>\n" +
        "<span></span>\n" +
        "<span></span>\n" +
        "</div>" +
        "<div class=\"pb-3\"></div>"
    );

    $.redirectPost("/auth/login",
        {
            "username_email": username_email,
            "password": password,
            "trusted_device": trusted_device
        }
    );
    return false;
});