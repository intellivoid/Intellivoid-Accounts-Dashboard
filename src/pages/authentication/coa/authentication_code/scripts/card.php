<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationFlags;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 3px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var AuthenticationAccess $AuthenticationAccess */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('access_token');

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    $ApplicationNameSafe = ucfirst($Application->Name);
    if(strlen($ApplicationNameSafe) > 16)
    {
        $ApplicationNameSafe = substr($ApplicationNameSafe, 0 ,16);
        $ApplicationNameSafe .= "...";
    }

?>
<div class="linear-activity">
    <div id="linear-spinner" class="indeterminate-none"></div>
</div>
<div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
        <div class="card-title">
            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <div class="d-flex mb-1">
                <div class="image-grouped mx-auto d-block">
                    <ul class="list-unstyled users-list d-flex">
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($UsernameSafe); ?>" class="avatar ml-0">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print($UsernameSafe); ?>" height="64" width="64">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($ApplicationNameSafe); ?>" class="avatar">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print($ApplicationNameSafe); ?>" height="64" width="64">
                        </li>
                    </ul>
                </div>
            </div>
            <h4 class="text-center">
                <?PHP HTML::print($Application->Name); ?>
                <?PHP
                if(in_array(ApplicationFlags::Verified, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_VERIFIED . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Official, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_OFFICIAL . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-alert-octagon text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_UNTRUSTED . "\"></i>", false);
                }
                ?>
            </h4>
            <div class="border-bottom mt-2"></div>
            <p class="pt-2"><?PHP HTML::print(TEXT_HEADER_TEXT); ?></p>
            <div class="form-group">
                <label for="access_token" class="label"><?PHP HTML::print(TEXT_ACCESS_TOKEN_LABEL); ?></label>
                <input name="access_token" id="access_token" type="text" class="form-control bg-white" value="<?PHP HTML::print($AuthenticationAccess->AccessToken); ?>" readonly>
            </div>
            <div class="form-group mb-0">
                <button id="submit_button" onclick="if(window.opener != null){window.close();}else{location.href='<?PHP DynamicalWeb::getRoute('index', array(), true); ?>'}" class="btn btn-primary btn-block"><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
            </div>

        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>