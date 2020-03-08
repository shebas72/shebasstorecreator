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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('blog');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a><?php echo $this->lang->line('blog');?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="container-fluid cont-sub-blog">
                <div class="row">
                    <div class="col-md-8">
                        <div class="blog-tit">
                            <span class="follow-us-text"><?php echo $this->lang->line('follow');?></span>
                            <ul class="list-inline icon-soc">
                                <?php 
                                    $fb_opt = footer_menu_options('facebook','code_option');
                                    $tw_opt = footer_menu_options('twitter','code_option');
                                    $int_opt = footer_menu_options('instagram','code_option');
                                ?>
                                <li class="list-inline-item"><a href="<?php echo $fb_opt[0]['optionvalue']; ?>" class="socialoa"><span class="fa fa-instagram socialim"></span></a></li>
                                <li class="list-inline-item"><a href="<?php echo $tw_opt[0]['optionvalue']; ?>" class="socialoa"><span class="fa fa-facebook socialim"></span></a></li>
                                <li class="list-inline-item"><a href="<?php echo $int_opt[0]['optionvalue']; ?>" class="socialoa"><span class="fa fa-twitter socialim"></span></a></li>
                           </ul>
        
                        </div>
                    </div>
                    <div class="col-md-4">
                          <form method="post" action="<?php echo base_url('blog/search') ?>" class="form-horizontal" novalidate>
                            <div class="input-group">
                              <input type="text" name="query" class="form-control input-searcho" placeholder="Search article">
                              <div class="input-group-btn">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                <button class="btn btn-primary btn-searcho" type="submit">
                                  <i class="fa fa-search"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
            <div id="content-wrapper2">
                <!--SHOWCASE SECTION-->
                <section id="section-showcase">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                              <?php foreach ($blog_content as $page_blog_content) { ?>
                                <h3 class="show-tit text-capitalize text-center"><?php if ($siteLang == 'arabic') { echo $page_blog_content['pagestitlearb']; } else { echo $page_blog_content['pagestitle']; }?></h3>
                                <?php if ($siteLang == 'arabic') { echo $page_blog_content['pagescontentarb']; } else { echo $page_blog_content['pagescontent']; }?>
                              <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                    <div class="row">
                      <?php if (count($blogs) == 0) {
                        echo "<h2 style='text-align:center; width:100%;'>";?><?php echo $this->lang->line('sorreynoresult');?></h2>
                     <?php } else { ?>
                        <?php foreach ($blogs as $blog): ?>
                          <div class="col-lg-4 col-md-6 ">
                              <div class="single-event-item">
                                  <div class="single-event-image">
                                      <a href="<?php echo base_url(); ?>blog/id/<?php echo $blog['blogid']; ?>">
                                        <?php if ($blog['blogimg'] != ''): ?>
                                          <img src="<?php echo base_url(); ?><?php echo $blog['blogimg']; ?>" alt="" style="max-width: 450px;">
                                        <?php else: ?>
                                          <img src="<?php echo base_url(); ?>assets/img/Default-img.png" alt="">
                                        <?php endif ?>
                                          <span><?php echo $blog['blogdate']; ?></span>
                                      </a>
                                  </div>
                                  <div class="single-event-text">
                                      <h3><a href="<?php echo base_url(); ?>blog/id/<?php echo $blog['blogid']; ?>"><?php if ($siteLang == 'arabic') { echo $blog['blogtitlearb'];  } else { echo $blog['blogtitle'];  } ?></a></h3>
                                      <div class="single-item-comment-view">
                                         <span><span class="fa fa-clock-o"></span><?php echo $blog['blogtime']; ?></span>
                                     </div>
                                     <p><?php if ($siteLang == 'arabic') { echo mb_strimwidth(strip_tags($blog['blogcontentarb'], '<p><a>'), 0, 100, '...'); } else { echo mb_strimwidth(strip_tags($blog['blogcontent'], '<p><a>'), 0, 100, '...'); } ?></p>
                                     <a class="button-default btn-create2 text-uppercase" href="<?php echo base_url(); ?>blog/id/<?php echo $blog['blogid']; ?>"><?php echo $this->lang->line('more_details');?></a>
                                  </div>
                              </div>
                          </div>
                        <?php endforeach ?>
                      <?php } ?>
                    </div>
                    <?php if (count($blogs) > 6) { ?>
                      <div class="row">
                          <div class="col-12">
                              <div class="text-center text-uppercase">
                                  <a href="#" class="btn-create2 btn-loadingo" id="loadMore"><?php echo $this->lang->line('load_more_posts');?>...</a>
                              </div>
                          </div>
                      </div>
                    <?php } ?>
                    </div>
                </section>
            </div>
<?php $this->load->view('footer'); ?>