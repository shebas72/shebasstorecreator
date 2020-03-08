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

    <style>
        
       .content-app-form, .content-theme-form{
        background: #fff;
        padding: 30px 20px;
        border-radius: 13px;
       }

       /* .content-image-profile{
            text-align: center;
        } */
.media-container {
  position: relative;
  display: inline-block;
  margin: auto;
  border-radius: 50%;
  overflow: hidden;
  width: 200px;
  height: 200px;
    vertical-align: middle;
    cursor: pointer;
}
  .media-overlay, .media-overlay2 {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
  }
    #media-input, #media-input2 {
      display: block;
      width: 200px;
      height: 200px;
      line-height: 200px;
      opacity: 0;
      position: absolute;
            z-index: 9;
            cursor: pointer;
    }
    .media-icon {
      display: block;
      color: #ffffff;
      font-size: 2em;
      height: 200px;
      line-height: 200px;
      position: absolute;
      z-index: 0;
      width: 100%;
      text-align: center;
    }

    .img-object , .img-object2{
      border-radius: 50%;
      width: 200px;
      height: 200px;
            display: block;
            border: 2px solid;
            transition: all 0.7s ease;
        }
        .img-object:hover ,.img-object2:hover{
            transform:  scale(1.1);
        }

.media-control {
  margin-top: 30px;
}

/*----- DRAG AND DROP*/
#si_uploader,#si_uploader2 {
    border: 3px dashed #999;
    padding: 35px 5px 5px 5px;
    cursor: move;
    position:relative;
    width: 100%;
}
#si_uploader:before ,#si_uploader2:before {
    content: "drag & drop your Images slider here";
    display: block;
    position: absolute;
    text-align: center;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 40px;
    margin: -25px 0 0 -100px;
    font-size: 14px;
    font-weight: bold;
    color: #999;
}
/* THUMBNAIL CSS*/
.si_thumbnailImg,.si_thumbnailImg2{
  height: 120px;
  cursor: pointer;
}
.si_thumbnailWrapper {
    position: relative;
    display: inline-block;
    display:inline-block;
    margin:7px 5px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.8em;
}
.si_thumbnailWrapper .si_thumbnailOverlay {
    position: absolute;
    bottom: 2px;
    left: 0;
    width: 100%;
    height: 15px;
    display: none;
    color: #FFF;
}
.si_thumbnailWrapper:hover .si_thumbnailOverlay {
    display: block;
    background: rgba(0, 0, 0, .6);
}

.si_thumbnailWrapper .si_thumbnailOverlay .si_ThumbnailOverlayContent {
    position: absolute;
    bottom: 0;
    padding-left: 5px; 
}
    </style>
            <section id="section-head-develop">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="tit-developer"><span>S</span>toreCreator Developer Center</h1>
                            <h3 class="sub-tit-dev">Build Apps &amp; Themes for over 30M Users</h3>
                            <a href="https://storecreator.io/developer/signup" class="btn btn-create2 text-uppercase btn-get">Get started</a>
                          
                        </div>
                    </div>
                </div>
            </section>
            <div id="content-wrapper">
                <!--SHOWCASE SECTION-->
                <section id="section-showcase">
                    <div class="container">
                        <nav class="nav-price">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav1 nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload Apps</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Upload Themes</a>
                               
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="container cont-prico">
                                  <div class="content-app-form">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h3 class="show-tit text-capitalize text-center">Upload App</h3>
                                                    </div>
                                                </div>
                                            </div>
                                              <form class="form-horizontal form-material" id="main-form-app" action="<?php echo base_url('developer/dashboard'); ?>" method="post" name="app-form" enctype="multipart/form-data">
                                                  <div class="form-row">
                                                          <div class=" form-group col-md-12">
                                                            <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                              <label for="inputState">App Title:</label>
                                                              <input type="text" name="title" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                              <label for="inputState">App Title Arabic:</label>
                                                              <input type="text" name="titlearabic" class="form-control">
                                                            </div>
                                                          </div>
                                                    <div class=" form-group col-md-6">
                                                            <label for="inputState">Upload Icon App:</label>
                                                            <div class="content-image-profile">
                                                                <div class="media-container">
                                                                        <span class="media-overlay" style="display: block;">
                                                                            <input type="file" id="media-input" accept="image/*" name="appicon">
                                                                            <span class="fa fa-edit media-icon"></span>
                                                                        </span>
                                                                        <figure class="media-object">
                                                                            <img class="img-object" src="<?php echo base_url('assets/img/Default-img.png');?>">
                                                                        </figure>
                                                                    </div>
                                                        </div>
            
                                                        </div>
                                                      <div class="form-group col-md-6" >
                                                              <label for="inputState">Categories:</label>
                                                              <select id="inputState" class="form-control" name="appcategory">
                                                                <option selected>Choose...</option>
                                                                <?php foreach ($appcategory as $app_category_value): ?>
                                                                  <option value="<?php echo $app_category_value['app_cat_id'];?>"><?php echo $app_category_value['app_cat_name'];?></option>
                                                                <?php endforeach; ?>
                                                              </select>
                                                      </div>
                                              <div class="form-group col-md-12">
                                                <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                  <label for="input-email">About App English Content:</label>
                                                  <textarea name="content" class="form-control" rows="8" placeholder="Type Your Content ..." required="" title="Add Your Content Herer"></textarea>
                                                </div>
                                                <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                  <label for="input-email">About App Arabic Content:</label>
                                                  <textarea name="arabiccontent" class="form-control" rows="8" placeholder="Type Your Content ..." required="" title="Add Your Content Herer"></textarea>
                                                </div>
                                              </div>
                                              <div class="form-group col-md-12">
                                                <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                  <label for="input-email">Features English Content:</label>
                                                  <textarea name="feature" class="form-control" rows="8" placeholder="Type Feature list - Seprate feature by new line ..." required="" title="Add Your Content Herer"></textarea>
                                                </div>
                                                <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                  <label for="input-email">Features Arabic Content:</label>
                                                  <textarea name="arabicfeature" class="form-control" rows="8" placeholder="Type Feature list - Seprate feature by new line ..." required="" title="Add Your Content Herer"></textarea>
                                                </div>
                                              </div>
                                              <div class="form-group col-md-12">
                                              <div class="custom-file">
                                                  <input type="file" class="custom-file-input" id="customFile" name="jsfile">
                                                  <label class="custom-file-label" for="customFile">Choose JS file</label>
                                                </div>

                                              </div>
                                        <div class=" form-group col-md-12">
                                            <article>
                                              
                                                <input id="si_uploader" type="file" name="multipleimg[]" multiple/>
                                                <div id="result1"></div>
                                            </article>

                                            </div>
                                              
                                                      
                                                      
                                                  
                                                  </div>

                                                  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                                                  <button type="submit" class="btn btn-create2" name="appform">Save App Content</button>
                                              </form>
                                             
                                    </div>
                                  </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="container cont-prico">
                                  <div class="content-theme-form">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="show-tit text-capitalize text-center">Upload Theme</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form class="form-horizontal form-material" id="main-form-app" action="<?php echo base_url('developer/dashboard'); ?>" method="post" name="theme-form" enctype="multipart/form-data">
                                                <div class="form-row">
                                                        <div class="form-group  col-md-12">
                                                          <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                            <label for="input-tit">Title:</label>
                                                            <input id="input-tit" type="text" name="title" class="form-control" placeholder="Your Title Theme" required title="This is Title Theme" >
                                                          </div>
                                                          <div class="form-group col-md-6" style=" padding-right: 5px;    padding-left: 5px;    float: left;">
                                                            <label for="input-tit">Arabic Title:</label>
                                                            <input id="input-tit" type="text" name="arabictitle" class="form-control" placeholder="Your Title Theme" required title="This is Title Theme" >
                                                          </div>
                                                        </div>
                                                        <div class=" form-group col-md-6">
                                                                <label for="inputState">Upload image theme:</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" name="themeimage">
                                                                    <label class="custom-file-label" for="customFile">Choose image theme</label>
                                                                  </div>
                
                                                            </div>
                                                                <div class="form-group  col-md-6">
                                                                    <label for="input-tit">Link:</label>
                                                                    <input id="input-link" type="link" name="link" class="form-control" placeholder="https://" required title="This is link Theme"  >
                                                                    </div>
                                                    <div class="form-group col-md-6" >
                                                            <label for="inputState">Categories:</label>
                                                            <select id="inputState" class="form-control" name="type">
                                                              <option selected><?php echo $this->lang->line('choose');?>...</option>
                                                              <option value="Event"><?php echo $this->lang->line('event');?></option>
                                                              <option value="Business"><?php echo $this->lang->line('business');?></option>
                                                              <option value="Portfolio"><?php echo $this->lang->line('portfolio');?></option>
                                                              <option value="Online Store"><?php echo $this->lang->line('online_store');?></option>
                                                            </select>
                                                    </div>
                                                    <div class="form-group col-md-6" >
                                                            <label for="inputState">Arabic Categories:</label>
                                                            <select id="inputState" class="form-control" name="arbtype">
                                                              <option selected><?php echo $this->lang->line('choose_arb');?>...</option>
                                                              <option value="<?php echo $this->lang->line('event_arb');?>"><?php echo $this->lang->line('event_arb');?></option>
                                                              <option value="<?php echo $this->lang->line('business_arb');?>"><?php echo $this->lang->line('business_arb');?></option>
                                                              <option value="<?php echo $this->lang->line('portfolio_arb');?>"><?php echo $this->lang->line('portfolio_arb');?></option>
                                                              <option value="<?php echo $this->lang->line('online_store_arb');?>"><?php echo $this->lang->line('online_store_arb');?></option>
                                                            </select>
                                                    </div>
                                                    <div class=" form-group col-md-12">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile" name="zipfile">
                                                            <label class="custom-file-label" for="customFile">Choose Zip file</label>
                                                          </div>

                                                    </div>
                                            
                                                    
                                                    
                                                
                                                </div>

                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                                                <button type="submit" class="btn btn-create2" name="themeform">Save Theme Content</button>
                                            </form>
                                  
                                </div>
                              </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
            
            
<?php $this->load->view('footer'); ?>