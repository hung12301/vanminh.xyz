<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('user-{id?}', function ($id = null) {
    return 'ID of you is ' . $id;
})->where(['id'=>'[a-z0-9]+@[a-z0-9]+.[a-z0-9]{1,4}']);

Route::get('/send', function () {
	Mail::send('send', ['title' => 'Hello World', 'content' => 'Hello :D'], function($message) {
    $message->to('hung12301@gmail.com')->subject('Chào mừng bạn đến với Facebook Tools của vanminh.xyz');
	});
	
	return 'Success';
});

Route::get('/view/send', function () {
	return view('send');
});

Route::get('/facebook', 'Facebook_Controller@getCode');
Route::get('/facebook/login', 'Facebook_Controller@getAccessToken');
Route::get('/facebook/logout', 'Facebook_Controller@Logout');
Route::get('/facebook/page/{id}/add', 'Facebook_Controller@PageIndex');
Route::post('/facebook/page/add', 'Facebook_Controller@PagePostAdd');
Route::get('/facebook/auto', 'Facebook_Controller@AutoPost');

Route::get('/blogger/', 'Blogger_Controller@index');
Route::get('/blogger/test', 'Blogger_Controller@testCode');
Route::get('/blogger/run', 'Blogger_Controller@run');
Route::post('/blogger/save-token', 'Blogger_Controller@saveToken');
Route::get('/blogger/get-token', 'Blogger_Controller@getToken');