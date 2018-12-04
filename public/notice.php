<?php

// [ 支付通知入口文件 ]

// 手动定义路由


// 定义运行目录
namespace think;
define('WEB_PATH', __DIR__ . '/');
define('APP_PATH', WEB_PATH . '../application/');
define('RUNTIME_PATH', WEB_PATH . './runtime');
$_GET['s'] = '/task/notify/order';
// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
