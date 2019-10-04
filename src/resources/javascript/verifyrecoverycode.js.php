<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    $GetParameters['anim'] = 'previous';
?>
function go_back()
{
    $("#input_dialog").removeClass("animated");
    $("#input_dialog").removeClass("slideInRight");
    $("#input_dialog").addClass("animated slideOutRight");
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>'
    }, 800);
}