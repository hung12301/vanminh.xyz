<?php
    if(isset($_GET['shortToken'])){
        $appID = '1692047901055669';
        $appSecret = '32b94b0e0944bd235113fd4904ed8775';
        $shortToken = $_GET['shortToken'];
        
        $url = 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.$appID.'&client_secret='.$appSecret.'&fb_exchange_token=' . $shortToken;

        $longToken = file_get_contents($url);

        echo $longToken;
    }

 
            
            
            
    

