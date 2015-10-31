<?php
class ClientDetailForm extends CFormModel
{
    public $security;
    public $mobile;
    public $phone;
    public $email;
    public $sales_status;
    public $phone_status;
    public $remark;
    public $sales_id;
    
    public function attributeLabels(){
        return array(
            
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
