/**
 * Created by Admin on 11/08/2016.
 */

$(document).ready(function () {
    $(".icon-search").click(function () {
        $(".icon-search").toggleClass("change");
        $(".text-search").focus();
        $(".notice").fadeTo(500,0);
    });

    $(".search-form").submit(function(e){
        e.preventDefault();

        $(".result").html('<img class="loading" src="http://vanminh.xyz/freecodecamp/03/loading.svg"/>');

        getInfo($(".text-search").val());

        $(".content").css("margin", "5vh auto auto auto");
    });
});

function addToHtml (val,key) {

    var html = '<a target="_blank" href="https://vi.wikipedia.org/wiki/'+ val.title +'"><div class="result-item" id="item'+key+'">';
    html += '<h1>' + val.title + '</h1>';
    html += '<p>' + val.snippet + '</p>';
    html += '</div></a>';

    $(".result").append(html);

}

function getInfo (text) {
    $.ajax({
        url: '//vi.wikipedia.org/w/api.php',
        data: { action: 'query', list: 'search', srsearch: text , format: 'json' },
        dataType: 'jsonp',
    }).done (function (res) {

        $(".loading").fadeTo(500,0, function() {
            $(this).remove();
        });

        res.query.search.map(function(val,key){
            addToHtml(val,key);
        });
    });
}
