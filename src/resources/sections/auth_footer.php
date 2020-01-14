<?PHP
    use DynamicalWeb\HTML;
?>
<ul class="auth-footer">
    <li>
        <a href="https://intellivoid.info/">Intellivoid</a>
    </li>
    <li>
        <a href="https://intellivoid.info/privacy">Privacy</a>
    </li>
    <li>
        <a href="https://intellivoid.info/tos">Terms</a>
    </li>
    <li>
        <a href="https://intellivoid.info/contact">Contact us</a>
    </li>
    <li>
        <a data-toggle="modal" data-target="#change-language-dialog" href="#">
            <i class="mdi mdi-translate"></i>
        </a>
    </li>
</ul>
<p class="footer-text text-center">Copyright © 2017-<?PHP HTML::print(date('Y')); ?> Intellivoid. All rights reserved.</p>
<?PHP HTML::importSection('change_language_modal'); ?>