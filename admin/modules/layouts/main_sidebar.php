<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo ROOTHOST_ADMIN;?>" class="brand-link navbar-primary">
        <img src="<?php echo ROOTHOST_ADMIN;?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo ROOTHOST_ADMIN;?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['firstname'] ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebar-menu" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>frontpage" class="nav-link" data-com="frontpage">
                        <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i> <p>Bảng điều khiển</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" data-com="booking">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Booking tour
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>booking/add" class="nav-link" data-link="booking/add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đặt tour</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>booking" class="nav-link" data-link="booking/list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ds đặt tour</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" data-com="tour">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Quản lý tour
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>tour/add" class="nav-link" data-link="tour/add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm tour</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>tour" class="nav-link" data-link="tour/list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ds tour</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>place" class="nav-link" data-link="place/list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ds điểm đến</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" data-com="contents">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p>
                            Tin tức
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>contents/add" class="nav-link" data-link="contents/add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm bài viết</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>contents" class="nav-link" data-link="contents/list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ds bài viết</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOTHOST_ADMIN;?>category" class="nav-link" data-link="category/list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ds chuyên mục</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>seo" class="nav-link" data-com="seo">
                        <i class="nav-icon fa fa-copy" aria-hidden="true"></i> <p>Meta SEO</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>slider" class="nav-link" data-com="slider">
                        <i class="nav-icon fas fa-sliders-h"></i><p>Slide banner</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>feedback" class="nav-link" data-com="feedback">
                        <i class="nav-icon fas fa-comment-dots"></i> <p>Cảm nhận KH</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>partner" class="nav-link" data-com="partner">
                        <i class="nav-icon far fa-handshake"></i> <p>Đối tác</p>
                    </a>
                </li>

                <li class="nav-header">User</li>
                <li class="nav-item">
                    <a href="<?php echo ROOTHOST_ADMIN;?>logout" class="nav-link">
                        <i class="nav-icon fa fa-power-off"></i>
                        <p>Đăng xuất</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>