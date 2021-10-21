<!DOCTYPE html>
<!--
Template Name: NobleUI - Admin & Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: You must have a valid license purchased only from above link or https://themeforest.net/user/nobleui/portfolio/ in order to legally use the theme for your project.
-->
<?php
  $webSet = WebsiteSettings::first();
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?=$page_title?></title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <!-- core:css -->
  <link rel="stylesheet" href="<?=$this_folder?>/assets/css/core.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="<?=$this_folder?>/assets/css/bootstrap-datepicker.min.css">
  <!-- end plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?=$this_folder?>/assets/css/iconfont.css">
  <link rel="stylesheet" href="<?=$this_folder?>/assets/css/flag-icon.min.css">
  <!-- endinject -->
  <!-- Layout styles -->  
  <link rel="stylesheet" href="<?=$this_folder?>/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?=$webSet->favicon_url?>" />
</head>
<body class="sidebar-dark">
  <div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          <img src="<?=$webSet->logo_url?>" width="120">
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item <?php if($active_page == 'dashboard') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>dashboard" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>


          <li class="nav-item mt-3 <?php if($active_page == 'gen_set') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#geneSettings" role="button" aria-expanded="false" aria-controls="geneSettings">
              <i class="link-icon" data-feather="settings"></i>
              <span class="link-title">General Settings</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="geneSettings">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>general_settings/website_settings" class="nav-link">Website settings</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>general_settings/currency_settings" class="nav-link">Currency Settings</a>
                </li>

                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>general_settings/social_settings" class="nav-link">Social Settings</a>
                </li>

                <!-- <li class="nav-item">
                  <a href="pages/ui-components/tooltips.html" class="nav-link">Configuration</a>
                </li>
                 -->
              </ul>
            </div>
          </li>

          <li class="nav-item mt-3 <?php if($active_page == 'con_manager') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#contentManager" role="button" aria-expanded="false" aria-controls="contentManager">
              <i class="link-icon" data-feather="edit"></i>
              <span class="link-title">Content Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="contentManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/home_slider" class="nav-link">Home Banners</a>
                </li>

                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/seller_content" class="nav-link">Seller Contents</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/why_chose_us" class="nav-link">Why Chose Us</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/about_us" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/faq" class="nav-link">FAQ</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/all_pages" class="nav-link">Pages</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/email_template" class="nav-link">Email Template</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/manage_menu" class="nav-link">Manage Menu</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/brands" class="nav-link">Brands</a>
                </li>
                <!-- <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>content_manager/adverts" class="nav-link">Adverts</a>
                </li> -->
              </ul>
            </div>
          </li>


          <li class="nav-item nav-category">admin Settings</li>
          <li class="nav-item <?php if($active_page == 'admin_manager') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#adminManager" role="button" aria-expanded="false" aria-controls="adminManager">
              <i class="link-icon" data-feather="user-plus"></i>
              <span class="link-title">Admin Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="adminManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>admin_manager" class="nav-link">Admins</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>admin_manager/add" class="nav-link">Add Admin</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item <?php if($active_page == 'acc_set') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#accSettings" role="button" aria-expanded="false" aria-controls="accSettings">
              <i class="link-icon" data-feather="slack"></i>
              <span class="link-title">Account Settings</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="accSettings">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>account_settings/edit_profile" class="nav-link">Edit Profile</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>account_settings/change_password" class="nav-link">change Password</a>
                </li>
              </ul>
            </div>
          </li>




          <!-- PRODUCT SETTINGS -->
          <li class="nav-item nav-category">Product settings</li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#productManager" role="button" aria-expanded="false" aria-controls="productManager">
              <i class="link-icon" data-feather="shopping-bag"></i>
              <span class="link-title">Product Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="productManager">
              <ul class="nav sub-menu">
                <li class="nav-item <?php if($active_page == 'pro_manager') { ?> active <?php } ?>">
                  <a href="<?=Config::ADMIN_BASE_URL()?>product_manager" class="nav-link">Manage Product</a>
                </li>

                <li class="nav-item <?php if($active_page == 'home_product') { ?> active <?php } ?>">
                  <a href="<?=Config::ADMIN_BASE_URL()?>home_product" class="nav-link">Home Product</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item <?php if($active_page == 'manage_cat') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/manage_category" class="nav-link">
              <i class="link-icon" data-feather="server"></i>
              <span class="link-title">Manage Category</span>
            </a>
          </li>

          <li class="nav-item <?php if($active_page == 'cat_banner') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/category_banner" class="nav-link">
              <i class="link-icon" data-feather="sidebar"></i>
              <span class="link-title">Category Banners</span>
            </a>
          </li>

          <li class="nav-item <?php if($active_page == 'featured_category_banner') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/top_category" class="nav-link">
              <i class="link-icon" data-feather="sidebar"></i>
              <span class="link-title">Top Category</span>
            </a>
          </li>

          <li class="nav-item <?php if($active_page == 'feature_cat') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/featured_category" class="nav-link">
              <i class="link-icon" data-feather="sidebar"></i>
              <span class="link-title">Featured Category</span>
            </a>
          </li>

          <li class="nav-item <?php if($active_page == 'common_variation') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/common_variation" class="nav-link">
              <i class="link-icon" data-feather="speaker"></i>
              <span class="link-title">Common Variation</span>
            </a>
          </li>

          <!-- <li class="nav-item <?php if($active_page == 'deals') { ?> active <?php } ?>">
            <a href="<?=Config::ADMIN_BASE_URL()?>product_manager/deals" class="nav-link">
              <i class="link-icon" data-feather="speaker"></i>
              <span class="link-title">Deals</span>
            </a>
          </li> -->



          <li class="nav-item nav-category">Users Manager</li>
          <li class="nav-item <?php if($active_page == 'customer') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#customerManager" role="button" aria-expanded="false" aria-controls="customerManager">
              <i class="link-icon" data-feather="users"></i>
              <span class="link-title">Customer Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="customerManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>customer_manager" class="nav-link">All Customers</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>customer_manager/active" class="nav-link">Active</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>customer_manager/pending" class="nav-link">Pending</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>customer_manager/blocked" class="nav-link">Blocked</a>
                </li>
              </ul>
            </div>
          </li>


          <li class="nav-item <?php if($active_page == 'seller') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#sellerManager" role="button" aria-expanded="false" aria-controls="sellerManager">
              <i class="link-icon" data-feather="user-check"></i>
              <span class="link-title">Seller Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="sellerManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>seller_manager" class="nav-link">All Sellers</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>seller_manager/active" class="nav-link">Active</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>seller_manager/pending" class="nav-link">Pending</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>seller_manager/blocked" class="nav-link">Blocked</a>
                </li>
              </ul>
            </div>
          </li>



          <li class="nav-item nav-category">Manager</li>
          <li class="nav-item <?php if($active_page == 'orderManager') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#orderManager" role="button" aria-expanded="false" aria-controls="orderManager">
              <i class="link-icon" data-feather="shopping-cart"></i>
              <span class="link-title">Order Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="orderManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager" class="nav-link">All Orders</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/orders/delivered" class="nav-link">Delivered Orders</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/orders/shipped" class="nav-link">Shipped Orders</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/orders/pending" class="nav-link">Pending Orders</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/orders/return" class="nav-link">Return Orders</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager/orders/cancelled" class="nav-link">Cancelled Orders</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item <?php if($active_page == 'otherManager') { ?> active <?php } ?>">
            <a class="nav-link" data-toggle="collapse" href="#otherManager" role="button" aria-expanded="false" aria-controls="otherManager">
              <i class="link-icon" data-feather="trello"></i>
              <span class="link-title">Other Manager</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="otherManager">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>other_manager/payment_gateway" class="nav-link">Payment Gateway</a>
                </li>
                <li class="nav-item">
                  <a href="<?=Config::ADMIN_BASE_URL()?>other_manager/bank" class="nav-link">Bank Account Info</a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </nav>

  
    <div class="page-wrapper">
          
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar">
        <a href="#" class="sidebar-toggler">
          <i data-feather="menu"></i>
        </a>
        <div class="navbar-content">
          <!-- <form class="search-form">
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i data-feather="search"></i>
                </div>
              </div>
              <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
          </form> -->
          <ul class="navbar-nav">
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="font-weight-medium ml-1 mr-1 d-none d-md-inline-block">English</span>
              </a>
              <div class="dropdown-menu" aria-labelledby="languageDropdown">
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ml-1"> English </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span class="ml-1"> French </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-de" title="de" id="de"></i> <span class="ml-1"> German </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-pt" title="pt" id="pt"></i> <span class="ml-1"> Portuguese </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-es" title="es" id="es"></i> <span class="ml-1"> Spanish </span></a>
              </div>
            </li> -->


            <li class="nav-item dropdown nav-apps">
              <a onclick="openFullscreen()" id="fullScreen" class="nav-link dropdown-toggle" href="#">
                <i data-feather="grid"></i>
              </a>

              <a onclick="closeFullscreen()" id="closeFullScreen" class="nav-link dropdown-toggle" href="#" style="display: none;">
                <i data-feather="grid"></i>
              </a>
            </li>


            <li class="nav-item dropdown nav-apps">
              <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="home"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="appsDropdown">
                <div class="dropdown-header d-flex align-items-center justify-content-between">
                  <p class="mb-0 font-weight-medium">Web Users</p>
                  <!-- <a href="javascript:;" class="text-muted">Edit</a> -->
                </div>
                <div class="dropdown-body">
                  <div class="d-flex align-items-center apps">
                    <a href="<?=Config::ADMIN_BASE_URL()?>customer_manager"><i data-feather="message-square" class="icon-lg"></i><p>Customers</p></a>
                    <a href="<?=Config::ADMIN_BASE_URL()?>seller_manager"><i data-feather="calendar" class="icon-lg"></i><p>Sellers</p></a>
                    <a href="<?=Config::ADMIN_BASE_URL()?>admin_manager"><i data-feather="mail" class="icon-lg"></i><p>Admins</p></a>
                    <a href="<?=Config::ADMIN_BASE_URL()?>account_settings/edit_profile"><i data-feather="instagram" class="icon-lg"></i><p>Profile</p></a>
                  </div>
                </div>
                <div class="dropdown-footer d-flex align-items-center justify-content-center">
                  <a href="<?=Config::ADMIN_BASE_URL()?>order_manager">All Orders</a>
                </div>
              </div>
            </li>


            <!-- <li class="nav-item dropdown nav-messages">
              <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="mail"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="messageDropdown">
                <div class="dropdown-header d-flex align-items-center justify-content-between">
                  <p class="mb-0 font-weight-medium">9 New Messages</p>
                  <a href="javascript:;" class="text-muted">Clear all</a>
                </div>
                <div class="dropdown-body">
                  <a href="javascript:;" class="dropdown-item">
                    <div class="figure">
                      <img src="../assets/images/faces/face2.jpg" alt="userr">
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <p>Leonardo Payne</p>
                        <p class="sub-text text-muted">2 min ago</p>
                      </div>  
                      <p class="sub-text text-muted">Project status</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="figure">
                      <img src="../assets/images/faces/face3.jpg" alt="userr">
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <p>Carl Henson</p>
                        <p class="sub-text text-muted">30 min ago</p>
                      </div>  
                      <p class="sub-text text-muted">Client meeting</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="figure">
                      <img src="../assets/images/faces/face4.jpg" alt="userr">
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <p>Jensen Combs</p>                       
                        <p class="sub-text text-muted">1 hrs ago</p>
                      </div>  
                      <p class="sub-text text-muted">Project updates</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="figure">
                      <img src="../assets/images/faces/face5.jpg" alt="userr">
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <p>Amiah Burton</p>
                        <p class="sub-text text-muted">2 hrs ago</p>
                      </div>
                      <p class="sub-text text-muted">Project deadline</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="figure">
                      <img src="../assets/images/faces/face6.jpg" alt="userr">
                    </div>
                    <div class="content">
                      <div class="d-flex justify-content-between align-items-center">
                        <p>Yaretzi Mayo</p>
                        <p class="sub-text text-muted">5 hr ago</p>
                      </div>
                      <p class="sub-text text-muted">New record</p>
                    </div>
                  </a>
                </div>
                <div class="dropdown-footer d-flex align-items-center justify-content-center">
                  <a href="javascript:;">View all</a>
                </div>
              </div>
            </li> -->


            <!-- <li class="nav-item dropdown nav-notifications">
              <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="bell"></i>
                <div class="indicator">
                  <div class="circle"></div>
                </div>
              </a>
              <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                <div class="dropdown-header d-flex align-items-center justify-content-between">
                  <p class="mb-0 font-weight-medium">6 New Notifications</p>
                  <a href="javascript:;" class="text-muted">Clear all</a>
                </div>
                <div class="dropdown-body">
                  <a href="javascript:;" class="dropdown-item">
                    <div class="icon">
                      <i data-feather="user-plus"></i>
                    </div>
                    <div class="content">
                      <p>New customer registered</p>
                      <p class="sub-text text-muted">2 sec ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="icon">
                      <i data-feather="gift"></i>
                    </div>
                    <div class="content">
                      <p>New Order Recieved</p>
                      <p class="sub-text text-muted">30 min ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="icon">
                      <i data-feather="alert-circle"></i>
                    </div>
                    <div class="content">
                      <p>Server Limit Reached!</p>
                      <p class="sub-text text-muted">1 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="icon">
                      <i data-feather="layers"></i>
                    </div>
                    <div class="content">
                      <p>Apps are ready for update</p>
                      <p class="sub-text text-muted">5 hrs ago</p>
                    </div>
                  </a>
                  <a href="javascript:;" class="dropdown-item">
                    <div class="icon">
                      <i data-feather="download"></i>
                    </div>
                    <div class="content">
                      <p>Download completed</p>
                      <p class="sub-text text-muted">6 hrs ago</p>
                    </div>
                  </a>
                </div>
                <div class="dropdown-footer d-flex align-items-center justify-content-center">
                  <a href="javascript:;">View all</a>
                </div>
              </div>
            </li> -->


            <li class="nav-item dropdown nav-profile">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if($this->admin()->photo) { ?>
                <img src="<?=$this->admin()->photo?>" alt="<?=$this->admin->username?>">
                <?php } else { ?>
                <img src="<?=$this_folder?>/assets/images/profile-default.png" alt="<?=$this->admin->username?>" style="border: 1px solid #ccc">
                <?php } ?>
              </a>

              <div class="dropdown-menu" aria-labelledby="profileDropdown">
                <div class="dropdown-header d-flex flex-column align-items-center">
                  <div class="figure mb-3">
                    <?php if($this->admin()->photo) { ?>
                    <img src="<?=$this->admin()->photo?>" alt="<?=$this->admin->username?>">
                    <?php } else { ?>
                    <img src="<?=$this_folder?>/assets/images/profile-default.png" alt="<?=$this->admin->username?>" style="border: 1px solid #ccc">
                    <?php } ?>
                  </div>
                  <div class="info text-center">
                    <p class="name font-weight-bold mb-0"><?=ucwords($this->admin->first_name)?> <?=ucwords($this->admin->last_name)?></p>
                    <p class="email text-muted mb-3"><?=$this->admin->email?></p>
                  </div>
                </div>
                <div class="dropdown-body">
                  <ul class="profile-nav p-0 pt-3">
                    <li class="nav-item mb-3">
                      <a href="<?=Config::ADMIN_BASE_URL()?>account_settings/edit_profile" class="nav-link">
                        <i data-feather="edit"></i>
                        <span>Edit Profile</span>
                      </a>
                    </li>
                    <li class="nav-item mb-3">
                      <a href="<?=Config::ADMIN_BASE_URL()?>account_settings/change_password" class="nav-link">
                        <i data-feather="lock"></i>
                        <span>Change Password</span>
                      </a>
                    </li>
                    <li class="nav-item mb-3">
                      <a href="<?=Config::ADMIN_BASE_URL()?>login/logout" class="nav-link">
                        <i data-feather="log-out"></i>
                        <span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
      <!-- partial -->