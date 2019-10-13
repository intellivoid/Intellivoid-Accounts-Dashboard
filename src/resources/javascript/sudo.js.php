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
};

function toggle_anim() {
    if($("#linear-spinner").hasClass("indeterminate") === true)
    {
        $("#linear-spinner").removeClass("indeterminate");
        $("#linear-spinner").addClass("indeterminate-none");
        $("#password").prop("disabled", false);
        $("#label_1").removeClass("text-muted");
        $("#submit_button").prop("disabled", false);
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#password").prop("disabled", true);
        $("#label_1").addClass("text-muted");
        $("#submit_button").prop("disabled", true);
    }
}

$('#authentication_form').on('submit', function () {
    var password = $("#password").val();
    $("#callback_alert").empty();
    toggle_anim();

    $.redirectPost("<?PHP DynamicalWeb::getRoute('sudo', [], true); ?>",
        {
            "password": password,
            "redirect": getUrlParameter('redirect')
        }
    );
    return false;
});