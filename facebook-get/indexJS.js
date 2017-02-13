/* global FB */
getStatusLogin();

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function getStatusLogin (){
    FB.getLoginStatus(function(response){
        var status = document.getElementById("status");
        if(response.status === "connected"){
            FB.api('/me', function(response) {
                status.innerHTML = 'Xin chào <b>' + response.name + '</b> <button onclick="facebookLogout()"> Đăng xuất </button>';
            });
            // Call Function
            createLongToken(response.authResponse.accessToken);
            getAllPage();
            showScanForm();
            deleteButtonLogin();
            setAllButton();
            // reload
            window.reload();
        }
    });
}

function createLongToken (shortToken) {
    
    var url = 'getLongToken.php?shortToken=' + shortToken;
    
    $.ajax({
        url: url
    }).done(function (response){
        var data = new Array;
        data = response.split('&');
        // Save your cookie
        document.cookie = data[0];
    });
}

function facebookLogin(){
    FB.login(function(response) {
        if (response.authResponse) {
            getStatusLogin();
        } else {
            document.getElementById("status").innerText = 'Đăng nhập không thành công';
        }
    }, {scope: 'manage_pages,publish_pages,publish_actions,pages_show_list,pages_manage_cta,pages_manage_instant_articles,pages_messaging,pages_messaging_phone_number'});
}

function facebookLogout () {
    FB.logout(function(){
        window.location.reload();
    });
}

function addData (access_token,id,name) {
    var tr = document.createElement('tr');
    var table = document.querySelector('table');
    var td = document.createElement('td');
    var td2 = document.createElement('td');
    var button = document.createElement('button');
    
    td.innerText = name;
    td.setAttribute('id',id);
    button.setAttribute('value', access_token);
    button.innerText = 'Chọn';
    td2.appendChild(button);
    
    tr.appendChild(td);
    tr.appendChild(td2);
    
    table.appendChild(tr);
}

function getAllPage (){
    // Show Table
    $("#showAllPage").show("fast");
    
    var access_token = getCookie('access_token');
    
    FB.api('/me/accounts?access_token=' + access_token, function(response){
        // Array data
        for(var i = 0; i < response.data.length; i++){
            
            var access_token = response.data[i].access_token;
            var id = response.data[i].id;
            var name = response.data[i].name;
            
            addData(access_token,id,name);
        }
    });
}

function postPageFeed (id,message){
    FB.api('/' + id, 'POST', {
        message: message
    },function(response){
        console.log(JSON.stringify(response));
    });
}

function deleteButtonLogin () {
  $("#login-button").hide("fast");
}

function showScanForm () {
  $('#scanPage').show("fast");
}

function setAllButton (){
    var homeUrl = window.location.href;
    $("table").on( "click", "button", function() {
        var tdParent = this.parentElement;
        var tdBefore = tdParent.previousSibling;
        var id = tdBefore.id;
        var access_token = this.value;
        // Open a new window
        window.open(homeUrl + 'myPage.html?id=' + id + '&access_token=' + access_token);
    });
}

