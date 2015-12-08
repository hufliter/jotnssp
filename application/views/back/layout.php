<?php
$baseUrl = base_url();
/** @var string $temp */
?>
<?php echo doctype('html5'); ?>
<!-- Code and design by J ngonam22 -->
<html>
<head>
    <title><?= isset($page_title) ? $page_title : 'Admin control panel' ?></title>
    <?php
    echo meta(array(
        array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
        array('name' => 'Content-control', 'content' => 'no-cache', 'type' => 'equiv'),
        array('name' => 'Pragma', 'content' => 'no-cache', 'type' => 'equiv'),
        array('name' => 'Expires', 'content' => '-1', 'type' => 'equiv')
    ));
    ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/flick/jquery-ui.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/datatable/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/animate.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/iCheck/skins/square/green.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/backend/extra.css"/>
    <?php
    if (!empty($css)) {
        foreach ($css as $v){
            echo link_tag(array('href' => base_url() . 'assets/css/' . $v . '.css', 'rel' => 'stylesheet'));
        }
    }
    ?>

    <script type="text/javascript" src="<?= $baseUrl ?>assets/js/jquery-1.9.0.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/libs/datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/libs/jquery.isloading.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/libs/jquery.serializejson.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/libs/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/libs/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>assets/js/admin/JTS.js"></script>
    <script>
        $.noty.defaults.animation = {
            open: 'animated bounceInDown',
            close: 'animated bounceOutDown',
            easing: 'swing',
            speed: 500
        };
    </script>
    <?php
    if (!empty($js))
        foreach ($js as $v)
            echo '<script type="text/javascript" src="' . base_url() . 'assets/js/' . $v . '.js"></script>';
    ?>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body style="overflow: auto">
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button name="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a href="<?php echo base_url() ?>admincp/dashboard" class="brand"><i class="icon-home"></i> Admin panel</a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="divider-vertical"></li>
                    <li class="<?php echo ($this->uri->segment(2) == 'user' && ($this->uri->segment(3) == null || $this->uri->segment(3) == 'index')) ? 'active' : null; ?>">
                        <a href="<?php echo base_url() ?>admincp/user/index">
                            <i class="icon-user"></i> Users
                        </a>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="<?php echo ($this->uri->segment(2) == 'order' && ($this->uri->segment(3) == null || $this->uri->segment(3) == 'index')) ? 'active' : null; ?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Bán hàng <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="<?php echo ($this->uri->segment(2) == 'order' && ($this->uri->segment(3) == null || $this->uri->segment(3) == 'index')) ? 'active' : null; ?>">
                                <a href="<?php echo base_url() ?>admincp/order/index">
                                    <i class="fa fa-shopping-cart"></i> DS Đơn hàng
                                </a>
                            </li>
                            <li class="<?php echo ($this->uri->segment(2) == 'order' && ($this->uri->segment(3) == 'ship_fee')) ? 'active' : null; ?>">
                                <a href="<?php echo base_url() ?>admincp/order/ship-fee">
                                    <i class="fa fa-truck"></i> Phí chuyển hàng
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="divider-vertical"></li>

                    <li class="<?php echo ($this->uri->segment(2) == 'gallery') ? 'active' : null; ?>">
                        <a href="<?php echo base_url() ?>admincp/gallery">
                            <i class="icon-eject"></i> Upload
                        </a>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="<?php echo (in_array($this->uri->segment(2), array('tip', 'news', 'recruitment'))) ? 'active' : null; ?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Bài viết <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo base_url() ?>admincp/tip">
                                    <i class="icon-thumbs-up"></i> Bí kíp
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>admincp/news">
                                    <i class="icon-bullhorn"></i> Thông báo
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>admincp/recruitment">
                                    <i class="icon-briefcase"></i> Tuyển dụng
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="<?php echo (in_array($this->uri->segment(2), array('product', 'category'))) ? 'active' : null; ?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Sản phẩm <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="<?php echo ($this->uri->segment(2) == 'product') ? 'active' : null; ?>">
                                <a href="<?php echo base_url() ?>admincp/product">
                                    <i class="icon-gift"></i> Sản phẩm
                                </a>
                            </li>

                            <li class="<?php echo ($this->uri->segment(2) == 'category') ? 'active' : null; ?>">
                                <a href="<?php echo base_url() ?>admincp/category">
                                    <i class="fa fa-server"></i> Chủng loại
                                </a>
                            </li>
                        </ul>

                    <li class="divider-vertical"></li>
                    <li class="<?php echo ($this->uri->segment(3) == 'advertise') ? 'active' : null; ?>">
                        <a href="<?php echo base_url() ?>admincp/dashboard/advertise">
                            <i class="icon-retweet"></i> Quảng cáo
                        </a>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="<?php echo ($this->uri->segment(3) == 'config') ? 'active' : null; ?>">
                        <a href="<?php echo base_url() ?>admincp/dashboard/config">
                            <i class="icon-wrench"></i> Cấu hình
                        </a>
                    </li>
                </ul>
					<span class="pull-right navbar-text divider">
						<b class="icon-user inline-block"></b> <a
                            href="<?php echo base_url('/admincp/user/edit'); ?>"><?php echo $this->session->userdata('user'); ?></a>
                        <?php echo anchor('/admincp/user/logout', 'Đăng xuất', array('class' => 'btn btn-info btn-mini', 'style' => 'vertical-align:0')); ?>
					</span>
            </div>
        </div>
    </div>
</div>
<div class="container" id="body_content">
    <?php
    showFlash($this);
    echo $temp;
    ?>
</div>
<footer class="footer">
    <div class="container">
        <p>Copyright @ 2015 Jotunshop</p>
    </div>
</footer>
<div class="hidden"><?= form_open('#', ['id' => '_global_form']) . form_close() ?></div>
</body>
</html>