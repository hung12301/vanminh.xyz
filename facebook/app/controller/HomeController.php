<?php 

require_once ROOT . '/app/controller/FacebookController.php';

class HomeController extends Controller {
    
    public function index () {
    	if(!isset($_SESSION['user'])) {
    		return Route::redirect('/thanh-vien/dang-nhap');
    	}
    	// Require
    	$FacebookAccounts = $this->model('FacebookAccounts');
        $FacebookPostGroup = $this->model('FacebookPostGroup');
        $FacebookJoinGroup = $this->model('FacebookJoinGroup');
        $FacebookComments = $this->model('FacebookComments');
    	$FacebookAddFriend = $this->model('FacebookAddFriend');
        $FacebookSchedules = $this->model('FacebookSchedules');
    	// Get All Facebook Account
    	$data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        // Get last schedule
        $data['allSchedules'] = $FacebookSchedules->select('*')->where(['user_id'=>$_SESSION['user']['id'],'done'=>0])->get();
        foreach ($data['allSchedules'] as $key => $schedule) {

            $data['allSchedules'][$key]['facebookAccount'] = $FacebookAccounts->select('*')->where(['facebook_id'=>$schedule['facebook_id']])->first();
            
            if($schedule['type'] == 'post-group') {
                $data['allSchedules'][$key]['nearPost'] = $FacebookPostGroup->getNearPostByScheduleId($schedule['id']);
                $data['allSchedules'][$key]['nearPost']['groupName'] = FacebookController::getGroupNameById($data['allSchedules'][$key]['nearPost']['group_id'],$data['allSchedules'][$key]['facebookAccount']['access_token']);
                $data['allSchedules'][$key]['posted'] = $FacebookPostGroup->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data['allSchedules'][$key]['post'] = $FacebookPostGroup->select('*')->where(['schedule_id'=>$schedule['id']])->count();
            }

            if($schedule['type'] == 'join-group') {
                $data['allSchedules'][$key]['nearJoin'] = $FacebookJoinGroup->getNearJoinByScheduleId($schedule['id']);
                $data['allSchedules'][$key]['nearJoin']['groupName'] = FacebookController::getGroupNameById($data['allSchedules'][$key]['nearJoin']['group_id'],$data['allSchedules'][$key]['facebookAccount']['access_token']);
                $data['allSchedules'][$key]['joined'] = $FacebookJoinGroup->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data['allSchedules'][$key]['join'] = $FacebookJoinGroup->select('*')->where(['schedule_id'=>$schedule['id']])->count();
            }

            if($schedule['type'] == 'up-top') {
                $data['allSchedules'][$key]['nearComment'] = $FacebookComments->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>0])->first();
                $data['allSchedules'][$key]['commented'] = $FacebookComments->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data['allSchedules'][$key]['comment'] = $FacebookComments->select('*')->where(['schedule_id'=>$schedule['id']])->count();
            }

            if($schedule['type'] == 'add-friend') {
                $data['allSchedules'][$key]['nearAdd'] = $FacebookAddFriend->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>0])->first();
                $data['allSchedules'][$key]['added'] = $FacebookAddFriend->select('*')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data['allSchedules'][$key]['add'] = $FacebookAddFriend->select('*')->where(['schedule_id'=>$schedule['id']])->count();
            }
        }

    	return $this->view('/home/index',$data);
    }

    public function tudongdangnhom () {
    	if(!isset($_SESSION['user'])) {
    		return Route::redirect('/');
    	}
    	// Get All Facebook Account
    	$FacebookAccounts = $this->model('FacebookAccounts');
    	$data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
    	return $this->view('facebook-group/post-group', $data);
    }

    public function tudongthamgianhom () {
    	if(!isset($_SESSION['user'])) {
    		return Route::redirect('/');
    	}
    	// Require
    	$FacebookAccounts = $this->model('FacebookAccounts');
    	// Get All Facebook Account
    	$data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
    	return $this->view('facebook-group/join-group', $data);
    }

    public function uptopbaiviet ($facebookID = null,$listPostID = null) {

        if(!isset($_SESSION['user'])) {
            return Route::redirect('/');
        }

        // Require
        $FacebookAccounts = $this->model('FacebookAccounts');

        // Get All Facebook Account
        $data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        $listPostID = explode("&", $listPostID);
        $data['facebookID'] = $facebookID;
        $data['listPostID'] = '';
        foreach ($listPostID as $key=>$value) {
            if($key != count($listPostID) - 1) $data['listPostID'] .= $value . "\n";
            else $data['listPostID'] .= $value;
        }
        return $this->view('facebook-comment/up-top', $data);
    }

    public function tudongketban () {
        if(!isset($_SESSION['user'])) {
            return Route::redirect('/');
        }

        // Require
        $FacebookAccounts = $this->model('FacebookAccounts');

        // Get All Facebook Account
        $data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        return $this->view('facebook-friend/add-friend', $data);
    }

    public function tudongchapnhanketban () {
        if(!isset($_SESSION['user'])) {
            return Route::redirect('/');
        }

        // Require
        $FacebookAccounts = $this->model('FacebookAccounts');

        // Get All Facebook Account
        $data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        return $this->view('facebook-friend/accept-friend', $data);
    }

    public function tudonghuyketban () {
        if(!isset($_SESSION['user'])) {
            return Route::redirect('/');
        }

        // Require
        $FacebookAccounts = $this->model('FacebookAccounts');

        // Get All Facebook Account
        $data['facebookAccounts'] = $FacebookAccounts->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        return $this->view('facebook-friend/delete-friend', $data);
    }

    public function tacvu () {
        if(!isset($_SESSION['user'])) return Route::redirect('/');
        // Require
        $FacebookAccounts = $this->model('FacebookAccounts');
        $FacebookPostGroup = $this->model('FacebookPostGroup');
        $FacebookJoinGroup = $this->model('FacebookJoinGroup');
        $FacebookComments = $this->model('FacebookComments');
        $FacebookAddFriend = $this->model('FacebookAddFriend');
        $FacebookSchedules = $this->model('FacebookSchedules');
        // Get all schedule
        $data = $FacebookSchedules->select("*")->where(['user_id'=>$_SESSION['user']['id']])->get();
        // Get Info
        foreach ($data as $key => $schedule) {
            // Facebook Account
            $data[$key]['facebookAccount'] = $FacebookAccounts->select('*')->where(['facebook_id'=>$schedule['facebook_id']])->first();
            // Process
            if($schedule['type'] == 'post-group') {
                $data[$key]['process']['done'] = $FacebookPostGroup->select('id')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data[$key]['process']['all'] = $FacebookPostGroup->select('id')->where(['schedule_id'=>$schedule['id']])->count();
            } else if ($schedule['type'] == 'join-group') {
                $data[$key]['process']['done'] = $FacebookJoinGroup->select('id')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data[$key]['process']['all'] = $FacebookJoinGroup->select('id')->where(['schedule_id'=>$schedule['id']])->count();
            } else if ($schedule['type'] == 'up-top') {
                $data[$key]['process']['done'] = $FacebookComments->select('id')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data[$key]['process']['all'] = $FacebookComments->select('id')->where(['schedule_id'=>$schedule['id']])->count();
            } else if ($schedule['type'] == 'add-friend') {
                $data[$key]['process']['done'] = $FacebookAddFriend->select('id')->where(['schedule_id'=>$schedule['id'],'status'=>1])->count();
                $data[$key]['process']['all'] = $FacebookAddFriend->select('id')->where(['schedule_id'=>$schedule['id']])->count();
            }
        }
        return $this->view('home/tac-vu', $data);
    }
}

?>