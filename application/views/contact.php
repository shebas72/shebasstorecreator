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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('contact_us');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('contact_us');?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="content-wrapper2">
                <!--PRICING SECTION-->
              <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="nav flex-column nav-pills aside-cont" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-aside nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php echo $this->lang->line('spam');?></a>
                            <a class="nav-aside nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><?php echo $this->lang->line('dmca');?></a>
                            <a class="nav-aside nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><?php echo $this->lang->line('support');?></a>
                            <a class="nav-aside nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><?php echo $this->lang->line('partnerhip');?></a>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="blog-details">
                                            <h3 class="tit-blog"><?php echo $this->lang->line('spam_complaints');?></h3>
                                            <p><?php echo $this->lang->line('we_are_sorry');?></p>
                                            <p><?php echo $this->lang->line('we_hate_spam');?></p>
                                            <p><?php echo $this->lang->line('this_page_is_here');?></p>
                                            <p><?php echo $this->lang->line('if_you_need_help');?><a href="index.html"><?php echo $this->lang->line('storecreator');?></a></p>
                                            
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                        <div class="cont-form-contact">
                                                              
                                                                <form method="post" action="<?php echo base_url('contact') ?>" class="form-horizontal" novalidate>

                                                                    <input type="hidden" name="contacttype" class="form-control" required value="Spam">

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contacttitle" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('title');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contactname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_full_name');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="email" class="form-control" name="contactemail" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>"> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="<?php echo $this->lang->line('enter_your_comment');?>" name="contactcontent"></textarea>
                                                                    </div>
                                                                   <div class="btn-create">
                                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                                        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('submit');?></button>
                                                                   </div>
                                                                </form>
                                                            </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="blog-details">
                                            <h3 class="tit-blog"><?php echo $this->lang->line('dmca_complaints');?></h3>
                                            <p><?php echo $this->lang->line('we_are_sorry2');?></p>
                                            <p><?php echo $this->lang->line('we_hate_spam2');?></p>
                                            <p><?php echo $this->lang->line('this_page_is_here2');?></p>
                                            <p><?php echo $this->lang->line('if_you_need_help2');?><a href="index.html"><?php echo $this->lang->line('storecreator');?></a></p>
                                            
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                        <div class="cont-form-contact">
                                                              
                                                                <form method="post" action="<?php echo base_url('contact') ?>" class="form-horizontal" novalidate>

                                                                    <input type="hidden" name="contacttype" class="form-control" required value="Dmca">

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contacttitle" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('title');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contactname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_full_name');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="email" class="form-control" name="contactemail" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>"> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="<?php echo $this->lang->line('enter_your_comment');?>" name="contactcontent"></textarea>
                                                                    </div>
                                                                   <div class="btn-create">
                                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                                        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('submit');?></button>
                                                                   </div>
                                                                </form>
                                                            </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"><div class="blog-details">
                                    <h3 class="tit-blog"><?php echo $this->lang->line('support');?></h3>
                                            <p><?php echo $this->lang->line('we_are_sorry3');?></p>
                                            <p><?php echo $this->lang->line('we_hate_spam3');?></p>
                                            <p><?php echo $this->lang->line('this_page_is_here3');?></p>
                                            <p><?php echo $this->lang->line('if_you_need_help3');?><a href="index.html"><?php echo $this->lang->line('storecreator');?></a></p>
                                    
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                                <div class="cont-form-contact">
                                                      
                                                        <form method="post" action="<?php echo base_url('contact') ?>" class="form-horizontal" novalidate>

                                                            <input type="hidden" name="contacttype" class="form-control" required value="Support">

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="contacttitle" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('title');?>"> 
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="contactname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_full_name');?>"> 
                                                            </div>

                                                            <div class="form-group">
                                                                <input type="email" class="form-control" name="contactemail" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>"> 
                                                            </div>
                                                            <div class="form-group">
                                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="<?php echo $this->lang->line('enter_your_comment');?>" name="contactcontent"></textarea>
                                                            </div>
                                                           <div class="btn-create">
                                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('submit');?></button>
                                                           </div>
                                                        </form>
                                                    </div>
                                        </div>
                                    </div>
                                </div></div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    <div class="blog-details">
                                            <h3 class="tit-blog"><?php echo $this->lang->line('partnership');?></h3>
                                            <p><?php echo $this->lang->line('we_are_sorry4');?></p>
                                            <p><?php echo $this->lang->line('we_hate_spam4');?></p>
                                            <p><?php echo $this->lang->line('this_page_is_here4');?></p>
                                            <p><?php echo $this->lang->line('if_you_need_help4');?><a href="index.html"><?php echo $this->lang->line('storecreator');?></a></p>
                                            
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                        <div class="cont-form-contact">
                                                              
                                                                <form method="post" action="<?php echo base_url('contact') ?>" class="form-horizontal" novalidate>

                                                                    <input type="hidden" name="contacttype" class="form-control" required value="Partnership">

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contacttitle" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('title');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="contactname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_full_name');?>"> 
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="email" class="form-control" name="contactemail" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $this->lang->line('your_email_address');?>"> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="<?php echo $this->lang->line('enter_your_comment');?>" name="contactcontent"></textarea>
                                                                    </div>
                                                                   <div class="btn-create">
                                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                                        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('submit');?></button>
                                                                   </div>
                                                                </form>
                                                            </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            </div>
                    </div>
                </div>
              </div>
            </div>
<?php $this->load->view('footer'); ?>