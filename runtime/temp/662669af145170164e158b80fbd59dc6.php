<?php /*a:3:{s:64:"E:\WWW\free\application\user\view\apps\agent\setting\qrcode.html";i:1543209671;s:45:"E:\WWW\free\application\user\view\layout.html";i:1543209671;s:69:"E:\WWW\free\application\user\view\layouts\_template\file_library.html";i:1543209671;}*/ ?>
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
                        <div class="widget-title layer-fl">分销海报设置</div>
                    </div>
                    <div class="tips layer-margin-bottom">
                        <div class="pre">
                            <p> 注：可拖动头像、二维码、昵称调整位置，如修改</p>
                            <p> 注：修改后如需生效请前往 <a href="<?php echo url('setting.cache/clear'); ?>" target="_blank">设置-清理缓存</a>，清除临时图片
                            </p>
                        </div>
                    </div>
                    <div id="app" v-cloak class="poster-pannel layer-cf layer-padding-bottom-xl">
                        <div class="pannel__left layer-fl">
                            <div id="j-preview" ref="preview" class="poster-preview">
                                <img id="preview-backdrop" class="backdrop" :src="backdrop.src" alt="">
                                <div id="j-qrcode" ref="qrcode" class="drag pre-qrcode" v-bind:class="qrcode.style"
                                     v-bind:style="{ width: qrcode.width + 'px', height: qrcode.width + 'px', top: qrcode.top + 'px', left: qrcode.left + 'px' }">
                                    <img src="assets/user/img/agent/qrcode.png" alt="">
                                </div>
                                <div id="j-avatar" ref="avatar" v-drag class="drag pre-avatar"
                                     v-bind:class="avatar.style"
                                     v-bind:style="{ width: avatar.width + 'px', height: avatar.width + 'px', top: avatar.top + 'px', left: avatar.left + 'px' }">
                                    <img src="assets/user/img/agent/avatar.png" alt="">
                                </div>
                                <div id="j-nickName" ref="nickName" class="drag pre-nickName"
                                     v-bind:style="{ fontSize: nickName.fontSize + 'px', color: nickName.color, top: nickName.top + 'px', left: nickName.left + 'px' }">
                                    <span>这里是昵称</span>
                                </div>
                            </div>
                        </div>

                        <div class="pannel__right layer-fl">
                            <form id="my-form" class="layer-form tpl-form-line-form" method="post">

                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-4 layer-form-label form-require ron-wide">海报背景图 </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <div class="layer-form-file">
                                            <div class="layer-form-file">
                                                <button type="button"
                                                        class="j-image upload-file layer-btn layer-btn-secondary layer-radius">
                                                    <i class="layer-icon-cloud-upload"></i> 选择图片
                                                </button>
                                            </div>
                                            <div class="help-block">
                                                <small>尺寸：宽750像素 高大于(等于)1200像素</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 头像宽度 </label>
                                    <div class="layer-u-sm-9">
                                        <input type="number" min="30" class="tpl-form-input" v-model="avatar.width"
                                               required>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 头像样式 </label>
                                    <div class="layer-u-sm-9">
                                        <label class="layer-radio-inline">
                                            <input type="radio" value="square" data-am-ucheck
                                                   v-model="avatar.style"> 正方形
                                        </label>
                                        <label class="layer-radio-inline">
                                            <input type="radio" value="circle" data-am-ucheck
                                                   v-model="avatar.style"> 圆形
                                        </label>
                                    </div>
                                </div>

                                <div class="layer-form-group layer-padding-top">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 昵称字体大小 </label>
                                    <div class="layer-u-sm-9 ">
                                        <input type="number" min="12" class="tpl-form-input"
                                               v-model="nickName.fontSize" required>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 昵称字体颜色 </label>
                                    <div class="layer-u-sm-9">
                                        <input class="tpl-form-input" type="color" v-model="nickName.color">
                                    </div>
                                </div>

                                <div class="layer-form-group layer-padding-top">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 小程序码宽度 </label>
                                    <div class="layer-u-sm-9 ">
                                        <input type="number" min="50" class="tpl-form-input" v-model="qrcode.width"
                                               required>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-md-4 layer-form-label form-require ron-wide"> 小程序码样式 </label>
                                    <div class="layer-u-sm-9 ">
                                        <label class="layer-radio-inline">
                                            <input type="radio" value="square" v-model="qrcode.style" data-am-ucheck
                                                   checked> 正方形
                                        </label>
                                        <label class="layer-radio-inline">
                                            <input type="radio" value="circle" v-model="qrcode.style" data-am-ucheck> 圆形
                                        </label>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <div class="layer-u-sm-9 layer-u-sm-push-3 layer-margin-top-lg">
                                        <button type="submit" class="j-submit layer-btn layer-btn-secondary">提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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


<script src="/assets/user/js/vue.min.js"></script>
<script>

    $(function () {

        var appVue = new Vue({
            el: '#app',
            data: <?= $data ?>,
            created: function () {
                /**
                 * 注册拖拽事件
                 */
                this.$nextTick(function () {
                    this.dragEvent('qrcode');
                    this.dragEvent('avatar');
                    this.dragEvent('nickName');
                });
            },
            methods: {
                /**
                 * 注册拖拽事件
                 * @param ele
                 */
                dragEvent: function (ele) {
                    var _this = this
                        , $preview = this.$refs.preview
                        , $ele = this.$refs[ele]
                        , l = 0
                        , t = 0
                        , r = $preview.offsetWidth - $ele.offsetWidth
                        , b = $preview.offsetHeight - $ele.offsetHeight;
                    $ele.onmousedown = function (ev) {
                        var sentX = ev.clientX - $ele.offsetLeft;
                        var sentY = ev.clientY - $ele.offsetTop;
                        document.onmousemove = function (ev) {
                            var slideLeft = ev.clientX - sentX;
                            var slideTop = ev.clientY - sentY;
                            slideLeft <= l && (slideLeft = l);
                            slideLeft >= r && (slideLeft = r);
                            slideTop <= t && (slideTop = t);
                            slideTop >= b && (slideTop = b);

                            _this[ele].left = slideLeft;
                            _this[ele].top = slideTop;
                        };
                        document.onmouseup = function () {
                            document.onmousemove = null;
                            document.onmouseup = null;
                        };
                        return false;
                    }
                }
            }
        });

        // 选择图片：分销中心首页
        $('.j-image').selectImages({
            multiple: false,
            done: function (data) {
                appVue.$data.backdrop.src = data[0].file_path;
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm({
            buildData: function () {
                return {
                    qrcode: appVue.$data
                };
            }
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
