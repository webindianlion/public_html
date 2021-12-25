
// $(window).on('scroll', function(){
// var  winTop = $(window).scrollTop();
// if (winTop >= 1) {    $('.nav').addClass('fixed').removeClass('top');
// } else if (winTop <= 0) {    $('.nav').addClass('top').removeClass('fixed');    
// }
// });

$(document).ready(function () {
  var wi = $(window).width();

    var containerr_height = $('.containerr').height();  
    var typewriter_height = $(".containerr .videoText").height();
    $(".containerr .videoText").css("top", containerr_height / 2 - typewriter_height / 2);

    if (wi >= 992) {  
       
      $(".owl-item > div").removeClass("flex-column");
      $(".owl-item > div").addClass("flex-row");
    }
    else if(wi <= 991) {
      
      $(" .owl-item > .d-flex").removeClass("flex-row");
      $(".owl-item > .d-flex").addClass("flex-column");
      

    }
    $(".owl-item").ready(function(){
      var wi = $(window).width();
      if (wi >= 992) {
        $(".owl-item > div").removeClass("flex-column align-items-center");
        $(".owl-item > div").addClass("flex-row");
      }
      else if(wi <= 991) {
        $(" .owl-item > .d-flex").removeClass("flex-row");
        $(".owl-item > .d-flex").addClass("flex-column align-items-center");
      }
      
    });

    var hhh = $(".parallax > div h2").outerHeight(true) + $("main .parallax > div h6").outerHeight(true) + $("main .parallax > div p").outerHeight(true) ;
    var parallaxHeight = $(".parallax").outerHeight() ;
    parallaxHeight = hhh + 140;
    $(".parallax").css("height", parallaxHeight );    


// script to add active class to top menu bar

    $(".topbarMenu a").each(function() {
      // console.log($(this).attr('href'));
      if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
          $(this).addClass('activeMenuItem');
      }
  });


});

$(function() {
    // dislay or hide the menu if the user resize the window
    $(window).resize(function() {
        var wi = $(window).width();
        if (wi >= 992) {
            $('#topbar-menu').css({'display':'block'});
            $('#topbar-menu-icon i').removeClass('fa-times');
            $('#topbar-menu-icon i').addClass('fa-bars');
            $(".owl-item > div").removeClass("flex-column align-items-center");
            $(".owl-item > div").addClass("flex-row");            
        }
        else if(wi <= 991) {
            $('#topbar-menu').css({'display':'none'});            
            $('#topbar-menu-icon i').removeClass('fa-times');
            $('#topbar-menu-icon i').addClass('fa-bars');
            $(".owl-item > div").removeClass("flex-row");
            $(".owl-item > div").addClass("flex-column align-items-center");
        }

        var hhh = $("main .parallax > div h2").outerHeight(true) + $("main .parallax > div h6").outerHeight(true) + $("main .parallax > div p").outerHeight(true) ;
        var parallaxHeight = $(".parallax").outerHeight() ;
        parallaxHeight = hhh + 100  - 100;
        $(".parallax").css("height", parallaxHeight + 100);
    });
    
    // Change the menu icon, and show or hide the menu
    $('#topbar-menu-icon').click(function(){
        if ($('#topbar-menu').css('display') == 'none') {
            $('#topbar-menu').css({'display':'block'});
            
            $('#topbar-menu-icon i').removeClass('fa-bars');
            $('#topbar-menu-icon i').addClass('fa-times');
        } 
        else {
            $('#topbar-menu').css({'display':'none'});
            
            $('#topbar-menu-icon i').removeClass('fa-times');
            $('#topbar-menu-icon i').addClass('fa-bars');
        }
    });
});



// progress bar script STARTS

  document.onreadystatechange = function(e) {
    if(document.readyState=="interactive")
    {
      var all = document.getElementsByTagName("*");
      for (var i=0, max=all.length; i < max; i++)  {
        set_ele(all[i]);
      }
    }
  }

function check_element(ele) {
  var all = document.getElementsByTagName("*");
  var totalele=all.length;
  var per_inc=100/all.length;
  if($(ele).on()) {
    var prog_width=per_inc+Number(document.getElementById("progress_width").value);
    document.getElementById("progress_width").value=prog_width;
    $("#bar1").animate({width:prog_width+"%"},10,function(){
      if(document.getElementById("bar1").style.width=="100%") {
        $(".progress").fadeOut("slow");
      }			
    });
  }
  else  { set_ele(ele); }
}
function set_ele(set_element) {
  check_element(set_element);
}
// progress bar script ENDS



  $(document).ready(function() {
    
    $('.banner').owlCarousel({
      animateIn: 'fadeInDown',
      animateOut: 'fadeOutDown',
      loop: true,
      margin: 10,
      center: true,
      autoplay: true,  
      // nav:true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: false,
          dots: false
        }
      }
    });

  //   $('.banner').on('changed.owl.carousel', function(event) {
  //     console.log("change");
  //     setTimeout( function() {
  //       $(".owl-item .subSlide").removeAttr("data-aos");
  //       $(".owl-item.active .subSlide").attr("data-aos","fade-left");
  //     }, 3000 )
      
  // });


  $(".classes.owl-carousel").owlCarousel({
    loop:true,
    margin:10,
    nav:true
    // navText: ["<img src='myprevimage.png'>","<img src='mynextimage.png'>"]
  });

  // $(" ")
  // $(".classes .owl-nav").removeClass("disabled");

   $('.gallery a').simpleLightbox({navText:    ['&lsaquo;','&rsaquo;']});


  });
  
 
  