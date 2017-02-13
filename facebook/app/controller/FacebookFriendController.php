<?php
	class FacebookFriendController extends Controller
	{
		public function index () {
			return Route::redirect('/');
		}

		public function tudongketban () {
		  	if(!isset($_SESSION['user']) || empty($_POST)) {
				Session::setFlash('error', "Bạn chưa đăng nhập hoặc không có quyền vào trang này");
				return Route::redirect('/tu-dong-ket-ban');
			}

			if(empty($_POST['facebook_id']) || $_POST['facebook_id'] == '') {
				Session::setFlash('error', "Bạn chưa chọn tài khoản Facebook");
				return Route::redirect('/tu-dong-ket-ban');
			}

			if(!isset($_POST['users']) || empty($_POST['users'])) {
				Session::setFlash('error', "Không có nhóm nào được chọn");
				return Route::redirect('/tu-dong-ket-ban');
			}

	        if($_POST) {
	        	$FacebookSchedules = $this->model('FacebookSchedules');
	        	$FacebookAddFriend = $this->model('FacebookAddFriend');
	        	// Create new Schedule
				$FacebookSchedules->insert([
					'user_id'=> $_SESSION['user']['id'],
					'facebook_id'=>$_POST['facebook_id'],
					'type'=>'add-friend',
					'status'=>1,
					'distance'=>$_POST['distance'],
				]);
				// Get last schedule and last content
				$lastScheduleID = $FacebookSchedules->select('id')->where(['user_id'=>$_SESSION['user']['id']])->orderBy('id', 'desc')->first()['id'];
				foreach($_POST['users'] as $user) {
					$user = explode("|", $user);
					$FacebookAddFriend->insert([
						'schedule_id'=>$lastScheduleID,
						'facebook_id'=>$_POST['facebook_id'],
						'user_id'=>$user[0],
						'user_name'=>$user[1]
					]);
				}
				Session::setFlash('success', 'Lên lịch thành công');
	        }

	        return Route::redirect('/');
		}

		public function xemchitietketban ($scheduleID) {
			if(!isset($_SESSION['user'])) {
				return Route::redirect('/');
			}

			$FacebookAddFriend = $this->model('FacebookAddFriend');
			$FacebookAccounts = $this->model('FacebookAccounts');
			$FacebookSchedules = $this->model('FacebookSchedules');

			$data['users'] = $FacebookAddFriend->select('*')->where(['schedule_id'=>$scheduleID])->get();
			$data['added'] = 0;
			foreach ($data['users'] as $value) {
				if($value['status'] == 1) $data['added']++;
			}
			$data['schedule'] = $FacebookSchedules->select('*')->where(['id'=>$scheduleID])->first();
			$data['facebookAccount'] = $FacebookAccounts->select('*')->where(['facebook_id'=>$data['schedule']['facebook_id']])->first();
			return $this->view('/facebook-friend/view-more-add-friend',$data);
		}

		public function suaketban ($scheduleID = null) {
			if(!isset($_SESSION['user']) || $scheduleID == null) return Route::redirect('/');
			if($_POST) {
				$FacebookSchedules = $this->model('FacebookSchedules');
				if($FacebookSchedules->select('id')->where(['user_id'=>$_SESSION['user']['id'], 'id'=>$scheduleID])->count() == 0) {
					Session::setFlash('error','Bạn không có quyền sửa tác vụ này');
					return Route::back();
				}
				$FacebookSchedules->update(['id'=>$scheduleID],[
					'distance'=>$_POST['distance'],
				]);
				Session::setFlash('success','Sửa thành công');
			}
			return Route::back();
		}
	}
?>