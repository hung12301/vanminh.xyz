<?php
// reset
set_time_limit(0);

function curl($url) {
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 28800);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
    
}

function getFacebook($link){
    if(substr($link, -1) != '/' && is_numeric(substr($link, -1))){
        $link = $link.'/';
    }

    preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)\/(.*)/U', $link, $id); // link dạng https://www.facebook.com/userName/videos/vb.IDuser/IDvideo/?type=2&theater
    if(isset($id[4])){
        $idVideo = $id[3];
    }else{
        preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)/U', $link, $id); // link dạng https://www.facebook.com/userName/videos/IDvideo
        if(isset($id[3])){
            $idVideo = $id[2];
        } else{
            preg_match('/https:\/\/www.facebook.com\/video\.php\?v\=(.*)/', $link, $id); // link dạng https://www.facebook.com/video.php?v=IDvideo
            $idVideo = $id[1];
            $idVideo = substr($idVideo, 0, -1);
        }
    }

    $embed = 'https://www.facebook.com/video/embed?video_id='.$idVideo; // đưa link về dạng embed
    $get = curl($embed);

    // Get videoData
    preg_match('/videoData\":\[(.*)\],\"minQuality/i', $get, $match);

    // thay thế các ký tự mã hóa thành ký tự đặc biệt
    $string = str_replace(
        array('\u00257B', '\u002522', '\u00253A', '\u00252C', '\u00255B', '\u00255C\u00252F', '\u00252F', '\u00253F', '\u00253D', '\u002526','\u00255Cu00253D'),
        array('{', '"', ':', ',', '[', '\/', '/', '?', '=', '&'),
        $match[1]
    );

    // Chuyển JSON thành mảng
    $data = json_decode($string);

    if(isset($data->hd_src) && $data->hd_src != '')
    	return $data->hd_src;

    return $data->sd_src;
}

function getYoutube($link) {
    $get = curl($link);
    $pattern = '/;ytplayer\.config\s*=\s*({.*?});/';
    preg_match($pattern, $get, $match);
    $jsonData = json_decode($match[1],true);
    $streamMap = $streamMap = $jsonData['args']['url_encoded_fmt_stream_map'];
    $return = array();
    foreach (explode(',', $streamMap) as $url)
    {
        $url = str_replace('\u0026', '&', $url);
        $url = urldecode($url);
        parse_str($url, $data);
        $dataURL = $data['url'];
        unset($data['url']);
        $return[$data['quality']."-".$data['itag']] = $dataURL.'&'.urldecode(http_build_query($data));
    }

    return $return['medium-18'];
}

function getYoutubeTitle ($link) {
    $get = curl($link);

    $pattern = '<meta name="title" content="(.*)">';

    preg_match($pattern,$get,$match);

    return $match[1];
}

if(!empty($_GET['link'])){
    
    $link = $_GET['link'];
    $ketqua = array();
    
    if(filter_var($link, FILTER_VALIDATE_URL) == true)
    {
        $facebookLink = getFacebook($link);
//         $data = curl($facebookLink);
//         $file = file_put_contents('video.mp4', $data);
        
//         $ketqua['url'] = 'https://' . $_SERVER['SERVER_NAME'] . '/facebook-get/video.mp4';
        
        $ketqua['url'] = $facebookLink;
    }else{
        $ketqua['error'] = 'Bạn phải nhập link của Facebook';
    }
    
    echo json_encode($ketqua);
}



if(!empty($_GET["youtube"])) {

    $ketqua = array(
        'error'=>true,
        'link'=>null,
        'title'=>null,
    );

    $link = $_GET["youtube"];
    $result = getYoutube($link);

    $param = '#; codecs=".*"#';
    preg_match($param, $result, $match);
    $result = str_replace($match[0],'',$result);

    $mp4file = curl($result);
    $filesize = file_put_contents('video.mp4',$mp4file);

    if($filesize > 0) {
        $allFolder = explode('/', $_SERVER['REQUEST_URI']);
        $parentFolder = $allFolder[1];

        $ketqua['error'] = false;
        $ketqua['videoLink'] = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $parentFolder . '/video.mp4';
        $ketqua['title'] = getYoutubeTitle($link);
        $ketqua['fileSize'] = $filesize;
        
    }

    echo json_encode($ketqua);
}

?>

