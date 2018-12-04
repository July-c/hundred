<?php /*a:2:{s:61:"E:\WWW\free\application\user\view\apps\agent\order\index.html";i:1543318966;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                    <div class="widget-title layer-cf">分销订单</div>
                </div>
                <div class="widget-body layer-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar layer-margin-bottom-xs layer-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?php echo htmlentities($request->pathinfo()); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlentities($request->get('user_id')); ?>">
                            <div class="layer-u-sm-12 layer-u-md-9 layer-u-sm-push-3">
                                <div class="layer fr">
                                    <div class="layer-form-group layer-fl">
                                        <select name="is_settled"
                                                data-layer-selected="{btnSize: 'sm', placeholder: '是否结算佣金'}">
                                            <option value=""></option>
                                            <option value="-1" <?php echo $request->get('is_settled')=='-1'?'selected' : ''; ?>>
                                                全部
                                            </option>
                                            <option value="0" <?php echo $request->get('is_settled')==='0'?'selected' : ''; ?>>
                                                未结算
                                            </option>
                                            <option value="1" <?php echo $request->get('is_settled')=='1'?'selected' : ''; ?>>
                                                已结算
                                            </option>
                                        </select>
                                    </div>
                                    <div class="layer-form-group layer-fl">
                                        <div class="layer-input-group layer-input-group-sm tpl-form-border-form">
                                            <input type="text" class="layer-form-field" name="search"
                                                   placeholder="请输入订单号"
                                                   value="<?php echo htmlentities($request->get('search')); ?>">
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
                    <div class="order-list layer-scrollable-horizontal layer-u-sm-12 layer-margin-top-xs">
                        <table width="100%" class="layer-table layer-table-centered
                        layer-text-nowrap layer-margin-bottom-xs">
                            <thead>
                            <tr>
                                <th width="30%" class="item-detail">商品信息</th>
                                <th width="10%">单价/数量</th>
                                <th width="15%">实付款</th>
                                <th>买家</th>
                                <th>交易状态</th>
                                <th>佣金结算</th>
                            </tr>
                            </thead>
                            <tbody>
                           <?php if(!$list->isEmpty()): foreach($list as $order): ?>
                                <tr class="order-empty">
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td class="layer-text-middle layer-text-left" colspan="6">
                                        <span class="layer-margin-right-lg"> <?php echo htmlentities($order['order_master']['create_time']); ?></span>
                                        <span class="layer-margin-right-lg">订单号：<?php echo htmlentities($order['order_master']['order_no']); ?></span>
                                    </td>
                                </tr>
                                
                                <?php foreach($order['order_master']['item'] as $i=>$item): ?>
                                    <tr>
                                        <td class="item-detail layer-text-middle">
                                            <div class="item-image">
                                                <img src="<?php echo htmlentities($item['image']['file_path']); ?>" alt="">
                                            </div>
                                            <div class="item-info">
                                                <p class="item-title"><?php echo htmlentities($item['name']); ?></p>
                                                <p class="item-spec layer-link-muted">
                                                    <?php echo htmlentities($item['item_attr']); ?>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="layer-text-middle">
                                            <p>￥<?php echo htmlentities($item['item_price']); ?></p>
                                            <p>×<?php echo htmlentities($item['total_num']); ?></p>
                                        </td>
                                        <?php if($itemCount = count($order['order_master']['item'])): ?>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p>￥<?php echo htmlentities($order['order_master']['pay_price']); ?></p>
                                                <p class="layer-link-muted">
                                                    (含运费：￥<?php echo htmlentities($order['order_master']['express_price']); ?>)</p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p><?php echo htmlentities($order['order_master']['user']['nickName']); ?></p>
                                                <p class="layer-link-muted">
                                                    (用户id：<?php echo htmlentities($order['order_master']['user']['user_id']); ?>)</p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p>付款状态：
                                                    <span class="layer-badge
                                                <?php echo $order['order_master']['pay_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['order_master']['pay_status']['text']); ?></span>
                                                </p>
                                                <p>发货状态：
                                                    <span class="layer-badge
                                               <?php echo $order['order_master']['delivery_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['order_master']['delivery_status']['text']); ?>
														</span>
                                                </p>
                                                <p>收货状态：
                                                    <span class="layer-badge
                                                <?php echo $order['order_master']['receipt_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['order_master']['receipt_status']['text']); ?></span>
                                                </p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <?php if((!!$order['is_settled'])): ?>
                                                    <span class="layer-badge layer-badge-success">已结算</span>
                                                <?php else: ?>
                                                    <span class="layer-badge">未结算</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                               <?php endforeach; ?>
                                <tr>
                                    <td class="layer-text-middle layer-text-left" colspan="6">
                                        <div class="agent layer-cf">
                                           <?php if($order['first_user_id'] > 0): ?>
                                                <div class="agent-item layer-fl layer-margin-right-xl">
                                                    <p>
                                                        <span class="layer-text-right">一级分销商：</span>
                                                        <span><?php echo htmlentities($order['agent_first']['user']['nickName']); ?>
                                                            (ID: <?php echo htmlentities($order['agent_first']['user_id']); ?>)</span>
                                                    </p>
                                                    <p>
                                                        <span class="layer-text-right">分销佣金：</span>
                                                        <span class="x-color-red">￥<?php echo htmlentities($order['first_money']); ?></span>
                                                    </p>
                                                </div>
                                            <?php endif; if(($order['second_user_id'] > 0)): ?>
                                                <div class="agent-item layer-fl layer-margin-right-xl">
                                                    <p>
                                                        <span class="layer-text-right">二级分销商：</span>
                                                        <span><?php echo htmlentities($order['agent_second']['user']['nickName']); ?>
                                                            (ID: <?php echo htmlentities($order['agent_second']['user_id']); ?>)</span>
                                                    </p>
                                                    <p>
                                                        <span class="layer-text-right">分销佣金：</span>
                                                        <span class="x-color-red">￥<?php echo htmlentities($order['second_money']); ?></span>
                                                    </p>
                                                </div>
                                           <?php endif; if($order['third_user_id'] > 0): ?>
                                                <div class="agent-item layer-fl layer-margin-right-xl">
                                                    <p>
                                                        <span class="layer-text-right">三级分销商：</span>
                                                        <span><?php echo htmlentities($order['agent_third']['user']['nickName']); ?>
                                                            (ID: <?php echo htmlentities($order['agent_third']['user_id']); ?>)</span>
                                                    </p>
                                                    <p>
                                                        <span class="layer-text-right">分销佣金：</span>
                                                        <span class="x-color-red">￥<?php echo htmlentities($order['third_money']); ?></span>
                                                    </p>
                                                </div>
                                           <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="6" class="layer-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="layer-u-lg-12 layer-cf">
                        <div class="layer-fr"><?php echo htmlentities($list->render()); ?></div>
                        <div class="layer-fr pagination-total layer-margin-right">
                            <div class="layer-vertical-align-middle">总记录：<?php echo htmlentities($list->total()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
