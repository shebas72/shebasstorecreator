<?php 
$ci =& get_instance();?>

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('app');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_app');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit');?> <a href="<?php echo base_url('admin/app/app_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_app');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/app/appupdate/'.$app->appid) ?>" class="form-horizontal" novalidate enctype="multipart/form-data">
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">
                                        <?php if(!empty($app->app_icon)) {?>
                                            <img src="<?php echo base_url()."/".$app->app_icon;?>" style="width: 50px;">
                                        <?php } ?>
                                        <?php echo $this->lang->line('app_icon');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="file" name="app_icon" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_category');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select class="form-control" name="appcat_array">
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['app_cat_id'];?>" <?php echo $app->app_icon;?>><?php echo $category['app_cat_name'];?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_title');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="apptitle" value="<?php echo $app->apptitle;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_title_arbic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="apptitlearb" value="<?php echo $app->apptitlearb;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_about_content');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea class="form-control" name="appabout"><?php echo $app->appabout;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_about_content_arabic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea class="form-control" name="appaboutarb"><?php echo $app->appaboutarb;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_feature_content');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea class="form-control" name="app_feature_content"><?php echo $app->app_feature_content;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_feature_content_arabic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea class="form-control" name="app_feature_content_arb"><?php echo $app->app_feature_content_arb;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_filename');?> | <a href="<?php echo base_url("plugins/".$app->appfilename);?>"><?php echo $this->lang->line('view');?></a> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="file" name="appfilename" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_slider');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="file" name="appslider" class="form-control" multiple>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_active');?> </label>
                                        <div class="col-md-9 controls">
                                            <input type="radio" name="appactive" value="1" class="form-control" style="    opacity: 1;    left: 0;    position: relative;    width: 20px;" <?php if($app->appactive == '1') { ?>checked="checked"<?php } ?>>No
                                            <input type="radio" name="appactive" value="2" class="form-control" style="    opacity: 1;    left: 0;    position: relative;    width: 20px;" <?php if($app->appactive == '2') { ?>checked="checked"<?php } ?>>Yes
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <!-- CSRF token -->
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                            <?php if($app->appuser == 0) { ?>
                                <input type="hidden" name="appuser" value="<?php echo $ci->session->userdata('id');?>" />
                            <?php } else { ?>
                                <input type="hidden" name="appuser" value="<?php echo $app->appuser;?>" />
                            <?php } ?>

                            
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