<?php

class MyAdminUser extends CWebUser {
    
    private $_member;
    private $_role;
	private $_crmAccess=array();
    
    
	public function init()
	{
		parent::init();
        
    }
    
    
    //you can use Yii::app()->user->member to access Member's model
    //if isGuest , then member is null
    public function getMember() {
        if($this->getId()===null)
            return null;
        if($this->_member===null){
            $this->_member = Member::model()->findByPk($this->getId());
        }
        return $this->_member;
    }
    
}

?>