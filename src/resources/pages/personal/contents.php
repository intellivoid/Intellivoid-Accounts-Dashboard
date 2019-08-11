<?PHP
    use DynamicalWeb\HTML;

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
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
                                                <div class="content-area">
                                                    <h3 class="mb-0">
                                                        Personal Information
                                                    </h3>
                                                    <p class="mb-0">You can edit what personal information is associated with your account here</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile-body">
                                            <div class="row">

                                                <div class="col-md-6 d-flex align-items-stretch">
                                                    <div class="row flex-grow">
                                                        <div class="col-12 grid-margin">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Personal Information</h4>
                                                                    <p class="card-description text-muted"> Basic information about you </p>
                                                                    <form class="forms-sample">
                                                                        <div class="form-group">
                                                                            <label for="first_name">First Name</label>
                                                                            <input type="text" class="form-control border-primary" id="first_name" name="first_name" placeholder="John" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="last_name">Last Name</label>
                                                                            <input type="text" class="form-control border-primary" id="last_name" name="last_name" placeholder="Smith" required>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Birthday</h4>
                                                            <p class="card-description text-muted">
                                                                When you were born
                                                            </p>
                                                            <form class="forms-sample">
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
                                                                                HTML::print("<option value=\"" . $CurrentCount . "\">" . $CurrentCount . "</option>", false);
                                                                                $CurrentCount += 1;
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dob_month">Month</label>
                                                                    <select class="form-control border-primary" id="dob_month" name="dob_month" required>
                                                                        <option value="1">January</option>
                                                                        <option value="2">February</option>
                                                                        <option value="3">March</option>
                                                                        <option value="4">April</option>
                                                                        <option value="5">May</option>
                                                                        <option value="6">June</option>
                                                                        <option value="7">July</option>
                                                                        <option value="8">Agust</option>
                                                                        <option value="9">September</option>
                                                                        <option value="10">October</option>
                                                                        <option value="11">November</option>
                                                                        <option value="12">December</option>
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
                                                                            HTML::print("<option value=\"" . $CurrentCount . "\">" . $CurrentCount . "</option>", false);
                                                                            $CurrentCount += 1;
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-success mr-2">Update</button>
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
