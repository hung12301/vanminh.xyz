<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title><?php echo $user['hovaten']; ?></title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>
<body>
<?php if(isset($_SESSION['success'])){echo '<div class="alert alert-success">
  <strong><font size="3">Hoàn thành!</font></strong>.
</div>';} ?>
		<?php unset($_SESSION['success']); ?>
<div class="list-header">
	<h1><?php echo $user['hovaten']; ?></h1>
            <?php 
            if(isset($user_visit)){
                if($user_visit['status']==2 || $user_visit['user_id'] == $user['user_id']){
            ?>
                <a href="<?php echo SITE_URL . '/admin/user/edit.php?user_id=' . $user['user_id']; ?>"><button type="button" class="btn btn-primary">Sửa</button></a>
        <?php 
            }
        }?>
	
</div>
<div class="row">
    <div class="col-md-3">
        <div class="list-header">
        <h1><span>Thông tin cá nhân</span></h1>
        <table class="table table-hover"><br/><br/>
            <tbody>
            <tr ><td><b>Họ tên</b></td><td><?php echo $user['hovaten']?></td></tr>
            <tr ><td><b>Tài khoản</b></td><td><?php echo $user['username']?></td></tr>
            <tr ><td><b>Trạng thái</b></td><td><?php if($user['status']==0){
            echo '<span class="label label-warning">Đang xem xét</span>';}elseif($user['status']==1){
            echo '<span class="label label-success">Thành viên</span>';}elseif($user['status']==2){
            echo '<span class="label label-danger">Quản trị viên</span>';}else{
            echo '<span class="label label-info">Điểm danh viên</span>';}
            ?></td></tr>
            <tr ><td><b>Facebook</b></td><td><?php echo $user['facebook']?></td></tr>
            <tr ><td><b>Tham gia</b></td><td><?php echo date('d/m/Y',strtotime($user['ngaythamgia']))?></td></tr>
            <tr ><td><b>Tiền</b></td><td><?php echo '<b>'.$user['taikhoan'].'</b>'.DONVI;?></td></tr>
            </tbody>
        </table>
        </div>
    </div>
	<div class="col-md-5">
		<div class="list-header">
		<h1><span>Thông tin đánh lô đề</span></h1>
		</div>
			<table class="table table-hover">
			<thead>
			  <tr>
				<th>Thời gian</th>
				<th>Số</th>
				<th>Kiểu</th>
				<th>Trạng thái</th>
			  </tr>
			</thead>
			<tbody>
			<?php while($user = mysql_fetch_assoc($user_lode)): ?>
                            <?php if($user['lohayde']==1){
                                $lohayde = '<span style="background-color: #8e44ad;" class="label label-primary">Đề</span>';
                                    }else{
                                $lohayde = '<span style="background-color: #2c3e50;" class="label label-default">Lô</span>';    
                                    }
                                if(checkThoigian($now, $user['thoigianghi'])){
                                    $trangthai = '<span class="label label-warning">Chưa biết</span>';
                                }else{
                                    if ($user['trung']==1){
                                        if($user['lohayde']==1){
                                            $sotientrung = ($user['sotiendanh'] * 70)/1000;
                                        }else{
                                            $sotientrung = ($user['sodiemdanh'] * 80);
                                        }
                                        $trangthai = '<span class="label label-success">Trúng + '.$sotientrung.'k</span>';   
                                    }else{
                                        $trangthai = '<span class="label label-danger">Tạch</span>';   
                                    }   
                                }
                            ?>
                            <tr>
                            <td><?php echo date('d/m/Y H:i',strtotime($user['thoigianghi'])); ?></td>
                            <td><?php echo '<span class="badge">'.$user['danhcon'].'</span>';?></td>
                            <td><?php echo $lohayde;?></td>
                            <td><?php echo $trangthai;?></td>
                            </tr>
			<?php endwhile; ?>
			</tbody>
		  </table>
		</div>
    <div class="col-md-4">
         <div class="list-header">
        <h1><span>Dữ liệu điểm danh</span></h1>
        </div>
        <table class="table table-hover">
        <thead>
        <tr>
        <th>
        <?php while($user = mysql_fetch_assoc($user_diemdanh)): ?>
        <?php echo date('d',strtotime($user['ngaydiemdanh'])) ?>
        <?php if($user['trangthai']==1){echo '<i style="color:#27ae60;" class="glyphicon glyphicon-ok"></i> - ';}
        else{echo '<i style="color:#c0392b;" class="glyphicon glyphicon-remove"></i> - ';} ?>
        <?php endwhile; ?>
        </th>
        </tr>
        </thead>
        </table>
        <table class="table table-hover">
                <tr class="danger" style="float:right;text-align: right;"><td>Đi:</td><td style="float:right;"><b><?php echo $tongbuoidi; ?></b> buổi</td></tr>
                <tr class="danger" style="float:left;text-align: right;"><td>Nghỉ:</td><td><b><?php echo $tongbuoinghi; ?></b> buổi</td></tr>
        </table>
    </div>
</div>

</body>
</html>