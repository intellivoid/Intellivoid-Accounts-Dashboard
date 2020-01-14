<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    if(DynamicalWeb::getInt32('total_items') > 50)
    {
        ?>
        <div class="card-footer">
            <div class="d-flex justify-content-between bd-highlight mb-3 pt-3">
                <?PHP
                    if(DynamicalWeb::getInt32('current_page') > 1)
                    {
                        $PreviousHref = DynamicalWeb::getRoute('login_history', array(
                            'page' => DynamicalWeb::getInt32('current_page') - 1
                        ));
                        ?>
                        <div class="p-2 bd-highlight">
                            <button class="btn btn-sm btn-primary" onclick="location.href='<?PHP HTML::print($PreviousHref); ?>'">
                                <i class="pl-2 mdi mdi-chevron-left"></i>
                            </button>
                        </div>
                        <?PHP
                    }
                    else
                    {
                        ?>
                        <div class="p-2 bd-highlight">
                            <button class="btn btn-sm btn-primary" aria-disabled="true" disabled>
                                <i class="pl-2 mdi mdi-chevron-left"></i>
                            </button>
                        </div>
                        <?PHP
                    }

                    if(DynamicalWeb::getInt32('current_page') < DynamicalWeb::getInt32('total_pages'))
                    {
                        $NextHref = DynamicalWeb::getRoute('login_history', array(
                            'page' => DynamicalWeb::getInt32('current_page') + 1
                        ));
                        ?>
                        <div class="p-2 bd-highlight">
                            <button class="btn btn-sm btn-primary" onclick="location.href='<?PHP HTML::print($NextHref); ?>'">
                                <i class="pl-2 mdi mdi-chevron-right"></i>
                            </button>
                        </div>
                        <?PHP
                    }
                    else
                    {
                        ?>
                        <div class="p-2 bd-highlight">
                            <button class="btn btn-sm btn-primary" aria-disabled="true" disabled>
                                <i class="pl-2 mdi mdi-chevron-right"></i>
                            </button>
                        </div>
                        <?PHP
                    }
                ?>
            </div>
        </div>
        <?PHP
    }