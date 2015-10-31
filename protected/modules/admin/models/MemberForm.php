<?php
class MemberForm extends CFormModel
{
    public $hasTrailTask;
    public $trailDays;
    public $noticeShopNumLimit;
    public $itemNumLimit;
    public $analysisShopNumLimit;
    public $hitNumLimit;
    public $edcNumLimit;
    public $categorys;

    public function attributeLabels(){
        return array(
            
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
