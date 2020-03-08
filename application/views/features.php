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
        <!--SLIDER SECTION-->
        <section id="section-head-develop" class="bg-overlo" style="    height: 200px !important;    min-height: 200px;">
            <div class="overlay" style="    height: 200px !important;    min-height: 200px;"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="tit-developer"><span>S</span>toreCreator Feature</h1>
                      
                    </div>
                </div>
            </div>
        </section>
        <section id="tab-icons">
            <div class="container">
              <?php if ($siteLang == 'arabic') { echo $feature->pagescontentarb; } else { echo $feature->pagescontent; } ?>
            </div>
        </section>
 <?php $this->load->view('footer'); ?>