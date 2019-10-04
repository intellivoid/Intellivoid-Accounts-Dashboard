<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['anim']);
?>
function animate_next(){
    $("#verification_dialog").removeClass("animated");
    $("#verification_dialog").removeClass("slideInLeft");
    $("#verification_dialog").addClass("animated slideOutLeft")
}
function verify_mobile()
{
    animate_next();
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('verify_mobile', $GetParameters, true); ?>'
    }, 800);
}
function verify_recovery_codes()
{
    animate_next();
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('verify_recovery_code', $GetParameters, true); ?>'
    }, 800);
}