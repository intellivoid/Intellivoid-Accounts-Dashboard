<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('update.name');
    HTML::importScript('clear.name');
    HTML::importScript('update.birthday');
    HTML::importScript('clear.birthday');
    HTML::importScript('define.information');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts - Personal</title>
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
                                                <img class="rounded-circle img-fluid img-lg ml-5" data-toggle="modal" data-target="#change-avatar-dialog" src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="profile image">

                                                <div class="content-area">
                                                    <h3 class="mb-0 mx-5">Personal Information</h3>
                                                    <p class="mb-0 mx-5">You can edit what personal information is associated with your account here</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="alert-area" class="pt-4">
                                            <?PHP HTML::importScript('callbacks'); ?>
                                        </div>
                                        <div class="profile-body">
                                            <div class="row">

                                                <div class="col-md-6 d-flex align-items-stretch">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <h4>Name</h4>
                                                            <p class="text-muted">Your legal name</p>
                                                            <form action="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'update_name'), true) ?>" method="POST">
                                                                <div class="form-group">
                                                                    <label for="first_name">First Name</label>
                                                                    <input type="text"<?PHP HTML::print(USER_FIRST_NAME, false); ?> class="form-control border-primary" id="first_name" name="first_name" placeholder="John" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="last_name">Last Name</label>
                                                                    <input type="text"<?PHP HTML::print(USER_LAST_NAME, false); ?> class="form-control border-primary" id="last_name" name="last_name" placeholder="Smith" required>
                                                                </div>
                                                                <input type="submit" class="btn btn-success mr-2" value="Update">
                                                                <a class="btn btn-warning mr-2 text-white" onclick="location.href='<?PHP DynamicalWeb::getRoute('personal', array('action' => 'clear_name'), true) ?>';">Clear</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 grid-margin stretch-card">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <h4>Birthday</h4>
                                                            <p class="text-muted">When you were born</p>
                                                            <form action="<?PHP DynamicalWeb::getRoute('personal', array('action' => 'update_birthday'), true) ?>" method="POST">
                                                                <div class="form-group">
                                                                    <label for="dob_year">Year</label>
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
                                                                    <label for="dob_month">Month</label>
                                                                    <select class="form-control border-primary" id="dob_month" name="dob_month" required>
                                                                        <option value="1"<?PHP if(USER_BOD_MONTH == 1){ HTML::print("selected=\selected\"", false); } ?>>January</option>
                                                                        <option value="2"<?PHP if(USER_BOD_MONTH == 2){ HTML::print("selected=\selected\"", false); } ?>>February</option>
                                                                        <option value="3"<?PHP if(USER_BOD_MONTH == 3){ HTML::print("selected=\selected\"", false); } ?>>March</option>
                                                                        <option value="4"<?PHP if(USER_BOD_MONTH == 4){ HTML::print("selected=\selected\"", false); } ?>>April</option>
                                                                        <option value="5"<?PHP if(USER_BOD_MONTH == 5){ HTML::print("selected=\selected\"", false); } ?>>May</option>
                                                                        <option value="6"<?PHP if(USER_BOD_MONTH == 6){ HTML::print("selected=\selected\"", false); } ?>>June</option>
                                                                        <option value="7"<?PHP if(USER_BOD_MONTH == 7){ HTML::print("selected=\selected\"", false); } ?>>July</option>
                                                                        <option value="8"<?PHP if(USER_BOD_MONTH == 8){ HTML::print("selected=\selected\"", false); } ?>>Agust</option>
                                                                        <option value="9"<?PHP if(USER_BOD_MONTH == 9){ HTML::print("selected=\selected\"", false); } ?>>September</option>
                                                                        <option value="10<?PHP if(USER_BOD_MONTH == 10){ HTML::print("selected=\selected\"", false); } ?>">October</option>
                                                                        <option value="11"<?PHP if(USER_BOD_MONTH == 11){ HTML::print("selected=\selected\"", false); } ?>>November</option>
                                                                        <option value="12"<?PHP if(USER_BOD_MONTH == 12){ HTML::print("selected=\selected\"", false); } ?>>December</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dob_day">Day</label>
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
                                                                <button type="submit" class="btn btn-success mr-2">Update</button>
                                                                <a class="btn btn-warning mr-2 text-white" onclick="location.href='<?PHP DynamicalWeb::getRoute('personal', array('action' => 'clear_birthday'), true) ?>';">Clear</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">

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
