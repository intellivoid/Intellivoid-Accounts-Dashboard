<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use udp\Exceptions\FileUploadException;
    use udp\Exceptions\ImageTooSmallException;
    use udp\Exceptions\InvalidImageException;
    use udp\Exceptions\SystemException;
    use udp\Exceptions\UnsupportedFileTypeException;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'change_avatar')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                change_avatar();
            }
        }
    }

    function change_avatar()
    {
        if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
                "intellivoid_accounts", new IntellivoidAccounts()
            );
        }
        else
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        }

        try
        {
            $file = $IntellivoidAccounts->getUdp()->getTemporaryFileManager()->accept_upload();
        }
        catch (FileUploadException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '105'))
            );
        }
        catch (SystemException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '106'))
            );
        }
        catch (UnsupportedFileTypeException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '107'))
            );
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '100'))
            );

        }


        try
        {
            $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->apply_avatar($file, $Application->PublicAppId);
        }
        catch (ImageTooSmallException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '108'))
            );
        }
        catch (InvalidImageException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_application',
                array('callback' => '109'))
            );
        }
        catch (UnsupportedFileTypeException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_application',
                array('callback' => '107'))
            );
        }

        Actions::redirect(DynamicalWeb::getRoute('index', array(
            'callback' => '110',
            'cache_refresh' => 'true'
        )));
    }