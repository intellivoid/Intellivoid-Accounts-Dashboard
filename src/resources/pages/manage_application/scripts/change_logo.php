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
    }
    catch (SystemException $e)
    {
    }
    catch (UnsupportedFileTypeException $e)
    {
    }
    catch(Exception $exception)
    {

    }


    try
    {
        $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->apply_avatar($file, $Application->PublicAppId);
    }
    catch (ImageTooSmallException $e)
    {
    }
    catch (InvalidImageException $e)
    {
    }
    catch (UnsupportedFileTypeException $e)
    {
    }


    Actions::redirect(DynamicalWeb::getRoute('manage_application', array(
        'pub_id' => $Application->PublicAppId
    )));