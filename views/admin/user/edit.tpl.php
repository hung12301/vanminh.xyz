<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Sửa thành viên <?php echo $user['hovaten']; ?></title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>
<body>

<div class="wrapper">
    <form class="form-signin" name="edit" method="POST" action="">       
    <h2 class="form-signin-heading"><b>Sửa thành viên</b></br><?php echo $user['hovaten']; ?></h2>
    <?php if(isset($thongbao)){ ?>
    <div class="alert alert-success">
        <strong><center>Sửa thành công</center></strong>
    </div>
    <?php unset($thongbao);} ?>
    <select name="status" class="form-control" id="sel1" <?php if($_SESSION['user']['status'] != 2){echo 'disabled';}?>>
        <option value="0" <?php if($user['status'] == 0){echo 'selected';}?> >Đang xem xét</option>
        <option value="1" <?php if($user['status'] == 1){echo 'selected';}?> >Thành viên</option>
        <option value="3" <?php if($user['status'] == 3){echo 'selected';}?> >Điểm danh viên</option>
        <option value="2" <?php if($user['status'] == 2){echo 'selected';}?> >Quản trị viên</option>
    </select>
    <p>Tên tài khoản</p>
    <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" disabled/>
    <p>Mật khẩu</p>
    <input type="password" class="form-control" name="password" value=""/>
    <p>Họ và tên</p>
    <input type="text" class="form-control" name="hovaten" value="<?php echo $user['hovaten']; ?>"/>
    <p>Lớp</p>
    <input type="text" class="form-control" name="lop" value="<?php echo $user['lop']; ?>"/>
    <p>Facebook</p>
    <input type="text" class="form-control" name="facebook" value="<?php echo $user['facebook']; ?>"/>
    <p>Số điện thoại</p>
    <input type="text" class="form-control" name="sodienthoai" value="<?php echo $user['sodienthoai']; ?>"/>
    <?php if($_SESSION['user']['status'] == 2):?>
    <p>Số tiền</p>
    <input type="text" class="form-control" name="taikhoan" value="<?php echo $user['taikhoan']; ?>"/>
    <?php endif;?>
    <br/>
    <br/>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Hoàn thành</button><br/>
    <?php if($_SESSION['user']['status'] == 2):?>
    <a href="<?php echo SITE_URL . '/admin/user/delete.php?user_id=' . $user['user_id']; ?>"><button type="button" class="btn btn-lg btn-danger btn-block">Xóa</button></a><br/>
    <?php endif;?>
    <a href="<?php echo SITE_URL . '/lode'; ?>"><button type="button" class="btn btn-lg btn-default btn-block">Quay lại</button></a>
    </form>
	
  </div>

</body>
	
</html>