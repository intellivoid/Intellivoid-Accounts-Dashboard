<?PHP
    use DynamicalWeb\DynamicalWeb;

    \DynamicalWeb\HTML::importScript('render_alert');
?>
<div class="modal fade" id="add-balance-dialog" tabindex="-1" role="dialog" aria-labelledby="abd" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('account_balance', array('action' => 'process_payment'), true); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="abd">Add to your Balance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="authentication_type">Select Amount</label>
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
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" value="Continue">
                </div>
            </form>
        </div>
    </div>
</div>