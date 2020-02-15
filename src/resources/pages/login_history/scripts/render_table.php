<?php
    use DynamicalWeb\HTML;
?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?PHP HTML::print(TEXT_TABLE_HEADERS_ORIGIN); ?></th>
                <th><?PHP HTML::print(TEXT_TABLE_HEADERS_BROWSER); ?></th>
                <th><?PHP HTML::print(TEXT_TABLE_HEADERS_IP_ADDRESS); ?></th>
                <th><?PHP HTML::print(TEXT_TABLE_HEADERS_STATUS); ?></th>
                <th><?PHP HTML::print(TEXT_TABLE_HEADERS_DATE); ?></th>
            </tr>
        </thead>
        <tbody>
            <?PHP HTML::importScript('render_table_items'); ?>
        </tbody>
    </table>
</div>

