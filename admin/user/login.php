<?php
	// Khởi động session
	session_start();
	
	// Kiểm tra nếu đã đăng nhập thì quay về trang quản trị
	if(isset($_SESSION['user'])){
            header('location:list.php');
	}
	//Require các file cần thiết
	require '../../configs/config.php';
	require '../../libraries/connect.php';
	require '../../models/user.php';
	
	//Kiểm tra dữ liệu POST lên
	if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
	//Gán tài khoản và mật khẩu nhận được từ form vào 2 biến tương ứng
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//Lấy thông tin thành viên từ DB
	$user = get_user_by_username($username);
	
	//Kiểm tra sự tồn tại của thành viên và mật khẩu có trùng khớp
	if($user && $user['password'] === md5($password)){
	//Tạo session lưu thông tin thành viên đăng nhập thành công
	$_SESSION['user'] = $user;
	
	//Chuyển hướng về trang chủ quản trị
	header('location:../../index.php');
	}else{
	//Bật cờ lỗi
	$error = true;
	}
	}
	
	//Require file giao diện (View)
	require '../../views/admin/user/login.tpl.php';
?>