<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'process_payment')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                process_payment();
            }
        }
    }

    function process_payment()
    {
        if(isset($_POST['amount']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('index'));
        }

        switch($_POST['amount'])
        {
            case 'FLLNCMMRHFT4E':
            case 'NN3U3ZKFN9NSG':
            case 'GC4AXGEBKH4HY':
            case '7C7KBDN8QUAR2':
            case 'FZJGN4HRS4D6E':
            case 'YLUR4PWD88FJ8':
                Actions::redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=' . $_POST['amount']);
                break;

            default:
                Actions::redirect(DynamicalWeb::getRoute('index'));
        }
    }