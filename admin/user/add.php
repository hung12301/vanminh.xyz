<?php
// Khởi động session
session_start();

//	Kiểm tra nếu chưa đăng nhập thì quay về trang đăng nhập
if(!isset($_SESSION['user'])){
header('location:login.php');
}

//Require các file cần thiết
require '../../configs/config.php';
require '../../libraries/connect.php';
require '../../models/user.php';
//Nếu có POST dữ liệu lên thì xử lý
if(!empty($_POST)){
    //Nhận dữ liệu từ form và gán vào một mãng
    $data = array(
    'username' => $_POST['username'],
    'password' => md5($_POST['password']),
    'hovaten' => $_POST['hovaten'],
    'lop' => $_POST['lop'],
    'facebook' => $_POST['facebook'],
    'sodienthoai' => $_POST['sodienthoai'],
    'status' => isset($_POST['status']) ? 3 : 1,
    );
    // Kiểm tra không rỗng
    if($data['hovaten']=='' || $data['facebook']=='' || $data['sodienthoai']=='' || $data['lop']==''){
        $thongbao = 'Không để rỗng các ô bắt buộc nhập';
    }else{
        //Thêm mới
        if(add_user($data)){
            //Tạo session để lưu cờ thông báo thành công
            $_SESSION['success'] = true;
            //Vào trang list (Mục đích là để xem đã có tên trong danh sách chưa)
            //header('location:add.php');
        }
    }
}
//Require file giao diện (View)
require '../../views/admin/user/add.tpl.php';
?>