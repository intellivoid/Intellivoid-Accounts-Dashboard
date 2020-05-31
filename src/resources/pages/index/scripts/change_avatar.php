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
        $RedirectToSettings = false;

        if(isset($_GET['redirect']))
        {
            if($_GET['redirect'] == 'settings_user')
            {
                $RedirectToSettings = true;
            }
        }

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
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '110'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '105'))
            );
        }
        catch (SystemException $e)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '111'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '106'))
            );
        }
        catch (UnsupportedFileTypeException $e)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '112'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '107'))
            );
        }
        catch(Exception $exception)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '100'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '100'))
            );

        }


        try
        {
            $IntellivoidAccounts->getUdp()->getProfilePictureManager()->apply_avatar($file, WEB_ACCOUNT_PUBID);
        }
        catch (ImageTooSmallException $e)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '113'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('index',
                array('callback' => '108'))
            );
        }
        catch (InvalidImageException $e)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user',
                    array('callback' => '114'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('manage_application',
                array('callback' => '109'))
            );
        }
        catch (UnsupportedFileTypeException $e)
        {
            if($RedirectToSettings)
            {
                Actions::redirect(DynamicalWeb::getRoute('personal',
                    array('callback' => '112'))
                );
            }

            Actions::redirect(DynamicalWeb::getRoute('manage_application',
                array('callback' => '107'))
            );
        }

        if($RedirectToSettings)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user',
                array('callback' => '115', 'cache_refresh' => 'true'))
            );
        }

        Actions::redirect(DynamicalWeb::getRoute('index', array(
            'callback' => '110',
            'cache_refresh' => 'true'
        )));
    }