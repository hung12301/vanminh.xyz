/**
 * Created by Admin on 11/08/2016.
 */
$(document).ready(function () {

   var allChannel = ["freecodecamp", "imaqtpie", "ESL_SC2", "OgamingSC2", "cretetion",  "storbeck", "habathcx", "RobotCaleb", "noobs2ninjas", "Fate_Twisted_NA"];

   allChannel.map (function(val) {
       $.get("https://api.twitch.tv/kraken/streams/" + val, function (res) {
            if(res.stream === null) {
                $.get("https://api.twitch.tv/kraken/channels/" + val, function (res2) {
                    addToHtml(val,res2.logo, res2.display_name, res2.status, 'offline');
                })
            } else {
                addToHtml(val,res.stream.channel.logo, res.stream.channel.display_name, res.stream.channel.status, 'online');
            }
       });
   });

    $(".result").on("click", ".online" , function () {
        var id = $(this).attr("id");
        var iframe = '<iframe style="width: 100%; height: 400px;" src="https://player.twitch.tv/?channel='+id+'"></iframe>';
        $(".modal-title").html(id);
        $(".modal-body").html(iframe);
        $("#myModal").modal("show");
    });

   $("#status-type").children().click(function () {

       $(".active").removeClass("active");
       $(this).addClass("active");

       var allClass = $(this).attr("class");

       if(allClass.indexOf("online") != -1){
           $(".online").show(300);
           $(".offline").hide(300);
       }else if(allClass.indexOf("offline") != -1) {
           $(".online").hide(300);
           $(".offline").show(300);
       }else {
           $(".online").show(300);
           $(".offline").show(300);
       }
   });
});

function addToHtml (id, imgUrl, name, status, onOrOff) {

    if(status.length >= 50) {
        status = status.substring(0,50);
        status += "...";
    }

    var html = '<tr class="info ' + onOrOff +  '" id="'+id+'">';
    html += '<td><img class="avatar" src="'+ imgUrl +'"></td>';
    html += '<td>'+name+'</td>';
    if(onOrOff === 'offline') {
        html += '<td>Offline</td>';
    }else {
        html += '<td><span>'+status+'</span></td>';
    }

    html += '</tr>';

    $(".result").append(html);
}

