<meta charset="utf-8">
<?php
//Khởi động session
session_start();

//Kiểm tra nếu chưa đăng nhập thì quay về trang đăng nhập
if(!isset($_SESSION['user'])){
header('location:login.php');
}

//Require các file cần thiết
require '../../configs/config.php';
require '../../libraries/connect.php';
require '../../models/user.php';

//Lấy user_id từ URL
$user_id = $_GET['user_id'];
if($_SESSION['user']['user_id'] == $user_id || $_SESSION['user']['status'] == 2){
    //Nếu có POST dữ liệu lên thì xử lý cập nhật
    if($_POST){
    //Nhận dữ liệu từ form và gán vào một mãng
    $data = array(
    'password' => empty($_POST['password']) ? null : md5($_POST['password']),
    'hovaten' => $_POST['hovaten'],
    'lop' => $_POST['lop'],
    'facebook' => $_POST['facebook'],
    'sodienthoai' => $_POST['sodienthoai'],
    'status' => empty($_POST['status']) ? null : $_POST['status'],
    'taikhoan' => empty($_POST['taikhoan']) ? null : $_POST['taikhoan']
    );

    //Cập nhật
    if(edit_user($data, $user_id)){
    $thongbao = 'Sửa thành công';
    }
    }

    //Lấy thông tin thành viên để trình bày trên form
    $user = get_user_by_id($user_id);

    //Require file giao diện (View)
    require '../../views/admin/user/edit.tpl.php';
}else{
    die('Bạn không có quyền sửa thành viên này');
}
	
?>