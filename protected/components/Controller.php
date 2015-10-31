<?php

class Controller extends CController {

    public $layout;
    public $menu = array();
    public $breadcrumbs = array();
    public $ctrlId;
    public $actionId;
    public $homeLink;
    public $activeNav;
    protected $isAjax;
    protected $introId;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'controllers' => array('site'),
                'users' => array('*'),
            ),
            array('allow',
                'controllers' => array('stat'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("StatController")',
            ),
            array('allow',
                'controllers' => array('shop'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("ShopController")',
            ),
            array('allow',
                'controllers' => array('marketing'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("MarketingController")',
            ),
            array('allow',
                'controllers' => array('hit'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("HitController")',
            ),
            array('allow',
                'controllers' => array('brand'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("BrandController")',
            ),
            array('allow',
                'controllers' => array('search'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("SearchController")',
            ),
            array('allow',
                'controllers' => array('seo'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("SeoController")',
            ),
            array('allow',
                'controllers' => array('member'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("ServicePackSuperAdmin")',
            ),
            array('allow',
                'controllers' => array('item'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("ItemController")',
            ),
            array('allow',
                'controllers' => array('personal'),
                'users' => array('@'),
                'expression' => '!$user->isGuest && $user->checkAccess("PersonalController")',
            ),
			array('allow',
                'controllers' => array('word'),
                'users' => array('@'),
                'expression' => '!$user->isGuest ',
            ),
            array('allow',
                'controllers' => array('news'),
                'users' => array('@'),
                'expression' => '!$user->isGuest',
            ),
            array('allow',
                'controllers' => array('edc'),
                'users' => array('@'),
                'expression' => '!$user->isGuest',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    protected function beforeAction($action) {
        Yii::app()->clientScript->registerCoreScript('jquery');
        $this->ctrlId = Yii::app()->controller->id;
        $this->actionId = Yii::app()->controller->action->id;
        $this->isAjax = Yii::app()->request->isAjaxRequest;
        if (!in_array($this->ctrlId, array('personal', 'site'))) {
            if(Yii::app()->user->member->expire_time < date('Y-m-d')){
                $this->renderError(Util::t('memberExpire'));
                return false;
            }
            $sql = "select min(date) from request where mid=:mid and state=0";
            $limitDate = Yii::app()->db->createCommand($sql)->queryScalar(array(":mid"=>Yii::app()->user->member->mid));
            if(Yii::app()->user->limitDate && Yii::app()->user->limitDate<date('Y-m-d', strtotime("-7 day"))){
                $this->renderError(Util::t('memberExpire'));
                return false;
            }
        }
        
        switch ($this->ctrlId) {
            case 'stat':
                $this->homeLink = Util::t('nav_stat');
                break;
            case 'shop':
                $this->homeLink = Util::t('nav_shop');
                break;
            case 'item':
                $this->homeLink = Util::t('nav_item');
                break;
            case 'marketing':
                $this->homeLink = Util::t('nav_marketing');
                break;
            case 'hit':
                $this->homeLink = Util::t('nav_hit');
                break;
            case 'brand':
                $this->homeLink = Util::t('nav_brand');
                break;
            case 'search':
                $this->homeLink = Util::t('nav_search');
                break;
            case 'seo':
                $this->homeLink = Util::t('nav_seo');
                break;
            case 'personal':
                $this->homeLink = Util::t('nav_personal');
                break;
            case 'news':
                $this->homeLink = Util::t('nav_news');
                break;
            case 'edc':
                $this->homeLink = Util::t('nav_edc');
                break;
        }
        $this->setLog();
        return true;
    }

    public function setLog(){
        if(Yii::app()->user->isGuest){
            return;
        }

        $ip = Util::getIp();
        if(empty($ip)){
            $ip = "";
        }

        $mid = Yii::app()->user->getState('rakuten_sales_mid');
        $action = $this->route;
        if(empty($mid)){
            $mid = 0;
        }

        $request = serialize($_REQUEST);
        $sql = "insert action_log (operator,mid,ip,action,request,created) values (:mid,:name,:ip,:action,:request,now())";
        Yii::app()->db->createCommand($sql)->execute(array(":mid"=>$mid,":name"=>Yii::app()->user->member->mid,":ip"=>$ip,":action"=>$action,":request"=>$request));

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

    protected function renderError($message = '') {
        $this->render('/error', array('message' => $message));
        Yii::app()->end();
    }
    
    protected function setIntroId($introId) {
        $this->introId = $introId;
    }
    
    protected function getIntroId() {
        return $this->introId;
    }

}