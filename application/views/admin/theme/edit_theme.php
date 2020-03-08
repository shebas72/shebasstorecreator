

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('theme');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_theme');?></li>
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
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_theme');?> <a href="<?php echo base_url('admin/theme/all_theme_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_themes');?></a></h4>

                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/theme/update/'.$theme->themeid) ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Type <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">

                                            <select id="inputState" class="form-control" name="themetype">
                                              <option><?php echo $this->lang->line('choose');?>...</option>
                                              <option value="Event" <?php if($theme->themetype == 'Event') { echo "selected"; } ?>><?php echo $this->lang->line('event');?></option>
                                                <option value="Business" <?php if($theme->themetype == 'Business') { echo "selected"; } ?>><?php echo $this->lang->line('business');?></option>
                                                <option value="Portfolio" <?php if($theme->themetype == 'Portfolio') { echo "selected"; } ?>><?php echo $this->lang->line('portfolio');?></option>
                                                <option value="Online Store" <?php if($theme->themetype == 'Online Store') { echo "selected"; } ?>><?php echo $this->lang->line('online_store');?></option>
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
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themetitle" class="form-control" value="<?php echo $theme->themetitle; ?>">
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
                                            <input type="text" name="themetitlearb" class="form-control"  value="<?php echo $theme->themetitlearb; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('image');?> </label>
                                        <div class="col-md-9 controls">
											<img src="<?php echo base_url($theme->themeimage); ?>" style="width:100px;">
                                            <input type="file" name="themeimage" class="form-control" value="<?php echo $theme->themeimage; ?>">
											<input type="hidden" name="existedImage" value="<?php echo $theme->themeimage; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('theme_folder_name');?> </label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themefolder" class="form-control" value="<?php echo $theme->themefolder; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('theme_link_name');?> </label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="themelink" class="form-control" value="<?php echo $theme->themelink; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="themeuser" value="<?php echo $theme->themeuser;?>" />

                            
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