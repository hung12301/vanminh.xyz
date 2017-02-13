<?php
    function getCurrentPageURL() {
    $pageURL = 'http';
 
    if (!empty($_SERVER['HTTPS'])) {
      if ($_SERVER['HTTPS'] == 'on') {
        $pageURL .= "s";
      }
    }
 
    $pageURL .= "://";
 
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
 
    return $pageURL;
    }

    function get_user_by_username($username){
        $sql = "SELECT * FROM user WHERE username = '{$username}'";
        $query = mysql_query($sql);
        return mysql_fetch_assoc($query);
    }
    
    function get_user_by_hovaten($hovaten){
        $sql = "SELECT * FROM user WHERE MATCH (hovaten) AGAINST ('+{$hovaten}' IN BOOLEAN MODE)";
        return mysql_query($sql);
    }
    
    function get_user_list($orderby = 'user_id'){
    $sql = "SELECT * FROM user ORDER BY {$orderby}";

    //Query và return
    return mysql_query($sql);
    }

    function topdaigia(){
    //SQL
    $sql = "SELECT * FROM user ORDER BY taikhoan DESC limit 10";

    //Query và return
    return mysql_query($sql);
    }

    function add_user($data){
    
    
    if(isset($data['password']) && isset($data['username']) && isset($data['status'])){
        $sql = "INSERT INTO user(username,password,status,hovaten,lop,facebook,sodienthoai) VALUES ('{$data['username']}','{$data['password']}',{$data['status']},'{$data['hovaten']}', '{$data['lop']}', '{$data['facebook']}', '{$data['sodienthoai']}')";
        }else{
            $sql = "INSERT INTO user(hovaten,lop,facebook,sodienthoai) VALUES('{$data['hovaten']}', '{$data['lop']}', '{$data['facebook']}', '{$data['sodienthoai']}')";
        }
        
        return mysql_query($sql);
    }
    
    
    function get_user_by_id($user_id){
    //SQL
    $sql = "SELECT * FROM user WHERE user_id = $user_id";

    //Query
    $query = mysql_query($sql);

    //Fetch và return
    return mysql_fetch_assoc($query);
    }

    function edit_user($data, $user_id){
    //SQL
    $sql = "UPDATE user SET hovaten = '{$data['hovaten']}', lop = '{$data['lop']}', facebook = '{$data['facebook']}', sodienthoai = '{$data['sodienthoai']}'";

    //Nếu có cập nhật mật khẩu
    if($data['password'] != null){
    $sql .= ", password = '{$data['password']}'";
    }
    //Nếu cập nhật Status
    if($data['status'] != null){
    $sql .= ", status = '{$data['status']}'";
    }
    //Nếu cập nhật tài khoản
     if($data['taikhoan'] != null){
    $sql .= ", taikhoan = '{$data['taikhoan']}'";
    }

    //Điều kiện
    $sql .= " WHERE user_id = $user_id";

    //Query và return
    return mysql_query($sql);
    }

    function delete_user($user_id){
    //SQL
    $sql = "DELETE FROM user WHERE user_id = $user_id";

    //Query và return
    return mysql_query($sql);
    }

    function add_diemdanh($user_id,$trangthai,$user_id_diemdanh,$phep = null){  
        if($trangthai == 0){
            $sql = "INSERT INTO diemdanh(user_id,trangthai,user_id_diemdanh,phep) VALUES ({$user_id},{$trangthai},{$user_id_diemdanh},{$phep})";
        }else{
            $sql = "INSERT INTO diemdanh(user_id,trangthai,user_id_diemdanh) VALUES ({$user_id},{$trangthai},{$user_id_diemdanh})";
        }
        return mysql_query($sql);
    }

    function update_diemdanh($user_id,$trangthai,$date,$phep = 1){
        if($trangthai == 0){
            $sql = "UPDATE diemdanh SET trangthai = {$trangthai},phep = $phep   WHERE user_id = {$user_id} and day(ngaydiemdanh) = {$date['ngay']} and month(ngaydiemdanh) = {$date['thang']} and year(ngaydiemdanh) = {$date['nam']}"; 
        }else{
            $sql = "UPDATE diemdanh SET trangthai = {$trangthai},phep = NULL  WHERE user_id = {$user_id} and day(ngaydiemdanh) = {$date['ngay']} and month(ngaydiemdanh) = {$date['thang']} and year(ngaydiemdanh) = {$date['nam']}";
        }  
        return mysql_query($sql);
    }

    function update_taikhoan_diemdanh($user_id,$type = 'di',$phep = 2){
        if($type == 'nghi'){
            if($phep == 0){
                $sql = "UPDATE user SET taikhoan = taikhoan - 10000 WHERE user_id = {$user_id}";
            }
            if($phep == 1){
                $sql = "UPDATE user SET taikhoan = taikhoan - 5000 WHERE user_id = {$user_id}";
            }
            if($phep == 2){
                $sql = "UPDATE user SET taikhoan = taikhoan - 0 WHERE user_id = {$user_id}";
            }
        }else{
            $sql = "UPDATE user SET taikhoan = taikhoan + 10000 WHERE user_id = {$user_id}";
        }
        return mysql_query($sql);
    }
    
    function get_diemdanh_by_id($user_id,$now){
    $sql = "SELECT * FROM diemdanh WHERE user_id = {$user_id} AND month(ngaydiemdanh) = {$now['mon']} order by ngaydiemdanh";
    return mysql_query($sql);
    }

    function get_diemdanh_today_by_id($user_id,$now){
    $sql = "SELECT * FROM diemdanh WHERE user_id = {$user_id} AND day(ngaydiemdanh) = {$now['mday']}";
    return mysql_query($sql);
    }

    function get_tongbuoidi_by_id($user_id,$now){
    $sql = "SELECT trangthai,ngaydiemdanh FROM diemdanh WHERE trangthai = 1 AND user_id = {$user_id} AND month(ngaydiemdanh) = {$now['mon']}";
    $query = mysql_query($sql);
    return mysql_num_rows($query);
    }

    function get_tongbuoinghi_by_id($user_id,$now){
    $sql = "SELECT trangthai,ngaydiemdanh FROM diemdanh WHERE trangthai = 0 AND user_id = {$user_id} AND month(ngaydiemdanh) = {$now['mon']}";
    $query = mysql_query($sql);
    return mysql_num_rows($query);
    }

    function get_diemdanh_by_day($now){
        $sql = "SELECT * FROM diemdanh WHERE day(ngaydiemdanh) = {$now['mday']} AND month(ngaydiemdanh) = {$now['mon']} AND year(ngaydiemdanh) = {$now['year']}";
        return mysql_query($sql);
    }
?>