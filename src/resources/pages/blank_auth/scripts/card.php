<?php
    use DynamicalWeb\HTML;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 4px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }
?>
<div class="linear-activity">
    <div id="linear-spinner" class="indeterminate" hidden></div>
</div>
<div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
        <div class="card-title">
            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
            <h4 class="mb-0 auth-header">Register an Account</h4>
            <?PHP HTML::importScript('callbacks'); ?>
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <form action="#">
                <div class="form-group">
                    <label for="email" id="email_label" class="text-muted">Email</label>
                    <div class="position-relative has-icon-left">
                        <input type="email" id="email" class="form-control" autocomplete="email" name="email" placeholder="Email Address" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-mail"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" id="username_label" class="text-muted">Username</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" id="username" class="form-control" autocomplete="username" name="username" placeholder="Username" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" id="password_label" class="text-muted">Password</label>
                    <div class="position-relative has-icon-left">
                        <input type="password" id="password" class="form-control" autocomplete="new-password" name="password" placeholder="Password" required disabled>
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <fieldset class="checkbox">
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input name="tos_agree" id="tos_agree" type="checkbox" required disabled>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <label for="tos_agree" id="tos_agree_label" class="text-muted">I accept the terms of service.</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" disabled>
                    <span id="submit_label" hidden>Register</span>
                    <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                <span> Have an account?
                    <a href="#">Login</a>
                </span>
            </form>
        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>