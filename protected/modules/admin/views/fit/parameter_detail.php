<div class="center_main">
<table style="border-style: none">
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">cid</th>
        <td style="width: 100px; text-align: right; border-style: none"><?php echo $cat['cid']; ?></td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">名称</th>
        <td style="width: 100px; text-align: right; border-style: none"><?php echo CHtml::encode($cat['name']); ?></td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">级别</th>
        <td style="width: 100px; text-align: right; border-style: none"><?php echo $cat['level']; ?></td>
    </tr>
</table>
<br />
</div>
<br />
<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th rowspan="2">日期</th>
            <th rowspan="2">样本数</th>
            <th rowspan="2">父类样本数</th>
            <th rowspan="2">类型</th>
            <th colspan="3">头部</th>
            <th colspan="4">尾部</th>
        </tr>
        <tr>
            <th>图</th>
            <th>err</th>
            <th>R^2</th>
            <th>样本数</th>
            <th>图</th>
            <th>err</th>
            <th>R^2</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $key => $value): ?>
                <?php $className = ($key % 2 == 0) ? 'odd' : 'even'; ?>
                <tr class="<?php echo $className; ?>">
                    <td><?php echo $value['date']; ?></td>
                    <td style="text-align: right"><?php echo number_format($value['samples']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['parent_samples']); ?></td>
                    <td><?php if ($value["type"] == "fit"): ?>拟合<?php else: ?>调整<?php endif; ?>
                    <td>
                        <?php
                            $imgUrl = Yii::app()->baseUrl . "/images/figure/{$value['date']}/{$cat['cid']}_head.png";
                            echo CHtml::link(CHtml::image($imgUrl, '', array('width' => '300px', 'height' => '210px')), $imgUrl, array('target' => '_blank'));
                        ?>
                    </td>
                    <td style="text-align: right"><?php echo number_format($value['head_err'], 4); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['head_r2'], 4); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['tail_samples']); ?></td>
                    <td>
                        <?php
                            if ($value['tail_err'] || $value['tail_r2']) {
                                $imgUrl = Yii::app()->baseUrl . "/images/figure/{$value['date']}/{$cat['cid']}_tail.png";
                                echo CHtml::link(CHtml::image($imgUrl, '', array('width' => '300px', 'height' => '210px')), $imgUrl, array('target' => '_blank'));
                            } else {
                                echo '无';
                            }
                        ?>
                    </td>
                    <td style="text-align: right"><?php echo number_format($value['tail_err'], 4); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['tail_r2'], 4); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="13">没有数据</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
