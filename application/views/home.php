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
        <!--SLIDER SECTION-->
        <section id="main-slider">
            <div class="owl-carousel">

                <?php 
                $query = $this->db->get('code_slider');
                $images = $query->result_array();
                    foreach($images as $index=>$image){
                ?>
                <div class="item">
                    <div class="overlay"></div>
                    <div class="bgimg" style="background-image:url(<?php echo base_url($image['sliderimg']); ?>);"></div>
                </div>
                <?php 
                    }
                ?>
                <!--/.item-->
            </div>
                <div class="slider-inner">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cont-form mr-auto">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h2 class="tit-sell"><?php echo $this->lang->line('sell_online_today');?></h2>
                                            <p class="ptit-form"><?php echo $this->lang->line('your_store_click_away');?></p>
                                        </div>
                                    </div>
                                    <?php
                                    $ci = get_instance();
                                    if ($ci->session->userdata('is_login') == TRUE) {
                                        if ($ci->session->userdata('role') != 'developer') { ?>
                                            <h2 class="tit-sell" style="text-align:center;"><?php echo $this->lang->line('welcome');?> <b><?php echo $ci->session->userdata('name');?></b></h2>
                                        <?php
                                        } else { ?>
                                            <form class="form-horizontal form-material" id="login-form" action="<?php echo base_url('login/log'); ?>" method="post">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('your_email_address');?>" name="user_name"> 
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $this->lang->line('password');?>" name="password">
                                                </div>
                                                <div class="btn-creation row">
                                                    <span class="col-6"> 
                                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                        </div>
                                                    </span>
                                                    <div class="col-12">
                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                        <button type="submit" class="btn btn-primary btn-sign"><?php echo $this->lang->line('login');?></button>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        <?php }
                                        } 
                                        if ($ci->session->userdata('is_login') != TRUE) { ?>

                                        <form class="form-horizontal form-material" id="login-form" action="<?php echo base_url('login/log'); ?>" method="post">
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>" name="user_name"> 
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $this->lang->line('password');?>" name="password">
                                            </div>
                                            <div class="btn-creation row">
                                                <span class="col-6"> 
                                                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    </div>
                                                </span>
                                                <div class="col-12">
                                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                    <button type="submit" class="btn btn-primary btn-sign"><?php echo $this->lang->line('login');?></button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                            <?php
                                        } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="carousel-content">
                                    <h1 class="tit-developer"><span>S</span>toreCreator The Best!</h1>

                                    <h3 class="sub-tit-dev"><?php echo $this->lang->line('Lorem_ipsum_dolor');?></h3>

                                    <h3 class="sub-tit-dev"><?php echo $this->lang->line('Lorem_ipsum_dolor2');?></h3>
                                    <div class="cont-create-storeslide">
                                        <div class="row">
                                            <div class="col-12 text-center cont-log-store">
                                                <a href="<?php echo base_url('createstore'); ?>" class="btn btn-create2 text-uppercase">Create store</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--/.owl-carousel-->
        </section>
		<?php 
		$contact_opt = page_fetch('home-showcase','code_pages');
        if ($siteLang == 'arabic') { echo $contact_opt[0]['pagescontentarb']; } else { echo $contact_opt[0]['pagescontent']; }
		
		?>
      <?php 
		$contact_opt = page_fetch('home-all-features','code_pages');
        if ($siteLang == 'arabic') { echo $contact_opt[0]['pagescontentarb']; } else { echo $contact_opt[0]['pagescontent']; }
		
		?>
        <!--THEMES SECTION -->
        <section id="themes">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('themes');?></h3>
                            </div>
                        </div>
                    </div>
            <div class="container">
                    <div class="swiper-container swipe2">
                            <div class="swiper-wrapper swip2">
							<?php 
									$this->db->order_by('themeid', 'DESC');
									$this->db->limit('5');
                                    $this->db->where('themeactive','2');
									$query = $this->db->get('code_theme');
									$theme = $query->result_array();
									
									foreach($theme as $image):
									?>
									<div class="swiper-slide" style="background-image: url(<?php echo $image['themeimage']; ?>)"></div>
									<?php endforeach; ?>
                             
                             
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                          </div>
            </div>

            <div class="container-fluid">
                    <div class="row">
                            <div class="col-12 text-center cont-log-store">
                                <a href="<?php echo base_url('themes'); ?>" class="btn btn-create2 text-uppercase"><?php echo $this->lang->line('view_themes');?></a>
                            </div>
                        </div>
            </div>
        </section>
<?php $this->load->view('footer'); ?>