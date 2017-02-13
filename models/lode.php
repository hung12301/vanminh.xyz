<?php
        function ramdomNumber($length = 2){
            $array = range(0,9); // Cho vao mang cac ki tu tu 0 - 9
            $number = implode($array,''); // chuyen mang thanh chuoi
            $number = str_shuffle($number); //Dao lon cac ki tu trong chuoi
            return $result = substr($number,0,$length);
        }
        
        function add_ketqua($dacbiet,$data){
	$sql = "INSERT INTO ketqua(dacbiet,giainhat,giainhi1,giainhi2,giaiba1,giaiba2,giaiba3,giaiba4,giaiba5,giaiba6,giaitu1,giaitu2,giaitu3,giaitu4,giainam1,giainam2,giainam3,giainam4,giainam5,giainam6,giaisau1,giaisau2,giaisau3,giaibay1,giaibay2,giaibay3,giaibay4)
	VALUES ('{$dacbiet}','{$data[0]}','{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}','{$data[7]}','{$data[8]}','{$data[9]}','{$data[10]}','{$data[11]}','{$data[12]}','{$data[13]}','{$data[14]}','{$data[15]}','{$data[16]}','{$data[17]}','{$data[18]}','{$data[19]}','{$data[20]}','{$data[21]}','{$data[22]}','{$data[23]}','{$data[24]}','{$data[25]}')";
	return mysql_query($sql);
	}
        
        function get_list_ketqua_today($date){
            $sql = "SELECT * FROM ketqua WHERE day(ngaythang) = {$date['ngay']} and month(ngaythang) = {$date['thang']} and year(ngaythang) = {$date['nam']}";
            return mysql_query($sql);
        }
        
        function get_list_lode_today($date,$orderby = 'thoigianghi'){
            $sql = "SELECT * FROM lode WHERE day(thoigianghi) = {$date['ngay']} and month(thoigianghi) = {$date['thang']} and year(thoigianghi) = {$date['nam']} order by {$orderby} DESC";
            return mysql_query($sql);  
        }
        
        function get_list_trung_today($date){
            $sql = "SELECT * FROM lode WHERE trung = 1 and day(thoigianghi) = {$date['ngay']} and month(thoigianghi) = {$date['thang']} and year(thoigianghi) = {$date['nam']}";
            return mysql_query($sql);
        }
        
        function get_user_by_userid($user_id){
	$sql = "SELECT * FROM user WHERE user_id = $user_id";
	$query = mysql_query($sql);
	return mysql_fetch_assoc($query);
	}
        
        function get_lode_by_userid($user_id,$order = 'thoigianghi'){
	$sql = "SELECT * FROM lode WHERE user_id = $user_id order by $order DESC";
	return mysql_query($sql);
	}
        
        
        function update_taikhoan_trung($user_id,$sotientrung){
            $sql = "UPDATE user SET taikhoan = taikhoan + {$sotientrung} WHERE user_id = {$user_id}";
            return mysql_query($sql);
        }
        function update_trangthai_trung($play_id){
            $sql = "UPDATE lode SET trung = 1 WHERE play_id = {$play_id}";
            return mysql_query($sql);
        }
        
        function ghide($data){
            $sql = "INSERT INTO lode(user_id,lohayde,danhcon,sotiendanh) VALUES ({$data['user_id']},1,'{$data['danhcon']}',{$data['sotiendanh']})";
            return mysql_query($sql);
        }
        
        function danhlo($data){
            $sql = "INSERT INTO lode(user_id,lohayde,danhcon,sodiemdanh) VALUES ({$data['user_id']},0,'{$data['danhcon']}',{$data['sodiemdanh']})";
            return mysql_query($sql);
        }
        
        function update_taikhoan_lode($data){
            $sql = "UPDATE user SET taikhoan = taikhoan - {$data['sotiendanh']} WHERE user_id = {$data['user_id']}";
            return mysql_query($sql);
        }
?>