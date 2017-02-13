<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Đăng kí thành viên</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>
<body>
<div class="wrapper">
    <form class="form-signin" name="add" method="POST" action="">       
      <h2 class="form-signin-heading">Đăng kí tài khoản</h2>
	<?php if(isset($thongbao)): ?>
		<div class="alert alert-danger">
		<strong><?php echo $thongbao; ?></strong>
		</div>
	<?php endif; ?>	
		<p>Tên tài khoản (Không viết tiếng việt)<span class="label label-danger">Bắt buộc</span></p>
		<input type="text" class="form-control" name="username" required />
		<p>Mật khẩu<span class="label label-danger">Bắt buộc</span></p>
		<input type="password" class="form-control" name="repeat-password" required />
		<p>Nhập lại Mật khẩu<span class="label label-danger">Bắt buộc</span></p>
		<input type="password" class="form-control" name="password" required />
		<p>Họ và tên<span class="label label-danger">Bắt buộc</span></p>
		<input type="text" class="form-control" name="hovaten" required/>
		<p>Lớp<span class="label label-primary">Không bắt buộc</span></p>
		<input type="text" class="form-control" name="lop" />
		<p>Facebook<span class="label label-danger">Bắt buộc</span></p>
		<input type="text" class="form-control" name="facebook"required/>
		<p>Số điện thoại<span class="label label-danger">Bắt buộc</span></p>
		<input type="text" class="form-control" name="sodienthoai" pattern="^\d+$" title="Chỉ nhập số" required />
		<br/>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Đăng kí</button>
    </form>
  </div>

</body>
</html>