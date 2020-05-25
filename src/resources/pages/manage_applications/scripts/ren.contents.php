<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;

    function render_items(array $items)
    {
        HTML::print("<div class=\"card-body p-50\">", false);
        foreach($items as $application)
        {
            ?>
            <div class="d-flex justify-content-start align-items-center my-75">
                <div class="avatar mr-75">
                    <img src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $application['public_app_id'], 'resource' => 'normal'), true); ?>" alt="<?PHP HTML::print($application['name']); ?>" height="40" width="40">
                </div>
                <div class="user-page-info">
                    <a class="d-flex text-primary" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id']), true); ?>">
                        <h6 class="mb-25"><?PHP HTML::print($application['name']); ?></h6>
                    </a>
                    <span class="font-small-2 d-none d-md-inline"><?PHP HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $application['creation_timestamp']), TEXT_APPLICATION_VIEW_CREATED_TIMESTAMP)); ?></span>
                </div>
                <div class="ml-auto cursor-pointer">
                    <?PHP
                        switch($application['status'])
                        {
                            case ApplicationStatus::Active:
                                HTML::print("<div class=\"badge bg-gradient-primary font-small-2 mr-50 d-none d-md-inline\">", false);
                                HTML::print(TEXT_APPLICATION_VIEW_STATE_ACTIVE);
                                HTML::print("</div>", false);
                                break;

                            case ApplicationStatus::Disabled:
                                HTML::print("<div class=\"badge bg-gradient-danger font-small-2 mr-50\">", false);
                                HTML::print(TEXT_APPLICATION_VIEW_STATE_DISABLED);
                                HTML::print("</div>", false);
                                break;

                            case ApplicationStatus::Suspended:
                                HTML::print("<div class=\"badge bg-gradient-warning font-small-2 mr-50\">", false);
                                HTML::print(TEXT_APPLICATION_VIEW_STATE_SUSPENDED);
                                HTML::print("</div>", false);
                                break;
                        }
                    ?>
                    <?PHP
                        if($application['status'] == ApplicationStatus::Active)
                        {
                            ?>
                            <a href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id'], 'action' => 'disable_application', 'redirect' => 'manage_applications'), true); ?>">
                                <i class="feather icon-cloud-off mr-50"></i>
                            </a>
                            <?PHP
                        }
                        if($application['status'] == ApplicationStatus::Disabled)
                        {
                            ?>
                            <a href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id'], 'action' => 'enable_application', 'redirect' => 'manage_applications'), true); ?>">
                                <i class="feather icon-cloud mr-50"></i>
                            </a>
                            <?PHP
                        }
                    ?>
                    <a href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id']), true); ?>">
                        <i class="feather icon-edit"></i>
                    </a>
                </div>
            </div>
            <?PHP
        }
        HTML::print("</div>", false);
    }