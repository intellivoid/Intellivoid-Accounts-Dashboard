<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

    HTML::importScript('check_application');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            switch($_GET['action'])
            {
                case 'change-logo':
                   HTML::importScript('change_logo');
                   break;
            }
        }
    }

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">

                        <div class="row">
                            <div class="col-md-4 d-flex align-items-stretch">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'change-logo'), true); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="d-flex align-items-start pb-3 border-bottom">
                                                        <img class="img-md" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="brand logo">

                                                        <div class="wrapper pl-4">
                                                            <p class="font-weight-bold mb-0"><?PHP HTML::print($Application->Name); ?></p>
                                                            <label class="btn btn-inverse-light btn-xs mt-2" for="file-selector" onchange="this.form.submit();">
                                                                <input id="file-selector" name="user_av_file" type="file" class="d-none">
                                                                Change Logo
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-block btn-danger mt-3">Disable Application</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Input size</h4>
                                        <p class="card-description"> This is the default bootstrap form layout </p>
                                        <div class="form-group">
                                            <label>Large input</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username"> </div>
                                        <div class="form-group">
                                            <label>Default input</label>
                                            <input type="text" class="form-control" placeholder="Username" aria-label="Username"> </div>
                                        <div class="form-group">
                                            <label>Small input</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username"> </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">Selectize</h4>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Large select</label>
                                            <select class="form-control form-control-lg" id="exampleFormControlSelect1">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">Default select</label>
                                            <select class="form-control" id="exampleFormControlSelect2">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect3">Small select</label>
                                            <select class="form-control form-control-sm" id="exampleFormControlSelect3">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
