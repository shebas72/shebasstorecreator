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
            <section id="section-head-develop">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="tit-developer"><span>S</span>toreCreator <?php echo $this->lang->line('developer_center');?></h1>
                            <h3 class="sub-tit-dev"><?php echo $this->lang->line('build_apps_&_themes_for_over_30m_users');?></h3>
                            <a href="https://storecreator.io/developer/signup" class="btn btn-create2 text-uppercase btn-get"><?php echo $this->lang->line('get_started');?></a>
                          
                        </div>
                    </div>
                </div>
            </section>
            <div id="content-wrapper">
                <!--PRICING SECTION-->
               <section id="form-all-content">
                   <div class="container">
                       <div class="log-page">
                           <div class="log-size">
                               <div class="log-content">
                                   <div class="log-head">
                                       <a href="index.html">
                                           <img src="<?php echo base_url() ?>assets/img/logo.png" alt="storeCreator">
                                       </a>
                                       <h2 class="headewel"><?php echo $this->lang->line('welcomeback');?></h2>
                                   </div>
                                  <form class="form-horizontal form-material" id="login-form" action="<?php echo base_url('developer/log'); ?>" method="post">
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
                                                    <label class="custom-control-label" for="customControlInline"><?php echo $this->lang->line('rememberme');?></label>
                                                </div>
                                            </span>
                                            <div class="col-6">
                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                <button type="submit" class="btn btn-primary btn-sign"><?php echo $this->lang->line('login');?></button>
                                            </div>
                                            
                                        </div>
                                   </form>
                                   
                               </div>
                           
                           </div>
                            <div class="sub-foot">
                                <div class="sect-left">
                                    <?php echo $this->lang->line('need_an_account');?>
                                    <a href="<?php echo base_url('developer/signup'); ?>"><?php echo $this->lang->line('signup');?></a>
                                </div>
                                <div class="sect-right">
                                    <a href="#"><?php echo $this->lang->line('forget_password');?></a>
                                </div>
                            </div>
                       </div>
                   </div>
               </section>
            </div>
<?php $this->load->view('footer'); ?>