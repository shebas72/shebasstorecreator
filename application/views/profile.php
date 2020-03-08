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
        .content-profile-form {
    background: #fff;
    padding: 30px 20px;
    border-radius: 13px;
}
        .content-image-profile{
            text-align: center;
        }
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
    .media-overlay {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }
        #media-input {
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

        .img-object {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            display: block;
            border: 2px solid;
            transition: all 0.7s ease;
        }
        .img-object:hover{
            transform:  scale(1.1);
        }

.media-control {
    margin-top: 30px;
}


    </style>
            <div class="section background-opacity page-titlen set-height-top">
                <div class="container  cont-sub">
                    <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('profile');?></h2>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url() ?>"><?php echo $this->lang->line('home');?></a></li>
                            <li class="active"><a href="#"><?php echo $this->lang->line('profile');?></a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <?php echo $main_content; ?>

<?php $this->load->view('footer'); ?>
<script>

var btn_save = $(".save-profile"),
    btn_edit = $(".edit-profile"),
    img_object = $(".img-object"),
    overlay = $(".media-overlay"),
    media_input = $("#media-input");

btn_save.hide(0);
overlay.hide(0);
$('.errorDiv').hide(0);

btn_edit.on("click", function() {
    $(this).hide(0);
    overlay.fadeIn(300);
    btn_save.fadeIn(300);
});
btn_save.on("click", function() {
    $(this).hide(0);
    overlay.fadeOut(300);
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

</script>
<script>
    $('.loading').hide();
$('#updateProfile').on('click',function(){
    $(this).hide();
    $('.loading').show();
    var data = $('#main-form-profile').serialize();
    $.ajax({
        type: 'POST',
        url: "<?= base_url('profile/update_profile') ?>",
        data: data,
        dataType: "json",
        success: function(resultData) {
            console.log(resultData);
            return false;
            if(data['result'] == 'error'){
                $(this).show();
                $('.loading').hide();
                $('.errorDiv').html(data['errors']).fadeIn('slow');
            } else {
                location.reload();
            }
        }
    })
})
            </script>