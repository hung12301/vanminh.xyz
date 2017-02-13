<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Ghi đề</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css" type="text/css">
</head>
<body>
<div class="wrapper">
    <form class="form-signin" name="add" method="POST" action="">       
      <h2 class="form-signin-heading">Ghi đề</h2>
	  <?php if(!$thongbao==null){
		  echo '<div class="alert alert-danger">
  <strong>'.$thongbao.'</strong>
</div>';
	  }else if($thongbao==true){
		  echo '<div class="alert alert-success">
		<strong>Ghi đề thành công!</strong>
		</div>';
	  }?>
	  <strong>Chào <?php echo '<b>'.$user['hovaten'].'</b>'; ?></strong><p> Bạn có <?php echo '<b>'.$user['taikhoan'].'</b>'.DONVI; ?></p>
          <p><b>Con số:</b> (Chỉ nhập 2 số) <button style="float:right;" type="submit" name="random" class="btn btn-xs btn-primary">Random</button></p>
          <input type="text" class="form-control" name="conso" value="<?php echo $randomNumber; ?>" <?php if(isset($disable)){echo 'disabled';} ?> />
		<p><b>Số tiền:</b> (1000 ăn 70.000)</p>
		<?php if($user['taikhoan']>=1000){?>
			<select class="form-control" name="sotien">
			<?php For($i=1000;$i<=$user['taikhoan'];$i=$i+1000){
				echo '<option value="'.$i.'">'.$i.''.DONVI.'</option>';
			}
			?>
		<?php }else{ ?>
			<div class="alert alert-danger">
			<strong>Bạn không có tiền !</strong>
			</div>
		<?php }?>
			</select>
		<br/>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Chơi !</button>
		<br/>
		<a href="<?php echo SITE_URL . '/lode/main.php'; ?>"><button type="button" class="btn btn-lg btn-default btn-block">Quay lại</button></a>
    </form>
  </div>

</body>
</html>