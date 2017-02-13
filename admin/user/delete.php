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

//Xóa
delete_user($user_id);

//Quay về trang danh sách thành viên
header('location:list.php');
?>