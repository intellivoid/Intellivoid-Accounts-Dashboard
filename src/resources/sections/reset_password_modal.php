<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<div class="modal fade" id="password-reset-dialog" tabindex="-1" role="dialog" aria-labelledby="prd" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'update_password'), true) ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="prd">Update Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-lock"></i>
                                    </span>
                                </div>
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password">
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-lock-plus"></i>
                                    </span>
                                </div>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter your new password">
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="confirm_password">Repeat Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-lock-reset"></i>
                                    </span>
                                </div>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Repeat your new password">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>