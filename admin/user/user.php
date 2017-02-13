<?php
    require '../../nav.php';

    //Lấy thông tin người dùng qua user_id trên URL
    $id = $_GET['user_id'];
    $user = get_user_by_id($id);
    if(isset($_SESSION['user'])){
            $user_visit = get_user_by_id($_SESSION['user']['user_id']);
    }
    $now = getdate();
    $user_lode = get_lode_by_userid($id);
    $user_diemdanh = get_diemdanh_by_id($id,$now);
    $tongbuoidi = get_tongbuoidi_by_id($id,$now);
    $tongbuoinghi = get_tongbuoinghi_by_id($id,$now);
    function checkThoigian($now,$thoigian){
        $flat = false;
        $day = date('d',  strtotime($thoigian));
        $month = date('m',  strtotime($thoigian));
        $year = date('Y',  strtotime($thoigian));
        if($now['mday'] == $day && $now['mon'] == $month && $now['year']== $year && $now['hours']<=19){
             $flat = true;
        }
        return $flat;
    }

    //Require file giao diện (View)
    require '../../views/admin/user/user.tpl.php';
?>