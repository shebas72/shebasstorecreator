    <?php $this->load->view('header'); 

    $ci =& get_instance();
    // load language helper
    // if ($siteLang == 'arabic') {  } else { }
    // $this->lang->line('themes_Responsive_themes');
    $ci->load->helper('language');
    $siteLang = $ci->session->userdata('site_lang');
    if ($siteLang) {
    } else {
        $siteLang = 'english';
    } ?>
        <div class="section background-opacity page-titlen set-height-top">
                <div class="container  cont-sub">
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('themes'); ?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"><?php echo $this->lang->line('Home'); ?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('themes'); ?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <!--SHOWCASE SECTION-->
                <section id="section-showcase">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('local'); ?>Beautiful Themes</h3>
                                <p class="p-tit-tab text-center"><?php echo $this->lang->line('themes_Responsive_themes'); ?>                   </p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <!-- work Filter -->
				<div class="row">
                        <div class="col-lg-12">
                            <ul class="container-filter categories-filter">
                                <li>
                                    <a class="categories active" data-filter="*"><?php echo $this->lang->line('themes_All_themes'); ?></a>
                                </li>
                                <?php foreach ($themesgroup as $themegroup): ?>
                                    <li>
                                        <a class="categories" data-filter=".<?php echo str_replace(' ', '-', $themegroup['themetype']); ?>"><?php if ($siteLang == 'arabic') { echo $themegroup['themetypearb']; } else { echo $themegroup['themetype']; }?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                    	<!-- End work Filter -->
				<div class="row container-grid nf-col-3">

                        <?php foreach ($themes as $theme): ?>
                        <div class="nf-item <?php echo str_replace(' ', '-', $theme['themetype']); ?> coffee spacing">
                            <div class="item-box">
                                <a> <img alt="1" src="<?php echo $theme['themeimage']; ?>" class="item-container"> </a>
                                <div class="link-zoom">
                                    <a href="<?php echo $theme['themelink']; ?>" class="project_links same_style" target="_blank"> <i class="fa fa-check" > </i> </a>
                                    <a href="<?php echo $theme['themeimage']; ?>" class="fancylight popup-btn same_style" data-fancybox-group="light" > <i class="fa fa-search-plus"></i> </a>
                                    <div class="gallery-heading">
    
                                    </div>
                                </div>
    
                            </div>
                        </div>
                        <?php endforeach ?>
    
                    </div>
                    </div>
                </section>
            </div>
            
<?php $this->load->view('footer'); ?>