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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('signup');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('signup');?></a></li>
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
                                       <h2 class="headewel"><?php echo $this->lang->line('get_started');?></h2>
                                   </div>
                                    <form method="post" action="<?php echo base_url('signup') ?>" class="form-horizontal" novalidate>
                                        <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputuser1" aria-describedby="userHelp" placeholder="<?php echo $this->lang->line('first_name');?>" name="first_name"> 
                                            </div>
                                        <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputuser1" aria-describedby="userHelp" placeholder="<?php echo $this->lang->line('lastname');?>" name="last_name"> 
                                            </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>" name="email"> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $this->lang->line('password');?>" name="password">
                                        </div>
                                        <div class="btn-creation row">
                                            
                                            <div class="col-12">
                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                <button type="submit" class="btn btn-primary btn-sign btn-signupo"><?php echo $this->lang->line('signup');?></button>
                                            </div>
                                            <span class="terms"><?php echo $this->lang->line('by_sign_up_our');?>
                                                 <a href="<?php echo base_url('pages/id/terms-and-condition'); ?>" ><?php echo $this->lang->line('terms_of_service');?></a> 
                                                 </span>
                                        </div>
                                   </form>
                                   
                               </div>
                               <div class="log-footer">
                                <p class="or"><?php echo $this->lang->line('or_sign_up_with_social');?></p>
                                <a href="<?php echo base_url() ?>index.php/hauth/window/Facebook">
                                    <button class="btn btn-sign1"><span class="fa fa-facebook"></span> <?php echo $this->lang->line('signup');?></button>
                                </a>
                                <a href="<?php echo base_url() ?>index.php/hauth/window/Google">
                                     <button class="btn btn-sign2"><span class="fa fa-google"></span> <?php echo $this->lang->line('signup');?></button>
                                 </a>
                            </div>
                           
                           </div>
                            <div class="sub-foot">
                               <div class="alredy">
                                    <?php echo $this->lang->line('already_have_account');?> <a href="<?php echo base_url('login'); ?>"><?php echo $this->lang->line('login');?></a>
                               </div>
                            </div>
                       </div>
                   </div>
               </section>
            </div>
<?php $this->load->view('footer'); ?>