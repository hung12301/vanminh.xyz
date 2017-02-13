/* global FB */
// Get Data from URL
var string = window.location.search;
var data = new Array;
// String to Array
data = string.split('&');
// Delete '?'
data[0] = data[0].substr(1,data[0].lenght);
// Split string from '=' to end of string
data.forEach(function(value,key){
    var location = value.indexOf('=') + 1;
    data[key] = value.substr(location,value.lenght);
});
// Assign to variables

var myPageId = data[0];
var myPageAccessToken = data[1];
var oldPostId = null;

// Get Info
FB.api('/' + myPageId + '?access_token=' + myPageAccessToken, function (response){
   if(!response.error){
       showInfo(response.name);
   }else{
       showInfo('Có lỗi xảy ra');
   }
});

// submit form scan data form another page
$("#scanPage").on("submit", function(e){
    e.preventDefault();
    var link = $("#scanPage > input").val();
    var timeScan = $("#timeScan").val();
    FB.api('/' + link, function (response) {
        checkPageId(response.id,timeScan);
        console.log(response.id,timeScan);
    });
});

// Function Show info in div #status
function showInfo(name){
    var status = document.getElementById('status');
    status.innerHTML = 'Xin chào: <b>' + name + '</b>';
}

// Function check page Id
function checkPageId (id,timeScan){
    FB.api('/' + id + '?access_token=' + myPageAccessToken, function(response){
        if(!response.error){
            $("#formStatus").html('<br/><img src="loading.gif"/> Đang lấy dữ liệu từ:  <b>' + response.name + '</b> ('+timeScan+' phút/lần) <br/><br/>');
            
            getVictimFeed(id,oldPostId);
            // Auto run 30phút/lần
            setInterval(function(){getVictimFeed(id,oldPostId);},timeScan * 60 * 1000);
        }else{
            $("#formStatus").html('<font color="red">'+ response.error.message +'</font>');
        }
    });
}

// Function get victim feed
function getVictimFeed(victimPageId){
    FB.api('/' + victimPageId + '/feed?fields=message,type,from&limit=1&type&access_token=' + myPageAccessToken, function (response){
        if(!response.error) {
            var type = response.data[0].type;
            var id = response.data[0].id;
            var message = response.data[0].message;
            var status_type = response.data[0].status_type;
            var fromId = response.data[0].from.id;
            
            $("#getStatus").html('<b>Lấy được: </b> 1 ' + type + '<br/>ID: ' + id + '<br/>Message: '+ message + '<br/><br/>');
            
            if(id !== oldPostId && fromId === victimPageId){
               oldPostId = id;
               getInfoAndAssign(id,type,message);
            }else{
                $("#getStatus").html('<font color="red">Cái này đã post rồi hoặc không post được !</font>');
            }
        }else{
            $("#getStatus").html('<font color="red">'+response.error.message+'</font>');
        }
    });
}

// Function post in my page
function getInfoAndAssign (id,type,message){
    var locationOfVictimName = message.indexOf('Leader');
    if(locationOfVictimName !== -1){
        message = message.replace('Leader', 'Liên Minh Huyền Thoại VN');
    }
    FB.api('/' + id + '?fields=full_picture,link,permalink_url', function(response){
        var postData = new Object;
        postData.message = message;
        postData.access_token = myPageAccessToken;
        if(type === 'link'){ postData.link = response.link; postInMyPage (type,postData);}
        else if(type === 'photo') {postData.url = response.full_picture; postInMyPage (type,postData);}
        else if(type === 'video'){
            getLinkVideoHd(response.permalink_url,function(urlHD){
                var postData = new Object;
                    var call_to_action = new Object;
                        var value = new Object;
                        
                        value.link = 'https://www.facebook.com/LienMinhVietNam.VN/';
                        value.link_title = 'Like Page để xem thêm';
                        value.link_description = 'Like Page để xem thêm';
                        value.link_caption = 'Like Page để xem thêm';
                        
                    call_to_action.type = 'WATCH_MORE';
                    call_to_action.value = value;
                
                postData.call_to_action = call_to_action;
                postData.file_url = urlHD;
                postData.description = message;
                postData.access_token = myPageAccessToken;
                postInMyPage (type,postData);
            });
        }
    });
}

// Function get link video HD facebook
function getLinkVideoHd(urlVideo,callback){
    var url = 'getVideoHd.php?link=' + urlVideo;
    $.ajax({
        url: url
    }).done(function(response){
        var data = JSON.parse(response);
        callback(data.url);
    });
}

// Function Post data in my Page
function postInMyPage (type,postData) {
        
        if(type === 'link') type = 'feed';
        if(type === 'photo') type = 'photos';
        if(type === 'video') type = 'videos';
        
        FB.api('/' + myPageId + '/' + type, 'POST', postData ,function (response) {
            if(!response.error){
                $("#postStatus").html('<br/><b>Tải lên thành công với ID là: ' + response.id + '</b><br/>');
            }else{
                $("#postStatus").html(response.error.message);
            }
        });
}