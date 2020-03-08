$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
    
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("myBtn").style.display = "block";
  } else {
    document.getElementById("myBtn").style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
(function ($) {
    "use strict";

  $(document).on('ready',function() {
    "use strict";
    

    /*----------------------------------------------
     -----------Masonry Function  --------------------
     -------------------------------------------------*/
    var container_masonry = $(".container_masonry");
  
    /*----------------------------------------------
     -----------Masonry filter Function  --------------------
     -------------------------------------------------*/
    var container_filter = $(".container-filter");
    container_filter.on("click", ".categories", function() {
      var a = $(this).attr("data-filter");
      container_masonry.isotope({
        filter : a
      });
  
    });
    /*----------------------------------------------
     -----------Masonry filter Active Function  --------------------
     -------------------------------------------------*/
    container_filter.each(function(e, a) {
      var i = $(a);
      i.on("click", ".categories", function() {
        i.find(".active").removeClass("active"), $(this).addClass("active");
      });
    });
  
    /*----------------------------------------------
     -----------Masonry Grid view Function  --------------------
     -------------------------------------------------*/
    var container_grid = $(".container-grid");
  
    /*----------------------------------------------
     -----------Masonry Grid Filter Function  --------------------
     -------------------------------------------------*/
    container_filter.on("click", ".categories", function() {
      var e = $(this).attr("data-filter");
      container_grid.isotope({
        filter : e
      });
    });
  
    /*----------------------------------------------
     -----------isotope Function  --------------------
     -------------------------------------------------*/
    var isotop_grid = $('#isotope');
    if (isotop_grid.length) {
      // init Isotope
      var $grid = isotop_grid.isotope({
        itemSelector : 'li	',
        percentPosition : true,
        layoutMode : 'fitRows',
        fitRows : {
          gutter : 0
        }
      });
    }
    /*----------------------------------------------
     -----------Light Function  --------------------
     -------------------------------------------------*/
    var fLight = $(".fancylight");
    if (fLight.length) {
      fLight.fancybox({
        openEffect : 'elastic',
        closeEffect : 'elastic',
        helpers : {
          media : {}
        }
      });
    }
  
    
  
  

    /* --------------------------------------------
     Product Zoom
     -------------------------------------------- */
    var single_product = $(".single-product");
    if (single_product.length !== 0) {
      var zoomWindowWidth;
      var zoomWindowHeight; zoomWindowWidth    :400; zoomWindowHeight   :470;
      if ($(window).width() < 992) { zoomWindowWidth    :0; zoomWindowHeight   :0;
        //zoomType = 'inner';
      }
      var zoomProduct = $("#zoom-product");
      zoomProduct.elevateZoom({
        gallery : 'zoom-product-thumb',
        cursor : 'pointer',
        galleryActiveClass : 'active',
        imageCrossfade : true,
        responsive : true,
        scrollZoom : false,
        zoomWindowWidth : zoomWindowWidth,
        zoomWindowHeight : zoomWindowHeight,
        //zoomType		: zoomType
      });
  
      zoomProduct.on("click", function(e) {
        var ez = zoomProduct.data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
      });
  
    }
    var plusJs = $('.plus');
    var minusJs = $('.minus');
    plusJs.on('click', function() {
      $(this).parent('.product-regulator').find('.output').html(function(i, val) {
        return val * 1 + 1
      });
    });
    minusJs.on('click', function() {
      var ab = $(this).parent('.product-regulator').find('.output').html();
      if (1 <= ab) {
        $(this).parent('.product-regulator').find('.output').html(function(i, val) {
          return val * 1 - 1
        });
      }
  
    });
  
    /*----------------------------------------------
     -----------Counter Function  --------------------
     -------------------------------------------------*/
    var counter = $('.counter');
    if (counter.length) {
      counter.appear(function() {
        counter.each(function() {
          var e = $(this),
              a = e.attr("data-count");
          $({
            countNum : e.text()
          }).animate({
            countNum : a
          }, {
            duration : 8e3,
            easing : "linear",
            step : function() {
              e.text(Math.floor(this.countNum));
            },
            complete : function() {
              e.text(this.countNum);
            }
          });
        });
      });
    }
  

    
    
    /*----------------------------------------------
     ----------- Loader Function  --------------------
     -------------------------------------------------*/
    var preloader = $("#preloader");
    preloader.delay(500).fadeOut();
  
   
    /*-----------------------------------------------
     -----------  style-switcher  --------------------
     -------------------------------------------------*/
    // $("body").append('<div id="style-switcher"></div>');
    // $("#style-switcher").load("theme-option/swicher.html");
  });
  
  /*accordion*/
  var accordion_select = $('.accordion');
  if (accordion_select) {
    accordion_select.each(function() {
      $(this).accordion({
        "transitionSpeed" : 400,
        transitionEasing : 'ease-in-out'
      });
    });
  }
  /*MatchHeight*/
  var matchHeigh = $('.matchHeigh');
  if (matchHeigh.length) {
    if (matchHeigh) {
      matchHeigh.matchHeight();
    }
  }
  // $(function(){ //shorter 
  //   $(".change-btn").click(function(){
  //     $(".content1a").slideToggle(400);
  //   });				
  // });
  $(".change-btn").click(function(){
    $(".content1a").addClass(".content2a");
  });
  $(".change-btn").click(function(){
    $(".content2a").removeClass(".content1a");
  });
  $("#main-slider").find('.owl-carousel').owlCarousel({
slideSpeed : 900,
items:1,
// autoplay:true,
loop:true,
paginationSpeed : 500,
singleItem : true,
autoplay: true,

//autoHeight : true,
transitionStyle : "fadeUp"
});
  })(jQuery); 
      /*-----------------------------
      slider one
  ---------------------------------*/
  var swiper = new Swiper('.swiper-container', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows : true,
    },
    spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 10000,
        disableOnInteraction: false,
      },
  });

  var fLight = $(".fancylight");
	if (fLight.length) {
		fLight.fancybox({
			openEffect : 'elastic',
			closeEffect : 'elastic',
			helpers : {
				media : {}
			}
		});
  }
  