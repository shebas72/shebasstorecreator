

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('app_comment');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('add_new_app_commnet');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('add_new_app_comment');?> <a href="<?php echo base_url('admin/app/comment_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> All Blogs </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/app/comment') ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('app_name');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="comappname" class="form-control">
                                                <?php foreach ($app as $apps): ?>
                                                    <option value="<?php echo $apps['appid'];?>"><?php echo $apps['apptitle'];?></option>
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
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('user');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="comuser" class="form-control">
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['id'];?>"><?php echo $user['first_name']." ".$user['last_name'];?></option>
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
                                            <textarea name="comcomment" class="form-control"></textarea>
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
                                            <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save_app_comment');?></button>
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