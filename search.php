<?php
    require_once 'configs/config.php';
    require_once 'libraries/connect.php';
    require_once 'models/user.php';
    
    $now = getdate();
    $xhtmlDSTV = '';
    if(isset($_GET["s"]) && $_GET["s"] != ''){
        $user_list = get_user_by_hovaten($_GET['s']);
        $i = 0;
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
//            $xhtmlDSTV .= '<td>'.$nhom.'</td>';
            $xhtmlDSTV .= '</tr>';
            $i++;
        }
        
        echo $xhtmlDSTV;
    }
    
?>

