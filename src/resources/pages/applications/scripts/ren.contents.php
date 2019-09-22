<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;

    function render_items(array $items)
    {
        //HTML::print("<div class=\"row\">", false);
        HTML::print("<div class=\"card-body no-gutter\">", false);
        foreach($items as $application)
        {
            ?>
            <div class="list-item">
                <div class="preview-image">
                    <img class="img-sm" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $application['public_app_id'], 'resource' => 'small'), true); ?>" alt="profile image">
                </div>
                <div class="content">
                    <div class="d-flex align-items-center">
                        <h6 class="product-name"><?PHP HTML::print($application['name']); ?></h6>
                        <small class="time ml-3 d-none d-sm-block">
                            <?PHP HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $application['creation_timestamp']), "Created at %s")); ?>
                        </small>
                        <div class="dropdown ml-auto">
                            <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="dropdown-<?PHP HTML::print($application['last_updated_timestamp']); ?>"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-<?PHP HTML::print($application['last_updated_timestamp']); ?>">
                                <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $application['public_app_id']), true); ?>">Manage Application</a>
                                <a class="dropdown-item" href="#">Disable</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="pl-0">
                            <div class="badge badge-outline-success">Active</div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP
        }
        HTML::print("</div>", false);
        //HTML::print("</div>", false);
    }