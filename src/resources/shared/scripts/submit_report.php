<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use Support\Support;
    use Support\Utilities\Validation;

    Runtime::import('Support');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'submit_feedback')
            {
                if(isset($_POST['feedback_message']) == false)
                {
                    Actions::redirect(DynamicalWeb::getRoute(
                        'index', array('callback' => '111')
                    ));
                }

                submit_report();
            }
        }
    }

    function submit_report()
    {
        if(Validation::message($_POST['feedback_message']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '112')
            ));
        }

        $IntellivoidSupport = new Support();

        try
        {
            $IntellivoidSupport->getTicketManager()->submitTicket(
                'Intellivoid Accounts', "Intellivoid Accounts Feedback", $_POST['feedback_message'], WEB_ACCOUNT_EMAIL
            );
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '111', 'type' => 'internal')
            ));
        }

        Actions::redirect(DynamicalWeb::getRoute(
            'index', array('callback' => '113')
        ));
    }