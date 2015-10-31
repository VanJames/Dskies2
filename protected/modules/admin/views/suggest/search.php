<?php
$this->pageTitle = '推荐店铺列表';
$fieldsName = SuggestUtil::getAllFieldWithNames();
$adminMid = $this->adminUser->member->mid;
$count = count($statistics);
$allFields = array_keys($fieldsName);
$fieldToRank = array();
foreach ($allFields as $field) {
    $fieldToRank[$field] = SuggestUtil::getRankByField($shopId, $statistics, $field);
}
$simulateMid = Yii::app()->db->createCommand("SELECT mid FROM member m JOIN shop s ON s.name = m.name WHERE s.shop_id = $shopId LIMIT 1")->queryScalar();
?>

<div>
    <?= CHtml::beginForm('search', 'GET', array('id' => 'searchForm')) ?>
    请选择:<br/>
    <table style="border-style: none">
        <?php foreach ($allFields as $field): ?>
            <tr>
                <td style="width: 100px;"><?= CHtml::checkBox('', in_array($field, $fields), array('value' => $field, 'class' => 'showKPI')) ?></td>
                <td style="border-style: none"><?= $fieldsName[$field] ?></td>
                <td style="border-style: none"><?= round($fieldToRank[$field] / $count * 100); ?>%</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br/>
    <?= CHtml::button('检索', array('class' => 'btnRec', 'style' => 'width:80px', 'id' => 'refresh')); ?>
    <?= CHtml::button('关注', array('class' => 'btnRec', 'style' => 'width:80px', 'id' => 'notice')); ?>
    <?= CHtml::hiddenField('shopId', $shopId, array('id' => 'shopId')) ?>
    <?= CHtml::hiddenField('similarity', $similarity, array('id' => 'similarity')) ?>
    <?= CHtml::endForm() ?>
</div>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>店铺名</th>
            <th>客户详情</th>
            <th>乐天页面</th>
            <th>売上(千円)</th>
            <th>相似度</th>
            <th>推荐个数</th>
            <th colspan="2">关注</th>
            <?php foreach ($fields as $field): ?>
                <th class="<?= $field; ?>"><?php echo Util::addLineBreak($fieldsName[$field], 1, 'UTF-8'); ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($suggestShops as $shopId => $row): ?>
            <tr>
                <td><?php echo CHtml::link($row['title'], Yii::app()->request->baseUrl . "/admin/suggest/list?shopName=" . $row['name'], array('target' => '_blank')); ?></td>
                <td><?php echo CHtml::link($row['title'], Yii::app()->request->baseUrl . "/admin/client/detail?clientId=" . $row['clientId'], array('target' => '_blank')); ?></td>
                <td><?php echo CHtml::link($row['title'], Util::getShopUrl($row['name']), array('target' => '_blank')); ?></td>
                <td><?php echo Util::myNumberFormat($row['sales']); ?></td>
                <td><?php echo Util::myNumberFormat($row['similarity'], 2); ?></td>
                <td><?php echo $row['specialIndex']; ?></td>
                <td><?php echo CHtml::checkBox('watcher[]', false, array('value' => $adminMid . ':' . $row['shop_id'], 'title' => '销售')) . '销售' . '<br/>' . CHtml::checkBox('watcher[]', false, array('value' => $simulateMid . ':' . $row['shop_id'], 'disabled' => empty($simulateMid), 'title' => '客户')) . '客户'; ?></td>
                <td><?php echo CHtml::checkBox('shop[]', false, array('value' => $row['shop_id'], 'title' => '店铺')) . '店铺' . '<br/>' . CHtml::checkBox('marketing[]', false, array('value' => $row['shop_id'], 'title' => '广告')) . '广告'; ?></td>
                <?php foreach ($fields as $field): ?>
                    <td class="<?= $field; ?>"><?php echo $row['percent'][$field] ? ($row['percent'][$field] . '%') : ""; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $('#refresh').live('click', function () {
        var num = $('.showKPI:checked').length
        if (!num) {
            alert('请最少选择一项kpi')
        } else {
            var fields = [];
            var url = 'search?shopId=' + $('#shopId').val() + '&similarity=' + $('#similarity').val()
            $('.showKPI:checked').each(function () {
                url += '&fields[]=' + $(this).val()
            })

            window.location.href = url
        }
    })
    $('#notice').live('click', function () {
        var watchers = []
        $("input[name='watcher[]']:checked").each(function () {
            watchers.push($(this).val())
        })
        var sShops = []
        $("input[name='shop[]']:checked").each(function () {
            sShops.push($(this).val())
        })
        var mShops = []
        $("input[name='marketing[]']:checked").each(function () {
            mShops.push($(this).val())
        })
        if (!watchers.length || (!sShops.length && !mShops.length)) {
            alert('请检查选择项')
        } else {
            $.ajax({
                type: 'POST',
                url: 'notice',
                data: {
                    watchers: watchers,
                    sShops: sShops,
                    mShops: mShops
                },
                dataType: 'json',
                success: function (resp) {
                    if (resp.ok) {
                        alert(resp.msg)
                        //TODO How to mark noticed shops
                        location.reload()
                    }
                    else {
                        alert(resp.msg)
                    }
                }
            })
        }
    })
</script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>