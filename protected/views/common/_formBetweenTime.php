<div class="row">

    <label><?php echo Util::t('Time'); ?></label>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $form,
        'attribute' => 'startTime',
        'language' => Yii::app()->language,
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'minDate' => MyAuthUtil::getEarliestDateTime(),
            'maxDate' => '0 d',
        ),
        'htmlOptions' => array(
            'size' => '10',
            'maxlength' => '10',
            'class' => 'form-control',
        ),
    ));
    ?>
    ~
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $form,
        'attribute' => 'endTime',
        'language' => Yii::app()->language,
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'minDate' => MyAuthUtil::getEarliestDateTime(),
            'maxDate' => '0 d',
        ),
        'htmlOptions' => array(
            'size' => '10',
            'maxlength' => '10',
            'class' => 'form-control',
        ),
    ));
    ?>

</div>