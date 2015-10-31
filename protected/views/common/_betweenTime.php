<div class="row">

    <label>
    <?php 
    	echo Util::t('Time');
    	$minDate = isset($minDate) ? $minDate : MyAuthUtil::getEarliestDateTime();
    ?>   </label>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'BetweenTime[start]',
        'value' => $betweenTime['start'],
        'language' => Yii::app()->language,
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'minDate' => $minDate,
            'maxDate'=>  '0 d',
        ),
        'htmlOptions' => array(
            'size' => '10',
            'maxlength' => '10',
            'class' => 'form-control',
        ),
    ));
    ?>
    <span id='fenge'>~</span>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'BetweenTime[end]',
        'value' => $betweenTime['end'],
        'language' => Yii::app()->language,
        'options' => array(
            'dateFormat' => 'yy-mm-dd',
            'minDate' =>  $minDate,
            'maxDate'=>  '0 d',
        ),
        'htmlOptions' => array(
            'size' => '10',
            'maxlength' => '10',
            'class' => 'form-control'
        ),
    ));
    ?>

</div>