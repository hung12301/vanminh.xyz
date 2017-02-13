<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Thêm thành viên</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
    <!-- Checkbox JS -->
	<script src="../../js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="../../js/bootstrap-checkbox.js"></script>
	<script type="text/javascript">
	$('document').ready(function() {
            var options = {offLabel:'Thành viên',onLabel:'Điểm danh viên'};
            $(':checkbox').checkboxpicker(options);
	});
	</script>
</head>
<body>
<div class="wrapper">
    <form class="form-signin" name="add" method="POST" action="">       
      <h2 class="form-signin-heading">Thêm thành viên</h2>
        <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
        <strong>Thêm mới thành công</strong>
        </div>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if(isset($thongbao)): ?>
        <div class="alert alert-danger">
        <strong><?php echo $thongbao;?></strong>
        </div>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <input type="checkbox" name="status" data-style="btn-group-justified" data-off-class="btn-success" data-on-class="btn-primary"/>
        <p>Tên tài khoản</p>
        <input type="text" class="form-control" name="username" placeholder="Có thể bỏ trống"/>
        <p>Mật khẩu</p>
        <input type="password" class="form-control" name="password" placeholder="Có thể bỏ trống"/>
        <p>Họ và tên</p>
        <input type="text" class="form-control" name="hovaten"/>
        <p>Lớp</p>
        <input type="text" class="form-control" name="lop"/>
        <p>Facebook</p>
        <input type="text" class="form-control" name="facebook"/>
        <p>Số điện thoại</p>
        <input type="text" class="form-control" name="sodienthoai"/><br/><br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Thêm thành viên</button><br/>
        <a href="<?php echo SITE_URL.'/admin/user/list.php';?>"><button type="button" class="btn btn-lg btn-default btn-block" name="return">Quay lại</button></a>
    </form>
  </div>

</body>
</html>