<?php
// Khởi động session
session_start();

//	Kiểm tra nếu đã đăng nhập thì chuyển qua ghi đề
if(isset($_SESSION['user'])){
header('location:../../lode');
}

//Require các file cần thiết
require '../../configs/config.php';
require '../../libraries/connect.php';
require '../../models/user.php';

//Nếu có POST dữ liệu lên thì xử lý
if($_POST){
    $success = true;
    // Lấy tất cả danh sách thành viên
    $user_list = get_user_list();
    // Kiểm tra xem có trùng thông tin không?
    while($user = mysql_fetch_assoc($user_list)){
        if($_POST['username']==$user['username']){
                $success = false;
                $thongbao = 'Tên tài khoản đã có người sử dụng';
        }elseif($_POST['hovaten']==$user['hovaten'] and $_POST['sodienthoai']==$user['sodienthoai']){
                $success = false;
                $thongbao = 'Bạn đã đăng kí rồi. Nếu quên mật khẩu liên hệ anh Sáng để lấy lại !';
        }elseif($_POST['repeat-password']!=$_POST['password']){
                $success = false;
                $thongbao = 'Nhập lại mật khẩu không đúng';
        }
    }
    if($success==true){
        //Nhận dữ liệu từ form và gán vào một mãng
        $data = array(
        'username' => $_POST['username'],
        'password' => md5($_POST['password']),
        'hovaten' => $_POST['hovaten'],
        'lop' => $_POST['lop'],
        'facebook' => $_POST['facebook'],
        'sodienthoai' => $_POST['sodienthoai'],
        );
        //Thêm mới
        if(add_user($data)){
        //Tạo session để lưu cờ thông báo thành công
        $_SESSION['success'] = true;
        //Vào trang lô đề (Mục đích là để xem đã có tên trong danh sách chưa)
        header('location:login.php');
        }
    }
}

//Require file giao diện (View)
require '../../views/admin/user/reg.tpl.php';
?>