<?PHP

    use DynamicalWeb\HTML;
use DynamicalWeb\Javascript;
use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('check');
    HTML::importScript('enter_sudo_mode');

    if(isset($_GET['redirect']) == false)
    {
        header('Location: /');
        exit();
    }
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Sudo Mode</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-5 mx-auto">
                            <div class="linear-activity">
                                <div id="linear-spinner" class="indeterminate-none"></div>
                            </div>
                            <div class="auto-form-wrapper" style="border-radius: 0px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                <h1 class="text-center">
                                    <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-sm rounded-circle"/>
                                    Intelli<b>void</b>
                                    <p>To prevent unauthorized changes, enter your password</p>
                                </h1>
                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="border-bottom pt-3"></div>

                                <form id="authentication_form" name="authentication_form" class="pt-4">
                                    <div class="form-group">
                                        <label for="password" id="label_1" class="label">Password</label>
                                        <input name="password" id="password" type="password" class="form-control" placeholder="*********" aria-autocomplete="none" autocomplete="off" required>
                                    </div>
                                    <div class="form-group pb-2 pt-2">
                                        <input id="submit_button" type="submit" class="btn btn-danger submit-btn btn-block" value="Enter sudo mode">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP Javascript::importScript('sudo', $_GET); ?>
    </body>
</html>
