<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    private $_member;
	public function authenticate()
	{
        $record = Member::model()->findByAttributes(array('name'=>$this->username));

		if($record === null) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
        }
		elseif($record->password!==Member::hashPassword($this->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
		else {
            $this->_member=$record;			
			$this->errorCode=self::ERROR_NONE;
            $record->saveAttributes(array('last_login_time'=>date('Y-m-d H:i:s'), 'login_times' => $record->login_times + 1));
            if($record->authAssignment->itemname=='TrialMember'){
                $client = Client::model()->find('name=:name', array(':name'=>$record->name));
                $clientlog = ClientLog::getClientLog($client->id, date("Y-m-d"), $client->sales_id);
                $clientlog->login_times += 1;
                if($record->login_times==1){
                    $clientlog->status = 4; #初次登陆
                    $probationTime = Yii::app()->params['probationTime'];
                    $expireTime = date('Y-m-d', strtotime("+$probationTime day"));
                    if($expireTime>$record->expire_time){
                    	$record->saveAttributes(array('expire_time'=>$expireTime));
                    }
                }
                else{
                    $sql = "select status from client_log where client_id=:id and date<curdate() order by date desc limit 1";
                    $lastStatus = Yii::app()->db->createCommand($sql)->queryScalar(array(":id"=>$client->id));
                    if($lastStatus){
                        $clientlog->status = $clientlog->status?$clientlog->status:$lastStatus;
                    }
                }
                $clientlog->save(false);
            }
        }
		return !$this->errorCode;
	}
    
    public function getId(){
		return $this->_member->mid;
	}
    
    public function getExpireTime (){
		return date('Y-m-d',strtotime($this->_member->expire_time));
	}
    
	public function getType(){
		return $this->_member->type;
	}
    
	public function test($member){
		return $this->_member = $member;
	}
    
}
