<?php
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="appInfoModal" tabindex="-1" role="dialog" aria-labelledby="appInfoModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'submit_feedback'), true) ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="appInfoModal"><?PHP HTML::print(TEXT_APP_INFO_DIALOG_TITLE); ?></h4>
                </div>
                <div class="modal-body">
                    <p>Intellivoid Accounts, Copyright &copy; Intellivoid Technologies 2017-<?PHP \DynamicalWeb\HTML::print(date("Y")); ?></p>
                    <h5>Components Info (PPM)</h5>
                    <ul class="list-unstyled">
                        <?PHP
                        foreach(\ppm\ppm::getImportedPackages() as $package_name => $package_version)
                        {
                            ?>
                            <li>
                                <?PHP \DynamicalWeb\HTML::print($package_name); ?>==<code><?PHP \DynamicalWeb\HTML::print($package_version); ?></code>
                            </li>
                            <?PHP
                        }
                        ?>
                    </ul>
                    <h5>DynamicalWeb Build Info</h5>
                    <ul class="list-unstyled">
                        <li>
                            Version==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_VERSION); ?></code>
                        </li>
                        <li>
                            Author==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_AUTHOR); ?></code>
                        </li>
                        <li>
                            Company==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_COMPANY); ?></code>
                        </li>
                    </ul>
                    <h5>Device Info</h5>
                    <ul class="list-unstyled">
                        <li>
                            Host==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_REMOTE_HOST); ?></code>
                        </li>
                        <li>
                            UserAgent==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_USER_AGENT); ?></code>
                        </li>
                        <li>
                            Platform==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_PLATFORM); ?></code>
                        </li>
                        <li>
                            Browser==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_BROWSER); ?></code>
                        </li>
                        <li>
                            Version==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_VERSION); ?></code>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <?PHP HTML::print(TEXT_APP_INFO_DIALOG_CLOSE_BUTTON); ?>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>