<?php $actionId = $this->actionId; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>データの精度確認</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" media="all and (orientation:portrait)" href="portrait.css">
    <link rel="stylesheet" media="all and (orientation:landscape)" href="landscape.css">

    <link rel="shortcut icon" href="<?= $this->createUrl('/favicon.ico'); ?>"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/rakuten-theme.css"/>
    <script src="<?= Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>

    <script>var baseUrl = '<?= Yii::app()->baseUrl; ?>';</script>
    <script>var baseImageUrl = '<?= Yii::app()->params["baseImageUrl"]; ?>';</script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/main.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/jquery/jquery.alert.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/text.js"></script>
    <style type="text/css">
        #header-mobile {
            width: auto;
        }
        #header-mobile a{
            width: auto;
        }
        #footer-mobile{
            height: 72px;
            width: 320px;
            line-height: 72px;
            font-size: 12px;
            text-align: right;
            border-top: 1px solid #edefef;
            background: url('http://static.nint.jp/images/logo-mini.png') no-repeat 5% 50% #f3feff;
            margin-top: 10px;
        }
        body {
            width: 100%;
            min-width: 320px;
        }
        .scale-320{
            width: 320px;
            margin: 0 auto;
            min-height: 480px;
        }
    </style>
</head>
<body class="outer-body scale-320">
<div id="header-mobile">
    <a href="<?= Yii::app()->request->baseUrl; ?>/site/index"><img
            src="<?= Yii::app()->request->baseUrl; ?>/images/logo_mobile.jpg" width="100%"/></a>
</div>
<div class="container-fluid">
    <div class="site-<?= $actionId; ?>">
        <?= $content; ?>
    </div>
</div>

<div id="footer-mobile"></div>

<script>
    $('#login-trigger').on('click', function () {
        $('#login-form-popup').modal('show');
        return false;
    });
    $('#user-info').click(function () {
        $('#user-info-pop').toggle();
    });
</script>
</body>

</html>