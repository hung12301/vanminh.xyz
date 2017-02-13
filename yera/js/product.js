$(document).ready(function () {

    $(".banner-list").children().click(function () {

        $(this).parent().find(".banner-list-active").removeClass("banner-list-active");
        $(this).addClass("banner-list-active");

        var html = $(this).html();
        var id = $(this).parent().data('root');
        var wrap = $("#" + id);

        if(html == "New Product") {
            wrap.css("transform", "translateY(0)");
            wrap.css("-webkit-transform", "translateY(0)");
            wrap.css("-moz-transform", "translateY(0)");
        } else if (html == "Popular") {
            wrap.css("transform", "translateY(-550px)");
            wrap.css("-webkit-transform", "translateY(-550px)");
            wrap.css("-moz-transform", "translateY(-550px)");
        } else {
            wrap.css("transform", "translateY(-1100px)");
            wrap.css("-webkit-transform", "translateY(-1100px)");
            wrap.css("-moz-transform", "translateY(-1100px)");
        }
    });

    var footerOffset = $("footer").prev().offset().top;
    var headerOffset = $("header").next().offset().top;
    var body = $("html, body");

    $(".scroll-top").click(function () {
        body.animate({scrollTop:0},'300');
    })

    $(".scroll-bottom").click(function () {
        body.animate({scrollTop:$("footer").offset().top},'300');
    })

    $(window).scroll(function () {

        var windowOffset = $(document).scrollTop();


        if(windowOffset >= footerOffset) {
            $(".scroll-top").css("opacity", "1");
            $(".scroll-bottom").css("opacity", "0");
        }
        else
        {
            if(windowOffset >= headerOffset) {
                $(".scroll-bottom").css("opacity", "1");
                $(".scroll-top").css("opacity", "0");
            }else{
                $(".scroll-bottom").css("opacity", "0");
            }
        }
    });

    $(".icon-search").click(function () {
        $(".icon-search").toggleClass("change");
        $(".text-search").focus();
        $(".notice").fadeTo(500,0);
    });

    $(".loading").fadeTo(1000,0,function () {
        $(this).remove();
    });

	//  Click Menu
	$(".btn-menu").click(function () {
		$("nav").toggleClass("nav-show");
	})

	$(".slider-next").click(function () {

		var current = $(this).after().next().data("current");
		var size = $(this).after().next().data("size");

		if(current === size) {
			current = 0;
		}

		var translateX = current * -356;
		var translateX = translateX.toString() + 'px';

		$(this).after().next().css("transform", "translateX("+translateX+")");
		$(this).after().next().css("-webkit-transform", "translateX("+translateX+")");
		$(this).after().next().css("-moz-transform", "translateX("+translateX+")");
		$(this).after().next().css("-o-transform", "translateX("+translateX+")");

		$(this).after().next().data("current", current + 1);
	});

	$(".slider-back").click(function() {

		var current = $(this).next().next().data("current");
		var size = $(this).next().next().data("size");

		if(current >= size - 1) {
			current = 0;
		}
		
		var translateX = current * 356;
		var translateX = translateX.toString() + 'px';

		$(this).next().next().css("transform", "translateX("+translateX+")");	
		$(this).next().next().css("-webkit-transform", "translateX("+translateX+")");
		$(this).next().next().css("-moz-transform", "translateX("+translateX+")");
		$(this).next().next().css("-o-transform", "translateX("+translateX+")");

		$(this).next().next().data("current", current+1);
	});
});