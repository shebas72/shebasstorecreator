<?php $this->load->view('header'); ?>
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
    <!--HEAD DEVELOPER SECTION-->
    <section id="section-head-develop">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="tit-developer"><span>S</span>toreCreator <?php echo $this->lang->line('developer_center');?></h1>
                    <h3 class="sub-tit-dev"><?php echo $this->lang->line('build_apps_&_themes_for_over_30m_users');?></h3>
                    <a href="https://storecreator.io/developer/signup" class="btn btn-create2 text-uppercase btn-get"><?php echo $this->lang->line('get_started');?></a>
                  
                </div>
            </div>
        </div>
    </section>
    <?php echo $developer->pagescontent;?>
<?php $this->load->view('footer'); ?>