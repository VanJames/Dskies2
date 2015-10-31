<?php $actionId = $this->actionId; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="keywords"
          content="<?= CHtml::encode(Yii::t('Seo', (($this->action->id == 'page') ? $_GET['view'] : $this->action->id) . '_keywords')) ?>"/>
    <meta name="description"
          content="<?= CHtml::encode(Yii::t('Seo', (($this->action->id == 'page') ? $_GET['view'] : $this->action->id) . '_desc')) ?>"/>
    <link rel="shortcut icon" href="<?= $this->createUrl('/favicon.ico'); ?>"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/rakuten-theme.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/ie7.css">
    <![endif]-->
    <title><?= CHtml::encode(Yii::t('Seo', (($this->action->id == 'page') ? $_GET['view'] : $this->action->id) . '_title')); ?></title>
    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?= Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>

    <script>var baseUrl = '<?= Yii::app()->baseUrl; ?>';</script>
    <script>var baseImageUrl = '<?= Yii::app()->params["baseImageUrl"]; ?>';</script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/main.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/jquery/jquery.alert.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/text.js"></script>
    <style type="text/css">

    </style>
</head>
<body class="outer-body scale-1200">
<div id="header">
    <a href="<?= Yii::app()->request->baseUrl; ?>/site/index"><img
            src="<?= Yii::app()->request->baseUrl; ?>/images/logo.png"/></a>

    <div id="user-inner-info">
        <div class="up">
            <a href="<?= Yii::app()->request->baseUrl; ?>/site/support">
                <?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home_mail.png'), '', array('height' => '54px')); ?>
            </a>
            <?= CHtml::image(CHtml::normalizeUrl(Yii::app()->request->baseUrl . '/images/home_call.png'), '', array('height' => '54px')); ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <?= $this->renderPartial('/common/_userInfo'); ?>
    <ul class="nav nav-tabs">
        <li<?php if ($actionId == 'index')
            echo ' class="active"';
        ?>><?= CHtml::link('ホーム', array('/site')); ?></li>
        <li<?php if ($actionId == 'product')
            echo ' class="active"';
        ?>><?= CHtml::link('プロダクト', array('/site/product')); ?></li>
        <li<?php if ($actionId == 'guide')
            echo ' class="active"';
        ?>><?= CHtml::link('利用ガイド', array('/site/guide')); ?></li>
        <!--li<?php if ($actionId == 'item')
            echo ' class="active"';
        ?>><?= CHtml::link('ランキング', array('#')); ?></li!-->
        <li<?php if ($actionId == 'faq')
            echo ' class="active"';
        ?>><?= CHtml::link('FAQ', array('/site/faq')); ?></li>
        <li<?php if ($actionId == 'qbt')
            echo ' class="active"';
        ?>><?= CHtml::link('中国版紹介', array('/site/qbt')); ?></li>
        <li<?php if ($actionId == 'seo')
            echo ' class="active"';
        ?>>
            <?php if (Util::getUserId()) { ?>
                <?= CHtml::link('Enter', array('/stat/index'), array('target' => '_blank')); ?>
            <?php } else { ?>
                <?= CHtml::link('ログイン', '#', array('id' => 'login-trigger')); ?>
            <?php } ?>
        </li>
    </ul>

    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array('homeLink' => $this->homeLink, 'links' => $this->breadcrumbs)); ?>
    <?php endif ?>
    <?php if (isset($this->subNav)): ?>
        <p id="sub-nav"><?= $this->subNav; ?></p>
    <?php endif ?>
    <div class="site-<?= $actionId; ?>">
        <?= $content; ?>
        <?php if (Yii::app()->user->isGuest) echo $this->renderPartial('/common/_loginFormPop'); ?>
    </div>
</div>

<?php $this->renderPartial('/common/_footer', TRUE); ?>

<script>
    $('#login-trigger').on('click', function () {
        $('#login-form-popup').modal('show');
        return false;
    });
    $('#user-info').click(function () {
        $('#user-info-pop').toggle();
    });
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-54884083-1', 'auto');
    ga('send', 'pageview');

</script>
</body>

</html>

