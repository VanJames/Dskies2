<?php
$num_labels = array(
    'items_no_img' => '缺图宝贝数',
    'items_no_title' => '无名宝贝数',
    'items_no_review' => '缺评价宝贝数',
    'ranking_item_num' => '进榜宝贝数',
    'ranking_err_num' => '未爬全类目数',
    'estimate_count' => '参与估算宝贝数',
    'estimate_sales' => '估算销售额',
    'rakuten_mail' => '乐天邮件数',
    'shop_mail' => '店铺邮件数',
    //add 09.22
    'ranking_category_num' => 'Ranking类目数',
    'check_category_num' => 'Check.Ranking类目数',
    'cpc_word_num' => 'CPC关键词数',
    'cpc_ad_num' => 'CPC广告数',
    'ads_top_num' => '首页广告数',
    'ads_topevent_num' => 'T特广告数',
    'ads_category_num' => '类目广告数',
    'ads_event_num' => '特集广告数',
    'ads_asuraku_num' => '明日乐广告数',
    'ads_freeshipping_num' => '免邮广告数',
    'ads_regular_num' => '定期购广告数',
    'ads_product_num' => '产品广告数',
    'ads_ranking_num' => '排名广告数',
    'ads_m_event_num' => 'M特集广告数',
    'ads_m_category_num' => 'M类目广告数',
    'ads_m_top_num' => 'M首页广告数',
    'ads_snap_num' => '截图总数',
    'ads_snap_ok_num' => '截图成功数',
    'ads_snap_num_real' => '实际截图总数',
    'ads_snap_ok_num_real' => '实际截图成功数',
    'inventory_item_count' => '库存点数',
    'inventory_effective_count' => '有效库存点数',
    'inventory_sales' => '库存总销售额',
    'inventory_avg_sales' => '库存平均销售额',
    'trade_num' => '出价交易数',
    'trade_item_num' => '出价宝贝数',
    'trade_sales' => '出价总销售额',
    'trade_page_full_num' => '出价全新页面数',
    'track_price_num' => '调价数',
    'track_point_num' => '改Point数',
    'track_title_num' => '改名数',
    'track_new_item_num' => '新宝贝数',
    'track_rank_num' => '新入榜数',
);
$time_labels = array(
    'all_ranking_start' => '计算所有排名开始',
    'all_ranking_end' => '计算所有排名结束',
    'fit_start' => '计算拟合参数开始',
    'fit_end' => '计算拟合参数结束',
    'estimate_start' => '估算销售额开始',
    'estimate_end' => '估算销售额结束',
    'stat_shop_start' => '店铺统计开始',
    'stat_shop_end' => '店铺统计结束',
    'stat_category_start' => '类目统计开始',
    'stat_category_end' => '类目统计结束',
    'snapshot_start' => '快照开始',
    'snapshot_end' => '快照结束',
    'advertise_shop_start' => '计算飙量指数开始',
    'advertise_shop_end' => '计算飙量指数结束',
    'hot_item_start' => '更新热销宝贝开始',
    'hot_item_end' => '更新热销宝贝结束',
    'hot_shop_start' => '更新热销店铺开始',
    'hot_shop_end' => '更新热销店铺结束',
    'track_word_items_start' => '更新关键词宝贝开始',
    'track_word_items_end' => '更新关键字宝贝结束',
    'track_word_start' => '更新关键词开始',
    'track_word_end' => '更新关键词结束',
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
            <?php foreach ($data['date'] as $date): ?>
                <th><?php echo $date ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        <?php foreach ($num_labels as $key => $label): ?>
            <?php $className = ($i++ % 2) ? 'odd' : 'even'; ?>
            <tr class="<?php echo $className; ?>">
                <td style="text-align: center"><?php echo $label ?></td>
                <?php foreach ($data[$key] as $day => $value): ?>
                    <?php if (dyeRedForLimit($key, $value)): ?>
                        <td style="text-align: right; color: red"><?php echo number_format($value) ?></td>
                    <?php elseif (in_array($key, array('ranking_category_num', 'check_category_num')) && dyeRedForCompare($data['ranking_category_num'][$day], $data['check_category_num'][$day])): ?>
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
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>项目</th>
            <?php foreach ($data['date'] as $date): ?>
                <th><?php echo $date ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        <?php foreach ($time_labels as $key => $label): ?>
            <?php $className = ($i++ % 2 == 0) ? 'odd' : 'even'; ?>
            <tr class="<?php echo $className; ?>" style="text-align: center">
                <td><?php echo $label ?></td>
                <?php foreach ($data[$key] as $value): ?>
                    <td><?php echo $value; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery/jquery.scroll.js"></script>
<script>
    $("#date_choose").click(function () {
        var date = $("#blablabla").val();
        location.href = '<?= CHtml::normalizeUrl(array("monitor/index")) ?>' + '?date=' + date;
    });

</script>