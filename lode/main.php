<?php

//Require các file cần thiết
require '../nav.php';


if(isset($_SESSION['user'])){
//Lấy số tiền trong tài khoản
$user_list_by_id = get_user_by_id($_SESSION['user']['user_id']);
}

//Lấy ngày hôm nay
$now = getdate();
$date = array(
'ngay' => $now['mday'],
'thang' => $now['mon'],
'nam'	=> $now['year']
);
//Lấy danh sách thành viên
$user_list = topdaigia();
//Lay danh sach danh de hom nay
$list_lode_today = get_list_lode_today($date);
//Lay danh sach trung thuong hom nay
$list_trung_today = get_list_trung_today($date);
//Lay danh sach cac ket qua trong ngày
$list_ketqua_today = mysql_fetch_array(get_list_ketqua_today($date));
// Function Get Giai
function getGiai($list_ketqua_today,$min,$max){
$result = '';
    for($i=$min;$i<=$max;$i++){
        if($i == $max){
            $result .= $list_ketqua_today[$i];    
        }else{
            $result .= $list_ketqua_today[$i] .' - ';
        }
    }
return $result;
}
//Require file giao diện (View)
require '../views/lode/main.tpl.php';
?>