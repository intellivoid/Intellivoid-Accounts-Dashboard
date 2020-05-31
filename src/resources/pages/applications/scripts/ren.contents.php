<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;

    function render_items(array $items)
    {
        HTML::print("<div class=\"card-body no-gutter\">", false);
        foreach($items as $application)
        {
            ?>
            <div class="list-item">
                <div class="preview-image">
                    <img class="img-sm" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $application['public_app_id'], 'resource' => 'small'), true); ?>" alt="<?PHP HTML::print(TEXT_APPLICATION_VIEW_APPLICATION_ICON_ALT); ?>">
                </div>
                <div class="content">
                    <div class="d-flex align-items-center">
                        <a class="d-flex align-items-center" style="text-decoration: none;" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id']), true); ?>">
                            <h6 class="product-name text-black"><?PHP HTML::print($application['name']); ?></h6>
                            <small class="time ml-3 d-none d-sm-block">
                                <?PHP HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $application['creation_timestamp']), TEXT_APPLICATION_VIEW_CREATED_TIMESTAMP)); ?>
                            </small>
                        </a>
                        <?PHP
                            if($application['status'] !== ApplicationStatus::Suspended)
                            {
                                ?>
                                <div class="dropdown ml-auto">
                                    <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="dropdown-<?PHP HTML::print($application['last_updated_timestamp']); ?>"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-<?PHP HTML::print($application['last_updated_timestamp']); ?>">
                                        <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id']), true); ?>"><?PHP HTML::print(TEXT_APPLICATION_VIEW_OPTIONS_MANAGE_APPLICATION); ?></a>
                                        <?PHP
                                        if($application['status'] == ApplicationStatus::Active)
                                        {
                                            ?>
                                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id'], 'action' => 'disable_application', 'redirect' => 'applications'), true); ?>"><?PHP HTML::print(TEXT_APPLICATION_VIEW_OPTIONS_DISABLE_APPLICATION); ?></a>
                                            <?PHP
                                        }
                                        if($application['status'] == ApplicationStatus::Disabled)
                                        {
                                            ?>
                                            <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id'], 'action' => 'enable_application', 'redirect' => 'applications'), true); ?>"><?PHP HTML::print(TEXT_APPLICATION_VIEW_OPTIONS_ENABLE_APPLICATION); ?></a>
                                            <?PHP
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?PHP
                            }
                        ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="pl-0">
                            <?PHP
                                switch($application['status'])
                                {
                                    case ApplicationStatus::Active:
                                        HTML::print("<div class=\"badge badge-outline-success\">", false);
                                        HTML::print(TEXT_APPLICATION_VIEW_STATE_ACTIVE);
                                        HTML::print("</div>", false);
                                        break;

                                    case ApplicationStatus::Disabled:
                                        HTML::print("<div class=\"badge badge-outline-danger\">", false);
                                        HTML::print(TEXT_APPLICATION_VIEW_STATE_DISABLED);
                                        HTML::print("</div>", false);
                                        break;

                                    case ApplicationStatus::Suspended:
                                        HTML::print("<div class=\"badge badge-outline-warning\">", false);
                                        HTML::print(TEXT_APPLICATION_VIEW_STATE_SUSPENDED);
                                        HTML::print("</div>", false);
                                        break;
                                }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <?PHP
        }
        HTML::print("</div>", false);
    }