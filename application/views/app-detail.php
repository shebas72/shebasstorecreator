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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php if ($siteLang == 'arabic') { echo $app->apptitlearb; } else { echo $app->apptitle; }?></h2>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home');?></a></li>
                            <li><a href="<?php echo base_url(); ?>app"><?php if ($siteLang == 'arabic') { echo $app->app_cat_name_arb;  } else { echo $app->app_cat_name; }?></a></li>
                            <li class="active"><a href="#"><?php if ($siteLang == 'arabic') { echo $app->apptitlearb;  } else { echo $app->apptitle; }?></a></li>
                        </ol>
                        <div class="row">
                                <div class="col-lg-offset-7 col-lg-5 m-auto" style="margin-bottom: 28px !important;">
                                  <form method="post" action="<?php echo base_url('app/search') ?>" class="form-horizontal" novalidate>
                                    <div class="input-group">
                                      <input type="text" class="form-control input- o" placeholder="<?php echo $this->lang->line('search_article');?>" name="query">
                                      <div class="input-group-btn">
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                        <button class="btn btn-primary btn-searcho" type="submit">
                                          <i class="fa fa-search"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div id="content-wrapper2">
                <!--PRICING SECTION-->
              <div class="container">
                  <div class="row">
                      <div class="col-lg-8">
                        <div class="content-app3 ">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                  <?php foreach ($appslider as $appslidervalue):?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo base_url() ?><?php echo $appslidervalue['appsliderimg'];?>" class="w-100" alt="">
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="content-featureing-app">
                            <h4 class="tit-feat-app"><?php echo $this->lang->line('features');?></h4>
                            <?php if ($siteLang == 'arabic') { $featurearray = (explode(PHP_EOL,$app->app_feature_content_arb)); } else { $featurearray = (explode(PHP_EOL,$app->app_feature_content)); }?>
                            <?php foreach ($featurearray as $featurearrayvalue): ?>
                              <p class="p-check-app-feat"><span class="fa fa-check"></span> <?php echo $featurearrayvalue;?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="content-about-app">
                                <h4 class="tit-abut-app"><?php echo $this->lang->line('about');?></h4>
                                <p><?php if ($siteLang == 'arabic') { echo $app->appaboutarb;  } else { echo $app->appabout; }?></p>
                        </div>
                        <div class="review-app">
                            <h4 class="tit-review-app"><?php echo $this->lang->line('reviews');?></h4>
                                <?php foreach ($appcomment as $appcommentdata): ?>
                                  <div class="single-comment">
                                      <div class="author-image">
                                        <?php if($appcommentdata['avatar'] != '') { ?>
                                          <img src="<?php echo base_url() ?><?php echo $appcommentdata['avatar'];?>" alt="">
                                        <?php } else {?>
                                          <img src="<?php echo base_url() ?>assets/img/avatar.svg" alt="">
                                        <?php } ?>
                                      </div>
                                      <div class="comment-text">
                                          <div class="author-info">
                                              <h4><?php echo $appcommentdata['first_name']." ".$appcommentdata['last_name'];?></h4> 
                                              <span class="comment-time">Posted on <?php echo date("M d, Y", strtotime($appcommentdata['app_com_date']));;?> /</span>
                                          </div>
                                          <p><?php echo $appcommentdata['app_com_comment'];?></p>
                                      </div>
                                  </div>
                                <?php endforeach;?>

                        </div>


                        <?php
                        $ci = get_instance();
                        if ($ci->session->userdata('is_login') == TRUE) { ?>
                        <div class="comments">
                                <h4 class="title"><?php echo $this->lang->line('add_comment');?></h4>
                                <form method="post" action="<?php echo base_url(); ?>app/comment" class="form-horizontal" novalidate>
                                <form id="main-comment-form" name="comment-form" method="post" action="#">
                                        
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" rows="8" placeholder="Type Your Message ..." required="" title="Add Your Message Herer"></textarea>
                                        </div>
                                        <input type="hidden" name="appid" value="<?php echo $app->appid?>">
                                        <input type="hidden" name="userid" value="<?php echo $ci->session->userdata('id');?>" />
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                        <button type="submit" class="btn btn-create2"><?php echo $this->lang->line('send_comment');?></button>
                                    </form>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4">
                        <div class="app-detail-card-wrapper">
                            <div class="card card-app-feature w-100"><a>
                                <div class="card-img card-img1">
                                    
                                </div>
                                <div class="card-header">
                                    <h4 class="tit-apps-suggest"><?php echo $this->lang->line('promote_forms');?></h4>
                                   
                                </div>
                                </a><div class="card-body"><a>
                                     <p><?php echo $this->lang->line('add_lead_capture');?></p>
                                     <div class="pricing-wrapper">
                                            <div class="left-col">
                                                <span><?php echo $this->lang->line('pricing');?></span>
                                            </div>
                                            <div class="right-col">
                                                <span class="pricing-string">
                                                            <?php echo $this->lang->line('free');?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="action-btn-wrapper">
                                            <div id="add-app" class="app-card__action"><div>	
                                            <a class="app-detail-card__btn btn-create2" href="<?php echo base_url('createstore'); ?>">
                                                    <span class="add-app-text"><?php echo $this->lang->line('add');?></span>
                                            </a>
                                        </div></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                
              </div>
            </div>
<?php $this->load->view('footer'); ?>