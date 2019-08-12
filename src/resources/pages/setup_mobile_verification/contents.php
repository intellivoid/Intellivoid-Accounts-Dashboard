<?PHP
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    HTML::importScript('setup');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">


                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Mobile Verification Setup</h4>
                                        <form id="mobile-verification-wizard" action="/setup_mobile_verification?action=verify" method="POST">
                                            <div>
                                                <h3>Download</h3>
                                                <section>
                                                    <h6>Download Google Authenticator</h6>
                                                    <p>
                                                        you can use the Google Authenticator app to receive codes even if you don’t have an Internet connection.
                                                    </p>
                                                    <div class="row pl-4">
                                                        <div class="col-md-6 col-lg-6 grid-margin">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-row align-items-top">
                                                                        <i class="mdi mdi-google-play text-success icon-md"></i>
                                                                        <div class="ml-3">
                                                                            <h6 class="text-success">Google Playstore</h6>
                                                                            <a class="btn btn-block btn-success mt-2" target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 grid-margin">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-row align-items-top">
                                                                        <i class="mdi mdi-apple-mobileme text-primary icon-md"></i>
                                                                        <div class="ml-3">
                                                                            <h6 class="text-primary">Apple AppStore</h6>
                                                                            <a class="btn btn-block btn-primary mt-2" target="_blank" href="http://appstore.com/googleauthenticator">
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <h3>Scan</h3>
                                                <section>
                                                    <h6>Scan QR Code</h6>
                                                    <div class="form-group">
                                                        <img class="img-fluid d-block mx-auto mb-2 pt-3 border-primary" src="<?PHP HTML::print(SECURITY_QR_CODE, false); ?>">
                                                        <p class="text-muted text-center pt-2">
                                                            Can't scan it? <code><?PHP HTML::print(SECURITY_SECRET_CODE); ?></code>
                                                        </p>
                                                    </div>
                                                </section>
                                                <h3>Verify</h3>
                                                <section>
                                                    <h6>Enter your generated code to verify</h6>
                                                    <div class="form-group pt-5 pl-1 pr-1">
                                                        <label for="verification_code">Verification Code</label>
                                                        <input type="text" class="form-control" id="verification_code" name="verification_code" placeholder="123 456" required>
                                                    </div>
                                                </section>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
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
            var verticalForm = $("#mobile-verification-wizard");
            verticalForm.children("div").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                onFinished: function (event, currentIndex) {
                    $.redirectPost("/setup_mobile_verification?action=verify",
                        {
                            "verification_code": $("#verification_code").val()
                        }
                    );
                }
            });
            $("#mobile-verification-wizard").each(function() {
                $(this).find('.content').addClass('bg-white');
            });
        </script>
    </body>
</html>
