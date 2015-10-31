<?php
class FitLowRSearchForm extends CFormModel
{
    public $date;
    public $minHeadR2;
    public $maxHeadR2;
    public $minTailR2;
    public $maxTailR2;

    public function attributeLabels()
    {
        return array(
            'date' => '月份',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
