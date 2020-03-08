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
        <div class="section background-opacity page-titlen set-height-top">
                <div class="container  cont-sub">
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('showcase');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('showcase');?></a></li>
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
                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('showcase');?></h3>
                                <p class="p-tit-tab text-center"><?php echo $this->lang->line('join_the_most');?></p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <!-- work Filter -->
				<div class="row">
                        <div class="col-lg-12">
                            <ul class="container-filter categories-filter cont-show-li">
                                <li>
                                    <a class="categories active" data-filter="*"><?php echo $this->lang->line('all_showcase');?></a>
                                </li>
                                <?php foreach ($showcasegroup as $showcasegroups): ?>
                                    <li>
                                        <a class="categories" data-filter=".<?php echo str_replace(' ', '-', $showcasegroups['showcasetype']); ?>"><?php if ($siteLang == 'arabic') { echo $showcasegroups['showcasetypearb']; } else { echo $showcasegroups['showcasetype']; }?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                    	<!-- End work Filter -->
				<div class="row container-grid nf-col-3">

                        <?php foreach ($showcase as $showcases): ?>
                            <div class="nf-item branding coffee spacing">
                                <div class="item-box">
                                    <a> <img alt="1" src="<?php echo $showcases['showcaseimage']; ?>" class="item-container"> </a>
                                    <div class="link-zoom">
                                        <a href="<?php echo $showcases['showcaselink']; ?>" class="btn btn-create2 text-uppercase mb-2" target="_blank"><?php echo $this->lang->line('visit_a_website');?></a>
                                        <div class="gallery-heading">
                                            <h4><a href="#"><?php if ($siteLang == 'arabic') { echo $showcases['showcasetitlearb']; } else { echo $showcases['showcasetitlearb']; } ?></a></h4>
        
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