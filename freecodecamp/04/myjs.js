$(document).ready(function() {

    $.get("http://ip-api.com/json", function (res) {
        getWeatherInfo(res.city,res.country);
    });

    $("#change-nhietdo").parent().click(function (){
        var temp = parseInt($("#number").html());
        var char = $("#char").html();

        if(char == "C") {
            changeTemp(temp * 1.8 + 32, "F");
        }else {
            changeTemp((temp - 32) / 1.8, "C");
        }
    });

});

function getWeatherInfo (city,country) {

    var url = "http://api.openweathermap.org/data/2.5/weather?q="+city+"&units=metric&lang=vi&appid=940b0ba49939757c4b0a7cdbfce8f4e1";

    $.get(url, function (res) {
        var background = getBackground(res.main.temp);
        addToHtml(city,country,res.main.temp,res.weather[0].description,background);
    });
}

function getBackground (temp) {

    var backgroundImages = {
        "0": "https://crealytics.com/wp-content/uploads/2016/01/iStock_000057491002_Medium.jpg",
        "5": "http://i2.cdn.turner.com/cnnnext/dam/assets/140106143102-cold-weather-colds-story-top.jpg",
        "10": "http://il8.picdn.net/shutterstock/videos/8215816/thumb/1.jpg",
        "15": "http://s0.geograph.org.uk/geophotos/02/50/50/2505067_f7c95f77.jpg",
        "20": "http://portugalresident.com/sites/default/files/styles/node-detail/public/field/image/a-cloudy-day-lisa-plymell.jpg?itok=YqnGMoE1",
        "25": "http://cdn.patch.com/users/12838/2015/08/T800x600/20150855cdd3b0df77e.jpg",
        "30": "http://images.techtimes.com/data/images/full/20426/extremely-hot-weather.jpg"
    };

    for(var i = 0; i <= 30; i = i + 5)
        if(temp <= i)
            return backgroundImages[i];

    return backgroundImages[30];
}

function addToHtml(city,country,temp,description,background) {
    $("#city-info").html(city + ', ' + country);
    $("#number").html(Math.round(temp));
    $(".description").html(description);
    $(".background").css("background-image", "url("+background+")");
    $("title").html(Math.round(temp) + ' ºC in ' + city + ' - ' + country);
    $(".bodyOverlay").fadeTo("slow", 0, function () {
        this.remove();
    });

}

function changeTemp (temp,char) {

    $("#number").html(Math.round(temp).toString());
    $("#char").html(char);
    $("title").html(Math.round(temp) + $("title").html().replace(/([0-9])/igm, ""));

    if(char == "C") {
        $("title").html($("title").html().replace("F", "C"));
        $("#change-nhietdo").html("Change to F");
    } else {
        $("title").html($("title").html().replace("C", "F"));
        $("#change-nhietdo").html("Change to C");
    }
}
