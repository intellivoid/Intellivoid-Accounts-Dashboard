<?php
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<footer class="container-fluid footer">
    <div class="row pb-5 text-white footer-top">
        <div class="mx-auto">
            <div class="row">
                <div class="mt-auto mb-4 ml-5">
                    <ul class="nav mt-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('privacy', array(), true); ?>"><?PHP HTML::print(TEXT_FOOTER_MENU_LINK_PRIVACY); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('tos', array(), true); ?>"><?PHP HTML::print(TEXT_FOOTER_MENU_LINK_TOS); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://intellivoid.net/">Intellivoid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('documentation', array(), true); ?>"><?PHP HTML::print(TEXT_FOOTER_MENU_LINK_DOCUMENTATION); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-4 footer-bottom">
        <div class="mx-auto">
            <div class="container-fluid clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright &copy; 2017-<?PHP HTML::print(date('Y')); ?>
                    <a href="https://intellivoid.net/">Intellivoid Technologies</a>. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer>