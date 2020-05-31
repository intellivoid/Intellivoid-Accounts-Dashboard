<?php

    if(isset($_GET['expanded']))
    {
        if($_GET['expanded'] == "1")
        {
            define("UI_EXPANDED", true);
        }
        else
        {
            define("UI_EXPANDED", false);
        }
    }
    else
    {
        define("UI_EXPANDED", false);
    }