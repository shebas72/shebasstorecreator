

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('domain');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_domain');?></li>
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
                    <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('edit');?> <a href="<?php echo base_url('admin/domain/domain_list') ?>" class="btn btn-info pull-right"><i class="fa fa-list"></i> <?php echo $this->lang->line('all_domain');?> </a></h4>

                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url('admin/domain/update/'.$domain->domainid) ?>" class="form-horizontal" novalidate enctype="multipart/form-data">
                        <div class="form-body">
                            <br>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_user');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="domainuser" class="form-control" >
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['id'];?>" <?php if($domain->domainuser == $user['id']) { echo "selected"; }?>><?php echo $user['first_name']." ".$user['last_name'];?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_title');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="domaintitle" value="<?php echo $domain->domaintitle;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_title_arabic');?><span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="domaintitlearb" value="<?php echo $domain->domaintitlearb;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_subdomain');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="domainsubdomain" value="<?php echo $domain->domainsubdomain;?>" placeholder="Subdomain.storecreator.io">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_link');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="domainlink" value="<?php echo $domain->domainlink;?>" placeholder="example.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('domain_category');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select name="categoryid" class="form-control" >
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['domaincatid'];?>" <?php if($domain->categoryid == $category['domaincatid']) { echo "selected"; }?>><?php echo $category['domaincatname'];?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('seo_description');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea cols="80" name="seodescription" rows="10" class="form-control"><?php echo $domain->seodescription;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('seo_description_arabic');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea cols="80" name="seodescriptionarb" rows="10" class="form-control"><?php echo $domain->seodescriptionarb;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('seo_keywords');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="seokeywords" value="<?php echo $domain->seokeywords;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('seo_keywords_arabic');?><span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" class="form-control" name="seokeywordsarb" value="<?php echo $domain->seokeywordsarb;?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('footer_code');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea cols="80" name="footercode" rows="10" class="form-control"><?php echo $domain->footercode;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('header_code');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <textarea cols="80" name="headercode" rows="10" class="form-control"><?php echo $domain->headercode;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><?php echo $this->lang->line('hide_from_search_engine');?> <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <label>Yes <input type="radio" name="hidefromsearchengine" value="1" <?php if($domain->hidefromsearchengine == '1') { echo 'checked="checked"'; } ?>></label>
                                            <label>No <input type="radio" name="hidefromsearchengine" value="2" <?php if($domain->hidefromsearchengine == '2') { echo 'checked="checked"'; } ?>></label>
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
                                            <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save_domain');?></button>
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