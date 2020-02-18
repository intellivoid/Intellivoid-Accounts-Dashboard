<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<div class="modal fade" id="change-language-dialog" tabindex="-1" role="dialog" aria-labelledby="crd" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crd">Change Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <a href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'en', 'cache' => hash('sha256', time())), true); ?>">
                            <i class="flag-icon flag-icon-gb" title="gb" id="gb"></i> English (UK)
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'es', 'cache' => hash('sha256', time())), true); ?>">
                            <i class="flag-icon flag-icon-cl" title="es" id="es"></i> Español
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'tr', 'cache' => hash('sha256', time())), true); ?>">
                            <i class="flag-icon flag-icon-tr" title="tr" id="tr"></i> Türk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>