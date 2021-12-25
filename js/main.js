
$(window).on('scroll', function(){
var  winTop = $(window).scrollTop();
if (winTop >= 1) {    $('.nav').addClass('fixed').removeClass('top');
} else if (winTop <= 0) {    $('.nav').addClass('top').removeClass('fixed');    
}
});

$(document).ready(function () {
    var containerr_height = $('.containerr').height();  
    var typewriter_height = $(".containerr .videoText").height();
    $(".containerr .videoText").css("top", containerr_height / 2 - typewriter_height / 2);


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
        if (wi >= 1024) {
            $('#topbar-menu').css({'display':'block'});
            $('#topbar-menu-icon i').removeClass('fa-times');
            $('#topbar-menu-icon i').addClass('fa-bars');
        }
        else {
            $('#topbar-menu').css({'display':'none'});            
            $('#topbar-menu-icon i').removeClass('fa-times');
            $('#topbar-menu-icon i').addClass('fa-bars');
        }
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