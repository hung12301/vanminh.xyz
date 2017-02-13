<?php
	
    define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/facebook');
    define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/facebook');
    define('FACEBOOK_API', 'https://graph.facebook.com/v2.3/');

    Config::set('DB_HOST', 'localhost');
    Config::set('DB_USERNAME', 'vanminhx');
    Config::set('DB_PASSWORD', 'hungvip12');
    Config::set('DB_NAME', 'vanminhx_fb');
    Config::set('DB_CHARSET', 'UTF8');
    Config::set('SSL', false);

    Config::set('password_prefix', 'acdata@123');
?>