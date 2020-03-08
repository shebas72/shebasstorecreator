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
}?>

    <style>
       .form-sub{
           display: none;
       }
       .form-full{
           display: none;
       }
       .open-sub-domain ,.open-full-domain{
        color: #387ac4;
        font-size: 18px;
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
        transition: all 0.7s ease;
       }
       .open-sub-domain:hover,.open-full-domain:hover{
        color: #37bea7;
       }
       .form-group label{
           display:block;
       }
       table{
           background: #fff !important;
           text-align: center;

       }
       thead{
           background: #37bea7;
           color: #fff;
       }
    </style>
            <!--HEAD DEVELOPER SECTION-->
        <section id="section-head-develop" class="bg-overlo" style="    height: 200px !important;    min-height: 200px;">
                <div class="overlay" style="    height: 200px !important;    min-height: 200px;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="tit-developer"><?php echo $domaininfo->domainlink;?></h1>
                          
                        </div>
                    </div>
                </div>
            </section>
            <div id="content-wrapper">
                <!--SHOWCASE SECTION-->
	                <section id="section-showcase">

	                    <div class="container-fluid">
		                        <div class="row">
		                            <div class="col-12">
		                            	<br>
		                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('themes_Responsive_themes'); ?>                   </h3>
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
		                                <a> <img alt="1" src="<?php echo base_url(); ?>/<?php echo $theme['themeimage']; ?>" class="item-container"> </a>
		                                <div class="link-zoom">
			                                    <a data-domainid="<?php echo $parameterid;?>" data-themeid="<?php echo $theme['themeid']; ?>" class="project_links same_style installtheme" style="width: 100px !important;"> <?php echo $this->lang->line('install');?> </a>
		                                    <a href="<?php echo $theme['themeimage']; ?>" class="fancylight popup-btn same_style" data-fancybox-group="light" > <i class="fa fa-search-plus"></i> </a>
		                                    <div class="gallery-heading">
		                                        <h4><a href="<?php echo $theme['themelink']; ?>"><?php if ($siteLang == 'arabic') { echo $theme['themetitlearb']; } else { echo $theme['themetitle']; } ?></a></h4>
		    
		                                    </div>
		                                </div>
		    
		                            </div>
		                        </div>
		                        <?php endforeach ?>
		    
		                    </div>
		                    </div>
	        		</section>
            </div>
		</section>
<?php $this->load->view('footer'); ?>