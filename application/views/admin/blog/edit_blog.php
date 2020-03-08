

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('blog');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_blog');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_blog');?> <a href="<?php echo base_url('admin/blog/all_blog_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('add_blogs');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/blog/update/'.$blog->blogid) ?>" class="form-horizontal" novalidate enctype="multipart/form-data">
                        <div class="form-body">
                            <br>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="blogtitle" class="form-control" value="<?php echo $blog->blogtitle; ?>">
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
                                            <input type="text" name="blogtitlearb" class="form-control" required data-validation-required-message="Title is required" value="<?php echo $blog->blogtitlearb; ?>">
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
											<?php if(!empty($blog->blogimg)) { ?>
											<img src="<?php echo base_url($blog->blogimg); ?>">
											<?php } ?>
                                            <input type="file" name="blogimg" class="form-control" required data-validation-required-message="Image is required">
											<input type="hidden" name="existedImage" value="<?php echo $blog->blogimg; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('date');?> </label>
                                        <div class="col-md-9 controls">
                                            <input type="date" name="blogdate" class="form-control" value="<?php echo $blog->blogdate; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('time');?> </label>
                                        <div class="col-md-9 controls">
                                            <input type="time" name="blogtime" class="form-control" value="<?php echo $blog->blogtime; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('content');?> </label>
                                        <div class="col-md-9 controls">
                                            <textarea class="ckeditor" cols="80" id="editor1" name="blogcontent" rows="10"><?php echo $blog->blogcontent; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('content_arabic');?> </label>
                                        <div class="col-md-9 controls">
                                            <textarea class="ckeditor" cols="80" id="editor2" name="blogcontentarb" rows="10"><?php echo $blog->blogcontentarb; ?></textarea>
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
                                            <button type="submit" class="btn btn-success" name="submit"><?php echo $this->lang->line('update');?></button>
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