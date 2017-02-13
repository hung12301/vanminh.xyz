$(document).ready(function () {


	// Button Menu Mobile Effect
	$(".mobile-menu").click(function () {

		var menu = $("#menu");
		var display = menu.css("max-height");
		var icon = $(this).children();

		if(display === '0px') {
			menu.css("max-height","150px");
			icon.removeClass('fa fa-bars');
			icon.addClass('fa fa-times');
		}else{
			menu.css("max-height","0");
			icon.removeClass('fa fa-times');
			icon.addClass('fa fa-bars');
		}
	})

	// Active Navbar Effect
	$(window).scroll(function () {

		var y = $(window).scrollTop();
		var yAbout = $("#about").offset().top;
		var yPortfolio = $("#portfolio").offset().top;
		var yContact = parseInt($("#contact").offset().top);

		if(y >= yPortfolio && y < yContact) {
			activeNavbar('portfolio');
		} else if (y >= yContact) {
			activeNavbar('contact');
		}else {
			activeNavbar('about');
		}
	})

	// Scroll Effect

	$(".scroll-effect").click(function (e) {

		var target = $( $(this).attr('href') );

        e.preventDefault();

        $('html, body').animate({
            scrollTop: target.offset().top
        }, 500);
	});


	// Input Focus Effect

	$(".contact-form > input,textarea").keyup(function () {

		var value = $(this).val();
		var label = $(this).prev();
		
		console.log(label.css('margin-top'));

		if(value !== '' || value.length > 0) {
			label.css('margin-top', '-25px');
			label.css('opacity', '1');
		}else {
			label.css('margin-top' , '20px');
			label.css('opacity', '0');
		}
	});

	$(".contact-form > input,textarea").focus(function ()  {
		
		$(".input-label").css('color', '#AAAAAA');

		var label = $(this).prev();

		label.css('color', '#722872');
	})

});

function activeNavbar (id) {
	$(".active").removeClass('active');
	$('[href="#' + id + '"]').parent().addClass("active");
}