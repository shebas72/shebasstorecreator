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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php if ($siteLang == 'arabic') { echo $pages->pagestitlearb; } else { echo $pages->pagestitle;}?></h2>
                        <ol class="breadcrumb">
                            <li><a href="index.html">Home</a></li>
                            <li class="active"><a href="#"><?php if ($siteLang == 'arabic') {  echo $pages->pagestitlearb; } else {  echo $pages->pagestitle; }?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <!--PRICING SECTION-->
              <div class="container">
                  <div class="row">
                      <div class="col-12">
                          <div class="content-about">
                          	<?php if ($siteLang == 'arabic') { echo $pages->pagescontentarb; } else { echo $pages->pagescontent; }?>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
<?php $this->load->view('footer'); ?>