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
        <section id="section-head-develop" class="bg-overlo">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="tit-developer"><span>S</span>toreCreator <?php echo $this->lang->line('app_center');?></h1>
                        <h3 class="sub-tit-dev"><?php echo $this->lang->line('apps_to_make_your_site_and_business_more_powerful');?></h3>
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
                <section id="filters">
                    <div class="container-fluid">
                        <div class="row">
                                <div class="col-lg-3">
                                        <div class="nav flex-column nav-pills aside-cont" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-aside nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php echo $this->lang->line('all_apps');?></a>
                                        <?php foreach ($app_category as $app_category_value): ?>
                                          <a class="nav-aside nav-link" id="v-pills-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>-tab" data-toggle="pill" href="#v-pills-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>" role="tab" aria-controls="v-pills-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>" aria-selected="false"><?php echo $app_category_value['app_cat_name'];?></a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="app-details">
                                                <div class="col-lg-12">
                                                <div class="row container-grid nf-col-3">
                        
                                                      <?php foreach ($app as $appvalue) : ?>
                                                        <div class="col-md-4 single-event-item-app-all branding photo spacing">
                                                            
                                                                        <a href="<?php echo base_url('app/id/') ?><?php echo $appvalue['appid'];?>">
                                                                            <div class="card card-app-feature">
                                                                            <div class="card-img card-img1" style="background: url(<?php if(empty($appvalue['app_icon'])) { echo base_url('assets/img/Default-img.png'); } else { echo $appvalue['app_icon']; }?>) !important; background-repeat: no-repeat !important; background-position: center !important;">
                                                                                
                                                                            </div>
                                                                            <div class="card-header">
                                                                                <h4 class="tit-apps-suggest"><?php if ($siteLang == 'arabic') { echo $appvalue['apptitlearb']; } else { echo $appvalue['apptitle']; }?></h4>
                                                                                
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <p><?php if ($siteLang == 'arabic') { echo substr($appvalue['appaboutarb'], 0, 50); } else { echo substr($appvalue['appabout'], 0, 50); }?>...</p>
                                                                                <a href="<?php echo base_url('app/id/') ?><?php echo $appvalue['appid'];?>" class="btn btn-create2 btn-free-app">Get Detail</a>
                                                                            </div>
                                                                        </div>
                                                                        </a>
                                                              
                                                        </div>

                                                      <?php endforeach; ?>


                                                        </div>
                                    
                                                       
                                    
                                                      
                                    
                                                </div>
                                            </div>
                                                        
                                                
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="text-center text-uppercase mb-3 mt-3">
                                                        <a href="#" class="btn-create2 btn-loadingo" id="loadMoreAppAll"><?php echo $this->lang->line('load_more_apps');?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <style type="text/css">
                                            .single-event-item-app-all {
                                              display: none;
                                            }</style>
                                        </div>

                                        <?php foreach ($app_category as $app_category_value): ?>
                                <div class="tab-pane fade" id="v-pills-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>" role="tabpanel" aria-labelledby="v-pills-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>-tab">
                                    <div class="app-details">
                                        
                                        <div class="col-lg-12">
                                        <div class="row container-grid nf-col-3">
                                                
                                          <?php foreach ($app as $appvalue) : 
                                            if (str_replace(" ","-",$app_category_value['app_cat_name']) == str_replace(" ","-",$appvalue['app_cat_name'])) {?>
                                            <div class="col-md-4 single-event-item-app-multiple single-event-slide-<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?> branding photo spacing">
                                                
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
                                            <?php } ?>
                                          <?php endforeach; ?>


                                        </div>
                            
                                               
                            
                                              
                            
                                        </div>
                                    </div>
                                        
                                        
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-center text-uppercase mb-3 mt-3">
                                                <a href="#" class="btn-create2 btn-loadingo loadMoreAppMultiple" data-id="<?php echo str_replace(" ","-",$app_category_value['app_cat_name']);?>"><?php echo $this->lang->line('load_more_apps');?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style type="text/css">
                                    .single-event-item-app-multiple {
                                      display: none;
                                    }</style>
                                </div>
                                        <?php endforeach; ?>
                    </div>
                </div>
                           
                            </div>
                        </div>
                </section>
<?php $this->load->view('footer'); ?>