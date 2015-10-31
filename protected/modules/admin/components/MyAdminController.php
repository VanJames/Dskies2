<?php
/*
 * CMyController class file.
 * Extends CController and we can modify it for certain purpose
*/
class MyAdminController extends CController
{
    public $adminUser;
    public $inAjax;
    public $stash = array();
    
    public function init() {

    }
    
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
        );
    }
    
    //edit by Touya.overwrite beforeAction to force login
    protected function beforeAction($action)
    {
        $this->adminUser = $this->module->adminUser;
//        var_dump($this->adminUser);
        //need logout?
       if(isset($this->adminUser->logoutRequired) && $this->adminUser->logoutRequired){
            $this->adminUser->logout();
            $this->adminUser->setState('logoutRequired',false);
            $this->adminUser->loginRequired();
            return false;
        }
        
        //need login?
        $controller = $this->id;
#        if(!in_array($controller,array('site','mactm','kpiana','email','statistics')))
        if(!in_array($controller,array('site')))
        {
            if($this->adminUser->isGuest){
                if(Yii::app()->request->isAjaxRequest){
                    echo "登陆超时，请重新登陆！";
                    return false;
                }
                else{
                    $this->adminUser->loginRequired();
                    return false;
                }
            }
            //update member info:
            $ar_member = $this->adminUser->member;
            if(isset($ar_member)){
            }
            else{
                $this->adminUser->loginRequired();
                return false;
            }
        }

        $this->inAjax	= Yii::app()->request->isAjaxRequest;
        $this->setLog();
        return true;
    }
    
    public function setLog(){
        if($this->adminUser->isGuest){
            return;
        }

        $ip = Util::getIp();
        if(empty($ip)){
            $ip = "";
        }
        
        $mid = $this->adminUser->member->mid;
        $action = $this->route;
        if(empty($mid)){
            $mid = 0;
        }

        $request = serialize($_REQUEST);
        $sql = "insert admin_action_log (mid,ip,action,request,created) values (:mid,:ip,:action,:request,now())";
        Yii::app()->db->createCommand($sql)->execute(array(":mid"=>$mid,":ip"=>$ip,":action"=>$action,":request"=>$request));
    }

    public function renderError()
    {
        $this->render('/error');
        Yii::app()->end();
    }
    protected function renderAjax($message, $html = null, $params = array()) {
        if (!isset($params['ok'])) {
            $params['ok'] = $message == 'ok' || $message === '';
        } else {
            $params['ok'] = $params['ok'] == true;
        }
        $params['html'] = $html;
        if (!isset($params['msg']))
            $params['msg'] = $message;
        echo CJSON::encode($params);
        Yii::app()->end();
    }
    
}
