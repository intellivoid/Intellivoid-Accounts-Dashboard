<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['action']);
    $GetParameters['anim'] = 'previous';
?>
var telegram_auth = {
    process_completed: false
}
function insertParam(key, value)
{
    key = encodeURI(key); value = encodeURI(value);
    var kvp = document.location.search.substr(1).split('&');
    var i=kvp.length; var x; while(i--)
    {
        x = kvp[i].split('=');
        if (x[0]==key)
        {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }
    if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    document.location.search = kvp.join('&');
}
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
    }, 500);
}
function toggle_anim()
{
    if($("#linear-spinner").hasClass("indeterminate") === true)
    {
        $("#linear-spinner").removeClass("indeterminate");
        $("#linear-spinner").addClass("indeterminate-none");
    }
    else
    {
        $("#linear-spinner").removeClass("indeterminate-none");
        $("#linear-spinner").addClass("indeterminate");
    }
}
setInterval(function(){

    if(telegram_auth.process_completed === true){
        return;
    }

    var feedback = $.ajax({
        type: "POST",
        url: "<?PHP DynamicalWeb::getRoute('telegram_poll', $GetParameters, true); ?>",
        async: false
    }).responseText;
    response_j = JSON.parse(feedback);
    if(response_j.status == false){
        switch(response_j.error_code)
        {
            case 200:
                <?PHP $GetParameters['callback'] = '107'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/login', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            case 201:
                <?PHP $GetParameters['callback'] = '101'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            case 202:
                <?PHP $GetParameters['callback'] = '100'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                break;

            case 203:
                <?PHP $GetParameters['callback'] = '102'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            case 204:
                <?PHP $GetParameters['callback'] = '104'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            case 205:
                <?PHP $GetParameters['callback'] = '109'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/login', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            case 206:
                <?PHP $GetParameters['callback'] = '106'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;

            default:
                <?PHP $GetParameters['callback'] = '101'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify', $GetParameters, true); ?>";
                telegram_auth.process_completed = true;
                break;
        }
    }
    else
    {
        if(response_j.approved == true)
        {
            <?PHP $GetParameters['action'] = 'verify'; ?>
            <?PHP unset($GetParameters['callback']); ?>
            location.href = "<?PHP DynamicalWeb::getRoute('authentication/verification/verify_telegram', $GetParameters, true); ?>";
            telegram_auth.process_completed = true;
        }
    }
}, 2000);
toggle_anim();