$(document).ready(function() {
    $(".child-room").mouseover(function(){
        $(".bg-room").css("opacity","0.4");
        $(this).addClass('active');
    });
    $(".child-room").mouseout(function(){
        $(".bg-room").css("opacity","1");
        $(".child-room").removeClass('active');
    });
});