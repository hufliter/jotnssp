<?php
$checkAuth = \Jotun\JotunAuth::instance()->check();
?>
<?php echo doctype('html5'); ?>
<html lang="vi-VN">
<head>
    <title>Jotun shop</title>
    <meta property="og:image"
          content="<?php echo(empty($fb_thumb) ? base_url('/assets/images/front/face_logo.png') : html_escape($fb_thumb)); ?>"/>
    <meta property="og:title"
          content="<?php echo(empty($fb_thumb) ? 'Chuyên phân phối sỉ và lẻ mỹ phẩm dưỡng da' : $fb_title); ?>"/>
    <meta property="og:site_name" content="Jotunshop.vn"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="<?php echo(empty($fb_thumb) ? base_url('/') : base_url($fb_url)); ?>"/>
    <meta property="fb:admins" content="1291888353"/>
    <meta property="fb:app_id" content="464400093677048"/><?php
    echo meta(array(
        array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
        array('name' => 'robots', 'content' => 'index, follow'),
        array('name' => 'Content-Language', 'content' => 'vi', 'type' => 'equiv'),
    ));
    if (empty($description))
        $description = 'phân phối sỉ lẻ mỹ phẩm , mỹ phẩm , jotunshop, jotun shop, mỹ phẩm jotun shop , chăm sóc da , mỹ phẩm trắng da, sữa rửa mặt';
    else
        $description = 'jotunshop, mỹ phẩm jotun shop ,' . $description;

    echo meta(array(
        array('name' => 'keywords', 'content' => $description)
    ));
    echo link_tag(
        array('href' => 'assets/css/bootstrap.min.css', 'rel' => 'stylesheet', 'media' => 'screen')
    );
    echo link_tag(
        array('href' => 'assets/css/absolute_bootstrap.min.css', 'rel' => 'stylesheet', 'media' => 'screen')
    );


    echo link_tag(
        array('href' => 'assets/images/front/face_logo.png', 'rel' => 'image_src', 'type' => "image/png")
    );
    echo link_tag(
        array('href' => 'assets/css/front.css', 'rel' => 'stylesheet', 'media' => 'screen')
    );
    echo link_tag(
        array('href' => 'assets/css/master.css', 'rel' => 'stylesheet', 'media' => 'screen')
    );
    echo "<link href='http://fonts.googleapis.com/css?family=Patrick+Hand&subset=latin,vietnamese' rel='stylesheet' type='text/css'>";
    echo '<link rel="shortcut icon" href="' . base_url('/assets/images/front/favicon.ico') . '" />';
    if (!empty($css))
        foreach ($css as $v)
            echo link_tag(array('href' => base_url() . 'assets/css/' . $v . '.css', 'rel' => 'stylesheet'));
    ?>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/spinner/bootstrap-spinner.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/remodal/jquery.remodal.css"/>
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/datatable/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/backend/extra.css"/>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/libs/jquery.isloading.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/libs/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/libs/jquery-validation/localization/messages_vi.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/libs/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/libs/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/spinner/jquery.spinner.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/remodal/jquery.remodal.min.js"></script>
    <script src="<?= base_url() ?>assets/js/numeral.min.js"></script>

    <?php
    if (!empty($js))
        foreach ($js as $v)
            echo '<script type="text/javascript" src="' . base_url() . 'assets/js/' . $v . '.js"></script>';
    ?>
    <style type="text/css">
        #logo {
            height: 167px;
            margin-top: -40px;
            background-image: url('<?php echo base_url('/assets/images/front/full_logo.png'); ?>');
        }
    </style>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function killCopy(e) {
            return false
        }
        function reEnable() {
            return true
        }
        document.onselectstart = new Function("return false");
        if (window.sidebar) {/*document.onmousedown=killCopy();*/
            document.onclick = reEnable();
        }
        //$(document).bind("contextmenu",function(e){return false;});
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-42069965-1', 'jotunshop.vn');
        ga('send', 'pageview');
        window['_base_url'] = "<?= base_url() ?>";
    </script>
</head>
<body style="position:relative">
<!-- thuat_layout : cart tag  -->
<div class="cart_tag">
    <div class="cart_icon">
        <span class="cart_count_product"><?= \Jotun\Cart\Cart::getInstance()->getTotal() ?></span>
    </div>
    <a href="<?= base_url() ?>dat-hang" class="text_cart"> <span>Giỏ hàng</span></a>
</div>
<!-- thuat_layout : cart tag  -->
<!-- search form -->
<div class="search_tag">
    <!-- <div class="cart_icon">
        <span class="cart_count_product"><?= \Jotun\Cart\Cart::getInstance()->getTotal() ?></span>
    </div>
    <a href="<?= base_url() ?>dat-hang" class="text_cart"> <span>Giỏ hàng</span></a> -->
    <?php
    echo form_open('/product/search/', 'method="get" class="search-tag-box"');
    echo form_input(array(
            'name' => 'q', 'value' => '', 'id' => 'search_input',
            'placeholder' => 'Tên sản phẩm', 'required' => 'required'
        )) . form_submit(array(
            'name' => '', 'value' => '', 'id' => 'search_submit'
        ));
    echo form_close();
    ?>
</div>
<!-- end search form -->
<div class="container fill">
    <div class="row">
        <div class="span12 wall">

            <section class="row" role="banner">
                <div class="span12 show deco">
                    <div class="row" style="padding-bottom:4px">
                        <div class="span3 offset1"><?php
                            echo img(array(
                                'src' => '/assets/images/front/left_deco.png',
                                'style' => 'height:100px;margin-top:20px', 'width' => '195', 'heigh' => '100'
                            ));
                            ?></div><?php
                        echo anchor('/', "<div id='logo' class='span4'> </div>") . "<div class='span3' style='margin-left:40px'>" .
                            img(array(
                                'src' => '/assets/images/front/right_deco.png',
                                'style' => 'height:120px;float:right', 'width' => '220', 'height' => '120'
                            )) . '</div>';
                        ?></div>
                    <div class="row">
                        <div class="span12 separator"></div>
                    </div>
                </div>
            </section>
            <nav class="row show">
                <div class="span2 offset1 text-center" style="width: 150px;">
                    <div class="main_category" style="float: left; width: 190px; position: absolute; left: 60px;">
                        <?php if (!$checkAuth): ?>
                            <span class="login_icon category_icon" style="position: absolute; float: left; left: 0; bottom: 10px;"></span>
                        <?php else: ?>
                            <a href="<?= base_url() ?>opauth/logout"> <span class="logout_icon category_icon"></span>
                        <?php endif; ?>
                         <?php if ($checkAuth) : ?>
                            <a href="<?php echo base_url('product/list_order'); ?>">Xem đơn hàng</a>
                        <?php else : ?>
                            <a  href="<?php echo base_url('opauth/facebook'); ?>">Đăng nhập</a>
                        <?php endif; ?>
                        <?php if (\Jotun\JotunAuth::instance()->hasRole(ROLE_RESELLER)): ?>
                            <a style="font-size: 11px;" href="<?= base_url() ?>product/list_order_ctv">Quản lý đơn hàng</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="span2  text-center">
                    <div class="main_category">
                        <span class="bow_icon category_icon"></span><?php
                        echo anchor('/product/', 'Sản phẩm');
                        ?></div>
                </div>
                <div class="span2 text-center">
                    <div class="main_category">
                        <span class="book_icon category_icon"></span><?php
                        echo anchor('/tip/', 'Bí kíp');
                        ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="span2">
                    <div class="main_category">
                        <span class="sale_icon category_icon" style="margin:0"></span><?php
                        echo anchor('/page/contact', 'Liên hệ', 'style="margin:0 5px 0"')
                        ?></div>
                </div>
                <div class="span2 text-center">
                    <div class="main_category">
                        <span class="contact_icon category_icon"></span><?php
                        echo anchor('/news', 'Thông báo');
                        ?></div>
                </div>
            </nav>
            <section class="row show">
                <div class="span12" style="margin-left:-10px; width:100%;margin-bottom: 20px;">
                    <section id="carousel" class="carousel slide carousel_radius" style="width:95%"><?php
                        if (empty($mainAds)):
                            $mainAds[0] = new stdClass();
                            $mainAds[0]->thumb = base_url('/assets/images/front/default_slide.jpg');
                        endif;
                        ?>
                        <div class="carousel-inner carousel_radius" style="width:98%"><?php
                            foreach ($mainAds as $k => $v):
                                ?>
                                <div class="item carousel_radius <?php echo ($k == 0) ? 'active' : null; ?>"><?php
                                echo anchor($v->link, img(array(
                                    'src' => $v->img,
                                    'style' => 'width:100%',
                                )));
                                ?></div><?php
                            endforeach;
                            ?></div>
                        <div style="clear:both"></div>
                    </section>
                </div>
                <div id="contact_hanger" class="show">
							<span id="contact_link">
							<div id="contact_detail" class="carousel_radius"><a href="/page/contact">
                                    <h5>Liên hệ</h5>
                                    <span class="house_icon contact_detail_icon"></span>

                                    <p><?php
                                        echo html_escape($config->contact);
                                        ?></p>
                                    <span class="contact_large_icon contact_detail_icon"></span>

                                    <p><?php
                                        echo getPhone($config->phone, true);
                                        ?></p>
                                    <span class="clock_icon contact_detail_icon"></span>

                                    <p style="padding-top:10px"><?php
                                        echo html_escape('9h --> 19h');
                                        ?></p>
                                    <span class="car_icon contact_detail_icon" style="clear:left"></span>

                                    <p style="padding-top:10px"><?php
                                        echo 'SHIP Toàn quốc';
                                        ?></p></a>
                            </div>
							</span>
                </div>
            </section>
            <div class="row show" style="margin-top:20px;width:970px;margin-bottom:80px" role="main">
                <aside class="span3" style="margin-left:26px;margin-bottom:80px">
                    <nav id="category" class="show">
                        <ul class="nav nav-list"><?php
                            if (!empty($category)):
                                foreach ($category as $v):
                                    ?>
                                    <li class="nav-header">
                                    <div class="category-align nonSelect"><?php echo html_escape($v['name']); ?></div>
                                    </li><?php
                                    if (!empty($v['child'])):
                                        foreach ($v['child'] as $childV):
                                            ?>
                                            <li><?php echo anchor('/category/show/' . $childV['id'] . '/' . $childV['link'], html_escape($childV['name'])); ?></li><?php
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;
                            ?></ul>
                    </nav>
                    <!-- Removed old search form -->
                    <?php
                    if (!empty($ads_under_search->active) && $config->advertise):
                        $img = array(
                            'src' => $ads_under_search->img,
                            'style' => 'height:100px;width:100%;margin-top:10px'
                        );
                        if (!empty($ads_under_search->link))
                            echo anchor($ads_under_search->link, img($img), 'alt="advertise" target="_blank"');
                        else
                            echo img($img);
                    endif;
                    ?>
                </aside>
                <div class="span9 table-product show"><?php
                    echo $temp;
                    ?></div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row show">
            <div class="span3 show" id="footer_banner"></div>
            <div class="span8" id="footer_label" style="margin-left:80px">
                <div class="phone_block" style="margin-top:8px">
                    <span class="footer_highlight">Địa chỉ:</span> <?php echo html_escape($config->contact); ?>
                    <span class="footer_highlight">Mã Số Thuế:</span> <?php echo $config->tax_code; ?>
                </div>
                <div style="margin-top:-10px;margin-right:125px">
                    <span class="footer_highlight">Điện thoại: </span><?php getPhone($config->phone); ?>
                </div>
                <div class="footer_highlight copyright">Code: <a href="mailto:ngonam22@yahoo.com.vn">Ngonam</a><br/>
                    Design1: <a href="#">Lai Nguyen</a><br/>Design2: <a href="#">Bao Nguyen</a><br/>Edit: Nguyen Trinh
                </div>
            </div>
        </div>
    </div>
</footer><?php
if (!empty($ads_bottom)):
    ?>
    <div class="ads_bottom"><span class="ads_control" title="Tắt quảng cáo">X</span><?php
    $img = array(
        'src' => $ads_bottom->img,
        'alt' => 'Quảng cáo dưới cùng'
    );
    if (!empty($ads_bottom->link))
        echo anchor($ads_bottom->link, img($img), 'target="_blank"');
    else
        echo img($img);
    ?></div><?php
endif;
?>
<div id="scroll"></div>
<script src="<?= base_url() ?>assets/js/jquery-animate-css-rotate-scale.js"></script>
<div class="curtain_only"></div>

<div class="remodal" id="_remodal">
    <h2 class="title">Modal title</h2>
    <div class="body">

    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/admin/JTS.js"></script>
<script src="<?php echo base_url() . 'assets/js/front/jts_cart.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/front/front.js'; ?>"></script>
<script>
    $(function () {

        contact = $('#contact_link');
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100)
                $('#scroll').fadeIn();
            else
                $('#scroll').fadeOut();
        });
        $('#scroll').click(function () {
            $('html,body').animate({
                scrollTop: 0
            }, 600);
            return false;
        });
        $('.carousel').carousel({
            interval: 2000
        });
        var rotation = 8;
        var initrotation = rotation;
        var swingtime = 1603;
        var startatcentre = true;

        if (startatcentre == true)
            initrotation = 0;
        function init() {
            contact.animate({rotate: initrotation}, 0, function () {
                rotation *= -1;
                pendulumswing();
            });
        }

        function pendulumswing() {
            contact.animate({rotate: rotation}, swingtime, "swing", function () {
                rotation *= -1;
                pendulumswing();
            });
        }

        contact.hover(function () {
            $(this).stop();
        }, function () {
            init();
        });
        var ads_close = $.cookie('ads_close');
        if (typeof (ads_close) == 'undefined') {

            $('.ads_control').click(function () {
                $(this).parent().remove();
                $.cookie('ads_close', true, {expire: 1});
                $('#scroll').removeAttr('style');
            });
            $('#scroll').css({
                bottom: 300
            });
        }
        init();
    });
</script>
<div class="hidden"><?= form_open('#', ['id' => '_global_form']) . form_close() ?></div>
<?= $bs_modal ?>
</body>
</html>
