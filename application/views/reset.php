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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('reset');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('reset');?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
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
                                      <?php if (isset($page) && $page == "logout"): ?>
                                          <div class="alert alert-success hide_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $this->lang->line('logout_successfully');?> &nbsp;
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                          </div>
                                      <?php endif ?>
                                   </div>
                                  <form class="form-horizontal form-material" id="reset-form" action="<?php echo base_url('login/reset/').$getid; ?>" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $this->lang->line('password');?>" name="password">
                                        </div>
                                        <div class="btn-creation row">
                                            <div class="col-12">
                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                <button type="submit" class="btn btn-primary btn-sign" name="resetpassword"><?php echo $this->lang->line('reset');?></button>
                                            </div>
                                            
                                        </div>
                                   </form>
                                   
                               </div>

                           </div>
                            <div class="sub-foot">
                                <div class="sect-left">
                                    <?php echo $this->lang->line('need_an_account');?>
                                    <a href="<?php echo base_url('signup'); ?>"><?php echo $this->lang->line('signup');?></a>
                                </div>
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo $this->lang->line('email_to_reset_password');?></h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            
                                          </div>
                                        </div>
                                      </div>
                            </div>
                       </div>
                   </div>
               </section>
            </div>
<?php $this->load->view('footer'); ?>