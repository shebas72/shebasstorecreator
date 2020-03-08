<?php 

$ci =& get_instance();
// load language helper
// if ($siteLang == 'arabic') {  } else { }
// $this->lang->line('themes_Responsive_themes');
$ci->load->helper('language');
$siteLang = $ci->session->userdata('site_lang');
if ($siteLang) {
} else {
    $siteLang = 'english';
}?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/favicon.png">
    <title><?php echo $this->lang->line('storecreator_admin');?></title>
    <!-- Bootstrap Core CSS -->
    <?php  if ($siteLang == 'arabic') { ?>
        <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap/css/bootstrap.minRTL.css" rel="stylesheet">
    <?php  } else { ?>
        <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <?php } ?>
    <!-- chartist CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin//plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin//plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin//plugins/css-chart/css-chart.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/morrisjs/morris.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- toast CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/toast-master/css/jquery.toast.css" rel="stylesheet">



    <!--Form css plugins -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/admin//plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet" />
    <!--Form css plugins end -->


    <!-- Calendar CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/calendar/dist/fullcalendar.css" rel="stylesheet" />
    <!-- summernotes CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/summernote/dist/summernote.css" rel="stylesheet" />
    <!-- wysihtml5 CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin//plugins/html5-editor/bootstrap-wysihtml5.css" />
    <!-- Dropzone css -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <!-- Cropper CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/cropper/cropper.min.css" rel="stylesheet">

    <!-- Footable CSS -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/footable/css/footable.core.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

    <!-- Date picker plugins css -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?php echo base_url() ?>assets/admin//plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/admin//plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


    <!-- Custom CSS -->

    <?php if ($siteLang == 'arabic') { ?>
        <link href="<?php echo base_url() ?>assets/admin//css/styleRTL.css" rel="stylesheet">
    <?php } else { ?>
        <link href="<?php echo base_url() ?>assets/admin//css/style.css" rel="stylesheet">
    <?php } ?>
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url() ?>assets/admin//css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
</head>

<body class="fix-header fix-sidebar card-no-border">
    
    <!-- Preloader - style you can find in spinners.css -->
    
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    
    <!-- Main wrapper - style you can find in pages.scss -->
    
    <div id="main-wrapper">
        
        <!-- Topbar header - style you can find in pages.scss -->
        
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                
                <!-- Logo -->
                
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo base_url('admin/dashboard') ?>">
                        <!-- Logo icon -->
                        <b>
                            <img src="<?php echo base_url() ?>assets/img/logo.png" alt="homepage" class="light-logo" style="width:100%;" />
                        </b>
                        <span>
                </div>
                
                <!-- End Logo -->
                
                <div class="navbar-collapse">
                    
                    <!-- toggle and nav items -->
                    
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        
                        <!-- Search -->
                        
                        <li class="nav-item hidden-sm-down search-box">
                            <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                        
                        <!-- Messages -->
                           
                    </ul>
                    
                    <!-- User profile and search -->
                    
                    <ul class="navbar-nav my-lg-0">
                        
                        <!-- Comment -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(empty($this->session->userdata('avatar'))) { ?><img src="<?php echo base_url() ?>assets/admin//images/users/1.jpg" alt="user" class="profile-pic" /> <?php } else { ?><img src="<?php echo base_url().$this->session->userdata('avatar'); ?>" alt="user" class="profile-pic" /> <?php } ?></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <?php if ($siteLang == 'arabic') {?>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?php echo base_url('language/switch/english') ?>"><i class="ti-user"></i> <?php echo $this->lang->line('english');?></a></li>
                                    <?php } else { ?>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?php echo base_url('language/switch/arabic') ?>"><i class="ti-user"></i> <?php echo $this->lang->line('arabic');?></a></li>
                                    <?php } ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url('profile') ?>"><i class="ti-user"></i> <?php echo $this->lang->line('my_profile');?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url('login/logout') ?>"><i class="fa fa-power-off"></i> <?php echo $this->lang->line('logout');?></a></li>
                                </ul>
                            </div>
                        </li>
                        
                        <!-- Language -->
                        
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                        </li> -->
                    </ul>
                </div>
            </nav>
        </header>
        
        <!-- End Topbar header -->
        









        
        
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <aside class="left-sidebar">
            

            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap"></li>
                        <li>
                            <a class="waves-effect waves-dark" href="<?php echo base_url('admin/dashboard') ?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu"><?php echo $this->lang->line('dashboard');?></span></a>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/blog/all_blog_list') ?>" aria-expanded="false"><i class="mdi mdi-blogger"></i><span class="hide-menu"><?php echo $this->lang->line('blog');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/blog') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_blog');?> </a></li>
                                

                                <li><a href="<?php echo base_url('admin/blog/all_blog_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_blog');?></a></li>
                                
                                
                                    <li><a href="<?php echo base_url('admin/comment') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_comment');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/comment/all_comment_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_comments');?></a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/domain/domain_list') ?>" aria-expanded="false"><i class="mdi mdi-blogger"></i><span class="hide-menu"><?php echo $this->lang->line('domain');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/domain') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_domain');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/domain/domain_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_domain');?></a></li>

                                
                                    <li><a href="<?php echo base_url('admin/domain/category') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_domain_category');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/domain/category_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_domain_category');?></a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/blog/app_list') ?>" aria-expanded="false"><i class="mdi mdi-blogger"></i><span class="hide-menu"><?php echo $this->lang->line('app');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/app') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_app');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/app/app_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_apps');?></a></li>
                                
                                
                                    <li><a href="<?php echo base_url('admin/app/comment') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_app_comment');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/app/comment_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_app_comments');?></a></li>
                                
                                
                                    <li><a href="<?php echo base_url('admin/app/category') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_app_category');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/app/categories_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_app_categories');?></a></li>
                            </ul>
                        </li>



                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/subscriber/all_subscriber_list') ?>" saria-expanded="false"><i class="fa fa-hand-pointer-o"></i><span class="hide-menu"><?php echo $this->lang->line('subscriber');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/subscriber') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_subscriber');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/subscriber/all_subscriber_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_subscribers');?></a></li>
                            </ul>
                        </li>
                        

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/contact/all_contact_list') ?>" aria-expanded="false"><i class="mdi mdi-contacts"></i><span class="hide-menu"><?php echo $this->lang->line('contact');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/contact') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_contact');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/contact/all_contact_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_contacts');?></a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/packages/all_packages_list') ?>" aria-expanded="false"><i class="fa fa-cube"></i><span class="hide-menu"><?php echo $this->lang->line('packages');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/packages') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_package');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/packages/all_packages_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_packages');?></a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/showcase/all_showcase_list') ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu"><?php echo $this->lang->line('showcase');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/showcase') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_showcase');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/showcase/all_showcase_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_showcases');?></a></li>
                            </ul>
                        </li>




                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/theme/all_theme_list') ?>" aria-expanded="false"><i class="fa fa-paint-brush"></i><span class="hide-menu"><?php echo $this->lang->line('theme');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/theme') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_theme');?> </a></li>
                                

                                <li><a href="<?php echo base_url('admin/theme/all_theme_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_themes');?></a></li>
                                <li><a href="<?php echo base_url('admin/slider/') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_slider_image');?></a></li>
                                <li><a href="<?php echo base_url('admin/slider/all_slider_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_slider_image');?></a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/custompages/all_custompages_list') ?>" aria-expanded="false"><i class="mdi mdi-page-layout-header"></i><span class="hide-menu"><?php echo $this->lang->line('page');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/custompages') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_page');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/custompages/all_custompages_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_pages');?></a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/user/all_user_list') ?>" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu"><?php echo $this->lang->line('user');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/user') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_user');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/user/all_user_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_users');?></a></li>
                            </ul>
                        </li>

                        <li>
                            <!-- <a class="waves-effect waves-dark" href="<?php echo base_url('admin/dashboard/backup') ?>" aria-expanded="false"><i class="fa fa-cloud-download"></i><span class="hide-menu">Backup Database</span></a> -->
                        </li>
                        
                        
                         <li>
                            <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url('admin/setting') ?>" aria-expanded="false">
                            <i class="mdi mdi-wrench"></i><span class="hide-menu"><?php echo $this->lang->line('settings');?></span></a>
                            <ul aria-expanded="false" class="collapse">

                                
                                    <li><a href="<?php echo base_url('admin/menu') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_menu');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/menu/all_menu_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_menu');?></a></li>
                                
                                 
                                    <li><a href="<?php echo base_url('admin/menuinner') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_menu_inner');?></a></li>
                                
                                
                                <li><a href="<?php echo base_url('admin/menuinner/all_menu_inner_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_menu_inner');?></a></li>
                                 <li><a href="<?php echo base_url('admin/options') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('options');?></a></li>

                                
                                <li><a href="<?php echo base_url('admin/newsletter') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_newsletter');?></a></li>
                                

                                <li><a href="<?php echo base_url('admin/newsletter/newsletter_list') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('all_newsletter');?></a></li>

                                <li><a href="<?php echo base_url('admin/sale') ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('sale');?></a></li>

                            </ul>
                        </li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <!-- End Bottom points-->



        </aside>
        
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        










        <!-- Page wrapper  -->
        
        <div class="page-wrapper">




        <!-- ==========================Dynamicaly Show Main Page Content============================ -->

            <?php echo $main_content; ?>
        
        <!-- ==========================Dynamicaly Show Main Page Content============================ -->



                
            <!-- footer -->
            
            <footer class="footer">
                © 2018 <?php echo $this->lang->line('storecreatore_admin_dashboard');?>
            </footer>
            
            <!-- End footer -->
            
        </div>
        
        <!-- End Page wrapper  -->




    </div>


    
    <!-- End Wrapper -->
    



    
    <!-- All Jquery -->
    
    <script src="<?php echo base_url() ?>assets/admin//plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url() ?>assets/admin//js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url() ?>assets/admin//js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url() ?>assets/admin//js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url() ?>assets/admin//js/custom.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//js/custom.js"></script>
    
    <!-- This page plugins -->
    
    <!-- chartist chart -->
    <!-- <script src="<?php echo base_url() ?>assets/admin//plugins/chartist-js/dist/chartist.min.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/admin//plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/admin//plugins/echarts/echarts-all.js"></script> -->
    
    <!-- Calendar JavaScript -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/moment/moment.js"></script>
    <script src='<?php echo base_url() ?>assets/admin//plugins/calendar/dist/fullcalendar.min.js'></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/calendar/dist/jquery.fullcalendar.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/calendar/dist/cal-init.js"></script>
    
    <!-- sparkline chart -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//js/dashboard4.js"></script>

    <!-- Sweet-Alert  -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
    
    <!-- toast notification CSS -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/toast-master/js/jquery.toast.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//js/toastr.js"></script>

    <!--Morris JavaScript -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/morrisjs/morris.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//js/morris-data.js"></script>
    <!-- Chart JS -->
    
    <script src="<?php echo base_url() ?>assets/admin//plugins/Chart.js/chartjs.init.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/Chart.js/Chart.min.js"></script>

    <!-- Invoice print JS -->
    <script src="<?php echo base_url() ?>assets/admin//js/jquery.PrintArea.js" type="text/JavaScript"></script>
    <script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
    </script>


    <!-- Start Table js -->
    
    <!-- This is data table js -->
    <script src="<?php echo base_url() ?>assets/admin//plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="http://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="http://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>

    <!-- Editable datatable-->
    <script src="<?php echo base_url() ?>assets/admin//plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/tiny-editable/numeric-input-example.js"></script>
    <script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
    $(document).ready(function() {
        $('#editable-datatable').DataTable();
    });
    </script>

    <!-- End Table js -->







    <!-- Start Forms js -->

    <script src="<?php echo base_url() ?>assets/admin//js/validation.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/summernote/dist/summernote.min.js"></script>
    <script>
    </script>

    <script src="<?php echo base_url() ?>assets/admin//plugins/switchery/dist/switchery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin//plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/editor/ckeditor.js" type="text/javascript"></script>
    <script>

    jQuery( document ).ready(function(){
        jQuery(".add-more").on("click",function(e){
            e.preventDefault();
            var addto = "";
            var addRemove = "";
            var next = "";
            
            if(jQuery(".delete-me").length > 0){
                var delete_l = jQuery(".delete-me").last().data('removeit');;
                 addto = "#delete" + delete_l;
                 addRemove = "#delete" + (delete_l);
            }else{
                 addto = "#field" + next;
                 addRemove = "#field" + (next);
            }
            next = next + 1;
            var newIn = '<div id="field'+ next +'" name="field'+ next +'" class="col-md-12 controls form-group"><!-- Text input--><input id="action_name" name="action_name[]" type="text" placeholder="" class="form-control input-md"></div><div id="field'+ next +'" name="field'+ next +'" class="col-md-12 controls form-group"><!-- Text input--><input id="action_name" name="action_namearb[]" type="text" placeholder="Arabic Title" class="form-control input-md"></div><div id="field'+ next +'" name="field'+ next +'" class="col-md-12 controls form-group"><!-- Text input--><input id="action_name" name="action_key[]" type="text" placeholder="Main Key" class="form-control input-md">';
            var newInput = jQuery(newIn);
            
            var removeBtn = "";
            if(jQuery(".delete-me").length > 0){
                 removeBtn = '<button type="button" id="remove' + (next) + '" data-removeit="' + (next) + '" class="btn btn-danger remove-me form-group" >Remove</button></div>';
            }else{
                 removeBtn = '<button type="button" id="remove' + (next - 1) + '" data-removeit="' + (next - 1) + '" class="btn btn-danger remove-me form-group" >Remove</button></div>';
            }
            var removeButton = jQuery(removeBtn);
            if(jQuery(".delete-me").length > 0){
                jQuery(addRemove).after(removeBtn);
                jQuery(addto).after(newInput);
            }else{
                jQuery(addto).after(newInput);
                jQuery(addRemove).after(removeBtn);
            }
            //jQuery("#field" + next).attr('data-source',jQuery(addto).attr('data-source'));
            //jQuery("#count").val(next);  
            
                jQuery('.remove-me').on("click",function(e){
                    e.preventDefault();
                    var fieldNum = jQuery(this).data('removeit');//this.id.charAt(this.id.length-1);
                    var fieldID = "#field" + fieldNum;
                    
                    if(jQuery(".delete-me").length > 0){
                        if(jQuery(".input-md").length > 1){
                            jQuery(this).remove();
                            jQuery(fieldID).remove();
                        }else{
                            alert("Single Input required");
                        }
                    }else{
                        if(jQuery(".input-md").length > 1){
                            jQuery(this).remove();
                            jQuery(fieldID).remove();
                        }else{
                            alert("Single Input required");
                        }
                    }
                });
        });
        jQuery('.delete-me').on("click",function(e){
            e.preventDefault();
            var fieldNum = jQuery(this).data('removeit');//this.id.charAt(this.id.length-1);
            var fieldID = "#field" + fieldNum;
            
            if(jQuery(".input-md").length > 1){
                jQuery(this).remove();
                jQuery(fieldID).remove();
            }else{
                alert("Single Input required");
            }
            
        });
    });

    jQuery(document).ready(function() {

        //summernone text editor
        jQuery(document).ready(function() {

        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
            });

        });

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
        // For multiselect

    });
    
    CKEDITOR.replace( 'editor1', {
        
        filebrowserUploadUrl: '../../upload.php'
    });
    
    CKEDITOR.replace( 'editor2', {
        
        filebrowserUploadUrl: '../../upload.php'
    });
    
    
    $(document).ready(function () {
    //@naresh action dynamic childs
    if($(".delete-me").length > 0){
        var next = $(".delete-me").length - 1;
    }else{
        var next = 0;
    }

});
    </script>
    <!-- End form js -->







    <!-- auto hide message div-->
    <script type="text/javascript">
        $( document ).ready(function(){
           $('.delete_msg').delay(3000).slideUp();
        });
    </script>



    <!-- Style switcher -->
    
    <script src="<?php echo base_url() ?>assets/admin//plugins/styleswitcher/jQuery.style.switcher.js"></script>


</body>

</html>
