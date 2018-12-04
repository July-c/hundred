<?php /*a:2:{s:48:"E:\WWW\free\application\user\view\tpl\links.html";i:1542613108;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?php echo htmlentities($setting['store']['values']['name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/assets/user/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlentities($setting['store']['values']['name']); ?>"/>
    <link rel="stylesheet" href="/assets/layer/theme/default/layer.css"/>
    <link rel="stylesheet" href="/assets/user/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_oo2lzo85b4.css">
    <script src="/assets/user/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        BASE_URL = '<?php echo htmlentities($base_url); ?>';
        STORE_URL = '/index.php?s=/user';
		
    </script>
</head>

<body data-type="">
<div class="layer-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="layer-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="layer-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
         
			
            <!-- 其它功能-->
            <div class="layer-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="layer-text-sm tpl-header-navbar-welcome">
                        <a href="<?php echo url("","",true,false);?>">欢迎你，<span><?php echo htmlentities($store['user']['user_name']); ?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="layer-text-sm">
                        <a href="<?php echo url('user/login/logout'); ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <!-- 一级菜单 <?php echo htmlentities($setting['store']['values']['name']); ?>-->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><img src="/assets/user/img/logo.png" width="60" /></li>
           
		  <?php foreach($menus as $key=>$item): ?> 
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                       class="<?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                        
                            <i class="iconfont sidebar-nav-link-logo <?php echo htmlentities($item['icon']); ?>"></i>
                     
                        <?php echo htmlentities($item['name']); ?>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
        <!-- 子级菜单-->
       <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if(!empty($second)): ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?php echo htmlentities($menus[$group]['name']); ?></li>
                <li class="sidebar-second-item">
                   
					<?php if(is_array($second) || $second instanceof \think\Collection || $second instanceof \think\Paginator): $i = 0; $__LIST__ = $second;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;if(!isset($item['submenu'])): ?>
                            <!-- 二级菜单-->
                            <a href="<?php echo url($item['index']); ?>" class="<?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                                <?php echo htmlentities($item['name']); ?>
                            </a>
                        <?php else: ?>
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                                <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?php echo htmlentities($item['name']); ?>
                                </a>
                                <ul class="sidebar-third-nav-sub">
									<?php if(is_array($item['submenu']) || $item['submenu'] instanceof \think\Collection || $item['submenu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $item['submenu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$third): $mod = ($i % 2 );++$i;?>
                                        <li>
                                            <a class="<?php echo !empty($third['active']) ? 'active'  :  ''; ?>"
                                               href="<?php echo url($third['index']); ?>">
                                                <?php echo htmlentities($third['name']); ?></a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?php if($second == null): ?>no-sidebar-second<?php endif; ?>">
        <div class="row-content layer-cf">
    <div class="row">
        <div class="layer-u-sm-12 layer-u-md-12 layer-u-lg-12">
            <div class="widget layer-cf widget-bff">
                <div class="widget-body">
                    <div class="widget-head layer-cf">
                        <div class="widget-title layer-fl">页面链接</div>
                    </div>
                    <div class="link-list">
                        <ul class="">
                            <li class="link-item">
                                <div class="row page-nlayere">商城首页</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/index/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">自定义页面</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/custom/index</span>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">参数：</div>
                                    <div class="layer-fl">
                                        <p class="parlayer">
                                            <span class="x-color-green">page_id</span>
                                            <span>页面ID</span>
                                            <span class="x-color-red">　--必填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">例如：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-c-gray-5f">pages/custom/index?page_id=10001</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">分类页面</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/category/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">商品列表</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/category/list</span>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">参数：</div>
                                    <div class="layer-fl">
                                        <p class="parlayer">
                                            <span class="x-color-green">category_id</span>
                                            <span>商品分类ID</span>
                                            <span class="">　--选填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">例如：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-c-gray-5f">pages/category/list?category_id=10001</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">商品详情</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/goods/index</span>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">参数：</div>
                                    <div class="layer-fl">
                                        <p class="parlayer">
                                            <span class="x-color-green">goods_id</span>
                                            <span>商品ID</span>
                                            <span class="x-color-red">　--必填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">例如：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-c-gray-5f">pages/goods/index?goods_id=10001</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">搜索页</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/search/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">购物车页面</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/flow/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">个人中心</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/user/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">订单列表</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/order/index</span>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">参数：</div>
                                    <div class="layer-fl">
                                        <p class="parlayer">
                                            <span class="x-color-green">dataType</span>
                                            <span>订单类型 ( </span>
                                            <span class="x-color-green">all</span>
                                            <span>全部，</span>
                                            <span class="x-color-green">payment</span>
                                            <span>已付款，</span>
                                            <span class="x-color-green">delivery</span>
                                            <span>待发货，</span>
                                            <span class="x-color-green">received</span>
                                            <span>待收货</span>
                                            <span>)</span>
                                            <span class="">　--选填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">例如：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-c-gray-5f">pages/order/index?dataType=all</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">分销中心</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/dealer/index/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">领券中心</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/coupon/coupon</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-nlayere">我的优惠券</div>
                                <div class="row layer-cf">
                                    <div class="layer-fl">地址：</div>
                                    <div class="layer-fl">
                                        <span class="x-color-green">pages/user/coupon/coupon</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>

    </div>
    <!-- 内容区域 end -->

</div>
<script src="/assets/layer/layer.js"></script>
<script src="/assets/user/js/jquery.form.min.js"></script>
<script src="/assets/user/js/webuploader.html5only.js"></script>
<script src="/assets/user/js/art-template.js"></script>
<script src="/assets/user/js/app.js"></script>
<script src="/assets/user/js/file.library.js"></script>
<script src="/assets/user/js/amazeui.min.js"></script>
</body>

</html>
