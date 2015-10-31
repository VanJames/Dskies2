<?php
class FitErrorStatForm extends CFormModel
{
    public $date;
    public $mode;
    public $type;
    public $minMiu;
    public $maxMiu;
    public $minSigma;
    public $maxSigma;
    public $minSales;
    public $maxSales;

    public function attributeLabels()
    {
        return array(
            'date' => '日期',
            'mode' => '模式',
            'type' => '类型',
            'miu' => 'μ',
            'sigma' => 'σ',
            'sales' => '销售额',
        );
    }

    public function numberAttributes()
    {
        return array(
            'miu',
            'sigma',
            'sales',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
