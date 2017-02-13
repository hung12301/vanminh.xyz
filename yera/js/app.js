$(document).ready(function () {

    // Intro

    $(".intro-mute").click (function () {
        var videoMute = $("#intro-video").prop("muted");
        $("#intro-video").prop("muted", !videoMute)

        if(videoMute == false)
            $(this).html('<i class="fa fa-volume-off"></i>');
        else
            $(this).html('<i class="fa fa-volume-up"></i>');
    });

    $(".intro-close").click(function () {
        $(".intro").fadeTo(500,0, function () {
            $(this).remove();
        });
    })

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

    $(".btn-buy").click(function () {
        location.href = "product-info.html";
    });

    $(".btn-options").click (function () {
        location.href = "product-info.html";
    });

    $(".loading").fadeTo(1000,0,function () {
        $(this).remove();
    });

	var allImg = $(".slider-images").find("img");
	var allCaption = $(".slider-caption").find("li");
	var current = 0;
	var isNext = 1;

	showImg(0);

	function showImg (type) {

		if(current >= allImg.length - 1) {
            isNext = 0;
        }

		if(current === 0)
			isNext = 1;

        if(current >= allImg.length) {
            current = 0;
        }

        $(".slider-images").css("transform", "translateX(-" + current*100 + "vw)");

        allCaption.map (function (key,val) {
            $(allCaption[key]).removeClass("slider-active");
        });

		$(allCaption[current]).addClass("slider-active");

		if(type === 0) {

			setTimeout(function () {

				if(isNext) {
                    current++;
                } else {
                    current--;
                }

				showImg (0);

			},5000);

		}
	}

	$(".slider-back").on("click", function () {

		current--;

		console.log(current);

		if(current < 0)
		{
			current = 0;
			return 0;
		}

		showImg (1);
	});

	$(".slider-next").on("click", function () {

		current++;

		if(current >= allImg.length)
		{
			current = 2;
			return 0;
		}

		showImg (1);
	});

	$(".slider-caption li").click (function () {

		current = parseInt($(this).attr("id"));

		showImg (1);
	});


	//  Click Menu
	$(".btn-menu").click(function () {
		$("nav").toggleClass("nav-show");
	});

    $(".remove").click(function () {
        $(this).toggleClass("removed");
    });
});

