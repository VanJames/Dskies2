<?php
class StatBuySearchForm extends CFormModel
{   
    public $minMonth;
    public $maxMonth;
    public $sales_id;
    public $type;
    
    
    public function attributeLabels(){
        return array(
            
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
