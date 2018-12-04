<?php /*a:2:{s:60:"E:\WWW\free\application\user\view\apps\agent\user\index.html";i:1543209350;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                    <div class="widget-title layer-cf">分销商列表</div>
                </div>
                <div class="widget-body layer-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar layer-margin-bottom-xs layer-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="layer-u-sm-12 layer-u-md-9 layer-u-sm-push-3">
                                <div class="layer fr">
                                    <div class="layer-form-group layer-fl">
                                        <div class="layer-input-group layer-input-group-sm tpl-form-border-form">
                                            <input type="text" class="layer-form-field" name="search"
                                                   placeholder="请输入昵称/姓名/手机号"
                                                   value="<?= $request->get('search') ?>">
                                            <div class="layer-input-group-btn">
                                                <button class="layer-btn layer-btn-default layer-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="__am-scrollable-horizontal layer-u-sm-12 layer-padding-bottom-lg">
                        <table width="100%" class="layer-table layer-table-compact layer-table-striped
                         tpl-table-black layer-text-nowrap">
                            <thead>
                            <tr>
                                <th>用户ID</th>
                                <th>微信头像</th>
                                <th>微信昵称</th>
                                <th>
                                    <p>姓名</p>
                                    <p>手机号</p>
                                </th>
                                <th>
                                    <p>累计佣金</p>
                                    <p>可提现佣金</p>
                                </th>
                                <th>推荐人</th>
                                <th>下级用户</th>
                                <th>成为时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="layer-text-middle"><?= $item['user_id'] ?></td>
                                    <td class="layer-text-middle">
                                        <a href="<?= $item['avatarUrl'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['avatarUrl'] ?>"
                                                 width="50" height="50" alt="">
                                        </a>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p><span><?= $item['nickName'] ?></span></p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if (!empty($item['real_name']) || !empty($item['mobile'])): ?>
                                            <p><?= $item['real_name'] ?: '--' ?></p>
                                            <p><?= $item['mobile'] ?: '--' ?></p>
                                        <?php else: ?>
                                            <p>--</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p><?= sprintf('%.2f', $item['money'] + $item['freeze_money'] + $item['total_money']) ?></p>
                                        <p><?= $item['money'] ?></p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if ($item['referee_id'] > 0): ?>
                                            <p><?= $item['referee']['nickName'] ?></p>
                                            <p class="layer-link-muted f-12">(ID：<?= $item['referee']['user_id'] ?>)</p>
                                        <?php else: ?>
                                            <p>平台</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p>
                                            <a href="javascript:void(0);"
                                               target="_blank">一级：<?= $item['first_num'] ?></a>
                                        </p>
                                        <?php if ($basicSetting['level'] >= 2): ?>
                                            <p>
                                                <a href="javascript:void(0);"
                                                   target="_blank">二级：<?= $item['second_num'] ?></a>
                                            </p>
                                        <?php endif; if ($basicSetting['level'] == 3): ?>
                                            <p>
                                                <a href="javascript:void(0);"
                                                   target="_blank">三级：<?= $item['third_num'] ?></a>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="layer-text-middle">
                                        <div class="operation-select layer-dropdown">
                                            <button type="button"
                                                    class="layer-dropdown-toggle layer-btn layer-btn-sm layer-btn-secondary">
                                                <span>操作</span>
                                                <span class="layer-icon-caret-down"></span>
                                            </button>
                                            <ul class="layer-dropdown-content" data-id="<?= $item['user_id'] ?>">
                                                <li>
                                                    <a class="" target="_blank"
                                                       href="<?= url('apps.agent.order/index', ['user_id' => $item['user_id']]) ?>">分销订单</a>
                                                </li>
                                                <li>
                                                    <a class="" target="_blank"
                                                       href="<?= url('apps.agent.withdraw/index', ['user_id' => $item['user_id']]) ?>">提现明细</a>
                                                </li>
                                                <li>
                                                    <a data-type="delete" class="" href="javascript:void(0);">删除分销商</a>
                                                </li>
                                                <li>
                                                    <a class=""
                                                       href="<?= url('apps.agent.user/qrcode', ['agent_id' => $item['user_id']]) ?>"
                                                       target="_blank">分销二维码</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9" class="layer-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="layer-u-lg-12 layer-cf">
                            <div class="layer-fr"><?= $list->render() ?> </div>
                            <div class="layer-fr pagination-total layer-margin-right">
                                <div class="layer-vertical-align-middle">总记录：<?= $list->total() ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 注册操作事件
         * @type {jQuery|HTMLElement}
         */
        var $dropdown = $('.operation-select');
        $dropdown.dropdown();
        $dropdown.on('click', 'li a', function () {
            var $this = $(this);
            var id = $this.parent().parent().data('id');
            var type = $this.data('type');
            if (type === 'delete') {
                layer.confirm('确定要删除分销商吗？', function (index) {
                    $.post("<?= url('apps.agent.user/delete') ?>", {agent_id: id}, function (result) {
                        result.code === 1 ? $.show_success(result.msg, result.url)
                            : $.show_error(result.msg);
                    });
                    layer.close(index);
                });
            }
            $dropdown.dropdown('close');
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
