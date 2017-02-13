/**
 * Created by Admin on 09/08/2016.
 */
var quotes = [
    {
        "text": "Thật dễ dàng để quen với một người xa lạ\nNhưng lại khó khăn biết mấy để xa lạ với một người đã từng thân quen.",
        "author": "Văn Minh"
    },
    {
        "text": "TỰ KỶ là gì???\nlà tự mình sống hết thế kỷ",
        "author": "Mai Phương"
    },
    {
        "text": "Lúc bé cứ nghĩ cởi truồng là đi tắm\nLớn lên mới biết không chỉ đi tắm mới cởi truồng.",
        "author": "Messi"
    },
    {
        "text": "Tình yêu đến rồi đi nhưng bệnh tật, con cái và nợ lần sẽ ở lại…",
        "author": "Ronaldo"
    },
    {
        "text": "Nếu bạn không biết nói dối thì bạn sẽ\nkhông bao giờ biết khi nào người khác nói dối bạn.",
        "author": "Gomez"
    },
    {
        "text": "Nếu bạn không biết nói dối thì bạn sẽ\nkhông bao giờ biết khi nào người khác nói dối bạn.",
        "author": "Gozo"
    },
    {
        "text": "Đời ngắn!\nNên đừng lãng phí thời gian với những người\nkhông có thời gian dành cho bạn.",
        "author": "Soloco"
    },
    {
        "text": "Ở bên anh,em bình yên đến lạ\nXa anh, em thấy lạ nhưng cũng khá bình yên.",
        "author": "VMTV"
    },
    {
        "text": "Tận cùng của sự ngu dốt\nlà đối xử quá tốt với nhiều người.",
        "author": "Sơn Tùng MTP"
    }
];

var colors = [
    "#1abc9c",
    "#27ae60",
    "#2980b9",
    "#8e44ad",
    "#2c3e50",
    "#d35400",
    "#f39c12",
    "#c0392b",
    "#bdc3c7",
    "#7f8c8d"
];

$(document).ready(function () {

    var info = getInfo();
    var color = getRandomColor();

    addToBox (info.text,info.author,color);

    $("#new-quote").click(function () {

        $(".text-content").fadeTo(1000, 0);
        $("#new-quote").html("Loading...");
        $("#new-quote").attr("disabled", "disabled");

        info = getInfo();
        color = getRandomColor();

        setTimeout(function () {
            addToBox (info.text,info.author,color);
        }, 2000);


    });

});

function getRandomColor () {

    var colorChar = "0123456789ABCFEF";

    var result = "#";

    for(var i = 0; i < 6; i++) {
        result += colorChar[Math.round(Math.random() * 15)];
    }

    return result;
}

function getInfo () {

    var result = {};

    var indexOfQuote = Math.round(Math.random() * 8);

    result.text = quotes[indexOfQuote].text;
    result.author = quotes[indexOfQuote].author;

    return result;
}

function addToBox (text,author,color) {
    $(".text-quote").html(text).show('slow');
    $(".text-author").html('- ' + author);
    $(".background").css('background-color', color);
    $(".text-color").css('color', color);
    $("#tweet").attr("href", "https://twitter.com/intent/tweet?hashtags=quotes&related=vanminh&text=" + encodeURI('"' + text + '"\n\n-' + author + '\n'));
    $("#tweet").attr("target", "_blank");
    $(".text-content").fadeTo(1000, 1,function () {
        $("#new-quote").html("New Quote");
        $("#new-quote").removeAttr("disabled");
    });
}