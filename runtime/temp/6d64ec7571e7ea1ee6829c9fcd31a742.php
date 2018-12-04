<?php /*a:2:{s:64:"E:\WWW\free\application\user\view\apps\agent\withdraw\index.html";i:1543209350;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                    <div class="widget-title layer-cf">分销商提现申请</div>
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
                                        <select name="apply_status"
                                                data-layer-selected="{btnSize: 'sm', placeholder: '审核状态'}">
                                            <option value=""></option>
                                            <option value="-1" <?php echo $request->get('apply_status')==='-1'?'selected' : ''; ?>>
                                                全部
                                            </option>
                                            <option value="10" <?php echo $request->get('apply_status')=='10'?'selected' : ''; ?>>
                                                待审核
                                            </option>
                                            <option value="20" <?php echo $request->get('apply_status')=='20'?'selected' : ''; ?>>
                                                审核通过
                                            </option>
                                            <option value="40" <?php echo $request->get('apply_status')=='40'?'selected' : ''; ?>>
                                                已打款
                                            </option>
                                            <option value="30" <?php echo $request->get('apply_status')=='30'?'selected' : ''; ?>>
                                                驳回
                                            </option>
                                        </select>
                                    </div>
                                    <div class="layer-form-group layer-fl">
                                        <select name="pay_type"
                                                data-layer-selected="{btnSize: 'sm', placeholder: '提现方式'}">
                                            <option value=""></option>
                                            <option value="-1" <?php echo $request->get('pay_type')=='-1'?'selected' : ''; ?>>
                                                全部
                                            </option>
                                            <option value="20" <?php echo $request->get('pay_type')=='20'?'selected' : ''; ?>>
                                                支付宝
                                            </option>
                                            <option value="30" <?php echo $request->get('pay_type')=='30'?'selected' : ''; ?>>
                                                银行卡
                                            </option>
                                        </select>
                                    </div>
                                    <div class="layer-form-group layer-fl">
                                        <div class="layer-input-group layer-input-group-sm tpl-form-border-form">
                                            <input type="text" class="layer-form-field" name="search"
                                                   placeholder="请输入姓名/手机号"
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
                                <th>提现金额</th>
                                <th>提现方式</th>
                                <th>提现信息</th>
                                <th class="layer-text-center">审核状态</th>
                                <th>申请时间</th>
                                <th>审核时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php if(!$list->isEmpty()): foreach($list as $item): ?>
                          
                                <tr>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['user_id']); ?></td>
                                    <td class="layer-text-middle">
                                        <a href="<?php echo htmlentities($item['avatarUrl']); ?>" title="点击查看大图" target="_blank">
                                            <img src="<?php echo htmlentities($item['avatarUrl']); ?>"
                                                 width="50" height="50" alt="">
                                        </a>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p><span><?php echo htmlentities($item['nickName']); ?></span></p>
                                    </td>
                                    <td class="layer-text-middle">
                                       <?php if((!empty($item['real_name']) or !empty($item['mobile']))): ?>
                                            <p><?php echo !empty($item['real_name']) ? htmlentities($item['real_name']) : '--'; ?></p>
                                            <p><?php echo !empty($item['mobile']) ? htmlentities($item['mobile']) : '--'; ?></p>
                                        <?php else: ?>
                                            <p>--</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p><span><?php echo htmlentities($item['money']); ?></span></p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p><span><?php echo htmlentities($item['pay_type']['text']); ?></span></p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if(($item['pay_type']['value'] == 20)): ?>
                                            <p><span><?php echo htmlentities($item['alipay_name']); ?></span></p>
                                            <p><span><?php echo htmlentities($item['alipay_account']); ?></span></p>
                                        <?php elseif(($item['pay_type']['value'] == 30)): ?>
                                            <p><span><?php echo htmlentities($item['bank_name']); ?></span></p>
                                            <p><span><?php echo htmlentities($item['bank_account']); ?></span></p>
                                            <p><span><?php echo htmlentities($item['bank_card']); ?></span></p>
                                        <?php else: ?>
                                            <p><span>--</span></p>
                                       <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle layer-text-center">
                                        <?php if($item['apply_status'] == 10): ?>
                                            <span class="layer-badge">待审核</span>
                                        <?php elseif(($item['apply_status'] == 20)): ?>
                                            <span class="layer-badge layer-badge-secondary">审核通过</span>
                                       <?php elseif(($item['apply_status'] == 30)): ?>
                                            <p><span class="layer-badge layer-badge-warning">已驳回</span></p>
                                            <span class="f-12">
                                                <a class="j-show-reason" href="javascript:void(0);"
                                                   data-reason="<?php echo htmlentities($item['reject_reason']); ?>">
                                                    查看原因</a>
                                            </span>
                                        <?php elseif(($item['apply_status'] == 40)): ?>
                                            <span class="layer-badge layer-badge-success">已打款</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['create_time']); ?></td>
                                    <td class="layer-text-middle"><?php echo !empty($item['audit_time']) ? htmlentities($item['audit_time']) : '--'; ?></td>
                                    <td class="layer-text-middle">
                                        <div class="tpl-table-black-operation">
                                           <?php if((in_array($item['apply_status'], [10, 20]))): ?>
                                                <a class="j-audit" data-id="<?php echo htmlentities($item['id']); ?>"
                                                   href="javascript:void(0);">
                                                    <i class="layer-icon-pencil"></i> 审核
                                                </a>
                                                <?php if(($item['apply_status'] == 20)): ?>
                                                    <a class="j-money tpl-table-black-operation-del"
                                                       data-id="<?php echo htmlentities($item['id']); ?>" href="javascript:void(0);">确认打款
                                                    </a>
                                                <?php endif; endif; if((in_array($item['apply_status'], [30, 40]))): ?>
                                                <span>---</span>
                                           <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="11" class="layer-text-center">暂无记录</td>
                                </tr>
                           <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="layer-u-lg-12 layer-cf">
                            <div class="layer-fr"><?php echo htmlentities($list->render()); ?> </div>
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

<!-- 提现审核 -->
<script id="tpl-agent-withdraw" type="text/template">
    <div class="layer-padding-top-sm">
        <form class="form-agent-withdraw layer-form tpl-form-line-form" method="post"
              action="<?php echo url('apps.agent.withdraw/submit'); ?>">
            <input type="hidden" name="id" value="{{ id }}">
            <div class="layer-form-group">
                <label class="layer-u-sm-3 layer-form-label"> 审核状态 </label>
                <div class="layer-u-sm-9">
                    <label class="layer-radio-inline">
                        <input type="radio" name="withdraw[apply_status]" value="20" data-layer-ucheck
                               checked> 审核通过
                    </label>
                    <label class="layer-radio-inline">
                        <input type="radio" name="withdraw[apply_status]" value="30" data-layer-ucheck> 驳回
                    </label>
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layer-u-sm-3 layer-form-label"> 驳回原因 </label>
                <div class="layer-u-sm-9">
                    <input type="text" class="tpl-form-input" name="withdraw[reject_reason]" placeholder="仅在驳回时填写"
                           value="">
                </div>
            </div>
        </form>
    </div>
</script>

<script>
    $(function () {

        /**
         * 审核操作
         */
        $('.j-audit').click(function () {
            var $this = $(this);
            layer.open({
                type: 1
                , title: '提现审核'
                , area: '340px'
                , offset: 'auto'
                , anim: 1
                , closeBtn: 1
                , shade: 0.3
                , btn: ['确定', '取消']
                , content: template('tpl-agent-withdraw', $this.data())
                , success: function (layero) {
                    // 注册radio组件
                    layero.find('input[type=radio]').uCheck();
                }
                , yes: function (index, layero) {
                    // 表单提交
                    layero.find('.form-agent-withdraw').ajaxSubmit({
                        type: 'post',
                        dataType: 'json',
                        success: function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        }
                    });
                    layer.close(index);
                }
            });
        });

        /**
         * 显示驳回原因
         */
        $('.j-show-reason').click(function () {
            var $this = $(this);
            layer.alert($this.data('reason'), {title: '驳回原因'});
        });

        /**
         * 确认打款
         */
        $('.j-money').click(function () {
            var id = $(this).data('id');
            var url = "<?= url('apps.agent.withdraw/money') ?>";
            layer.confirm('确定已打款吗？', function (index) {
                $.post(url, {id: id}, function (result) {
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
