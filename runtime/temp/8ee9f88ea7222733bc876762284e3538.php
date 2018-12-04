<?php /*a:2:{s:51:"E:\WWW\free\application\user\view\tpl\category.html";i:1543893472;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
        <style>
    .img__category_style {
        width: 100%;
        box-shadow: 0 3px 10px #dcdcdc;
    }
</style>
<div class="row-content layer-cf">
    <div class="row">
        <div class="layer-u-sm-12 layer-u-md-12 layer-u-lg-12">
            <div class="widget layer-cf widget-bff">
                <form id="my-form" class="layer-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">分类页模板</div>
                            </div>
                            <div class="wrapper layer-container">
                                <div class="left-style layer-u-sm-12 layer-u-md-12 layer-u-lg-4">
                                    <img class="img__category_style"
                                         src="assets/user/img/categoryTpl_<?php echo htmlentities($model['category_style']); ?>.png">
                                </div>
                                <div class="right-form layer-u-sm-12 layer-u-md-12 layer-u-lg-8">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require"> 分类页样式 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="category[category_style]" value="10"
                                                       data-layer-ucheck
                                                    <?= $model['category_style'] === 10 ? 'checked' : '' ?>
                                                       required>
                                                一级分类 (大图)
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="category[category_style]" value="11"
                                                       data-layer-ucheck
                                                    <?= $model['category_style'] === 11 ? 'checked' : '' ?>>
                                                一级分类 (小图)
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="category[category_style]" value="20"
                                                       data-layer-ucheck
                                                    <?= $model['category_style'] === 20 ? 'checked' : '' ?>>
                                                二级分类
                                            </label>
                                            <div class="help__style help-block layer-margin-top-xs">
                                                <small class="<?= $model['category_style'] === 10 ? '' : 'hide' ?>"
                                                       data-value="10">分类图尺寸：宽750像素 高度不限
                                                </small>
                                                <small class="<?= $model['category_style'] === 11 ? '' : 'hide' ?>"
                                                       data-value="11">分类图尺寸：宽188像素 高度不限
                                                </small>
                                                <small class="<?= $model['category_style'] === 20 ? '' : 'hide' ?>"
                                                       data-value="20">分类图尺寸：宽150像素 高150像素
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require"> 分享标题 </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input" name="category[share_title]"
                                                   value="<?php echo htmlentities($model['share_title']); ?>">
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <div class="layer-u-sm-9 layer-u-sm-push-3 layer-margin-top-lg">
                                            <button type="submit" class="j-submit layer-btn layer-btn-secondary">提交
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 切换分类样式图
        var $imgCategorystyle = $('.img__category_style');
        var $helpStyleSmall = $('.help__style').find('small');
        $("input[nlayere='category[category_style]']").change(function (e) {
            var styleValue = e.currentTarget.value;
            $helpStyleSmall.hide().filter('[data-value=' + styleValue + ']').show();
            $imgCategorystyle.attr('src', 'assets/user/img/categoryTpl_' + styleValue + '.png');
        });

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
