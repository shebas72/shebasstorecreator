    <?php $this->load->view('header'); ?>
    <?php $ci =& get_instance();
    // load language helper
    // if ($siteLang == 'arabic') {  } else { }
    // $this->lang->line('themes_Responsive_themes');
    $ci->load->helper('language');
    $siteLang = $ci->session->userdata('site_lang');
    if ($siteLang) {
    } else {
        $siteLang = 'english';
    }?>
        <div class="content1a">
                <div class="section background-opacity page-titlen set-height-top">
                        <div class="container  cont-sub">
                            <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('checkout');?></h2>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo base_url() ?>"><?php echo $this->lang->line('home');?></a></li>
                                    <li ><a href="#"><?php echo $this->lang->line('checkout');?></a></li>
                                    <li class="active"><a href="#"><?php echo $this->lang->line('success');?></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div id="content-wrapper">
                        <h1><?php echo $this->lang->line('your_order_has_been_canceled');?></h1>
                    </div>
        </div>
<?php $this->load->view('footer'); ?>