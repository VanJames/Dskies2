<?php $this->renderPartial('/common/_menu', array('submenu'=>$submenu)); ?>
<!-- form -->
<?php $this->renderPartial('/common/_alert', array('form'=>$form)); ?>
<?php
$url = array('/' . $this->id . '/itemRankTrend',);
if ($id) {
    $url['id'] = $id;
}
if ($itemCode) {
    $url['itemCode'] = $itemCode;
}
if ($catalogId) {
    $url['catalogId'] = $catalogId;
}
?>
<?php echo CHtml::form($url,'GET',array('class'=>'form-inline')); ?>

<?php $this->renderPartial('/common/_formBetweenTime', array('form' => $form)); ?>

<div class="row">
	<button type="submit" class="btn btn-primary">
		<?php echo Util::t('btn_submit'); ?>
	</button>

</div>
<?php echo CHtml::endForm(); ?>
<p class="text-right button-group">
    <!--hideCsv<button type="button" class="btn csv-dl-button"></button>-->
</p>
<?php $ids = Util::getTipIds('/common/_itemRankTrendReport'); ?>
<?php $tips = Util::fetchTips($ids); ?>
<?php if ($form->mode == 'chart'): ?>
<?php $this->renderPartial('/common/_itemRankTrendReport', array('cids_name'=>$cids_name,'data_info'=>$data_info)); ?>
<?php else: ?>
<?php $this->renderPartial('/common/_itemRankTrendReport', array('cids_name'=>$cids_name,'data_info'=>$data_info,'tips' => $tips)); ?>
<?php endif; ?>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/question-mark.js"></script>