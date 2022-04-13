
$(window).on('scroll', function(){
var  winTop = $(window).scrollTop();
if (winTop >= 1) {    $('.nav').addClass('fixed').removeClass('top');
} else if (winTop <= 0) {    $('.nav').addClass('top').removeClass('fixed');    
}
});

$(document).ready(function () {
    var containerr_height = $('.containerr').height();  
    var typewriter_height = $(".containerr .videoText").height();
    // $(".containerr .videoText").css("top", containerr_height / 2 - typewriter_height / 2);


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

/////////////////////////////////////////////////////////////////////////

 // Create cookie
function setCookie(cname, cvalue, exdays) {
	const d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	let expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// Delete cookie
function deleteCookie(cname) {
	const d = new Date();
	d.setTime(d.getTime() + (24*60*60*1000));
	let expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=;" + expires + ";path=/";
}

// Read cookie
function getCookie(cname) {
	let name = cname + "=";
	let decodedCookie = decodeURIComponent(document.cookie);
	let ca = decodedCookie.split(';');
	for(let i = 0; i <ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

// Set cookie consent
function acceptCookieConsent(){
	deleteCookie('user_cookie_consent');
	setCookie('user_cookie_consent', 1, 30);
	document.getElementById("cookieNotice").style.display = "none";
}

// Set visibility of the cookie consent popup
let cookie_consent = getCookie("user_cookie_consent");
if(cookie_consent != ""){
	document.getElementById("cookieNotice").style.display = "none";
// 	document.getElementById("acceptNoti").style.display = "block";
}else{
	document.getElementById("cookieNotice").style.display = "block";
// 	document.getElementById("acceptNoti").style.display = "none";
}