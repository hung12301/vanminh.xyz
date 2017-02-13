<meta charset="utf-8">
<?php
// Khởi động session
session_start();

//Require các file cần thiết
require '../configs/config.php';
require '../libraries/connect.php';
require '../models/lode.php';
require '../models/simple_html_dom.php';

// Lấy kết quả đặc biệt từ ketqua.net
$link = 'http://xoso.wap.vn/';
$html = file_get_html($link);
// Khai báo mảng
$array = array();
$dacbiet = array();
            $i = 0;
foreach($html->find('td[class="web_XS_2 chukq"]') as $e){
        foreach($html->find('span[class="do"]') as $f)
        $dacbiet[$i++] = $f->innertext;
        $array[$i++] = $e->innertext;
}
//Lấy 2 số của giải đặc biệt
$dacbiet = array_shift($dacbiet);
//Lấy các phần tử từ mảng array (Lấy các giải khác)
$data = array_slice($array,1,26);


//Add vào CSDL
if(add_ketqua($dacbiet,$data)){
    echo 'Đã cập nhật kết quả xổ số <br/>';
};

$dacbiet = substr($dacbiet,-2);
//Lay 2 so cuoi cua cac giai
foreach($data as $value){
    $haisocuoi[] = substr($value,-2);
}
    $haisocuoi[] = $dacbiet;
//Lấy ngày hôm nay
$now = getdate();
$date = array(
'ngay' => $now['mday'],
'thang' => $now['mon'],
'nam'	=> $now['year']
);
$list_lode_today = get_list_lode_today($date);
$thongbao = '';
while($user = mysql_fetch_assoc($list_lode_today)){
    $play_id = $user['play_id'];
    $user_id = $user['user_id'];
    $user_info = get_user_by_userid($user_id);
    $user_name = $user_info['hovaten'];
    $lohayde = $user['lohayde'];
    $danhcon = $user['danhcon'];
    $sotiendanh  = $user['sotiendanh'];
    $sodiemdanh = $user['sodiemdanh'];
    $thoigianghi = $user['thoigianghi'];
    $trung = $user['trung'];
    $ande = 0;
    $anlo = 0;
    if($lohayde==1){
        if($danhcon==$dacbiet){
            $ande++;
        }
        if($ande<=0){
            $thongbao .= $user_name.' tạch đề con '.$danhcon.'<br/>';
        }else{
            if($trung == 0){
                $sotientrung = $sotiendanh * 70;
                $thongbao .= $user_name . ' trúng đềcon '.$danhcon.' +'.$sotientrung.'<br/>';
                if(!update_taikhoan_trung($user_id,$sotientrung) || !update_trangthai_trung($play_id)){
                die('Lỗi Update CSDL');
                }
            }
        }
    }else{
        foreach($haisocuoi as $value){
            if($danhcon==$value){
               $anlo++;
            }
        }
        if($anlo<=0){
           $thongbao .= $user_name.' tạch lô con '.$danhcon.'<br/>';
        }else{
            if($trung == 0){
            $sotientrung = ($sodiemdanh * 80000)*$anlo;
            $thongbao .= $user_name . ' trúng lô '.$anlo.' nháy con '.$danhcon.' +'.$sotientrung.'<br/>';
               if(!update_taikhoan_trung($user_id,$sotientrung) || !update_trangthai_trung($play_id)){
               die('Lỗi Update CSDL');
               }
            }
        }
    }
}
echo $thongbao;
//Lưu log vao file TxT
$filename = 'log/'.$date['ngay'].'_'.$date['thang'].'_'.$date['nam'].'.txt';
file_put_contents($filename, $thongbao);
?>