<!DOCTYPE html>
<?php 
require 'nav.php';

/**********************************
            HEADER PHP
 **********************************/
// Thông báo đã có kết quả xổ số
$now = getdate();
if($now['hours']>=18){
    $thongbao = 'Đã có kết quả xổ số và danh sách trúng thưởng ngày hôm nay. <a style="color:green;font-size:18px;" href="'.SITE_URL.'/lode/main.php"><b>Xem tại đây</b></a>';
}
//Lay thong tin thanh vien qua user_id

/**********************************
     DANH SACH THANH VIEN PHP
 **********************************/
//Lấy danh sách thành viên
$user_list = get_user_list('user_id');
//In danh sách thành viên vào Table
$i = 0;
$xhtmlDSTV = '';
while ($user = mysql_fetch_assoc($user_list)){
    // HTML Cac nhom
    $nhom = '<span class="label label-danger">Quản trị viên</span>';
    if($user['status'] == 0) $nhom = '<span class="label label-warning">Đang xem xét</span>';
    if($user['status'] == 1) $nhom = '<span class="label label-success">Thành viên</span>';
    if($user['status'] == 2) $nhom = '<span class="label label-danger">Quản trị viên</span>';
    //Lay du lieu diem danh
    $tongbuoidi = get_tongbuoidi_by_id($user['user_id'], $now);
    $tongbuoinghi = get_tongbuoinghi_by_id($user['user_id'], $now);
    
    //Hien thi class cua bang
    $trclass = '';
    if($i % 2 != 0){$trclass = 'class="danger"';}
    
    $xhtmlDSTV .= '<tr '.$trclass.'>';
    $xhtmlDSTV .= '<td>'.$user['username'].'</td>';
    $xhtmlDSTV .= '<td><a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'">'.$user['hovaten'].'</a></td>';
    $xhtmlDSTV .= '<td><b>'.$user['taikhoan'].'</b> '.DONVI.'</td>';
    $xhtmlDSTV .= '<td>Đi: <b>'.$tongbuoidi.'</b> - Nghỉ: <b>'.$tongbuoinghi.'</b></td>';
//    $xhtmlDSTV .= '<td>'.$nhom.'</td>';
    $xhtmlDSTV .= '</tr>';
    $i++;
}

/**********************************
     DANG KY THAM GIA CLB PHP
 **********************************/
//Nếu có POST dữ liệu lên thì xử lý
if(!empty($_POST)){

//Nhận dữ liệu từ form và gán vào một mãng
    $data = array(
    'hovaten' => $_POST['hovaten'],
    'lop' => $_POST['lop'],
    'facebook' => $_POST['facebook'],
    'sodienthoai' => $_POST['sodienthoai'],
);
//Thêm mới
if(add_user($data)){
    //Tạo session để lưu cờ thông báo thành công
    $_SESSION['data'] = $data;
    //Thông báo
    }
}
//Nếu tồn tại section thêm mới thì không hiện form
if(isset($_SESSION['data'])){
    $thongbao = 'Bạn đã đăng ký vào CLB. Đến sảnh A vào lúc 18h gặp chủ nhiệm CLB để được hướng dẫn';
}

/**********************************
            GIAO DIEN
 **********************************/
// Require giao diện
require_once 'views/index.tpl.php';
?>
