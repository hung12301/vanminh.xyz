<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Redirect;
use stdClass;
use Mail;

use App\BloggerContents as BloggerContents;
use App\BloggerUsers as BloggerUsers;
use App\BloggerLogs as BloggerLogs;

class Blogger_Controller extends BaseController
{
	protected $apiKEY = "AIzaSyCU_-RzFMLA52S_uU3zbdJyuqu_-_RzxsE";
	protected $apiURL = "https://www.googleapis.com/blogger/v3/blogs/";
	protected $blogID = "4485719543539339538";

	public function index () {
		$url = $this->apiURL . $this->blogID . '?key=' . $this->apiKEY;
		$str = file_get_contents($url);
	}

	function replaceChar($str) {

     $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
     $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
     $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
     $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
     $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
     $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
     $str = preg_replace("/(đ)/", 'd', $str);    

     $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
     $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
     $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
     $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
     $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
     $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
     $str = preg_replace("/(Đ)/", 'D', $str);

		$str = str_replace(' ', '-', $str);

		return strtolower($str);
	}

	public function saveContent ($url, $title, $type, $content, $label) {

		for($i = 0; $i < count($title); $i++) {
			$BloggerContents = new BloggerContents;
			$isset = $BloggerContents::where([
				['url','=',$url[$i]],
				['title', '=', $title[$i]]
			])->count();

			if(!$isset) {
				$BloggerContents = new BloggerContents;
				$BloggerContents->title = $title[$i];
				$BloggerContents->url = $url[$i];
				$BloggerContents->type = $type[$i];
				$BloggerContents->content = $content[$i];
				$BloggerContents->label = $label[$i];
				$BloggerContents->status = 0;
				$BloggerContents->save();
			}
		}

	}

	public function getHocVienTienAo () {
		
		// Tin tức hocvientienao.com
		$xml = file_get_contents("http://hocvientienao.com/?feed=rss2");
		$data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA );

		$i = 0;

		foreach($data->channel->item as $item) {

			$url[$i] = 'http://hocvientienao.com/';
			$type[$i] = $item->category[0];
			$label[$i] = implode(',', (array) $item->category);

			foreach((array) $item->category as $key=>$category) {
				$label[$i] .= ',' . $this->replaceChar($category);
			}

			$title[$i] = $item->title;
			$content[$i] = $item->children('content', true);
			$i++;
		}

		$this->saveContent($url, $title, $type, $content, $label);
	}

	public function getBtcnews () {

		$xml = file_get_contents("http://btcnews.vn/category/san-giao-dich/feed/");
		$data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA );

		$item = $data->channel->item;
		$url[0] = 'http://btcnews.vn/';
		$type[0] = 'san-giao-dich,Sàn giao dịch';
		$label[0] = 'san-giao-dich,Sàn giao dịch';
		$title[0] = $item[0]->title;
		$content[0] = $item[0]->children('content', true);

		$this->saveContent($url, $title, $type, $content, $label);
	}

	public function getBitcoinvietnam () {
		$xml = file_get_contents("http://bitcoinvietnam.vn/?feed=rss2");
		$data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA );

		$i = 0;

		foreach($data->channel->item as $item) {

			$url[$i] = 'http://bitcoinvietnam.vn/';
			$type[$i] = $item->category[0];
			$label[$i] = 'tin-tuc,Tin tức';
			$title[$i] = $item->title;
			$content[$i] = $item->children('content', true);
			
			$content[$i] = str_replace('/images/', 'http://bitcoinvietnam.vn/images/', $content[$i]);
			
			$i++;
		}

		$this->saveContent($url, $title, $type, $content, $label);
	}

	public function post ($data) {
		$BloggerUsers = new BloggerUsers;
		$BloggerContents = new BloggerContents;

		$access_token = $BloggerUsers::where('name','=','Văn Minh')->first()->toArray()['token'];

		$url = $this->apiURL . $this->blogID . '/posts/';
		$json = json_encode($data);
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer '. $access_token,
		    'Content-Type: application/json'
	    ));
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json); 
		$result = curl_exec($ch);
		curl_close($ch);

		$res = json_decode($result);

		echo '<pre>';
		print_r($res);
		echo '</pre>';

		$BloggerLogs = new BloggerLogs;

		$User = $BloggerContents::where('title','=', $data['title']);

		if(!empty($res->error)) {
			$BloggerLogs->content_id = $User->get()->toArray()[0]['id'];
			$BloggerLogs->message = $res->error->message;
			$BloggerLogs->save();

			$data['title'] = 'Văn Minh';

			Mail::send(['html' => 'blogger.view'], $data, function($message) {
			    $message->to('hung12301@gmail.com', 'Văn Minh')->subject('Blogger Auto Post Report');
			});

			return 0;

		} else {
			$BloggerLogs->content_id = $User->get()->toArray()[0]['id'];
			$BloggerLogs->message = 'Post Success';
			$BloggerLogs->save();

			$User->update(['status'=>1]);
		}

		return 1;
	}

	public function run () {

		$this->getHocVienTienAo();
		$this->getBtcnews();
		$this->getBitcoinvietnam();

		$BloggerContents = new BloggerContents;
		// Get Data
		$numberContentOneDay = 2;
		$datas = $BloggerContents::where('status','=',0)->limit($numberContentOneDay)->get()->toArray();
		
		foreach($datas as $data) {
			$param['title'] = $data['title'];
			$param['content'] = $data['content'];
			$param['labels'] = explode(',', $data['label']);

			if($this->post($param) == 0) return;
		}
	}

	public function saveToken () {
		if($_POST) {
			$BloggerUsers = new BloggerUsers;
			$User = $BloggerUsers::where('name','=','Văn Minh');

			if(!$User->count()) {
				$BloggerUsers->name = "Văn Minh";
				$BloggerUsers->token = $_POST['access_token'];
				$BloggerUsers->expires_in = $_POST['expires_in'];
				$BloggerUsers->save();
			} else {
				$User->update(['token'=>$_POST['access_token']]);
			}

		}
	}

	public function getToken () {
		return view('/blogger/view');
	}
	
	public function testCode () {
		$this->getBitcoinvietnam();
	}
}

?>