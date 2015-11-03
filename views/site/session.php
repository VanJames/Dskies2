<?php echo '用户编号：'.Yii::$app->session->get('userId');?>
<?php echo '用户名称：'.Yii::$app->session->get('userName');?>
<?php echo '来源路径：'.Yii::$app->session->get('url');?>
<a href="/site/index">去登录</a>
<a href="/site/logout">注销</a>