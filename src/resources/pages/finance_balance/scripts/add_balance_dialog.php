<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="add-balance-dialog" tabindex="-1" role="dialog" aria-labelledby="abd" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('finance_balance', array('action' => 'process_payment'), true); ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="abd"><?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount"><?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_SELECT_LABEL); ?></label>
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
                    <input type="submit" class="btn btn-primary" value="<?PHP HTML::print(TEXT_ADD_BALANCE_DIALOG_CONTINUE_BUTTON); ?>">
                </div>
            </form>
        </div>
    </div>
</div>