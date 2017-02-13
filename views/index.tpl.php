<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="google-site-verification" content="GHtlNcnA5qpfS2rXG54rs17sFsG4GBbY-DAJWS6g5nY" />
    <title>Taekwondo Kinh Kông Đường</title>
    
    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/creative.css" type="text/css">
    
    <!-- Search JS-->
    <script type="text/javascript" charset="utf-8" src="../js/search.js"></script>
    
</head>

<body>

<!-- Header -->    
<section id="header">
    <header>
        <div class="header-content" id="header">
            <div class="header-content-inner">
                <?php if(isset($thongbao)):?>
                <div class="alert alert-success" id="contact-success">
                    <span class="glyphicon glyphicon-ok "></span>
                    <font size="4"><?php echo $thongbao?></font>
                </div>
                <?php endif; ?>
                <h5>TAEKWONDO KINH KÔNG HUBT</h5>
                <hr>
                <p>Câu lạc bộ Taekwondo trường Đại học Kinh doanh và Công nghệ đang tuyển thành viên. Những người trong trường và ngoài trường đều có thể tham gia</p>
                <?php if(!isset($_SESSION['user'])): ?>
                <a><button class="btn btn-dangnhap" data-toggle="modal" data-target=".bs-example-modal-sm-dangnhap">Đăng nhập<i class="glyphicon glyphicon-user"></i></button></a>
                <!-- JavaScript Đăng nhâp -->

                <div class="modal fade bs-example-modal-sm-dangnhap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm-dangnhap">
                    <div class="modal-content">
                    <form name="login" method="POST" action="admin/user/login.php">       
                      <input type="text" class="form-control" name="username" placeholder="Tên tài khoản"/>
                      <br/>
                      <input type="password" class="form-control" name="password" placeholder="Mật khẩu"/> 
                      <br/>
                      <button type="submit" class="btn btn-dangnhap">Đăng nhập</button>
                    </form>
                    </div>
                </div>
                </div>
                <?php endif;?>
                <?php if(isset($_SESSION['user'])): ?>
                <a href="<?php echo ''.SITE_URL.'/lode' ?>">
                <button class="btn btn-dangnhap" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="glyphicon glyphicon glyphicon-user"></i>
                <?php echo $userhientai['hovaten']; ?>
                - Bạn có: <?php echo $userhientai['taikhoan'].DONVI;?></button></a>
                <?php endif;?>
                <a href="<?php echo ''.SITE_URL.'/lode' ?>"><button class="btn btn-lode" data-toggle="modal" data-target=".bs-example-modal-sm">Lô đề <i class="glyphicon glyphicon-menu-right"></i></button></a>		
            </div>
        </div>
    </header>
</section>
<!-- Header -->

<!-- Danh sach thanh vien -->
<section id="home">
<div class="container">
    <h1>DANH SÁCH THÀNH VIÊN</h1>
    <hr/>
    <div id="search">
        <input type="text" class="input" id="inputSearch" placeholder="Tìm kiếm"/>
        <button type="submit" id="search-btn">Submit!</button>
    </div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>TK</th>
        <th>Họ và tên</th>
        <th>Số tiền</th>
        <th>Tháng này</th>
    </tr>
    </thead>
    <tbody id="showElement" style="text-align: left;font-size: 1em;">
      <?php echo $xhtmlDSTV;?>
    </tbody>
</table>
</div>
</section>
<!-- Danh sach thanh vien -->
    
<!-- Album anh -->
<!--<section id="album">
	
  <img alt="Preview Image 1"
    src="images/thumbs/thumb1.jpg"
    data-image="images/big/image1.jpg"
    data-description="Preview Image 1 Description">

  <img alt="Youtube Video"
    data-type="youtube"
    data-videoid="A3PDXmYoF5U"
    data-description="You can include youtube videos easily!">
  
  <img alt="Html5 Video"
    src="images/thumbs/html5_video.png"
    data-type="html5video"
    data-image="http://video-js.zencoder.com/oceans-clip.png"
    data-videomov="gallery/video/IMG_0256.MOV"
	    	 data-description="This is html5 video demo played by mediaelement2 player">

</section>-->
<!-- Album anh -->
    
<!-- Đang ki tham gia CLB -->
<section id="dangki">
    <div class="container">
        <div class="container">	
            <h2>ĐĂNG KÝ THAM GIA CÂU LẠC BỘ</h2>
            <p>Chú ý: Chỉ dành cho những ai chưa vào CLB. Ai đã có tên trong danh sách không được đăng ký !</p>
            <?php if(!isset($_SESSION['data'])){ ?>
            <div class="row">
                <form action="" method="POST"  class="form ajax-contact-form">
                <div class="col-sm-3">
                    <input type="text" name="hovaten" id="hovaten" required="" class="form-control" placeholder="Họ và tên" aria-required="true">   
                </div>
                <div class="col-sm-2">
                    <input type="text" name="lop" id="lop" required="" class="form-control" placeholder="Lớp" aria-required="true">   
                </div>
                <div class="col-sm-3">
                    <input type="text" name="facebook" id="facebook" required="" class="form-control" placeholder="Facebook" aria-required="true">   
                </div>
                <div class="col-sm-2">
                    <input type="text" name="sodienthoai" id="sodienthoai" required="" class="form-control" placeholder="Số điện thoại" aria-required="true">   
                </div>
                <div class="col-sm-2">   
                    <button type="submit" name="dangki" id="dangki" class="btn btn-dangki">Đăng ký <i class="glyphicon glyphicon-menu-right"></i></button>
                </div>                       
                </form>
            </div>
            <?php }else{?>
            <div class="alert alert-success" id="contact-success">
                <span class="glyphicon glyphicon-ok "></span>
                <strong>Bạn đã đăng ký vào CLB. Đến sảnh A vào lúc 18h gặp chủ nhiệm CLB để được hướng dẫn</strong>
            </div>
            <?php }?>
        </div>
    </div>
</section>
<!-- Đang ki tham gia CLB -->
    
<!-- Footer -->
<section style="" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2>LIÊN HỆ</h2>
                <p>Nếu bạn có thắc mắc gì về giờ tập, lệ phí hay cách đăng kí thì liên hệ với Anh Sáng</p>
                <div class="text-center">
                    <p><i class="glyphicon glyphicon-earphone"></i>  0167 436 3343</p>
                </div>
                <div class="text-center">
                    <p><a href="https://www.facebook.com/iam.sang"><i class="glyphicon glyphicon-info-sign"></i>  Facebook: Nguyễn Hữu Sáng </a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer -->

<!-- Facebook Ads -->
<script type='text/javascript'>
window.onload=function(){
      window.fbAsyncInit = function() {
        FB.Event.subscribe(
          'ad.loaded',
          function(placementID) {
            console.log('ad loaded');
          }
        );

        FB.Event.subscribe(
          'ad.error',
          function(errorCode, errorMessage, placementID) {
            console.log('ad error ' + errorCode + ': ' + errorMessage);
          }
        );
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk/xfbml.ad.js#xfbml=1&version=v2.5&appId=1059078247500944";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
}
</script>

</body>
</html>