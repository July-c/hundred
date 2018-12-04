<?php /*a:2:{s:48:"E:\WWW\free\application\user\view\tpl\index.html";i:1542189886;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
            <div class="widget layer-cf">
                <div class="widget-head layer-cf">
                    <div class="widget-title layer-cf">页面设计</div>
                </div>
                <div class="widget-body layer-fr">
                    <div class="layer-u-sm-12 layer-u-md-6 layer-u-lg-6">
                        <div class="layer-form-group">
                            <div class="layer-btn-toolbar">
                                    <div class="layer-btn-group layer-btn-group-xs">
                                        <a class="layer-btn layer-btn-default layer-btn-success layer-radius"
                                           href="<?php echo url('tpl/add'); ?>">
                                            <span class="layer-icon-plus"></span> 新增
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="layer-u-sm-12">
                        <table width="100%" class="layer-table layer-table-compact layer-table-striped tpl-table-black ">
                            <thead>
                            <tr>
                                <th>页面ID</th>
                                <th width="25%">页面名称</th>
                                <th>页面类型</th>
                                <th>添加时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!$list->isEmpty()): foreach($list  as $item): ?>
                                <tr>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['page_id']); ?></td>
                                    <td class="layer-text-middle">
                                        <span><?php echo htmlentities($item['page_name']); ?></span>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if($item['page_type'] == 10): ?>
                                            <span class="layer-badge layer-badge-warning">商城首页</span>
                                        <?php elseif($item['page_type'] == 20): ?>
                                            <span class="layer-badge layer-badge-secondary">自定义页</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['create_time']); ?></td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['update_time']); ?></td>
                                    <td class="layer-text-middle">
                                        <div class="tpl-table-black-operation">
                                                <a href="<?php echo url('tpl/edit', ['page_id' => $item['page_id']]); ?>">
                                                    <i class="layer-icon-pencil"></i> 编辑
                                                </a>
                                           <?php if($item['page_type'] == 20): ?>
                                                    <a href="javascript:;"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?php echo htmlentities($item['page_id']); ?>">
                                                        <i class="layer-icon-trash"></i> 删除
                                                    </a>
                                                    <a href="javascript:;"
                                                       class="j-setHome tpl-table-black-operation-green"
                                                       data-id="<?php echo htmlentities($item['page_id']); ?>">
                                                        <i class="iconfont icon-home"></i> 设为首页
                                                    </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                          <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="layer-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 删除元素
        $('.item-delete').delete('page_id', "<?= url('tpl/delete') ?>");

        // 设为首页
        $('.j-setHome').click(function () {
            var pageId = $(this).attr('data-id');
            layer.confirm('确定要将此页面设置为默认首页吗？', function (index) {
                $.post("<?= url('tpl/sethome') ?>", {page_id: pageId}, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url)
                        : $.show_error(result.msg);
                });
                layer.close(index);
            });
        });

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
