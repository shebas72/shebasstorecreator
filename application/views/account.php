<?php $this->load->view('header'); 

$ci =& get_instance();
// load language helper
// if ($siteLang == 'arabic') {  } else { }
// $this->lang->line('themes_Responsive_themes');
$ci->load->helper('language');
$siteLang = $ci->session->userdata('site_lang');
if ($siteLang) {
} else {
    $siteLang = 'english';
}?>

    <style>
       .form-sub{
           display: none;
       }
       .form-full{
           display: none;
       }
       .open-sub-domain ,.open-full-domain{
        color: #387ac4;
        font-size: 18px;
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
        transition: all 0.7s ease;
       }
       .open-sub-domain:hover,.open-full-domain:hover{
        color: #37bea7;
       }
       .form-group label{
           display:block;
       }
       table{
           background: #fff !important;
           text-align: center;

       }
       thead{
           background: #37bea7;
           color: #fff;
       }
    </style>
            <!--HEAD DEVELOPER SECTION-->
        <section id="section-head-develop" class="bg-overlo" style="    height: 200px !important;    min-height: 200px;">
                <div class="overlay" style="    height: 200px !important;    min-height: 200px;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="tit-developer"><span>S</span>toreCreator <?php echo $this->lang->line('domains');?></h1>
                          
                        </div>
                    </div>
                </div>
            </section>
            <div id="content-wrapper">
                <!--SHOWCASE SECTION-->
                <section id="section-showcase">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('create_store');?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                          <div class="form-group col-md-12">
                            <table class="table table-bordered">
                                <thead class="">
                                  <tr>
                                    <th scope="col">#</th>
                                    
                                    <th scope="col"><?php echo $this->lang->line('your_domain');?></th>

                                    <th scope="col"><?php echo $this->lang->line('action');?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 0;?>
                                  <?php foreach ($domainlist as $domainlist_value) { ?>
                                    <?php $i++; ?>
                                    <tr>
                                      <th scope="row"><?php echo $i;?></th>
                                      
                                      <td><?php echo $domainlist_value['domaintitle'];?></td>
                                      <td><a href="https://<?php echo $domainlist_value['domainlink'];?>/wp-admin" target="_blank"><?php echo $this->lang->line('edit');?></a> | <a href="<?php echo base_url("createstore/delete/"); ?>/<?php echo $domainlist_value['domainid'];?>"><?php echo $this->lang->line('delete');?></a> | <a href="https://<?php echo $domainlist_value['domainlink'];?>" target="_blank"><?php echo $this->lang->line('view');?></a> | <a href="<?php echo base_url("createstore/successfully/"); ?><?php echo $domainlist_value['domainid'];?>"><?php echo $this->lang->line('reconfigure');?></a> | <a href="<?php echo base_url("createstore/upgrade/"); ?><?php echo $domainlist_value['domainid'];?>"><?php echo $this->lang->line('upgrade');?></a><br>
                                        <p style="text-align: center;"><b>Admin access</b> <?php echo $domainlist_value['domainlink'];?>/wp-admin<br>
                                        <b>user:</b> storecreator</br>
                                        <b>pass:</b> y4u5AlcdEMoO1kMMB00NdMP2<br>
                                        <b>Note: It is recommended to change password</b></p></td>
                                    </tr>
                                  <?php } ?>
                            </tbody>
                          </table>
                          </div>
                          <?php if ($totaldomainlist > $perpage) {?>
                            <div class="form-group col-md-12">
                                <nav class="pagination col-md-12">
                                    <ul class="pagination__list list-unstyled p-0 m-0">
                                        <?php if (isset($pageid)) { ?>
                                          <li><a rel="prev" <?php if($pageid == 1) { ?>href="#" class="pagination__previous btn-squae disable" <?php } else { ?>href="<?php echo base_url("createstore/page/"); ?><?php echo $pageid - 1;?>" class="pagination__previous btn-squae" <?php }?>>‹</a></li>
                                        <?php } else {?>
                                          <li><a rel="prev" href="#" class="pagination__previous btn-squae disable">‹</a></li>
                                        <?php } ?>
                                        <?php $pagelist = $totaldomainlist / $perpage;
                                        for ($i=0; $i < $pagelist; $i++) { ?>
                                          <?php if(isset($pageid)) { ?>
                                              <li><a <?php if($pageid == $i + 1) { } else { ?> href="<?php echo base_url("createstore/page/"); ?><?php echo $i + 1;?>" <?php } ?> class="pagination__page btn-squae <?php if($pageid == $i + 1) { echo 'active'; } ?>"><?php echo $i + 1; ?></a></li>
                                          <?php } else {?>
                                            <?php if($i == 0) { ?>
                                              <li><a class="pagination__page btn-squae active"><?php echo $i + 1; ?></a></li>
                                            <?php } else {?>
                                              <li><a href="<?php echo base_url("createstore/page/"); ?><?php echo $i + 1;?>" class="pagination__page btn-squae"><?php echo $i + 1; ?></a></li>
                                            <?php } ?>
                                          <?php } ?>
                                        <?php } ?>
                                        <?php if (isset($pageid)) { ?>
                                          <?php if($pageid == $pagelist) { ?>
                                            <li><a rel="next" href="<?php echo base_url("createstore/page/"); ?><?php echo $pageid + 1;?>" class="pagination__next btn-squae disable">›</a></li>
                                          <?php } else { ?>
                                            <li><a rel="next" href="<?php echo base_url("createstore/page/"); ?><?php echo $pageid + 1;?>" class="pagination__next btn-squae">›</a></li>
                                          <?php } ?>
                                        <?php } else { ?>
                                          <li><a rel="next" href="<?php echo base_url("createstore/page/"); ?>2" class="pagination__next btn-squae">›</a></li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                          <?php } ?>
                            <div class="col-md-12">
                                <p class="displayonfulldomain" style="text-align: center;    font-weight: bold; display: none;">You have to change your domain nameserver to <br>
                                  ns1.storecreator.io<br>
                                  ns2.storecreator.io</p>
                                <div class="content-profile-form">
                                        <div class="form-row" id="domainvalidateform">
                                            <div class="form-group  col-md-6">
                                                <label for="input-domain-t"><?php echo $this->lang->line('domain_title');?>:</label>
                                                <input id="input-domain-t" type="text" name="domain-title" class="form-control" placeholder="Your Domain Title" required title="This is Your Domain Title" value="<?php if(!empty($editdomain)) { echo $editdomain->domaintitle; }?>" required>
                                            </div>

                                            <div class="form-group  col-md-6">
                                                <label for="input-domain-t"><?php echo $this->lang->line('domain_name');?>:</label>
                                                <input id="input-domain-t-name" type="text" name="domain-link" class="form-control" placeholder="Your Domain Name" required title="This is Your Domain Link" value="<?php if(!empty($editdomain)) { echo $editdomain->domainlink; }?>" required>
                                                <div class="avilablehtml"></div>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="input-domain-t"><?php echo $this->lang->line('category');?>:</label>
                                                <select name="category" class="form-control selectcategory">
                                                  <option>Select Category</option>
                                                  <?php foreach ($domaincategory as $domaincategory_value) { ?>
                                                    <option value="<?php echo $domaincategory_value['domaincatid'];?>" <?php if(!empty($editdomain)) { if($editdomain->categoryid == $domaincategory_value['domaincatid']) { echo "selected"; } }?>><?php if ($siteLang == 'arabic') { echo $domaincategory_value['domaincatnamearb']; } else { echo $domaincategory_value['domaincatname']; }?></option>
                                                  <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="input-domain-t"><?php echo $this->lang->line('option');?>:</label>
                                                <input type="radio" name="subdomain" value="1" checked="checked" class="form-control" id="input-domain-t-opt-sub"> <label for="input-domain-t-opt-sub" style="text-align: center;">Sub Domain</label>
                                                <input type="radio" name="subdomain" value="2" class="form-control" id="input-domain-t-opt"> <label for="input-domain-t-opt" style="text-align: center;">Full Domain</label>
                                            </div>
                                            <div class="form-group  col-md-12" style="text-align: center;">
                                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                            <?php if(!empty($editdomain)) {?> 
                                              <input type="hidden" name="domainid" value="<?php echo $editdomain->domainid;?>">
                                              <button type="submit" class="btn btn-create2 createstore1" type="submit" data-target="#exampleModalCenter" name="updatedomain"><?php echo $this->lang->line('update_domain');?></button>
                                            <?php } else {?>
                                              <button type="submit" class="btn btn-create2 createstore1" type="submit" data-target="#exampleModalCenter" name="adddomain"><?php echo $this->lang->line('add_domain');?></button>
                                            <?php } ?>
                                          </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
<?php $this->load->view('footer'); ?>