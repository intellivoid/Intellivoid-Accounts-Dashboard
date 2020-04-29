<?php
    use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('mayax_dashboard_headers'); ?>
        <title>Blank Page</title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns  navbar-sticky fixed-footer  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <div class="content-overlay"></div>
        <?PHP HTML::importSection('mayax_dashboard_nav'); ?>

        <div class="horizontal-menu-wrapper">
            <div class="header-navbar navbar-expand-sm navbar navbar-horizontal fixed-top navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mr-auto"><a class="navbar-brand" href="../../../html/ltr/horizontal-menu-template/index.html">
                                <div class="brand-logo"></div>
                                <h2 class="brand-text mb-0">Vuexy</h2>
                            </a></li>
                        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
                    </ul>
                </div>
                <!-- Horizontal menu content-->
                <div class="navbar-container main-menu-content" data-menu="menu-container">
                    <!-- include ../../../includes/mixins-->
                    <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                        <li class="nav-item"><a class="nav-link" href="../../../html/ltr/horizontal-menu-template/index.html"><i class="feather icon-home"></i><span data-i18n="Dashboard">Dashboard</span></a></li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="feather icon-zap"></i><span data-i18n="Starter kit">Starter kit</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="sk-layout-2-columns.html" data-toggle="dropdown" data-i18n="2 columns">2 columns</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="sk-layout-fixed-navbar.html" data-toggle="dropdown" data-i18n="Fixed navbar">Fixed navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="sk-layout-floating-navbar.html" data-toggle="dropdown" data-i18n="Floating navbar">Floating navbar</a>
                                </li>
                                <li class="active" data-menu=""><a class="dropdown-item" href="sk-layout-fixed.html" data-toggle="dropdown" data-i18n="Fixed layout">Fixed layout</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="https://pixinvent.ticksy.com/"><i class="feather icon-life-buoy"></i><span>Raise Support</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation"><i class="feather icon-folder"></i><span>Documentation</span></a></li>
                    </ul>
                </div>
                <!-- /horizontal menu content-->
            </div>
        </div>
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-left mb-0">Fixed Layout</h2>
                                <div class="breadcrumb-wrapper col-12">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="sk-layout-2-columns.html">Home</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#">Starter Kit</a>
                                        </li>
                                        <li class="breadcrumb-item active">Fixed Layout
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                        <div class="form-group breadcrum-right">
                            <div class="dropdown">
                                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Description -->
                    <section id="description" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Description</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>The fixed layout has a fixed navbar, navigation menu and footer only content section is scrollable to user. In this page you can experience it. Fixed layout provide seamless UI on different screens.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--/ Description -->
                    <!-- CSS Classes -->
                    <section id="css-classes" class="card">
                        <div class="card-header">
                            <h4 class="card-title">CSS Classes</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>This table contains all classes related to the fixed layout. This is a custom layout classes for fixed layout page requirements.</p>
                                    <p>All these options can be set via following classes:</p>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Classes</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row"><code>.navbar-sticky</code></th>
                                                <td>To set navbar fixed you need to add <code>navbar-sticky</code> class in <code>&lt;body&gt;</code> tag.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><code>.fixed-top</code></th>
                                                <td>To set navbar fixed you need to add <code>fixed-top</code> class in <code>&lt;nav&gt;</code> tag.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><code>.menu-fixed</code></th>
                                                <td>To set the main navigation fixed on page <code>menu-fixed</code> class needs to add in navigation wrapper.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><code>.fixed-footer</code></th>
                                                <td>To set the main footer fixed on page <code>fixed-footer</code> class needs to add in <code>&lt;body&gt;</code> tag.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="html-markup" class="card">
                        <div class="card-header">
                            <h4 class="card-title">HTML Markup</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>This section contains HTML Markup to create fixed layout. This markup define where to add css classes to make navbar, navigation & footer fixed.</p>
                                    <p>Vuexy has a ready to use starter kit, you can use this layout directly by using the starter kit pages from the <code>vuexy-html-bootstrap-admin-template/starter-kit</code> folder.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('mayax_dashboard_ehelper'); ?>
        <?PHP HTML::importSection('mayax_dashboard_footer'); ?>
        <?PHP HTML::importSection('mayax_dashboard_js'); ?>
    </body>

</html>