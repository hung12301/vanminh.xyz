$(document).ready(function(){
    $("#search-btn").click(function(){
        var inputText = document.getElementById('inputSearch').value;
        var dataSend = { 's': inputText};
        $.get('search.php', dataSend ,function(data){
        if(data != '')
        {
            $("#showElement").html(data);
        }
        });
    });
    var option = {'gallery_width' : 900}
    $("#album").unitegallery(option);
});