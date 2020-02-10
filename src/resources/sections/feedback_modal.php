<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<div class="modal fade" id="feedback_dialog" tabindex="-1" role="dialog" aria-labelledby="fdl" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'submit_feedback'), true) ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="fdl">Send Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="feedback_message">Message</label>
                        <textarea name="feedback_message" id="feedback_message" class="form-control" rows="12" placeholder="Write your message here and we will get back to you as soon as possible via Email"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Send">
                </div>
            </form>
        </div>
    </div>
</div>