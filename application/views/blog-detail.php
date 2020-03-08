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
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php if ($siteLang == 'arabic') { echo $blog->blogtitlearb; } else { echo $blog->blogtitle; } ?></h2>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home');?></a></li>
                            <li><a href="<?php echo base_url(); ?>blog"><?php echo $this->lang->line('blog');?></a></li>
                            <li class="active"><a><?php if ($siteLang == 'arabic') { echo $blog->blogtitlearb;  } else { echo $blog->blogtitle; }?></a></li>
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
                              <input type="text" name="query" class="form-control input-searcho" placeholder="<?php echo $this->lang->line('search_article');?>">
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
                <!--<?php if ($siteLang == 'arabic') { echo $blog->blogtitlearb; } else { echo $blog->blogtitle; }  ?> SECTION-->
                <section id="section-showcase">
                   <article id="article-cont">
                       <div class="container">
                           <div class="row">
                               <div class="col-lg-2"></div>
                               <div class="col-lg-8">
                                    <div class="single-event-item-det">
                                        <div class="single-event-image">
                                            <?php if ($blog->blogimg != ''): ?>
                                              <img src="<?php echo base_url(); ?><?php echo $blog->blogimg; ?>" alt="">
                                            <?php else: ?>
                                              <img src="<?php echo base_url(); ?>assets/img/Default-img.png" alt="">
                                            <?php endif ?>
                                            <span class="day-blog-det"><?php echo $blog->blogdate; ?></span>
                                        </div>
                                        <div class="blog-details">
                                            <h3 class="tit-blog"><?php if ($siteLang == 'arabic') { echo $blog->blogtitlearb; } else { echo $blog->blogtitle; }?></h3>
                                            <p><?php if ($siteLang == 'arabic') { echo $blog->blogcontentarb; } else { echo $blog->blogcontent; } ?></p>
                                        </div>
                                        <div class="blog-latest container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="tit-lat text-capitalize"><?php echo $this->lang->line('latest_blogs');?></h3>
                                                </div>
                                                <div class="row">
                                                    <?php foreach ($latestblog as $latestblogs): ?>
                                                        <div class="col-lg-6 col-sm-11">
                                                            <div class="single-event-item">
                                                              <div class="single-event-image">
                                                                  <a href="<?php echo base_url(); ?>blog/id/<?php echo $latestblogs['blogid']; ?>">
                                                                    <?php if ($latestblogs['blogimg'] != ''): ?>
                                                                      <img src="<?php echo base_url(); ?><?php echo $latestblogs['blogimg']; ?>" alt="" style="max-width: 450px;">
                                                                    <?php else: ?>
                                                                      <img src="<?php echo base_url(); ?>assets/img/Default-img.png" alt="">
                                                                    <?php endif ?>
                                                                      <span><?php echo $latestblogs['blogdate']; ?></span>
                                                                  </a>
                                                              </div>
                                                              <div class="single-event-text">
                                                                  <h3><a href="<?php echo base_url(); ?>blog/id/<?php echo $latestblogs['blogid']; ?>"><?php echo $latestblogs['blogtitle']; ?></a></h3>
                                                                  <div class="single-item-comment-view">
                                                                     <span><span class="fa fa-clock-o"></span><?php echo $latestblogs['blogtime']; ?></span>
                                                                 </div>
                                                                 <p><?php echo mb_strimwidth(strip_tags($latestblogs['blogcontent'], '<p><a>'), 0, 100, '...');?></p>
                                                                 <a class="button-default btn-create2 text-uppercase" href="<?php echo base_url(); ?>blog/id/<?php echo $latestblogs['blogid']; ?>"><?php echo $this->lang->line('more_details');?></a>
                                                              </div>
                                                          </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                            <div class="comments">
                                                    <h4 class="title"><?php echo $this->lang->line('comments');?></h4>
                                                    <?php foreach ($blogcomment as $blogcommentdata): ?>
                                                      <div class="single-comment">
                                                          <div class="author-image">
                                                            <?php if($blogcommentdata['avatar'] != '') { ?>
                                                              <img src="<?php echo base_url() ?><?php echo $blogcommentdata['avatar'];?>" alt="">
                                                            <?php } else {?>
                                                              <img src="<?php echo base_url() ?>assets/img/avatar.svg" alt="">
                                                            <?php } ?>
                                                          </div>
                                                          <div class="comment-text">
                                                              <div class="author-info">
                                                                  <h4><?php echo $blogcommentdata['first_name']." ".$blogcommentdata['last_name'];?></h4> 
                                                                  <span class="comment-time"><?php echo $this->lang->line('posted_on');?> <?php echo date("M d, Y", strtotime($blogcommentdata['commenttitme']));;?> /</span>
                                                              </div>
                                                              <p><?php echo $blogcommentdata['commentcontent'];?></p>
                                                          </div>
                                                      </div>
                                                      <?php endforeach;?>
                                            </div>
                                            <?php
                                            $ci = get_instance();
                                            if ($ci->session->userdata('is_login') == TRUE) { ?>
                                            <div class="comments" id="comments">
                                                <h4 class="title"><?php echo $this->lang->line('add_comment');?></h4>
                                                    <form method="post" action="<?php echo base_url(); ?>blog/comment#comments" class="form-horizontal" novalidate>
                                                       
                                                        <div class="form-group">
                                                            <textarea name="message" class="form-control" rows="8" placeholder="Type Your Message ..." required="" title="Add Your Message Herer"></textarea>
                                                        </div>
                                                        <input type="hidden" name="blogid" value="<?php echo $blog->blogid;?>" />
                                                        <input type="hidden" name="userid" value="<?php echo $ci->session->userdata('id');?>" />
                                                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                                        <button type="submit" class="btn btn-create2"><?php echo $this->lang->line('send_comment');?></button>
                                                    </form>
                                            </div>
                                          <?php } ?>
                                        </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-lg-2"></div>
                           </div>
                       </div>
                   </article>
                </section>
            </div>
            
<?php $this->load->view('footer'); ?>