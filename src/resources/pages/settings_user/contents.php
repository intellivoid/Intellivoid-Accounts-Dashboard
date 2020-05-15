<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('clear.name');
    HTML::importScript('clear.birthday');
    HTML::importScript('define.information');

?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title>General Settings</title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <?PHP HTML::importScript('callbacks'); ?>
                    <section id="account_settings">
                        <div class="row">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Account Information</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Intellivoid Avatar -->
                                            <div class="media">
                                                <a href="javascript: void(0);">
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
                                                    <img class="rounded mr-75" height="64" width="64" data-toggle="modal" data-target="#change-avatar-dialog" src="<?PHP DynamicalWeb::getRoute('avatar', $img_parameters, true) ?>" alt="profile image">
                                                </a>
                                                <div class="media-body mt-75">
                                                    <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                        <button class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light"data-toggle="modal" data-target="#change-avatar-dialog">
                                                            Change Avatar
                                                        </button>
                                                    </div>
                                                    <p class="text-muted ml-75 mt-50">
                                                        <small>Supported formats are JPEG and PNG</small>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr/>

                                            <!-- Personal Information -->
                                            <form>
                                                <div class="row">

                                                    <!-- Email Address -->
                                                    <div class="col-12 mb-1">
                                                        <label for="email">Personal Email Address</label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input id="email" name="email" autocomplete="email" type="email" class="form-control" placeholder="johndoe@intellivoid.net" <?PHP HTML::print(USER_EMAIL, false); ?> required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-mail"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <!-- Name -->
                                                    <div class="col-12 mb-1">
                                                        <div class="mb-1">
                                                            <h5 class="">Legal Name</h5>
                                                            <?PHP
                                                                if(USER_NAME_SET)
                                                                {
                                                                    ?>
                                                                    <a href="<?PHP DynamicalWeb::getRoute('settings_user', array('action' => 'clear_name'), true) ?>" class="text-muted font-small-3">
                                                                        <i class="feather icon-delete pr-25"></i>Clear
                                                                    </a>
                                                                    <?PHP
                                                                }
                                                            ?>

                                                        </div>

                                                        <div class="row">

                                                            <!-- First Name -->
                                                            <div class="col-6">
                                                                <label for="first_name">First Name</label>
                                                                <fieldset class="form-group position-relative has-icon-left">
                                                                    <input id="first_name" name="first_name" autocomplete="given-name" type="text" class="form-control" placeholder="John" <?PHP HTML::print(USER_FIRST_NAME, false); ?>>
                                                                    <div class="form-control-position">
                                                                        <i class="feather icon-user"></i>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <!-- Last Name -->
                                                            <div class="col-6">
                                                                <label for="last_name">Last Name</label>
                                                                <fieldset class="form-group position-relative has-icon-left">
                                                                    <input id="last_name" name="last_name" autocomplete="family-name" type="text" class="form-control" placeholder="Doe" <?PHP HTML::print(USER_LAST_NAME, false); ?> required>
                                                                    <div class="form-control-position">
                                                                        <i class="feather icon-user"></i>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Birthday -->
                                                    <div class="col-12">
                                                        <div class="mb-1">
                                                            <h5 class="">Birthday</h5>
                                                            <?PHP
                                                                if(USER_BOD_SET)
                                                                {
                                                                    ?>
                                                                    <a href="<?PHP DynamicalWeb::getRoute('settings_user', array('action' => 'clear_birthday'), true) ?>" class="text-muted font-small-3">
                                                                        <i class="feather icon-delete pr-25"></i>Clear
                                                                    </a>
                                                                    <?PHP
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="row">

                                                            <!-- Year -->
                                                            <div class="col-4">
                                                                <label for="dob_year">Year</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" id="dob_year" name="dob_year">
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
                                                                </fieldset>
                                                            </div>

                                                            <!-- Month -->
                                                            <div class="col-4">
                                                                <label for="dob_month">Month</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" id="dob_month" name="dob_month">
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
                                                                </fieldset>
                                                            </div>

                                                            <!-- Day -->
                                                            <div class="col-4">
                                                                <label for="dob_day">Day</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" id="dob_day" name="dob_day">
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
                                                                </fieldset>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <span class="float-right">
                                            <button class="btn btn-primary">Update</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>