<?php

class DatePickerBehavior extends CBehavior
{
    public function activeDatePicker($model, $attribute, $htmlOptions=array(), $format='yy-mm-dd')
    {
        $controller = $this->owner;        
        return $controller->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => $attribute,
            'language' => 'zh-CN',
            'options' => array(
        		'dateFormat'=>$format,
                'buttonImage' => $controller->createUrl('/image') . '/calendar.gif',
                'buttonImageOnly' => true,
                //'showOn' => 'both',
                'duration' => '',
            ),
            'htmlOptions' => $htmlOptions,
        ));
    }
    
	public function datePicker($name, $value, $htmlOptions=array(), $format='yy-mm-dd')
    {
        $controller = $this->owner;        
        return $controller->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => $name,
            'language' => 'zh-CN',
        	'value' =>$value,
            'options' => array(
        		'dateFormat'=>$format,
                'buttonImage' => $controller->createUrl('/image') . '/calendar.gif',
                'buttonImageOnly' => true,
                //'showOn' => 'both',
                'duration' => '',
            ),
            'htmlOptions' => $htmlOptions,
        ));
    }
}
