<?php
$this->pageTitle = '店铺KPI';
$fieldWithNames = SuggestUtil::getAllFieldWithNames();
$count = count($statistics);
$showPercentArr = SuggestUtil::getShowPercentArr();
?>
<div class="center_main">
    <?= CHtml::beginForm('list', 'GET', array('id' => 'suggestForm')) ?>
    请输入:<br/>
    <table style="border-style: none">
        <tr>
            <th style="width: 100px;">目标店铺名</th>
            <td style="border-style: none"><?= CHtml::textField('shopName', $shop['name'], array('id' => 'shopName')) ?></td>
        </tr>
        <tr>
            <th style="width: 100px;">相似度</th>
            <td style="border-style: none"><?= CHtml::textField('similarity', $similarity, array('id' => 'similarity')) ?>
            </td>
        </tr>
    </table>
    <br/>
    <?= CHtml::submitButton('检索', array('class' => 'btnRec', 'style' => 'width:80px')) ?>
    <?= CHtml::hiddenField('shopId', $shop['shop_id'], array('id' => 'shopId')) ?>
    <?= CHtml::button('推荐店铺', array('class' => 'btn', 'id' => 'suggest')) ?>
    <?= CHtml::button('相似店铺', array('class' => 'btn', 'id' => 'similar')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="shop_title">
    <p>
        <?= $shop['title']; ?>
    </p>
</div>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>KPI</th>
            <th>数值</th>
            <th>排名</th>
            <th>百分比</th>
            <?php foreach ($showPercentArr as $percentName): ?>
                <th><?= $percentName ?></th>
            <?php endforeach; ?>
            <th><?= CHtml::checkBox('chk-all', false, array('id' => 'chk-all')) ?>选择</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($fieldToRank): ?>
            <?php foreach ($fieldToRank as $field => $rank): ?>
                <?php
                $className = ($key % 2) ? 'odd' : 'even';
                ?>
                <tr class="<?= $className; ?>">
                    <td><?= $fieldWithNames[$field]; ?></td>
                    <td><?= Util::myNumberFormat($shopStat[$field], in_array($field, array('month_percent_up', 'plan_max_up')) ? 3 : 0) . (($field == 'sales') ? '千円' : ''); ?></td>
                    <td><?= $rank . '/' . $count; ?></td>
                    <td><?= $count ? round($rank / $count * 100) : 0; ?>%</td>
                    <?php foreach (array_keys($showPercentArr) as $showPercent): ?>
                        <td><?= Util::myNumberFormat($showRankToValue[$field][$showPercent], in_array($field, array('month_percent_up', 'plan_max_up')) ? 3 : 0) . (($field == 'sales') ? '千円' : ''); ?></td>
                    <?php endforeach; ?>
                    <td><?= CHtml::checkBox("fields[]", false, array("class" => "chk-one", "id" => false, "value" => $field)); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var shopCorrect = <?= $shopCorrect ?>;
        if (!shopCorrect) {
            alert('请检查店铺名是否正确');
        }
    });
    $('#suggest').live('click', function () {
        var num = $('.chk-one:checked').length;
        if (!num) {
            alert('请最少选择一项kpi');
        } else {
            var fields = [];
            var url = 'search?shopId=' + $('#shopId').val() + '&similarity=' + $('#similarity').val();
            $('.chk-one:checked').each(function () {
                url += '&fields[]=' + $(this).val();
            });

            window.location.href = url
        }
    })
    $('#similar').live('click', function(){
        var shopId = $('#shopId').val();
        var url = 'similar?shopId=' + shopId + '&similarity=' + $('#similarity').val();
        if (!shopId) {
            var shopName = $('#shopName').val();
            if (!shopName) {
                alert('您没有选择一家店铺');
                return false;
            } else {
                url += '&shopName=' + $('#shopName').val();
            }
        }
        window.location.href = url
    })
    $('#chk-all').live('click', function () {
        if (this.checked) {
            $('.chk-one').each(function () {
                this.checked = true
            })
        } else {
            $('.chk-one').each(function () {
                this.checked = false
            })
        }
    })
</script>
<script src="<?= Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>
