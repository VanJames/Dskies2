<?php

class SiteController extends MyAdminController
{
    public $defaultAction = 'index';

    public function actions()  
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page  
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xf4f4f4,
                'testLimit'=>1,
            ),
        );
    }



    public function actionIndex(){
        if(!$this->adminUser->isGuest){
            $this->redirect($this->createUrl('client/list'));
        }

        $form=new LoginForm;
        if(isset($_POST['LoginForm']))
        {
            $form->attributes=$_POST['LoginForm'];
            // validate user input and redirect to previous page if valid
            if($form->validate()){
                $this->redirect($this->createUrl('client/list'));
            }
        }
        // $this->layout='cool';
        $this->renderPartial('index',array('form'=>$form,'nick_name'=>'test'));
	}


    public function actionLogout(){
        $tmp = $this->adminUser->returnUrl;
        $this->adminUser->logout();
        $this->adminUser->returnUrl = $tmp;

        $this->redirect($this->createUrl('site/index'));
    }

    public function actionTest(){
        echo "aaa";
    }
    
}
