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
?>      <!--FOOTER SECTION-->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                        <h5 class="tit-foot text-uppercase"><?php echo $this->lang->line('overview');?></h5>
                        <ul class="footer-list">
                                <?php 
                                    $menu_one = footer_menu('2','code_menuinner');
                                    foreach($menu_one  as $link){
                                        echo '<li><a href="'.$link['menuinnerlink'].'">'; if ($siteLang == 'arabic') { echo $link['menuinnertextarb']; } else { echo $link['menuinnertext']; } echo '</a></li>';
                                    }
                                ?>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                            <h5 class="tit-foot text-uppercase"><?php echo $this->lang->line('StoreCreator');?></h5>
                            <ul class="footer-list">
                                <?php 
                                    $menu_one = footer_menu('3','code_menuinner');
                                    foreach($menu_one  as $link){
                                        echo '<li><a href="'.$link['menuinnerlink'].'">'; if ($siteLang == 'arabic') { echo $link['menuinnertextarb']; } else { echo $link['menuinnertext']; } echo '</a></li>';
                                    }
                                ?>
                            </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="tit-foot text-uppercase conto-tit"><?php echo $this->lang->line('contact_us');?></h5>
                        <ul class="contact-list">
                            <li>
                                <?php 
                                    $contact_opt = footer_menu_options('footercontact','code_option');
                                    
                                    if ($siteLang == 'arabic') { echo $contact_opt[0]['optionvaluearb']; } else { echo $contact_opt[0]['optionvalue']; }
                                ?>
                                
                            </li>
                            <li>
                            <?php 
                                    $contact_opt = footer_menu_options('footerwhatsapp','code_option');
                                    if ($siteLang == 'arabic') { echo $contact_opt[0]['optionvaluearb']; } else { echo $contact_opt[0]['optionvalue']; }
                                ?>
                            </li>
                            <li><a href="<?php echo base_url('contact'); ?>"><?php echo $this->lang->line('contact_us');?></a></li>
                            <li class="time-open">
                            <?php 
                                    $contact_opt = footer_menu_options('officetiming','code_option');
                                    if ($siteLang == 'arabic') { echo $contact_opt[0]['optionvaluearb']; } else { echo $contact_opt[0]['optionvalue']; }
                                ?>
                            </li>
                            
                           
                        </ul>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="content-subscirbe">
                            <h5 class="tit-subscribe"><?php echo $this->lang->line('stay_updated_with');?></h5>
                            <form action="<?php echo base_url('signup/subscribe'); ?>" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                                    <input type="email" name="subs_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" title="Sign Up for our Newsletter" placeholder="Your Email Address"> 
                                </div>
                                <div class="cont-btn-subscrive">
                                    <button type="submit" class="btn btn-create2 text-uppercase "><?php echo $this->lang->line('subscribe_now');?></button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="logo-footer">
                            <a class="navbar-brand" href="#">
                                <?php 
                                    $logo_opt = footer_menu_options('footerlogo','code_option');
                                ?>
                                <img src="<?php echo $logo_opt[0]['optionvalue']; ?>" alt="<?php echo $this->lang->line('storecreator');?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-icons">
                            <?php 
                                    $fb_opt = footer_menu_options('facebook','code_option');
                                    $tw_opt = footer_menu_options('twitter','code_option');
                                    $int_opt = footer_menu_options('instagram','code_option');
                            ?>
                            <li class="list-inline-item"><a href="<?php echo $fb_opt[0]['optionvalue']; ?>"><span class="fa fa-instagram fa-2x socialim"></span></a></li>
                            <li class="list-inline-item"><a href="<?php echo $tw_opt[0]['optionvalue']; ?>"><span class="fa fa-facebook fa-2x socialim"></span></a></li>
                            <li class="list-inline-item"><a href="<?php echo $int_opt[0]['optionvalue']; ?>"><span class="fa fa-twitter fa-2x socialim"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    








 <!-- btn scroller page-->
 <button class="btn" onclick="topFunction()" id="myBtn" title="Go to top">
    <i class="fa fa-chevron-up"></i>
  </button>

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/swiper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.fancybox.pack.js"></script>

<!-- masonry,isotope Effect Js -->
    <script src="<?php echo base_url() ?>assets/js/imagesloaded.pkgd.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/isotope.pkgd.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/masonry.pkgd.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/owl.carousel.min.js"></script>
<?php if ($siteLang == 'arabic') { ?>
    <script src="<?php echo base_url() ?>assets/js/custom-rtl.js"></script>
<?php } else { ?>
    <script src="<?php echo base_url() ?>assets/js/custom.js"></script>
<?php } ?>
<?php 
// Upload app / Theme script ?>
<script>

$(document).ready(function () {
    bsCustomFileInput.init()
})

</script>
<script>
    var btn_save = $(".save-profile"),
        btn_edit = $(".edit-profile"),
        img_object = $(".img-object"),
        overlay = $(".media-overlay"),
        media_input = $("#media-input");
    
    btn_save.hide(0);
    
    btn_edit.on("click", function() {
        $(this).hide(0);
        btn_save.fadeIn(300);
    });
    btn_save.on("click", function() {
        $(this).hide(0);
        btn_edit.fadeIn(300);
    });
    
    media_input.change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                img_object.attr("src", e.target.result);
            };
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    //second image upload theme
    var btn_savea = $(".save-profile2"),
        btn_edita = $(".edit-profile2"),
        img_objecta = $(".img-object2"),
        overlaya = $(".media-overlay2"),
        media_inputa = $("#media-input2");
    
    btn_savea.hide(0);
    overlaya.hide(0);
    

        
    $( ".installtheme" ).click(function() {
      $( "#target" ).click();
      var domainid = $(this).attr("data-domainid");
      var themeid = $(this).attr("data-themeid");

      console.log("domainid" + domainid);
      console.log("themeid" + themeid);
        $( "body" ).append( "<div class='loadingmodal' style='    width: 100%;    height: 100%;    position: fixed;    z-index: 1000;    top: 0;    background-color: rgba(255, 252, 252, 0.8);    text-align: center;    padding: 50px 0 0 0;'>    <h2>Creating Store</h2>    <p>Loading.. Installing Theme.. This may take few mins..<br><img src='<?php echo base_url('assets/loading.gif'); ?>' style='width:50px !important;'></p></div>" );
        console.log("Process");

        $.ajax({
            url: 'https://storecreator.io/createstore/selectheme',  
            data: "domainid="+ domainid + "&themeid="+ themeid,
            type: "post",
            success: function(data) {
                console.log("data" + data);
                if($.trim(data) === 'error1') {
                    $(".loadingmodal").remove();
                    alert("Sorry! You have already reach domain create limit.");
                } else if ($.trim(data) === 'error2') {
                    $(".loadingmodal").remove();
                    alert("Sorry! Domain already exist.");
                } else {
                    window.location.href = $.trim(data);
                }
            }
        });
    });
        
    $( ".createstore1" ).click(function() {
      $( "#target" ).click();
      var domainname = $("input#input-domain-t").val();
      var domainnameurl = $("input#input-domain-t-name").val();
      var selectedcate = $( ".selectcategory option:selected" ).val();
      var selectedradio = $( "input[name='subdomain']:checked" ).val();
      var domainid = $("input[name='domainid']").val();

      console.log("domainname" + domainname);
      console.log("domainnameurl" + domainnameurl);
      console.log("selectedcate" + selectedcate);
      console.log("selectedradio" + selectedradio);
      if (domainname === '' || domainname === null  || domainname === undefined || domainnameurl === '' || domainnameurl === null  || domainnameurl === undefined || selectedcate === '' || selectedcate === 'Select Category' || selectedcate === null  || selectedcate === undefined || selectedradio === '' || selectedradio === null  || selectedradio === undefined) {
        alert("Please complete form");
      } else {
        $( "body" ).append( "<div class='loadingmodal' style='    width: 100%;    height: 100%;    position: fixed;    z-index: 1000;    top: 0;    background-color: rgba(255, 252, 252, 0.8);    text-align: center;    padding: 50px 0 0 0;'>    <h2>Creating Store</h2>        <p>Loading.. Installing Theme.. This may take few mins..<br><img src='<?php echo base_url('assets/loading.gif'); ?>' style='width:50px !important;'></p></div>" );
        console.log("Process");

        $.ajax({
            url: 'https://storecreator.io/createstore/adddomain',  
            data: "domainname="+ domainname + "&domainnameurl="+ domainnameurl + "&selectedcate="+ selectedcate + "&selectedradio="+ selectedradio + "&domainid="+ domainid,
            type: "post",
            success: function(data) {
                $(".loadingmodal").remove();
                console.log("data" + data);
                if($.trim(data) === 'error1') {
                    alert("Sorry! You have already reach domain create limit.");
                } else if ($.trim(data) === 'error2') {
                    alert("Sorry! Domain already exist.");
                } else if ($.trim(data) === 'error3') {
                    alert("Sorry! Nameserve looks like not matching!");
                }  else {
                    window.location.href = $.trim(data);
                }
            }
        });
      }
    });

    btn_edita.on("click", function() {
        $(this).hide(0);
        overlaya.fadeIn(300);
        btn_savea.fadeIn(300);
    });

    btn_edita.on("click", function() {
        $(this).hide(0);
        overlaya.fadeIn(300);
        btn_savea.fadeIn(300);
    });
    btn_savea.on("click", function() {
        $(this).hide(0);
        overlaya.fadeOut(300);
        btn_edita.fadeIn(300);
    });
    
    media_inputa.change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                img_objecta.attr("src", e.target.result);
            };
            
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    </script>
    <script>
        window.onload = function(){
        si_imageReader();
    }
        /*
            formats: [
                image/gif, 
                image/svg+xml, 
                image/png, 
                image/webp, 
                image/jpeg, 
                image/bmp
            ]
        */
    var image_data = [];
    function si_imageReader(){      
        if(window.File && window.FileList && window.FileReader)
        {
            
            var filesInput = document.getElementById("si_uploader");
            filesInput.addEventListener("change", function(event){
                var files = event.target.files; //FileList object
                var output = document.getElementById("result1");
                
                for(var i = 0; i < files.length; i++)
                {
                    var file = files[i],
                    filename = file.name;
                    if(file.type.match('image')){                       
                        var _fileReader = new FileReader();
                        _fileReader.onload = (function(file) {
                            return function(evt) {
                                si_cookHTML(evt, file)
                            };
                        })(files[i]);

                        _fileReader.readAsDataURL(files[i]);
                    }
                }                               
            });
        }
        else
        {
            console.log("Your browser does not support File API");
        }
    }
    function si_cookHTML(evt, file) {
        // console.log(file)
        var initial = {
            "name": file.name,
            "size": file.size,
            "type": file.type,
            "data": evt.target.result
        };
        image_data.push(initial);
        var img = new Image();
        // var x = ''
        img.onload = function(){
            var x = img.height.toString() +' x '+img.width.toString()

            var _size = file.size;
            var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i=0;while(_size>900){_size/=1024;i++;}
            var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
            
            img.setAttribute('class', 'si_thumbnailImg');
            img.setAttribute('ondragstart', 'return false;');
            var aTag = document.createElement('div');
            aTag.setAttribute('class', 'si_thumbnailWrapper');
            aTag.appendChild(img);

            var overLay = document.createElement('div');
            overLay.setAttribute('class', 'si_thumbnailOverlay');

            var lay = '<div class="si_ThumbnailOverlayContent"><small>'+x+' &nbsp;&nbsp;'+exactSize+'</small></div>';
                
            overLay.innerHTML = lay;
            aTag.appendChild(overLay);
    
            document.querySelector('div#result1').appendChild(aTag) 
        }
        img.src = evt.target.result;
    }
    
    
    </script>

<script type="text/javascript">
// A $( document ).ready() block.
$( document ).ready(function() {

    $('.paypal').on('click',function(){
        $(this).css({"width":"250px"});
        $('#customDetail').fadeIn();
    })
});
</script>
    <?php 
//END Upload app / Theme script ?>

    <?php 
// Domain script ?>
<script>
        $(function(){ //shorter 
            $(".open-sub-domain").click(function(){
              $(".form-sub").slideToggle(400);
            });             
          });
          $(function(){ //shorter 
            $(".open-full-domain").click(function(){
              $(".form-full").slideToggle(400);
            });             
          });
        </script>
    <?php 
//END Domain script ?>


   <script>
        $(document).ready(function () {
            $("#input-domain-t-opt").on('click', function (e) {
                if ($('#input-domain-t-opt').prop('checked')) {
                    $('.displayonfulldomain').show();
                }
            });
            $("#input-domain-t-opt-sub").on('click', function (e) {
                if ($('#input-domain-t-opt-sub').prop('checked')) {
                    $('.displayonfulldomain').hide();
                }
            });
            $( "#input-domain-t-name" ).keyup(function() {
                var radioValue = $("input[name='subdomain']:checked").val();
                if(radioValue == 1) {
                    var curval = $( "#input-domain-t-name" ).val();
                    curval = curval.replace(/[_\W]+/g, "");
                    var checkavilableurl = 'https://storecreator.io/createstore/checkdomain/'+ curval;
                    $( "#input-domain-t-name" ).val(curval);
                    $.ajax({
                        url: checkavilableurl,  
                        success: function(data) {
                            $(".avilablehtml").html(data);
                        }
                    });
                }
                if(radioValue == 2) {
                    

                    var curval = $( "#input-domain-t-name" ).val();
                    curval = curval.replace(/[^-.a-z0-9]*/gi, "");
                    var checkavilableurl = 'https://storecreator.io/createstore/checkfulldomain/'+ curval;
                    $( "#input-domain-t-name" ).val(curval);
                    console.log(checkavilableurl);  
                    $(".avilablehtml").html("<span style='color:red;'>Loading</span>");
                    $.ajax({
                        url: checkavilableurl,  
                        success: function(data) {
                            $(".avilablehtml").html(data);
                        }
                    });

                }
            });
            $( "input[name='subdomain']" ).change(function() {
                $(".avilablehtml").html("");
                
                var radioValue = $("input[name='subdomain']:checked").val();
                if(radioValue == 1) {
                    var curval = $( "#input-domain-t-name" ).val();
                    curval = curval.replace(/[_\W]+/g, "");
                    var checkavilableurl = 'https://storecreator.io/createstore/checkdomain/'+ curval;
                    $( "#input-domain-t-name" ).val(curval);
                    $.ajax({
                        url: checkavilableurl,  
                        success: function(data) {
                            $(".avilablehtml").html(data);
                        }
                    });
                }
                if(radioValue == 2) {
                    

                    var curval = $( "#input-domain-t-name" ).val();
                    curval = curval.replace(/[^-.a-z0-9]*/gi, "");
                    var checkavilableurl = 'https://storecreator.io/createstore/checkfulldomain/'+ curval;
                    $( "#input-domain-t-name" ).val(curval);
                    console.log(checkavilableurl);  
                    $(".avilablehtml").html("<span style='color:red;'>Loading</span>");
                    $.ajax({
                        url: checkavilableurl,  
                        success: function(data) {
                            $(".avilablehtml").html(data);
                        }
                    });

                }
            });
            $(".apptoinstall").on('click', function (e) {
                e.preventDefault();
                var appid = $(this).attr("data-id");
                var domainid = $(this).attr("data-domain-id");
                var installpluginurl = 'https://storecreator.io/createstore/installplugin/'+ domainid + '/' + appid;
                var apptoclickdiv = $(this);
                console.log(installpluginurl);
                $.ajax({
                    url: installpluginurl,  
                    success: function(data) {
                        $(apptoclickdiv).hide();
                        $(apptoclickdiv).parent('.card-body').append('<a class="btn btn-create2 btn-free-app" style="    cursor: not-allowed;">Installed</a>');
                    }
                });
            });

        });
        $(function () {
            $(".single-event-item").slice(0, 6).show();
            $("#loadMore").on('click', function (e) {
                e.preventDefault();
                $(".single-event-item:hidden").slice(0, 3).slideDown();
                if ($(".single-event-item:hidden").length == 0) {
                    $("#loadMore").fadeOut('speed');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });
        });

        $(function () {
            $(".single-event-item-app-all").slice(0, 6).show();
            $("#loadMoreAppAll").on('click', function (e) {
                e.preventDefault();
                $(".single-event-item-app-all:hidden").slice(0, 3).slideDown();
                if ($(".single-event-item-app-all:hidden").length == 0) {
                    $("#loadMoreAppAll").fadeOut('speed');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });
        });

        $(function () {
            $(".single-event-item-app-multiple").slice(0, 6).show();
            $("#loadMoreAppMultiple").on('click', function (e) {
                e.preventDefault();
                $(".single-event-item-app-all:hidden").slice(0, 3).slideDown();
                if ($(".single-event-item-app-all:hidden").length == 0) {
                    $("#loadMoreAppAll").fadeOut('speed');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });
        });
        
        $(document).ready(function () {
            $(".loadMoreAppMultiple").click(function() {
                var dataid = $(this).attr("data-id");
                alert(dataid);
                $(".single-event-slide-" + dataid +":hidden").slice(0, 3).slideDown();
                if ($(".single-event-slide-" + dataid +":hidden").length == 0) {
                    $(this).fadeOut('speed');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });
            $( ".loadMoreAppMultiple" ).each(function( index ) {
                var dataid = $(this).attr("data-id");
                $(".single-event-slide-" + dataid).slice(0, 6).show();
            });
        });




        $(function () {
            $(".single-event-item-app").slice(0, 6).show();
            $("#loadMoreApp").on('click', function (e) {
                e.preventDefault();
                $(".single-event-item-app:hidden").slice(0, 3).slideDown();
                if ($(".single-event-item-app:hidden").length == 0) {
                    $("#loadMoreApp").fadeOut('speed');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });
        });

    $(function(){ //shorter 
        $(".reply").click(function(){
          $(".content-form-comment").slideToggle(400);
        });             
      });

    
    $( "input[name=customRadio]" ).change(function() {
      var customradiovalue = $(this).attr("data-expire");
      var customradiototal = $(this).attr("data-total");
      var customradiototalpayid = $(this).attr("data-paypal-id");
      var custommonth = $(this).attr("data-month");
      $(".custom3").val(custommonth);

      var customzero = $(".custom0").val();
      var customone = $(".custom1").val();
      var customtwo = $(".custom2").val();
      var customthree = $(".custom3").val();

      var customvalue = customzero + '&' + customone + '&' + customtwo + '&' + customthree;
      $(".custom").val(customvalue);

      $( ".expiration-date" ).text("");
      $( ".expiration-date" ).text( "Expires: "+ customradiovalue );
      $( "li.summry-cart-region .pull-right b" ).text("");
      $( "li.summry-cart-region .pull-right b" ).text( customradiototal );
      $( ".changepaypalid" ).val("");
      $( ".changepaypalid" ).val( customradiototalpayid );
      $( "span.cart__total--price.pull-right.js-cart-total-price b" ).text("");
      $( "span.cart__total--price.pull-right.js-cart-total-price b" ).text( customradiototal );
      $( "span.cart__total--price.pull-right.js-cart-total-price b" ).val("");
      $( "#getTotal" ).val( customradiototal );



    });
    </script>
</body>