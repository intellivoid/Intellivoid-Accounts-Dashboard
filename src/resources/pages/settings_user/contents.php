<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('clear.name');
    HTML::importScript('clear.birthday');
    HTML::importScript('update');
    HTML::importScript('define.information');

?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE) ?></title>
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
                            <div class="col-md-4 col-lg-3 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8 col-lg-9" id="settings_viewer">
                                <div class="card">
                                    <form method="POST" action="<?PHP DynamicalWeb::getRoute('settings_user', array('action' => 'update'), true); ?>">
                                        <div class="card-header">
                                            <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
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
                                                            <button class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light" data-toggle="modal" type="button" data-target="#change-avatar-dialog">
                                                                <?PHP HTML::print(TEXT_CHANGE_AVATAR_BUTTON); ?>
                                                            </button>
                                                        </div>
                                                        <p class="text-muted ml-75 mt-50">
                                                            <small><?PHP HTML::print(TEXT_CHANGE_AVATAR_HINT) ?></small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr/>

                                                <!-- Personal Information -->
                                                <div class="row">

                                                        <!-- Email Address -->
                                                        <div class="col-12 mb-1">
                                                            <label for="email"><?PHP HTML::print(TEXT_EMAIL_ADDRESS_LABEL); ?></label>
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
                                                                <h5><?PHP HTML::print(TEXT_LEGAL_NAME_LABEL); ?></h5>
                                                                <?PHP
                                                                    if(USER_NAME_SET)
                                                                    {
                                                                        ?>
                                                                        <a href="<?PHP DynamicalWeb::getRoute('settings_user', array('action' => 'clear_name'), true) ?>" class="text-muted font-small-3">
                                                                            <i class="feather icon-delete pr-25"></i>
                                                                            <?PHP HTML::print(TEXT_CLEAR_ACTION_HINT); ?>
                                                                        </a>
                                                                        <?PHP
                                                                    }
                                                                ?>

                                                            </div>

                                                            <div class="row">

                                                                <!-- First Name -->
                                                                <div class="col-6">
                                                                    <label for="first_name"><?PHP HTML::print(TEXT_FIRST_NAME_LABEL); ?></label>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input id="first_name" name="first_name" autocomplete="given-name" type="text" class="form-control" placeholder="John" <?PHP HTML::print(USER_FIRST_NAME, false); ?>>
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-user"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>

                                                                <!-- Last Name -->
                                                                <div class="col-6">
                                                                    <label for="last_name"><?PHP HTML::print(TEXT_LAST_NAME_LABEL); ?></label>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input id="last_name" name="last_name" autocomplete="family-name" type="text" class="form-control" placeholder="Doe" <?PHP HTML::print(USER_LAST_NAME, false); ?>>
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
                                                                <h5>Birthday</h5>
                                                                <?PHP
                                                                    if(USER_BOD_SET)
                                                                    {
                                                                        ?>
                                                                        <a href="<?PHP DynamicalWeb::getRoute('settings_user', array('action' => 'clear_birthday'), true) ?>" class="text-muted font-small-3">
                                                                            <i class="feather icon-delete pr-25"></i>
                                                                            <?PHP HTML::print(TEXT_CLEAR_ACTION_HINT); ?>
                                                                        </a>
                                                                        <?PHP
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="row">

                                                                <!-- Year -->
                                                                <div class="col-4">
                                                                    <label for="dob_year"><?PHP HTML::print(TEXT_DOB_YEAR_LABEL); ?></label>
                                                                    <fieldset class="form-group">
                                                                        <select class="form-control" id="dob_year" autocomplete="bday-year" name="dob_year">
                                                                            <?PHP
                                                                                if(USER_BOD_YEAR == "")
                                                                                {
                                                                                    HTML::print("<option value=\"None\" selected=\"selected\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }
                                                                                else
                                                                                {
                                                                                    HTML::print("<option value=\"None\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }

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
                                                                    <label for="dob_month"><?PHP HTML::print(TEXT_DOB_MONTH_LABEL); ?></label>
                                                                    <fieldset class="form-group">
                                                                        <select class="form-control" id="dob_month" autocomplete="bday-month" name="dob_month">
                                                                            <?php
                                                                                if(USER_BOD_MONTH == "")
                                                                                {
                                                                                    HTML::print("<option value=\"None\" selected=\"selected\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }
                                                                                else
                                                                                {
                                                                                    HTML::print("<option value=\"None\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }
                                                                            ?>
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
                                                                    <label for="dob_day"><?PHP HTML::print(TEXT_DOB_DAY_LABEL); ?></label>
                                                                    <fieldset class="form-group">
                                                                        <select class="form-control" id="dob_day" autocomplete="bday-day" name="dob_day">
                                                                            <?PHP
                                                                                if(USER_BOD_DAY == "")
                                                                                {
                                                                                    HTML::print("<option value=\"None\" selected=\"selected\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }
                                                                                else
                                                                                {
                                                                                    HTML::print("<option value=\"None\">" . TEXT_DEFAULT_VALUE . "</option>", false);
                                                                                }

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

                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <span class="float-right">
                                                <button type="submit" class="btn btn-primary mb-1"><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
                                            </span>
                                        </div>
                                    </form>
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