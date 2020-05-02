<?php
    use DynamicalWeb\DynamicalWeb;
?>
<span class="float-left">
    <a data-toggle="modal" data-target="#change-language-dialog" href="#">
        <i class="feather icon-globe"></i>
    </a>
</span>
<span class="float-right">
    <a href="<?PHP DynamicalWeb::getRoute('tos', [], true); ?>" class="card-link">Terms of Service
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="<?PHP DynamicalWeb::getRoute('privacy', [], true); ?>" class="card-link">Privacy
        <i class="fa fa-angle-right"></i>
    </a>
</span>