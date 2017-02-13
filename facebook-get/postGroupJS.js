/* global FB, divStatus */
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

function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue;
}

function getInfo (access_token, callback) {
    FB.api('/me?access_token=' + access_token ,function (response) {
        callback(response);
    });        
}

function getAllGroup (access_token, callback) {
    FB.api('/me/groups?limit=1000', {access_token: access_token}, function (response){
        callback(response);
    });
}

function addStatus (string,color) {
    var span = document.createElement('span');
    
    span.innerHTML = string + '<br/>';
    span.style.color = color;
    
    postStatus.appendChild(span);
}

function postGroup (access_token,url,vitri) {
    getAllGroup(access_token, function (response) {
        
        if(response.error){
            addStatus(response.error.message, 'red');
            return 0;
        }
        
        var Interval = setInterval(function () {
            
            var id = response.data[vitri].id;
            var name = response.data[vitri].name;
            
            FB.api('/' + id + '/feed', "POST" ,{
                access_token: access_token,
                link : url
            },function (response) {
                if(!response.error){
                    addStatus('Đăng thành công lên <b>' + name + '</b>','green');
                }else{
                    addStatus(response.error.message, 'red');
               }
            });
            
            vitri++;
            if(vitri % 10 === 0 || vitri >= response.data.length){
                setCookie('vitri', vitri);
                if(vitri >= response.data.length)
                   setCookie('vitri', 0);
                clearInterval(Interval);
                location.reload();
            } 
        }, timeOnePost);
    });
}

// Xu ly
var access_token =  getCookie('access_token_group');
var divStatus = document.getElementById('status');
var postForm = document.getElementById('postForm');
var btnSubmit = postForm.querySelectorAll('input')[2];
var timeOnePost = document.getElementById('timeOnePost').value;
    timeOnePost = parseInt(timeOnePost) * 1000;
var postStatus = document.getElementById('postStatus');
var vitri = getCookie('vitri');
    if(vitri === ''){
        vitri = 0;
        setCookie('vitri', 0);
    }
    vitri = parseInt(vitri);
var access_tokenInput = document.getElementById('access_token');

if(access_token.length > 10){
    document.getElementById('access_token').value = access_token;
    getInfo(access_token, function (response){
        if(!response.error) {
            var string = 'Xin chào: <b>' + response.name + '</b><br/>';
            divStatus.innerHTML = string;
            getAllGroup(access_token, function (response){
                var string = 'Tài khoản này có <b>' + response.data.length + '</b> nhóm';
                var span = document.createElement('span');
                span.innerHTML = string;
                divStatus.appendChild(span);

                for (var i = vitri; i < vitri + 10; i++){
                   var span = document.createElement('span');
                   span.innerHTML = i + '.' + response.data[i].name + '<br/>';
                   document.body.appendChild(span);
                }
            });
        }else{
            var string = '<b style="color:red">Lỗi: ' + response.error.message + '</b><br/>';
            divStatus.innerHTML = string;
        }
    });
}

postForm.addEventListener("submit", function(e) {
    
    e.preventDefault();
    var url = document.getElementById('url').value;
    if(vitri === ''){
        setCookie('vitri', 0);
        vitri = getCookie('vitri');
    }
    
    if(access_tokenInput.value.length > 10){
        if (access_tokenInput.value !== access_token)
        {
            setCookie('access_token_group',access_tokenInput.value);
            access_token = access_tokenInput.value;
        }

        if(url.length < 10){
            alert('Chưa nhập link cần post!');
        }else {
            btnSubmit.disabled = 'disabled';
            btnSubmit.value = 'Đang đăng...';
            postStatus.innerHTML = '<img src="https://cat.eduroam.org/external/discojuice/images/spinning.gif"/><br/>';
            postGroup(access_token,url,vitri);
        }
    }else{
        alert('Chưa nhập Access Token!');
    }
});



