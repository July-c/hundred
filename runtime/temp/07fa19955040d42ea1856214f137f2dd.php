<?php /*a:2:{s:60:"E:\WWW\free\application\user\view\market\coupon\receive.html";i:1543399170;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;}*/ ?>
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
       <div class="widget-title layer-cf">
        优惠券领取记录
       </div> 
      </div> 
      <div class="widget-body layer-fr"> 
       <div class="layer-u-sm-12"> 
        <table width="100%" class="layer-table layer-table-compact layer-table-striped tpl-table-black"> 
         <thead> 
          <tr> 
           <th class="layer-text-center">用户</th> 
           <th>优惠券ID</th> 
           <th>优惠券名称</th> 
           <th>优惠券类型</th> 
           <th>最低消费金额</th> 
           <th>优惠方式</th> 
           <th>有效期</th> 
           <th>领取时间</th> 
          </tr> 
         </thead> 
         <tbody>
           <?php if((!$list->isEmpty())): foreach($list as $item): ?> 
          <tr> 
           <td class="layer-text-center"> <p class=""><?php echo htmlentities($item['user']['nickName']); ?></p> <p class="layer-link-muted">(用户id：<?php echo htmlentities($item['user']['user_id']); ?>)</p> </td> 
           <td class="layer-text-middle"><?php echo htmlentities($item['coupon_id']); ?></td> 
           <td class="layer-text-middle"><?php echo htmlentities($item['name']); ?></td> 
           <td class="layer-text-middle"><?php echo htmlentities($item['coupon_type']['text']); ?></td> 
           <td class="layer-text-middle"><?php echo htmlentities($item['min_price']); ?></td> 
           <td class="layer-text-middle"> <?php if(($item['coupon_type']['value'] === 10)): ?> <span>立减 <strong><?php echo htmlentities($item['reduce_price']); ?></strong> 元</span> <?php elseif(($item['coupon_type']['value'] === 20)): ?> <span>打 <strong><?php echo htmlentities($item['discount']); ?></strong> 折</span> <?php endif; ?> </td> 
           <td class="layer-text-middle"> <?php if(($item['expire_type'] === 10)): ?> <span>领取 <strong><?php echo htmlentities($item['expire_day']); ?></strong> 天内有效</span> <?php elseif(($item['expire_type'] === 20)): ?> <span><?php echo htmlentities($item['start_time']['text']); ?> ~ <?php echo htmlentities($item['end_time']['text']); ?></span> <?php endif; ?> </td> 
           <td class="layer-text-middle"><?php echo htmlentities($item['create_time']); ?></td> 
          </tr> <?php endforeach; else: ?> 
          <tr> 
           <td colspan="11" class="layer-text-center">暂无记录</td> 
          </tr> <?php endif; ?> 
         </tbody> 
        </table> 
       </div> 
       <div class="layer-u-lg-12 layer-cf"> 
        <div class="layer-fr">
         <?php echo $list->render(); ?>
        </div> 
        <div class="layer-fr pagination-total layer-margin-right"> 
         <div class="layer-vertical-align-middle">
          总记录：<?php echo htmlentities($list->total()); ?>
         </div> 
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div>
  </div>
  <script>    $(function () {        // 删除元素        
var url = "<?php echo url('market.coupon/delete'); ?>";       
 $('.item-delete').delete('coupon_id', url);   
 });</script>
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
