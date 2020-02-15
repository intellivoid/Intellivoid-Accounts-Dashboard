<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('update.name');
    HTML::importScript('clear.name');
    HTML::importScript('update.birthday');
    HTML::importScript('update.email');
    HTML::importScript('clear.birthday');
    HTML::importScript('define.information');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <div class="row profile-page">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="profile-header text-white">
                                            <div class="d-flex justify-content-around">
                                                <?PHP
                                                    $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal');
                                                    if(isset($_GET['cache_refresh']))
                                                    {
                                                        if($_GET['cache_refresh'] == 'true')
                                                        {
                                                            $img_parameters = array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal', 'cache_refresh' => hash('sha256', time() . 'CACHE'));
                                                        }
                                                    }
                                                ?>
                                                <img class="rounded-circle img-fluid img-lg ml-5" data-toggle="modal" data-target="#change-avatar-dialog" src="<?PHP DynamicalWeb::getRoute('avatar', $img_parameters, true) ?>" alt="profile image">

                                                <div class="content-area">
                                                    <h3 class="mb-0 mx-5"><?PHP HTML::print(TEXT_BANNER_HEADER); ?></h3>
                                                    <p class="mb-0 mx-5"><?PHP HTML::print(TEXT_BANNER_SUB_HEADER); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="alert-area" class="pt-4">
                                            <?PHP HTML::importScript('callbacks'); ?>
                                        </div>
                                        <div class="profile-body">
                                            <div class="row">
                                                <div class="col-md-12 d-flex align-items-stretch">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <div class="d-flex mb-0">
                                                                <h4><?PHP HTML::print(TEXT_EMAIL_ADDRESS_HEADER); ?></h4>
                                                            </div>
                                                            <form action="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'update_email'), true) ?>" method="POST">
                                                                <div class="input-group mb-3">
                                                                    <input type="email"<?PHP HTML::print(USER_EMAIL, false); ?> aria-label="Email Address" class="form-control border-primary" id="email_address" name="email_address" placeholder="example@intellivoid.info" required>
                                                                    <div class="input-group-append">
                                                                        <input type="submit" class="btn btn-success ml-3" value="<?PHP HTML::print(TEXT_UPDATE_BUTTON); ?>">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border-top"></div>
                                            <div class="row mt-4">
                                                <div class="col-md-6 d-flex align-items-stretch">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <div class="d-flex mb-0">
                                                                <h4>Name</h4>
                                                                <div class="ml-auto mr-3 mt-auto mb-0">
                                                                    <a class="text-muted" href="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'clear_name'), true) ?>">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted"><?PHP HTML::print(TEXT_LEGAL_NAME_HEADER); ?></p>
                                                            <form action="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'update_name'), true) ?>" method="POST">
                                                                <div class="form-group">
                                                                    <label for="first_name"><?PHP HTML::print(TEXT_LEGAL_NAME_FIRST_NAME_LABEL); ?></label>
                                                                    <input type="text"<?PHP HTML::print(USER_FIRST_NAME, false); ?> class="form-control border-primary" id="first_name" name="first_name" placeholder="John" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="last_name"><?PHP HTML::print(TEXT_LEGAL_NAME_LAST_NAME_LABEL); ?></label>
                                                                    <input type="text"<?PHP HTML::print(USER_LAST_NAME, false); ?> class="form-control border-primary" id="last_name" name="last_name" placeholder="Smith" required>
                                                                </div>
                                                                <input type="submit" class="btn btn-success mr-2" value="<?PHP HTML::print(TEXT_UPDATE_BUTTON); ?>">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 grid-margin stretch-card">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <div class="d-flex mb-0">
                                                                <h4><?PHP HTML::print(TEXT_BIRTHDAY_HEADER); ?></h4>
                                                                <div class="ml-auto mr-3 mt-auto mb-0">
                                                                    <a class="text-muted" href="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'clear_birthday'), true) ?>">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted"><?PHP HTML::print(TEXT_BIRTHDAY_SUB_HEADER); ?></p>
                                                            <form action="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'update_birthday'), true) ?>" method="POST">
                                                                <div class="form-group">
                                                                    <label for="dob_year"><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_LABEL); ?></label>
                                                                    <select class="form-control border-primary" id="dob_year" name="dob_year" required>
                                                                        <?PHP
                                                                        $FirstYear = 1970;
                                                                        $CurrentYear = (int)date('Y') - 13;
                                                                        $CurrentCount = $FirstYear;

                                                                        while(true)
                                                                        {
                                                                            if($CurrentCount > $CurrentYear)
                                                                            {
                                                                                break;
                                                                            }
                                                                            if(USER_BOD_YEAR == $CurrentCount)
                                                                            {
                                                                                HTML::print("<option value=\"" . $CurrentCount . "\" selected=\"selected\">" . $CurrentCount . "</option>", false);
                                                                            }
                                                                            else
                                                                            {
                                                                                HTML::print("<option value=\"" . $CurrentCount . "\">" . $CurrentCount . "</option>", false);
                                                                            }
                                                                            $CurrentCount += 1;
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dob_month"><?PHP HTML::print(TEXT_BIRTHDAY_MONTH_LABEL); ?></label>
                                                                    <select class="form-control border-primary" id="dob_month" name="dob_month" required>
                                                                        <option value="1"<?PHP if(USER_BOD_MONTH == 1){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_01); ?></option>
                                                                        <option value="2"<?PHP if(USER_BOD_MONTH == 2){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_02); ?></option>
                                                                        <option value="3"<?PHP if(USER_BOD_MONTH == 3){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_03); ?></option>
                                                                        <option value="4"<?PHP if(USER_BOD_MONTH == 4){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_04); ?></option>
                                                                        <option value="5"<?PHP if(USER_BOD_MONTH == 5){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_05); ?></option>
                                                                        <option value="6"<?PHP if(USER_BOD_MONTH == 6){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_06); ?></option>
                                                                        <option value="7"<?PHP if(USER_BOD_MONTH == 7){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_07); ?></option>
                                                                        <option value="8"<?PHP if(USER_BOD_MONTH == 8){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_08); ?></option>
                                                                        <option value="9"<?PHP if(USER_BOD_MONTH == 9){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_09); ?></option>
                                                                        <option value="10<?PHP if(USER_BOD_MONTH == 10){ HTML::print("selected=\selected\"", false); } ?>"><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_10); ?></option>
                                                                        <option value="11"<?PHP if(USER_BOD_MONTH == 11){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_11); ?></option>
                                                                        <option value="12"<?PHP if(USER_BOD_MONTH == 12){ HTML::print("selected=\selected\"", false); } ?>><?PHP HTML::print(TEXT_BIRTHDAY_YEAR_12); ?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dob_day"><?PHP HTML::print(TEXT_BIRTHDAY_DAY_LABEL); ?></label>
                                                                    <select class="form-control border-primary" id="dob_day" name="dob_day" required>
                                                                        <?PHP
                                                                        $FirstDay = 1;
                                                                        $MaxDay = 31;
                                                                        $CurrentCount = $FirstDay;

                                                                        while(true)
                                                                        {
                                                                            if($CurrentCount > $MaxDay)
                                                                            {
                                                                                break;
                                                                            }
                                                                            if(USER_BOD_DAY == $CurrentCount)
                                                                            {
                                                                                HTML::print("<option value=\"" . $CurrentCount . "\"  selected=\"selected\">" . $CurrentCount . "</option>", false);
                                                                            }
                                                                            else
                                                                            {
                                                                                HTML::print("<option value=\"" . $CurrentCount . "\">" . $CurrentCount . "</option>", false);
                                                                            }
                                                                            $CurrentCount += 1;
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-success mr-2"><?PHP HTML::print(TEXT_UPDATE_BUTTON); ?></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
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
