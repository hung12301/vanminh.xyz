<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Đăng nhập</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>
<body>
  <div class="wrapper">
    <form class="form-signin" name="login" method="POST" action="">       
      <h2 class="form-signin-heading">Đăng nhập</h2>
	 <?php if(isset($_SESSION['success'])):?>
		<div class="alert alert-success">
		<strong>Đăng kí thành công!</strong>
		</div>
	<?php unset($_SESSION['success']); ?>
	<?php endif; ?>
	<?php if(isset($error) && $error == true): ?>
		<p style="color:red;">Sai Tài khoản hoặc Mật khẩu!</p>
	<?php endif; ?>
      <input type="text" class="form-control" name="username" placeholder="Tên tài khoản"/>
      <input type="password" class="form-control" name="password" placeholder="Mật khẩu"/>      
      <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
    </form>
	
  </div>

</body>
</html>