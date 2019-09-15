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
};

$('#authentication_form').on('submit', function () {
    var password = $("#password").val();
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

    $.redirectPost("/auth/sudo",
        {
            "password": password,
            "redirect": getUrlParameter('redirect')
        }
    );
    return false;
});