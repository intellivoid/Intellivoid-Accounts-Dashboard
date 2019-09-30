<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    HTML::importScript('auth.login');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Authentication</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-4 mx-auto">

                            <div class="linear-activity">
                                <div id="linear-spinner" class="indeterminate-none"></div>
                            </div>
                            <div class="auto-form-wrapper" style="border-radius: 0px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                <h1 class="text-center">
                                    <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-sm rounded-circle"/>
                                    Intelli<b>void</b>
                                    <p>Login to an existing Intellivoid Account</p>
                                </h1>
                                <div name="callback_alert" id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="border-bottom pt-3"></div>
                                <form id="authentication_form" name="authentication_form">
                                    <div class="form-group pt-4">
                                        <label for="username_email" id="label_1" class="label">Username or Email</label>
                                        <div class="input-group">
                                            <input name="username_email" id="username_email" type="text" class="form-control" placeholder="example@intellivoid.info" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-account text-black" id="username_group_ico"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" id="label_2" class="label">Password</label>
                                        <div class="input-group">
                                            <input name="password" id="password" type="password" class="form-control" placeholder="*********" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-textbox-password text-black" id="password_group_ico"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit_button" class="btn btn-primary submit-btn btn-block" value="Login">
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label" id="label_3">
                                                <input name="trusted_device" id="trusted_device" type="checkbox" class="form-check-input">
                                                Trust this device
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold">Don't have an account?</span>
                                        <a href="<?PHP DynamicalWeb::getRoute('register', $GetParameters, true); ?>" class="text-black text-small">Create one</a>
                                    </div>
                                </form>
                            </div>
                            <?PHP HTML::importSection('auth_footer'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script>
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
            function toggle_anim()
            {
                if($("#linear-spinner").hasClass("indeterminate") === true)
                {
                    $("#linear-spinner").removeClass("indeterminate");
                    $("#linear-spinner").addClass("indeterminate-none");
                    $("#username_email").prop("disabled", false);
                    $("#label_1").removeClass("text-muted");
                    $("#label_2").removeClass("text-muted");
                    $("#submit_button").prop("disabled", false);
                    $("#trusted_device").prop("disabled", false);
                    $("#label_3").removeClass("text-muted");
                    $("#password_group_ico").removeClass("text-muted");
                    $("#password_group_ico").addClass("text-black");
                    $("#username_group_ico").removeClass("text-muted");
                    $("#username_group_ico").addClass("text-black");
                }
                else
                {
                    $("#linear-spinner").removeClass("indeterminate-none");
                    $("#linear-spinner").addClass("indeterminate");
                    $("#username_email").prop("disabled", true);
                    $("#label_1").addClass("text-muted");
                    $("#label_2").addClass("text-muted");
                    $("#submit_button").prop("disabled", true);
                    $("#trusted_device").prop("disabled", true);
                    $("#label_3").addClass("text-muted");
                    $("#password_group_ico").addClass("text-muted");
                    $("#password_group_ico").removeClass("text-black");
                    $("#username_group_ico").addClass("text-muted");
                    $("#username_group_ico").removeClass("text-black");
                }
            }
            $('#authentication_form').on('submit', function () {
                var username_email = $("#username_email").val();
                var password = $("#password").val();
                var trusted_device = $("#trusted_device").is(":checked");
                $("#callback_alert").empty();
                toggle_anim();

                $.redirectPost("<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>",
                    {
                        "username_email": username_email,
                        "password": password,
                        "trusted_device": trusted_device
                    }
                );
                return false;
            });
        </script>
    </body>
</html>
