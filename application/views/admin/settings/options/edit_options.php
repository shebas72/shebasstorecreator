

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('options');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_options');?></li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">

                
            </div>
        </div>
    </div>
    
    <!-- End Bread crumb and right sidebar toggle -->
    

    
    <!-- Start Page Content -->

    <div class="row">
        <div class="col-lg-12">
			 <?php $msg = $this->session->flashdata('msg'); ?>
            <?php if (isset($msg)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_options');?> </h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/options/update') ?>" class="form-horizontal" novalidate >
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('top_header_logo');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $logo_opt = footer_menu_options('toplogo','code_option'); ?>
                                            <input type="hidden" name="headerlogo[id]" class="form-control" value="<?php echo $logo_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="headerlogo[key]" class="form-control" value="<?php echo $logo_opt[0]['optionkey']; ?>">
                                            <input type="url" name="headerlogo[value]" class="form-control" value="<?php echo $logo_opt[0]['optionvalue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('top_header_logo_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $logo_opt = footer_menu_options('toplogo','code_option'); ?>
                                            <input type="hidden" name="headerlogo[id]" class="form-control" value="<?php echo $logo_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="headerlogo[key]" class="form-control" value="<?php echo $logo_opt[0]['optionkey']; ?>">
                                            <input type="url" name="headerlogo[valuearb]" class="form-control" value="<?php echo $logo_opt[0]['optionvaluearb']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
							
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_logo');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $footer_logo_opt = footer_menu_options('footerlogo','code_option'); ?>
                                            <input type="hidden" name="footerlogo[id]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footerlogo[key]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionkey']; ?>">
                                            <input type="url" name="footerlogo[value]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionvalue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_logo_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $footer_logo_opt = footer_menu_options('footerlogo','code_option'); ?>
                                            <input type="hidden" name="footerlogo[id]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footerlogo[key]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionkey']; ?>">
                                            <input type="url" name="footerlogo[valuearb]" class="form-control" value="<?php echo $footer_logo_opt[0]['optionvaluearb']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
							
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('instagram_link');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $int_opt = footer_menu_options('instagram','code_option'); ?>
                                            <input type="hidden" name="instagramlink[id]" class="form-control" value="<?php echo $int_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="instagramlink[key]" class="form-control" value="<?php echo $int_opt[0]['optionkey']; ?>">
                                            <input type="text" name="instagramlink[value]" class="form-control" value="<?php echo $int_opt[0]['optionvalue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('instagram_link_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $int_opt = footer_menu_options('instagram','code_option'); ?>
                                            <input type="hidden" name="instagramlink[id]" class="form-control" value="<?php echo $int_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="instagramlink[key]" class="form-control" value="<?php echo $int_opt[0]['optionkey']; ?>">
                                            <input type="text" name="instagramlink[valuearb]" class="form-control" value="<?php echo $int_opt[0]['optionvaluearb']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
								
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('facebook_link');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $fb_opt = footer_menu_options('facebook','code_option'); ?>
                                            <input type="hidden" name="facebooklink[id]" class="form-control" value="<?php echo $fb_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="facebooklink[key]" class="form-control" value="<?php echo $fb_opt[0]['optionkey']; ?>">
                                            <input type="text" name="facebooklink[value]" class="form-control" value="<?php echo $fb_opt[0]['optionvalue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('facebook_link_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $fb_opt = footer_menu_options('facebook','code_option'); ?>
                                            <input type="hidden" name="facebooklink[id]" class="form-control" value="<?php echo $fb_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="facebooklink[key]" class="form-control" value="<?php echo $fb_opt[0]['optionkey']; ?>">
                                            <input type="text" name="facebooklink[valuearb]" class="form-control" value="<?php echo $fb_opt[0]['optionvaluearb']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
								
								
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('twitter_link');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $tw_opt = footer_menu_options('twitter','code_option'); ?>
                                            <input type="hidden" name="twitterlink[id]" class="form-control" value="<?php echo $tw_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="twitterlink[key]" class="form-control" value="<?php echo $tw_opt[0]['optionkey']; ?>">
                                            <input type="text" name="twitterlink[value]" class="form-control" value="<?php echo $tw_opt[0]['optionvalue']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                     <label class="control-label text-right col-md-3"><?php echo $this->lang->line('twitter_link_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <?php $tw_opt = footer_menu_options('twitter','code_option'); ?>
                                            <input type="hidden" name="twitterlink[id]" class="form-control" value="<?php echo $tw_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="twitterlink[key]" class="form-control" value="<?php echo $tw_opt[0]['optionkey']; ?>">
                                            <input type="text" name="twitterlink[valuearb]" class="form-control" value="<?php echo $tw_opt[0]['optionvaluearb']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
							
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_whatsapp_contact');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ft_wtsapp_opt = footer_menu_options('footerwhatsapp','code_option'); ?>
                                            <input type="hidden" name="footerwhatsapp[id]" class="form-control" value="<?php echo $ft_wtsapp_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footerwhatsapp[key]" class="form-control" value="<?php echo $ft_wtsapp_opt[0]['optionkey']; ?>">
                                            <textarea cols="80" name="footerwhatsapp[value]" rows="10" class="form-control"><?php echo $ft_wtsapp_opt[0]['optionvalue']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_whatsapp_contact_arabic');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ft_wtsapp_opt = footer_menu_options('footerwhatsapp','code_option'); ?>
                                            <input type="hidden" name="footerwhatsapp[id]" class="form-control" value="<?php echo $ft_wtsapp_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footerwhatsapp[key]" class="form-control" value="<?php echo $ft_wtsapp_opt[0]['optionkey']; ?>">
                                            <textarea cols="80" name="footerwhatsapp[valuearb]" rows="10" class="form-control"><?php echo $ft_wtsapp_opt[0]['optionvaluearb']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('office_timing');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ofc_time_opt = footer_menu_options('officetiming','code_option'); ?>
                                            <input type="hidden" name="officetiming[id]" class="form-control" value="<?php echo $ofc_time_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="officetiming[key]" class="form-control" value="<?php echo $ofc_time_opt[0]['optionkey']; ?>">
                                            <textarea cols="80" name="officetiming[value]" rows="10" class="form-control"><?php echo $ofc_time_opt[0]['optionvalue']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('office_timing_arabic');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ofc_time_opt = footer_menu_options('officetiming','code_option'); ?>
                                            <input type="hidden" name="officetiming[id]" class="form-control" value="<?php echo $ofc_time_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="officetiming[key]" class="form-control" value="<?php echo $ofc_time_opt[0]['optionkey']; ?>">
                                            <textarea cols="80" name="officetiming[valuearb]" rows="10" class="form-control"><?php echo $ofc_time_opt[0]['optionvaluearb']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
							
							
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_contact');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ft_contat_opt = footer_menu_options('footercontact','code_option'); ?>
                                            <input type="hidden" name="footercontact[id]" class="form-control" value="<?php echo $ft_contat_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footercontact[key]" class="form-control" value="<?php echo $ft_contat_opt[0]['optionkey']; ?>">
                                            <textarea cols="80"  name="footercontact[value]" rows="10" class="form-control"><?php echo $ft_contat_opt[0]['optionvalue']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_contact_arabic');?> </label>
                                        <div class="col-md-9 controls">
                                            <?php $ft_contat_opt = footer_menu_options('footercontact','code_option'); ?>
                                            <input type="hidden" name="footercontact[id]" class="form-control" value="<?php echo $ft_contat_opt[0]['optionid']; ?>">
                                            <input type="hidden" name="footercontact[key]" class="form-control" value="<?php echo $ft_contat_opt[0]['optionkey']; ?>">
                                            <textarea cols="80"  name="footercontact[valuearb]" rows="10" class="form-control"><?php echo $ft_contat_opt[0]['optionvaluearb']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update');?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- End Page Content -->

</div>