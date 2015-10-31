<?php
class FitErrorSearchForm extends CFormModel
{
    public $date;
    public $mode;
    public $type;
    public $name;
    public $minMiu;
    public $maxMiu;
    public $minSigma;
    public $maxSigma;
    public $minSales;
    public $maxSales;
    public $minError;
    public $maxError;

    public function attributeLabels()
    {
        return array(
            'date' => '日期',
            'mode' => '模式',
            'type' => '类型',
            'name' => '名称',
            'miu' => 'μ',
            'sigma' => 'σ',
            'sales' => '销售额',
            'error' => '误差',
        );
    }

    public function numberAttributes()
    {
        return array(
            'miu',
            'sigma',
            'sales',
            'error',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
