jQuery(document).ready(function() {

	$(".toggle-menu").click(function () {
		$(this).toggleClass('clicked');
		$(".nav-bar").toggleClass('show-menu');
	});

});
