<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

//class UserIdentity extends CUserIdentity
//{
//	/**
//	 * Authenticates a user.
//	 * The example implementation makes sure if the username and password
//	 * are both 'demo'.
//	 * In practical applications, this should be changed to authenticate
//	 * against some persistent user identity storage (e.g. database).
//	 * @return boolean whether authentication succeeds.
//	 */
//	public function authenticate()
//	{
//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		else if($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
//	}
//}

class UserIdentity extends CUserIdentity
{
    private $_id;
    const ERROR_USER_DELETED = 11;
    public function authenticate($is_admin=null)
    {
        $record = Member::model()->findByAttributes(array('name'=>$this->username, 'status'=>1));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->del_flag)
            $this->errorCode=self::ERROR_USER_DELETED;
        else if(empty($record->password) or $record->password!=Member::hashPassword($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
 //           $this->setState('admin_last_login_time', $record->last_login_time);
            $this->_id = $record->mid;
            $this->errorCode=self::ERROR_NONE;
//            if(!isset($is_admin) || !$is_admin){
//                $record->saveAttributes(array('last_login_time'=>date('Y-m-d H:i:s'),'login_times' => $record->login_times + 1));
//            }
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    public function setId($id)
    {
        return $this->_id = $id;
    }
}