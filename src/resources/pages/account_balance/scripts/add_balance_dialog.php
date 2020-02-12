<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="add-balance-dialog" tabindex="-1" role="dialog" aria-labelledby="abd" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('account_balance', array('action' => 'process_payment'), true); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="abd"><?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_TITLE); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="mdi mdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="authentication_type"><?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_SELECT_LABEL); ?></label>
                        <select class="form-control" name="amount" id="amount">
                            <option value="FLLNCMMRHFT4E">$5.00 USD</option>
                            <option value="NN3U3ZKFN9NSG">$10.00 USD</option>
                            <option value="GC4AXGEBKH4HY">$20.00 USD</option>
                            <option value="7C7KBDN8QUAR2">$30.00 USD</option>
                            <option value="FZJGN4HRS4D6E">$40.00 USD</option>
                            <option value="YLUR4PWD88FJ8">$50.00 USD</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_CANCEL_BUTTON); ?></button>
                    <input type="submit" class="btn btn-success" value="<?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_CONTINUE_BUTTON); ?>">
                </div>
            </form>
        </div>
    </div>
</div>