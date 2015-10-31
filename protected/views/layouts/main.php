<?php $ctrlId = $this->ctrlId; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="<?= $this->createUrl('/favicon.ico'); ?>"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/rakuten-theme.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?= Yii::app()->params['baseImageUrl']; ?>/css/ie7.css">
    <![endif]-->
    <title><?= Util::getTitle($ctrlId) ?></title>
    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?= Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts-more.js"></script>

    <script>var baseUrl = '<?= Yii::app()->baseUrl; ?>';</script>
    <script>var baseImageUrl = '<?= Yii::app()->params["baseImageUrl"]; ?>';</script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/main.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/jquery/jquery.alert.js"></script>
    <script src="<?= Yii::app()->params['baseImageUrl']; ?>/js/text.js"></script>
</head>
<body>
<div id="header">
    <a href="<?= Yii::app()->request->baseUrl; ?>/site/index"><img
            src="<?= Yii::app()->request->baseUrl; ?>/images/logo.png"/></a>

    <div id="user-inner-info">
        <div class="up">
            <?php $level = Yii::app()->user->member->vip_level; ?>
            <?php if ($level > 0): ?>
                <img src="<?= Yii::app()->request->baseUrl; ?>/images/level/<?= $level ?>.png"/>
            <?php endif; ?>
            <span><?= Yii::app()->user->member->name; ?>(<?= Yii::app()->user->role->description; ?>
                )</span>
                    <span class="emial-wrap">
                    <a id="letter" href="<?= Yii::app()->request->baseUrl; ?>/personal/letter">
                        <?php
                        $numLetterNum = Yii::app()->user->member->member_message->newLetterNum;
                        if ($numLetterNum) {
                            echo "<em id='email-tips'>" . $numLetterNum . "</em>";
                            echo "<img class='va-top' src='" . Yii::app()->request->baseUrl . "/images/email_active.gif' />";
                        } else {
                            echo "<img class='va-top' src='" . Yii::app()->request->baseUrl . "/images/email.png' />";
                        }
                        ?>
                    </a>
                    </span>&nbsp;&nbsp;&nbsp;
            <span>利用期限&nbsp;&nbsp;&nbsp;<?= date('Y-m-d', strtotime(Yii::app()->user->member->expire_time)); ?></span>&nbsp;&nbsp;&nbsp;<a
                id="logout" href="<?= Yii::app()->request->baseUrl; ?>/site/logout"><img
                    src="<?= Yii::app()->request->baseUrl; ?>/images/logout.png"/></a></div>
        <div class="down color-white">
            <?php
            $db = Yii::app()->db;
            $mid = Util::getUserId();
            $requests = $db->createCommand("SELECT * FROM recommand WHERE mid = $mid")->queryRow();
            if (Yii::app()->user->role->name == 'TrialMember' && $requests) { ?>
                <a href="<?= Yii::app()->request->baseUrl; ?>/personal/recommand">お薦め購入内容</a><span
                    class="seperate"></span>
            <?php } ?>

            <a href="<?= Yii::app()->request->baseUrl; ?>/personal/invite">友人招待</a><span class="seperate"></span>
            <a href="<?= Yii::app()->request->baseUrl; ?>/personal/buy1">見積書作成</a><span class="seperate"></span>
            <?php if (PersonalUtil::canAppendOrder($mid)): ?>
                <a href="<?= Yii::app()->request->baseUrl; ?>/personal/add1">追加購入</a><span class="seperate"></span>
            <?php endif; ?>
            <a href="<?= Yii::app()->request->baseUrl; ?>/personal/priceList" target="_blank">価格表</a><span
                class="seperate"></span>
            <a href="<?= Yii::app()->request->baseUrl; ?>/site/faq" target="_blank">FAQ</a><span
                class="seperate"></span>
            <a href="<?= Yii::app()->request->baseUrl; ?>/site/guide" target="_blank">利用ガイド</a>
        </div>
    </div>
    <?php if (Yii::app()->user->limitDate && Yii::app()->user->limitDate < date('Y-m-d', strtotime("+7 day"))): ?>
        <div id="deadline-hint">
            次回お支払い期限は（<?= date('Y/m/d', strtotime(Yii::app()->user->limitDate)); ?>）となります。
        </div>
    <?php endif; ?>
</div>
<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li<?php
        if ($ctrlId == 'stat')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_stat'), array('/stat')); ?></li>
        <li<?php
        if ($ctrlId == 'shop')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_shop'), array('/shop')); ?></li>
        <li<?php
        if ($ctrlId == 'item')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_item'), array('/item')); ?></li>
        <li<?php
        if ($ctrlId == 'hit')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_hit'), array('/hit')); ?></li>
        <li<?php
        if ($ctrlId == 'marketing')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_marketing'), array('/marketing')); ?></li>
        <li<?php
        if ($ctrlId == 'word')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_word'), array('/word')); ?></li>
        <?php if(Yii::app()->user->role->name == 'ServicePackAdmin' || Yii::app()->user->role->name == 'ServicePackSuperAdmin'): ?>
        <li<?php
        if ($ctrlId == 'brand')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_brand'), array('/brand')); ?></li>
        <?php endif; ?>
        <li<?php
        if ($ctrlId == 'edc')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_edc'), array('/edc')); ?></li>
        <!--                <li<?php
        if ($ctrlId == 'search')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_search'), array('/search')); ?></li>
                                <li<?php
        if ($ctrlId == 'seo')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_seo'), array('/seo')); ?></li>-->
        <li<?php
        if ($ctrlId == 'personal')
            echo ' class="active"';
        ?>><?= CHtml::link(Util::t('nav_personal'), array('/personal')); ?></li>
        <li<?php
        if ($ctrlId == 'news')
            echo ' class="active"';
        ?>><?php //echo CHtml::link(Util::t('nav_news'), array('/news')); ?></li>
    </ul>
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array('homeLink' => $this->homeLink, 'links' => $this->breadcrumbs)); ?>
    <?php endif ?>
    <div id="content" class="<?= $ctrlId; ?> clearfix">
        <?= $content; ?>
    </div>

    <?php
    $introductionUrl = DBUtil::getActionUrl("/" . Yii::app()->controller->id . "/" . $this->getAction()->getId(), $this->getIntroId());
    $solutions = DBUtil::getActionSolution();
    $introductions = DBUtil::getActionIntroduction();
    ?>
    <?php if ($introductionUrl || ($solutions && count($solutions) > 0) || ($introductions && count($introductions) > 0)): ?>
        <div class="section inner-helper">
            <div class="section-head-type2"><span style="margin-left: 15px;">Nintをもっと詳しく知るために</span></div>
            <div class="section-body-type3 ">
                <ul class="clearfix">
                    <li class="col-lg-6 border-right">
                        <?php
                        if (Yii::app()->controller->id == "stat")
                            $icid = 1;
                        elseif (Yii::app()->controller->id == "shop")
                            $icid = 2;
                        elseif (Yii::app()->controller->id == "item")
                            $icid = 3;
                        elseif (Yii::app()->controller->id == "marketing")
                            $icid = 4;
                        elseif (Yii::app()->controller->id == "word")
                            $icid = 5;
                        if ($icid) {
                            $videoUrl = DBUtil::getVideo($icid);
                            ?>
                            <dl>
                                <dt>基本操作</dt>
                                <dd>
                                    <div class="lbox"><a href="#" class='vidio-trigger red underline fz-14'
                                                         data-url='<?= $videoUrl ?>'>初心者必見ビデオ</a></div>
                                </dd>
                            </dl>
                        <?php } ?>
                        <?php
                        if ($introductionUrl) { ?>
                            <dl>
                                <dt>画面説明</dt>
                                <dd><a class="underline fz-14" href="<?= $introductionUrl; ?>"
                                       target="_blank">画面詳細説明</a>
                                </dd>
                            </dl>
                        <?php } ?>

                        <?php
                        if ($solutions && count($solutions) > 0) { ?>
                            <!--dl>
                                    <dt>ソリューション</dt>
                                    <?php foreach ($solutions as $solution) {
                                $url = Yii::app()->request->baseUrl . "/site/guide?page=" . $solution['cid'] . "&intro_id=" . $solution['intro_id'];
                                ?>
                                    <dd><a class="underline fz-14" href="<?= $url ?>" target="_blank"><?= $solution['title'] ?></a></dd>
                                    <?php } ?>
                                </dl!-->
                        <?php } ?>

                    </li>
                    <li class="col-lg-6">
                        <?php
                        if ($introductions && count($introductions) > 0) { ?>
                            <dl>
                                <dt>利用ガイド</dt>
                                <?php foreach ($introductions as $introduction) {
                                    $url = Yii::app()->request->baseUrl . "/site/guide?page=" . $introduction['cid'] . "&intro_id=" . $introduction['intro_id'];
                                    ?>
                                    <dd><a class="underline fz-14" href="<?= $url ?>"
                                           target="_blank"><?= $introduction['title'] ?></a></dd>
                                <?php } ?>
                            </dl>
                        <?php } ?>
                    </li>
                </ul>

            </div>
        </div>
    <?php endif; ?>

</div>

<?php $this->renderPartial('/common/_footer', TRUE); ?>
<?php $this->renderPartial('/common/_vidioFramePop'); ?>

</body>
</html>