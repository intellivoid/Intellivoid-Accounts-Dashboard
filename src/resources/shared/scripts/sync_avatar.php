<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;
    use udp\Exceptions\ImageTooSmallException;
    use udp\Exceptions\InvalidImageException;
    use udp\Exceptions\UnsupportedFileTypeException;

    Runtime::import('IntellivoidAccounts');

    if(defined('WEB_ACCOUNT_PUBID'))
    {
        if(WEB_ACCOUNT_PUBID !== null)
        {
            sync_avatar();
        }
    }

    /**
     * @throws ImageTooSmallException
     * @throws InvalidImageException
     * @throws UnsupportedFileTypeException
     */
    function sync_avatar()
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

        if($IntellivoidAccounts->getUdp()->getProfilePictureManager()->avatar_exists(WEB_ACCOUNT_PUBID) == false)
        {
            $IntellivoidAccounts->getUdp()->getProfilePictureManager()->generate_avatar(WEB_ACCOUNT_PUBID);
        }
    }