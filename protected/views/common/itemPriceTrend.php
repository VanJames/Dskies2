<?php $this->renderPartial('/common/_menu', array('submenu' => $submenu)); ?>
<!-- form -->
<?php $this->renderPartial('/common/_alert', array('form' => $form)); ?>
<?php echo CHtml::form(array('/' . $this->id . '/itemPriceTrend', 'id' => $id, 'itemCode' => $itemCode, 'catalogId' => $catalogId), 'get', array('class' => 'form-inline')); ?>

<?php $this->renderPartial('/common/_formBetweenTime', array('form' => $form)); ?>
<div class="row">
    <label><?php echo Yii::t('Shop', 'Report Mode'); ?></label> <span
        class="radio"><?php echo CHtml::activeRadioButtonList($form, 'mode', $form->getModeDataList(), array('separator' => false, 'class' => 'form-control')); ?>
    </span>
</div>
<div class="row">
    <button type="submit" class="btn btn-primary">
        <?php echo Util::t('btn_submit'); ?>
    </button>
</div>
<?php echo CHtml::endForm(); ?>
<p class="text-right button-group">
    <!--hideCsv<button type="button" class="btn csv-dl-button"></button>-->
</p>
<?php $ids = Util::getTipIds('/common/_itemPriceTrendChart'); ?>
<?php $tips = Util::fetchTips($ids); ?>
<?php if ($form->mode == 'chart'): ?>
    <?php $this->renderPartial('/common/_itemPriceTrendChart', array('table_head' => $table_head, 'data' => $data)); ?>
<?php else: ?>
    <?php $this->renderPartial('/common/_itemPriceTrendReport', array('table_head' => $table_head, 'data' => $data,'tips' => $tips)); ?>
<?php endif; ?>