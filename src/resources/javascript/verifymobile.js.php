<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['incorrect_auth']);
    $GetParameters['anim'] = 'previous';

    $SubmitGetParameters = $GetParameters;
    $SubmitGetParameters['action'] = 'submit';
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
function go_back()
{
    <?php
        $Expanded = false;
        if(isset($_GET['expanded']))
        {
            if($_GET['expanded'] == "1")
            {
                $Expanded = true;
            }
        }

        if($Expanded == false)
        {
            ?>
            $("#verification_dialog").removeClass("animated");
            $("#verification_dialog").removeClass("fadeInRight");
            $("#verification_dialog").addClass("animated fadeOutRight");
            <?php
        }
        else
        {
            ?>
            $("#linear-spinner").removeClass("indeterminate-none");
            $("#linear-spinner").addClass("indeterminate");
            <?php
        }
    ?>
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>'
    }, 800);
}
function toggle_anim()
{
    if($("#linear-spinner").hasClass("indeterminate") === true)
    {
        $("#linear-spinner").removeClass("indeterminate");
        $("#linear-spinner").addClass("indeterminate-none");

        $("#code").prop("disabled", false);

        $("#submit_button").prop("disabled", false);
        $("#code_label").removeClass("text-muted");
        $("#submit_preloader").prop("hidden", true);
        $("#submit_label").prop("hidden", false);
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
        $("#code").prop("disabled", true);
        $("#submit_button").prop("disabled", true);
        $("#code_label").addClass("text-muted");
        $("#submit_preloader").prop("hidden", false);
        $("#submit_label").prop("hidden", true);
    }
}
$('#authentication_form').on('submit', function () {
    $("#callback_alert").empty();
    toggle_anim();
    $.redirectPost("<?PHP DynamicalWeb::getRoute('authentication/verification/verify_mobile', $SubmitGetParameters, true); ?>",
        {
            "code": $("#code").val()
        }
    );
    return false;
});
toggle_anim();