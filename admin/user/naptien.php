<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location:login.php');
}

require_once '../../configs/config.php';
require_once '../../libraries/connect.php';
require_once '../../models/user.php';

if($_SESSION['user']['status']==2){
    
}else{
    die('Bạn không có quyền vào trang này!');
}
    
?>