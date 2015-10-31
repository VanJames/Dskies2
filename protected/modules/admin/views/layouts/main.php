<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/rakuten-theme.css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/gridview/styles.css"/>
        <title>nint后台管理 - <?= $this->pageTitle ?></title>

    </head>
    <body>
        <div id="lyOuter" class="outer clearfix">
            <div id="lySide" class="side">
                <div class="side_header">
                    <div class="side_logo">
                        <?=
                        CHtml::link(
                                CHtml::image(Yii::app()->request->baseUrl . '/images/icon/chart-icon.png', '', array('style' => 'width: 100px; height: 50px')), array('default/index')
                        )
                        ?>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="side_menu">
                            <h3><?= CHtml::link('数据一览', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('客户列表', array('client/list')) ?></li>
                                    <li><?= CHtml::link('订单列表', array('client/buyList')) ?></li>
                                    <li><?= CHtml::link('请求列表', array('client/requestList')) ?></li>
                                    <li><?= CHtml::link('问题列表', array('client/supportList')) ?></li>
									<li><?= CHtml::link('销售列表', array('client/saleList')) ?></li>
                                    <li><?= CHtml::link('销售日志统计', array('client/clientLogStat')) ?></li>
									<li><?= CHtml::link('创建账号', array('client/create')) ?></li>
									<li><?= CHtml::link('店铺推荐', array('suggest/list')) ?></li>
									<li><?= CHtml::link('店铺推荐2', array('suggest/similar2')) ?></li>
									<li><?= CHtml::link('成长店铺', array('suggest/similar3')) ?></li>
                                    <li><?= CHtml::link('销售额统计 ', array('client/statBuy')) ?></li>
                                    <li><?= CHtml::link('レコメンド作成', array('client/recommand')) ?></li>
                                    <li><?= CHtml::link('销售额统计（销售向）', array('client/statBuySales')) ?></li>
                                </ul>
                            </div>
                        </div>
        <?php if ($this->module->adminUser->checkAccess('Developer')): ?> 
                        <div class="side_menu">
                            <h3><?= CHtml::link('系统监控', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('系统监控', array('monitor/index')) ?></li>
                                    <li><?= CHtml::link('Yahoo!系统监控', array('monitor/yahooIndex')) ?></li>
                                    <li><?= CHtml::link('乐天爬虫统计', array('monitor/statSpiderRakuten')) ?></li>
                                    <li><?= CHtml::link('爬虫统计', array('monitor/statCrawler')) ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="side_menu">
                            <h3><?= CHtml::link('拟合', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('问题参数列表', array('fit/parameterListLowR')) ?></li>
                                    <li><?= CHtml::link('参数列表', array('fit/parameterList')) ?></li>
                                    <li><?= CHtml::link('误差列表', array('fit/errorList')) ?></li>
                                    <li><?= CHtml::link('误差统计', array('fit/errorStat')) ?></li>
                                    <li><?= CHtml::link('误差报表', array('fit/errorReport')) ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="side_menu">
                            <h3><?= CHtml::link('拟合2', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('问题参数列表', array('fit2/parameterListLowR')) ?></li>
                                    <li><?= CHtml::link('参数列表', array('fit2/parameterList')) ?></li>
                                    <li><?= CHtml::link('误差列表', array('fit2/errorList')) ?></li>
                                    <li><?= CHtml::link('误差统计', array('fit2/errorStat')) ?></li>
                                    <li><?= CHtml::link('误差报表', array('fit2/errorReport')) ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="side_menu">
                            <h3><?= CHtml::link('拟合3', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('问题参数列表', array('fit3/parameterListLowR')) ?></li>
                                    <li><?= CHtml::link('参数列表', array('fit3/parameterList')) ?></li>
                                    <li><?= CHtml::link('误差列表', array('fit3/errorList')) ?></li>
                                    <li><?= CHtml::link('误差统计', array('fit3/errorStat')) ?></li>
                                    <li><?= CHtml::link('误差报表', array('fit3/errorReport')) ?></li>
                                </ul>
                            </div>
                        </div>
        <?php endif; ?> 
                        <div class="side_menu">
                            <h3><?= CHtml::link('个人', '#', array('style' => 'color: #000000')) ?></h3>
                            <div>
                                <ul>
                                    <li><?= CHtml::link('个人设置', array('client/editMember?mid='.$this->adminUser->member->mid)) ?></li>
                                    <!-- <li><?= CHtml::link('首页', array('default/index')) ?></li>-->
                                    <li><?= CHtml::link('退出', array('site/logout')) ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lyCenterOuter" class="center">
                <div id="lyCenter" class="center">
                    <div class="center_header">
                        <div class="center_spc">
                            你好！<strong><span><?= Yii::app()->controller->module->adminUser->member->name ?></span></strong> <br />
                            欢迎使用nint管理系统
                        </div>
                    </div>
                    <div>
                        <div class="center_title">
                            <div style="color: red; font-weight: bold; font-size: large;">
                                <?= $this->pageTitle ?>
                            </div>
                        </div>
                        <?= $content; ?>
                    </div>
                    <div class="center_footer"></div>
                </div>
            </div>
        </div>
    </body>
</html>
