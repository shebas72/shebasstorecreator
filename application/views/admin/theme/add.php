<?php
$ci =& get_instance();?>


<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('theme');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('add_new_theme');?></li>
            </ol>
        </div>
        
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    

    
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-lg-12">

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>
            
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('add_new_theme');?> <a href="<?php echo base_url('admin/theme/all_theme_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_themes');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/theme/add') ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('type');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select id="inputState" class="form-control" name="themetype">
                                              <option selected><?php echo $this->lang->line('choose');?>...</option>
                                              <option value="Event"><?php echo $this->lang->line('event');?></option>
                                                <option value="Business"><?php echo $this->lang->line('business');?></option>
                                                <option value="Portfolio"><?php echo $this->lang->line('portfolio');?></option>
                                                <option value="Online Store"><?php echo $this->lang->line('online_store');?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('type_arabic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select id="inputState" class="form-control" name="themetypearb">
                                              <option selected><?php echo $this->lang->line('choose_arb');?>...</option>
                                              <option value="<?php echo $this->lang->line('event_arb');?>"><?php echo $this->lang->line('event_arb');?></option>
                                                <option value="<?php echo $this->lang->line('business_arb');?>"><?php echo $this->lang->line('business_arb');?></option>
                                                <option value="<?php echo $this->lang->line('portfolio_arb');?>"><?php echo $this->lang->line('portfolio_arb');?></option>
                                                <option value="<?php echo $this->lang->line('online_store_arb');?>"><?php echo $this->lang->line('online_store_arb');?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themetitle" class="form-control" required data-validation-required-message="Title is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title_arabic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themetitlearb" class="form-control" required data-validation-required-message="Title is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('image');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="file" name="themeimage" class="form-control" required data-validation-required-message="Date is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('theme_folder_name');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themefolder" class="form-control" required data-validation-required-message="Date is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('theme_link_name');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themelink" class="form-control" required data-validation-required-message="Date is required">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>



                            <!-- CSRF token -->
                            <input type="hidden" name="themeuser" value="<?php echo $ci->session->userdata('id');?>" />
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"></label>
                                        <div class="controls">
                                            <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save_theme');?></button>
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