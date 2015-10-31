<div class="center_main">
<?php echo CHtml::form(array(''), 'GET'); ?>
<table style="border-style: none">
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'date'); ?></th>
        <td style="border-style: none">
            <?php   
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $form,
                'attribute' => 'date',
                'language' => 'zh_cn',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'size' => '10',
                    'maxlength' => '10',
                    'class' => 'form-control',
                ),
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">样本数</th>
        <td style="border-style: none">
            <?php echo CHtml::activeTextField($form, 'minSamples', array('class' => 'txt1', 'style' => 'width: 101px')); ?>
            &nbsp;～&nbsp; 
            <?php echo CHtml::activeTextField($form, 'maxSamples', array('class' => 'txt1', 'style' => 'width: 102px')); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'type'); ?></th>
        <td style="border-style:none">
            <?php echo CHtml::activeDropDownList($form, 'type', 
                            array('fit' => '拟合', 'adjust' => '调整'), 
                            array('empty' => '全部', 'class' => 'txt1', 'style' => 'width: 230px')
            ); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">头部R^2</th>
        <td style="border-style: none">
            <?php echo CHtml::activeTextField($form, 'minHeadR2', array('class' => 'txt1', 'style' => 'width: 101px')); ?>
            &nbsp;～&nbsp; 
            <?php echo CHtml::activeTextField($form, 'maxHeadR2', array('class' => 'txt1', 'style' => 'width: 102px')); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold">尾部R^2</th>
        <td style="border-style: none">
            <?php echo CHtml::activeTextField($form, 'minTailR2', array('class' => 'txt1', 'style' => 'width: 101px')); ?>
            &nbsp;～&nbsp; 
            <?php echo CHtml::activeTextField($form, 'maxTailR2', array('class' => 'txt1', 'style' => 'width: 102px')); ?>
        </td>
    </tr>
</table>
<br />
<?php echo CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width: 80px')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<br />
<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th rowspan="2">cid</th>
            <th rowspan="2">名称</th>
            <th rowspan="2">级别</th>
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
                    <td style="text-align: center"><?php echo $value['cid']; ?></td>
                    <td><?php echo CHtml::link(CHtml::encode($value['name']), array('monitor/fitParameterDetail', 'cid' => $value['cid']), array('target' => '_blank')); ?></td>
                    <td style="text-align: center"><?php echo $value['level']; ?></td>
                    <td style="text-align: right"><?php echo number_format($value['samples']); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['parent_samples']); ?></td>
                    <td><?php if ($value["type"] == "fit"): ?>拟合<?php else: ?>调整<?php endif; ?>
                    <td>
                        <?php
                            $imgUrl = Yii::app()->baseUrl . "/images/figure/{$form->date}/{$value['cid']}_head.png";
                            echo CHtml::link(CHtml::image($imgUrl, '', array('width' => '300px', 'height' => '210px')), $imgUrl, array('target' => '_blank'));
                        ?>
                    </td>
                    <td style="text-align: right"><?php echo number_format($value['head_err'], 4); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['head_r2'], 4); ?></td>
                    <td style="text-align: right"><?php echo number_format($value['tail_samples']); ?></td>
                    <td>
                        <?php
                            if ($value['tail_err'] || $value['tail_r2']) {
                                $imgUrl = Yii::app()->baseUrl . "/images/figure/{$form->date}/{$value['cid']}_tail.png";
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
