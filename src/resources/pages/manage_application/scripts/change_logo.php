<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
use udp\Exceptions\FileUploadException;
use udp\Exceptions\ImageTooSmallException;
use udp\Exceptions\InvalidImageException;
use udp\Exceptions\SystemException;
use udp\Exceptions\UnsupportedFileTypeException;

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");


    try
    {
        $file = $IntellivoidAccounts->getAppUdp()->getTemporaryFileManager()->accept_upload();
    }
    catch (FileUploadException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '101'))
        );
    }
    catch (SystemException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '102'))
        );
    }
    catch (UnsupportedFileTypeException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '103'))
        );
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '100'))
        );

    }


    try
    {
        $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->apply_avatar($file, $Application->PublicAppId);
    }
    catch (ImageTooSmallException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '104'))
        );
    }
    catch (InvalidImageException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '105'))
        );
    }
    catch (UnsupportedFileTypeException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '103'))
        );
    }


    Actions::redirect(DynamicalWeb::getRoute('manage_application', array(
        'pub_id' => $Application->PublicAppId,
        'callback' => '112',
        'cache_refresh' => 'true'
    )));