<div id="content-wrapper">
                <!--SHOWCASE SECTION-->
                <section id="section-showcase">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <?php $this->session->flashdata('msg'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="content-image-profile">
                                    <form class="form-horizontal form-material" enctype="multipart/form-data" id="main-form-profile" action="<?php echo base_url('profile/avatar'); ?>" method="post">
                                        <div class="media-container">
                                                <span class="media-overlay">
                                                    <input type="file" name="avatar" id="media-input" accept="image/*" required>
                                                    <span class="fa fa-edit media-icon"></span>
                                                </span>
                                                <figure class="media-object">
                                                    <?php if(empty($user->avatar)) { ?>
                                                        <img class="img-object" src="<?php echo base_url('assets/img');?>/img-profile.jpg">
                                                    <?php } else {?>
                                                        <img class="img-object" src="<?php echo base_url($user->avatar);?>">
                                                    <?php } ?>
                                                </figure>
                                            </div>
                                            <div class="media-control">
                                                <a class="edit-profile btn btn-create2 "><?php echo $this->lang->line('edit_image');?></a>
                                                <button class="save-profile btn btn-create2 "><?php echo $this->lang->line('save_image');?></button>
                                            </div>
                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                        <input type="hidden" name="userid" value="<?= $user->id ?>" />
                                        
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="content-profile-form">
                                    
                                        <div class="form-row">
                                            <div class="form-group  col-md-6">
                                                <label for="input-fname"><?php echo $this->lang->line('first_name');?>:</label>
                                            <input type="text" name="fname" class="form-control" placeholder="Your FName" required title="This is Your FName" value="<?= $user->first_name; ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label for="input-lname"><?php echo $this->lang->line('last_name');?>:</label>
                                                <input type="text"  name="lname" class="form-control" placeholder="Your LName" required title="This is Your LName" value="<?= $user->last_name; ?>" disabled>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="input-email"><?php echo $this->lang->line('email');?>:</label>
                                            <input  type="email" name="email" class="form-control" placeholder="Your Email" required title="This is Your Email" value="<?= $user->email; ?>" disabled>
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label for="input-country"><?php echo $this->lang->line('country');?>:</label>
                                            <?php if(empty($countryName->name)) { $countryname = 'No Country Selected';} else { $countryname = $countryName->name; }?>
                                            <input type="text" name="country" class="form-control" placeholder="Your Country" required title="This is Your Country" value="<?= $countryname ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label for="input-mob"><?php echo $this->lang->line('mobile');?>:</label>
                                                <input type="text" name="mobile" class="form-control" placeholder="Your Mobile" required title="This is Your Mobile" value="<?= $user->mobile ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-6">
                                                    <label for="input-mob"><?php echo $this->lang->line('role');?>:</label>
                                                <input type="text" name="mobile" class="form-control" placeholder="Your Mobile" required title="This is Your Mobile" value="<?= $user->role ?>" disabled>
                                            </div>
                                            <?php if(!empty($user->user_membership) AND $user->user_membership > 0) { ?>
                                                <div class="form-group col-md-6">
                                                        <label for="input-mob"><?php echo $this->lang->line('membership');?>:</label>
                                                    <input type="text" name="membership" class="form-control" placeholder="Your Membership" required title="This is Your Mobile" value="<?= $user->packagetitle ?>" disabled>
                                                </div>
                                            <?php } ?>
                                            <?php if(!empty($user->user_membership) AND $user->user_membership > 0) { ?>
                                                <div class="form-group col-md-6">
                                                    <label for="input-mob"><?php echo $this->lang->line('membership_expiry');?>:</label>
                                                    <input type="text" name="membersipexpire" class="form-control" placeholder="Your Membership" required title="This is Your Membership Expiry" value="<?= $user->user_mem_expire ?>" disabled>
                                                </div>
                                            <?php } ?>
                                            
                                        
                                        </div>
                                        
                                        <button type="button" class="btn btn-create2" data-toggle="modal" data-target="#exampleModalCenter"><?php echo $this->lang->line('edit_profile');?></button>
                                    
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo $this->lang->line('update_your_profile');?></h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="fa fa-times"></span>
                                                  </button>
                                                </div>
                                                <form class="form-horizontal form-material" id="main-form-profile" action="<?php echo base_url('profile/update'); ?>" method="post" name="app-form">
                                                    <div class="modal-body">
                                                		<div class="alert alert-danger errorDiv" role="alert"></div>
                                                                <div class="form-row">
                                                                    <div class="form-group  col-md-6">
                                                                        <label for="input-fname"><?php echo $this->lang->line('first_name');?>:</label>
                                                                    <input id="input-fname" type="text" name="first_name" class="form-control" placeholder="Your FName" required title="This is Your FName" value="<?= $user->first_name ?>" >
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                            <label for="input-lname"><?php echo $this->lang->line('last_name');?>:</label>
                                                                        <input type="text" id="input-lname" name="last_name" class="form-control" placeholder="Your LName" required title="This is Your LName" value="<?= $user->last_name ?>" >
                                                                    </div>
                                                                    <div class="form-group  col-md-6">
                                                                        <label for="input-email"><?php echo $this->lang->line('email');?>:</label>
                                                                    <input id="input-email" type="email" name="email" class="form-control" placeholder="Your Email" required title="This is Your Email" value="<?= $user->email ?>" disabled>
                                                                    </div>
                                                                    <div class="form-group  col-md-6">
                                                                        <label for="input-country"><?php echo $this->lang->line('country');?>:</label>
                                                                    <select class="form-control form-control-line" name="country">

                                                                    <?php foreach ($country as $cn): ?>
                                                                        <?php 
                                                                            if($cn['id'] == $user->country){
                                                                                $selec = 'selected';
                                                                            }else{
                                                                                $selec = '';
                                                                            }
                                                                        ?>
                                                                        <option <?php echo $selec; ?> value="<?php echo $cn['id']; ?>"><?php echo $cn['name']; ?></option>
                                                                    <?php endforeach ?>

                                                                </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                            <label for="input-pass"><?php echo $this->lang->line('password');?>:</label>
                                                                        <input type="password" id="input-pass" name="password" class="form-control" placeholder="Your Password" title="This is Your Password" value="" >
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                            <label for="input-passr"><?php echo $this->lang->line('Re-Password');?>:</label>
                                                                        <input type="password" id="input-passr" name="passwordr" class="form-control" placeholder="Your Re-Password"  title="This is Your Re-Password" >
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-md-6">
                                                                            <label for="input-mob"><?php echo $this->lang->line('mobile');?>:</label>
                                                                        <input type="text" id="input-mob" name="mobile" class="form-control" placeholder="Your Mobile" required title="This is Your Mobile" value="<?= $user->mobile ?>" >
                                                                    </div>
                                                                    
                                                                
                                                                </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
                                                      <button id="updateProfile" type="submit" class="btn btn-primary btn-searcho"><?php echo $this->lang->line('save_changes');?></button>
                                                      <button class="btn btn-primary loading" type="button" disabled>
    												  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    												  <?php echo $this->lang->line('loading');?>...
    												</button>
                                                    </div>
                                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                    <input type="hidden" name="userid" value="<?= $user->id ?>" />
                                                    
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
            