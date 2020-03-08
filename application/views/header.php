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
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="StoreCreator store create a store sell online today selling online themes features about pricing showcase">
    <meta name="author" content="Ramadan Amoum">
    <meta name="description" content="IUG: Courses Arabic, Islamic universtiy, Learn Arabic">
    <title>StoreCreator | <?php echo $this->lang->line('HOME');?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/favicon.png">
    <link href='https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <?php if ($siteLang == 'arabic') { ?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/swiper.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.fancybox.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style-ar.css">
    <?php } else { ?>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/media.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/swiper.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/slick.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.fancybox.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/media.css">
    <?php } ?>
</head>

<body>
    <div class="container-fluid p-0">
	<!--HEADER SECTION-->
    <header id="header">
        <div class="content-nav container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light">
						<?php 
									$logo_opt = footer_menu_options('toplogo','code_option');
								?>
                        <a class="navbar-brand" href="<?php echo base_url(); ?>">
                            <img src="<?php echo $logo_opt[0]['optionvalue']; ?>"  alt="logo StoreCreator">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="fa fa-bars"></span>
                        </button>
                      
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav m-auto nav-linking">
							<?php 
									$menu = footer_menu('1','code_menuinner');
									foreach($menu  as $link){
                                        echo '<li class="nav-item active"><a class="nav-link" href="'.$link['menuinnerlink'].'">';
                                        if ($siteLang == 'arabic') { echo $link['menuinnertextarb']; } else { echo $link['menuinnertext']; }
										echo '</a></li>';
									}
								?>
						  
                          
                          </ul>
                          <ul class="side-menuo list-unstyled list-inline m-auto">
                              <li class="lang-ar list-inline-item">
                                  <a class="lang-name" href="<?php echo base_url(); ?>language/switch/<?php if ($siteLang == 'arabic') { echo "english";  } else { echo "arabic"; } ?>"><?php echo $this->lang->line('language');?></a>
                              </li>
                                <li class="list-inline-item create-name-all dropdown" style="cursor: pointer;">
                                    <?php if ($ci->session->userdata('is_login') == TRUE) { ?>
                                        <a class="create-name-head dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('my_account');?></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?php echo base_url('createstore'); ?>"><?php echo $this->lang->line('create_store');?></a>
                                                <a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><?php echo $this->lang->line('edit_profile');?></a>
                                                <a class="dropdown-item" href="<?php echo base_url('login/logout'); ?>"><?php echo $this->lang->line('logout');?></a>
                                            </div>
                                    <?php } else {?>
                                        <a class="create-name-head has-submenu" href="<?php echo base_url('signup'); ?>"><?php echo $this->lang->line('create_store');?></a>
                                    <?php } ?>
                              </li>
                          </ul>
                        </div>
            </nav>
        </div>
    </header>
<?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%;top:90px; z-index: 2;"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>
			
<?php $msg = $this->session->flashdata('msg'); ?>
            <?php if (isset($msg)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%;top:90px; z-index: 2;"> <i class="fa fa-times"></i> <?php echo $msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>
<?php $msgs = $this->session->flashdata('msgs'); ?>
            <?php if (isset($msgs)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%;top:90px; z-index: 2;"> <i class="fa fa-times"></i> <?php echo $msgs; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>