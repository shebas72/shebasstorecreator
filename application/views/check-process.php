        <?php $this->load->view('header'); ?>
    <?php 

    $ci =& get_instance();
    // load language helper
    // if ($siteLang == 'arabic') {  } else { }
    // $this->lang->line('themes_Responsive_themes');
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
                            <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php $this->lang->line('checkout');?></h2>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo base_url() ?>"><?php $this->lang->line('home');?></a></li>
                                    <li class="active"><a href="#"><?php $this->lang->line('checkout');?></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div id="content-wrapper">
                       <h2 style="text-align: center;"><?php $this->lang->line('thank_you_for_purchasing');?>!</h2>
                    </div>
        </div>
<?php $this->load->view('footer'); ?>