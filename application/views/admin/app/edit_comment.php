

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('app_comment');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_app_comment');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_comment');?> <a href="<?php echo base_url('admin/app/categories_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_categories');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/app/commentupdate/'.$comment->app_com_id) ?>" class="form-horizontal" novalidate enctype="multipart/form-data">
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_name');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="comappname" class="form-control">
                                                <?php foreach ($app as $apps): ?>
                                                    <option value="<?php echo $apps['appid'];?>" <?php if ($comment->app_com_user == $apps['appid']) { echo "selected"; } ?>><?php echo $apps['apptitle'];?></option>
                                                <?php endforeach ?>
                                                <option value="1" <?php if ($comment->app_com_appid == '1') { echo "selected"; } ?>>t</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('user');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="comuser" class="form-control">
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['id'];?>" <?php if ($comment->app_com_user == $user['id']) { echo "selected"; } ?>><?php echo $user['first_name']." ".$user['last_name'];?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('comment');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea name="comcomment" class="form-control"><?php echo $comment->app_com_comment;?></textarea>
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