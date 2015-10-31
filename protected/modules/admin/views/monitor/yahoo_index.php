<?php
$num_labels = array(
    'ranking_category_num' => 'Ranking类目数',
    'check_category_num' => 'Check.Ranking类目数',
    'ranking_item_num' => 'Ranking总条目数',
    'check_item_num' => 'Check.Ranking条目数',
    'inventory_num' => '库存点数',
    'inventory_available_num' => '有效库存点数',
    'inventory_total_sales' => '库存总销售额',
    'inventory_average_sales' => '库存平均销售额',
    'trade_num' => '交易数',
    'trade_amount' => '交易金额',
);
function dyeRedForLimit($key, $value) {
    if ($key == 'rakuten_mail' && $value <= 5) {
        return true;
    }
    if ($key == 'shop_mail' && $value <= 200) {
        return true;
    }
    if ($key == 'ranking_err_num' && $value > 0) {
        return true;
    }
    if ($key == 'trade_page_full_num' && $value >= 30) {
        return true;
    }
    if ($key == 'inventory_item_count' && $value <= 10000) {
        return true;
    }
    if ($key == 'inventory_effective_count' && $value <= 5000) {
        return true;
    }
    return false;
}

function dyeRedForCompare($value1, $value2) {
    return $value1 != $value2;
}

function dyeRedForRelativeDiff($value1, $value2) {
    return ($value1 && (($value1 - $value2) / $value1 > 0.05));
}

?>
<br/>
<span>
    <?php $this->datePicker('blablabla', $data['date'][0], array('class' => 'txt1', 'style' => 'width: 120px'), $format = 'yy-mm-dd') ?>
</span>
<button id="date_choose" type="button" class="btnRec" style="width:60px">检索</button>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>项目</th>
            <?php if($data['date']) :?>
                <?php foreach ($data['date'] as $date): ?>
                    <th><?php echo $date ?></th>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        <?php foreach ($num_labels as $key => $label): ?>
            <?php $className = ($i++ % 2) ? 'odd' : 'even'; ?>
            <tr class="<?php echo $className; ?>">
                <td style="text-align: center"><?php echo $label ?></td>
                <?php if ($data[$key]):?>
                <?php foreach ($data[$key] as $day => $value): ?>
                    <?php if (dyeRedForLimit($key, $value)): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php elseif (in_array($key, array('ranking_category_num', 'check_category_num')) && dyeRedForCompare($data['ranking_category_num'][$day], $data['check_category_num'][$day])): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php elseif (in_array($key, array('ranking_item_num', 'check_item_num')) && dyeRedForCompare($data['ranking_category_num'][$day], $data['check_category_num'][$day])): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php elseif (in_array($key, array('ads_snap_num', 'ads_snap_ok_num')) && dyeRedForRelativeDiff($data['ads_snap_num'][$day], $data['ads_snap_ok_num'][$day])): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php elseif (in_array($key, array('ads_snap_num_real', 'ads_snap_ok_num_real')) && dyeRedForRelativeDiff($data['ads_snap_num_real'][$day], $data['ads_snap_ok_num_real'][$day])): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php
                    else: ?>
                        <td style="text-align: right"><?php echo number_format($value) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php endif;?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.scroll.js"></script>
<script>
    $("#date_choose").click(function () {
        var date = $("#blablabla").val();
        location.href = '<?= CHtml::normalizeUrl(array("monitor/yahooIndex")) ?>' + '?date=' + date;
    });

</script>