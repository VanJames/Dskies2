<?php
$this->pageTitle = '销售额统计（销售向）';
$sales = Member::model()->findAll(array("condition" => "status=1 and is_sales=1"));
$monthRangeMin = Util::getMonthRangeMin();
$monthRangeMax = Util::getMonthRangeMax();
$monthRangeMin = array_reverse($monthRangeMin);
$monthRangeMax = array_reverse($monthRangeMax);

$fields = array(
    'order_num' => '当月订单数',
    'order_fee' => '当月订单金额',
    'valid' => '有效客户数',
    'first_fee' => '订单销售额（新）',
    'month_fee' => '订单销售额（旧）',
    'fee' => '当月销售额',
    'first' => '预计销售额（新）',
    'expected_month_fee' => '预计销售额（旧）',
    'expected_fee' => '预计销售额合计'
);

?>
<div class="center_main">
    <?= CHtml::beginForm(array(''), 'GET') ?>
    请输入检索条件:<br/>
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">销售</th>
            <?php
            $salesHash["-1"] = "不限";
            $salesHash = $salesHash + CHtml::listData($sales, 'mid', 'name');
            ?>
            <td style="border-style: none"><?= CHtml::activeDropDownList($form, 'sales_id', $salesHash, array('class' => 'txt1', 'style' => 'width: 240px')) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">期间选择</th>
            <td style="border-style: none">
                <?= CHtml::activeDropDownList($form, 'minMonth', $monthRangeMax, array('class' => 'txt1', 'style' => 'width: 110px')); ?>
                ~
                <?= CHtml::activeDropDownList($form, 'maxMonth', $monthRangeMax, array('class' => 'txt1', 'style' => 'width: 110px')); ?>
            </td>
        </tr>
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="center_main">
    <table style="border-style: none">
        <tr>
            <th></th>
            <?php foreach (array_keys($monthStat) as $month): ?>
                <th style="width: 100px;"><?= substr($month, 0, 7) ?></th>
            <?php endforeach; ?>
            <th style="width: 100px;">Total</th>
        </tr>
        <?php foreach ($fields as $k => $v): ?>
            <tr>
                <td style="width: 100px;" align="center"><?= $v ?></td>
                <?php foreach ($monthStat as $month => $stat): ?>
                    <td style="width: 100px;" align="center"><?= Util::myNumberFormat($stat[$k]) ?></td>
                <?php endforeach; ?>
                <td style="width: 100px;" align="center"><?= ($k == 'valid') ? '--' : Util::myNumberFormat($totalStat[$k]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
