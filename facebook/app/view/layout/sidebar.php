 <!-- Left Sidebar -->
        <div class="navbar-header" style="padding: 20px 30px;">
            <a href="javascript:void(0);" class="bars"></a>
        </div>
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?= SITE_URL . '/public/images/avatar/' . $_SESSION['user']['avatar'] ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['user']['name'] ?></div>
                    <div class="email"><?= $_SESSION['user']['email'] ?></div>
                </div>
                <a href="<?= SITE_URL ?>/thanh-vien/dang-xuat" style="position: absolute;right: 10px;top: 19px;color: #fff;">
                    <i class="material-icons" style="font-size: 11px;margin-right: 5px;">input</i> Thoát
                </a>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="active">
                        <a href="<?= SITE_URL ?>">
                            <i class="material-icons">home</i>
                            <span>TRANG CHỦ</span>
                        </a>
                    </li>
                    <li style="display: none;">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_circle</i>
                            <span>TÀI KHOẢN</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="../../pages/ui/animations.html" class=" waves-effect waves-block">Tất cả tài khoản</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/animations.html" class=" waves-effect waves-block">Tạo tài khoản tự động</a>
                            </li>
                            <li>
                                <a href="../../pages/ui/animations.html" class=" waves-effect waves-block">Thêm tài khoản có sẵn</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">public</i>
                            <span>NHÓM</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-dang-nhom" class=" waves-effect waves-block">Tự động đăng lên nhóm</a>
                            </li>
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-tham-gia-nhom" class=" waves-effect waves-block">Tự động tham gia nhóm</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>BẠN BÈ</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-ket-ban" class=" waves-effect waves-block">Tự động kết bạn</a>
                            </li>
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-chap-nhan-ket-ban" class=" waves-effect waves-block">Tự động chấp nhận kết bạn</a>
                            </li>
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-huy-ket-ban" class=" waves-effect waves-block">Tự động hủy kết bạn</a>
                            </li>
                            <li>
                                <a href="<?= SITE_URL ?>/tu-dong-chap-nhan-ket-ban" class=" waves-effect waves-block">Tự động đăng lên tường bạn bè</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/lich-su">
                            <i class="material-icons">message</i>
                            <span>GỬI TIN NHẮN</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/up-top-bai-viet">
                            <i class="material-icons">trending_up</i>
                            <span>UP TOP BÀI VIẾT</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/tac-vu">
                            <i class="material-icons">list</i>
                            <span>TÁC VỤ</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= SITE_URL ?>/lich-su">
                            <i class="material-icons">attach_money</i>
                            <span>GIA HẠN TÀI KHOẢN</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <!-- <div class="legal">
                <div class="copyright">
                    &copy; 2016 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.4
                </div>
            </div> -->
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->