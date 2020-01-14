<?PHP
    use DynamicalWeb\DynamicalWeb;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['action']);
?>
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
    $("#input_dialog").removeClass("animated");
    $("#input_dialog").removeClass("slideInRight");
    $("#input_dialog").addClass("animated slideOutRight");
    setTimeout(function() {
        window.location.href='<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>'
    }, 800);
}
setInterval(function(){
    var feedback = $.ajax({
        type: "POST",
        url: "<?PHP DynamicalWeb::getRoute('telegram_poll', $GetParameters, true); ?>",
        async: false
    }).responseText;
    console.log(feedback);
    response_j = JSON.parse(feedback);
    if(response_j.status == false){
        switch(response_j.error_code)
        {
            case 200:
                <?PHP $GetParameters['callback'] = '107'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>";
                break;

            case 201:
                <?PHP $GetParameters['callback'] = '101'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;

            case 202:
                <?PHP $GetParameters['callback'] = '100'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;

            case 203:
                <?PHP $GetParameters['callback'] = '102'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;

            case 204:
                <?PHP $GetParameters['callback'] = '104'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;

            case 205:
                <?PHP $GetParameters['callback'] = '109'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>";
                break;

            case 206:
                <?PHP $GetParameters['callback'] = '106'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;

            default:
                <?PHP $GetParameters['callback'] = '101'; ?>
                location.href = "<?PHP DynamicalWeb::getRoute('verify', $GetParameters, true); ?>";
                break;
        }
    }
    else
    {
        if(response_j.approved == true)
        {
            <?PHP $GetParameters['action'] = 'verify'; ?>
            <?PHP unset($GetParameters['callback']); ?>
            location.href = "<?PHP DynamicalWeb::getRoute('verify_telegram', $GetParameters, true); ?>";
        }
    }
}, 1000);