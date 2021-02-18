<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

    if(WEB_SUDO_MODE == true)
    {
        Actions::redirect(DynamicalWeb::getRoute('index'));
    }