<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nint后台管理登录界面</title>
<link type="text/css" rel="stylesheet" href="<?=$this->createUrl('/css/crm-login.css');?>" />
<!--[if lte IE 6]><style>#logo,#main h2,#main fieldset{behavior:url("<?=$this->createUrl('/js/iepngfix.htc');?>")}</style><![endif]-->
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="logo"></div>
			<div id="welcome">
				欢迎来到Nint管理后台！
			</div>
		</div>
		<div id="main">
			<h2></h2>
			<?php echo CHtml::beginForm("","post",array('name'=>'form1','onkeydown'=>"if(event.keyCode==13)login()")); ?>
			<fieldset>
			<?php $that_errors = $form->getErrors() ;?>
				<div>
					<label>用户名：</label><span style="color: red;"><?php if( $form->hasErrors() ) :?>
					<?php echo $that_errors['username'][0]?> <?php endif; ?> </span>
				</div>
				<div class="uid">
				<?php echo CHtml::activeTextField($form,'username',array('class' => 'txt5')) ?>
					<span> </span>
				</div>
				<div>
					<label>密&nbsp;&nbsp;码：</label><span style="color: red;"><?php if( $form->hasErrors() ) :?>
					<?php echo $that_errors['password'][0]?> <?php endif; ?> </span>
				</div>
				<div class="pwd">
				<?php echo CHtml::activePasswordField($form,'password',array('class' => 'txt5')) ?>
					<span></span>
				</div>
				<div>
					<label>验证码：</label></br><?php $this->widget('CCaptcha'); ?>
					<span style="color: red;"><?php if( $form->hasErrors() ) :?>
					<?php echo $that_errors['verifyCode'][0]?> <?php endif; ?> </span>
				</div>
				<div class="uid">
					<?php echo CHtml::activeTextField($form,'verifyCode',array('tabindex'=>1)); ?>
					<span> </span>
				</div>
				<div class="btn">
					<a href="#" onclick="login()">登&nbsp;录</a>
				</div>
			</fieldset>
			<div class="remember">
				<label><?php echo CHtml::activeCheckBox($form,'rememberMe',array()) ?>
					<span>记住登录状态</span> </label>
			</div>
			<?php echo CHtml::endForm(); ?>
		</div>
		<div id="footer">
			<p id="copyright">
				Copyright © 2014 Nint - All Rights Reserved <a
					href='http://www.miibeian.gov.cn' target='_blank'>沪ICP备08004235号-22</a>
			</p>
			<p class="link">
				<span><a href="#">阅读许可</a> </span> <span><a href="#">隐私权政策</a> </span>
				<span><a href="#">联系我们</a> </span> <span class="last"><a
					href="#">关于我们</a> </span>
			</p>
		</div>
	</div>
	<script type="text/javascript">
	function login() {
    	document.form1.submit();
    }
    </script>
</body>
</html>