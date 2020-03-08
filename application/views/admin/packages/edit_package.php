

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('packages');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_packages');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit_packages');?> <a href="<?php echo base_url('admin/packages/all_packages_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_packages');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/packages/update/'.$packages->packageid) ?>" class="form-horizontal" novalidate>
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packagetitle" class="form-control" value="<?php echo $packages->packagetitle; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('title_arabic');?> <span class="text-danger"></span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packagetitlearb" class="form-control" value="<?php echo $packages->packagetitlearb; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>


                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_1_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packageprice" class="form-control" required data-validation-required-message="Date is required" value="<?php echo $packages->packageprice; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_12_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packageprice12" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->packageprice12; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_24_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packageprice24" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->packageprice24; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_riyal_1_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packagepricearb" class="form-control" required data-validation-required-message="Date is required" value="<?php echo $packages->packagepricearb; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_riyal_12_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packagepricearb12" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->packagepricearb12; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('price_riyal_24_month');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packagepricearb24" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->packagepricearb24; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_allow');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="pack_domain" class="form-control" required data-validation-required-message="Date is required" value="<?php echo $packages->pack_domain; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('disk_allow');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="pack_disk" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->pack_disk; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('bandwidth_allow');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="pack_bandwidth" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->pack_bandwidth; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('order_number');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="packageorder" class="form-control" required data-validation-required-message="Image is required" value="<?php echo $packages->packageorder; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('Feature');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="packagedefault" class="form-control">
                                                <option value="1" <?php if($packages->packagedefault == 1) { echo "selected"; } ?>>Yes</option>
                                                <option value="2" <?php if($packages->packagedefault != 1) { echo "selected"; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
	
							<div class="row">
                                <div class="col-md-9">
									<div class="form-group row">
										<label class="control-label text-right col-md-3"><?php echo $this->lang->line('attributes');?></label>
										<div class="col-md-9 controls">
											<div id="field">
												<div class="row">
												<?php 
												$indexs = 0;
												foreach($packages_attr  as $index=>$attr): ?>
                                                    <div id="field<?=$index;?>" class="col-md-12 controls form-group">
                                                        <input id="action_name" name="action_key[<?=$attr->packattid;?>]" value="<?=$attr->packattvalue;?>" type="text" placeholder="" class="form-control input-md">
                                                    </div>
                                                    <div id="field<?=$index;?>" class="col-md-12 controls form-group">
                                                        <input id="action_name" name="action_name[<?=$attr->packattid;?>]" value="<?=$attr->packattvalue;?>" type="text" placeholder="" class="form-control input-md">
                                                    </div>
                                                    <div id="field<?=$index;?>" class="col-md-12 controls form-group">
                                                        <input id="action_name" name="action_namearb[<?=$attr->packattid;?>]" value="<?=$attr->packattvaluearb;?>" type="text" placeholder="Arabic Title" class="form-control input-md">
                                                    </div>
													<button type="button" id="delete<?=$index;?>" data-removeit="<?=$index;?>" data-dbit="<?=$attr->packattid;?>" class="btn btn-danger delete-me form-group" ><?php echo $this->lang->line('delete');?></button>
												<?php $indexs = $index; endforeach; ?>
												 </div>
											 </div>
										</div>
									</div>
								</div>
                            </div>
							<div class="row">
                                <div class="col-md-9">
									<div class="form-group row">
										<label class="control-label text-right col-md-3"></label>
                                        <div class="col-md-9 controls">
											<button type="button" id="add-more" name="add-more" class="btn btn-primary add-more"><?php echo $this->lang->line('add_more');?></button>
										</div>
									</div>
								</div>
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