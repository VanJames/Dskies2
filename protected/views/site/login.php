<?php
$this->pageTitle = Yii::app()->name . ' - ログイン';
$this->breadcrumbs = array(
    'ログイン',
);
?>
<div class="clearfix">
    <div class="login-wrap">
        <form id="login-form" action="<?php echo Yii::app()->request->baseUrl; ?>/site/login" method="post">
            <input type="hidden" name="LoginForm[checkNum]" id="checkNum" value="<?php echo $model->checkNum ?>" >
            <div class="login-form">
                <input id="username" class=" w-230" type="text" name="LoginForm[username]" placeholder="会員ID" value="<?php echo $model->username ?>"/>
                <input id="password" class=" w-230" type="password" name="LoginForm[password]" placeholder="パスワード" value="<?php echo $model->password ?>"/>
                <button id="login-button" class="btn qbt-button" type="submit">ログイン</button>
            </div>

            <span style="color:red;">
                <?php
                if ($model->getError('username')) {
                    echo $model->getError('username');
                }
                ?>
            </span>
        </form>
    </div>
</div>
