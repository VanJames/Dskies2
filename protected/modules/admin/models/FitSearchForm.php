<?php
class FitSearchForm extends CFormModel
{
    public $date;
    public $minSamples;
    public $maxSamples;
    public $type;
    public $minHeadR2;
    public $maxHeadR2;
    public $minTailR2;
    public $maxTailR2;

    public function attributeLabels()
    {
        return array(
            'date' => '日期',
            'type' => '类型',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
