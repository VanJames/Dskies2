<?php

class MyWebUser extends CWebUser {
    private $_member;
    private $_role;
    private $_limitDate;
    
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

    //you can use Yii::app()->user->role to access Member's Role model
    //if no member , then role is null
    //if no ServicePack role, then role is null
    public function getRole() {
        if($this->getMember()===null)
            return null;
        if($this->_role===null){
            $assign = AuthAssignment::model()->with('auth_item')->find(array(
                'condition' => "t.userid=:userid and auth_item.type=:role_type",
                'params'    => array(":userid"=>$this->member->mid,":role_type"=>CAuthItem::TYPE_ROLE),
            ));
            if(isset($assign) && isset($assign->auth_item)){
                $this->_role = $assign->auth_item;
            }
        }
        return $this->_role;
    }
    
    public function getLimitDate(){
        if($this->_limitDate===null){
            $sql = "select min(date) from request where mid=:mid and state=0";
            $this->_limitDate = Yii::app()->db->createCommand($sql)->queryScalar(array(":mid"=>$this->member->mid));
        }
        return $this->_limitDate;
    }
        

}

?>