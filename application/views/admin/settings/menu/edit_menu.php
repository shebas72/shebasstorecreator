

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('menu');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_menu');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_menu');?> <a href="<?php echo base_url('admin/menu/all_menu_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_menu');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/menu/update/'.$menu->menuid) ?>" class="form-horizontal" novalidate >
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_name');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="menuname" class="form-control" value="<?php echo $menu->menuname; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
								
							<div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_location');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="menulocation" class="form-control" value="<?php echo $menu->menulocation; ?>">
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