<?php
// Khởi động session
session_start();

//Require các file cần thiết
require 'configs/config.php';
require 'libraries/connect.php';
require 'models/lode.php';
require 'models/user.php';

if(isset($_SESSION['user'])){
    $userhientai = get_user_by_id($_SESSION['user']['user_id']);	
}

?>
<meta charset="utf-8">
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/bootstrap.min.css" type="text/css">
 <!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css" type="text/css">
<!-- Boostrap JS-->
<script type="text/javascript" charset="utf-8" src="<?php echo SITE_URL; ?>/js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo SITE_URL; ?>/js/bootstrap.js"></script>

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php if(isset($_SESSION['user'])){ ?>
            <a class="navbar-brand" href="<?php echo SITE_URL.'/admin/user/user.php?user_id='.$userhientai['user_id']; ?>"><?php echo $userhientai['hovatearia-haspopup="true" aria-expanded="false" href="<?php echo SITE_URL.'/lode' ?>"><i class="glyphicon glyphicon-usd"></i> LÔ ĐỀ <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php echo SITE_URL.'/lode/main.php' ?>"><i class="glyphicon glyphicon-star"></i> <b>Top đại gia</b></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo SITE_URL.'/lode/ghide.php' ?>"><i class="glyphicon glyphicon-plus"></i> Ghi đề</a></li>
                        <li><a href="<?php echo SITE_URL.'/lode/danhlo.php' ?>"><i class="glyphicon glyphicon-plus"></i> Đánh lô</a></li>
                    </ul>
                </li>
                <?php if(isset($_SESSION['user'])){?>
                <?php if($userhientai['status'] == 2 || $userhientai['status'] == 3){?>
                <li <?php if(getCurrentPageURL() == SITE_URL.'/admin/user/diemdanh.php'){echo 'class="onpage"';} ?>>
                    <a href="<?php echo SITE_URL.'/admin/user/diemdanh.php'; ?>"><i class="glyphicon glyphicon-th-list"></i> ĐIỂM DANH</a>
                </li>
                <?php }?>
                <?php if($userhientai['status'] == 2){?>
                <li <?php if(getCurrentPageURL() == SITE_URL.'/admin/user/list.php'){echo 'class="onpage"';} ?>>
                    <a href="<?php echo SITE_URL.'/admin/user/list.php'; ?>"><i class="glyphicon glyphicon-user"></i> QUẢN LÍ THÀNH VIÊN</a>
                </li>
                <?php } ?>
                <li >
                    <a href="<?php echo SITE_URL.'/admin/user/logout.php'; ?>"><i class="glyphicon glyphicon-off"></i> ĐĂNG XUẤT</a>
                </li>
                <?php }?>
            </ul>
            
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
    
</nav>
