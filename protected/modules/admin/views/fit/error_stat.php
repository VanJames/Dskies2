<div class="center_main">
<?php echo CHtml::form(array(''), 'GET'); ?>
请输入误差统计条件:<br />
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
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'mode'); ?></th>
        <td style="border-style:none">
            <?php echo CHtml::activeRadioButtonList($form, 'mode', 
                            array('day' => '按日统计', 'month' => '按月统计'), 
                            array('class' => 'txt1', 'separator' => ' ', 'uncheckValue' => null)
            ); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 100px; text-align: center"><?php echo CHtml::activeLabel($form, 'type'); ?></th>
        <td style="border-style:none">
            <?php echo CHtml::activeDropDownList($form, 'type', 
                            array('all' => '综合', 'shop' => '店铺', 'item' => '商品', 'category' => '类目'), 
                            array('class' => 'txt1', 'style' => 'width: 230px')
            ); ?>
        </td>
    </tr>
    <?php foreach ($form->numberAttributes() as $attribute): ?>
    <tr>
        <th style="width: 100px; text-align: center; font-weight: bold"><?php echo CHtml::encode($form->getAttributeLabel($attribute)); ?></th>
        <td style="border-style: none">
            <?php echo CHtml::activeTextField($form, 'min' . ucfirst($attribute), array('class' => 'txt1', 'style' => 'width: 101px')); ?>
            &nbsp;～&nbsp; 
            <?php echo CHtml::activeTextField($form, 'max' . ucfirst($attribute), array('class' => 'txt1', 'style' => 'width: 102px')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<br />
<?php echo CHtml::submitButton('提交', array('class' => 'btnRec', 'style' => 'width: 80px')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<br />
<div class="grid-view" style="width: 300px">
<table class="items">
    <thead>
        <tr>
            <th>误差范围</th>
            <th>数量</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = count($intervals) ?>
        <?php for ($i = 0; $i <= $count; $i++): ?>
        <?php $className = ($i % 2 == 0) ? 'odd' : 'even'; ?>
        <?php $categories[] = $i == $count ? ">={$intervals[$i - 1]}" : $intervals[$i]; ?>
        <?php $series[] = (int)$data[$i] ?>
        <tr class="<?php echo $className; ?>">
            <td><?php echo $i == 0 ? "[0, {$intervals[$i]})" : ($i == $count ? "[{$intervals[$i - 1]}, +∞)": "[{$intervals[$i - 1]}, {$intervals[$i]})"); ?></td>
            <td style="text-align: right"><?php echo number_format($data[$i]); ?></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>
</div>
<br />
<div id="chart" style="width: 500px"></div>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#chart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories: <?php echo json_encode($categories) ?>,
            title: {
                text: '误差'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '数量'
            }
        },
        tooltip: {
            formatter: function() {
                return Highcharts.numberFormat(this.y, 0);
            }
        },
        series: [{
            data: <?php echo json_encode($series); ?>
        }]
    });
});
</script>
