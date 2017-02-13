<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Quản lý thành viên</title>
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
<h1>QL Thành Viên</h1>
<a href="<?php echo SITE_URL . '/admin/user/add.php';?>"><button type="button" class="btn btn-success">+ Add</button></a>
</div>

<table class="table table-hover">
    <thead>
      <tr>
		<th>ID</th>
		<th>Họ và tên</th>
		<th>Số tiền</th>
		<th>Facebook</th>
		<th>Số điện thoại</th>
		<th>Tháng này</th>
		<th>Trạng thái</th>
		<th></th>
      </tr>
    </thead>
    <tbody>
      <?php $i=0;while($user = mysql_fetch_assoc($user_list)): ?>
        <?php
            $tongbuoidi = get_tongbuoidi_by_id($user['user_id'], $now);
            $tongbuoinghi = get_tongbuoinghi_by_id($user['user_id'], $now);
        ?>
        <tr class="<?php if ($i%2==0){echo 'danger';}?>">
        <td><?php echo $user['user_id']; ?></td>
        <td><?php echo '<a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'">'.$user['hovaten'].'</a>'; ?></td>
        <td><?php echo '<b>'.$user['taikhoan'].'</b>'.DONVI;?></td>
        <td><?php echo $user['facebook']; ?></td>
        <td><?php echo $user['sodienthoai']; ?></td>
        <td><?php echo 'Đi: <b>'.$tongbuoidi.'</b> - Nghỉ: <b>'.$tongbuoinghi.'</b>';?></td>
        <td><?php if($user['status']==0){
            echo '<span class="label label-warning">Đang xem xét</span>';}elseif($user['status']==1){
            echo '<span class="label label-success">Thành viên</span>';}elseif($user['status']==2){
            echo '<span class="label label-danger">Quản trị viên</span>';}else{
            echo '<span class="label label-info">Điểm danh viên</span>';}
        ?></td>
        <td><a href="<?php echo SITE_URL . '/admin/user/edit.php?user_id=' . $user['user_id']; ?>"><button type="button" class="btn-xs btn btn-primary">Sửa</button></a></td>
        </tr>
        
        <?php $i++;endwhile; ?>
    </tbody>
 </table>
<table width="100%" cellpadding="10">
<tr>

</tr>

</table>

</body>
</html>