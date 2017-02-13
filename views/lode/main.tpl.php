<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Quản lý kết quả xổ số</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css" type="text/css">
        
</head>
<body>
<?php if(isset($_SESSION['success'])):?>
<div class="alert alert-success">
  <strong>Hoàn thành</strong>
</div>
<?php unset($_SESSION['success']);?>
<?php endif; ?>
<div class="row">
	<div class="col-md-4">
	<div class="list-header">
	<h1><span>Top đại gia</span></h1>
	</div>
		<table class="table table-hover">
			<thead>
			  <tr>
				<th>STT</th>
				<th>Tên thành viên</th>
				<th>Số tiền</th>
			  </tr>
			</thead>
			<tbody>
			  <?php $i=1;while($user = mysql_fetch_assoc($user_list) and $i<=10): ?>
					<tr <?php if(isset($_SESSION['user'])){if($user['user_id']==$_SESSION['user']['user_id']){echo 'class="danger"';}} ?>>
					<td><?php if($i==1){echo '<img src="'.SITE_URL.'/img/top1.gif"/>';}elseif($i==2){echo '<img src="'.SITE_URL.'/img/top2.gif"/>';}elseif($i==3){echo '<img src="'.SITE_URL.'/img/top3.gif"/>';}else{echo $i;} ?></td>
					<td><?php echo '<a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'" >'.$user['hovaten'].'</a>'; ?></td>
					<td><?php echo '<b>'.$user['taikhoan'].'</b>'.DONVI; ?></td>
					</tr>
				<?php $i++;endwhile; ?>
			</tbody>
		  </table>
	  </div>
	  <div class="col-md-5">
		<div class="list-header">
		<h1><span>Ai ghi lô đề hôm nay?</span></h1>
		</div>
		<table class="table table-hover">
			<thead>
			  <tr>
				<th>Tên</th>
				<th>Số</th>
				<th>Lô hay Đề</th>
				<th>Giờ ghi</th>
			  </tr>
			</thead>
			<tbody>
			  <?php while($user = mysql_fetch_assoc($list_lode_today)): ?>
                                <?php   $user_info = get_user_by_userid($user['user_id']);
                                        $user_name = $user_info['hovaten'];
                                        if($user['lohayde']==1){
                                            $xhtml = '<span style="background-color: #8e44ad;display: block;"; class="label label-primary">Ghi Đề '.$user['sotiendanh']/1000 .'đ ('.$user['sotiendanh']/1000 .'k)</span>';
                                        }else{
                                            $xhtml = '<span style="background-color: #2c3e50;display: block;" class="label label-default">Ghi Lô '.$user['sodiemdanh'].'đ ('.$user['sodiemdanh']*23 .'k) </span>';
                                        }
                                ?>
				<td><?php echo '<a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'">'.$user_name.'</a>'; ?></td>
				<td><?php echo '<span class="badge">'.$user['danhcon'].'</span>';?></td>
				<td><?php echo $xhtml;?></td>
				<td><?php echo date('H:i',strtotime($user['thoigianghi'])); ?></td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		  </table>
             
	  </div>
	  <div class="col-md-3">
	  <div class="list-header">
		<h1><span>Trúng thưởng hôm nay</span></h1>
		</div>
		<?php if(mysql_num_rows($list_trung_today)>0 || mysql_num_rows($list_trung_today)>0):?>
		<table class="table table-hover">
			<thead>
			  <tr>
				<th>Người ghi</th>
				<th>Số tiền trúng</th>
			  </tr>
			</thead>
			<tbody>
			  <?php while($user = mysql_fetch_assoc($list_trung_today)): ?>
                            <?php       
                            $user_info = get_user_by_userid($user['user_id']);
                            $user_name = $user_info['hovaten'];
                            if($user['lohayde']==1){
                                $sotientrung = '<span style="display: block;" class="label label-danger">Trúng đề '.$user['danhcon'].' + '.($user['sotiendanh']*70)/1000 .'k</span>';
                            }else{
                                $sotientrung = '<span style="display: block;" class="label label-success">Trúng lô '.$user['danhcon'].' + '.$user['sodiemdanh']*80 .'k</span>';
                            }
                            ?>
				<tr>
				<td><?php echo '<a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'">'.$user_name.'</a>'; ?></td>
				<td><?php echo $sotientrung; ?></td>
				</tr>
				<?php endwhile; ?>
                        </tbody>
		  </table>
		<?php endif;?>
                    <?php if(mysql_num_rows($list_trung_today)==0 and $now['hours']>=19){?>
                    <br/><b><center><font size="3" color="#c83d2f" > Chán thế ! Hôm nay đéo ai trúng à :( </font></center></b><br/>
                    <?php }elseif(!mysql_num_rows($list_trung_today)>0 ){ ?>
                    <br/><b><center><font size="3" color="#c83d2f" > Chưa có kết quả xổ số ngày hôm nay </font></center></b><br/>
                    <?php } ?>
            <div class="list-header">
            <h1><span>Kết quả xổ số</span></h1>
        </div>
            <?php if($now['hours'] >= 18){ ?>
            <table class="table table-hover" style="text-align: center;">
            <tbody>
                <tr class="danger"><td style="text-align: left;"><b>ĐB</b></td><td><b><?php echo $list_ketqua_today[2];?></b></td></tr>
            <tr><td style="text-align: left;"><b>Nhất</b></td><td><?php echo $list_ketqua_today[3];?></td></tr>
            <tr><td td style="text-align: left;"><b>Nhì</b></td><td><?php echo getGiai($list_ketqua_today,4,5);?></td></tr>
            <tr><td td style="text-align: left;"><b>Ba</b></td><td><?php echo getGiai($list_ketqua_today,6,11);?></td></tr>
            <tr><td td style="text-align: left;"><b>Tư</b></td><td><?php echo getGiai($list_ketqua_today,12,15);?></td></tr
            <tr><td td style="text-align: left;"><b>Năm</b></td><td><?php echo getGiai($list_ketqua_today,16,21);?></td></tr>
            <tr><td td style="text-align: left;"><b>Sáu</b></td><td><?php echo getGiai($list_ketqua_today,22,24);?></td></tr>
            <tr><td td style="text-align: left;"><b>Bảy</b></td><td><?php echo getGiai($list_ketqua_today,25,28);?></td></tr>
            </tbody>
            </table>
            <?php }else{
                echo '<br/><b><center><font size="3" color="#c83d2f"> Chưa có kết quả xổ số ngày hôm nay </font></center></b>';
            } ?>
        </div>


</body>
</html>