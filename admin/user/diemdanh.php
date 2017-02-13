<meta charset="utf-8">
<?php

ob_start();
//Require các file cần thiết
require '../../nav.php';

//Kiểm tra nếu chưa đăng nhập thì quay về trang đăng nhập 
    if(!isset($_SESSION['user'])){
        header('location:login.php');
    }
    
//Kiểm tra quyền điểm danh
$user_admin = get_user_by_id($_SESSION['user']['user_id']);
if($user_admin['status'] == 2){
    $quyenadmin = true;
}
$now = getdate();
if($user_admin['status'] == 2 or $user_admin['status']== 3){
//Lay ghi chu
$filename = 'ghichu.txt';
$string = file_get_contents($filename);
$ghichu = explode("|", $string);
//Them ghi chu
if(isset($_POST['themghichu']) && file_exists($filename)){
    $string = '| ['.$now['mday'].'/'.$now['mon'].'] ' . $_POST['textghichu'];
    $file = fopen($filename, "a");
    if(fwrite($file, $string) != FALSE){
        header('location:diemdanh.php');
    }
}

//Lấy danh sách thành viên
$user_list = get_user_list();
$date = array(
'ngay' => $now['mday'],
'thang' => $now['mon'],
'nam'	=> $now['year']
);
$now = getdate();
if ($now['hours'] >= 19){
    //Lấy danh sách điểm danh hôm nay
    $user_diemdanh_today = get_diemdanh_by_day($now);
    if(mysql_num_rows($user_diemdanh_today)>=1){
        $user = mysql_fetch_assoc($user_diemdanh_today);
        $user_name_diemdanh_today = get_user_by_id($user['user_id_diemdanh']);
        $thongbao = 'Ngày hôm nay đã được điểm danh bởi '.$user_name_diemdanh_today['hovaten'].' vào lúc '.date('H:i',strtotime($user['ngaydiemdanh'])).'';
    }
}else{
        $thongbao = "Chưa đến giờ Điểm Danh. 19h đến 23h59 mới là giờ điểm danh";
}
//Require file giao diện (View)
require '../../views/admin/user/diemdanh.tpl.php';
}else{
die('Bạn không phải Điểm danh viên hoặc Quản trị viên ! Không thể truy cập trang này');
}
?>