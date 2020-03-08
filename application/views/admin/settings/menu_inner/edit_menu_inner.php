

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('menu_inner');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_menu_inner');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_blog');?> <a href="<?php echo base_url('admin/menuinner/all_menu_inner_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_menu_inner');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/menuinner/update/'.$menuinnner->menuinnerid) ?>" class="form-horizontal" novalidate >
                        <div class="form-body">
                            <br>
							 <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_inner_parent');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="menuinnerparent" id="select" required class="form-control">
												<option value="">Select Your Parent</option>
												<?php foreach ($menus as $menu): ?>
                                                <option value="<?php echo $menu['menuid']; ?>" 
												<?php if($menu['menuid'] == $menuinnner->menuinnerparentid){ echo "selected"; }  ?>><?php echo $menu['menuname']; ?></option>
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
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_inner_title');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="menuinnertitle" class="form-control" value="<?php echo $menuinnner->menuinnertext; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_inner_title_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="menuinnertextarb" class="form-control" value="<?php echo $menuinnner->menuinnertextarb; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
								
							
							<div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('menu_inner_link');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="menuinnerlink" class="form-control" value="<?php echo $menuinnner->menuinnerlink; ?>">
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