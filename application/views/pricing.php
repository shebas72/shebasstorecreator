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
        <div class="section background-opacity page-titlen set-height-top">
                <div class="container  cont-sub">
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('pricing');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html"<?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('pricing');?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <!--PRICING SECTION-->
                <section id="section-tab-pricing">
                   <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="show-tit text-capitalize text-center"><?php echo $this->lang->line('try_storecreator_free');?></h3>
                                <p class="p-tit-tab text-center"><?php echo $this->lang->line('no_commitment');?></p>
                            </div>
                        </div>
                    </div>
                <div class="container">
                        <nav class="nav-price">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav1 nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo $this->lang->line('for_online_stores');?></a>
                               
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="container cont-prico">
                                    <div class="row">
                                        <?php 
                                        $upgrade = '';
                                        foreach ($pricing as $pricings): ?>
                                             <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-price" id="pricing">
                                                        <ul class="pricing <?php if ($pricings['packagedefault'] == '1') { echo "featured"; }?>">
                                                            <li class="plan-header">
                                                                <div class="price-duration">
                                                                    <span class="price">
                                                                        <?php if ($siteLang == 'arabic') { echo "SR".$pricings['packagepricearb']; } else { echo "$".$pricings['packageprice']; }?>
                                                                    </span>
                                                                </div>
                                    
                                                                <h4 class="plan-name">
                                                                    <?php echo $pricings['packagetitle'];?>
                                                                </h4>
                                                            </li>
                                                            <?php 
                                                            $query = $this->db->get_where('code_packages_attribute', array('packattparent' => $pricings['packageid']));
                                                            $options = $query->result();
                                                                if(!empty($options)){
                                                                    foreach($options as $option){
                                                                        echo "<li>"; 
                                                                        if ($siteLang == b'arabic') { echo $option->packattvaluearb; } else { echo $option->packattvalue;} echo '</li>';
                                                                    }
                                                                }
                                                            ?>
                                                            <?php if(!empty($userdata)) { 
                                                                $userexpiredatestring = $userdata->user_mem_expire;
                                                                ?>
                                                                <?php if(!empty($userdata->user_membership) AND $userdata->user_membership > 0 AND strtotime($userexpiredatestring) > strtotime(date("m/d/Y"))) { 
                                                                    if ($userdata->user_membership == $pricings['packageid'] AND strtotime($userexpiredatestring) > strtotime(date("m/d/Y"))) {?>
                                                                        <li class="plan-purchase"><a class="btn btn-create2" href="#"><?php echo $this->lang->line('current_plan');?></a></li>
                                                                        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=BLDM387UL7SG8"><?php echo $this->lang->line('cancel');?></a>
                                                                    <?php $upgrade = 1; ?>
                                                                    <?php } else { 
                                                                        if ($upgrade == 1) {?>
                                                                        <!-- <li class="plan-purchase"><a class="btn btn-create2" href="<?php echo base_url("check/package/".$pricings['packageid']);?>"><?php echo $this->lang->line('upgrade');?></a></li> -->
                                                                    <?php } else {?>
                                                                        <!-- <li class="plan-purchase"><a class="btn btn-create2" href="<?php echo base_url("check/package/".$pricings['packageid']);?>"><?php echo $this->lang->line('downgrade');?></a></li> -->
                                                                    <?php }
                                                                    } ?>
                                                                <?php } else {?>
                                                                    <li class="plan-purchase"><a class="btn btn-create2" href="<?php echo base_url("check/package/".$pricings['packageid']);?>"><?php echo $this->lang->line('order_now');?></a></li>
                                                                <?php } ?>
                                                                <?php if($userdata->user_membership == 1){?>
                                                                    <li class="plan-purchase"><a class="btn btn-create2" href="<?php echo base_url("check/package/".$pricings['packageid']);?>"><?php echo $this->lang->line('order_now');?></a></li>
                                                                <?php }?>
                                                            <?php } else {?>
                                                                    <li class="plan-purchase"><a class="btn btn-create2" href="<?php echo base_url("signup");?>"><?php echo $this->lang->line('signup');?></a></li>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                </div>
            </section>
            </div>
<?php $this->load->view('footer'); ?>