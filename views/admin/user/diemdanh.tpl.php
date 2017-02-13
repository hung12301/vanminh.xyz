<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Điểm danh</title>
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.css" type="text/css">
	
	 <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
	
	<!-- Checkbox JS -->
	<script src="../../js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="../../js/bootstrap-checkbox.js"></script>
	<script type="text/javascript">
	$('document').ready(function() {
            var options = {offLabel:'Nghỉ',onLabel:'Có đi'};
            $(':checkbox').checkboxpicker(options);
            
            $('#themghichu').on('click', function(){
                
            });
	});
	</script>
        
</head>
<body>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-5">
	<br/>
            <div class="alert alert-info">
              <strong>Đi +10k | Nghỉ (Không phép) -10k | Nghỉ (không phép buổi chính) -5k</strong><br/><br/>
              <?php foreach($ghichu as $value){echo '<strong> '.$value . '</strong><br/>';}?>
            </div>
        <form method="POST" action="" class="form-group">
            <textarea name="textghichu" class="form-control" cols="3" placeholder="Nhập ghi chú mới ..."></textarea><br/>
            <button type="submit" class="btn btn-xl btn-primary" id="themghichu" name="themghichu">Thêm ghi chú + </button> 
        </form>
	</div>
	<div class="col-md-6">
        <?php if(isset($_SESSION['success'])){echo '<div class="alert alert-success">
        <strong>Hoàn thành!</strong>.
        </div>';} ?>
        <?php unset($_SESSION['success']); ?>
	<?php if(isset($thongbao)):?>
		<div class="alert alert-danger">
		<strong><?php echo $thongbao;?></strong>
		</div>
	<?php endif; ?>
	<table class="table table-hover">
    <thead>
      <tr>
        <th>TK</th>
        <th>Họ và tên</th>
        <th>
        <form style="margin:0px;" action="" method="POST" name="diemdanh" id="diemdanh">
        
        <?php if(!isset($thongbao)){ ?>
        <input type="submit" class="btn btn-xs btn-primary" name="submit" value="Điểm danh"/>
        <?php }?>
        <?php if(isset($quyenadmin) && isset($thongbao)) : ?>
        <input type="submit" class="btn btn-xs btn-primary" name="update" value="Update"/>
        <?php endif;?>
        </th>
        <th>Xin phép</th>
      </tr>
    </thead>
    <tbody>
	<?php $i = 0;$data = array();?>
      <?php while($user = mysql_fetch_assoc($user_list)): ?>
	  <?php 
            $user_diemdanh = mysql_fetch_assoc(get_diemdanh_today_by_id($user['user_id'],$now));
                if(!empty($_POST)){
                    $data['user_id'][] = $_POST['user_id'.$user['user_id'].''];
                    $data['trangthai'][] = isset($_POST['trangthai'.$user['user_id'].'']) ? 1 : 0;
                    $data['user_id_diemdanh'][] = $_SESSION['user']['user_id'];
                    $data['phep'][] = !empty($_POST['phep'.$user['user_id'].'']) ? $_POST['phep'.$user['user_id'].''] : 0;
                }
	  ?>
            <tr class="<?php if ($i%2==0){echo 'danger';}?>">
            <td><input style="display:none;" type="text" name="user_id<?php echo $user['user_id']; ?>" value="<?php echo $user['user_id']; ?>"/><?php echo $user['username']; ?></td>
            <td><?php echo '<a href="'.SITE_URL.'/admin/user/user.php?user_id='.$user['user_id'].'">'.$user['hovaten'].'</a>'; ?></td>
            <td>
            <input type="checkbox" name="trangthai<?php echo $user['user_id']; ?>" data-style="btn-group-xs" 
            <?php if($user_diemdanh['trangthai']==1){echo 'checked=checked';} ?>/>
            </td>
            <?php if($user_diemdanh['trangthai']!=1){ ?>
            <td>
                <select name="phep<?php echo $user['user_id'];?>">
                    <option value="0">Không</option>
                    <option value="1"<?php if($user_diemdanh['phep']==1){echo 'selected=selected';}?>>Chính</option>
                    <option value="2"<?php if($user_diemdanh['phep']==2){echo 'selected=selected';}?>>Phụ</option>
                </select>
            </td>
            <?php } ?>
            </tr>
            <?php $i++; ?>
    <?php endwhile; ?>
    <?php if(isset($_POST['submit'])){
        foreach($data['user_id'] as $key => $value){
            if(add_diemdanh($value,$data['trangthai'][$key],$data['user_id_diemdanh'][$key],$data['phep'][$key])){
                // Update tài khoản
                if($data['trangthai'][$key] == 1){
                update_taikhoan_diemdanh($value);
                }else{
                update_taikhoan_diemdanh($value,$type = 'nghi',$data['phep'][$key]);
                }
                $_SESSION['success'] = true;
            }else{
                die('Lỗi điểm danh cho ID '.$value);
            }
        }
        header('location:diemdanh.php');
    }
    if(isset($_POST['update'])){
        foreach($data['user_id'] as $key => $value){
            $user_id = $value;
            $trangthai = $data['trangthai'][$key];
            $phep = $data['phep'][$key];
            if(update_diemdanh($user_id, $trangthai,$date,$phep)){
                $_SESSION['success'] = true;
            }else{
                die('Lỗi điểm danh cho ID '.$value);
            }
        }
        header('location:diemdanh.php');
    }
    ;?>
	</form>	
		
    </tbody>
  </table>
 
	</div>
</div>

</body>
</html>