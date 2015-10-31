<?php
class ClientLogForm extends CFormModel
{
    public $client_id;
    public $date;
    public $sales_id;
    public $status;
    public $sales_action;
    public $remark;
    public $minDate;
    public $maxDate;
    
    
    public function attributeLabels(){
        return array(
            
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
