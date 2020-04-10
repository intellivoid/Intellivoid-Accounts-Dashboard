<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<ul class="auth-footer">
    <li>
        <a href="https://intellivoid.net/">Intellivoid</a>
    </li>
    <li>
        <a href="<?PHP DynamicalWeb::getRoute('privacy', array(), true); ?>"><?PHP HTML::print(TEXT_AUTH_FOOTER_PRIVACY_LINK); ?></a>
    </li>
    <li>
        <a href="<?PHP DynamicalWeb::getRoute('tos', array(), true); ?>"><?PHP HTML::print(TEXT_AUTH_FOOTER_TOS_LINK); ?></a>
    </li>
    <li>
        <a href="https://intellivoid.net/contact"><?PHP HTML::print(TEXT_AUTH_FOOTER_CONTACT_LINK); ?></a>
    </li>
    <li>
        <a data-toggle="modal" data-target="#change-language-dialog" href="#">
            <i class="mdi mdi-translate"></i>
        </a>
    </li>
</ul>
<p class="footer-text tiny-text text-center">Copyright © 2017-<?PHP HTML::print(date('Y')); ?> Intellivoid Technologies. All rights reserved.</p>
<?PHP HTML::importSection('change_language_modal'); ?>