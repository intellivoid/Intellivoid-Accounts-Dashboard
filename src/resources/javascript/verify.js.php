<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['anim']);
?>
function animate_next(){
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
            $("#verification_dialog").removeClass("fadeInLeft");
            $("#verification_dialog").addClass("animated fadeOutLeft");
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

}
function verify_mobile()
{
    animate_next();
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('authentication/verification/verify_mobile', $GetParameters, true); ?>'
    }, 800);
}
function verify_recovery_codes()
{
    animate_next();
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('authentication/verification/verify_recovery_code', $GetParameters, true); ?>'
    }, 800);
}
function verify_telegram()
{
    animate_next();
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('authentication/verification/verify_telegram', $GetParameters, true); ?>'
    }, 800);
}
$("#linear-spinner").removeClass("indeterminate");
$("#linear-spinner").addClass("indeterminate-none");