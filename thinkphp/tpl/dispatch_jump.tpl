{__NOLAYOUT__}<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>权限树扩展分享</title>
</head>
<body>
<style>
.widget-error {background:#fff; padding:5% 20px; text-align:center;width:40%; margin:10% auto;box-shadow:0px 0px 5px 0px rgba(250,104,105,0.39)}
.widget-error-im {margin-bottom:20px;height:50px; line-height:50px;}
.widget-error-im img {height:50px;width:50px; vertical-align:middle;}
</style>

<div class="row-content layer-cf">
    <div class="row">
        <div class="layer-u-sm-12 layer-u-md-12 layer-u-lg-12">
            <div class="widget layer-cf ">
                <div class="widget-error layer-u-sm-6">
				
					<div class="widget-error-im" >
					 <?php switch ($code) {?>
					 <?php case 1:?>
						<img src="public/assets/user/img/icon_gth.png"/>
					<?php break;?>
					<?php case 0:?>
						<img src="public/assets/user/img/icon_gth.png"/>
					<?php break;?>
						<em style="color:#fa6869"><?php echo(strip_tags($msg));?></em>
						<?php } ?>
					</div>
					<p class="font-size:14px;">
					页面自动 <a id="href" style="color:#fa6869;margin:0 5px;" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></p>
				</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	(function(){
		var wait = document.getElementById('wait'),
			href = document.getElementById('href').href;
		var interval = setInterval(function(){
			var time = --wait.innerHTML;
			if(time <= 0) {
				location.href = href;
				clearInterval(interval);
			};
		}, 1000);
	})();
</script>

</body>