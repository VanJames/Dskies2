<?php
class CrawlerSearchForm extends CFormModel
{
    public $minDate;
    public $maxDate;
    public $minHour;
    public $maxHour;
    
    public function __construct(){
        $this->minDate = date("Y-m-d");
        $this->maxDate = date("Y-m-d");
        $this->minHour = 0;
        $this->maxHour = 23;
    }

    public function attributeLabels()
    {
        return array(
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
