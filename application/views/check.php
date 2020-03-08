<?php $this->load->view('header'); ?>
<?php
$ci =& get_instance();
$ci->load->helper('language');
$siteLang = $ci->session->userdata('site_lang');
if ($siteLang) {
} else {
    $siteLang = 'english';
}
?>
    <div class="content1a">
            <div class="section background-opacity page-titlen set-height-top">
                    <div class="container  cont-sub">
                        <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('checkout');?></h2>
                            <ol class="breadcrumb">
                                <li><a href="<?php echo base_url() ?>"><?php echo $this->lang->line('home');?></a></li>
                                <li class="active"><a href="#"><?php echo $this->lang->line('checkout');?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div id="content-wrapper">
                    <!--CHECKOUT FORM SECTION-->
                    <section id="all-content-check">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-9 ">
                                    <div class="content-check-right">
                                        <h2 class="tit-head-check text-capitalize"><?php echo $this->lang->line('plan_term');?></h2>
                                        <div class="messages">
                                            </div>
                                        <div class="cont-form-addons">
                                            <div class="group-head-form-addons">
                                                <div class="group-heading-title-check">
                                                   <h2 class="titchecko">
                                                       <?php echo $selected_packages[0]['packagetitle'];?>
                                                    <a href="<?php echo base_url('pricing') ?>" class="change-btn"><?php echo $this->lang->line('change');?></a>
                                                   </h2>

                                                   <span class="expiration-date"><?php echo $this->lang->line('expires');?>: 
                                                    <?php $dt1 = new DateTime();
                                                    $today = $dt1->format("Y-m-d");

                                                    $dt2 = new DateTime("+1 month");
                                                    $dt12 = new DateTime("+12 month");
                                                    $dt24 = new DateTime("+24 month");
                                                    $date = $dt2->format("Y-m-d");
                                                    $date12 = $dt12->format("Y-m-d");
                                                    $date24 = $dt24->format("Y-m-d");
                                                    echo $date;  ?></span>
                                                </div>
                                                <div class="plans-terms">
                                                
                                                    
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked="checked" data-product="<?php echo $selected_packages[0]['packagetitle'];?>" data-currency="<?php echo $this->lang->line('currency');?>" data-expire="<?php echo $date;?>" data-total="<?php echo number_format((float)$selected_packages[0]['packageprice'], 2, '.', '');?>" data-paypal-id="<?php echo $selected_packages[0]['packagepaypal'];?>" data-month="1">
                                                        <label class="custom-control-label" for="customRadio1">
                                                            <span class="left-month"> <?php echo $this->lang->line('1_month_subscription');?></span>
                                                            <span class="mid-month">
                                                               <div class="plan-price">$<?php echo number_format((float)$selected_packages[0]['packageprice'], 2, '.', '');?>/mo</div>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    
                                                    
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" data-product="<?php echo $selected_packages[0]['packagetitle'];?>" data-currency="<?php echo $this->lang->line('currency');?>" name="customRadio" class="custom-control-input" data-expire="<?php echo $date12;?>" data-total="<?php echo number_format((float)$selected_packages[0]['packageprice12'] * 12, 2, '.', '');?>" data-paypal-id="<?php echo $selected_packages[0]['packagepaypal12'];?>" data-month="12">
                                                        <label class="custom-control-label" for="customRadio2">
                                                            <span class="left-month"> <?php echo $this->lang->line('1_year_subscription');?></span>
                                                            <span class="mid-month">
                                                                <span class="fa fa-star-o"></span>
                                                                <div class="plan-price">$<?php echo number_format((float)$selected_packages[0]['packageprice12'], 2, '.', '');?>/mo</div>
                                                                <div class="save-badge">Save <?php $totalsave = $selected_packages[0]['packageprice'] - $selected_packages[0]['packageprice12'];?>$<?php echo number_format((float)$totalsave, 2, '.', ''); ?></div>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio3" data-product="<?php echo $selected_packages[0]['packagetitle'];?>" data-currency="<?php echo $this->lang->line('currency');?>" name="customRadio" class="custom-control-input" data-expire="<?php echo $date24;?>" data-total="<?php echo number_format((float)$selected_packages[0]['packageprice24'] * 24, 2, '.', '');?>" data-paypal-id="<?php echo $selected_packages[0]['packagepaypal24'];?>" data-month="24">
                                                            <label class="custom-control-label" for="customRadio3">
                                                                <span class="left-month"> <?php echo $this->lang->line('2_year_subscription');?></span>
                                                                <span class="mid-month">
                                                                    <span class="fa fa-star-o"></span>
                                                                    <div class="plan-price">$<?php echo number_format((float)$selected_packages[0]['packageprice24'], 2, '.', '');?>/mo</div>
                                                                    <div class="save-badge">Save <?php $totalsave = $selected_packages[0]['packageprice'] - $selected_packages[0]['packageprice24'];?>$<?php echo number_format((float)$totalsave, 2, '.', ''); ?></div>
                                                                </span>
                                                            </label>
                                                        </div>
                                                </div>
                                                 
                                            </div>
                                        </div>
                                        <div class="footer-legal">
                                            <p class="tit-footer-legal">
                                                    *<?php echo $this->lang->line('by_submitting_you_agree_to_our');?>
                                                <a href="<?php echo base_url() ?>pages/id/terms-and-condition" target="_blank"> <?php echo $this->lang->line('term_of_service_&_privacy_notice');?>.</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 ">
                                    <div class="card card-aside">
                                        <div class="card-header">
                                            <h4 class="cart-subtitle"><?php echo $this->lang->line('order_summary');?></h4>
                                            
                                        </div>
                                        <div class="card-body">
                                                <ul class="orderlist">
                                                    <li class="summry-cart-region">
                                                        <div><div style="display: flex;">
                                                            <div style="flex: 2;">
                                                                <label> <?php echo $selected_packages[0]['packagetitle'];?></label>
                                                            </div>
                                                            <div style="flex: 1;">
                                                                <span class="pull-right">$<b><?php echo number_format((float)$selected_packages[0]['packageprice'], 2, '.', '');?></b></span>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </li>
                                                    <li class="summry-money-region">
                                                            <div>
                                                                <div class="cart__total">
                                                                    <label>Total</label>
                                                                    <span class="cart__total--price pull-right js-cart-total-price">
                                                                            $<b><?php echo number_format((float)$selected_packages[0]['packageprice'], 2, '.', '');?></b>
                                                                    </span>
                                                                    <input type="hidden" id="getTotal" value="<?php echo number_format((float)$selected_packages[0]['packageprice'], 2, '.', '');?>" />
                                                                </div>
                                                            </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" href="#" class="btn btn-create2 btn-check" data-toggle="modal" data-target="#exampleModal" data-target=".bd-example-modal-xl" data-target="#exampleModalCenter"><?php echo $this->lang->line('checkout');?></button>
                                                <div class="modal fade" id="exampleModal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                               <!-- <button type="button" class="close closen" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">cancel</span>
                                                              </button>-->
                                                              <h5 class="modal-title tit-mode-pay" id="exampleModalLabel"><?php echo $this->lang->line('select_payment_method');?></h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                             <!-- <button type="button" class="close saving">
                                                                   <a href="#">save</a>
                                                              </button>-->
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-check">
                                                                            <form name="myform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                                                                <input type="hidden" name="cmd" value="_s-xclick">
                                                                                <input type="hidden" name="quantity" value="1"> 
                                                                                <input type="hidden" name="return" value="https://storecreator.io/check/success">
                                                                                <input type="hidden" name="cancel_return" value="https://storecreator.io/check/cancel">
                                                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                                                <input type='hidden' name='notify_url' value='http://storecreator.io/check/paypalipn'>
                                                                                <input type='hidden' name='custom0' class='custom0' value='<?php echo $ci->session->userdata('id');?>'>
                                                                                <input type='hidden' name='custom1' class='custom1' value='<?php echo $id;?>'>
                                                                                <input type='hidden' name='custom2' class='custom2' value='<?php print_r($selected_packages[0]['packagetitle']);?>'>
                                                                                <input type='hidden' name='custom3' class='custom3' value='1'>
                                                                                <input type='hidden' name='custom' value='<?php echo $ci->session->userdata('id');?>&<?php echo $id;?>&<?php print_r($selected_packages[0]['packagetitle']);?>&1' class="custom">
                                                                                
                                                                                <input type="hidden" name="hosted_button_id" value="<?php echo $selected_packages[0]['packagepaypal'];?>" class="changepaypalid">

                                                                                <button type="submit"><img class="paypal" src="<?php echo base_url() ?>assets/img/logopaypal.jpg"  alt=""></button>
                                                                            </form>
                                                                        </div>      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                   
                </div>
    </div>
<?php echo $this->load->view('footer'); ?>