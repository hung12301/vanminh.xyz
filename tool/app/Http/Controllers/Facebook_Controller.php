<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Redirect;
use stdClass;
use App\FacebookUsers as fbUser;
use App\FacebookPages as fbPage;
use App\FacebookAutoLogs as fbAutoLog;
use App\FacebookPageSchedules as fbPageSchedules;

require_once app_path() . '/Facebook/vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
use Facebook\Facebook as Facebook;
use Facebook\Exceptions\FacebookResponseException as FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException as FacebookSDKException;

session_start();

class Facebook_Controller extends BaseController {
	
	private $FB = null;
	
	public function __construct () {
		$this->FB = new Facebook ([
		  'app_id' => '1692047901055669',
		  'app_secret' => '32b94b0e0944bd235113fd4904ed8775',
		  'default_graph_version' => 'v2.5',
		]);
	}

	public function saveUser ($data) {
		
		$user = new fbUser;
		
		$user->access_token = $data->access_token;
		$user->facebook_id = $data->profile['id'];
		$user->name = $data->profile['name'];
		$user->sex = $data->profile['gender'];
		$user->avatar = $data->profile['avatar'];
		$user->timestamp = time();
		$user->save();
	}

	public function updateAccessToken ($id, $access_token) {
		$user = fbUser::where('facebook_id', $id)->update(['access_token' => $access_token]);
	}

	public function getAvatar ($id) {
		$res = $this->FB->get('/' .$id. '/picture?width=9999&redirect=false')->getDecodedBody();

		return $res['data']['url'];
	}
	
	public function updatePageInDatabase ($facebook_id,$data) {
		
		$page = fbPage::where('page_id', $data['page_id'])->first();
		
		$page->facebook_id = $facebook_id;
		$page->page_id = $data['page_id'];
		$page->name = $data['name'];
		$page->avatar = $data['avatar'];
		$page->access_token = $data['access_token'];
		$page->save();
	}
	
	public function savePageInDatabase ($facebook_id,$data) {
		
		if(fbPage::where('page_id', $data['page_id'])->count() > 0) {
 			$this->updatePageInDatabase($facebook_id,$data);
			return ;
		}
		
		$page = new fbPage;
		
		$page->facebook_id = $facebook_id;
		$page->page_id = $data['page_id'];
		$page->name = $data['name'];
		$page->avatar = $data['avatar'];
		$page->access_token = $data['access_token'];
		$page->save();
	}
	
	public function getAllPageInDatabase ($facebook_id) { 
		$data = fbPage::where('facebook_id', $facebook_id)->get()->toArray();
		
		return $data;
	}

	public function getAllPageOnline ($facebook_id) {
		$result = [];

		$response = $this->FB->get('/me/accounts')->getDecodedBody();

		foreach($response['data'] as $key=>$value) {
			
			$result[$key] = [];
			$result[$key]['access_token'] = $value['access_token'];
			$result[$key]['name'] = $value['name'];
			$result[$key]['page_id'] = $value['id'];
			$result[$key]['avatar'] = $this->getAvatar($value['id']);
			
			$this->savePageInDatabase($facebook_id,$result[$key]);
		}
		
		return $result;
	}
	
	public function getLoginUrl ($permissions) {
		$helper = $this->FB->getRedirectLoginHelper();
		return $helper->getLoginUrl(url('/facebook/login'), $permissions);
	}
	
	public function isLiveAccessToken ($access_token) {
		
		try {
			$this->FB->get('/me?access_token=' . $access_token);
		} catch (FacebookSDKException $e) {
			return 0;
		}
		
		return 1;
	}
	
	public function getCode () {
		$loginUrl = $this->getLoginUrl(['email', 'public_profile', 'publish_actions', 'manage_pages', 'publish_pages', '	
pages_show_list', 'publish_actions']);

		$data = new stdClass;
		$data->loginUrl = $loginUrl;
		$data->loggedIn = false;
		
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']->isExpired() == false) {
			
			$access_token = $_SESSION['access_token']->getValue();

			if(!$this->isLiveAccessToken($access_token))
				return view('facebook.index', ['data' => $data]);
			
			$this->FB->setDefaultAccessToken($_SESSION['access_token']->getValue());
			$response = $this->FB->get('/me?fields=name,id,gender');
			$data->profile = $response->getDecodedBody();
			$data->loggedIn = true;
			$data->profile['avatar'] = $this->getAvatar($data->profile['id'],$access_token);
			$data->access_token = $access_token;

			if(fbUser::all()->where('facebook_id', $data->profile['id'])->count() >= 1) {
				$data->allPage = $this->getAllPageInDatabase($data->profile['id']);
				$this->updateAccessToken($data->profile['id'],$access_token);
			} else {
				$this->saveUser($data);
				$data->allPage = $this->getAllPageOnline($data->profile['id']);
			}
	    }

	  	return view('facebook.index', ['data' => $data]);
	}

	public function getAccessToken () {

	  $helper = $this->FB->getRedirectLoginHelper();
	  $accessToken = $helper->getAccessToken();
	  $_SESSION['access_token'] = $accessToken;

	  if(isset($accessToken)) {
	  	return view('facebook.close');
	  } else {
	  	return 'Login Error';
	  }
	}

	public function Logout () {
		// $helper = $this->FB->getRedirectLoginHelper();
		// $logoutUrl = $helper->getLogoutUrl($_SESSION['access_token'], url('/facebook'));
		// Delete user
		if(isset($_SESSION['access_token'])) {
			fbUser::where('access_token',$_SESSION['access_token'])->delete();
			session_destroy();
		}
		return Redirect::to('/facebook');
	}

	public function PageIndex ($id) {
		return view('facebook.auto.index');
	}
	
	public function getPageAccessToken ($page_id) {
		$page = fbPage::select('access_token')->where('page_id', $page_id)->first()->toArray();
		return $page['access_token'];
	}
	
	public function getPageInfo ($link,$access_token) {
		$request = $this->FB->request("GET", '/' .$link);
		$request->setParams([
			'access_token' => $access_token
		]);
		$res = $this->FB->getClient()->sendRequest($request);
		return $res->getDecodedBody();
	}
	
	public function isExistPageIdGet ($page_id_get,$page_id) {
		return fbPageSchedules::where('page_id_get', $page_id_get)->where('page_id', $page_id)->count();
	}
	
	public function PagePostAdd (Request $request) {
		
		$page_id = $request->page_id;
		$link = $request->page_id_get;
		$distance_time = (int)$request->distance_time;
		
		$page_access_token = $this->getPageAccessToken($page_id);
		$page_info_get = $this->getPageInfo($link,$page_access_token);
		$page_id_get = $page_info_get['id'];
		$page_name_get = $page_info_get['name'];
		
		if($this->isExistPageIdGet($page_id_get,$page_id)) {
			return 'This link of page is exist !';
		}else {
			$data = new fbPageSchedules;
			
			$data->page_id = $page_id;
			$data->page_id_get = $page_id_get;
			$data->page_name_get = $page_name_get;
			$data->last_post_id = "0";
			$data->distance_time = $distance_time;
			$data->options = "0";
			
			$data->save();
		}
		
		return redirect('/facebook');
	}
	
	public function getFirstPost ($page_id_get,$access_token) {
		$res = $this->FB->get('/' . $page_id_get . '/feed?limit=1&access_token=' . $access_token)->getDecodedBody();
		return $res['data'][0]['id'];
	}
	
	public function getLastPost ($page_id_get, $page_id) {
		$data = fbPageSchedules::select('last_post_id')->where('page_id_get',$page_id_get)->where('page_id', $page_id)->first()->toArray();
		return $data['last_post_id'];
	}
	
	public function isWallPostStatus ($post_id, $page_id_get, $access_token) {
		$res = $this->FB->get('/' . $post_id . '?fields=from&access_token=' . $access_token)->getDecodedBody();
		
		if($res['from']['id'] == $page_id_get)
			return 0;
		
		return 1;
	}
	
	public function getPostInfo ($post_id, $access_token) {
		$res = $this->FB->get('/' . $post_id . '?fields=full_picture,link,permalink_url,type,message,source&access_token=' . $access_token)->getDecodedBody();
		return $res;
	}
	
	public function updateDatabase ($page_id_get,$page_id,$last_post_id) {
		$data = fbPageSchedules::where('page_id_get', $page_id_get)->where('page_id', $page_id)->first();
		$data->last_post_id = $last_post_id;
		$data->save();
	}
	
	public function getLinkVideoHD ($link) {
		  $url = 'http://vanminh.xyz/facebook-get/getVideoHd.php?link=' . $link;

		  echo $url;

		  $data = file_get_contents($url);
		  return json_decode($data);
	}
	
	public function saveToDatabaseFacebookAutoLog ($data) {
		$log = new fbAutoLog;
		$log->page_id_get = $data['page_id_get'];
		$log->page_name_get = $data['page_name_get'];
		$log->page_id = $data['page_id'];
		$log->post_id = $data['post_id'];
		$log->type = $data['type'];
		$log->description = $data['description'];
		$log->save();
	}
	
	public function AutoPost () {
		$data = fbPageSchedules::all()->toArray();
		
		foreach($data as $value) {
			
			$last_time = strtotime($value['updated_at']);
			$current_time = time();
			$distance_time = (int)$value['distance_time'] * 60;
			$page_id_get = $value['page_id_get'];
			$page_id = $value['page_id'];
			$page_name_get = $value['page_name_get'];
			echo $page_name_get;
			
			if($current_time - $last_time >= $distance_time) {
				$access_token = $this->getPageAccessToken($page_id);
				$first_post_id = $this->getFirstPost($page_id_get,$access_token);
				$last_post_id = $this->getLastPost($page_id_get,$page_id);
				
				if($this->isWallPostStatus($first_post_id,$page_id_get,$access_token) || $first_post_id == $last_post_id)
				{
					echo 'This post of ' . $value['page_name_get'] . ' is exist on ' . $this->getPageInfo($page_id,$access_token)['name'];
					echo '<hr/>';
					continue;
				}
				
				$post_info = $this->getPostInfo($first_post_id,$access_token);
				$type = $post_info['type'];
				$request = $this->FB->request('POST', '/' . $page_id . '/feed?access_token=' . $access_token);
				
				if($type == 'status') {
					$request->setParams([
						'message' => isset($post_info['message']) ? $post_info['message'] : '',
					]);
				}
				
				
				if($type == 'link') {
					$request->setParams([
						'link' => $post_info['link'],
						'message' => isset($post_info['message']) ? $post_info['message'] : ''
					]);
				}
				
				if($type == 'photo') {
					$request = $this->FB->request('POST', '/' . $page_id . '/photos?access_token=' . $access_token);
					$request->setParams([
						'url' => $post_info['full_picture'],
						'caption' => isset($post_info['message']) ? $post_info['message'] : ''
					]);
				}
				
				if($type == 'video') {
					$request = $this->FB->request('POST', '/' . $page_id . '/videos?access_token=' . $access_token);
					$request->setParams([
						'file_url' => $this->getLinkVideoHD($post_info['permalink_url'])->url,
						'description' => isset($post_info['message']) ? $post_info['message'] : ''
					]);
				}
				
				$this->updateDatabase($page_id_get,$page_id,$first_post_id);
				$res = $this->FB->getClient()->sendRequest($request)->getDecodedBody();
				
				if(!empty($res['id'])) {
// 					Save log to database
					$data = array(
						'page_id_get' => $page_id_get,
						'page_name_get' => $value['page_name_get'],
						'page_id' => $page_id,
						'post_id' => $res['id'],
						'type' => $type,
						'description' => isset($post_info['message']) ? $post_info['message'] : ''
					);
					//$this->saveToDatabaseFacebookAutoLog($data);
					echo 'Post Success ! <br>';
				} else {
					echo 'Post Error ! <br>';
				}
				
				echo 'From: ' . $value['page_name_get'] . ' Type: ' . $type;
				echo '<pre>';print_r($res);echo '</pre>';
				echo '<hr/>';
			}
		}
	}

}

?>
