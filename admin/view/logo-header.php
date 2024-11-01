<?php

if (!defined('ABSPATH')) exit;

$show_dash_btn = false;
if (function_exists('current_action')) {
    if (current_action() == 'stylish-business-hours_page_business_hour_page_new') {
        $show_dash_btn = true;
    }
}
?>
<div class="row m-0">
    <div class="row align-items-center">
        <div class="col-12 col-md-5 col-lg-5 ">
            <a href="http://designful.ca/apps/stylish-price-list-wordpress/" class="sbh-header">
                <img src="<?php echo esc_url(DF_SBH_URL . '/assets/images/sbh.png'); ?>" class="img-responsive1 pb-0" style="padding-bottom:20px;max-width: 160px" alt="Image">
            </a>
        </div>
        <div class="col-12 col-md-7 col-lg-7 sbh-navbar">
            <div class="sbh-top-nav-container">
                <ul class="sbh-edit-nav-items">
                    <li><span class="free_version"><a class="highlighted" href="https://www.stylishpricelist.com/stylish-business-hours" target="_blank">Buy Premium</a></span></li>
                    <li><a href="<?php echo esc_url( admin_url('admin.php?page=business_hour_page_new') ); ?>">Add New</a></li>
                    <li><a href="<?php echo esc_url( admin_url('admin.php?page=business_hour_listing') ); ?>">Edit Existing</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Feedback <span class="caret"></span></a>
                        <ul class="dropdown-menu nav-fill">
                            <li class="nav-fill"><a class="nav-link" target="_blank" href="http://designful.ca/apps/stylish-price-list-wordpress/how-can-we-be-better/">Send Feedback</a></li>
                            <li class="nav-fill"><a class="nav-link" target="_blank" href="http://designful.ca/apps/stylish-price-list-wordpress/poll/new-features/">Suggest Feature</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="https://www.stylishpricelist.com/stylish-business-hours/support ">Support <span class="caret"></span></a>
                        <!-- <ul class="dropdown-menu nav-fill">
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="https://designful.freshdesk.com/support/solutions/48000446985">User Guides</a></li>
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="https://designful.freshdesk.com/support/solutions/folders/48000657938">Video Guides</a></li>
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="http://newsite.test/wp-admin/admin.php?page=stylish_cost_calculator_Diagnostic">Diagnostic</a></li>
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="https://designful.freshdesk.com/support/solutions/folders/48000670797">Troubleshooting</a></li>
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="http://designful.ca/apps/stylish-price-list-wordpress/support/">Contact Support</a></li>
                                <li class="nav-fill"><a class="nav-link" target="_blank" href="https://members.stylishcostcalculator.com/">Member's Portal</a></li>
                            </ul> -->
                    </li>
                    <?php if ($show_dash_btn) { ?>
                        <li style="margin-right:15px;">
                            <a class="text-decoration-none btn btn-warning text-dark" href="<?php echo esc_url( admin_url() ) ?>">WP Dashboard</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</div>
<style type="text/css">
    .sbh-header {
        display: inline-block;
    }

    .sbh-header.logo {
        position: relative;
        top: -20px;
    }

    img.img-responsive1 {
        max-width: 100%;
        height: auto;
    }

    .inner-footer-logo-section h4 {
        float: left;
        margin-right: 16px;
    }

    .inner-footer-logo-section {
        float: right;
    }

    .inner-footer-logo-section {
        margin-top: 26px;
    }

    .inner-footer-logo-section img {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    }

    .inner-footer-logo-section img {
        width: 47%;
    }

    .inner-footer-logo-section {
        width: 200px;
    }
</style>