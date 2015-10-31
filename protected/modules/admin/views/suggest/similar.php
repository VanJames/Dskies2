<?php
/**
 * User: diaoshoujun
 * Date: 14/12/3
 * Time: 上午11:08
 */
$this->pageTitle = '相似店铺列表';
$fieldWithNames = SuggestUtil::getAllFieldWithNames();
$count = count($shopStats);
?>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>店铺名</th>
            <th>客户详情</th>
            <th>乐天页面</th>
            <th>売上(千円)</th>
            <th>相似度</th>
            <?php foreach ($fieldWithNames as $field => $name): ?>
                <th class="<?= $field; ?>"><?php echo Util::addLineBreak($name, 1, 'UTF-8'); ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($shopStats as $shopId => $row): ?>
            <tr>
                <td><?php echo CHtml::link($row['title'], Yii::app()->request->baseUrl . "/admin/suggest/list?shopName=" . $row['name'], array('target' => '_blank')); ?></td>
                <td><?php echo CHtml::link($row['title'], Yii::app()->request->baseUrl . "/admin/client/detail?clientId=" . $row['clientId'], array('target' => '_blank')); ?></td>
                <td><?php echo CHtml::link($row['title'], Util::getShopUrl($row['name']), array('target' => '_blank')); ?></td>
                <td><?php echo Util::myNumberFormat($row['sales']); ?></td>
                <td><?php echo Util::myNumberFormat($row['similarity'], 2); ?></td>
                <?php foreach ($fieldWithNames as $field => $name): ?>
                    <td class="<?= $field; ?>"><?php echo $row[$field] > $standardStat[$field] ? (round($row['fieldsRank'][$field] / $count * 100) . '%') : ""; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>