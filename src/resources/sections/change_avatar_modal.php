<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    $ActionParameters =  array('action' => 'change_avatar');

    if(APP_CURRENT_PAGE == 'personal')
    {
        $ActionParameters['redirect'] = 'personal';
    }
?>
<div class="modal fade text-left" id="change-avatar-dialog" tabindex="-1" role="dialog" aria-labelledby="cam" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', $ActionParameters, true); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="cam"><?PHP HTML::print(TEXT_CHANGE_AVATAR_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center"  style="height:30vh;">
                        <?PHP
                            $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal');
                            if(isset($_GET['cache_refresh']))
                            {
                                if($_GET['cache_refresh'] == 'true')
                                {
                                    $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal', 'cache_refresh' => hash('sha256', time() . 'CACHE'));
                                }
                            }
                        ?>
                        <div class="avatar avatar-xl pull-up mt-2">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('avatar', $img_parameters, true) ?>" alt="<?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>">
                        </div>
                        <div class="mt-2 my-flex-item text-center">
                            <p class="text-muted"><?PHP HTML::print(TEXT_CHANGE_AVATAR_DIALOG_HINT); ?></p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CHANGE_AVATAR_DIALOG_CANCEL_BUTTON); ?></button>
                    <?PHP
                    if(APP_CURRENT_PAGE == 'manage_application')
                    {
                        ?>
                        <label class="btn btn-primary" onclick="location.href='<?PHP DynamicalWeb::getRoute('index', $ActionParameters, true); ?>'">
                            <?PHP HTML::print(TEXT_CHANGE_AVATAR_DIALOG_UPLOAD_BUTTON); ?>
                        </label>
                        <?PHP
                    }
                    else
                    {
                        ?>
                        <label class="btn btn-primary" for="file-selector" onchange="this.form.submit();">
                            <input id="file-selector" name="user_av_file" type="file" class="d-none">
                            <?PHP HTML::print(TEXT_CHANGE_AVATAR_DIALOG_UPLOAD_BUTTON); ?>
                        </label>
                        <?PHP
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>