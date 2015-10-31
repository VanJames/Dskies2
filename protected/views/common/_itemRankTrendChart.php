<?php if ($data): ?>
<?php 
$x = array();
$y = array();
foreach ($data as $value){
    $format = ($type == 'month') ? 'Y-m' : 'Y-m-d';
    $date = Util::getDateTime(Util::getTimestamp($value['date']), $format);
    $x[] = $date;
    $y[] = $value['hot_items'];
}
$dataX = implode(',', $x);
$dataY = implode(',', $y);
$dataUrl = CHtml::normalizeUrl(array('/shop/trendDetail/'.$id, 'type'=>$type));
?>
<div id="chart" data-x="<?php echo $dataX; ?>" data-y="<?php echo $dataY; ?>" data-url="<?php echo $dataUrl; ?>"></div>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/shop/trend.js"></script>
<?php else: ?>
<?php echo Util::t('No Data'); ?>
<?php endif; ?>