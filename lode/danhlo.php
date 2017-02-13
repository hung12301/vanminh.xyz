<?php
	// Khởi động session
	session_start();
	
	//Require các file cần thiết
	require '../configs/config.php';
	require '../libraries/connect.php';
	require '../models/lode.php';
	require '../models/user.php';
	
	//Kiểm tra nếu chưa đăng nhập thì quay về trang đăng nhập 
	if(!isset($_SESSION['user'])){
	header('location:../admin/user/login.php');
	}
	$thongbao = NULL;
	//Kiểm tra nếu quá 18h thì tắt ghi đề
	$now = getdate();
	if($now['hours']>=18){
		$disable = true;
		$thongbao = 'Hiện tại đã quá 18h.Chức năng đánh lô đang đóng và sẽ mở lại vào lúc 0h ngày mai.Xin cảm ơn !';
	}
	//Lấy thông tin thành viên
	$user = get_user_by_id($_SESSION['user']['user_id']);
	if($user['status']==0){
		$disable = true;
		$thongbao = 'Tài khoản của bạn chưa kích hoạt! Liên hệ anh Sáng để kích hoạt tài khoản';
	}
        $randomNumber = '';
	if(!isset($disable)){
            if(isset($_POST['random'])){
                $randomNumber = ramdomNumber();
                $thongbao = 'Tôi khuyên bạn nên đánh con: '.$randomNumber;
            }
		if(isset($_POST['submit'])){
			//Kiểm tra ô Post không được để trống
			if($_POST['conso']==""){
				$thongbao = 'Bạn chưa nhập con số !';
			}
			//Kiểm tra số tiền có lớn hơn số tiền hiện tại không
			if($_POST['sodiem']*23000 > $user['taikhoan']){
				$thongbao = 'Bạn không đủ tiền';
			}elseif(!preg_match('/^[0-9]{2}$/',$_POST['conso'])){
				$thongbao = 'Bạn phải nhập 2 số - VD: 05';
			}else{
				// Tạo mảng
				$data = array(
				'user_id' => $user['user_id'],
				'danhcon' => $_POST['conso'],
				'sodiemdanh' => $_POST['sodiem'],
                                'sotiendanh'    => $_POST['sodiem']*23000
				);
				// Lưu vào csdl
				if(danhlo($data)){
					//update số tiền trong tài khoản
					update_taikhoan_lode($data);
					//Tạo session lưu ghi đề thành công
					$_SESSION['success'] = true;
					//Reload lại trang để số tiền update
					header('location:main.php');
				}
			}
		}	
	}
	//Require file giao diện (View)
	require '../views/lode/danhlo.tpl.php';
?>