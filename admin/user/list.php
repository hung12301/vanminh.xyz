<?php

require '../../nav.php';

//Kiểm tra nếu chưa đăng nhập thì quay về trang đăng nhập 
if(!isset($_SESSION['user'])){
header('location:login.php');
}

//Kiểm tra quyền admin
$user = get_user_by_id($_SESSION['user']['user_id']);
if($user['status']==2){
    $now = getdate();
    //Lấy danh sách thành viên
    $user_list = get_user_list();
    //Require file giao diện (View)
    require '../../views/admin/user/list.tpl.php';
}else{
	echo 'Bạn không phải Quản trị viên ! Không thể truy cập trang này';
}
?>