<?php

    if(isset($_GET['require_close']))
    {
        if($_GET['require_close'] == "1")
        {
            define("REQUIRE_CLOSE_WINDOW", true);
        }
        else
        {
            define("REQUIRE_CLOSE_WINDOW", false);
        }
    }
    else
    {
        define("REQUIRE_CLOSE_WINDOW", false);
    }