<?php /*a:3:{s:63:"E:\WWW\free\application\user\view\apps\agent\setting\index.html";i:1543209350;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;s:69:"E:\WWW\free\application\user\view\layouts\_template\file_library.html";i:1543209671;}*/ ?>
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
                <form id="my-form" class="layer-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <div class="layer-tabs layer-margin-top" data-layer-tabs="{noSwipe: 1}">
                            <ul class="layer-tabs-nav layer-nav layer-nav-tabs">
                                <li class="layer-active"><a href="#tab1">基础设置</a></li>
                                <li><a href="#tab2">分销商条件</a></li>
                                <li><a href="#tab3">佣金设置</a></li>
                                <li><a href="#tab4">结算</a></li>
                                <li><a href="#tab5">自定义文字</a></li>
                                <li><a href="#tab6">申请协议</a></li>
                                <li><a href="#tab7">页面背景图</a></li>
                                <li><a href="#tab8">模板消息</a></li>
                            </ul>
                            <div class="layer-tabs-bd">
                                <div class="layer-tab-panel layer-active layer-margin-top-lg" id="tab1">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide" > 是否开启分销功能 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[basic][is_open]"
                                                       value="1" data-am-ucheck
                                                    <?php echo $data['basic']['values']['is_open']==='1' ? 'checked'  :  ''; ?>>
                                                开启
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[basic][is_open]"
                                                       value="0" data-am-ucheck
                                                    <?php echo $data['basic']['values']['is_open']==='0' ? 'checked'  :  ''; ?>>
                                                关闭
                                            </label>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide"> 分销层级 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[basic][level]"
                                                       value="1" data-am-ucheck
                                                    <?php echo $data['basic']['values']['level']==='1' ? 'checked'  :  ''; ?>>
                                                一级分销
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[basic][level]"
                                                       value="2" data-am-ucheck
                                                    <?php echo $data['basic']['values']['level']==='2' ? 'checked'  :  ''; ?>>
                                                二级分销
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[basic][level]"
                                                       value="3" data-am-ucheck
                                                    <?php echo $data['basic']['values']['level']==='3' ? 'checked'  :  ''; ?>>
                                                三级分销
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel layer-margin-top-lg" id="tab2">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide"> 成为分销商条件 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[condition][become]"
                                                       value="10" data-am-ucheck
                                                    <?php echo $data['condition']['values']['become']==='10' ? 'checked'  :  ''; ?>>
                                                需后台审核
                                            </label>
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[condition][become]"
                                                       value="20" data-am-ucheck
                                                    <?php echo $data['condition']['values']['become']==='20' ? 'checked'  :  ''; ?>>
                                                无需审核
                                            </label>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide"> 成为下线条件 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-radio-inline">
                                                <input type="radio" name="setting[condition][downline]"
                                                       value="10" data-am-ucheck
                                                    <?php echo $data['condition']['values']['downline']==='10' ? 'checked'  :  ''; ?>>
                                                首次点击分享链接
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel layer-margin-top-lg" id="tab3">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            一级佣金比例
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="number" min="0" max="100" class="tpl-form-input"
                                                   name="setting[commission][first_money]"
                                                   value="<?php echo htmlentities($data['commission']['values']['first_money']); ?>" required>
                                            <small>佣金比例范围 0% - 100%</small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            二级佣金比例
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="number" min="0" max="100" class="tpl-form-input"
                                                   name="setting[commission][second_money]"
                                                   value="<?php echo htmlentities($data['commission']['values']['second_money']); ?>"
                                                   required>
                                            <small>佣金比例范围 0% - 100%</small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            三级佣金比例
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="number" min="0" max="100" class="tpl-form-input"
                                                   name="setting[commission][third_money]"
                                                   value="<?php echo htmlentities($data['commission']['values']['third_money']); ?>" required>
                                            <small>佣金比例范围 0% - 100%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel layer-margin-top-lg" id="tab4">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide"> 提现方式 </label>
                                        <div class="layer-u-sm-9">
                                            <label class="layer-checkbox-inline">
                                                <input type="checkbox" name="setting[settlement][pay_type][]" value="20"
                                                       data-am-ucheck
                                                  <?= in_array('20', $data['settlement']['values']['pay_type']) ? 'checked' : '' ?>>
                                                支付宝
                                            </label>
                                            <label class="layer-checkbox-inline">
                                                <input type="checkbox" name="setting[settlement][pay_type][]" value="30"
                                                       data-am-ucheck
                                                   <?= in_array('30', $data['settlement']['values']['pay_type']) ? 'checked' : '' ?>>
                                                银行卡
                                            </label>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            最低提现额度
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="number" min="0" class="tpl-form-input"
                                                   name="setting[settlement][min_money]"
                                                   value="<?php echo htmlentities($data['settlement']['values']['min_money']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel" id="tab5">
                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">分销中心页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['index']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            非分销商提示
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][not_agent][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['not_agent']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            申请成为分销商
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][apply_now][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['apply_now']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            推荐人
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][referee][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['referee']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            可提现佣金
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][money][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['money']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            待提现佣金
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][freeze_money][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['freeze_money']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            已提现金额
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][total_money][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['total_money']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            去提现
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][index][words][withdraw][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['index']['words']['withdraw']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">申请成为分销商页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['apply']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            请填写申请信息
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][words][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['words']['title']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            分销商申请协议
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][words][license][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['words']['license']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            申请成为经销商
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][words][submit][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['words']['submit']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            审核中提示信息
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][words][wait_audit][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['words']['wait_audit']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            去商城逛逛
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][apply][words][goto_mall][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['apply']['words']['goto_mall']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">分销订单页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][order][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['order']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['order']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            全部
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][order][words][all][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['order']['words']['all']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            未结算
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][order][words][unsettled][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['order']['words']['unsettled']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            已结算
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][order][words][settled][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['order']['words']['settled']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">我的团队页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][team][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['team']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['team']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            团队总人数
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][team][words][total_team][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['team']['words']['total_team']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            一级团队
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][team][words][first][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['team']['words']['first']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            二级团队
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][team][words][second][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['team']['words']['second']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            三级团队
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][team][words][third][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['team']['words']['third']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">提现明细页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['withdraw_list']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            全部
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][words][all][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['words']['all']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            审核中
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][words][apply_10][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['words']['apply_10']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            审核通过
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][words][apply_20][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['words']['apply_20']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            已打款
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][words][apply_40][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['words']['apply_40']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            驳回
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_list][words][apply_30][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_list']['words']['apply_30']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">申请提现页面</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['withdraw_apply']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            可提现佣金
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][words][capital][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['words']['capital']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            提现金额
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][words][money][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['words']['money']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            请输入要提取的金额
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][words][money_placeholder][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['words']['money_placeholder']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            最低提现佣金
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][words][min_money][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['words']['min_money']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            提交申请
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][withdraw_apply][words][submit][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['withdraw_apply']['words']['submit']['value']); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="widget-head layer-cf">
                                        <div class="widget-title layer-fl">推广二维码</div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            页面标题
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[words][qrcode][title][value]"
                                                   value="<?php echo htmlentities($data['words']['values']['qrcode']['title']['value']); ?>"
                                                   required>
                                            <small>
                                                默认：<?php echo htmlentities($data['words']['values']['qrcode']['title']['default']); ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="layer-tab-panel layer-margin-top-lg" id="tab6">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require ron-wide">分销商申请协议 </label>
                                        <div class="layer-u-sm-9 layer-u-end">
                                    <textarea class="" rows="6" placeholder="请输入分销商申请协议"
                                              name="setting[license][license]"><?php echo htmlentities($data['license']['values']['license']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel layer-margin-top-lg" id="tab7">
                                    <input type="hidden" name="setting[background][__]" value="">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require ron-wide">分销中心首页 </label>
                                        <div class="layer-u-sm-9 layer-u-end">
                                            <div class="layer-form-file">
                                                <div class="layer-form-file">
                                                    <button type="button"
                                                            class="j-index upload-file layer-btn layer-btn-secondary layer-radius">
                                                        <i class="layer-icon-cloud-upload"></i> 选择图片
                                                    </button>
                                                    <div class="uploader-list layer-cf">
                                                        <?php if((!empty($data['background']['values']['index']))): ?>
                                                            <div class="file-item">
                                                                <a href="<?php echo htmlentities($data['background']['values']['index']); ?>"
                                                                   title="点击查看大图"
                                                                   target="_blank">
                                                                    <img src="<?php echo htmlentities($data['background']['values']['index']); ?>">
                                                                </a>
                                                                <input type="hidden" name="setting[background][index]"
                                                                       value="<?php echo htmlentities($data['background']['values']['index']); ?>">
                                                                <i class="iconfont icon-shanchu file-item-delete"></i>
                                                            </div>
                                                       <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="help-block">
                                                    <small>尺寸：宽750像素 高度不限</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require ron-wide">申请成为分销商页 </label>
                                        <div class="layer-u-sm-9 layer-u-end">
                                            <div class="layer-form-file">
                                                <div class="layer-form-file">
                                                    <button type="button"
                                                            class="j-apply upload-file layer-btn layer-btn-secondary layer-radius">
                                                        <i class="layer-icon-cloud-upload"></i> 选择图片
                                                    </button>
                                                    <div class="uploader-list layer-cf">
                                                       <?php if((!empty($data['background']['values']['apply']))): ?>
                                                            <div class="file-item">
                                                                <a href="<?php echo htmlentities($data['background']['values']['apply']); ?>"
                                                                   title="点击查看大图"
                                                                   target="_blank">
                                                                    <img src="<?php echo htmlentities($data['background']['values']['apply']); ?>">
                                                                </a>
                                                                <input type="hidden" name="setting[background][apply]"
                                                                       value="<?php echo htmlentities($data['background']['values']['apply']); ?>">
                                                                <i class="iconfont icon-shanchu file-item-delete"></i>
                                                            </div>
                                                       <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="help-block">
                                                    <small>尺寸：宽750像素 高度不限</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require ron-wide">申请提现页 </label>
                                        <div class="layer-u-sm-9 layer-u-end">
                                            <div class="layer-form-file">
                                                <div class="layer-form-file">
                                                    <button type="button"
                                                            class="j-withdraw_apply upload-file layer-btn layer-btn-secondary layer-radius">
                                                        <i class="layer-icon-cloud-upload"></i> 选择图片
                                                    </button>
                                                    <div class="uploader-list layer-cf">
                                                        <?php if((!empty($data['background']['values']['withdraw_apply']))): ?>
                                                            <div class="file-item">
                                                                <a href="<?php echo htmlentities($data['background']['values']['withdraw_apply']); ?>"
                                                                   title="点击查看大图"
                                                                   target="_blank">
                                                                    <img src="<?php echo htmlentities($data['background']['values']['withdraw_apply']); ?>">
                                                                </a>
                                                                <input type="hidden"
                                                                       name="setting[background][withdraw_apply]"
                                                                       value="<?php echo htmlentities($data['background']['values']['withdraw_apply']); ?>">
                                                                <i class="iconfont icon-shanchu file-item-delete"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="help-block">
                                                    <small>尺寸：宽750像素 高度不限</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layer-tab-panel layer-margin-top-lg" id="tab8">
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            分销商入驻审核通知
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[template_msg][apply_tpl]"
                                                   placeholder="请填写模板消息ID"
                                                   value="<?php echo htmlentities($data['template_msg']['values']['apply_tpl']); ?>">
                                            <small>模板编号AT0674，关键词 (申请时间、审核状态、审核时间、备注信息)</small>
                                            <small class="layer-margin-left-xs">
                                                <a href="index.php?s=/store/setting.help/tplmsg" target="_blank">如何获取模板消息ID？</a>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="layer-form-group">
                                        <label class="layer-u-sm-3 layer-form-label form-require ron-wide">
                                            提现状态通知
                                        </label>
                                        <div class="layer-u-sm-9">
                                            <input type="text" class="tpl-form-input"
                                                   name="setting[template_msg][withdraw_tpl]"
                                                   placeholder="请填写模板消息ID"
                                                   value="<?php echo htmlentities($data['template_msg']['values']['withdraw_tpl']); ?>">
                                            <small>模板编号AT0324，关键词 (提现时间、提现方式、提现金额、提现状态、备注)</small>
                                            <small class="layer-margin-left-xs">
                                                <a href="index.php?s=/store/setting.help/tplmsg" target="_blank">如何获取模板消息ID？</a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layer-form-group">
                            <div class="layer-u-sm-9 layer-u-sm-push-3 layer-margin-top-lg">
                                <button type="submit" class="j-submit layer-btn layer-btn-secondary">提交
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
<script id="tpl-file-item" type="text/template">    {{ each list }}    <div class="file-item">        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">            <img src="{{ $value.file_path }}">        </a>        <input type="hidden" name="{{ name }}" value="{{ $value.file_path }}">        <i class="iconfont icon-shanchu file-item-delete"></i>    </div>    {{ /each }}</script>

<!-- 文件库弹窗 -->
<!-- 文件库模板 -->
<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ is_default ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name layer-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope" data-group-id="0">
                    <a class="group-name layer-text-truncate" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
                {{ each group_list }}
                <li class="ng-scope"
                    data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
                    <a class="group-edit" href="javascript:void(0);" title="编辑分组">
                        <i class="iconfont icon-bianji"></i>
                    </a>
                    <a class="group-name layer-text-truncate" href="javascript:void(0);">
                        {{ $value.group_name }}
                    </a>
                    <a class="group-delete" href="javascript:void(0);" title="删除分组">
                        <i class="iconfont icon-shanchu1"></i>
                    </a>
                </li>
                {{ /each }}
            </ul>
            <a class="group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header layer-cf">
                <div class="h-left layer-fl layer-cf">
                    <div class="layer-fl">
                        <div class="group-select layer-dropdown">
                            <button type="button" class="layer-btn layer-btn-sm layer-btn-secondary layer-dropdown-toggle">
                                移动至 <span class="layer-icon-caret-down"></span>
                            </button>
                            <ul class="group-list layer-dropdown-content">
                                <li class="layer-dropdown-header">请选择分组</li>
                                {{ each group_list }}
                                <li>
                                    <a class="move-file-group" data-group-id="{{ $value.group_id }}"
                                       href="javascript:void(0);">{{ $value.group_name }}</a>
                                </li>
                                {{ /each }}
                            </ul>
                        </div>
                    </div>
                    <div class="layer-fl tpl-table-black-operation">
                        <a href="javascript:void(0);" class="file-delete tpl-table-black-operation-del"
                           data-group-id="2">
                            <i class="layer-icon-trash"></i> 删除
                        </a>
                    </div>
                </div>
                <div class="h-rigth layer-fr">
                    <div class="j-upload upload-image">
                        <i class="iconfont icon-add1"></i>
                        上传图片
                    </div>
                </div>
            </div>
            <div id="file-list-body" class="v-box-body">
                {{ include 'tpl-file-list' file_list }}
            </div>
            <div class="v-box-footer layer-cf"></div>
        </div>
    </div>

</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list" type="text/template">
    <ul class="file-list-item">
        {{ include 'tpl-file-list-item' data }}
    </ul>
    {{ if last_page > 1 }}
    <div class="file-page-box layer-fr">
        <ul class="pagination">
            {{ if current_page > 1 }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="上一页" data-page="{{ current_page - 1 }}">«</a>
            </li>
            {{ /if }}
            {{ if current_page < last_page }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="下一页" data-page="{{ current_page + 1 }}">»</a>
            </li>
            {{ /if }}
        </ul>
    </div>
    {{ /if }}
</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="file-name layer-text-center layer-text-truncate">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="assets/user/img/chose.png">
        </div>
    </li>
    {{ /each }}
</script>

<!-- 分组元素-->
<script id="tpl-group-item" type="text/template">
    <li class="ng-scope" data-group-id="{{ group_id }}" title="{{ group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name layer-text-truncate" href="javascript:void(0);">
            {{ group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
</script>


<script>
    $(function () {

        // 选择图片：分销中心首页
        $('.j-index').selectImages({
            name: 'setting[background][index]'
            , multiple: false
        });

        // 选择图片：申请成为分销商页
        $('.j-apply').selectImages({
            name: 'setting[background][apply]'
            , multiple: false
        });

        // 选择图片：申请提现页
        $('.j-withdraw_apply').selectImages({
            name: 'setting[background][withdraw_apply]'
            , multiple: false
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
