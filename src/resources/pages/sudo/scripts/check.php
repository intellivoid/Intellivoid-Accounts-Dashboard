<?php

    if(WEB_SUDO_MODE == true)
    {
        header('Location: /');
        exit();
    }