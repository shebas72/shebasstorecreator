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
        <!--HEAD DEVELOPER SECTION-->
        <section id="section-head-develop">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="tit-developer"><?php echo $this->lang->line('search');?></h1>
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
        </section>
            
         <!--SECTION APP CENTER-->
         <section class="section" id="featured">
          <div class="container">
              <div class="content-apps-suggest">
                  <div class="row">
                    <?php if(count($app) == 0) { 
                      echo "<h2 style='text-align:center; width:100%;'>";?><?php echo $this->lang->line('sorreynoresult');?></h2>
                    <?php } else { ?>
                      
                            <?php foreach ($app as $appvalue) : ?>
                            <div class="col-md-4 single-event-item branding photo spacing">
                                
                                            <a href="<?php echo base_url('app/id/') ?><?php echo $appvalue['appid'];?>">
                                                <div class="card card-app-feature">
                                                <div class="card-img card-img1" style="background: url(<?php if(empty($appvalue['app_icon'])) { echo base_url('assets/img/Default-img.png'); } else { echo $appvalue['app_icon']; }?>) !important; background-repeat: no-repeat !important; background-position: center !important;">
                                                    
                                                </div>
                                                <div class="card-header">
                                                    <h4 class="tit-apps-suggest"><?php if ($siteLang == 'arabic') { echo $appvalue['apptitlearb']; } else { echo $appvalue['apptitle']; }?></h4>
                                                    
                                                </div>
                                                <div class="card-body">
                                                    <p><?php if ($siteLang == 'arabic') { echo substr($appvalue['appaboutarb'], 0, 50); } else { echo substr($appvalue['appabout'], 0, 50); }?>...</p>
                                                    <a href="<?php echo base_url('app/id/') ?><?php echo $appvalue['appid'];?>" class="btn btn-create2 btn-free-app"><?php echo $this->lang->line('get_detail');?></a>
                                                </div>
                                            </div>
                                            </a>
                                  
                            </div>
                                                              <?php endforeach; ?>
                    <?php } ?>
                  </div>
              </div>
          </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center text-uppercase mb-3 mt-3">
                                    <a href="#" class="btn-create2 btn-loadingo" id="loadMore"><?php echo $this->lang->line('load_more_apps');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
         </section>
<?php $this->load->view('footer'); ?>