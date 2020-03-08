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
                            <h1 class="tit-developer"><span>S</span>toreCreator <?php echo $this->lang->line('domains');?></h1>
                          
                        </div>
                    </div>
                </div>
            </section>
            <div id="content-wrapper">
                <!--SHOWCASE SECTION-->
         			<section class="section" id="featured">
						<div class="container">
						    <div class="row">
						        <div class="col-12">
						            <h1 class="show-tit text-capitalize text-center"><?php echo $domaininfo->domainlink;?></h3>
						        	<p style="text-align: center;"><b>Admin access</b> <?php echo $domaininfo->domainlink;?>/wp-admin<br>
						        	<b>user:</b> storecreator</br>
						        	<b>pass:</b> y4u5AlcdEMoO1kMMB00NdMP2<br>
						        	<b>Note: It is recommended to change password</b></p>
						        </div>
						    </div>
						</div>
			          <div class="container">
			              <div class="content-apps-suggest">
			                  <div class="row">
			                    <?php if(count($app) == 0) { 
			                      echo "<h2 style='text-align:center; width:100%;'>";?><?php echo $this->lang->line('sorreynoresult');?></h2>
			                    <?php } else { ?>
			                      
			                            <?php foreach ($app as $appvalue) : ?>
			                            <div class="col-md-4 single-event-item branding photo spacing">
			                                
			                                            <a>
			                                                <div class="card card-app-feature">
			                                                <div class="card-img card-img1" style="background: url(<?php echo base_url(); ?>/<?php if(empty($appvalue['app_icon'])) { echo base_url('assets/img/Default-img.png'); } else { echo $appvalue['app_icon']; }?>) !important; background-repeat: no-repeat !important; background-position: center !important;">
			                                                    
			                                                </div>
			                                                <div class="card-header">
			                                                    <h4 class="tit-apps-suggest"><b>Name</b>: <?php if ($siteLang == 'arabic') { echo $appvalue['apptitlearb']; } else { echo $appvalue['apptitle']; }?></h4>
			                                                    
			                                                </div>
			                                                <div class="card-body">
			                                                    <p><?php if ($siteLang == 'arabic') { echo substr($appvalue['appaboutarb'], 0, 50); } else { echo substr($appvalue['appabout'], 0, 50); }?>...</p>
			                                                    <?php $appinstalledarray = explode(',', $domaininfo->appinstalled);?>
			                                                    <?php if(in_array($appvalue['appid'], $appinstalledarray)) { ?>
				                                                    <a data-domain-id="<?php echo $domainid;?>" data-id="<?php echo $appvalue['appid'];?>" class="btn btn-create2 btn-free-app apptoinstall" style="cursor: not-allowed;"><?php echo $this->lang->line('installed');?></a>
				                                                <?php } else { ?>
				                                                    <a data-domain-id="<?php echo $domainid;?>" data-id="<?php echo $appvalue['appid'];?>" class="btn btn-create2 btn-free-app apptoinstall"><?php echo $this->lang->line('install');?></a>
				                                                <?php } ?>
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
			          <div class="container-fluid">
			              <div class="row">
			                  <div class="col-12">
			                      <div class="text-center text-uppercase mb-3 mt-3">
			                          <a href="<?php echo base_url('createstore'); ?>" class="btn-create2 btn-loadingo" id="loadMore"><?php echo $this->lang->line('done_back_to_domain_list');?></a>
			                      </div>
			                  </div>
			              </div>
			          </div>
	        		</section>
            </div>
		</section>
<?php $this->load->view('footer'); ?>