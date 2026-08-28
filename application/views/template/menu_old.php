<!-- BEGIN HEADER MENU -->
<div class="page-header-menu">
    <div class="container-fluid">
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
        <div class="hor-menu ">
            <ul class="nav navbar-nav">
                <li>
					<a href="<?php echo base_url();?>">
						<i class="icon-home"></i>&nbsp;				
					</a>
				</li>
				
				<li class="menu-dropdown classic-menu-dropdown ">
					<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
					Master <i class="fa fa-angle-down"></i>
					</a>
					
					<ul class="dropdown-menu pull-left">
						<li class="">
							<a href="<?php echo site_url('master/country');?>" class="iconify">
								<i class="fa fa-angle-right"></i>
								Country 
							</a>
						</li>
						<li>
							<a href="<?php echo site_url('Master_COA'); ?>" class="iconify">
								<i class="fa fa-angle-right"></i>
								Master COA
							</a>
						</li>
					</ul>
				</li>
				
                <li class="menu-dropdown mega-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Utility <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 710px">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">

                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Users</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Manage_User'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Manage 
                                                </a>
                                            </li>
											<li>
												<a href="<?php echo site_url('User-group');?>" class="iconify">
													<i class="fa fa-angle-right"></i>
													Group 
												</a>
											</li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Menu</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/header'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Header
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detail'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detailsub'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Detail Submenu
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--<div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Master</h3>
                                            </li>
                                            
                                           
                                        </ul>
                                    </div>-->

                                </div>
                            </div>
                        </li>

                    </ul>
                </li>

                <li class="menu-dropdown mega-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Accounting <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="mega-menu-content" style="min-width: 710px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3><i class="fa fa-credit-card"></i> Dept</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('#'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Debt Journal 
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('#'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    CDN
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('#'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    SDN
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                 <h3><i class="fa fa-university"></i> Credit</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('payable_recognition'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Payable Recognition
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/header'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Credit Journal
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detail'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    CCN
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detailsub'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    SCN
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                 <h3><i class="fa fa-archive"></i> Others</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/header'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    Cash Bank
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detail'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    AP/AR
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('utility/menu/detailsub'); ?>" class="iconify">
                                                    <i class="fa fa-angle-right"></i>
                                                    General Journal
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="menu-dropdown mega-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Marketing <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 710px">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Users</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>" class="iconify">
                                                    <i class="icon-users"></i>
                                                    Manage </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="menu-dropdown mega-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Purchasing <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 710px">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Users</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>" class="iconify">
                                                    <i class="icon-users"></i>
                                                    Manage </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="menu-dropdown mega-menu-dropdown ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Shipping <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 710px">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Users</h3>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>" class="iconify">
                                                    <i class="icon-users"></i>
                                                    Manage </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
<!--
                <li class="menu-dropdown mega-menu-dropdown mega-menu-full ">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
                        Pages <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>User Pages</h3>
                                            </li>
                                            <li>
                                                <a href="page_timeline.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    New Timeline <span class="badge badge-warning">2</span></a>
                                            </li>
                                            <li>
                                                <a href="extra_profile.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    New User Profile <span class="badge badge-success badge-roundless">new</span></a>
                                            </li>
                                            <li>
                                                <a href="page_todo.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Todo & Tasks <span class="badge badge-danger">4</span></a>
                                            </li>
                                            <li>
                                                <a href="inbox.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    User Inbox <span class="badge badge-success">4</span></a>
                                            </li>
                                            <li>
                                                <a href="page_calendar.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    User Calendar <span class="badge badge-warning">14</span></a>
                                            </li>
                                            <li>
                                                <a href="page_timeline_old.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Old Timeline <span class="badge badge-warning">2</span></a>
                                            </li>
                                            <li>
                                                <a href="extra_profile_old.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Old User Profile </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>General Pages</h3>
                                            </li>
                                            <li>
                                                <a href="extra_faq.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    FAQ Page </a>
                                            </li>
                                            <li>
                                                <a href="page_portfolio.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Portfolio </a>
                                            </li>
                                            <li>
                                                <a href="page_timeline.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Timeline <span class="badge badge-info">4</span></a>
                                            </li>
                                            <li>
                                                <a href="page_coming_soon.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Coming Soon </a>
                                            </li>
                                            <li>
                                                <a href="extra_invoice.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Invoice </a>
                                            </li>
                                            <li>
                                                <a href="page_blog.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Blog </a>
                                            </li>
                                            <li>
                                                <a href="page_blog_item.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Blog Post </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Custom Pages</h3>
                                            </li>
                                            <li>
                                                <a href="page_news.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    News <span class="badge badge-success">9</span></a>
                                            </li>
                                            <li>
                                                <a href="page_news_item.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    News View </a>
                                            </li>
                                            <li>
                                                <a href="page_about.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    About Us </a>
                                            </li>
                                            <li>
                                                <a href="page_contact.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Contact Us </a>
                                            </li>
                                            <li>
                                                <a href="extra_search.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Search Results </a>
                                            </li>
                                            <li>
                                                <a href="extra_pricing_table.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Pricing Tables </a>
                                            </li>
                                            <li>
                                                <a href="login.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Login Form 1 </a>
                                            </li>
                                            <li>
                                                <a href="login_2.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Login Form 2 </a>
                                            </li>
                                            <li>
                                                <a href="login_3.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Login Form 3 </a>
                                            </li>
                                            <li>
                                                <a href="login_soft.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Login Form 4 </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <h3>Miscellaneous</h3>
                                            </li>
                                            <li>
                                                <a href="extra_lock.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Lock Screen 1 </a>
                                            </li>
                                            <li>
                                                <a href="extra_lock2.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    Lock Screen 2 </a>
                                            </li>
                                            <li>
                                                <a href="extra_404_option1.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    404 Page Option 1 </a>
                                            </li>
                                            <li>
                                                <a href="extra_404_option2.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    404 Page Option 2 </a>
                                            </li>
                                            <li>
                                                <a href="extra_404_option3.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    404 Page Option 3 </a>
                                            </li>
                                            <li>
                                                <a href="extra_500_option1.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    500 Page Option 1 </a>
                                            </li>
                                            <li>
                                                <a href="extra_500_option2.html">
                                                    <i class="fa fa-angle-right"></i>
                                                    500 Page Option 2 </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            -->
            </ul>
        </div>
        <!-- END MEGA MENU -->

        <!--<div class="page-head">
        <div class="container">
                 BEGIN PAGE TITLE 
                <div class="page-title">
                        <h1>GENERAL <small>Main Application Controller</small></h1>
                </div>
        </div>
        </div>-->

    </div>
</div>
<!-- END HEADER MENU -->