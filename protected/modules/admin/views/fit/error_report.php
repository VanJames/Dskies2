<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th>项目</th>
            <?php foreach (array_keys($data) as $date): ?>
            <th><?php echo $date; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 0;
            $rowHeaders = array(
                'head_r2' => '头部R^2 < 0.5 数量',
                'tail_r2' => '尾部R^2 < 0.5 数量',
                'all' => '综合误差 >0.05 数量',
                'shop' => '店铺误差 > 0.2 数量',
                'item' => '宝贝误差 > 0.3 数量',
                'category' => '类目误差 > 0.05 数量',
            );
        ?>
        <?php foreach ($rowHeaders as $key => $label): ?>
        <?php $className = ($i++ % 2 == 0) ? 'odd' : 'even'; ?>
        <tr class="<?php echo $className; ?>">
            <td><?php echo CHtml::encode($label); ?></td>
            <?php foreach ($data as $date => $value): ?>
            <td style="text-align: right"><?php echo number_format($value[$key][0]); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        <?php
            $rowHeaders = array(
                'head_r2' => '头部R^2直方图',
                'tail_r2' => '尾部R^2直方图',
                'all' => '综合误差直方图',
                'shop' => '店铺误差直方图',
                'item' => '宝贝误差直方图',
                'category' => '类目误差直方图',
            );
        ?>
        <?php foreach ($rowHeaders as $key => $label): ?>
        <?php $className = ($i++ % 2 == 0) ? 'odd' : 'even'; ?>
        <tr class="<?php echo $className; ?>">
            <td><?php echo CHtml::encode($label); ?></td>
            <?php foreach ($data as $date => $value): ?>
            <td style="text-align: right"><div id="<?php echo "chart_{$key}_{$date}"; ?>" style="width: 250px; height: 250px"></div></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    <?php
        $count = count($intervals);
        for ($i = 0; $i < $count; $i++) {
            $categories[] = $intervals[$i];
        }
        $categories[] = ">={$intervals[$count - 1]}";
        $categories = json_encode($categories);
    ?>
    <?php foreach ($rowHeaders as $key => $label): ?>
    <?php foreach ($data as $date => $value): ?>
    <?php
        $series = array();
        foreach ($value[$key] as $v) {
            $series[] = (int)$v;
        }
        array_shift($series);
    ?>
    $('<?php echo "#chart_{$key}_{$date}"; ?>').highcharts({
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
            categories: <?php echo $categories ?>,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: null
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
    <?php endforeach; ?>
    <?php endforeach; ?>
});
</script>
</div>
