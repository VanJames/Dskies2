<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	public $verifyCode;
    
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// verifyCode needs to be entered correctly  
			array('verifyCode', 'captcha', 'allowEmpty'=>false),
			// username and password are required
			array('username, password', 'required'),
            array('rememberMe','safe'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            'username'  => '用户名',
            'password'  => '密码',
			'rememberMe'=> '保持登录状态',
			'verifyCode'=> '验证码',  
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->username,$this->password);
			$identity->authenticate();
            
			switch($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
                    $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                    Yii::app()->controller->adminUser->login($identity,$duration);
//                    $db = Yii::app()->db;
//                    $mid = Yii::app()->controller->adminUser->id;
//                    $db->createCommand("insert member_login (mid,ip,sessionid,try_password) values (:mid,:ip,:sessionid,:try_password)")->execute(array(":mid"=>$mid,":ip"=>Yii::app()->request->userHostAddress,":sessionid"=>Yii::app()->session->sessionID,":try_password"=>$this->password));
                    
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username','用户名或密码输入有误!');
					break;
				default: // UserIdentity::ERROR_PASSWORD_INVALID
					$this->addError('password','用户名或密码输入有误!');
					break;
			}
		}
	}
    
}
