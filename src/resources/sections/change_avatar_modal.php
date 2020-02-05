<?PHP
    use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;

?>
<div class="modal fade" id="change-avatar-dialog" tabindex="-1" role="dialog" aria-labelledby="cam" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'change_avatar'), true); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="cam">Change Avatar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center"  style="height:30vh;">
                        <div class="preview-image mb-3">
                            <img class="img-lg img-fluid rounded-circle" src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="profile image">
                        </div>
                        <div class="mt-4 my-flex-item text-center">
                            <p class="text-muted"><?PHP HTML::print("JPEG or PNG Images that are 128x128px or larger are acceptable uploads"); ?></p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <label class="btn btn-success mt-2" for="file-selector" onchange="this.form.submit();">
                        <input id="file-selector" name="user_av_file" type="file" class="d-none">
                        Upload
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>